<?php
session_start();

require_once '../../system/config.php';
include '../../system/layout/header.php';
include '../../system/layout/sidebar.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
   header("Location: ../login.php");
   exit;
}

$stmt = $pdo->prepare("select d.*, p.status, s.nama_siswa from denda d join peminjaman p on d.id_peminjaman = p.id_peminjaman join siswa s on p.id_siswa = s.id_siswa");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!-- Main Content -->
<div id="content">

   <?php include '../../system/layout/topbar.php'; ?>

   <!-- Begin Page Content -->
   <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">Daftar Denda</h1>
      <p class="mb-4">Tabel denda berfungsi untuk mencatat biaya atau sanksi yang dikenakan kepada peminjam apabila terjadi keterlambatan pengembalian buku atau pelanggaran aturan peminjaman. Dengan adanya tabel ini, pengelolaan denda dapat dilakukan secara tertib, transparan, dan terintegrasi dengan data peminjaman.</p>
      <p class="mb-4">DataTables adalah plugin pihak ketiga yang digunakan untuk menghasilkan tabel demo di bawah ini. Untuk informasi lebih lanjut tentang DataTables, silakan kunjungi <a target="_blank"
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
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Denda</th>
                        <th>Nominal</th>
                        <th>Status Denda</th>
                        <th>Status Pengembalian</th>
                        <th>Keterangan</th>
                     </tr>
                  </thead>
                  <?php foreach ($data as $s)
                     echo "<tr><td>" . $s['id_denda'] . "</td><td>" . $s['nama_siswa'] . "</td><td>" . $s['nama_denda'] . "</td><td>" . $s['nominal_denda'] . "</td><td>" . $s['status_denda'] . "</td><td>" . $s['status'] . "</td><td>" . $s['keterangan_denda'] . "</td></tr>"; ?>
                  <tfoot>
                     <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Denda</th>
                        <th>Nominal</th>
                        <th>Status Denda</th>
                        <th>Status Pengembalian</th>
                        <th>Keterangan</th>
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