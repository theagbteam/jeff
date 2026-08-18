<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        <?= htmlspecialchars(
            $web_settings['company_alias'] . "-" . $page_name,
            ENT_QUOTES,
            'UTF-8'
        ); ?>
    </title>


    <!-- Bootstrap CSS -->
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
    <script src="views/inc/sweetalert/sweetalert2@11.js"></script>

    <script src="views/inc/sweetalert/jquery-3.6.4.min.js"></script>

    <link
        rel="stylesheet"
        href="views/inc/sweetalert/sweetalert2.min.css"
    >


    <style>

        /* =========================================================
           ROOT
        ========================================================= */

        :root {

            --primary: #082f63;
            --primary-dark: #041c3d;
            --primary-light: #0d4f9c;

            --background: #f4f7fb;
            --card: #ffffff;

            --text: #10233f;
            --muted: #718096;

            --border: #dce4ef;

            --input-bg: #ffffff;

            --button: #083b78;
            --button-hover: #062d5c;

            --shadow:
                0 25px 70px rgba(4, 28, 61, .18);
        }


        body.dark-mode {

            --primary: #0d4385;
            --primary-dark: #020c1c;
            --primary-light: #1761b3;

            --background: #020b18;
            --card: #07182d;

            --text: #f5f8ff;
            --muted: #aab7c9;

            --border: #1b3554;

            --input-bg: #091e36;

            --button: #0d4d91;
            --button-hover: #1260b2;

            --shadow:
                0 25px 70px rgba(0, 0, 0, .45);
        }



        /* =========================================================
           GLOBAL
        ========================================================= */

        * {
            box-sizing: border-box;
        }


        html,
        body {

            width: 100%;
            height: 100%;

            margin: 0;
            padding: 0;
        }


        body {

            min-height: 100vh;

            font-family:
                "Segoe UI",
                Roboto,
                Helvetica,
                Arial,
                sans-serif;

            background: var(--background);

            color: var(--text);

            overflow: hidden;

            transition:
                background .3s ease,
                color .3s ease;
        }



        /* =========================================================
           FULL PAGE
        ========================================================= */

        .page-container {

            width: 100vw;
            height: 100vh;

            min-height: 100vh;

            display: flex;

            margin: 0;
            padding: 0;

            background: var(--background);
        }



        /* =========================================================
           LEFT INCIDENT PANEL
        ========================================================= */

        .incident-panel {

            width: 50%;
            height: 100vh;

            position: relative;

            overflow: hidden;

            background:

                linear-gradient(
                    135deg,
                    rgba(3, 28, 60, .86),
                    rgba(4, 48, 98, .68)
                ),

                url("views/assets/img/loginbg.png");

            background-size: cover;

            background-position: center;

            display: flex;

            align-items: flex-end;

            color: white;
        }


        .incident-overlay {

            position: absolute;

            inset: 0;

            background:

                linear-gradient(
                    180deg,
                    rgba(3, 24, 52, .10) 0%,
                    rgba(2, 19, 42, .30) 45%,
                    rgba(1, 13, 30, .92) 100%
                );
        }


        .incident-content {

            position: relative;

            z-index: 2;

            width: 100%;

            padding: 55px;
        }


        .brand {

            position: absolute;

            top: 35px;
            left: 45px;

            display: flex;

            align-items: center;

            gap: 10px;

            font-size: 20px;

            font-weight: 700;

            letter-spacing: .3px;

            z-index: 5;
        }


        .brand-icon {

            width: 34px;
            height: 34px;

            border-radius: 10px;

            display: flex;

            align-items: center;
            justify-content: center;

            background: white;

            color: var(--primary);
        }


        .brand-icon img {

            width: 50px;
            height: 50px;

            object-fit: contain;
        }


        .incident-tag {

            display: inline-flex;

            align-items: center;

            gap: 8px;

            padding: 8px 14px;

            border-radius: 30px;

            background: rgba(255,255,255,.13);

            border:
                1px solid rgba(255,255,255,.24);

            backdrop-filter: blur(10px);

            font-size: 12px;

            margin-bottom: 18px;
        }


        .incident-tag i {

            color: #74b9ff;
        }


        .incident-content h2 {

            font-size:
                clamp(32px, 4vw, 56px);

            line-height: 1.05;

            font-weight: 750;

            margin: 0 0 18px;

            letter-spacing: -1.5px;
        }


        .incident-content p {

            max-width: 570px;

            color:
                rgba(255,255,255,.82);

            font-size: 16px;

            line-height: 1.7;

            margin-bottom: 28px;
        }


        .incident-features {

            display: flex;

            flex-wrap: wrap;

            gap: 10px;
        }


        .feature {

            display: flex;

            align-items: center;

            gap: 8px;

            padding: 9px 13px;

            border-radius: 8px;

            background:
                rgba(255,255,255,.09);

            border:
                1px solid rgba(255,255,255,.15);

            font-size: 12px;

            color:
                rgba(255,255,255,.92);
        }


        .feature i {

            color: #8fc8ff;
        }



        /* =========================================================
           RIGHT AUTH PANEL
        ========================================================= */

        .auth-panel {

            width: 50%;
            height: 100vh;

            min-height: 100vh;

            background: var(--card);

            position: relative;

            display: flex;

            flex-direction: column;

            overflow-y: auto;

            transition:
                background .3s ease;
        }



        /* =========================================================
           TOP CONTROLS
        ========================================================= */

        .top-controls {

            width: 100%;

            display: flex;

            justify-content: flex-end;

            align-items: center;

            gap: 10px;

            padding:
                24px 35px 0;

            flex-shrink: 0;
        }


        .control-button {

            width: 38px;
            height: 38px;

            border-radius: 10px;

            border:
                1px solid var(--border);

            background:
                var(--input-bg);

            color: var(--text);

            display: flex;

            align-items: center;
            justify-content: center;

            cursor: pointer;

            transition: .25s;
        }


        .control-button:hover {

            background: var(--primary);

            color: white;

            border-color:
                var(--primary);
        }



        /* =========================================================
           AUTH CONTENT
        ========================================================= */

        .auth-inner {

            width:
                min(470px, calc(100% - 70px));

            margin: auto;

            padding:
                25px 0 35px;
        }


        .welcome {

            text-align: center;

            margin-bottom: 30px;
        }


        .welcome > img {

            width: 55px;
            height: 55px;

            object-fit: contain;

            margin-bottom: 15px;
        }


        .welcome h2 {

            margin: 0 0 8px;

            font-size: 29px;

            font-weight: 750;

            letter-spacing: -.5px;
        }


        .welcome p {

            color: var(--muted);

            margin: 0;

            font-size: 14px;
        }



        /* =========================================================
           TABS
        ========================================================= */

        .auth-tabs {

            display: flex;

            background:
                var(--input-bg);

            border:
                1px solid var(--border);

            border-radius: 12px;

            padding: 4px;

            margin-bottom: 25px;
        }


        .auth-tab {

            width: 50%;

            border: 0;

            background: transparent;

            color: var(--muted);

            padding: 12px;

            border-radius: 9px;

            font-size: 13px;

            font-weight: 650;

            transition: .25s;

            cursor: pointer;
        }


        .auth-tab.active {

            background: var(--primary);

            color: white;

            box-shadow:
                0 5px 15px
                rgba(8,59,120,.18);
        }



        /* =========================================================
           FORMS
        ========================================================= */

        .form-section {

            display: none;
        }


        .form-section.active {

            display: block;
        }


        .form-label {

            font-size: 13px;

            font-weight: 650;

            color: var(--text);

            margin-bottom: 7px;
        }


        .input-group-custom {

            position: relative;

            margin-bottom: 18px;
        }


        .input-icon {

            position: absolute;

            left: 14px;

            top: 50%;

            transform:
                translateY(-50%);

            color: var(--muted);

            z-index: 5;
        }


        .form-control-custom {

            width: 100%;

            height: 48px;

            border:
                1px solid var(--border);

            border-radius: 9px;

            background:
                var(--input-bg);

            color: var(--text);

            padding:
                0 43px 0 42px;

            outline: none;

            font-size: 13px;

            transition: .25s;
        }


        .form-control-custom::placeholder {

            color: var(--muted);

            opacity: .8;
        }


        .form-control-custom:focus {

            border-color:
                var(--primary-light);

            box-shadow:
                0 0 0 3px
                rgba(13,79,156,.10);
        }


        .password-toggle {

            position: absolute;

            right: 14px;

            top: 50%;

            transform:
                translateY(-50%);

            color: var(--muted);

            cursor: pointer;

            z-index: 5;
        }



        /* =========================================================
           FORM OPTIONS
        ========================================================= */

        .form-options {

            display: flex;

            justify-content: space-between;

            align-items: center;

            gap: 8px;

            margin-bottom: 20px;

            font-size: 12px;

            flex-wrap: wrap;
        }


        .remember {

            display: flex;

            align-items: center;

            gap: 7px;

            color: var(--muted);
        }


        .remember input {

            accent-color:
                var(--primary);

            width: 14px;
            height: 14px;
        }


        .forgot {

            color:
                var(--primary-light);

            text-decoration: none;

            font-weight: 600;
        }


        .forgot:hover {

            text-decoration: underline;
        }



        /* =========================================================
           MAIN BUTTON
        ========================================================= */

        .main-button {

            width: 100%;

            height: 49px;

            border: 0;

            border-radius: 9px;

            background:

                linear-gradient(
                    135deg,
                    var(--button),
                    var(--primary-light)
                );

            color: white;

            font-size: 14px;

            font-weight: 700;

            letter-spacing: .2px;

            transition: .25s;

            box-shadow:
                0 10px 22px
                rgba(8,59,120,.18);

            cursor: pointer;
        }


        .main-button:hover {

            background:

                linear-gradient(
                    135deg,
                    var(--button-hover),
                    var(--primary)
                );

            transform:
                translateY(-1px);
        }



        /* =========================================================
           FOOTER
        ========================================================= */

        .auth-footer {

            text-align: center;

            margin-top: 24px;

            font-size: 11px;

            color: var(--muted);

            line-height: 1.6;
        }


        .auth-footer a {

            color:
                var(--primary-light);

            text-decoration: none;

            font-weight: 600;
        }



        /* =========================================================
           TERMS AGREEMENT
        ========================================================= */

        .terms-agreement {

            display: flex;

            align-items: flex-start;

            gap: 9px;

            color: var(--muted);

            font-size: 12px;

            line-height: 1.5;

            margin-bottom: 20px;
        }


        .terms-agreement input {

            width: 16px;
            height: 16px;

            margin-top: 2px;

            flex-shrink: 0;

            accent-color:
                var(--primary);

            cursor: pointer;
        }


        .terms-link {

            border: 0;

            padding: 0;

            background: transparent;

            color:
                var(--primary-light);

            font-weight: 700;

            text-decoration: underline;

            cursor: pointer;

            font-size: inherit;
        }


        .terms-link:hover {

            color: var(--primary);
        }



        /* =========================================================
           CUSTOM TERMS MODAL
        ========================================================= */

        .terms-modal-overlay {

            position: fixed;

            inset: 0;

            width: 100%;
            height: 100%;

            background:
                rgba(2, 12, 28, .72);

            backdrop-filter:
                blur(5px);

            -webkit-backdrop-filter:
                blur(5px);

            display: none;

            align-items: center;

            justify-content: center;

            padding: 20px;

            z-index: 99999;
        }


        .terms-modal-overlay.show {

            display: flex;
        }


        .terms-modal-box {

            width:
                min(850px, 100%);

            max-height:
                calc(100vh - 40px);

            background:
                var(--card);

            color:
                var(--text);

            border:
                1px solid var(--border);

            border-radius: 16px;

            box-shadow:
                0 30px 100px
                rgba(0,0,0,.35);

            display: flex;

            flex-direction: column;

            overflow: hidden;

            animation:
                termsModalOpen .18s ease-out;
        }


        @keyframes termsModalOpen {

            from {

                opacity: 0;

                transform:
                    translateY(15px)
                    scale(.98);
            }

            to {

                opacity: 1;

                transform:
                    translateY(0)
                    scale(1);
            }
        }


        .terms-modal-header {

            flex-shrink: 0;

            background:

                linear-gradient(
                    135deg,
                    var(--primary-dark),
                    var(--primary)
                );

            color: white;

            padding:
                18px 22px;

            display: flex;

            align-items: center;

            justify-content: space-between;

            gap: 15px;
        }


        .terms-modal-title {

            margin: 0;

            font-size: 18px;

            font-weight: 750;
        }


        .terms-modal-subtitle {

            display: block;

            margin-top: 4px;

            font-size: 11px;

            opacity: .75;
        }


        .terms-close-button {

            width: 36px;
            height: 36px;

            flex-shrink: 0;

            border: 0;

            border-radius: 8px;

            background:
                rgba(255,255,255,.10);

            color: white;

            font-size: 20px;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            transition: .2s;
        }


        .terms-close-button:hover {

            background:
                rgba(255,255,255,.22);
        }



        /* =========================================================
           TERMS SCROLL AREA
        ========================================================= */

        .terms-scroll-area {

            flex: 1;

            min-height: 0;

            overflow-y: auto;

            overscroll-behavior: contain;

            -webkit-overflow-scrolling: touch;
        }


        .terms-content {

            padding: 25px;

            font-size: 13px;

            line-height: 1.7;
        }


        .terms-content h5 {

            color: var(--text);

            font-size: 14px;

            font-weight: 750;

            margin-top: 22px;

            margin-bottom: 8px;
        }


        .terms-content h5:first-child {

            margin-top: 0;
        }


        .terms-content p {

            color: var(--muted);

            margin-bottom: 10px;
        }


        .terms-content ul {

            color: var(--muted);

            padding-left: 20px;

            margin-bottom: 10px;
        }


        .terms-content li {

            margin-bottom: 6px;
        }


        .terms-warning {

            background:
                rgba(255,193,7,.10);

            border:
                1px solid rgba(255,193,7,.30);

            color: var(--text);

            padding:
                13px 15px;

            border-radius: 10px;

            margin: 18px 0;
        }


        .terms-warning i {

            color: #d99b00;
        }



        /* =========================================================
           TERMS STATUS
        ========================================================= */

        .terms-scroll-status {

            flex-shrink: 0;

            background:
                var(--background);

            border-top:
                1px solid var(--border);

            padding:
                9px 20px;

            text-align: center;

            color: var(--muted);

            font-size: 11px;

            transition: .2s;
        }


        .terms-scroll-status.read {

            color: #198754;

            background:
                rgba(25,135,84,.08);
        }



        /* =========================================================
           TERMS FOOTER
        ========================================================= */

        .terms-modal-footer {

            flex-shrink: 0;

            border-top:
                1px solid var(--border);

            padding:
                14px 20px;

            background:
                var(--card);

            display: flex;

            justify-content: flex-end;

            align-items: center;

            gap: 10px;
        }


        .terms-cancel-button {

            border:
                1px solid var(--border);

            background:
                var(--input-bg);

            color:
                var(--text);

            border-radius: 8px;

            padding:
                10px 18px;

            font-size: 13px;

            font-weight: 600;

            cursor: pointer;
        }


        .terms-accept-button {

            border: 0;

            border-radius: 8px;

            padding:
                10px 18px;

            background:
                var(--primary);

            color: white;

            font-size: 13px;

            font-weight: 700;

            cursor: pointer;

            transition: .2s;
        }


        .terms-accept-button:hover:not(:disabled) {

            background:
                var(--primary-light);

            transform:
                translateY(-1px);
        }


        .terms-accept-button:disabled {

            opacity: .45;

            cursor: not-allowed;

            transform: none;
        }



        /* =========================================================
           PREVENT BACKGROUND SCROLL WHILE TERMS OPEN
        ========================================================= */

        body.terms-open {

            overflow: hidden !important;
        }



        /* =========================================================
           MOBILE
        ========================================================= */

        @media (max-width: 900px) {

            body {

                overflow: auto;
            }


            .page-container {

                width: 100%;

                min-height: 100vh;

                height: auto;

                display: block;
            }


            .incident-panel {

                display: none;
            }


            .auth-panel {

                width: 100%;

                min-height: 100vh;

                height: auto;

                overflow-y: auto;
            }


            .top-controls {

                padding:
                    18px 20px 0;
            }


            .auth-inner {

                width:
                    min(
                        470px,
                        calc(100% - 40px)
                    );

                padding-top: 20px;

                padding-bottom: 30px;
            }


            .welcome h2 {

                font-size: 26px;
            }


            .terms-modal-overlay {

                padding: 10px;
            }


            .terms-modal-box {

                max-height:
                    calc(100vh - 20px);

                border-radius: 12px;
            }


            .terms-content {

                padding: 20px;
            }
        }


        @media (max-width: 480px) {

            .auth-inner {

                width:
                    calc(100% - 30px);
            }


            .top-controls {

                padding-right: 15px;
            }


            .welcome {

                margin-bottom: 22px;
            }


            .welcome h2 {

                font-size: 24px;
            }


            .form-control-custom {

                height: 47px;
            }


            .form-options {

                flex-wrap: wrap;
            }


            .terms-modal-header {

                padding:
                    15px;
            }


            .terms-modal-title {

                font-size: 16px;
            }


            .terms-content {

                padding: 18px;

                font-size: 12.5px;
            }


            .terms-modal-footer {

                flex-direction: column;
            }


            .terms-modal-footer button {

                width: 100%;
            }
        }

    </style>

