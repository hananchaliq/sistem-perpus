<?php
session_start();
require_once '../../system/config.php';
include '../../system/layout/header.php';
include '../../system/layout/sidebar.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
   header("Location: ../login.php");
   exit;
}

// Query Data Peminjaman
$sql = "SELECT p.*, s.nisn, s.nama_siswa, s.kelas, b.nama_buku, pa.nama_petugas
        FROM peminjaman p
        JOIN siswa s ON s.id_siswa = p.id_siswa
        JOIN buku b  ON b.id_buku  = p.id_buku
        JOIN petugas pa ON pa.id_petugas = p.id_petugas
        ORDER BY p.tanggal_peminjaman DESC";
$data = $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);

$buku = $pdo->query("SELECT id_buku, nama_buku FROM buku WHERE jumlah_stok > 0")->fetchAll();
$petugas = $pdo->query("SELECT id_petugas, nama_petugas FROM petugas")->fetchAll();
?>

<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<div id="content">
   <?php include '../../system/layout/topbar.php'; ?>
   <div class="container-fluid">
      <h1 class="h3 mb-2 text-gray-800">Daftar Peminjaman</h1>

      <div class="card shadow mb-4">
         <div class="card-header d-flex justify-content-between align-items-center py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Peminjaman</h6>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahPeminjaman">
               <i class="fas fa-plus"></i> Tambah Peminjaman
            </button>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                     <tr>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Buku</th>
                        <th>Pinjam</th>
                        <th>Kembali</th>
                        <th>Status</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach ($data as $s): ?>
                        <tr>
                           <td><?= $s['nisn']; ?></td>
                           <td><?= $s['nama_siswa']; ?></td>
                           <td><?= $s['kelas']; ?></td>
                           <td><?= $s['nama_buku']; ?></td>
                           <td><?= $s['tanggal_peminjaman']; ?></td>
                           <td><?= $s['tanggal_pengembalian']; ?></td>
                           <td><span
                                 class="badge <?= $s['status'] == 'Dipinjam' ? 'bg-warning' : 'bg-success' ?> text-white"><?= $s['status']; ?></span>
                           </td>
                           <td><?= $s['nama_petugas']; ?></td>
                           <td class="text-center">
                              <button class="btn btn-warning btn-sm btn-edit" data-id="<?= $s['id_peminjaman']; ?>"
                                 data-tanggal="<?= $s['tanggal_pengembalian']; ?>" data-status="<?= $s['status']; ?>"
                                 data-pinjam="<?= $s['tanggal_peminjaman']; ?>" data-bs-toggle="modal"
                                 data-bs-target="#modalEdit">
                                 <i class="fas fa-pen"></i>
                              </button>

                              <button type="button" class="btn btn-danger btn-sm btn-hapus"
                                 data-id="<?= $s['id_peminjaman']; ?>">
                                 <i class="fas fa-trash"></i>
                              </button>
                           </td>
                        </tr>
                     <?php endforeach; ?>
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal fade" id="modalTambahPeminjaman" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <form action="../../config/admin/peminjaman/tambah.php" method="POST">
            <div class="modal-header">
               <h5>Tambah Peminjaman</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
               <input type="hidden" name="status" value="Dipinjam">
               <label>Cari Siswa</label>
               <input type="text" id="searchSiswa" class="form-control mb-2" placeholder="Ketik nama/nisn...">
               <div id="resultSiswa" class="list-group mb-2" style="position:absolute; z-index:1000; width:90%"></div>
               <input type="text" name="nisn" id="nisn" class="form-control mb-2" placeholder="NISN" readonly required>
               <input type="text" id="nama" class="form-control mb-2" placeholder="Nama" readonly>

               <label>Pilih Buku</label>
               <select name="id_buku" class="form-control mb-2" required>
                  <?php foreach ($buku as $b): ?>
                     <option value="<?= $b['id_buku']; ?>"><?= $b['nama_buku']; ?></option>
                  <?php endforeach; ?>
               </select>

               <div class="row">
                  <div class="col-6"><label>Tgl Pinjam</label><input type="date" name="tgl_pinjam" class="form-control"
                        value="<?= date('Y-m-d') ?>" required></div>
                  <div class="col-6"><label>Est. Kembali</label><input type="date" name="tgl_kembali"
                        class="form-control" required></div>
               </div>

               <label class="mt-2">Petugas</label>
               <select name="id_petugas" class="form-control">
                  <?php foreach ($petugas as $p): ?>
                     <option value="<?= $p['id_petugas']; ?>"><?= $p['nama_petugas']; ?></option>
                  <?php endforeach; ?>
               </select>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary w-100">Simpan</button></div>
         </form>
      </div>
   </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <form action="../../config/admin/peminjaman/edit.php" method="POST">
            <div class="modal-header">
               <h5>Update Status</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
               <input type="hidden" name="id_peminjaman" id="edit_id_peminjaman">
               <label>Tgl Pengembalian Asli</label>
               <input type="date" name="tanggal_pengembalian" id="edit_tanggal_pengembalian" class="form-control mb-2"
                  required>
               <label>Status</label>
               <select name="status" id="edit_status" class="form-control">
                  <option value="Dipinjam">Dipinjam</option>
                  <option value="Dikembalikan">Dikembalikan</option>
               </select>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary w-100">Update</button></div>
         </form>
      </div>
   </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   // Search Siswa AJAX
   const search = document.getElementById('searchSiswa');
   const result = document.getElementById('resultSiswa');
   search.addEventListener('input', () => {
      const key = search.value;
      if (key.length < 1) { result.innerHTML = ''; return; }
      fetch(`../../config/admin/peminjaman/search.php?keyword=${key}`)
         .then(res => res.json()).then(data => {
            result.innerHTML = '';
            data.forEach(s => {
               let btn = document.createElement('button');
               btn.className = 'list-group-item list-group-item-action';
               btn.innerHTML = `${s.nisn} - ${s.nama}`;
               btn.onclick = (e) => {
                  e.preventDefault();
                  document.getElementById('nisn').value = s.nisn;
                  document.getElementById('nama').value = s.nama;
                  result.innerHTML = ''; search.value = '';
               };
               result.appendChild(btn);
            });
         });
   });

   // Edit Logic & Min Date Validation
   document.querySelectorAll('.btn-edit').forEach(btn => {
      btn.addEventListener('click', function () {
         document.getElementById('edit_id_peminjaman').value = this.dataset.id;
         document.getElementById('edit_tanggal_pengembalian').value = this.dataset.tanggal;
         document.getElementById('edit_status').value = this.dataset.status;
         document.getElementById('edit_tanggal_pengembalian').setAttribute('min', this.dataset.pinjam);
      });
   });

   // SweetAlert Notif
   document.addEventListener('DOMContentLoaded', function () {
      <?php if (isset($_SESSION['success'])): ?>
         Swal.fire('Berhasil!', '<?= $_SESSION['success'] ?>', 'success');
         <?php unset($_SESSION['success']); ?>
      <?php endif; ?>
      <?php if (isset($_SESSION['error'])): ?>
         Swal.fire('Gagal!', '<?= $_SESSION['error'] ?>', 'error');
         <?php unset($_SESSION['error']); ?>
      <?php endif; ?>
   });

   // Delete Confirmation
   document.querySelectorAll('.btn-hapus').forEach(btn => {
      btn.onclick = function () {
         const id = this.dataset.id;
         Swal.fire({
            title: 'Hapus data?', text: "Data ini akan hilang!", icon: 'warning',
            showCancelButton: true, confirmButtonText: 'Ya, Hapus!'
         }).then((res) => { if (res.isConfirmed) window.location.href = `../../config/admin/peminjaman/hapus.php?id=${id}`; });
      }
   });
   // ... kode script lainnya (search, edit, dll) ...

   // REVISI LOGIKA HAPUS
   document.querySelectorAll('.btn-hapus').forEach(btn => {
      btn.addEventListener('click', function (e) {
         e.preventDefault(); // Mencegah reload halaman mendadak
         const idHapus = this.dataset.id; // Mengambil ID dari atribut data-id

         Swal.fire({
            title: 'Yakin mau hapus?',
            text: "Data peminjaman akan dihapus dan stok buku akan dikembalikan (jika status masih dipinjam).",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true
         }).then((result) => {
            if (result.isConfirmed) {
               // Arahkan ke file hapus.php dengan parameter ID
               // Pastikan path ../../config/admin/peminjaman/hapus.php sudah benar
               window.location.href = `../../config/admin/peminjaman/hapus.php?id=${idHapus}`;
            }
         });
      });
   });
</script>
<?php include '../../system/layout/footer.php'; ?>