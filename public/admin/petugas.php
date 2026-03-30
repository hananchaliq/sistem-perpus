<?php
session_start();

require_once '../../system/config.php';
include '../../system/layout/header.php';
include '../../system/layout/sidebar.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
   header("Location: ../login.php");
   exit;
}

$stmt = $pdo->prepare("select p.*, u.username, u.email  from petugas p left join users u on p.id_user = u.id_user");
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$n = 1;

?>


<!-- Main Content -->
<div id="content">

   <?php include '../../system/layout/topbar.php'; ?>

   <!-- Begin Page Content -->
   <div class="container-fluid">

      <!-- Page Heading -->
      <h1 class="h3 mb-2 text-gray-800">Daftar petugas</h1>
      <p class="mb-4">Tabel petugas digunakan untuk menyimpan data petugas perpustakaan yang memiliki hak akses dalam
         sistem. Data yang disimpan meliputi identitas petugas, username, dan peran atau hak akses, sehingga setiap
         proses pengelolaan data buku, peminjaman, dan denda dapat dipertanggungjawabkan.</p>
      <p class="mb-4">DataTables adalah plugin pihak ketiga yang digunakan untuk menghasilkan tabel demo di bawah ini.
         Untuk informasi lebih lanjut tentang DataTables, silakan kunjungi <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

      <!-- DataTales Example -->
      <div class="card shadow mb-4">
         <div class="card-header flex justify-between items-center py-3">
            <h6 class="m-0 font-weight-bold text-primary py-3">DataTables Example</h6>
            <div class="flex">
               <button class="btn btn-success btn-icon-split" data-bs-toggle="modal" data-bs-target="#modalTambah">
                  <span class="icon text-white-50">
                     <i class="fas fa-plus"></i>
                  </span>
                  <span class="text"> Tambah</span>
               </button>

               <!-- Modal Tambah Petugas -->
               <div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel"
                  aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered">
                     <div class="modal-content">

                        <div class="modal-header">
                           <h5 class="modal-title" id="modalTambahLabel">Tambah Petugas</h5>
                           <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <form action="../../config/admin/petugas/tambah.php" method="POST">
                           <div class="modal-body">

                              <input type="text" name="username" class="form-control mb-2" placeholder="Username"
                                 required autofocus>

                              <input type="password" name="password" class="form-control mb-2" placeholder="Password"
                                 required>

                              <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

                              <input type="text" name="no_hp" class="form-control mb-2" placeholder="No HP" required>

                              <textarea name="alamat" class="form-control mb-2" placeholder="Alamat" rows="2"
                                 required></textarea>

                              <select name="gender" class="form-select mb-2 p-2 px-1 border rounded-lg" required>
                                 <option value="" disabled selected>Pilih Gender</option>
                                 <option value="Pria">Pria</option>
                                 <option value="Wanita">Wanita</option>
                              </select>

                           </div>

                           <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                              <button type="submit" class="btn btn-primary">Simpan</button>
                           </div>
                        </form>

                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                     <tr id="row-<?= $s['id_petugas'] ?>">
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Gender</th>
                        <th>Username</th>
                        <th class="text-center">Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($data as $s): ?>
                        <tr id="row-<?= $s['id_petugas'] ?>">
                           <td><?= $n++ ?></td>
                           <td><?= $s['nama_petugas'] ?></td>
                           <td><?= $s['alamat'] ?></td>
                           <td><?= $s['email'] ?></td>
                           <td><?= $s['no_hp'] ?></td>
                           <td><?= $s['gender'] ?></td>
                           <td><?= $s['username'] ?></td>
                           <td class="text-center flex justify-evenly items-center">
                              <button class="btn btn-danger btn-sm btn-hapus" data-id="<?= $s['id_petugas'] ?>">
                                 <span class="icon">
                                    <i class="fas fa-trash"></i>
                                 </span>
                              </button>
                              <div class="">
                                 <button class="btn btn-warning btn-sm btn-edit" data-bs-toggle="modal"
                                    data-bs-target="#modalEdit" data-id="<?= $s['id_petugas'] ?>"
                                    data-username="<?= $s['username'] ?>" data-email="<?= $s['email'] ?>"
                                    data-no-hp="<?= $s['no_hp'] ?>" data-gender="<?= $s['gender'] ?>"
                                    data-alamat="<?= $s['alamat'] ?>">
                                    <span class="icon">
                                       <i class="fas fa-pen"></i>
                                    </span>
                                 </button>
                                 <div class="">
                                    <div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel"
                                       aria-hidden="true">
                                       <div class="modal-dialog modal-dialog-centered">
                                          <div class="modal-content">

                                             <div class="modal-header">
                                                <h5 class="modal-title" id="modalEditLabel">Edit Petugas</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                             </div>

                                             <form action="../../config/admin/petugas/edit.php" method="POST">
                                                <div class="modal-body text-left">

                                                   <!-- hidden id -->
                                                   <input type="hidden" name="id_petugas" id="edit_id_petugas">

                                                   <input type="text" name="username" id="edit_username"
                                                      class="form-control mb-2" required>

                                                   <input type="email" name="email" id="edit_email"
                                                      class="form-control mb-2" required>

                                                   <input type="text" name="no_hp" id="edit_no_hp"
                                                      class="form-control mb-2" required>

                                                   <textarea name="alamat" id="edit_alamat" class="form-control mb-2"
                                                      rows="2" required></textarea>

                                                   <input type="password" name="password" class="form-control mb-2"
                                                      placeholder="Password baru (kosongkan jika tidak diubah)">

                                                   <select name="gender" id="edit_gender"
                                                      class="form-select p-2 px-1 border rounded-lg" required>
                                                      <option value="" disabled selected>Pilih Gender</option>
                                                      <option value="Pria">Pria</option>
                                                      <option value="Wanita">Wanita</option>
                                                   </select>

                                                </div>

                                                <div class="modal-footer py-2">
                                                   <button type="button" class="btn btn-secondary"
                                                      data-bs-dismiss="modal">Batal</button>
                                                   <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                             </form>

                                          </div>
                                       </div>
                                    </div>

                                 </div>
                              </div>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
                  <tfoot>
                     <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>No HP</th>
                        <th>Gender</th>
                        <th>Username</th>
                        <th class="text-center">Action</th>
                     </tr>
                  </tfoot>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!-- /.container-fluid -->