</head>


<body>


<?php

/* =========================================================
   SESSION MESSAGE
========================================================= */

$msgtext = '';

$url = '#';

$showAlert = false;


if (isset($_SESSION['error'])) {

    $msgtext = $_SESSION['error'];

    unset($_SESSION['error']);
}

?>


<div class="page-container">


    <!-- =====================================================
         LEFT PANEL
    ====================================================== -->

    <section class="incident-panel">


        <div class="incident-overlay"></div>


        <div class="brand">

            <div class="brand-icon">

                <img
                    src="views/uploads/img/logo.png"
                    alt="AICSS Logo"
                >

            </div>

            <span>AICSS</span>

        </div>


        <div class="incident-content">


            <div class="incident-tag">

                <i class="bi bi-exclamation-circle"></i>

                Incident Management System

            </div>


            <h2>

                <b>

                    Ai Consult & Security<br>

                    Services Ltd.

                </b>

            </h2>


            <p>

                Securely report incidents, suspicious activities,
                emergencies and other important events. Your report
                helps organizations respond quickly and take the
                appropriate action.

            </p>


            <div class="incident-features">


                <div class="feature">

                    <i class="bi bi-shield-lock"></i>

                    Secure Reporting

                </div>


                <div class="feature">

                    <i class="bi bi-clock-history"></i>

                    24/7 Access

                </div>


                <div class="feature">

                    <i class="bi bi-file-earmark-text"></i>

                    Track Reports

                </div>


            </div>


        </div>


    </section>



    <!-- =====================================================
         RIGHT PANEL
    ====================================================== -->

    <section class="auth-panel">


        <!-- TOP CONTROLS -->

        <div class="top-controls">


            <div
                id="google_translate_element"
                style="font-size:11px;"
            ></div>


            <button
                class="control-button"
                id="themeToggle"
                title="Switch theme"
                type="button"
            >

                <i
                    class="bi bi-moon-stars-fill"
                    id="themeIcon"
                ></i>

            </button>


        </div>



        <!-- AUTH -->

        <div class="auth-inner">


            <!-- WELCOME -->

            <div class="welcome">


                <img
                    src="views/uploads/img/logo.png"
                    alt="AICSS Logo"
                >


                <h2>
                    Welcome Back!
                </h2>


                <p>
                    Access your incident reporting account
                </p>


            </div>



            <!-- TABS -->

            <div class="auth-tabs">


                <button
                    class="auth-tab active"
                    id="loginTab"
                    type="button"
                >
                    LOGIN
                </button>


                <button
                    class="auth-tab"
                    id="signupTab"
                    type="button"
                >
                    SIGN UP
                </button>


            </div>



            <!-- =================================================
                 LOGIN
            ================================================== -->

            <div
                class="form-section active"
                id="loginForm"
            >


                <form
                    method="post"
                    enctype="multipart/form-data"
                >


                    <label class="form-label">
                        User ID
                    </label>


                    <div class="input-group-custom">


                        <i class="bi bi-person input-icon"></i>


                        <input
                            type="text"
                            name="userid"
                            class="form-control-custom"
                            placeholder="Enter your user ID"
                            required
                        >


                    </div>



                    <label class="form-label">
                        Password
                    </label>


                    <div class="input-group-custom">


                        <i class="bi bi-lock input-icon"></i>


                        <input
                            type="password"
                            name="password"
                            class="form-control-custom"
                            id="loginPassword"
                            placeholder="Enter your password"
                            required
                        >


                        <i
                            class="bi bi-eye password-toggle"
                            onclick="
                                togglePassword(
                                    'loginPassword',
                                    this
                                )
                            "
                        ></i>


                    </div>



                    <div class="form-options">


                        <label class="remember">

                            <input
                                type="radio"
                                name="role"
                                value="reporter"
                                checked
                            >

                            <b>Reporter</b>

                        </label>


                        <label class="remember">

                            <input
                                type="radio"
                                name="role"
                                value="admin"
                            >

                            <b>Admin</b>

                        </label>


                        <label class="remember">

                            <input
                                type="radio"
                                name="role"
                                value="dev"
                            >

                            <b>Developer</b>

                        </label>


                        <a
                            href="#"
                            class="forgot"
                        >
                            <b>Forgot password?</b>
                        </a>


                    </div>



                    <button
                        class="main-button"
                        type="submit"
                        name="login"
                    >

                        <i
                            class="bi bi-box-arrow-in-right me-2"
                        ></i>

                        Login to Account

                    </button>


                </form>



                <div class="auth-footer">


                    Don't have an account?


                    <a
                        href="#"
                        onclick="
                            switchToSignup();
                            return false;
                        "
                    >

                        Create an account

                    </a>


                </div>


            </div>



            <!-- =================================================
                 SIGNUP
            ================================================== -->

            <div
                class="form-section"
                id="signupForm"
            >


                <form
                    id="signupAccountForm"
                    method="post"
                >


                    <label class="form-label">
                        Full Name
                    </label>


                    <div class="input-group-custom">


                        <i class="bi bi-person input-icon"></i>


                        <input
                            type="text"
                            name="fullname"
                            class="form-control-custom"
                            placeholder="Enter your full name"
                            required
                        >


                    </div>



                    <label class="form-label">
                        Phone
                    </label>


                    <div class="input-group-custom">


                        <i
                            class="bi bi-telephone input-icon"
                        ></i>


                        <input
                            type="tel"
                            name="phone"
                            class="form-control-custom"
                            placeholder="Enter your phone number"
                            required
                        >


                    </div>



                    <label class="form-label">
                        Email Address
                    </label>


                    <div class="input-group-custom">


                        <i
                            class="bi bi-envelope input-icon"
                        ></i>


                        <input
                            type="email"
                            name="email"
                            class="form-control-custom"
                            placeholder="Enter your email"
                            required
                        >


                    </div>



                    <label class="form-label">
                        Password
                    </label>


                    <div class="input-group-custom">


                        <i
                            class="bi bi-lock input-icon"
                        ></i>


                        <input
                            type="password"
                            name="password"
                            class="form-control-custom"
                            id="signupPassword"
                            placeholder="Create a password"
                            required
                        >


                        <i
                            class="bi bi-eye password-toggle"
                            onclick="
                                togglePassword(
                                    'signupPassword',
                                    this
                                )
                            "
                        ></i>


                    </div>



                    <label class="form-label">
                        Confirm Password
                    </label>


                    <div class="input-group-custom">


                        <i
                            class="bi bi-lock-fill input-icon"
                        ></i>


                        <input
                            type="password"
                            name="confirm_password"
                            class="form-control-custom"
                            id="confirmPassword"
                            placeholder="Confirm your password"
                            required
                        >


                        <i
                            class="bi bi-eye password-toggle"
                            onclick="
                                togglePassword(
                                    'confirmPassword',
                                    this
                                )
                            "
                        ></i>


                    </div>



                    <!-- =================================================
                         TERMS CHECKBOX
                    ================================================== -->

                    <div class="terms-agreement">


                        <input
                            type="checkbox"
                            id="termsCheckbox"
                            name="terms_accepted"
                            value="1"
                            required
                        >


                        <span>


                            I confirm that I have read and agree to the


                            <button
                                type="button"
                                class="terms-link"
                                id="openTermsButton"
                            >

                                Incident Reporting Terms & Conditions

                            </button>


                            and agree to comply with the reporting
                            requirements of this system.


                        </span>


                    </div>



                    <button
                        class="main-button"
                        type="submit"
                        name="signup"
                    >

                        <i
                            class="bi bi-person-plus me-2"
                        ></i>

                        Create Account

                    </button>


                </form>



                <div class="auth-footer">


                    Already have an account?


                    <a
                        href="#"
                        onclick="
                            switchToLogin();
                            return false;
                        "
                    >

                        Login here

                    </a>


                </div>


            </div>


        </div>


    </section>


