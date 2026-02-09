<?php
require_once '../../system/config.php';
?>

<body id="page-top">

   <!-- Page Wrapper -->
   <div id="wrapper">

      <!-- Sidebar -->
      <ul class="navbar-nav bg-gradient-primary  sidebar sidebar-dark accordion" id="accordionSidebar">

         <!-- Sidebar - Brand -->
         <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= $base ?>/public/admin/dashboard.php">
            <div class="sidebar-brand-icon">
               <i class="fas fa-book-open fa-fw"></i>
            </div>
            <div class="sidebar-brand-text mx-3">E-Perpus</div>
         </a>

         <!-- Divider -->
         <hr class="sidebar-divider my-0">

         <!-- Nav Item - Dashboard -->
         <li class="nav-item active">
            <a class="nav-link" href="<?= $base ?>/public/admin/dashboard.php">
               <i class="fas fa-fw fa-tachometer-alt"></i>
               <span>Dashboard</span></a>
         </li>

         <!-- Divider -->
         <hr class="sidebar-divider">

         <!-- Heading -->
         <div class="sidebar-heading">
            Interface
         </div>

         <!-- Nav Item - Pages Collapse Menu -->
         <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>/public/admin/peminjaman.php">
               <i class="fas fa-book-reader fa-fw"></i>
               <span>Peminjaman</span>
            </a>
         </li>

         <!-- Kategori -->
         <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>/public/admin/denda.php">
               <i class="fas fa-money-bill-wave fa-fw"></i>
               <span>Denda</span>
            </a>
         </li>

         <!-- Buku -->
         <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>/public/admin/buku.php">
               <i class="fas fa-fw fa-book fa-fw"></i>
               <span>Daftar Buku</span>
            </a>
         </li>

         <!-- Ulasan -->
         <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>/public/admin/ulasan.php">
               <i class="fas fa-comment-dots fa-fw"></i>
               <span>Ulasan</span>
            </a>
         </li>

         <!-- Pengurus -->
         <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>/public/admin/pengurus.php">
               <i class="fas fa-user fa-fw"></i>
               <span>Pengurus</span>
            </a>
         </li>

         <!-- Logout -->
         <li class="nav-item">
            <a class="nav-link" href="<?= $base ?>/public/logout.php">
               <i class="fas fa-sign-out-alt fa-fw"></i>
               <span class="">Logout</span>
            </a>
         </li>

         <!-- Divider -->
         <hr class="sidebar-divider d-none d-md-block">

         <!-- Sidebar Toggler (Sidebar) -->
         <div class="text-center d-none d-md-inline">
            <button class="rounded-circle border-0" id="sidebarToggle"></button>
         </div>

         <!-- Sidebar Message -->
         <div class="sidebar-card d-none d-lg-flex">
            <img class="sidebar-card-illustration mb-2" src="<?= $base ?>/img/undraw_rocket.svg" alt="...">
            <p class="text-center mb-2"><strong>SB Admin Pro</strong> is packed with premium features, components, and
               more!</p>
            <a class="btn btn-success btn-sm" href="https://startbootstrap.com/theme/sb-admin-pro">Upgrade to Pro!</a>
         </div>

      </ul>
      <!-- End of Sidebar -->

      <!-- Content Wrapper -->
      <div id="content-wrapper" class="d-flex flex-column">