</div>
<?php if (isset($_SESSION['success'])): ?>
   <script>
      Swal.fire({
         icon: 'success',
         title: 'Berhasil',
         text: '<?= $_SESSION['success']; ?>',
         timer: 2000,
         showConfirmButton: false
      });
   </script>
   <?php unset($_SESSION['success']); endif; ?>


<?php if (isset($_SESSION['error'])): ?>
   <script>
      Swal.fire({
         icon: 'error',
         title: 'Gagal',
         text: '<?= $_SESSION['error']; ?>'
      });
   </script>
   <?php unset($_SESSION['error']); endif; ?>

<!-- End of Main Content -->
<?php include '../../system/layout/footer.php'; ?>
<script>
   document.querySelectorAll('.btn-hapus').forEach(btn => {
      btn.addEventListener('click', function () {
         let id = this.getAttribute('data-id');

         Swal.fire({
            title: 'Yakin mau hapus?',
            text: 'Petugas yang dihapus tidak bisa dikembalikan!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
         }).then((result) => {
            if (result.isConfirmed) {
               fetch('../../config/admin/petugas/hapus.php', {
                  method: 'POST',
                  headers: {
                     'Content-Type': 'application/x-www-form-urlencoded'
                  },
                  body: 'id_petugas=' + id
               })
                  .then(res => res.text())
                  .then(data => {
                     if (data === 'success') {
                        Swal.fire(
                           'Terhapus!',
                           'Petugas berhasil dihapus.',
                           'success'
                        ).then(() => {
                           location.reload();
                        });
                     } else {
                        Swal.fire('Tidak bisa dihapus!', data, 'error');
                     }
                  });
            }
         });
      });
   });
   // update data petugas
   document.addEventListener('DOMContentLoaded', function () {
      var modalEdit = document.getElementById('modalEdit');

      modalEdit.addEventListener('show.bs.modal', function (event) {
         var button = event.relatedTarget; // tombol edit yg diklik

         // ambil data dari tombol
         var id = button.getAttribute('data-id');
         var username = button.getAttribute('data-username');
         var email = button.getAttribute('data-email');
         var no_hp = button.getAttribute('data-no-hp');
         var gender = button.getAttribute('data-gender');
         var alamat = button.getAttribute('data-alamat');

         // isi ke form
         document.getElementById('edit_id_petugas').value = id;
         document.getElementById('edit_username').value = username;
         document.getElementById('edit_email').value = email;
         document.getElementById('edit_no_hp').value = no_hp;
         document.getElementById('edit_gender').value = gender;
         document.getElementById('edit_alamat').value = alamat;
      });
   });
</script>