<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$password_generated = chr(rand(65, 90)) . str_pad(rand(0, 99999), 5, '0', STR_PAD_LEFT);

if (isset($_SESSION['success'])) {
    $msgtext = $_SESSION['success'];
    $url = "#";
    $showAlert = true;
    $alertType = 'success';
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    $msgtext = $_SESSION['error'];
    $url = "#";
    $showAlert = true;
    $alertType = 'error';
    unset($_SESSION['error']);
}

?>

<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password · Secure Account</title>

```
<script src="views/inc/dev/sweetalert/sweetalert2@11.js"></script>
<script src="views/inc/dev/sweetalert/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="views/inc/dev/sweetalert/sweetalert2.min.css">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,400;14..32,500;14..32,600&display=swap" rel="stylesheet">

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        background: linear-gradient(145deg, #f0f4fa 0%, #e6ecf5 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1.5rem;
        margin: 0;
        line-height: 1.5;
        color: #1f2937;
    }

    .card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(4px);
        width: 100%;
        max-width: 460px;
        border-radius: 2rem;
        box-shadow:
            0 25px 50px -12px rgba(0, 0, 0, 0.25),
            0 0 0 1px rgba(255, 255, 255, 0.6) inset,
            0 0 0 1px rgba(0, 0, 0, 0.02);
        padding: 2rem 2rem 2.2rem;
        transition: transform 0.2s ease;
    }

    .card:hover {
        transform: scale(1.005);
    }

    h1 {
        font-size: 1.85rem;
        font-weight: 600;
        letter-spacing: -0.02em;
        color: #0b1e33;
        margin-bottom: 0.35rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .subhead {
        font-size: 0.95rem;
        color: #64748b;
        margin-bottom: 2rem;
        border-left: 3px solid #3b82f6;
        padding-left: 0.75rem;
        font-weight: 400;
    }

    .form-group {
        margin-bottom: 1.6rem;
    }

    label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        margin-bottom: 0.45rem;
        color: #1e293b;
        letter-spacing: 0.01em;
    }

    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .input-icon {
        position: absolute;
        left: 1rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94a3b8;
        font-size: 1.1rem;
        pointer-events: none;
        transition: color 0.2s;
    }

    input {
        width: 100%;
        padding: 0.9rem 1rem 0.9rem 2.8rem;
        font-size: 0.95rem;
        font-family: inherit;
        border: 1.5px solid #e2e8f0;
        border-radius: 1.2rem;
        background: #ffffff;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
        color: #0f172a;
        font-weight: 450;
    }

    input:hover {
        border-color: #cbd5e1;
        background: #fefefe;
    }

    input:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
        background: #ffffff;
    }

    .input-wrapper:focus-within .input-icon {
        color: #3b82f6;
    }

    .toggle-password {
        position: absolute;
        right: 1rem;
        background: none;
        border: none;
        color: #94a3b8;
        font-size: 0.9rem;
        font-weight: 500;
        cursor: pointer;
        padding: 0.3rem 0.5rem;
        border-radius: 2rem;
        transition: color 0.2s, background 0.2s;
        display: flex;
        align-items: center;
        gap: 0.2rem;
        font-family: inherit;
    }

    .toggle-password:hover {
        color: #2563eb;
        background: #eff6ff;
    }

    .strength-meter {
        margin-top: 0.5rem;
        display: flex;
        gap: 0.4rem;
        align-items: center;
    }

    .strength-bar {
        height: 4px;
        flex: 1;
        border-radius: 4px;
        background: #e2e8f0;
        transition: background 0.2s ease;
    }

    .strength-bar.weak {
        background: #ef4444;
    }

    .strength-bar.fair {
        background: #f59e0b;
    }

    .strength-bar.good {
        background: #3b82f6;
    }

    .strength-bar.strong {
        background: #10b981;
    }

    .strength-text {
        font-size: 0.75rem;
        font-weight: 500;
        color: #64748b;
        min-width: 4.5rem;
        text-align: right;
    }

    .match-message {
        font-size: 0.8rem;
        margin-top: 0.4rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
        color: #ef4444;
        min-height: 1.25rem;
    }

    .match-message.ok {
        color: #10b981;
    }

    button.submit-btn {
        width: 100%;
        padding: 1rem;
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
        color: white;
        font-weight: 600;
        font-size: 1rem;
        border: none;
        border-radius: 1.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 10px 20px -5px rgba(37, 99, 235, 0.3);
        font-family: inherit;
        letter-spacing: 0.01em;
        margin-top: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    button.submit-btn:hover {
        background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 100%);
        box-shadow: 0 15px 25px -8px rgba(37, 99, 235, 0.5);
        transform: translateY(-1px);
    }

    button.submit-btn:active {
        transform: translateY(0.5px);
        box-shadow: 0 5px 12px -5px rgba(37, 99, 235, 0.4);
    }

    .form-footer {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.85rem;
        color: #64748b;
    }

    .form-footer a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 500;
        border-bottom: 1px dotted #93c5fd;
    }

    .form-footer a:hover {
        color: #1e40af;
        border-bottom-style: solid;
    }

    .error-hint {
        font-size: 0.75rem;
        color: #ef4444;
        margin-top: 0.25rem;
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    @media (max-width: 480px) {
        .card {
            padding: 1.6rem 1.4rem 1.8rem;
            border-radius: 1.8rem;
        }

        h1 {
            font-size: 1.65rem;
        }

        input {
            padding: 0.85rem 1rem 0.85rem 2.6rem;
        }

        .toggle-password {
            font-size: 0.8rem;
            right: 0.8rem;
        }
    }

    .icon-svg {
        width: 1.25rem;
        height: 1.25rem;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    @keyframes shake {
        0%, 100% {
            transform: translateX(0);
        }

        25% {
            transform: translateX(-4px);
        }

        75% {
            transform: translateX(4px);
        }
    }

    .shake {
        animation: shake 0.3s ease-in-out;
    }
</style>
```

