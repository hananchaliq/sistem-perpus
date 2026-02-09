<?php
session_start();

require_once '../../system/config.php';
include '../../system/layout/header.php';
include '../../system/layout/sidebar.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
   header("Location: ../login.php");
   exit;
}

$sql = "
    SELECT 
        p.*,
        s.nisn,
        s.nama_siswa,
        s.kelas,
        b.nama_buku,
        pa.nama_pengurus
    FROM peminjaman p
    JOIN siswa s ON s.id_siswa = p.id_siswa
    JOIN buku b  ON b.id_buku  = p.id_buku
    JOIN pengurus pa ON pa.id_pengurus = p.id_pengurus
";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<!-- Main Content -->
<div id="content">

   <?php include '../../system/layout/topbar.php'; ?>

   <!-- Begin Page Content -->
   <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">Daftar Peminjaman</h1>
      <p class="mb-4">Tabel peminjaman digunakan untuk mencatat seluruh aktivitas peminjaman buku oleh anggota
         perpustakaan. Tabel ini berisi informasi seperti kode peminjaman, data anggota, data buku yang dipinjam,
         tanggal peminjaman, tanggal pengembalian, serta status peminjaman untuk memantau apakah buku sudah dikembalikan
         atau belum.</p>
      <p class="mb-4">DataTables adalah plugin pihak ketiga yang digunakan untuk menghasilkan tabel demo di bawah ini.
         Untuk informasi lebih lanjut tentang DataTables, silakan kunjungi <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
         <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <th>Nisn</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Buku</th>
                        <th>Peminjaman</th>
                        <th>Pengembalian</th>
                        <th>Status</th>
                        <th>Pengurus</th>
                     </tr>
                  </thead>
                  <?php foreach ($data as $s)
                     echo "<tr><td>" . $s['nisn'] . "</td><td>" . $s['nama_siswa'] . "</td><td>" . $s['kelas'] . "</td><td>" . $s['nama_buku'] . "</td><td>" . $s['tanggal_peminjaman'] . "</td><td>" . $s['tanggal_pengembalian'] . "</td><td>" . $s['status'] . "</td><td>" . $s['nama_pengurus'] . "</td></tr>"; ?>
                  <tfoot>
                     <tr>
                        <th>Nisn</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Buku</th>
                        <th>Peminjaman</th>
                        <th>Pengembalian</th>
                        <th>Status</th>
                        <th>Pengurus</th>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>

   </div>
   <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
<?php include '../../system/layout/footer.php'; ?>