</div>



<!-- =============================================================
     CUSTOM TERMS MODAL
============================================================= -->

<div
    class="terms-modal-overlay"
    id="termsModal"
    aria-hidden="true"
>


    <div
        class="terms-modal-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="termsModalTitle"
    >


        <!-- HEADER -->

        <div class="terms-modal-header">


            <div>


                <h4
                    class="terms-modal-title"
                    id="termsModalTitle"
                >

                    <i
                        class="bi bi-shield-check me-2"
                    ></i>

                    Incident Reporting Terms & Conditions

                </h4>


                <span class="terms-modal-subtitle">

                    Please read all terms before accepting.

                </span>


            </div>


            <button
                type="button"
                class="terms-close-button"
                id="closeTermsTop"
                aria-label="Close"
            >

                <i class="bi bi-x-lg"></i>

            </button>


        </div>



        <!-- SCROLL CONTENT -->

        <div
            class="terms-scroll-area"
            id="termsScrollArea"
        >


            <div class="terms-content">


                <h5>
                    1. Purpose of the System
                </h5>


                <p>

                    This Incident Reporting System is provided to enable
                    authorized users to report incidents, accidents,
                    security concerns, suspicious activities, safety
                    issues, emergencies, policy violations and other
                    events requiring attention or investigation.

                </p>



                <h5>
                    2. Accurate and Honest Reporting
                </h5>


                <p>

                    All users are expected to provide information that is
                    truthful, accurate and complete to the best of their
                    knowledge.

                </p>


                <ul>

                    <li>
                        Do not knowingly submit false, misleading or
                        fabricated information.
                    </li>

                    <li>
                        Do not exaggerate or deliberately omit material
                        facts relating to an incident.
                    </li>

                    <li>
                        Where information is uncertain, clearly indicate
                        that it is an observation, assumption or
                        unconfirmed information.
                    </li>

                    <li>
                        Provide the date, time, location and relevant
                        details whenever reasonably available.
                    </li>

                </ul>



                <h5>
                    3. Good-Faith Reporting
                </h5>


                <p>

                    Reports should be submitted in good faith and for a
                    legitimate reporting, safety, security, compliance,
                    investigation or organizational purpose.

                </p>


                <p>

                    Users must not use the reporting system to harass,
                    threaten, intimidate, defame, discriminate against or
                    deliberately target another person.

                </p>



                <h5>
                    4. Emergency Situations
                </h5>


                <div class="terms-warning">

                    <i
                        class="bi bi-exclamation-triangle-fill me-2"
                    ></i>


                    <strong>Important:</strong>


                    This system should not be considered a replacement
                    for emergency services or immediate physical
                    assistance. If an incident presents an immediate
                    threat to life, health, safety or property, contact
                    the appropriate emergency service or responsible
                    authority immediately.

                </div>



                <h5>
                    5. Confidentiality and Sensitive Information
                </h5>


                <p>

                    Users should only provide information that is relevant
                    to the incident being reported.

                </p>


                <ul>

                    <li>
                        Do not unnecessarily include passwords,
                        authentication credentials or security keys.
                    </li>

                    <li>
                        Do not disclose private information about
                        individuals unless it is relevant and necessary
                        for the investigation.
                    </li>

                    <li>
                        Handle confidential information in accordance
                        with applicable organizational policies.
                    </li>

                </ul>



                <h5>
                    6. Evidence and Supporting Information
                </h5>


                <p>

                    Where permitted, users may provide relevant supporting
                    information such as photographs, documents,
                    timestamps, locations, witness information or other
                    evidence connected to the incident.

                </p>


                <p>

                    Users must not knowingly upload manipulated,
                    fraudulent, malicious or unrelated material.

                </p>



                <h5>
                    7. Prohibited Use
                </h5>


                <p>

                    The system must not be used for:

                </p>


                <ul>

                    <li>
                        Knowingly submitting false incident reports.
                    </li>

                    <li>
                        Harassment, retaliation or personal disputes.
                    </li>

                    <li>
                        Unauthorized access or attempts to access another
                        user's account.
                    </li>

                    <li>
                        Introducing malicious software, harmful code or
                        other security threats.
                    </li>

                    <li>
                        Circumventing system security or access controls.
                    </li>

                    <li>
                        Submitting spam or reports unrelated to the
                        purpose of the system.
                    </li>

                </ul>



                <h5>
                    8. Investigation and Administrative Review
                </h5>


                <p>

                    Submitted reports may be reviewed, categorized,
                    investigated, escalated, assigned to authorized
                    personnel and retained according to applicable
                    organizational procedures and retention requirements.

                </p>


                <p>

                    Submission of a report does not guarantee that a
                    particular action, disciplinary measure or outcome
                    will result.

                </p>



                <h5>
                    9. Confidentiality of Reports
                </h5>


                <p>

                    Access to reports may be restricted to authorized
                    personnel based on their responsibilities and access
                    privileges. Users should understand that information
                    submitted through the system may need to be disclosed
                    where required for legitimate investigations,
                    organizational processes or applicable law.

                </p>



                <h5>
                    10. Protection Against Retaliation
                </h5>


                <p>

                    Reports should be handled in accordance with applicable
                    organizational policies concerning confidentiality and
                    protection against retaliation. Users should report
                    concerns honestly and should not knowingly misuse the
                    system to make allegations against another person.

                </p>



                <h5>
                    11. User Account Security
                </h5>


                <p>

                    Users are responsible for maintaining the
                    confidentiality of their login credentials and must
                    immediately report suspected unauthorized access or
                    account compromise through the appropriate channel.

                </p>



                <h5>
                    12. System Monitoring and Audit
                </h5>


                <p>

                    For security, accountability and operational
                    purposes, system activity may be logged and audited
                    in accordance with applicable policies and
                    requirements. This may include account activity,
                    report submission information and system access
                    records.

                </p>



                <h5>
                    13. Privacy
                </h5>


                <p>

                    Personal information submitted through this system
                    will be handled according to the organization's
                    applicable privacy policies and legal requirements.
                    Users should avoid submitting personal information
                    that is not necessary for the incident report.

                </p>



                <h5>
                    14. Responsibility of the Reporter
                </h5>


                <p>

                    By submitting an incident report, the reporter
                    confirms that the information provided is accurate to
                    the best of their knowledge and that the report is
                    being submitted for a legitimate purpose.

                </p>



                <h5>
                    15. Changes to These Terms
                </h5>


                <p>

                    These terms may be updated from time to time to
                    reflect changes in organizational procedures,
                    security requirements, applicable law or system
                    functionality. Users may be required to review and
                    accept updated terms before continuing to use the
                    system.

                </p>



                <h5>
                    16. Acceptance
                </h5>


                <p>

                    By selecting the acceptance option during account
                    registration, you acknowledge that you have read,
                    understood and agreed to comply with these Incident
                    Reporting Terms & Conditions and the applicable rules
                    governing use of the reporting system.

                </p>



                <div class="terms-warning">

                    <i
                        class="bi bi-info-circle-fill me-2"
                    ></i>


                    <strong>Reporting Reminder:</strong>


                    Always provide factual information, distinguish
                    observations from assumptions, preserve relevant
                    evidence where appropriate, and use the correct
                    emergency channel when immediate assistance is
                    required.

                </div>



                <p
                    style="
                        margin-top:25px;
                        font-size:11px;
                        color:var(--muted);
                    "
                >

                    Last reviewed: August 2026

                </p>


            </div>


        </div>



        <!-- SCROLL STATUS -->

        <div
            class="terms-scroll-status"
            id="termsScrollStatus"
        >

            <i
                class="bi bi-arrow-down-circle me-1"
            ></i>

            Please scroll to the bottom to read all terms.

        </div>



        <!-- FOOTER -->

        <div class="terms-modal-footer">


            <button
                type="button"
                class="terms-cancel-button"
                id="closeTermsButton"
            >

                Close

            </button>


            <button
                type="button"
                class="terms-accept-button"
                id="acceptTermsButton"
                disabled
            >

                <i
                    class="bi bi-check-circle me-1"
                ></i>

                I Have Read & Agree

            </button>


        </div>


    </div>


