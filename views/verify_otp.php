<?php

if (session_status() === PHP_SESSION_NONE) {

    session_start();

}

/*
|--------------------------------------------------------------------------
| SESSION SUCCESS / ERROR MESSAGE
|--------------------------------------------------------------------------
*/

$msgtext = '';

$url = '#';

$showAlert = false;

$alertType = 'success';

if (isset($_SESSION['success'])) {

    $msgtext = $_SESSION['success'];

    $url = $_SESSION['url'] ?? '#';

    $showAlert = true;

    $alertType = 'success';

    unset(
        $_SESSION['success'],
        $_SESSION['url']
    );

}

if (isset($_SESSION['error'])) {

    $msgtext = $_SESSION['error'];

    $url = $_SESSION['url'] ?? '#';

    $showAlert = true;

    $alertType = 'error';

    unset(
        $_SESSION['error'],
        $_SESSION['url']
    );

}

/*
|--------------------------------------------------------------------------
| OTP PAGE DATA
|--------------------------------------------------------------------------
*/

$otp_refid = $_SESSION['otp_refid'] ?? '';

$otp_email = $_SESSION['otp_email'] ?? '';

/*
|--------------------------------------------------------------------------
| MASK EMAIL
|--------------------------------------------------------------------------
*/

$masked_email = '';

if (!empty($otp_email)) {

    $email_parts = explode('@', $otp_email);

    if (count($email_parts) === 2) {

        $email_username = $email_parts[0];

        $email_domain = $email_parts[1];

        if (strlen($email_username) > 2) {

            $masked_email =
                substr($email_username, 0, 2) .
                str_repeat('*', max(2, strlen($email_username) - 2)) .
                '@' .
                $email_domain;

        } else {

            $masked_email =
                substr($email_username, 0, 1) .
                '*@' .
                $email_domain;

        }

    } else {

        $masked_email = $otp_email;

    }

}

?>

<!DOCTYPE html>

<html lang="en">

<head>

<meta charset="UTF-8">

<meta
name="viewport"
content="width=device-width, initial-scale=1.0"

>

<title>Verify Your Account</title>

<!-- Bootstrap -->

<link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
>

<!-- Bootstrap Icons -->

<link
    rel="stylesheet"
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
>

<!-- SweetAlert -->

<script
    src="https://cdn.jsdelivr.net/npm/sweetalert2@11"
></script>

