<?php
session_start();

require_once __DIR__ . '/../system/config.php';
include __DIR__ . '/../system/layout/header.php';

?>

<body class="bg-gradient-primary">

   <div class="container">

      <!-- Outer Row -->
      <div class="row justify-content-center">

         <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
               <div class="card-body p-0">
                  <!-- Nested Row within Card Body -->
                  <div class="row">
                     <div class="col-lg-6 d-none d-lg-flex bg-login-image align-items-center justify-content-center">
                        <img src="<?= $base ?>img/undraw_posting_photo.svg" class="img-fluid pl-5" alt="">
                     </div>

                     <div class="col-lg-6">
                        <div class="p-5">
                           <div class="text-center">
                              <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                           </div>
                           <form class="user" action="../action/login.php" method="POST">
                              <div class="form-group">
                                 <input type="email" class="form-control form-control-user" name="email" id="email"
                                    aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                              </div>
                              <div class="form-group">
                                 <input type="password" class="form-control form-control-user" name="password"
                                    id="password" placeholder="Password" required>
                              </div>
                              <div class="form-group">
                                 <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" for="customCheck">Remember
                                       Me</label>
                                 </div>
                              </div>
                              <button type="submit" class="btn btn-primary btn-user btn-block">
                                 Login
                              </button>
                              <div class="text-center">
                                 <a class="small" href="register.html">Create an Account!</a>
                              </div>
                        </div>
                     </div>
                  </div>


               </div>
            </div>

         </div>

      </div>

   </div>

   <!-- Bootstrap core JavaScript-->
   <script src="<?= $base ?>vendor/jquery/jquery.min.js"></script>
   <script src="<?= $base ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

   <!-- Core plugin JavaScript-->
   <script src="<?= $base ?>vendor/jquery-easing/jquery.easing.min.js"></script>

   <!-- Custom scripts for all pages-->
   <script src="<?= $base ?>js/sb-admin-2.min.js"></script>
   <?php if (isset($_SESSION['error'])): ?>
      <script>
         Swal.fire({
            icon: 'error',
            title: 'Login Gagal',
            text: '<?= $_SESSION['error']; ?>',
            confirmButtonText: 'OK'
         });
      </script>
      <?php unset($_SESSION['error']); endif; ?>
   <?php if (isset($_SESSION['success'])):
      if ($_SESSION['role'] === 'admin'): ?>
         <script>
            Swal.fire({
               icon: 'success',
               title: 'Login Berhasil Sebagai',
               text: '<?= $_SESSION['success']; ?> (Admin)',
               timer: 2200,
               showConfirmButton: false
            }).then(() => {
               window.location.href = 'admin/dashboard.php';
            });
         </script>
      <?php else: ?>
         <script>
            Swal.fire({
               icon: 'success',
               title: 'Login Berhasil Sebagai',
               text: '<?= $_SESSION['success']; ?> (Petugas)',
               timer: 2200,
               showConfirmButton: false
            }).then(() => {
               window.location.href = 'petugas/dashboard.php';
            });
         </script>
      <?php endif; ?>
      <?php unset($_SESSION['success']); endif; ?>
</body>

</html>