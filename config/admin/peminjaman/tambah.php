<?php
session_start();
require_once '../../../system/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $pdo->beginTransaction();
        $stmtS = $pdo->prepare("SELECT id_siswa FROM siswa WHERE nisn = ?");
        $stmtS->execute([$_POST['nisn']]);
        $siswa = $stmtS->fetch();

        if(!$siswa) throw new Exception("Siswa tidak ditemukan!");

        $sql = "INSERT INTO peminjaman (id_siswa, id_buku, tanggal_peminjaman, tanggal_pengembalian, status, id_petugas) VALUES (?,?,?,?,?,?)";
        $pdo->prepare($sql)->execute([$siswa['id_siswa'], $_POST['id_buku'], $_POST['tgl_pinjam'], $_POST['tgl_kembali'], $_POST['status'], $_POST['id_petugas']]);

        $pdo->prepare("UPDATE buku SET jumlah_stok = jumlah_stok - 1 WHERE id_buku = ?")->execute([$_POST['id_buku']]);
        
        $pdo->commit();
        $_SESSION['success'] = "Data Peminjaman Berhasil!";
    } catch (Exception $e) {
        $pdo->rollBack();
        $_SESSION['error'] = $e->getMessage();
    }
}
header("Location: ../../../public/admin/peminjaman.php");

// 1. Ambil data dari POST
$nisn        = $_POST['nisn'] ?? '';
$id_buku     = $_POST['id_buku'] ?? '';
$tgl_pinjam  = $_POST['tgl_pinjam'] ?? '';
$tgl_kembali = $_POST['tgl_kembali'] ?? '';
$id_petugas  = $_POST['id_petugas'] ?? '';
$status      = $_POST['status'] ?? 'Dipinjam';

// 2. Validasi input
if (empty($nisn) || empty($id_buku) || empty($tgl_pinjam) || empty($tgl_kembali) || empty($id_petugas)) {
    $_SESSION['error'] = "Gagal: Data formulir tidak lengkap!";
    header("Location:../../../public/admin/peminjaman.php");
    exit;
}

try {
    $pdo->beginTransaction();

    // 3. Cari id_siswa berdasarkan NISN
    $stmtSiswa = $pdo->prepare("SELECT id_siswa FROM siswa WHERE nisn = ?");
    $stmtSiswa->execute([$nisn]);
    $siswa = $stmtSiswa->fetch();

    if (!$siswa) {
        throw new Exception("Siswa dengan NISN $nisn tidak ditemukan.");
    }

    $id_siswa_fix = $siswa['id_siswa'];

    // 4. Cek apakah stok buku masih ada (pakai kolom jumlah_stok)
    $stmtCekBuku = $pdo->prepare("SELECT jumlah_stok FROM buku WHERE id_buku = ?");
    $stmtCekBuku->execute([$id_buku]);
    $buku = $stmtCekBuku->fetch();

    if (!$buku || $buku['jumlah_stok'] <= 0) {
        throw new Exception("Stok buku habis, tidak bisa melakukan peminjaman.");
    }

    // 5. INSERT ke tabel peminjaman
    $sql = "INSERT INTO peminjaman 
            (id_siswa, id_buku, tanggal_peminjaman, tanggal_pengembalian, status, id_petugas) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $id_siswa_fix,
        $id_buku,
        $tgl_pinjam,
        $tgl_kembali,
        $status,
        $id_petugas
    ]);

    // 6. UPDATE stok buku (menggunakan nama kolom jumlah_stok)
    $updateStok = $pdo->prepare("UPDATE buku SET jumlah_stok = jumlah_stok - 1 WHERE id_buku = ?");
    $updateStok->execute([$id_buku]);

    $pdo->commit();
    $_SESSION['success'] = "Peminjaman berhasil ditambahkan! ✔️";

} catch (Exception $e) {
    if ($pdo->inTransaction()) { $pdo->rollBack(); }
    $_SESSION['error'] = "Gagal: " . $e->getMessage();
}

header("Location:../../../public/admin/peminjaman.php");
exit;