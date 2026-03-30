<?php
$host = 'localhost';
$db = 'nan_tugas_perpus';
$user = 'sistem_perpus';
$pass = 'perpus_123';
$charset = 'utf8mb4';
$base = '/project-sistem-perpus/';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
   $pdo = new PDO($dsn, $user, $pass);
} catch (Exception $e) {
   echo 'DB Connection failed: ' . $e->getMessage();
   exit;
}
?>