</head>

<body>

<div class="card">

```
<h1>
    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#2563eb" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="margin-right: 4px;">
        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
    </svg>
    Change password
</h1>

<div class="subhead">Ensure your account stays secure</div>

<form id="passwordForm" action="index.php?action=compulsory_cp" method="post">

    <div class="form-group">

        <label for="newPassword">New password</label>

        <div class="input-wrapper">

            <span class="input-icon">
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    <circle cx="12" cy="16" r="1.2" fill="currentColor" stroke="none"></circle>
                </svg>
            </span>

            <input
                type="password"
                name="new_password"
                id="newPassword"
                placeholder="Create new password"
                autocomplete="new-password"
                required
            >

            <button
                type="button"
                class="toggle-password"
                data-target="newPassword"
                aria-label="Show password"
            >
                Show
            </button>

        </div>

        <div class="strength-meter" id="strengthMeter">
            <div class="strength-bar" id="bar1"></div>
            <div class="strength-bar" id="bar2"></div>
            <div class="strength-bar" id="bar3"></div>
            <div class="strength-bar" id="bar4"></div>
            <span class="strength-text" id="strengthText">—</span>
        </div>

        <div id="newError" class="error-hint"></div>

    </div>

    <div class="form-group">

        <label for="confirmPassword">Confirm new password</label>

        <div class="input-wrapper">

            <span class="input-icon">
                <svg class="icon-svg" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    <path d="M9 16l2 2 4-4" stroke="currentColor" stroke-width="2" fill="none"/>
                </svg>
            </span>

            <input
                type="password"
                name="verify_password"
                id="confirmPassword"
                placeholder="Confirm new password"
                autocomplete="new-password"
                required
            >

            <button
                type="button"
                class="toggle-password"
                data-target="confirmPassword"
                aria-label="Show password"
            >
                Show
            </button>

        </div>

        <div id="matchMessage" class="match-message"></div>

    </div>

    <input type="hidden" name="old_password" value="">

    <button
        type="submit"
        class="submit-btn"
        id="submitBtn"
        name="update_user_password"
    >
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M20 6L9 17l-5-5"></path>
        </svg>

        Update password
    </button>

</form>

<div class="form-footer">
    <a href="index.php?action=logout">Logout to main website</a>
</div>
```

</div>

<script>

