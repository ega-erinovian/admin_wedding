<?php 
  include '../model/connect.php';
  date_default_timezone_get(); ?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: Mar 09 2023 with Bootstrap v5.2.3
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <!-- Logo -->
      <div class="row align-items-center" style="margin-left: -1.5rem;">
        <div class="col">
          <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>
        <div class="col">
          <a href="../index.php" class="logo d-flex align-items-center">
            <img src="../assets/img/logo.png" alt="">
            <span class="d-none d-lg-block">Wedding Gaslik</span>
          </a>
        </div>
      </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!-- Profile Nav -->
        <li class="nav-item dropdown pe-3">

          <!-- Profile Image Icon -->
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">W. Anderson</span>
          </a><!-- End Profile Image Icon -->

          <!-- Profile Dropdown Items -->
          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Wes Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../profile/users_profile.php">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <!-- Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="../index.php">
          <i class="bi bi-grid-1x2"></i>
          <span>Dashboard</span>
        </a>
      </li><!-- End Dashboard Nav -->
      
      <!-- Projects -->
      <li class="nav-item">
        <a class="nav-link" href="./tabel_project.php">
          <i class="bi bi-camera-fill"></i>
          <span>Projects</span>
        </a>
      </li><!-- End Projects -->

      <li class="nav-heading">Pages</li>

      <!-- Profile Page Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="../profile/users_profile.php">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li><!-- End Profile Page Nav -->
    </ul>

  </aside><!-- End Sidebar -->

  <!-- ======= Main ======= -->
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Kelola Project Baru</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item ">Home</li>
          <li class="breadcrumb-item ">Projects</li>
          <li class="breadcrumb-item ">Tabel Projects</li>
          <li class="breadcrumb-item active">Kelola Project</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">

        <!-- Left side columns -->
        <div class="col">
          <div class="row">

            <!-- Recent Projects -->
            <?php
              function randString($length) {
                $char = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
                $char = str_shuffle($char);
                for($i = 0, $rand = '', $l = strlen($char) - 1; $i < $length; $i ++) {
                    $rand .= $char{mt_rand(0, $l)};
                }
                return $rand;
              }

              for($i = 0; $i < 10 ; $i++)
              {
                  $id_project = randString(5);
              }

              $datetime = new DateTime();
              $unix=$datetime->getTimestamp();

              if(isset($_GET['kelola'])){
                // 'Tambah' condition
                if($_GET['kelola'] == 'tambah'){
                  $nama       ="";
                  $datetime   ="";
                  $price      ="";
                  $status     ="";
                }else{
                    // 'Edit' Condition - Form terisi dengan data didatabase
                    $query = mysqli_query($connect, "SELECT * FROM projects WHERE id_project='".$_GET['id']."'");
                    while($data=mysqli_fetch_array($query)){
                      $id_project =$data[0];
                      $nama       =$data[1];
                      $datetime   =date("Y-m-d\TH:i", $data[2]);
                      $price      =$data[3];
                      $status     =$data[4];
                    }
                }
            }
            ?>
            <div class="col">
              <div class="card recent-sales overflow-auto">

                <div class="card-body">
                  <div class="row py-4">
                    <div class="col">
                      <h2 class="fw-bold mb-1" style="text-transform: capitalize;"><?= $_GET['kelola'] ?> Project Baru</h2>
                    </div>
                  </div>
                  <form action="../model/proses_project.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" value=<?= $_GET['kelola'] ?> name="kelola" />
                    <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Project ID</label>
                      <input type="text" class="form-control" name="id_project" id="projectName" value=<?= $id_project ?> />
                      <div class="form-text"><span class="text-danger">*</span> Terisi otomatis</div>
                    </div>
                    <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Project Name</label>
                      <input type="text" class="form-control" name="nama" id="projectName" placeholder="ex. Wedding Egie Tatsa" value=<?= $nama ?> />
                    </div>
                    <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Tanggal Project</label>
                      <input type="text" class="form-control" name="datetime" id="projectName" value=<?= $datetime ?> />
                      <div class="form-text"><span class="text-danger">*</span> Terisi otomatis</div>
                    </div>
                    <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Harga</label>
                      <input type="number" class="form-control" name="price" id="projectName" placeholder="ex. 300000" value=<?= $price ?> />
                    </div>
                    <div class="mb-3">
                      <label for="exampleFormControlInput1" class="form-label">Status</label>
                      <select class="form-select" name="status" aria-label="Default select example">
                        <option selected disabled>Open this select menu</option>
                        <option value="rejected" <?php if($status =="rejected") echo 'selected'; ?>>Rejected</option>
                        <option value="pending" <?php if($status =="pending") echo 'selected'; ?>>Pending</option>
                        <option value="approved" <?php if($status =="approved") echo 'selected'; ?>>Approved</option>
                      </select>
                    </div>
                    <div class="mb-3">
                      <label for="fileInput" class="form-label">Unggah Gambar</label>
                      <input type="file" class="form-control-file" name="img_file[]" accept=".jpg,.gif,.png,.webp" multiple/>
                    </div>
                    <div class="row">
                      <div class="col-12" style="text-align: end;">
                        <button type="submit" class="btn btn-primary">Submit</button>
                      </div>
                    </div>
                  </form>
                </div>

              </div>
            </div><!-- End Recent Projects -->

          </div>
        </div><!-- End Left side columns -->

      </div>
    </section>
  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>

</html>