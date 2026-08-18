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