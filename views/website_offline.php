<!DOCTYPE html>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Under Maintenance</title>
  <!-- Bootstrap 5 (light version, but we override with dark green styles) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 (free) for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <!-- Google Font (Inter) for a modern, trustworthy look -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300..700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

```
body {
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
  background-color: #0b2b1e;  /* deep dark green base */
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1.5rem;
  /* subtle pattern overlay for depth */
  background-image: radial-gradient(circle at 20% 30%, rgba(30, 90, 60, 0.15) 0%, transparent 35%),
                    radial-gradient(circle at 90% 70%, rgba(20, 70, 45, 0.2) 0%, transparent 40%);
  background-attachment: fixed;
}

/* main card – dark green fill, gentle border and shadow */
.maintenance-card {
  background: #0f3b2a;   /* rich dark green fill */
  border: 1px solid #2a6e4e;
  border-radius: 2rem;
  box-shadow: 0 30px 45px -15px rgba(0, 0, 0, 0.6), 0 0 0 1px rgba(80, 180, 130, 0.15) inset;
  max-width: 680px;
  width: 100%;
  padding: 3rem 2.5rem;
  transition: transform 0.3s ease;
  backdrop-filter: blur(2px);
}

/* general icon container */
.bank-icon {
  width: 90px;
  height: 90px;
  background: rgba(30, 90, 60, 0.5);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1.8rem auto;
  border: 2px solid #34a56f;
  box-shadow: 0 0 20px rgba(52, 165, 111, 0.3);
}

.bank-icon i {
  font-size: 3.2rem;
  color: #b1e6c9;  /* soft minty green */
  filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.4));
}

/* headings */
h1 {
  font-size: 2.6rem;
  font-weight: 700;
  letter-spacing: -0.02em;
  color: #e7f7ee;  /* almost white with green tint */
  margin-bottom: 1rem;
  text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
}

.lead {
  font-size: 1.3rem;
  font-weight: 400;
  color: #b9e0ce;  /* soft sage green */
  margin-bottom: 2rem;
  line-height: 1.5;
}

/* divider with a subtle line */
.divider {
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 1.8rem 0 2rem 0;
}

.divider-line {
  width: 80px;
  height: 2px;
  background: linear-gradient(90deg, transparent, #3e9e73, #3e9e73, transparent);
  border-radius: 4px;
}

.divider i {
  color: #3e9e73;
  font-size: 1.2rem;
  margin: 0 1.2rem;
  opacity: 0.8;
}

/* maintenance progress / soft indicator */
.progress-container {
  width: 100%;
  background: rgba(10, 40, 28, 0.8);
  border-radius: 40px;
  padding: 0.3rem;
  margin: 2.2rem 0 2rem 0;
  border: 1px solid #2b6b4b;
}

.progress-bar-custom {
  height: 8px;
  border-radius: 40px;
  background: #266e4b;
  width: 100%;
  position: relative;
  overflow: hidden;
}

.progress-bar-custom::after {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  height: 100%;
  width: 60%;
  background: linear-gradient(90deg, #5bbd8a, #a3e0c0);
  border-radius: 40px;
  box-shadow: 0 0 12px #5bbd8a;
  animation: pulseWidth 2.4s infinite alternate ease-in-out;
}

@keyframes pulseWidth {
  0% { width: 40%; opacity: 0.8; }
  100% { width: 80%; opacity: 1; }
}

/* small text / footer inside card */
.footer-note {
  font-size: 0.95rem;
  color: #92bfab;
  margin-top: 2.2rem;
  margin-bottom: 0;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  gap: 1.5rem;
}

.footer-note span {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
}

.footer-note i {
  color: #52b788;
  font-size: 1rem;
}

/* contact / minimal links */
.contact-link {
  color: #a1d9be;
  text-decoration: none;
  font-weight: 500;
  border-bottom: 1px dashed #52b788;
  transition: color 0.2s, border-color 0.2s;
}

.contact-link:hover {
  color: #ffffff;
  border-bottom-color: #ffffff;
}

/* custom button just in case (not used, but for style consistency) */
.btn-outline-mint {
  border: 1px solid #52b788;
  color: #d0f0e0;
  padding: 0.6rem 2rem;
  border-radius: 40px;
  transition: all 0.2s;
}

.btn-outline-mint:hover {
  background: #1e5a3e;
  border-color: #7ed4a8;
  color: white;
}

/* fine print */
.fine-print {
  font-size: 0.8rem;
  color: #5f8f77;
  margin-top: 1rem;
  letter-spacing: 0.3px;
}

/* make the card a bit more responsive on small screens */
@media (max-width: 576px) {
  .maintenance-card {
    padding: 2.2rem 1.5rem;
    border-radius: 1.8rem;
  }

  h1 {
    font-size: 2rem;
  }

  .lead {
    font-size: 1.1rem;
  }

  .bank-icon {
    width: 75px;
    height: 75px;
  }

  .bank-icon i {
    font-size: 2.6rem;
  }

  .footer-note {
    flex-direction: column;
    gap: 0.8rem;
  }
}

/* custom dark green fill accents */
.glow-text {
  color: #d2f0e0;
}
```

  </style>
</head>
<body>
  <div class="maintenance-card text-center">
    <!-- General icon -->
    <div class="bank-icon">
      <i class="fas fa-university"></i>
    </div>

```
<!-- Headline -->
<h1>Under Maintenance</h1>

<!-- Subheadline / message -->
<p class="lead">
  Our systems are currently being upgraded.<br>
  We'll be back shortly — thank you for your patience.
</p>

<!-- decorative divider -->
<div class="divider">
  <span class="divider-line"></span>
  <i class="fas fa-shield-alt"></i>
  <span class="divider-line"></span>
</div>

<!-- subtle progress / activity indicator -->
<div class="progress-container">
  <div class="progress-bar-custom"></div>
</div>

<!-- Additional small info -->
<div class="footer-note">
  <span>
    <i class="fas fa-lock"></i> Secure
  </span>
  <span>
    <i class="fas fa-headset"></i> Support available
  </span>
  <span>
    <i class="fas fa-clock"></i> Back soon
  </span>
</div>

<!-- optional contact line (minimal) -->
<!--<p class="fine-print mt-4">-->
<!--  Need urgent assistance? -->
<!--  <a href="#" class="contact-link">Contact support</a> -->
<!--</p>-->
```

  </div>

  <!-- Bootstrap JS (optional, but not required for this static page) -->

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/6a7f095f9fa2631d420917eb/1k003p8e8';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>

</body>
</html>