</div>



<!-- =============================================================
     JAVASCRIPT
============================================================= -->

<script>


    /* =========================================================
       LOGIN / SIGNUP SWITCH
    ========================================================= */

    const loginTab =
        document.getElementById("loginTab");


    const signupTab =
        document.getElementById("signupTab");


    const loginForm =
        document.getElementById("loginForm");


    const signupForm =
        document.getElementById("signupForm");


    loginTab.addEventListener(
        "click",
        switchToLogin
    );


    signupTab.addEventListener(
        "click",
        switchToSignup
    );


    function switchToLogin() {

        loginTab.classList.add("active");

        signupTab.classList.remove("active");

        loginForm.classList.add("active");

        signupForm.classList.remove("active");

    }


    function switchToSignup() {

        signupTab.classList.add("active");

        loginTab.classList.remove("active");

        signupForm.classList.add("active");

        loginForm.classList.remove("active");

    }



    /* =========================================================
       PASSWORD VISIBILITY
    ========================================================= */

    function togglePassword(
        inputId,
        icon
    ) {

        const input =
            document.getElementById(inputId);


        if (!input) {
            return;
        }


        if (input.type === "password") {

            input.type = "text";


            icon.classList.remove(
                "bi-eye"
            );


            icon.classList.add(
                "bi-eye-slash"
            );

        } else {

            input.type = "password";


            icon.classList.remove(
                "bi-eye-slash"
            );


            icon.classList.add(
                "bi-eye"
            );

        }

    }



    /* =========================================================
       DARK / LIGHT MODE
    ========================================================= */

    const themeToggle =
        document.getElementById(
            "themeToggle"
        );


    const themeIcon =
        document.getElementById(
            "themeIcon"
        );


    const savedTheme =
        localStorage.getItem(
            "incidentTheme"
        );


    if (savedTheme === "dark") {

        document.body.classList.add(
            "dark-mode"
        );


        themeIcon.classList.remove(
            "bi-moon-stars-fill"
        );


        themeIcon.classList.add(
            "bi-sun-fill"
        );

    }


    themeToggle.addEventListener(
        "click",
        function() {

            document.body.classList.toggle(
                "dark-mode"
            );


            const dark =
                document.body.classList.contains(
                    "dark-mode"
                );


            localStorage.setItem(
                "incidentTheme",
                dark ? "dark" : "light"
            );


            if (dark) {

                themeIcon.classList.remove(
                    "bi-moon-stars-fill"
                );


                themeIcon.classList.add(
                    "bi-sun-fill"
                );

            } else {

                themeIcon.classList.remove(
                    "bi-sun-fill"
                );


                themeIcon.classList.add(
                    "bi-moon-stars-fill"
                );

            }

        }
    );



    /* =========================================================
       CUSTOM TERMS MODAL
    ========================================================= */

    const termsModal =
        document.getElementById(
            "termsModal"
        );


    const openTermsButton =
        document.getElementById(
            "openTermsButton"
        );


    const closeTermsButton =
        document.getElementById(
            "closeTermsButton"
        );


    const closeTermsTop =
        document.getElementById(
            "closeTermsTop"
        );


    const acceptTermsButton =
        document.getElementById(
            "acceptTermsButton"
        );


    const termsScrollArea =
        document.getElementById(
            "termsScrollArea"
        );


    const termsScrollStatus =
        document.getElementById(
            "termsScrollStatus"
        );


    const termsCheckbox =
        document.getElementById(
            "termsCheckbox"
        );


    let termsRead = false;



    /* =========================================================
       OPEN TERMS
    ========================================================= */

    function openTerms() {

        termsModal.classList.add("show");

        termsModal.setAttribute(
            "aria-hidden",
            "false"
        );


        document.body.classList.add(
            "terms-open"
        );


        /*
         * Always start at the top.
         */

        termsScrollArea.scrollTop = 0;


        /*
         * User must read/scroll to bottom
         * every time they open the terms.
         */

        termsRead = false;


        acceptTermsButton.disabled = true;


        termsScrollStatus.classList.remove(
            "read"
        );


        termsScrollStatus.innerHTML =

            '<i class="bi bi-arrow-down-circle me-1"></i>' +

            'Please scroll to the bottom to read all terms.';


        /*
         * Small timeout makes sure the browser
         * has completed layout before checking height.
         */

        setTimeout(
            function() {

                checkTermsRead();

            },
            100
        );

    }



    /* =========================================================
       CLOSE TERMS
    ========================================================= */

    function closeTerms() {

        termsModal.classList.remove(
            "show"
        );


        termsModal.setAttribute(
            "aria-hidden",
            "true"
        );


        document.body.classList.remove(
            "terms-open"
        );

    }



    /* =========================================================
       OPEN BUTTON
    ========================================================= */

    openTermsButton.addEventListener(
        "click",
        function(event) {

            event.preventDefault();

            openTerms();

        }
    );



    /* =========================================================
       CLOSE BUTTONS
    ========================================================= */

    closeTermsButton.addEventListener(
        "click",
        function() {

            closeTerms();

        }
    );


    closeTermsTop.addEventListener(
        "click",
        function() {

            closeTerms();

        }
    );



    /* =========================================================
       CLICK OUTSIDE MODAL
    ========================================================= */

    termsModal.addEventListener(
        "click",
        function(event) {

            if (
                event.target ===
                termsModal
            ) {

                closeTerms();

            }

        }
    );



    /* =========================================================
       ESC KEY
    ========================================================= */

    document.addEventListener(
        "keydown",
        function(event) {

            if (
                event.key === "Escape" &&
                termsModal.classList.contains("show")
            ) {

                closeTerms();

            }

        }
    );



    /* =========================================================
       CHECK IF USER REACHED BOTTOM
    ========================================================= */

    function checkTermsRead() {

        if (!termsScrollArea) {
            return;
        }


        const currentPosition =
            termsScrollArea.scrollTop +
            termsScrollArea.clientHeight;


        const totalHeight =
            termsScrollArea.scrollHeight;


        /*
         * 15px tolerance handles browser
         * rounding differences.
         */

        const reachedBottom =
            currentPosition >=
            totalHeight - 15;


        if (reachedBottom) {

            termsRead = true;


            acceptTermsButton.disabled =
                false;


            termsScrollStatus.classList.add(
                "read"
            );


            termsScrollStatus.innerHTML =

                '<i class="bi bi-check-circle-fill me-1"></i>' +

                'You have read all the terms. You may now accept them.';

        }

    }



    /* =========================================================
       SCROLL EVENT
    ========================================================= */

    termsScrollArea.addEventListener(
        "scroll",
        function() {

            checkTermsRead();

        }
    );



    /* =========================================================
       ACCEPT TERMS
    ========================================================= */

    acceptTermsButton.addEventListener(
        "click",
        function(event) {

            event.preventDefault();


            /*
             * Safety check.
             */

            if (!termsRead) {

                Swal.fire({

                    title:
                        "Please read the terms",

                    text:
                        "Scroll to the bottom of the Terms & Conditions before accepting them.",

                    icon:
                        "warning",

                    confirmButtonText:
                        "OK",

                    allowOutsideClick:
                        true,

                    allowEscapeKey:
                        true

                });


                return;

            }


            /*
             * CHECK THE CHECKBOX.
             */

            termsCheckbox.checked = true;


            /*
             * Trigger change event.
             */

            termsCheckbox.dispatchEvent(
                new Event(
                    "change",
                    {
                        bubbles: true
                    }
                )
            );


            /*
             * CLOSE THE CUSTOM MODAL.
             *
             * No Bootstrap modal code is used here.
             * This prevents the page freezing problem.
             */

            closeTerms();


            /*
             * Optional visual feedback.
             */

            setTimeout(
                function() {

                    termsCheckbox.focus();

                },
                50
            );

        }
    );



    /* =========================================================
       SIGNUP FORM VALIDATION
    ========================================================= */

    const signupAccountForm =
        document.getElementById(
            "signupAccountForm"
        );


    signupAccountForm.addEventListener(
        "submit",
        function(event) {


            const password =
                document.getElementById(
                    "signupPassword"
                ).value;


            const confirmPassword =
                document.getElementById(
                    "confirmPassword"
                ).value;



            /* -------------------------------------------------
               PASSWORD MATCH
            ------------------------------------------------- */

            if (
                password !==
                confirmPassword
            ) {

                event.preventDefault();


                Swal.fire({

                    title:
                        "Passwords do not match",

                    text:
                        "Please make sure both password fields contain the same password.",

                    icon:
                        "warning",

                    confirmButtonText:
                        "OK"

                });


                return false;
            }



            /* -------------------------------------------------
               TERMS ACCEPTANCE
            ------------------------------------------------- */

            if (
                !termsCheckbox.checked
            ) {

                event.preventDefault();


                Swal.fire({

                    title:
                        "Terms & Conditions required",

                    text:
                        "You must read and accept the Incident Reporting Terms & Conditions before creating an account.",

                    icon:
                        "warning",

                    showCancelButton:
                        true,

                    confirmButtonText:
                        "Read Terms",

                    cancelButtonText:
                        "Cancel",

                    allowOutsideClick:
                        true,

                    allowEscapeKey:
                        true

                }).then(
                    function(result) {

                        if (
                            result.isConfirmed
                        ) {

                            openTerms();

                        }

                    }
                );


                return false;
            }


            return true;

        }
    );



    /* =========================================================
       CHECKBOX CHANGE
    ========================================================= */

    termsCheckbox.addEventListener(
        "change",
        function() {

            if (
                this.checked
            ) {

                this.setAttribute(
                    "aria-checked",
                    "true"
                );

            } else {

                this.setAttribute(
                    "aria-checked",
                    "false"
                );

            }

        }
    );

