<?php
session_start();

require_once '../../system/config.php';
include '../../system/layout/header.php';
include '../../system/layout/sidebar.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
   header("Location: ../login.php");
   exit;
}

?>

<?php include '../../system/layout/footer.php'; ?>