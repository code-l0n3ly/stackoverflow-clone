<?php
  date_default_timezone_set("Asia/Riyadh");
    session_start();
    include "common.php";

    $isLogin = false;
    if(isset($_SESSION['user'])) {
      $user = $_SESSION['user'];
      $isLogin = true;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Stackoverflow | Home</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- google fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- bootstrap css cdns -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">

  <script src="assets/vendor/sweetalert/sweetalert.min.js"></script>
  <script src="assets/vendor/sweetalert/sweetalert.js"></script>
  <!-- main css file -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
  <!-- header section -->
  <header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.php" class="logo d-flex align-items-center">
        <!-- <img src="assets/img/logo.png" alt=""> -->
        <span class="d-none d-lg-block">Stackoverflow</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar" >
      <form  class="search-form d-flex align-items-center" method="POST">
        <input type="text" id="search-key" name="query" placeholder="Search" title="Enter search keyword">
        <button id="search-btn" type="button" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center px-4">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->
        <?php
          if($isLogin) {
        ?>
        <li class="nav-item dropdown pe-5">
          <a class="nav-link nav-profile d-flex align-items-center pe-0 fs-4" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-person-circle"></i>
          </a><!-- End Profile Iamge Icon -->
          
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?= $user->name ?></h6>
              <span>Welcome Back!</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a id="signout-btn" class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->
        <?php }else { ?>
          <li class="nav-item me-2">
            <a href="register.php" class="nav-link btn border-primary text-primary px-3 py-2">Register</a>
          </li>
          <li class="nav-item dropdown">
            <a href="login.php" class="nav-link btn btn-primary px-3 py-2 text-white">Login</a>
          </li>
        <?php } ?>
      </ul>
    </nav><!-- End Icons Navigation -->
  </header>
  <!-- end header -->
  <script>

      $('#signout-btn').click(function() {
        $.ajax({
          url: "http://localhost/stackoverflow/signout.php",
          success: function(data) {
            if(data.status) {
              swal("Logout!", data.message, "success");
              setTimeout(function() {
                window.location. reload();
              }, 2000);
            }else {
              swal("Error!", data.message, "error");
            }
          }
        })
      })

  </script>