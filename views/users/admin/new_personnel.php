<?php  
$page_name  = "personnel";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title><?php echo $this->siteSettings['company_alias'] . " - " . $page_name; ?></title>

<link href="views/assets/css/bootstrap.min.css" rel="stylesheet" />
<script src="views/inc/sweetalert/sweetalert2@11.js"></script>
<script src="views/inc/sweetalert/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="views/inc/sweetalert/sweetalert2.min.css">

<style>
:root {
  --nis-green:#0b6623;
  --nis-gold:#c9a100;
  --nis-light:#f5f8f5;
  --card-bg:#ffffff;
}

body{
  background:var(--nis-light);
  font-family:"Segoe UI",sans-serif;
}

/* NAVBAR */
.navbar{background:var(--nis-green);}
.menu-btn{font-weight:800;color:#fff;}
.user-photo{
  width:36px;height:36px;border-radius:50%;
  object-fit:cover;border:2px solid #fff;
}

/* SIDEBAR */
.offcanvas{background:var(--nis-green);color:#fff;width:220px;}
.offcanvas .nav-link{color:#d9ffd9;}
.offcanvas .nav-link.active{
  background:var(--nis-gold);color:#fff;font-weight:700;
}

/* CARD */
.card{border-radius:10px;box-shadow:0 4px 10px rgba(0,0,0,.05);}
.card-header{background:var(--nis-green);color:#fff;font-weight:bold;}

/* STEPS */
.step{display:none;}
.step.active{display:block;}

/* PASSPORT PREVIEW */
.preview-box{
  width:150px;
  height:180px;
  border:2px dashed var(--nis-green);
  border-radius:6px;
  display:flex;
  align-items:center;
  justify-content:center;
  cursor:pointer;
  color:var(--nis-green);
  font-size:0.9rem;
  background:#f9f9f9;
  overflow:hidden;
}

.preview-box img{
  width:100%;
  height:100%;
  object-fit:cover;
}

#passport{display:none;}
</style>
</head>

<body>

<!-- TOP NAVBAR -->
<nav class="navbar navbar-expand-lg">
<div class="container-fluid d-flex justify-content-between">
<button class="btn btn-sm menu-btn"
data-bs-toggle="offcanvas"
data-bs-target="#sidebarMenu">☰ Menu</button>

<div class="text-white fw-bold fs-5">
<img src="views/uploads/img/logo.png" width="35"> CME
</div>

<div class="d-flex align-items-center text-white fw-bold gap-2">
<span>E.E Agbonile</span>
<img src="views/uploads/img/photo/1.jpeg" class="user-photo">
</div>
</div>
</nav>

<!-- SIDEBAR -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebarMenu">
<div class="offcanvas-header">
<h5>
<img src="views/uploads/img/logo.png" width="40">
<?= $this->siteSettings['company_alias'] ?>
</h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
</div>

<div class="offcanvas-body">
<nav class="nav flex-column">
<?php if ($_SESSION['role']=="desk") : ?>
<?php include 'views/inc/menu_desk.php'; ?>
<?php endif; ?>
</nav>
</div>
</div>

<!-- MAIN CONTENT -->
<div class="container mt-3 mb-4">
<div class="card">
<div class="card-header">
Personnel Registration (3 Steps)
</div>

<div class="card-body">
<form id="regForm" enctype="multipart/form-data" method="post">

<!-- STEP 1 -->
<div class="step active">
<h5>Step 1: Identity & Service</h5>

<label class="form-label">Passport Photograph *</label>
<div class="preview-box mb-2" id="previewBox">
Click to select photo
</div>
<input type="file" id="passport" name="passport" accept="image/*" class="required">

<div class="mb-3">
<label class="form-label">Personnel *</label>
<select class="form-control required">
<option value="">Select status</option>
<option value="personnel">Trained Officer</option>
<option value="recruit">Recruit (Untrained)</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Service Number *</label>
<input type="text" class="form-control required">
</div>

<div class="mb-3">
<label class="form-label">Surname *</label>
<input type="text" class="form-control required">
</div>

<div class="mb-3">
<label class="form-label">First Name *</label>
<input type="text" class="form-control required">
</div>

<div class="mb-3">
<label class="form-label">Middle Name</label>
<input type="text" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">Date of Birth *</label>
<input type="date" class="form-control required">
</div>

<div class="mb-3">
<label class="form-label">Email *</label>
<input type="email" class="form-control required">
</div>

<div class="mb-3">
<label class="form-label">Rank *</label>
<select class="form-control required">
<option value="">Select Rank</option>
<option>Constable</option>
<option>Corporal</option>
<option>Sergeant</option>
<option>Inspector</option>
<option>ASP</option>
<option>DSP</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Phone *</label>
<input type="text" class="form-control required" placeholder="15 digit number">
</div>
</div>

<!-- STEP 2 -->
<div class="step">
<h5>Step 2: Background & Posting</h5>

<div class="mb-3">
<label class="form-label">Address *</label>
<textarea class="form-control required" rows="2"></textarea>
</div>

<div class="mb-3">
<label class="form-label">Qualification *</label>
<select class="form-control required">
<option value="">Select Qualification</option>
<option>SSCE</option>
<option>ND</option>
<option>HND</option>
<option>BSc</option>
<option>MSc</option>
<option>PhD</option>
</select>
</div>

<div class="mb-3">
<label class="form-label">Course of Study</label>
<input type="text" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">Height (M)</label>
<input type="text" class="form-control">
</div>

<div class="mb-3">
<label class="form-label">State of Duty *</label>
<select class="form-control required">
<option>Edo</option>
<option>Lagos</option>
<option>Abuja</option>
</select>
</div>
</div>

<!-- STEP 3 -->
<div class="step">
<h5>Step 3: Next of Kin</h5>

<div class="mb-3">
<label class="form-label">Next of Kin *</label>
<input type="text" class="form-control required">
</div>

<div class="mb-3">
<label class="form-label">NOK Address *</label>
<textarea class="form-control required" rows="2"></textarea>
</div>

<div class="mb-3">
<label class="form-label">NOK Phone *</label>
<input type="text" class="form-control required">
</div>
</div>

<!-- BUTTONS -->
<div class="d-flex justify-content-between mt-3">
<button type="button" class="btn btn-secondary btn-sm" id="prevBtn" disabled>Previous</button>
<button type="button" class="btn btn-success btn-sm" id="nextBtn">Next</button>
</div>

</form>
</div>
</div>
</div>

<script src="views/assets/js/bootstrap.bundle.min.js"></script>

<script>
let currentStep=0;
const steps=document.querySelectorAll(".step");
const nextBtn=document.getElementById("nextBtn");
const prevBtn=document.getElementById("prevBtn");

function showStep(i){
  steps.forEach((s,idx)=>s.classList.toggle("active",idx===i));
  prevBtn.disabled=i===0;
  nextBtn.textContent=i===steps.length-1?"Submit":"Next";
}
showStep(currentStep);

function validateStep(step){
  let valid=true;
  step.querySelectorAll(".required").forEach(el=>{
    if(!el.value){
      el.classList.add("is-invalid");
      valid=false;
    }else{
      el.classList.remove("is-invalid");
    }
  });
  return valid;
}

nextBtn.onclick=()=>{
  if(!validateStep(steps[currentStep]))return;
  if(currentStep<steps.length-1){
    currentStep++;
    showStep(currentStep);
  }else{
    alert("Registration completed successfully");
    document.getElementById("regForm").reset();
    location.reload();
  }
};

prevBtn.onclick=()=>{
  currentStep--;
  showStep(currentStep);
};

/* PASSPORT PREVIEW */
const previewBox=document.getElementById("previewBox");
const passportInput=document.getElementById("passport");

previewBox.onclick=()=>passportInput.click();

passportInput.onchange=()=>{
  if(passportInput.files[0]){
    previewBox.innerHTML="";
    const img=document.createElement("img");
    img.src=URL.createObjectURL(passportInput.files[0]);
    previewBox.appendChild(img);
  }
};
</script>

</body>
</html>
