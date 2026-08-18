<?php

http_response_code(404);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $this->siteSettings['company_alias'] ?> - Page Not Found</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="Views/assets/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --nis-green: #0b6623;
      --nis-gold: #c9a100;
      --nis-light: #f5f8f5;
    }

    body {
      background: var(--nis-light);
      font-family: "Segoe UI", sans-serif;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      margin: 0;
    }

    .error-box {
      background: white;
      border-radius: 12px;
      padding: 40px;
      text-align: center;
      max-width: 480px;
      width: 100%;
      box-shadow: 0 10px 30px rgba(0,0,0,0.08);
    }

    .error-code {
      font-size: 6rem;
      font-weight: 800;
      color: var(--nis-green);
      margin-bottom: 10px;
    }

    .error-text {
      font-size: 1.4rem;
      font-weight: 600;
      margin-bottom: 10px;
    }

    .error-desc {
      color: #666;
      font-size: 0.95rem;
      margin-bottom: 25px;
    }

    .btn-dashboard {
      background: var(--nis-green);
      color: white;
      border-radius: 30px;
      padding: 10px 25px;
      font-weight: 600;
    }

    .btn-dashboard:hover {
      background: var(--nis-gold);
      color: white;
    }

    .logo {
      width: 70px;
      margin-bottom: 15px;
    }
  </style>
</head>

<body>

  <div class="error-box">
    <img src="Views/uploads/img/<?= $this->siteSettings['company_logo'] ?>" class="logo">

    <div class="error-code">404</div>
    <div class="error-text">Page Not Found</div>

    <p class="error-desc">
      The page you are trying to access does not exist or has been moved.
      Please check the URL or return to the dashboard.
    </p>

    <a href="index?action=dashboard" class="btn btn-dashboard">
      🎛️ Back to Dashboard
    </a>

    <div class="mt-4 text-muted small">
      <?= $this->siteSettings['company_alias'] ?> © <?= date('Y') ?>
    </div>
  </div>

</body>
</html>
