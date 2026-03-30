<?php
session_start();
require_once '../../../system/config.php';

// proteksi
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
   header("Location: ../../../public/admin/dashboard.php");
   exit;
}

// ambil data
$id_petugas = $_POST['id_petugas'];
$username = trim($_POST['username']);
$email = trim($_POST['email']);
$no_hp = trim($_POST['no_hp']);
$gender = trim($_POST['gender']);
$alamat = trim($_POST['alamat']);
$password = $_POST['password'];

// validasi simpel
if (
   empty($id_petugas) || empty($username) || empty($email) ||
   empty($no_hp) || empty($gender) || empty($alamat)
) {
   $_SESSION['error'] = "Data tidak boleh kosong!";
   header("Location:../../../public/admin/petugas.php");
   exit;
}

try {

   // ambil id_user dari petugas
   $stmt = $pdo->prepare("SELECT id_user FROM petugas WHERE id_petugas = ?");
   $stmt->execute([$id_petugas]);
   $petugas = $stmt->fetch();

   if (!$petugas) {
      throw new Exception("Data petugas tidak ditemukan");
   }

   $id_user = $petugas['id_user'];

   // update table petugas
   $stmt = $pdo->prepare("
      UPDATE petugas SET
         nama_petugas = ?,
         no_hp = ?,
         gender = ?,
         alamat = ?
      WHERE id_petugas = ?
   ");
   $stmt->execute([$username, $no_hp, $gender, $alamat, $id_petugas]);

   // update table users
   if (!empty($password)) {
      // kalau password diisi
      $hash = password_hash($password, PASSWORD_DEFAULT);

      $stmt = $pdo->prepare("
         UPDATE users SET
            username = ?,
            email = ?,
            password = ?
         WHERE id_user = ?
      ");
      $stmt->execute([strtolower($username), $email, $hash, $id_user]);

   } else {
      // kalau password kosong
      $stmt = $pdo->prepare("
         UPDATE users SET
            username = ?,
            email = ?
         WHERE id_user = ?
      ");
      $stmt->execute([strtolower($username), $email, $id_user]);
   }

   $_SESSION['success'] = "Data petugas berhasil diupdate ✔️";

} catch (Exception $e) {
   $_SESSION['error'] = "Gagal update data ❌";
}

// balik ke halaman utama
header("Location:../../../public/admin/petugas.php");
exit;