<style>

    :root {

        --primary: #0b63ce;

        --primary-dark: #084a9b;

        --primary-light: #eaf3ff;

        --background: #eef3f9;

        --card: #ffffff;

        --text: #182230;

        --muted: #758195;

        --border: #e2e8f0;

        --input-background: #f8fafc;

        --success: #198754;

        --shadow:
            0 24px 70px rgba(20, 43, 75, 0.14);

    }

    body.dark-mode {

        --background: #07111f;

        --card: #101b2b;

        --text: #f3f6fa;

        --muted: #9ba8ba;

        --border: #26374d;

        --input-background: #0b1625;

        --primary-light: rgba(13, 110, 253, 0.10);

        --shadow:
            0 25px 75px rgba(0, 0, 0, 0.45);

    }

    html,
    body {

        width: 100%;

        min-height: 100%;

        margin: 0;

        padding: 0;

    }

    body {

        min-height: 100vh;

        display: flex;

        align-items: center;

        justify-content: center;

        padding: 20px;

        font-family:
            Inter,
            -apple-system,
            BlinkMacSystemFont,
            "Segoe UI",
            Roboto,
            Helvetica,
            Arial,
            sans-serif;

        color: var(--text);

        background:
            radial-gradient(
                circle at 10% 15%,
                rgba(13, 110, 253, 0.11),
                transparent 30%
            ),
            radial-gradient(
                circle at 90% 85%,
                rgba(44, 116, 190, 0.10),
                transparent 32%
            ),
            linear-gradient(
                135deg,
                #edf3f9 0%,
                #f8fafc 50%,
                #e9f0f8 100%
            );

        transition:
            background 0.3s ease,
            color 0.3s ease;

        overflow-x: hidden;

    }

    body.dark-mode {

        background:
            radial-gradient(
                circle at 10% 15%,
                rgba(13, 110, 253, 0.15),
                transparent 30%
            ),
            radial-gradient(
                circle at 90% 85%,
                rgba(13, 110, 253, 0.10),
                transparent 32%
            ),
            linear-gradient(
                135deg,
                #050c16 0%,
                #091525 50%,
                #07111f 100%
            );

    }

    .background-shape {

        position: fixed;

        pointer-events: none;

        z-index: 0;

        border-radius: 50%;

    }

    .shape-one {

        width: 280px;

        height: 280px;

        top: -150px;

        left: -110px;

        background:
            rgba(13, 110, 253, 0.055);

    }

    .shape-two {

        width: 360px;

        height: 360px;

        right: -190px;

        bottom: -180px;

        background:
            rgba(13, 110, 253, 0.055);

    }

    .page-container {

        width: 100%;

        display: flex;

        align-items: center;

        justify-content: center;

        position: relative;

        z-index: 2;

    }

    .otp-card {

        width: 100%;

        max-width: 455px;

        background: var(--card);

        border: 1px solid var(--border);

        border-radius: 20px;

        box-shadow: var(--shadow);

        overflow: hidden;

        position: relative;

        transition:
            background 0.3s ease,
            border-color 0.3s ease,
            box-shadow 0.3s ease;

    }

    .card-accent {

        height: 4px;

        width: 100%;

        background:
            linear-gradient(
                90deg,
                #084a9b,
                #0b63ce,
                #4d9cf6
            );

    }

    .theme-toggle {

        position: absolute;

        top: 15px;

        right: 17px;

        width: 31px;

        height: 31px;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 50%;

        border: 1px solid var(--border);

        background: var(--input-background);

        color: var(--muted);

        font-size: 13px;

        cursor: pointer;

        z-index: 5;

        transition:
            color 0.2s ease,
            background 0.2s ease,
            border-color 0.2s ease;

    }

    .theme-toggle:hover {

        color: var(--primary);

        background: var(--primary-light);

        border-color:
            rgba(13, 110, 253, 0.20);

    }

    .otp-card-body {

        padding: 26px 31px 20px;

    }

    .otp-header {

        text-align: center;

        margin-bottom: 15px;

    }

    .brand-logo {

        width: 44px;

        height: 44px;

        object-fit: contain;

        margin-bottom: 6px;

    }

    .brand-name {

        font-size: 10px;

        font-weight: 700;

        letter-spacing: 1.4px;

        text-transform: uppercase;

        color: var(--muted);

        margin-bottom: 9px;

    }

    .shield-icon {

        width: 48px;

        height: 48px;

        display: flex;

        align-items: center;

        justify-content: center;

        margin: 0 auto 9px;

        border-radius: 14px;

        color: var(--primary);

        background: var(--primary-light);

        font-size: 22px;

        border:
            1px solid rgba(13, 110, 253, 0.08);

    }

    .otp-title {

        margin: 0 0 4px;

        font-size: 21px;

        font-weight: 700;

        letter-spacing: -0.25px;

        color: var(--text);

    }

    .otp-subtitle {

        margin: 0;

        font-size: 12.5px;

        line-height: 1.5;

        color: var(--muted);

    }

    .security-notice {

        display: flex;

        align-items: center;

        gap: 9px;

        padding: 9px 11px;

        margin: 14px 0 12px;

        border-radius: 9px;

        border:
            1px solid rgba(13, 110, 253, 0.10);

        background: var(--primary-light);

        color: var(--muted);

        font-size: 11px;

        line-height: 1.35;

    }

    .security-notice i {

        color: var(--primary);

        font-size: 15px;

        flex-shrink: 0;

    }

    .account-box {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 10px;

        padding: 9px 11px;

        margin-bottom: 15px;

        border-radius: 9px;

        border: 1px solid var(--border);

        background: var(--input-background);

    }

    .account-label {

        margin-bottom: 2px;

        font-size: 9px;

        font-weight: 600;

        letter-spacing: 0.8px;

        text-transform: uppercase;

        color: var(--muted);

    }

    .account-value {

        font-size: 12px;

        font-weight: 600;

        color: var(--text);

        word-break: break-word;

    }

    .account-icon {

        width: 30px;

        height: 30px;

        flex-shrink: 0;

        display: flex;

        align-items: center;

        justify-content: center;

        border-radius: 8px;

        color: var(--primary);

        background: var(--primary-light);

        font-size: 13px;

    }

    .otp-label {

        text-align: center;

        margin-bottom: 9px;

        font-size: 11.5px;

        font-weight: 600;

        color: var(--text);

    }

    .otp-input-container {

        display: flex;

        justify-content: center;

        gap: 7px;

        margin-bottom: 13px;

    }

    .otp-input {

        width: 48px;

        height: 51px;

        border: 1px solid var(--border);

        border-radius: 10px;

        background: var(--input-background);

        color: var(--text);

        text-align: center;

        font-size: 19px;

        font-weight: 700;

        outline: none;

        transition:
            border-color 0.2s ease,
            box-shadow 0.2s ease,
            background 0.2s ease;

    }

    .otp-input:focus {

        background: var(--card);

        border-color: var(--primary);

        box-shadow:
            0 0 0 3px rgba(13, 110, 253, 0.09);

    }

    .resend-area {

        text-align: center;

        margin: 2px 0 13px;

        font-size: 11px;

        color: var(--muted);

    }

    .resend-btn {

        padding: 0;

        border: 0;

        background: transparent;

        color: var(--primary);

        font-size: 11px;

        font-weight: 600;

        cursor: pointer;

        text-decoration: none;

    }

    .resend-btn:hover {

        text-decoration: underline;

    }

    .resend-btn.disabled {

        opacity: 0.65;

        cursor: not-allowed;

        text-decoration: none;

        pointer-events: none;

    }

    .verify-btn {

        width: 100%;

        height: 43px;

        border: 0;

        border-radius: 9px;

        background:
            linear-gradient(
                135deg,
                #084a9b,
                #0b63ce
            );

        color: #ffffff;

        font-size: 12.5px;

        font-weight: 600;

        letter-spacing: 0.1px;

        box-shadow:
            0 7px 18px rgba(11, 99, 206, 0.19);

        transition:
            transform 0.2s ease,
            box-shadow 0.2s ease,
            opacity 0.2s ease;

    }

    .verify-btn:hover {

        transform: translateY(-1px);

        box-shadow:
            0 9px 23px rgba(11, 99, 206, 0.25);

    }

    .verify-btn:disabled {

        opacity: 0.75;

        cursor: not-allowed;

        transform: none;

    }

    .back-login {

        text-align: center;

        margin-top: 13px;

    }

    .back-login a {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        gap: 5px;

        color: var(--muted);

        text-decoration: none;

        font-size: 11.5px;

        font-weight: 500;

        transition:
            color 0.2s ease;

    }

    .back-login a:hover {

        color: var(--primary);

    }

    .back-login i {

        font-size: 12px;

    }

    .otp-footer {

        margin-top: 14px;

        padding-top: 12px;

        border-top: 1px solid var(--border);

        text-align: center;

        color: var(--muted);

        font-size: 9.5px;

        line-height: 1.4;

    }

    .secure-status {

        display: inline-flex;

        align-items: center;

        gap: 4px;

        margin-top: 2px;

    }

    .secure-status i {

        color: var(--success);

        font-size: 10px;

    }

    @media (max-width: 500px) {

        body {

            padding: 14px;

        }

        .otp-card {

            max-width: 100%;

            border-radius: 18px;

        }

        .otp-card-body {

            padding: 23px 19px 17px;

        }

        .otp-input-container {

            gap: 5px;

        }

        .otp-input {

            width: 43px;

            height: 48px;

            font-size: 18px;

        }

        .otp-title {

            font-size: 20px;

        }

    }

    @media (max-width: 370px) {

        body {

            padding: 9px;

        }

        .otp-card-body {

            padding: 20px 14px 15px;

        }

        .otp-input-container {

            gap: 4px;

        }

        .otp-input {

            width: 39px;

            height: 45px;

            font-size: 17px;

        }

        .security-notice {

            font-size: 10.5px;

        }

    }

