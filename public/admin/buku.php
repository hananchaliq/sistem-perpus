<?php
session_start();

require_once '../../system/config.php';
include '../../system/layout/header.php';
include '../../system/layout/sidebar.php';


$stmt = $pdo->prepare("select * from buku");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>
<!-- Main Content -->
<div id="content">

   <?php include '../../system/layout/topbar.php'; ?>

   <!-- Begin Page Content -->
   <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">Daftar Buku</h1>
      <p class="mb-4">Tabel buku berfungsi untuk menyimpan seluruh data koleksi perpustakaan, seperti kode buku, judul buku, pengarang, penerbit, tahun terbit, kategori, serta jumlah stok buku yang tersedia. Data pada tabel ini menjadi dasar utama dalam proses pengelolaan dan pencarian buku di perpustakaan.</p>
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
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Halaman</th>
                        <th>Stok</th>
                        <th>Tahun Terbit</th>
                        <th>Kategori</th>
                     </tr>
                  </thead>
                  <?php foreach ($data as $s)
                     echo "<tr><td>" . $s['id_buku'] . "</td><td>" . $s['nama_buku'] . "</td><td>" . $s['penulis'] . "</td><td>" . $s['penerbit'] . "</td><td>" . $s['jumlah_halaman'] . "</td><td>" . $s['jumlah_stok'] . "</td><td>" . $s['tahun_terbit'] . "</td><td>" . $s['kategori'] . "</td></tr>"; ?>
                  <tfoot>
                     <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Penulis</th>
                        <th>Penerbit</th>
                        <th>Halaman</th>
                        <th>Stok</th>
                        <th>Tahun Terbit</th>
                        <th>Kategori</th>
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