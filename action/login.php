<?php

require_once '../system/config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $email = trim($_POST['email']);
   $password = trim($_POST['password']);

   // cek apakah email ada di database
   $stmt = $pdo->prepare("SELECT id_user, username, password, level FROM user WHERE email = ? LIMIT 1");
   $stmt->bindParam(1, $email);
   $stmt->execute();
   $result = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($result) {
      $row = $result;

      // verifikasi password hash
      if (password_verify($password, $row['password'])) {
         $_SESSION['admin_id'] = $row['id_user'];
         $_SESSION['admin_name'] = $row['username'];
         $_SESSION['role'] = $row['level'];

         $_SESSION['success'] = "Login berhasil, selamat datang " . $row['username'];
         header("Location:" . $base . "public/login.php");
         exit;
      } else {
         // password salah
         $_SESSION['error'] = "Password salah";
         header("Location:" . $base . "public/login.php");
         exit;

      }

   } else {
      // email tidak ditemukan
      $_SESSION['error'] = "Email tidak ditemukan";
      header("Location:" . $base . "public/login.php");
      exit;

   }
} else {
   header("Location:" . $base . "public/login.php");
   exit;
}


?>