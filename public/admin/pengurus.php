<?php
session_start();

require_once '../../system/config.php';
include '../../system/layout/header.php';
include '../../system/layout/sidebar.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
   header("Location: ../login.php");
   exit;
}

$stmt = $pdo->prepare("select * from pengurus");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>


<!-- Main Content -->
<div id="content">

   <?php include '../../system/layout/topbar.php'; ?>

   <!-- Begin Page Content -->
   <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">Daftar Pengurus</h1>
      <p class="mb-4">Tabel pengurus digunakan untuk menyimpan data petugas perpustakaan yang memiliki hak akses dalam sistem. Data yang disimpan meliputi identitas pengurus, username, dan peran atau hak akses, sehingga setiap proses pengelolaan data buku, peminjaman, dan denda dapat dipertanggungjawabkan.</p>
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
                        <th>Gender</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email</th>
                     </tr>
                  </thead>
                  <?php foreach ($data as $s)
                     echo "<tr><td>" . $s['id_pengurus'] . "</td><td>" . $s['nama_pengurus'] . "</td><td>" . $s['jenis_kelamin'] . "</td><td>" . $s['username'] . "</td><td>" . $s['password'] . "</td><td>" . $s['email'] . "</td></tr>"; ?>
                  <tfoot>
                     <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Gender</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Email</th>
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