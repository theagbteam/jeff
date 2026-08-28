<?php

http_response_code(404);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?= $company_alias . " - " . $page_name; ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link href="Views/assets/css/bootstrap.min.css" rel="stylesheet">

  <style>
    :root {
      --nis-green: #0b6623;
      --nis-green-dark: #064518;
      --nis-gold: #c9a100;
      --nis-blue: #1769aa;
      --nis-blue-light: #eaf4ff;
      --nis-light: #f4f7fb;
      --nis-dark: #17202a;
      --nis-muted: #6b7280;
    }

    * {
      box-sizing: border-box;
    }

    body {
      min-height: 100vh;
      margin: 0;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 30px 15px;
      font-family: "Segoe UI", Arial, sans-serif;
      background:
        radial-gradient(circle at 10% 10%, rgba(23, 105, 170, 0.10), transparent 30%),
        radial-gradient(circle at 90% 90%, rgba(11, 102, 35, 0.10), transparent 30%),
        linear-gradient(135deg, #f8fafc 0%, #eef4f9 100%);
      color: var(--nis-dark);
      overflow: hidden;
    }

    /* Decorative background shapes */
    body::before,
    body::after {
      content: "";
      position: fixed;
      border-radius: 50%;
      z-index: -1;
      pointer-events: none;
    }

    body::before {
      width: 320px;
      height: 320px;
      top: -160px;
      right: -100px;
      background: rgba(23, 105, 170, 0.08);
      border: 1px solid rgba(23, 105, 170, 0.10);
    }

    body::after {
      width: 260px;
      height: 260px;
      bottom: -130px;
      left: -80px;
      background: rgba(11, 102, 35, 0.07);
      border: 1px solid rgba(11, 102, 35, 0.10);
    }

    .error-box {
      position: relative;
      width: 100%;
      max-width: 520px;
      padding: 48px 42px 35px;
      text-align: center;
      background: rgba(255, 255, 255, 0.96);
      border: 1px solid rgba(255, 255, 255, 0.8);
      border-radius: 22px;
      box-shadow:
        0 25px 60px rgba(15, 23, 42, 0.10),
        0 5px 15px rgba(15, 23, 42, 0.04);
      overflow: hidden;
    }

    /* Top accent line */
    .error-box::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      height: 5px;
      background: linear-gradient(
        90deg,
        var(--nis-green),
        var(--nis-blue),
        var(--nis-gold)
      );
    }

    .logo-wrapper {
      width: 86px;
      height: 86px;
      margin: 0 auto 18px;
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 20px;
      background: var(--nis-blue-light);
      border: 1px solid rgba(23, 105, 170, 0.10);
      box-shadow: 0 8px 20px rgba(23, 105, 170, 0.08);
    }

    .logo {
      width: 62px;
      height: 62px;
      object-fit: contain;
    }

    .error-code {
      position: relative;
      margin: 5px 0 0;
      font-size: clamp(5rem, 15vw, 7rem);
      line-height: 0.95;
      font-weight: 900;
      letter-spacing: -5px;

      /* Sophisticated blue/green gradient */
      background: linear-gradient(
        135deg,
        var(--nis-green-dark) 10%,
        var(--nis-blue) 60%,
        #2386c8 100%
      );

      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
    }

    .error-text {
      margin-top: 18px;
      margin-bottom: 10px;
      font-size: 1.45rem;
      font-weight: 700;
      color: var(--nis-dark);
      letter-spacing: -0.3px;
    }

    .error-desc {
      max-width: 400px;
      margin: 0 auto 28px;
      color: var(--nis-muted);
      font-size: 0.96rem;
      line-height: 1.7;
    }

    .btn-dashboard {
      position: relative;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      gap: 8px;
      min-width: 190px;
      padding: 12px 26px;
      border: none;
      border-radius: 50px;
      background: linear-gradient(
        135deg,
        var(--nis-green),
        var(--nis-blue)
      );
      color: #fff !important;
      font-size: 0.95rem;
      font-weight: 600;
      text-decoration: none;
      box-shadow: 0 8px 20px rgba(23, 105, 170, 0.22);
      transition: all 0.25s ease;
    }

    .btn-dashboard:hover {
      transform: translateY(-2px);
      color: #fff !important;
      background: linear-gradient(
        135deg,
        var(--nis-blue),
        var(--nis-green)
      );
      box-shadow: 0 12px 25px rgba(23, 105, 170, 0.30);
    }

    .btn-dashboard:active {
      transform: translateY(0);
    }

    .footer {
      margin-top: 28px;
      padding-top: 20px;
      border-top: 1px solid #edf0f3;
      color: #8a929d;
      font-size: 0.78rem;
    }

    .status-badge {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      margin-top: 18px;
      padding: 6px 12px;
      border-radius: 30px;
      background: #f1f8f3;
      color: var(--nis-green);
      font-size: 0.72rem;
      font-weight: 600;
    }

    .status-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--nis-green);
      box-shadow: 0 0 0 4px rgba(11, 102, 35, 0.08);
    }

    @media (max-width: 576px) {
      body {
        padding: 20px 12px;
      }

      .error-box {
        padding: 40px 25px 28px;
        border-radius: 18px;
      }

      .logo-wrapper {
        width: 75px;
        height: 75px;
      }

      .logo {
        width: 54px;
        height: 54px;
      }

      .error-text {
        font-size: 1.25rem;
      }

      .error-desc {
        font-size: 0.9rem;
      }
    }
  </style>
</head>

<body>

  <div class="error-box">

    <div class="logo-wrapper">
      <img
        src="views/uploads/img/<?= $company_logo ?>"
        class="logo"
        alt="<?= htmlspecialchars($company_alias) ?>"
      >
    </div>

    <div class="error-code">404</div>

    <div class="error-text">
      Page Not Found
    </div>

    <p class="error-desc">
      The page you are trying to access doesn't exist, may have been moved,
      or is temporarily unavailable. Please check the URL or return to the dashboard.
    </p>

    <a href="index?action=login" class="btn-dashboard">
      <span>←</span>
      <span>Back to Main website</span>
    </a>

    <div class="status-badge">
      <span class="status-dot"></span>
      System Ready
    </div>

    <div class="footer">
      <?= $company_alias ?> &copy; <?= $company_copyright ?>
    </div>

  </div>

</body>
</html>
