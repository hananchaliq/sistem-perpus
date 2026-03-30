<?php

session_start();
require_once '../../system/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $email = trim($_POST['email']);
   $password = trim($_POST['password']);

   // cek apakah email ada di database
   $stmt = $pdo->prepare("SELECT id_user, username, password, level FROM users WHERE email = ? LIMIT 1");
   $stmt->bindParam(1, $email);
   $stmt->execute(); 
   $result = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($result) {
      $row = $result;

      // verifikasi password hash
      if (password_verify($password, $row['password'])) {
         $_SESSION['admin_id'] = $row['id_user'];
         $_SESSION['username'] = $row['username'];
         $_SESSION['role'] = $row['level'];

         $_SESSION['success'] = "Selamat datang, Anda login sebagai " . $row['username'];
         header("Location:" . $base . "public/login.php");
         exit;
      } else {
         // password salah
         $_SESSION['error'] = "Password yang anda masukkan salah";
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