</style>

</head>

<body class="dark-mode">

<div class="background-shape shape-one"></div>

<div class="background-shape shape-two"></div>

<div class="page-container">

<div class="otp-card">


<div class="card-accent"></div>

<button
    type="button"
    class="theme-toggle"
    id="themeToggle"
    aria-label="Toggle theme"
>

    <i
        class="bi bi-sun-fill"
        id="themeIcon"
    ></i>

</button>

<div class="otp-card-body">

    <div class="otp-header">

        <?php if (!empty($company_logo)): ?>

            <img
                src="<?= htmlspecialchars($company_logo, ENT_QUOTES, 'UTF-8') ?>"
                alt="Company Logo"
                class="brand-logo"
            >

        <?php endif; ?>

        <?php if (!empty($company_alias)): ?>

            <div class="brand-name">

                <?= htmlspecialchars($company_alias, ENT_QUOTES, 'UTF-8') ?>

            </div>

        <?php endif; ?>

        <div class="shield-icon">

            <i class="bi bi-shield-lock-fill"></i>

        </div>

        <h1 class="otp-title">

            Verify Your Account

        </h1>

        <p class="otp-subtitle">

            Enter the 6-digit verification code

            sent to your email.

        </p>

    </div>

    <div class="security-notice">

        <i class="bi bi-shield-check"></i>

        <span>

            For your security, never share this

            verification code with anyone.

        </span>

    </div>

    <div class="account-box">

        <div class="account-icon">

            <i class="bi bi-person"></i>

        </div>

        <div
            class="account-info"
            style="
                flex: 1 !important;
                width: 100% !important;
                text-align: left !important;
            "
        >

            <div
                class="account-label"
                style="
                    width: 100% !important;
                    text-align: left !important;
                    display: block !important;
                "
            >

                <?= htmlspecialchars($user_name, ENT_QUOTES, 'UTF-8') ?>

            </div>

            <div
                class="account-value"
                style="
                    width: 100% !important;
                    text-align: left !important;
                    display: block !important;
                "
            >

                <?= htmlspecialchars($masked_email, ENT_QUOTES, 'UTF-8') ?>

            </div>

        </div>

    </div>

    <!-- OTP FORM -->

    <form
        id="otpVerificationForm"
        method="post"
        enctype="multipart/form-data"
        action="index?action=verify_otp"
        autocomplete="off"
    >

        <!-- ACTION TOKEN -->

        <input
            type="hidden"
            name="action_token"
            value="<?= htmlspecialchars(
                $_SESSION['action_token'] ?? '',
                ENT_QUOTES,
                'UTF-8'
            ) ?>"
        >

        <!-- OTP CODE -->

        <input
            type="hidden"
            name="otp_code"
            id="otp_code"
            value=""
        >

        <!-- CONFIRM RESEND OTP -->

       
        <div class="otp-label">

            Enter verification code

        </div>

        <div
            class="otp-input-container"
            id="otpInputContainer"
        >

            <input
                type="text"
                class="otp-input"
                maxlength="1"
                inputmode="numeric"
                autocomplete="one-time-code"
                aria-label="OTP digit 1"
            >

            <input
                type="text"
                class="otp-input"
                maxlength="1"
                inputmode="numeric"
                aria-label="OTP digit 2"
            >

            <input
                type="text"
                class="otp-input"
                maxlength="1"
                inputmode="numeric"
                aria-label="OTP digit 3"
            >

            <input
                type="text"
                class="otp-input"
                maxlength="1"
                inputmode="numeric"
                aria-label="OTP digit 4"
            >

            <input
                type="text"
                class="otp-input"
                maxlength="1"
                inputmode="numeric"
                aria-label="OTP digit 5"
            >

            <input
                type="text"
                class="otp-input"
                maxlength="1"
                inputmode="numeric"
                aria-label="OTP digit 6"
            >

        </div>

        <!-- RESEND OTP -->

        <div
            class="resend-area"
            id="resendArea"
        >

            Didn't receive the code?

            <a
                href="#"
                class="resend-btn"
                id="resendOtpBtn"
            >
                Resend OTP
            </a>

        </div>

        <!-- VERIFY OTP -->

        <button
            type="submit"
            class="verify-btn"
            id="verifyOtpBtn"
            name="verify_otp"
            value="1"
        >

            <span id="verifyButtonText">

                Verify OTP

            </span>

        </button>

        <!-- BACK TO LOGIN -->

        <div class="back-login">

            <a href="index?action=login">

                <i class="bi bi-arrow-left"></i>

                Back to Login

            </a>

        </div>

    </form>

    <div class="otp-footer">

        Your information is protected with secure verification.

        <div class="secure-status">

            <i class="bi bi-check-circle-fill"></i>

            Secure verification enabled

        </div>

    </div>

