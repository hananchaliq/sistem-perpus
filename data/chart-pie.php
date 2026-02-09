<?php
require_once '../system/config.php';

$data = [
  'pinjaman' => $pdo->query("SELECT COUNT(*) FROM peminjaman")->fetchColumn(),
  'buku'     => $pdo->query("SELECT COUNT(*) FROM buku")->fetchColumn(),
  'denda'    => $pdo->query("SELECT COUNT(*) FROM denda")->fetchColumn()
];

echo json_encode($data);