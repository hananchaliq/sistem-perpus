<?php
session_start();
require_once '../../../system/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   try {
      $pdo->beginTransaction();
      $id = $_POST['id_peminjaman'];
      $status_baru = $_POST['status'];

      $old = $pdo->prepare("SELECT status, id_buku FROM peminjaman WHERE id_peminjaman = ?");
      $old->execute([$id]);
      $oldData = $old->fetch();

      $pdo->prepare("UPDATE peminjaman SET tanggal_pengembalian = ?, status = ? WHERE id_peminjaman = ?")
         ->execute([$_POST['tanggal_pengembalian'], $status_baru, $id]);

      if ($oldData['status'] == 'Dipinjam' && $status_baru == 'Dikembalikan') {
         $pdo->prepare("UPDATE buku SET jumlah_stok = jumlah_stok + 1 WHERE id_buku = ?")->execute([$oldData['id_buku']]);
      }

      $pdo->commit();
      $_SESSION['success'] = "Data Berhasil di-Update!";
   } catch (Exception $e) {
      $pdo->rollBack();
      $_SESSION['error'] = $e->getMessage();
   }
}
header("Location: ../../../public/admin/peminjaman.php");

// 1. Ambil data dari form modal edit
$id_peminjaman = $_POST['id_peminjaman'] ?? '';
$tgl_kembali_asli = $_POST['tanggal_pengembalian'] ?? ''; // Tanggal input user
$status_baru = $_POST['status'] ?? '';

if (empty($id_peminjaman) || empty($tgl_kembali_asli) || empty($status_baru)) {
   $_SESSION['error'] = "Data pembaruan tidak lengkap!";
   header("Location:../../../public/admin/peminjaman.php");
   exit;
}

try {
   $pdo->beginTransaction();

   // 2. Ambil data lama untuk validasi tanggal & stok
   $stmtCek = $pdo->prepare("SELECT tanggal_peminjaman, id_buku, status FROM peminjaman WHERE id_peminjaman = ?");
   $stmtCek->execute([$id_peminjaman]);
   $dataLama = $stmtCek->fetch();

   if (!$dataLama) {
      throw new Exception("Data peminjaman tidak ditemukan.");
   }

   // --- VALIDASI LOGIKA TANGGAL ---
   // Pastikan tanggal kembali tidak lebih kecil dari tanggal pinjam
   if (strtotime($tgl_kembali_asli) < strtotime($dataLama['tanggal_peminjaman'])) {
      throw new Exception("Tanggal kembali tidak boleh mendahului tanggal pinjam (" . $dataLama['tanggal_peminjaman'] . ")");
   }

   // 3. Update data peminjaman
   $sqlEdit = "UPDATE peminjaman SET 
                tanggal_pengembalian = ?, 
                status = ? 
                WHERE id_peminjaman = ?";
   $stmtEdit = $pdo->prepare($sqlEdit);
   $stmtEdit->execute([$tgl_kembali_asli, $status_baru, $id_peminjaman]);

   // 4. LOGIKA PENGEMBALIAN STOK
   // Jika status berubah dari 'Dipinjam' menjadi 'Dikembalikan', stok buku harus bertambah +1
   if ($dataLama['status'] === 'Dipinjam' && $status_baru === 'Dikembalikan') {
      $updateStok = $pdo->prepare("UPDATE buku SET jumlah_stok = jumlah_stok + 1 WHERE id_buku = ?");
      $updateStok->execute([$dataLama['id_buku']]);
   }
   // Jika status diubah balik dari 'Dikembalikan' ke 'Dipinjam' (karena salah input), stok dikurangi lagi -1
   else if ($dataLama['status'] === 'Dikembalikan' && $status_baru === 'Dipinjam') {
      $updateStok = $pdo->prepare("UPDATE buku SET jumlah_stok = jumlah_stok - 1 WHERE id_buku = ?");
      $updateStok->execute([$dataLama['id_buku']]);
   }

   $pdo->commit();
   $_SESSION['success'] = "Data berhasil diperbarui! ✔️";

} catch (Exception $e) {
   if ($pdo->inTransaction()) {
      $pdo->rollBack();
   }
   $_SESSION['error'] = "Gagal Update: " . $e->getMessage();
}

header("Location:../../../public/admin/peminjaman.php");
exit;

?>