<?php
require_once '../../../system/config.php';

if (!isset($_POST['id_petugas'])) {
   echo "ID tidak ditemukan";
   exit;
}

$id_petugas = $_POST['id_petugas'];

/* ambil id_user dari petugas */
$stmt = $pdo->prepare("SELECT id_user FROM petugas WHERE id_petugas = ?");
$stmt->execute([$id_petugas]);
$data = $stmt->fetch();

if (!$data) {
   echo "Data petugas tidak ditemukan";
   exit;
}

$id_user = $data['id_user'];

try {
   $pdo->beginTransaction();

   // hapus petugas dulu
   $stmt = $pdo->prepare("DELETE FROM petugas WHERE id_petugas = ?");
   $stmt->execute([$id_petugas]);

   // lalu hapus user
   $stmt = $pdo->prepare("DELETE FROM users WHERE id_user = ?");
   $stmt->execute([$id_user]);

   $pdo->commit();
   echo "success";

} catch (PDOException $e) {
   echo 'Data Petugas ini ada riwayat Peminjaman,</br> Tidak bisa di hapus.';
}

