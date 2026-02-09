<?php
session_start();
require_once __DIR__ . '/../system/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   $name = trim($_POST['name']);
   $username = trim($_POST['username']);
   $email = trim($_POST['email']);
   $pass1 = $_POST['password'];
   $pass2 = $_POST['password2'];

   // cek password sama atau tidak
   if ($pass1 !== $pass2) {
      header("Location: " . $base . "public/register.php?status=pass_error");
      exit;
   }

   // cek username atau email sudah terdaftar atau belum
   $cek = $pdo->prepare(
      "SELECT id_user 
       FROM user 
       WHERE (username = ? OR email = ?)
       AND level = 'peminjam'
       LIMIT 1"
   );
   $cek->execute([$username, $email]);

   if ($cek->rowCount() > 0) {
      header("Location: " . $base . "public/register.php?status=duplicate");
      exit;
   }

   // hash password
   $password = password_hash($pass1, PASSWORD_DEFAULT);

   // user cuma bisa register sebagai user
   $level = 'peminjam';

   // simpan ke database
   $stmt = $pdo->prepare(
      "INSERT INTO user (nama, username, email, password, level)
       VALUES (?, ?, ?, ?, ?)"
   );
   $stmt->execute([$name, $username, $email, $password, $level]);

   header("Location: " . $base . "public/register.php?status=success");
   exit;
}
?>