</div>


</div>

</div>

<script>

/*
|--------------------------------------------------------------------------
| OTP INPUT HANDLING
|--------------------------------------------------------------------------
*/

document.addEventListener(
    "DOMContentLoaded",
    function () {

        const otpInputs =
            document.querySelectorAll(
                ".otp-input"
            );

        const otpCode =
            document.getElementById(
                "otp_code"
            );

        const otpForm =
            document.getElementById(
                "otpVerificationForm"
            );

        const verifyButton =
            document.getElementById(
                "verifyOtpBtn"
            );

        const verifyButtonText =
            document.getElementById(
                "verifyButtonText"
            );

        const resendOtpBtn =
            document.getElementById(
                "resendOtpBtn"
            );

        /*
        |--------------------------------------------------------------------------
        | OTP INPUT
        |--------------------------------------------------------------------------
        */

        otpInputs.forEach(
            function (input, index) {

                input.addEventListener(
                    "input",
                    function () {

                        this.value =
                            this.value.replace(
                                /[^0-9]/g,
                                ""
                            );

                        if (
                            this.value &&
                            index <
                            otpInputs.length - 1
                        ) {

                            otpInputs[
                                index + 1
                            ].focus();

                        }

                    }
                );

                /*
                |--------------------------------------------------------------------------
                | KEYBOARD NAVIGATION
                |--------------------------------------------------------------------------
                */

                input.addEventListener(
                    "keydown",
                    function (event) {

                        if (
                            event.key ===
                            "Backspace" &&
                            !this.value &&
                            index > 0
                        ) {

                            otpInputs[
                                index - 1
                            ].focus();

                        }

                        if (
                            event.key ===
                            "ArrowLeft" &&
                            index > 0
                        ) {

                            otpInputs[
                                index - 1
                            ].focus();

                        }

                        if (
                            event.key ===
                            "ArrowRight" &&
                            index <
                            otpInputs.length - 1
                        ) {

                            otpInputs[
                                index + 1
                            ].focus();

                        }

                    }
                );

                /*
                |--------------------------------------------------------------------------
                | PASTE OTP
                |--------------------------------------------------------------------------
                */

                input.addEventListener(
                    "paste",
                    function (event) {

                        event.preventDefault();

                        const pastedData =
                            (
                                event.clipboardData ||
                                window.clipboardData
                            )
                            .getData("text")
                            .replace(
                                /[^0-9]/g,
                                ""
                            )
                            .substring(
                                0,
                                6
                            );

                        if (!pastedData) {

                            return;

                        }

                        for (
                            let i = 0;
                            i < pastedData.length;
                            i++
                        ) {

                            if (
                                otpInputs[i]
                            ) {

                                otpInputs[i].value =
                                    pastedData[i];

                            }

                        }

                        if (
                            pastedData.length ===
                            6
                        ) {

                            otpInputs[5].focus();

                        } else {

                            otpInputs[
                                pastedData.length
                            ].focus();

                        }

                    }
                );

            }
        );

        /*
        |--------------------------------------------------------------------------
        | RESEND OTP COUNTDOWN
        |--------------------------------------------------------------------------
        */

        const resendCooldownKey =
            "otp_resend_cooldown";

        const resendCooldown =
            31;

        let cooldownEnd =
            parseInt(
                localStorage.getItem(
                    resendCooldownKey
                ),
                10
            );

        function updateResendButton() {

            const currentTime =
                Date.now();

            const remainingMilliseconds =
                cooldownEnd - currentTime;

            const remainingSeconds =
                Math.ceil(
                    remainingMilliseconds / 1000
                );

            if (
                remainingSeconds > 0
            ) {

                resendOtpBtn.classList.add(
                    "disabled"
                );

                resendOtpBtn.setAttribute(
                    "aria-disabled",
                    "true"
                );

                resendOtpBtn.innerHTML =
                    'Resend OTP in <span id="resendCountdown">' +
                    remainingSeconds +
                    '</span>s';

                return true;

            }

            localStorage.removeItem(
                resendCooldownKey
            );

            resendOtpBtn.classList.remove(
                "disabled"
            );

            resendOtpBtn.removeAttribute(
                "aria-disabled"
            );

            resendOtpBtn.innerHTML =
                "Resend OTP";

            return false;

        }

        /*
        |--------------------------------------------------------------------------
        | CHECK EXISTING COUNTDOWN
        |--------------------------------------------------------------------------
        */

        if (
            !isNaN(cooldownEnd) &&
            cooldownEnd > Date.now()
        ) {

            updateResendButton();

            const resendTimer =
                setInterval(
                    function () {

                        if (
                            !updateResendButton()
                        ) {

                            clearInterval(
                                resendTimer
                            );

                        }

                    },
                    250
                );

        } else {

            localStorage.removeItem(
                resendCooldownKey
            );

            resendOtpBtn.classList.remove(
                "disabled"
            );

            resendOtpBtn.removeAttribute(
                "aria-disabled"
            );

            resendOtpBtn.innerHTML =
                "Resend OTP";

        }

        /*
        |--------------------------------------------------------------------------
        | RESEND OTP LINK
        |--------------------------------------------------------------------------
        */

        resendOtpBtn.addEventListener(
            "click",
            function (event) {

                event.preventDefault();

                /*
                |--------------------------------------------------------------------------
                | PREVENT MULTIPLE CLICKS
                |--------------------------------------------------------------------------
                */

                if (
                    resendOtpBtn.classList.contains(
                        "disabled"
                    )
                ) {

                    return;

                }

                /*
                |--------------------------------------------------------------------------
                | START 31 SECOND COOLDOWN
                |--------------------------------------------------------------------------
                */

                cooldownEnd =
                    Date.now() +
                    (
                        resendCooldown *
                        1000
                    );

                localStorage.setItem(
                    resendCooldownKey,
                    cooldownEnd
                );

                /*
                |--------------------------------------------------------------------------
                | DISABLE RESEND LINK
                |--------------------------------------------------------------------------
                */

                resendOtpBtn.classList.add(
                    "disabled"
                );

                resendOtpBtn.setAttribute(
                    "aria-disabled",
                    "true"
                );

                resendOtpBtn.textContent =
                    "Sending...";

                /*
                |--------------------------------------------------------------------------
                | CHANGE FORM ACTION
                |--------------------------------------------------------------------------
                */

                otpForm.action =
                    "index?action=resend_otp";

                /*
                |--------------------------------------------------------------------------
                | SUBMIT FORM
                |--------------------------------------------------------------------------
                */

                const resendInput =
                    document.createElement(
                        "input"
                    );

                resendInput.type =
                    "hidden";

                resendInput.name =
                    "resend_otp";

                resendInput.value =
                    "38299";

                otpForm.appendChild(
                    resendInput
                );

                otpForm.submit();

            }
        );

        /*
        |--------------------------------------------------------------------------
        | FORM SUBMIT
        |--------------------------------------------------------------------------
        */

        otpForm.addEventListener(
            "submit",
            function (event) {

                /*
                |--------------------------------------------------------------------------
                | VERIFY OTP SUBMISSION
                |--------------------------------------------------------------------------
                */

                let code = "";

                otpInputs.forEach(
                    function (input) {

                        code += input.value;

                    }
                );

                /*
                |--------------------------------------------------------------------------
                | VALIDATE OTP
                |--------------------------------------------------------------------------
                */

                if (
                    code.length !== 6 ||
                    !/^\d{6}$/.test(code)
                ) {

                    event.preventDefault();

                    Swal.fire({

                        icon: "warning",

                        title: "Incomplete OTP",

                        text:
                            "Please enter the complete 6-digit verification code.",

                        confirmButtonText: "OK",

                        confirmButtonColor:
                            "#0b63ce",

                        allowOutsideClick: true,

                        allowEscapeKey: true

                    });

                    return;

                }

                /*
                |--------------------------------------------------------------------------
                | STORE OTP
                |--------------------------------------------------------------------------
                */

                otpCode.value = code;

                /*
                |--------------------------------------------------------------------------
                | PREVENT MULTIPLE SUBMISSIONS
                |--------------------------------------------------------------------------
                */

                verifyButton.disabled = true;

                verifyButtonText.innerHTML =
                    '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>' +
                    'Processing...';

            }
        );

    }
);

