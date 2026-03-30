<?php
session_start();
require_once '../../../system/config.php';

// Pastikan ada ID yang dikirim lewat URL
if (!isset($_GET['id'])) {
    header("Location: ../../../public/admin/peminjaman.php");
    exit;
}

$id = $_GET['id'];

try {
    $pdo->beginTransaction();

    // 1. Ambil info status dan id_buku sebelum dihapus
    $stmtCek = $pdo->prepare("SELECT status, id_buku FROM peminjaman WHERE id_peminjaman = ?");
    $stmtCek->execute([$id]);
    $peminjaman = $stmtCek->fetch();

    if (!$peminjaman) {
        throw new Exception("Data tidak ditemukan!");
    }

    // 2. Jika statusnya masih 'Dipinjam', kembalikan stok buku +1
    if ($peminjaman['status'] == 'Dipinjam') {
        $updateStok = $pdo->prepare("UPDATE buku SET jumlah_stok = jumlah_stok + 1 WHERE id_buku = ?");
        $updateStok->execute([$peminjaman['id_buku']]);
    }

    // 3. Hapus data peminjaman
    $stmtHapus = $pdo->prepare("DELETE FROM peminjaman WHERE id_peminjaman = ?");
    $stmtHapus->execute([$id]);

    $pdo->commit();
    $_SESSION['success'] = "Data peminjaman berhasil dihapus! 🗑️";

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['error'] = "Gagal menghapus: " . $e->getMessage();
}

header("Location: ../../../public/admin/peminjaman.php");
exit;