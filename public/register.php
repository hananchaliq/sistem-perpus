<?php
session_start();

require_once __DIR__ . '/../system/config.php';
include __DIR__ . '/../system/layout/header.php';

?>

<body class="bg-gradient-primary">

   <div class="container vh-100 d-flex justify-content-center align-items-center">

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
                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                     </div>
                     <form class="user" action="../action/register.php" method="POST">
                        <div class="form-group row">
                           <div class="col-sm-6 mb-3 mb-sm-0">
                              <input type="text" class="form-control form-control-user" name="name"
                                 id="exampleFirstName" placeholder="Name" required>
                           </div>
                           <div class="col-sm-6">
                              <input type="text" class="form-control form-control-user" name="username"
                                 id="exampleLastName" placeholder="Username" required>
                           </div>
                        </div>
                        <div class="form-group">
                           <input type="email" class="form-control form-control-user" name="email"
                              id="exampleInputEmail" placeholder="Email Address" required>
                        </div>
                        <div class="form-group row">
                           <div class="col-sm-6 mb-3 mb-sm-0">
                              <input type="password" class="form-control form-control-user" name="password"
                                 id="exampleInputPassword" placeholder="Password" required>
                           </div>
                           <div class="col-sm-6">
                              <input type="password" class="form-control form-control-user" name="password2"
                                 id="exampleRepeatPassword" placeholder="Repeat Password" required>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-user btn-block">
                           Register Account
                        </button>
                     </form>
                     <hr>
                     <div class="text-center">
                        <a class="small" href="login.php">Already have an account? Login!</a>
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

   <!-- sweet alert -->
   <script>
      const urlParams = new URLSearchParams(window.location.search);
      const status = urlParams.get('status');

      if (status === 'duplicate') {
         Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: 'Username atau Email sudah terdaftar!'
         });
      }

      if (status === 'pass_error') {
         Swal.fire({
            icon: 'warning',
            title: 'Oops!',
            text: 'Password tidak sama!'
         });
      }

      if (status === 'success') {
         Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: 'Akun berhasil dibuat',
            timer: 2000,
            showConfirmButton: false
         });
      }
   </script>

</body>

</html>