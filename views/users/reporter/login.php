<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?= $this->siteSettings['company_alias'] . "-" . $page_name ; ?></title>
  <link href="views/assets/css/bootstrap.min.css" rel="stylesheet" />

   <script src="views/inc/sweetalert/sweetalert2@11.js"></script>
 <script src="views/inc/sweetalert/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="views/inc/sweetalert/sweetalert2.min.css"> 
    
  <style>
    :root {
      --nis-green: #0b6623;
      --nis-gold: #c9a100;
    }

    body {
      height: 100vh;
      margin: 0;
      background: url('views/uploads/img/bg/<?php echo $this->siteSettings['company_bg3'] ?>') center/cover no-repeat fixed;
      display: flex;
      justify-content: center;
      align-items: center;
      font-family: "Segoe UI", sans-serif;
      overflow: hidden;
      position: relative;
    }

    #bg-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      overflow: hidden;
    }

    .bg-image {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-size: cover;
      background-position: center;
      opacity: 0;
      transition: opacity 6s ease-in-out;
    }

    .bg-image.active {
      opacity: 1;
    }

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

    .loader-spin {
      width: 50px;
      height: 50px;
      border: 6px solid #e0e0e0;
      border-top: 6px solid var(--nis-green);
      border-radius: 50%;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      to { transform: rotate(360deg); }
    }

    .loader-text {
      color: var(--nis-green);
      font-weight: bold;
      font-size: 18px;
      margin-top: 10px;
    }

    .login-card {
      width: 100%;
      max-width: 420px;
      background: white;
      border-radius: 14px;
      padding: 2rem;
      box-shadow: 0 4px 25px rgba(0,0,0,0.4);
      border-top: 6px solid var(--nis-green);
      animation: fadeIn 0.9s ease;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }

    .nis-logo {
      width: 90px;
      display: block;
      margin: 0 auto 10px auto;
    }

    .login-btn {
      background: var(--nis-green);
      color: white;
      border: none;
      padding: 10px;
      border-radius: 6px;
      transition: 0.3s;
    }

    .login-btn:hover {
      background: var(--nis-gold);
      color: #fff;
    }

    .title {
      font-weight: bold;
      color: var(--nis-green);
      text-align: center;
    }

    .sub-title {
      text-align: center;
      color: #555;
      margin-bottom: 1.5rem;
    }

    .powered-text {
      position: absolute;
      bottom: 10px;
      width: 100%;
      text-align: center;
      color: #fff;
      font-size: 14px;
    }
  </style>
</head>
<body>
<?php 
if (!empty($error)) {
    $msgtext = $error;
    $url = "#";
    $showAlert = false ;

}



?>


<!-- Background Fade Layers -->
<div id="bg-container">
  <div class="bg-image active" style="background-image:url('views/uploads/img/bg/<?php echo $this->siteSettings['company_bg1'] ?>');"></div>
  <div class="bg-image" style="background-image:url('views/uploads/img/bg/<?php echo $this->siteSettings['company_bg2'] ?>');"></div>
  <div class="bg-image" style="background-image:url('views/uploads/img/bg/<?php echo $this->siteSettings['company_bg3'] ?>');"></div>
  <div class="bg-image" style="background-image:url('views/uploads/img/bg/<?php echo $this->siteSettings['company_bg4'] ?>');"></div>
</div>

<!-- PAGE LOADER -->
<div id="page-loader">
  <img src="views/uploads/img/logo.png" alt="NIS Logo" width="80" height="80">
  <div class="loader-spin"></div>
  <div class="loader-text">Loading... Please wait</div>
</div>

<div class="login-card">
  <img src="views/uploads/img/logo.png" alt="NIS Logo" class="nis-logo">
  <h3 class="title">Nigeria Immigration Service</h3>
  <p class="sub-title"><b><?= $this->siteSettings['company_name'] ?></b></p>

  <form  method="post" enctype="multipart/form-data">
    <div class="mb-1">
      <label class="form-label">Service No</label>
      <input name="username" type="text" pattern="[0-9]*" inputmode="numeric" class="form-control" maxlength="8" placeholder="Enter service no" required>
    </div>

    <div class="mb-1">
      <label class="form-label">Password</label>
      <input type="password" class="form-control"  pattern="[a-zA-Z0-9]+"  name="password" maxlength="15" placeholder="Enter password" required>
    </div>

    <div class="mb-1">
      <div class="d-flex flex-wrap gap-3">
        <div class="form-check"><input class="form-check-input" type="radio" name="role" value="officer"><label class="form-check-label">Officer</label></div>
        <div class="form-check"><input class="form-check-input" type="radio" name="role" value="oc"><label class="form-check-label">OC</label></div>
        <div class="form-check"><input class="form-check-input" type="radio" name="role" value="desk" checked><label class="form-check-label">Desk</label></div>
        <div class="form-check"><input class="form-check-input" type="radio" name="role" value="cis"><label class="form-check-label">CIS</label></div>
        <div class="form-check"><input class="form-check-input" type="radio" name="role" value="dev"><label class="form-check-label">Dev</label></div>
      </div>
    </div>

    <button type="submit" name="login" class="login-btn w-100 mt-1">Login</button>

    <div class="text-center mt-3">
      <a href="#" data-bs-toggle="modal" data-bs-target="#forgotPasswordModal" class="text-decoration-none" style="color: var(--nis-green);">
        Forgot Password?
      </a>
    </div>
  </form>
</div>

<p class="powered-text">Powered by IA3 Imeokparia J.</p>

<!-- RESET PASSWORD POPUP -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">

      <div class="modal-header" style="background: var(--nis-green); color: white;">
        <h5 class="modal-title">Alternative Login</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <form id="forgotPasswordForm"  method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <p>Please enter your registered email address for alternative login code.</p>

          <label class="form-label">Email Address</label>
          <input type="email" id="resetEmail" name="email" class="form-control"
                 placeholder="example@gmail.com" required>

          <!-- Hidden field so PHP can detect this request -->
          <input type="hidden" name="forgot_password" value="1">
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-success" onclick="return validateAndSubmit()">Submit</button>
        </div>
      </form>

    </div>
  </div>
</div>

<script>
  // Strict Email Validation
  function validateAndSubmit() {
    const email = document.getElementById("resetEmail").value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    if (!emailPattern.test(email)) {
      alert("Please enter a valid email address.\nExample: name@domain.com");
      return false; // stop submission
    }

    return true; // allow form submission
  }

  // Loader fade
  window.addEventListener("load", function () {
    const loader = document.getElementById("page-loader");
    loader.style.transition = "opacity 0.5s ease";
    loader.style.opacity = "0";
    setTimeout(() => loader.style.display = "none", 500);
  });

  // Background transition
  let index = 0;
  const images = document.querySelectorAll('.bg-image');

  setInterval(() => {
    const nextIndex = (index + 1) % images.length;
    images[index].classList.remove('active');
    images[nextIndex].classList.add('active');
    index = nextIndex;
  }, 20000);
</script>
<?php include 'views/inc/footer.php' ?>