</script>



<!-- =============================================================
     GOOGLE TRANSLATOR
============================================================= -->

<!--

<script>

function googleTranslateElementInit() {

    new google.translate.TranslateElement(

        {
            pageLanguage: "en",

            includedLanguages:
                "en,fr,es,pt,ar,ha,yo,ig",

            layout:
                google.translate.TranslateElement
                    .InlineLayout
                    .SIMPLE
        },

        "google_translate_element"
    );

}

</script>


<script
    src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"
></script>

-->



<!-- =============================================================
     PHP SESSION ALERT
============================================================= -->

<?php if (!empty($msgtext)): ?>

<script>

document.addEventListener(
    'DOMContentLoaded',
    function() {

        Swal.fire({

            title:
                'Notification',

            text:
                <?= json_encode(
                    $msgtext,
                    JSON_HEX_TAG |
                    JSON_HEX_APOS |
                    JSON_HEX_AMP |
                    JSON_HEX_QUOT
                ); ?>,

            icon:
                'info',

            confirmButtonText:
                'OK',

            allowOutsideClick:
                true,

            allowEscapeKey:
                true

        }).then(
            function(result) {

                if (
                    result.isConfirmed ||
                    result.dismiss
                ) {

                    const redirectUrl =
                        <?= json_encode($url); ?>;


                    if (
                        redirectUrl &&
                        redirectUrl !== '#'
                    ) {

                        window.location.href =
                            redirectUrl;

                    }

                }

            }
        );

    }
);

</script>

<?php endif; ?>



<!-- =============================================================
     OTHER JS
============================================================= -->

<script src="views/assets/js/jquery.dataTables.min.js"></script>

<script src="views/assets/js/dataTables.bootstrap5.min.js"></script>


</body>
</html>