/*
|--------------------------------------------------------------------------
| THEME TOGGLE
|--------------------------------------------------------------------------
*/

const themeToggle =
    document.getElementById(
        "themeToggle"
    );

const themeIcon =
    document.getElementById(
        "themeIcon"
    );

function applyTheme(theme) {

    if (theme === "dark") {

        document.body.classList.add(
            "dark-mode"
        );

        themeIcon.className =
            "bi bi-sun-fill";

    } else {

        document.body.classList.remove(
            "dark-mode"
        );

        themeIcon.className =
            "bi bi-moon-fill";

    }

}

const savedTheme =
    localStorage.getItem(
        "incidentTheme"
    );

/*
|--------------------------------------------------------------------------
| DEFAULT THEME - DARK MODE AS DEFAULT
|--------------------------------------------------------------------------
*/

if (savedTheme) {

    applyTheme(savedTheme);

} else {

    applyTheme("dark");

}

themeToggle.addEventListener(
    "click",
    function () {

        const isDark =
            document.body.classList.contains(
                "dark-mode"
            );

        const newTheme =
            isDark
                ? "light"
                : "dark";

        applyTheme(newTheme);

        localStorage.setItem(
            "incidentTheme",
            newTheme
        );

    }
);

/*
|--------------------------------------------------------------------------
| SWEETALERT SESSION MESSAGE
|--------------------------------------------------------------------------
*/

document.addEventListener(
    "DOMContentLoaded",
    function () {

        <?php if (!empty($showAlert) && !empty($msgtext)): ?>

        Swal.fire({

            title:
                <?= json_encode(
                    $alertType === 'success'
                        ? 'Successful!'
                        : 'Error'
                ) ?>,

            text:
                <?= json_encode(
                    htmlspecialchars(
                        $msgtext,
                        ENT_QUOTES,
                        'UTF-8'
                    )
                ) ?>,

            icon:
                <?= json_encode(
                    $alertType
                ) ?>,

            confirmButtonText:
                'OK',

            allowOutsideClick:
                true,

            allowEscapeKey:
                true

        }).then(function () {

            window.location.href =
                <?= json_encode($url) ?>;

        });

        <?php endif; ?>

    }
);

</script>

</body>

</html>