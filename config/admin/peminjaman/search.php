<?php
require_once '../../../system/config.php';

$keyword = $_GET['keyword'] ?? '';

$stmt = $pdo->prepare("
   SELECT
      nisn        AS nisn,
      nama_siswa AS nama,
      kelas      AS kelas
   FROM siswa
   WHERE nisn LIKE ? OR nama_siswa LIKE ?
   LIMIT 10
");

$stmt->execute([
   "%$keyword%",
   "%$keyword%"
]);

header('Content-Type: application/json');
echo json_encode($stmt->fetchAll());