(function() {

    const form = document.getElementById('passwordForm');
    const newInput = document.getElementById('newPassword');
    const confirmInput = document.getElementById('confirmPassword');
    const newError = document.getElementById('newError');
    const matchMessage = document.getElementById('matchMessage');

    const strengthBars = [
        document.getElementById('bar1'),
        document.getElementById('bar2'),
        document.getElementById('bar3'),
        document.getElementById('bar4')
    ];

    const strengthText = document.getElementById('strengthText');

    const toggleButtons = document.querySelectorAll('.toggle-password');

    toggleButtons.forEach(btn => {

        btn.addEventListener('click', function(e) {

            e.preventDefault();

            const targetId = this.getAttribute('data-target');
            const targetInput = document.getElementById(targetId);

            if (!targetInput) {
                return;
            }

            const type = targetInput.getAttribute('type') === 'password'
                ? 'text'
                : 'password';

            targetInput.setAttribute('type', type);

            this.textContent = type === 'password'
                ? 'Show'
                : 'Hide';

            this.setAttribute(
                'aria-label',
                type === 'password'
                    ? 'Show password'
                    : 'Hide password'
            );

        });

    });

    function evaluatePasswordStrength(password) {

        if (!password) {
            return {
                score: 0,
                label: '—',
                bars: 0
            };
        }

        let score = 0;

        if (password.length >= 8) {
            score++;
        }

        if (password.length >= 12) {
            score++;
        }

        if (/[a-z]/.test(password) && /[A-Z]/.test(password)) {
            score++;
        }

        if (/\d/.test(password)) {
            score++;
        }

        if (/[^A-Za-z0-9]/.test(password)) {
            score++;
        }

        const barScore = Math.min(score, 4);

        let label = 'Weak';

        if (score >= 5) {
            label = 'Strong';
        } else if (score >= 4) {
            label = 'Good';
        } else if (score >= 3) {
            label = 'Fair';
        } else if (score >= 1) {
            label = 'Weak';
        } else {
            label = '—';
        }

        if (password.length > 0 && password.length < 6) {
            return {
                score: 0,
                label: 'Weak',
                bars: 1
            };
        }

        return {
            score: score,
            label: label,
            bars: barScore
        };
    }

    function updateStrengthMeter() {

        const password = newInput.value;

        const result = evaluatePasswordStrength(password);

        const bars = result.bars;
        const label = result.label;

        strengthBars.forEach((bar, index) => {

            bar.className = 'strength-bar';

            if (index < bars) {

                if (label === 'Weak') {
                    bar.classList.add('weak');
                } else if (label === 'Fair') {
                    bar.classList.add('fair');
                } else if (label === 'Good') {
                    bar.classList.add('good');
                } else if (label === 'Strong') {
                    bar.classList.add('strong');
                }

            }

        });

        strengthText.textContent = label;
    }

    function checkMatch() {

        const newVal = newInput.value;
        const confirmVal = confirmInput.value;

        if (!confirmVal) {

            matchMessage.textContent = '';
            matchMessage.classList.remove('ok');

            return false;
        }

        if (newVal === confirmVal) {

            matchMessage.innerHTML = '✓ Passwords match';
            matchMessage.classList.add('ok');

            return true;

        } else {

            matchMessage.innerHTML = '✗ Passwords do not match';
            matchMessage.classList.remove('ok');

            return false;
        }
    }

    newInput.addEventListener('input', function() {

        updateStrengthMeter();

        if (newInput.value.length > 0 && newInput.value.length < 8) {

            newError.textContent = 'Password must be at least 8 characters.';

        } else {

            newError.textContent = '';

        }

        if (confirmInput.value) {
            checkMatch();
        }

    });

    confirmInput.addEventListener('input', checkMatch);

    form.addEventListener('submit', function(e) {

        newError.textContent = '';

        let isValid = true;

        const newPass = newInput.value;
        const confirmPass = confirmInput.value;

        if (!newPass) {

            newError.textContent = 'Please enter a new password.';
            isValid = false;

            newInput.classList.add('shake');

            setTimeout(function() {
                newInput.classList.remove('shake');
            }, 300);

        } else if (newPass.length < 8) {

            newError.textContent = 'Password must be at least 8 characters.';
            isValid = false;

            newInput.classList.add('shake');

            setTimeout(function() {
                newInput.classList.remove('shake');
            }, 300);
        }

        if (!confirmPass) {

            matchMessage.innerHTML = '✗ Please confirm your new password.';
            matchMessage.classList.remove('ok');

            isValid = false;

            confirmInput.classList.add('shake');

            setTimeout(function() {
                confirmInput.classList.remove('shake');
            }, 300);

        } else if (newPass !== confirmPass) {

            matchMessage.innerHTML = '✗ Passwords do not match';
            matchMessage.classList.remove('ok');

            isValid = false;

            confirmInput.classList.add('shake');

            setTimeout(function() {
                confirmInput.classList.remove('shake');
            }, 300);

        }

        if (!isValid) {

            e.preventDefault();
            return false;

        }

        /*
         * IMPORTANT:
         * Do NOT call e.preventDefault() here.
         *
         * The browser will now submit:
         *
         * new_password
         * verify_password
         * old_password
         * update_user_password
         *
         * to:
         *
         * index.php?action=compulsory_cp
         */

        return true;

    });

    updateStrengthMeter();

    if (newInput.value || confirmInput.value) {
        checkMatch();
    }

})();

</script>

<script>

document.addEventListener('DOMContentLoaded', function() {

<?php if (isset($showAlert) && $showAlert && isset($alertType) && $alertType === 'success'): ?>

    Swal.fire({
        title: 'Successful!',
        text: '<?= htmlspecialchars($msgtext, ENT_QUOTES, 'UTF-8'); ?>',
        icon: 'success',
        confirmButtonText: 'OK',
        allowOutsideClick: true,
        allowEscapeKey: true
    }).then(function(result) {

        if (result.isConfirmed || result.dismiss) {

            window.location.href =
                '<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>';

        }

    });

<?php elseif (isset($showAlert) && $showAlert && isset($alertType) && $alertType === 'error'): ?>

    Swal.fire({
        title: 'Error',
        text: '<?= htmlspecialchars($msgtext, ENT_QUOTES, 'UTF-8'); ?>',
        icon: 'error',
        confirmButtonText: 'OK',
        allowOutsideClick: true,
        allowEscapeKey: true
    }).then(function(result) {

        if (result.isConfirmed || result.dismiss) {

            window.location.href =
                '<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>';

        }

    });

<?php endif; ?>

});

</script>

</body>
</html>
