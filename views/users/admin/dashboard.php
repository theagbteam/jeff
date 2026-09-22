<?php 
$page_name  = "dashboard" ;


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo $this->siteSettings['company_alias'] . "  -  " . $page_name; ?></title>
  <link href="views/assets/css/bootstrap.min.css" rel="stylesheet" />
   <script src="views/inc/dev/sweetalert/sweetalert2@11.js"></script>
 <script src="views/inc/dev/sweetalert/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="views/inc/dev/sweetalert/sweetalert2.min.css"> 

  <style>
    :root {
      --nis-green: #0b6623;
      --nis-gold: #c9a100;
      --nis-light: #f5f8f5;
      --card-bg: #ffffff;
      --metric-color: #0b6623;
      --metric-font: 'Courier New', monospace;
    }

    body {
      background: var(--nis-light);
      font-family: "Segoe UI", sans-serif;
    }

    /* PAGE LOADER */
    #page-loader {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: white;
      z-index: 9999;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
    }

    #page-loader img { width: 80px; height: 80px; margin-bottom: 15px; }

    .loader-spin {
      width: 50px;
      height: 50px;
      border: 6px solid #e0e0e0;
      border-top: 6px solid var(--nis-green);
      border-radius: 50%;
      animation: spin 1s linear infinite;
      margin-bottom: 15px;
    }

    @keyframes spin { to { transform: rotate(360deg); } }

    /* NAVBAR */
    .navbar { background: var(--nis-green); }

    .menu-btn {
      font-weight: 800;
      font-size: 1rem;
      color: white;
    }

    .navbar .center-logo {
      position: absolute;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      align-items: center;
      color: white;
      font-weight: bold;
      gap: 8px;
    }

    .navbar .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
      color: white;
      font-weight: bold;
    }

    .user-photo {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      object-fit: cover;
      border: 2px solid white;
    }

    /* SIDEBAR */
    .offcanvas {
      background: var(--nis-green);
      color: white;
      width: 220px;
    }

    .offcanvas .nav-link {
      color: #d9ffd9;
      padding: 10px 18px;
      border-radius: 4px;
      display: flex;
      align-items: center;
      gap: 10px;
      transition: 0.3s;
      font-weight: 500;
    }

    /* ACTIVE DASHBOARD */
    .offcanvas .nav-link.active {
      background: var(--nis-gold);
      color: #fff;
      font-weight: 700;
    }

    .offcanvas .nav-link:hover {
      background: var(--nis-gold);
      color: white;
      transform: translateX(5px);
    }

    /* SUBMENUS */
    #recruitMenu .nav-link,
    #promotionsMenu .nav-link {
      font-size: 0.9rem;
      padding-left: 35px;
      color: #e8ffe8;
    }

    #recruitMenu .nav-link:hover,
    #promotionsMenu .nav-link:hover {
      background: rgba(255,255,255,0.15);
    }

    /* DASHBOARD */
    .card {
      border-radius: 10px;
      background: var(--card-bg);
      box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .card-header {
      background: var(--nis-green);
      color: white;
      font-weight: bold;
      font-size: 0.95rem;
      text-transform: uppercase;
    }

    .metric {
      font-family: var(--metric-font);
      font-size: 2rem;
      color: var(--metric-color);
      margin: 0;
    }

    .activity-list li {
      padding: 6px 0;
      border-bottom: 1px solid #eee;
      font-size: 0.9rem;
    }
  </style>
</head>

<body>
  <!-- <?=   $_SESSION['success']; ?> -->
<?php 

if (isset( $_SESSION['success'] )) {
    $msgtext =  $_SESSION['success'] ;
    $url       = "#";
    $showAlert = true;
     unset($_SESSION['success']);
}


?>

<!-- PAGE LOADER -->


<!-- TOP NAVBAR -->
<div id="page-loader">
  <img src="views/uploads/img/<?= $this->siteSettings['company_logo'] ?>">
  <div class="loader-spin"></div>
  <div>Loading... Please wait</div>
</div>
<nav class="navbar navbar-expand-lg position-relative">
  <div class="container-fluid d-flex justify-content-between">
    <button class="btn btn-sm menu-btn" type="button"
      data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu">
      ☰ Menu
    </button>

    <div class="center-logo">
      <!-- <img src="views/uploads/img/<?= $this->siteSettings['company_logo'] ?>" width="40"> -->
   
      <?php if ($this->deviceType == 'mobile') : ?>

    <?php elseif ($this->deviceType == 'tablet') : ?>
<img src="views/uploads/img/<?= $this->siteSettings['company_logo'] ?>" width="40">
<span class="fs-5"><?= $this->siteSettings['company_alias'] ?></span>
<?php  else : ?>

<img src="views/uploads/img/<?= $this->siteSettings['company_logo'] ?>" width="40">
<span class="fs-5"><?= $this->siteSettings['company_alias'] ?></span>
        <?php endif;  ?>
    </div>

    <div class="user-info">
      <span><b><?=   $this->officers_name ?></b></span>
      <img src="views/uploads/img/profile/<?= $this->Get_personenl_data ['img'] ?>" class="user-photo">
    </div>
  </div>
</nav>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu">
  <div class="offcanvas-header">
    <h5><img src="views/uploads/img/logo.png" width="40"> <?= $this->siteSettings['company_alias'] ?></h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
  </div>

  <div class="offcanvas-body">
    <nav class="nav flex-column">
<?php   if ($_SESSION['role'] =="desk") : ?>
  <?php include 'views/inc/dev/menu_desk.php' ;  ?>
<?php endif;  ?>
    </nav>
  </div>
</div>

<!-- MAIN CONTENT -->
<div class="container mt-4">

  <div class="row g-4">
    <div class="col-md-4">
      <div class="card p-3">
        <div class="card-header">Total Personnel</div>
        <div class="card-body">
          <p class="metric">12,540</p>
          <small class="text-muted">Active officers registered</small>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3">
        <div class="card-header">Officers on Leave</div>
        <div class="card-body">
          <p class="metric">87</p>
          <small class="text-muted">Awaiting approval</small>
        </div>
      </div>
    </div>

    <div class="col-md-4">
      <div class="card p-3">
        <div class="card-header">Officers on Duty</div>
        <div class="card-body">
          <p class="metric">14</p>
          <small class="text-muted">Upcoming programs</small>
        </div>
      </div>
    </div>
  </div>

  <div class="row mt-4">
    <div class="col-12">
      <div class="card p-3">
        <div class="card-header">Recent Activity</div>
        <div class="card-body">
          <ul class="activity-list">
            <li>5 personnel updated their profiles</li>
            <li>12 leave requests submitted</li>
            <li>Promotion cycle initiated for senior officers</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <div class="text-center mt-4 mb-3 text-muted">
    Powered by <strong>IA3 Imeokparia J.</strong>
  </div>

</div>

<script>
  window.addEventListener("load", function () {
    const loader = document.getElementById("page-loader");
    loader.style.opacity = "0";
    setTimeout(() => loader.style.display = "none", 500);
  });
</script>
<?php include 'views/inc/dev/footer.php' ?>
