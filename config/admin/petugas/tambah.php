<?php
session_start();
require_once '../../../system/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   try {
      $pdo->beginTransaction();

      $username = trim($_POST['username']);
      $email = trim($_POST['email']);
      $no_hp = trim($_POST['no_hp']);
      $gender = trim($_POST['gender']); // Pria / Wanita
      $alamat = trim($_POST['alamat']);
      $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
      $level = 'petugas';

      // cek duplicate
      $cek = $pdo->prepare(
         "SELECT id_user
             FROM users
             WHERE username = ? OR email = ?
             LIMIT 1"
      );
      $cek->execute([$username, $email]);

      if ($cek->rowCount() > 0) {
         $_SESSION['error'] = "Username atau email sudah terdaftar";
         header("Location: " . $base . "public/admin/petugas.php");
         exit;
      }

      // insert users
      $stmt = $pdo->prepare( 
         "INSERT INTO users (username, email, password, level)
             VALUES (?, ?, ?, ?)"
      );
      $stmt->execute([strtolower($username), $email, $password, $level]);

      $id_user = $pdo->lastInsertId();

      // insert petugas
      $stmt = $pdo->prepare(
         "INSERT INTO petugas (id_user, nama_petugas, no_hp, gender, alamat)
             VALUES (?, ?, ?, ?, ?)"
      );
      $stmt->execute([$id_user, $username, $no_hp, $gender, $alamat]);

      $pdo->commit();

      $_SESSION['success'] = "Data Petugas berhasil ditambahkan";
      header("Location: " . $base . "public/admin/petugas.php");
      exit;

   } catch (PDOException $e) {
      $pdo->rollBack();
      die("ERROR DB: " . $e->getMessage());
   }

}
