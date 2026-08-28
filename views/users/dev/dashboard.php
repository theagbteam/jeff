<?php

if (isset($_SESSION['success'])) {
    $msgtext = $_SESSION['success'];
    $url = "#";
    $showAlert = true;
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    $msgtext = $_SESSION['error'];
    $url = "#";
    $showAlert = false;
    unset($_SESSION['error']);
}

/*
 * ==========================================================
 * CURRENT PAGE / MENU ACTION
 * ==========================================================
 *
 * URL examples:
 *
 * index?action=dashboard
 * index?action=users
 * index?action=corridors
 *
 * The current action determines which sidebar item
 * receives the "active" class.
 *
 * IMPORTANT:
 * There is NO green background for the active item.
 * Only its text and icon become green.
 */

$current_action = isset($_GET['action'])
    ? trim($_GET['action'])
    : 'dashboard';

/*
 * If no action is supplied, or action=index,
 * Dashboard is treated as the current page.
 */
if ($current_action === '' || $current_action === 'index') {
    $current_action = 'dashboard';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no"
    >

    <title>
        <?= htmlspecialchars($company_alias) ?>
        -
        <?= ucfirst(htmlspecialchars($current_action)) ?>
    </title>

    <script src="views/inc/sweetalert/sweetalert2@11.js"></script>
    <script src="views/inc/sweetalert/jquery-3.6.4.min.js"></script>

    <link
        rel="stylesheet"
        href="views/inc/sweetalert/sweetalert2.min.css"
    >

    <link
        rel="stylesheet"
        href="views/assets/backend/vendors/mdi/css/materialdesignicons.min.css"
    >

    <link
        rel="stylesheet"
        href="views/assets/backend/vendors/ti-icons/css/themify-icons.css"
    >

    <link
        rel="stylesheet"
        href="views/assets/backend/vendors/css/vendor.bundle.base.css"
    >

    <link
        rel="stylesheet"
        href="views/assets/backend/vendors/font-awesome/css/font-awesome.min.css"
    >

    <link
        rel="stylesheet"
        href="views/assets/backend/vendors/jvectormap/jquery-jvectormap.css"
    >

    <link
        rel="stylesheet"
        href="views/assets/backend/vendors/flag-icon-css/css/flag-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="views/assets/backend/vendors/owl-carousel-2/owl.carousel.min.css"
    >

    <link
        rel="stylesheet"
        href="views/assets/backend/vendors/owl-carousel-2/owl.theme.default.min.css"
    >

    <link
        rel="stylesheet"
        href="views/assets/backend/css/style.css"
    >

    <!-- DataTables -->
    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css"
    >

    <link
        rel="shortcut icon"
        href="views/uploads/img/<?= htmlspecialchars($company_favicon) ?>"
    >


    <style>

        /* ==========================================================
           SIDEBAR MENU
           ========================================================== */

        .sidebar .nav .nav-item.menu-items {
            margin-bottom: 3px !important;
        }


        /*
         * ==========================================================
         * DEFAULT MENU LINK
         * ==========================================================
         *
         * IMPORTANT:
         * Background ALWAYS remains transparent.
         */

        .sidebar .nav .nav-item.menu-items .nav-link {
            background: transparent !important;
            color: #6c7293 !important;

            border-radius: 6px !important;

            padding: 10px 12px !important;

            transition:
                color 0.2s ease;
        }


        /*
         * ==========================================================
         * DEFAULT MENU TITLE
         * ==========================================================
         */

        .sidebar .nav .nav-item.menu-items .nav-link .menu-title {
            color: #6c7293 !important;

            line-height: 1.2 !important;

            white-space: nowrap;

            transition:
                color 0.2s ease;
        }


        /*
         * ==========================================================
         * MENU ICON CONTAINER
         * ==========================================================
         */

        .sidebar .nav .nav-item.menu-items .menu-icon {
            width: 42px !important;

            min-width: 42px !important;

            height: 34px !important;

            display: inline-flex !important;

            align-items: center !important;

            justify-content: center !important;

            margin-right: 4px !important;

            border-radius: 5px !important;

            background: transparent !important;
        }


        /*
         * ==========================================================
         * DEFAULT MENU ICON
         * ==========================================================
         */

        .sidebar .nav .nav-item.menu-items .menu-icon i {
            color: #6c7293 !important;

            font-size: 20px;

            line-height: 1 !important;

            transition:
                color 0.2s ease;
        }


        /*
         * ==========================================================
         * HOVER
         * ==========================================================
         *
         * Dashboard stays green.
         *
         * All other menu links and their corresponding icons
         * become green on mouse hover.
         *
         * NO background.
         */

        .sidebar .nav .nav-item.menu-items:not(.dashboard-menu):hover > .nav-link {
            background: transparent !important;
            color: #00d25b !important;
        }

        .sidebar .nav .nav-item.menu-items:not(.dashboard-menu):hover > .nav-link .menu-title {
            color: #00d25b !important;
        }

        .sidebar .nav .nav-item.menu-items:not(.dashboard-menu):hover > .nav-link .menu-icon i {
            color: #00d25b !important;
        }


        /*
         * ==========================================================
         * DASHBOARD MENU ITEM
         * ==========================================================
         *
         * Dashboard text and icon remain green.
         * NO background.
         */

        .sidebar .nav .nav-item.menu-items.dashboard-menu .nav-link {
            background: transparent !important;
            color: #00d25b !important;
        }

        .sidebar .nav .nav-item.menu-items.dashboard-menu .nav-link .menu-title {
            color: #00d25b !important;
        }

        .sidebar .nav .nav-item.menu-items.dashboard-menu .nav-link .menu-icon i {
            color: #00d25b !important;
        }


        /*
         * ==========================================================
         * OTHER ACTIVE ITEMS
         * ==========================================================
         *
         * Other menu items do not stay green when active.
         * They remain grey until hovered.
         * NO background.
         */

        .sidebar .nav .nav-item.menu-items.active > .nav-link:not([href="index?action=dashboard"]) {
            background: transparent !important;
            color: #6c7293 !important;
        }

        .sidebar .nav .nav-item.menu-items.active > .nav-link:not([href="index?action=dashboard"]) .menu-title {
            color: #6c7293 !important;
        }

        .sidebar .nav .nav-item.menu-items.active > .nav-link:not([href="index?action=dashboard"]) .menu-icon i {
            color: #6c7293 !important;
        }


        /*
         * ==========================================================
         * ACTIVE OTHER ITEMS - HOVER OVERRIDE
         * ==========================================================
         *
         * This comes after the active rules so hovering an
         * active menu item changes both text and icon to green.
         */

        .sidebar .nav .nav-item.menu-items.active:not(.dashboard-menu):hover > .nav-link {
            background: transparent !important;
            color: #00d25b !important;
        }

        .sidebar .nav .nav-item.menu-items.active:not(.dashboard-menu):hover > .nav-link .menu-title {
            color: #00d25b !important;
        }

        .sidebar .nav .nav-item.menu-items.active:not(.dashboard-menu):hover > .nav-link .menu-icon i {
            color: #00d25b !important;
        }


        /* ==========================================================
           UPPER RIGHT ACCOUNT MENU
           ========================================================== */

        .account-dropdown-wrapper {
            position: relative;
        }

        .account-dropdown-button {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 7px;
            min-height: 40px;
            white-space: nowrap;
        }

        .account-dropdown-button i {
            font-size: 20px;
            line-height: 1;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .account-dropdown-menu {
            min-width: 245px !important;
            padding: 8px 0 !important;
            margin-top: 8px !important;
        }

        .account-dropdown-menu .account-menu-item {
            display: flex !important;
            align-items: center !important;
            width: 100%;
            min-height: 55px;
            padding: 8px 16px !important;
            text-decoration: none !important;

            transition:
                background-color 0.2s ease,
                color 0.2s ease;
        }

        .account-dropdown-menu .account-menu-item:hover {
            background: #00d25b !important;
            color: #111318 !important;
        }

        .account-dropdown-menu .account-menu-item:hover p,
        .account-dropdown-menu .account-menu-item:hover i {
            color: #111318 !important;
        }

        .account-menu-icon {
            width: 38px;
            min-width: 38px;
            height: 38px;
            margin-right: 12px;
            border-radius: 50%;

            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .account-menu-icon i {
            font-size: 19px;
            line-height: 1;
            margin: 0 !important;
        }

        .account-menu-content {
            flex: 1;
            min-width: 0;

            display: flex;
            align-items: center;
        }

        .account-menu-content p {
            margin: 0 !important;
            padding: 0 !important;
            line-height: 1.3;
        }


        @media (max-width: 991px) {

            .account-dropdown-menu {
                position: absolute !important;
                right: 0 !important;
                left: auto !important;
            }

            .account-dropdown-button .account-button-text {
                display: none;
            }

            .account-dropdown-button {
                width: 42px;
                padding: 0 !important;
                gap: 0;
            }

        }


        @media (max-width: 575px) {

            .account-dropdown-menu {
                min-width: 230px !important;
                max-width: calc(100vw - 20px);
            }

            .account-dropdown-menu .account-menu-item {
                min-height: 52px;
                padding: 7px 13px !important;
            }

            .account-menu-icon {
                width: 36px;
                min-width: 36px;
                height: 36px;
                margin-right: 10px;
            }

        }


        /* ==========================================================
           REGISTRATION POPUP
           ========================================================== */

        .registration-popup {
            background: #191c24 !important;
            border: 1px solid rgba(255, 255, 255, 0.08) !important;
            border-radius: 12px !important;
            color: #ffffff !important;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.65) !important;
        }

        .registration-title {
            color: #ffffff !important;
            font-size: 22px !important;
            font-weight: 600 !important;
            margin-bottom: 5px !important;
        }

        .registration-html {
            color: #a7a7a7 !important;
        }

        .registration-label {
            display: block;
            text-align: left;
            color: #c9c9c9;
            font-size: 13px;
            font-weight: 500;
            margin: 0 0 7px 2px;
        }

        .registration-field {
            width: 100% !important;
            height: 46px !important;
            margin: 0 0 16px 0 !important;
            padding: 0 14px !important;

            border: 1px solid #343842 !important;
            border-radius: 6px !important;

            background: #101217 !important;
            color: #ffffff !important;

            font-size: 14px !important;

            outline: none !important;
            box-shadow: none !important;

            transition: all 0.2s ease;
        }

        .registration-field:focus {
            border-color: #00d25b !important;
            background: #12151b !important;

            box-shadow:
                0 0 0 2px rgba(0, 210, 91, 0.10) !important;
        }

        .registration-field::placeholder {
            color: #70747d !important;
        }

        .registration-field option {
            background: #191c24;
            color: #ffffff;
        }

        .registration-role-wrapper {
            position: relative;
        }

        .registration-role-wrapper .mdi {
            position: absolute;
            right: 14px;
            top: 15px;

            color: #00d25b;

            pointer-events: none;

            font-size: 18px;
        }

        .registration-header-icon {
            width: 52px;
            height: 52px;

            margin: 0 auto 12px;

            border-radius: 50%;

            background: rgba(0, 210, 91, 0.10);

            border: 1px solid rgba(0, 210, 91, 0.20);

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .registration-header-icon i {
            color: #00d25b;
            font-size: 25px;
        }

        .registration-role-display {
            display: inline-block;

            margin-top: 4px;

            padding: 4px 10px;

            border-radius: 20px;

            background: rgba(0, 210, 91, 0.10);

            color: #00d25b;

            font-size: 11px;
            font-weight: 600;
        }

        .registration-popup .swal2-actions {
            margin-top: 5px !important;
        }

        .registration-popup .swal2-confirm {
            background: #00d25b !important;
            color: #111318 !important;

            border-radius: 6px !important;

            font-weight: 600 !important;

            padding: 11px 25px !important;

            box-shadow: none !important;
        }

        .registration-popup .swal2-cancel {
            background: #2a2d35 !important;
            color: #ffffff !important;

            border-radius: 6px !important;

            font-weight: 500 !important;

            padding: 11px 22px !important;
        }

        @media (max-width: 576px) {

            .registration-popup {
                width: calc(100% - 25px) !important;
                padding: 22px 18px !important;
            }

            .registration-title {
                font-size: 20px !important;
            }

        }


        /* ==========================================================
           DASHBOARD DATA TABLE
           ========================================================== */

        .dashboard-datatable-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .dashboard-datatable {
            width: 100% !important;
            min-width: 850px;
            border-collapse: collapse;
            margin: 0 !important;
        }

        .dashboard-datatable thead th {
            background: #191c24 !important;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 600;
            padding: 14px 15px;
            border: 0 !important;
            white-space: nowrap;
        }

        .dashboard-datatable tbody td {
            color: #a7a7a7 !important;
            font-size: 13px;
            padding: 14px 15px;
            border-top: 1px solid rgba(255, 255, 255, 0.06) !important;
            vertical-align: middle;
            white-space: nowrap;
        }

        .dashboard-datatable tbody tr {
            transition: background-color 0.2s ease;
        }

        .dashboard-datatable tbody tr:hover {
            background: rgba(255, 255, 255, 0.025) !important;
        }

        .dashboard-table-user {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dashboard-table-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
        }

        .dashboard-table-user-name {
            color: #ffffff !important;
            font-weight: 500;
        }

        .dashboard-table-user-email {
            color: #6c7293 !important;
            font-size: 11px;
            margin-top: 2px;
        }

        .dashboard-status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .dashboard-status-active {
            color: #00d25b !important;
            background: rgba(0, 210, 91, 0.10);
        }

        .dashboard-status-pending {
            color: #ffab00 !important;
            background: rgba(255, 171, 0, 0.10);
        }

        .dashboard-status-inactive {
            color: #ff4747 !important;
            background: rgba(255, 71, 71, 0.10);
        }

        .dashboard-role {
            color: #00d25b !important;
            font-weight: 500;
        }

        .dashboard-table-action {
            width: 34px;
            height: 34px;

            border: 0;
            border-radius: 5px;

            background: #191c24;
            color: #6c7293;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;

            transition: all 0.2s ease;
        }

        .dashboard-table-action:hover {
            background: #00d25b;
            color: #111318;
        }


        /* ==========================================================
           DATATABLE CONTROLS
           ========================================================== */

        .dataTables_wrapper {
            color: #a7a7a7 !important;
            font-size: 13px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 15px;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: #101217 !important;
            border: 1px solid #343842 !important;
            border-radius: 5px !important;
            color: #ffffff !important;
            outline: none !important;
            padding: 7px 10px !important;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-left: 8px !important;
        }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #00d25b !important;
        }

        .dataTables_wrapper .dataTables_info {
            color: #6c7293 !important;
            padding-top: 15px !important;
        }

        .dataTables_wrapper .dataTables_paginate {
            padding-top: 12px !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            min-width: 32px !important;
            height: 32px !important;

            padding: 6px 9px !important;
            margin-left: 4px !important;

            border: 1px solid #343842 !important;
            border-radius: 4px !important;

            background: #191c24 !important;
            color: #a7a7a7 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: #00d25b !important;
            border-color: #00d25b !important;
            color: #111318 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current,
        .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
            background: #00d25b !important;
            border-color: #00d25b !important;
            color: #111318 !important;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: #191c24 !important;
            border-color: #343842 !important;
            color: #555b68 !important;
        }

        table.dataTable.no-footer {
            border-bottom: 1px solid rgba(255, 255, 255, 0.06) !important;
        }

        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            color: #ffffff !important;
        }


        @media (max-width: 767px) {

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                float: none !important;
                text-align: left !important;
                width: 100%;
            }

            .dataTables_wrapper .dataTables_filter {
                margin-top: 12px;
            }

            .dataTables_wrapper .dataTables_filter input {
                width: calc(100% - 70px);
            }

            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                float: none !important;
                text-align: center !important;
            }

        }

    </style>

</head>


<body>

<div class="container-scroller">


    <div
        class="row p-0 m-0 proBanner"
        id="proBanner"
    >

        <div class="col-md-12 p-0 m-0"></div>

    </div>


    <!-- ==========================================================
         SIDEBAR
         ========================================================== -->

    <nav
        class="sidebar sidebar-offcanvas"
        id="sidebar"
    >

        <div
            class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top"
        >

            <a
                class="sidebar-brand brand-logo"
                style="color:aliceblue; text-decoration:none;"
                href="index?action=index"
            >

                <img
                    style="
                        width:50px !important;
                        height:50px !important;
                        object-fit:contain !important;
                    "
                    src="views/uploads/img/<?= htmlspecialchars($company_logo) ?>"
                    alt="logo"
                >

                <?= htmlspecialchars($company_alias) ?>

            </a>


            <a
                class="sidebar-brand brand-logo-mini"
                href="index?action=index"
            >

                <img
                    src="views/uploads/img/<?= htmlspecialchars($company_logo) ?>"
                    alt="logo"
                >

            </a>

        </div>


        <ul class="nav">


            <li class="nav-item profile">

                <div class="profile-desc">

                    <div class="profile-pic">

                        <div class="count-indicator">

                            <img
                                class="img-xs rounded-circle"
                                src="views/uploads/img/profile//<?= $user_image ?>"
                                alt=""
                            >

                            <span class="count bg-success"></span>

                        </div>


                        <div class="profile-name">

                            <h5 class="mb-0 font-weight-normal">

                                <?= htmlspecialchars($AbrvName) ?>

                            </h5>

                            <span>

                                <?= ucfirst(htmlspecialchars($role)) ?>

                            </span>

                        </div>

                    </div>

                </div>

            </li>


            <li class="nav-item nav-category">

                <span class="nav-link">
                    Navigation
                </span>

            </li>


            <!-- ==================================================
                 DASHBOARD
                 ================================================== -->

            <li
                class="nav-item menu-items dashboard-menu <?= $current_action === 'dashboard' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=dashboard"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-speedometer"></i>

                    </span>


                    <span class="menu-title">

                        Dashboard

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 USERS
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'users' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=users"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-account-multiple"></i>

                    </span>


                    <span class="menu-title">

                        Users

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 RECYCLE
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'deleted_items' ? 'active' : '' ?>"
            >

                <!--
                <a
                    class="nav-link"
                    href="index?action=deleted_items"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-delete"></i>

                    </span>


                    <span class="menu-title">

                        Recycle

                    </span>

                </a>
                -->

            </li>


            <!-- ==================================================
                 CORRIDORS
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'corridors' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=corridors"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-road-variant"></i>

                    </span>


                    <span class="menu-title">

                        Corridors

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 INCIDENCE SOURCE
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'incidence_source' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=incidence_source"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-source-branch"></i>

                    </span>


                    <span class="menu-title">

                        Incidence Source

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 OPERATORS
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'operators' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=operators"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-account-hard-hat"></i>

                    </span>


                    <span class="menu-title">

                        Operators

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 OWNERS
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'owners' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=owners"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-account-star"></i>

                    </span>


                    <span class="menu-title">

                        Owners

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 PIPELINES
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'pipelines' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=pipelines"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-pipe"></i>

                    </span>


                    <span class="menu-title">

                        Pipelines

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 PIPELINE TYPES
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'pipeline_types' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=pipeline_types"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-pipe-disconnected"></i>

                    </span>


                    <span class="menu-title">

                        Pipeline Types

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 PRIORITY
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'priority' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=priority"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-alert-circle"></i>

                    </span>


                    <span class="menu-title">

                        Priority

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 ZONES
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'zones' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=zones"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-map-marker-multiple"></i>

                    </span>


                    <span class="menu-title">

                        Zones

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 WELLHEAD STATUS
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'wellhead_status' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=wellhead_status"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-oil"></i>

                    </span>


                    <span class="menu-title">

                        Wellhead Status

                    </span>

                </a>

            </li>


            <!-- ==================================================
                 REPORT TYPES
                 ================================================== -->

            <li
                class="nav-item menu-items <?= $current_action === 'report_types' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=report_types"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-file-chart"></i>

                    </span>


                    <span class="menu-title">

                        Report Types

                    </span>

                </a>

            </li>


        </ul>

    </nav>


    <!-- ==========================================================
         PAGE BODY
         ========================================================== -->

    <div class="container-fluid page-body-wrapper">


        <!-- ======================================================
             TOP NAVBAR
             ====================================================== -->

        <nav class="navbar p-0 fixed-top d-flex flex-row">


            <div
                class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center"
            >

                <a
                    class="navbar-brand brand-logo-mini"
                    href="index?action=index"
                    style="color:aliceblue !important;"
                >

                    <img
                        style="
                            width:80px !important;
                            height:50px !important;
                            object-fit:contain !important;
                        "
                        src="views/uploads/img/<?= htmlspecialchars($company_logo) ?>"
                        alt="logo"
                    >

                    <?= htmlspecialchars($company_alias) ?>

                </a>

            </div>


            <div
                class="navbar-menu-wrapper flex-grow d-flex align-items-stretch"
            >


                <button
                    class="navbar-toggler navbar-toggler align-self-center"
                    type="button"
                    data-toggle="minimize"
                >

                    <span class="mdi mdi-menu"></span>

                </button>


                <ul class="navbar-nav w-100">

                    <li class="nav-item w-100"></li>

                </ul>


                <ul class="navbar-nav navbar-nav-right">


                    <!-- ==================================================
                         CREATE USER
                         ================================================== -->

                    <li class="nav-item dropdown">

                        <a
                            class="nav-link btn btn-success create-new-button"
                            id="createbuttonDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            href="#"
                        >

                            + Create User

                        </a>


                        <div
                            class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list"
                            aria-labelledby="createbuttonDropdown"
                        >

                            <div class="dropdown-divider"></div>

                            <div class="dropdown-divider"></div>


                            <a
                                href="#"
                                class="dropdown-item preview-item register-user-btn"
                                data-role="2"
                            >

                                <div class="preview-thumbnail">

                                    <div class="preview-icon bg-dark rounded-circle">

                                        <i class="mdi mdi-layers text-danger"></i>

                                    </div>

                                </div>


                                <div class="preview-item-content">

                                    <p class="preview-subject ellipsis mb-1">

                                        Administrator

                                    </p>

                                </div>

                            </a>

                        </div>

                    </li>


                    <!-- ==================================================
                         ACCOUNT MENU
                         ================================================== -->

                    <li class="nav-item dropdown account-dropdown-wrapper">

                        <a
                            class="nav-link account-dropdown-button"
                            href="#"
                            id="accountDropdown"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                            title="Account"
                        >

                            <i class="mdi mdi-account-circle"></i>

                            <span class="account-button-text">
                                Account
                            </span>

                            <i
                                class="mdi mdi-chevron-down"
                                style="font-size:16px;"
                            ></i>

                        </a>


                        <div
                            class="dropdown-menu dropdown-menu-end navbar-dropdown account-dropdown-menu"
                            aria-labelledby="accountDropdown"
                        >

                            <div class="dropdown-divider"></div>


                            <a
                                href="#"
                                class="dropdown-item account-menu-item"
                            >

                                <div class="account-menu-icon bg-dark">

                                    <i class="mdi mdi-onepassword text-info"></i>

                                </div>


                                <div class="account-menu-content">

                                    <p class="preview-subject text-small">

                                        Change Password

                                    </p>

                                </div>

                            </a>


                            <div class="dropdown-divider"></div>


                            <a
                                href="#"
                                class="dropdown-item account-menu-item"
                            >

                                <div class="account-menu-icon bg-dark">

                                    <i class="mdi mdi-delete text-success"></i>

                                </div>


                                <div class="account-menu-content">

                                    <p class="preview-subject text-small">

                                        Recycle Bin

                                    </p>

                                </div>

                            </a>


                            <a
                                href="#"
                                class="dropdown-item account-menu-item"
                            >

                                <div class="account-menu-icon bg-dark">

                                    <i class="mdi mdi-cog text-primary"></i>

                                </div>


                                <div class="account-menu-content">

                                    <p class="preview-subject text-small">

                                        Settings

                                    </p>

                                </div>

                            </a>


                            <a
                                href="index?action=logout"
                                class="dropdown-item account-menu-item"
                            >

                                <div class="account-menu-icon bg-dark">

                                    <i class="mdi mdi-logout text-primary"></i>

                                </div>


                                <div class="account-menu-content">

                                    <p class="preview-subject text-small">

                                        Logout

                                    </p>

                                </div>

                            </a>

                        </div>

                    </li>


                    <!-- ==================================================
                         SETTINGS ICON
                         ================================================== -->

                    <!-- <li class="nav-item nav-settings d-none d-lg-block">

                        <a
                            class="nav-link"
                            href="#"
                        >

                            <i class="mdi mdi-view-grid"></i>

                        </a>

                    </li> -->


                </ul>


                <button
                    class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
                    type="button"
                    data-toggle="offcanvas"
                >

                    <span class="mdi mdi-format-line-spacing"></span>

                </button>

            </div>

        </nav>


        <!-- ======================================================
             MAIN PANEL
             ====================================================== -->

        <div class="main-panel">

            <div class="content-wrapper">


                <!-- ==================================================
                     DASHBOARD CARDS
                     ================================================== -->

                <div class="row">


                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

                        <div class="card">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-9">

                                        <div
                                            class="d-flex align-items-center align-self-start"
                                        >

                                            <h3 class="mb-0">
                                                3435
                                            </h3>

                                            <p class="text-danger ms-2 mb-0 font-weight-medium">
                                                +24342
                                            </p>

                                        </div>

                                    </div>


                                    <div class="col-3">

                                        <div class="icon icon-box-success">

                                            <span class="mdi mdi-arrow-top-right icon-item"></span>

                                        </div>

                                    </div>

                                </div>


                                <h6 class="text-muted font-weight-normal">

                                    Total Requests

                                </h6>

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

                        <div class="card">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-9">

                                        <div
                                            class="d-flex align-items-center align-self-start"
                                        >

                                            <h3 class="mb-0">
                                                $12.34
                                            </h3>

                                            <p class="text-danger ms-2 mb-0 font-weight-medium">
                                                +4343
                                            </p>

                                        </div>

                                    </div>


                                    <div class="col-3">

                                        <div class="icon icon-box-success">

                                            <span class="mdi mdi-arrow-top-right icon-item"></span>

                                        </div>

                                    </div>

                                </div>


                                <h6 class="text-muted font-weight-normal">

                                    Total Administrator

                                </h6>

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

                        <div class="card">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-9">

                                        <div
                                            class="d-flex align-items-center align-self-start"
                                        >

                                            <h3 class="mb-0">
                                               <?= number_format($totaladmin) ?>
                                            </h3>

                                            <p class="text-danger ms-2 mb-0 font-weight-medium">
                                                -2.4%
                                            </p>

                                        </div>

                                    </div>


                                    <div class="col-3">

                                        <div class="icon icon-box-danger">

                                            <span class="mdi mdi-arrow-bottom-left icon-item"></span>

                                        </div>

                                    </div>

                                </div>


                                <h6 class="text-muted font-weight-normal">

                                    Total Supervisors

                                </h6>

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

                        <div class="card">

                            <div class="card-body">

                                <div class="row">

                                    <div class="col-9">

                                        <div
                                            class="d-flex align-items-center align-self-start"
                                        >

                                            <h3 class="mb-0">
                                                  <?= number_format($totalsupervisor ) ?>
                                            </h3>

                                            <p class="text-success ms-2 mb-0 font-weight-medium">
                                                +3.5%
                                            </p>

                                        </div>

                                    </div>


                                    <div class="col-3">

                                        <div class="icon icon-box-success">

                                            <span class="mdi mdi-arrow-top-right icon-item"></span>

                                        </div>

                                    </div>

                                </div>


                                <h6 class="text-muted font-weight-normal">

                                    Total Reporters

                                </h6>

                            </div>

                        </div>

                    </div>


                </div>


                <!-- ==================================================
                     REAL DATATABLE
                     ================================================== -->

                <div class="row">

                    <div class="col-12 grid-margin stretch-card">

                        <div class="card">

                            <div class="card-body">


                                <div
                                    class="d-flex flex-row justify-content-between align-items-center dashboard-table-heading"
                                >

                                    <div>

                                        <h4 class="card-title mb-1">

                                            Recent Activity

                                        </h4>


                                        <p class="text-muted mb-0">

                                            Overview of recent system activities

                                        </p>

                                    </div>

                                </div>


                                <div class="dashboard-datatable-wrapper mt-4">

                                    <table
                                        class="dashboard-datatable"
                                        id="dashboardDataTable"
                                    >

                                        <thead>

                                            <tr>

                                                <th>S/N</th>
                                                <th>User</th>
                                                <th>Activity</th>
                                                <th>Category</th>
                                                <th>Date & Time</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                            </tr>

                                        </thead>


                                        <tbody>


                                            <tr>

                                                <td>1</td>


                                                <td>

                                                    <div class="dashboard-table-user">

                                                        <img
                                                            class="dashboard-table-avatar"
                                                            src="views/uploads/img/profile//admin.png"
                                                            alt="User"
                                                        >


                                                        <div>

                                                            <div class="dashboard-table-user-name">

                                                                Henry Klein

                                                            </div>


                                                            <div class="dashboard-table-user-email">

                                                                admin@example.com

                                                            </div>

                                                        </div>

                                                    </div>

                                                </td>


                                                <td>

                                                    User account created

                                                </td>


                                                <td>

                                                    <span class="dashboard-role">

                                                        Users

                                                    </span>

                                                </td>


                                                <td>

                                                    24 Aug 2026, 09:15 AM

                                                </td>


                                                <td>

                                                    <span class="dashboard-status dashboard-status-active">

                                                        Completed

                                                    </span>

                                                </td>


                                                <td>

                                                    <button
                                                        type="button"
                                                        class="dashboard-table-action"
                                                        title="View"
                                                    >

                                                        <i class="mdi mdi-eye"></i>

                                                    </button>

                                                </td>

                                            </tr>


                                            <tr>

                                                <td>2</td>


                                                <td>

                                                    <div class="dashboard-table-user">

                                                        <img
                                                            class="dashboard-table-avatar"
                                                            src="views/uploads/img/profile//admin.png"
                                                            alt="User"
                                                        >


                                                        <div>

                                                            <div class="dashboard-table-user-name">

                                                                Operations Manager

                                                            </div>


                                                            <div class="dashboard-table-user-email">

                                                                manager@example.com

                                                            </div>

                                                        </div>

                                                    </div>

                                                </td>


                                                <td>

                                                    Pipeline information updated

                                                </td>


                                                <td>

                                                    <span class="dashboard-role">

                                                        Pipelines

                                                    </span>

                                                </td>


                                                <td>

                                                    24 Aug 2026, 08:52 AM

                                                </td>


                                                <td>

                                                    <span class="dashboard-status dashboard-status-active">

                                                        Completed

                                                    </span>

                                                </td>


                                                <td>

                                                    <button
                                                        type="button"
                                                        class="dashboard-table-action"
                                                        title="View"
                                                    >

                                                        <i class="mdi mdi-eye"></i>

                                                    </button>

                                                </td>

                                            </tr>


                                            <tr>

                                                <td>3</td>


                                                <td>

                                                    <div class="dashboard-table-user">

                                                        <img
                                                            class="dashboard-table-avatar"
                                                            src="views/uploads/img/profile//admin.png"
                                                            alt="User"
                                                        >


                                                        <div>

                                                            <div class="dashboard-table-user-name">

                                                                Field Supervisor

                                                            </div>


                                                            <div class="dashboard-table-user-email">

                                                                supervisor@example.com

                                                            </div>

                                                        </div>

                                                    </div>

                                                </td>


                                                <td>

                                                    New incident report submitted

                                                </td>


                                                <td>

                                                    <span class="dashboard-role">

                                                        Incidence

                                                    </span>

                                                </td>


                                                <td>

                                                    24 Aug 2026, 08:31 AM

                                                </td>


                                                <td>

                                                    <span class="dashboard-status dashboard-status-pending">

                                                        Pending

                                                    </span>

                                                </td>


                                                <td>

                                                    <button
                                                        type="button"
                                                        class="dashboard-table-action"
                                                        title="View"
                                                    >

                                                        <i class="mdi mdi-eye"></i>

                                                    </button>

                                                </td>

                                            </tr>


                                            <tr>

                                                <td>4</td>


                                                <td>

                                                    <div class="dashboard-table-user">

                                                        <img
                                                            class="dashboard-table-avatar"
                                                            src="views/uploads/img/profile//admin.png"
                                                            alt="User"
                                                        >


                                                        <div>

                                                            <div class="dashboard-table-user-name">

                                                                John Operator

                                                            </div>


                                                            <div class="dashboard-table-user-email">

                                                                operator@example.com

                                                            </div>

                                                        </div>

                                                    </div>

                                                </td>


                                                <td>

                                                    Wellhead status updated

                                                </td>


                                                <td>

                                                    <span class="dashboard-role">

                                                        Wellhead

                                                    </span>

                                                </td>


                                                <td>

                                                    24 Aug 2026, 08:14 AM

                                                </td>


                                                <td>

                                                    <span class="dashboard-status dashboard-status-active">

                                                        Completed

                                                    </span>

                                                </td>


                                                <td>

                                                    <button
                                                        type="button"
                                                        class="dashboard-table-action"
                                                        title="View"
                                                    >

                                                        <i class="mdi mdi-eye"></i>

                                                    </button>

                                                </td>

                                            </tr>


                                            <tr>

                                                <td>5</td>


                                                <td>

                                                    <div class="dashboard-table-user">

                                                        <img
                                                            class="dashboard-table-avatar"
                                                            src="views/uploads/img/profile//admin.png"
                                                            alt="User"
                                                        >


                                                        <div>

                                                            <div class="dashboard-table-user-name">

                                                                Zone Administrator

                                                            </div>


                                                            <div class="dashboard-table-user-email">

                                                                zone@example.com

                                                            </div>

                                                        </div>

                                                    </div>

                                                </td>


                                                <td>

                                                    Zone information modified

                                                </td>


                                                <td>

                                                    <span class="dashboard-role">

                                                        Zones

                                                    </span>

                                                </td>


                                                <td>

                                                    23 Aug 2026, 05:42 PM

                                                </td>


                                                <td>

                                                    <span class="dashboard-status dashboard-status-active">

                                                        Completed

                                                    </span>

                                                </td>


                                                <td>

                                                    <button
                                                        type="button"
                                                        class="dashboard-table-action"
                                                        title="View"
                                                    >

                                                        <i class="mdi mdi-eye"></i>

                                                    </button>

                                                </td>

                                            </tr>


                                            <tr>

                                                <td>6</td>


                                                <td>

                                                    <div class="dashboard-table-user">

                                                        <img
                                                            class="dashboard-table-avatar"
                                                            src="views/uploads/img/profile//admin.png"
                                                            alt="User"
                                                        >


                                                        <div>

                                                            <div class="dashboard-table-user-name">

                                                                System Administrator

                                                            </div>


                                                            <div class="dashboard-table-user-email">

                                                                system@example.com

                                                            </div>

                                                        </div>

                                                    </div>

                                                </td>


                                                <td>

                                                    Report type configuration updated

                                                </td>


                                                <td>

                                                    <span class="dashboard-role">

                                                        Reports

                                                    </span>

                                                </td>


                                                <td>

                                                    23 Aug 2026, 04:27 PM

                                                </td>


                                                <td>

                                                    <span class="dashboard-status dashboard-status-active">

                                                        Completed

                                                    </span>

                                                </td>


                                                <td>

                                                    <button
                                                        type="button"
                                                        class="dashboard-table-action"
                                                        title="View"
                                                    >

                                                        <i class="mdi mdi-eye"></i>

                                                    </button>

                                                </td>

                                            </tr>


                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <!-- ==================================================
                 FOOTER
                 ================================================== -->

            <footer class="footer">

                <div class="d-sm-flex justify-content-center justify-content-sm-between">


                    <span
                        style="text-decoration:none !important;"
                        class="text-muted text-center text-sm-left d-block d-sm-inline-block"
                    >

                        Copyright © <?= $company_copyright ?>

                        <a
                            href="<?= htmlspecialchars($company_copyrightlink) ?>"
                            target="_blank"
                        >

                            <?= htmlspecialchars($company_poweredby) ?>

                        </a>

                        All rights reserved.

                    </span>


                    <span
                        class="text-muted float-none float-sm-end d-block mt-1 mt-sm-0 text-center"
                    >

                        Hand coded by Agb team

                        <i class="mdi mdi-heart text-danger"></i>

                    </span>

                </div>

            </footer>

        </div>

    </div>

</div>


<!-- ==========================================================
     REGISTRATION POPUP
     ========================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.register-user-btn').forEach(function (button) {

        button.addEventListener('click', function (e) {

            e.preventDefault();

            const selectedRole = this.getAttribute('data-role');

            Swal.fire({

                customClass: {
                    popup: 'registration-popup',
                    title: 'registration-title',
                    htmlContainer: 'registration-html'
                },

                background: '#191c24',
                color: '#ffffff',

                width: '460px',

                padding: '28px',

                showCloseButton: true,

                showCancelButton: true,

                confirmButtonText:
                    '<i class="mdi mdi-account-plus"></i> Submit',

                cancelButtonText:
                    'Cancel',

                focusConfirm: false,

                buttonsStyling: false,

                html: `

                    <div class="registration-header-icon">

                        <i class="mdi mdi-account-plus"></i>

                    </div>


                    <div
                        style="
                            font-size:13px;
                            color:#8e929a;
                            margin-bottom:20px;
                        "
                    >

                        Create a new user account

                        <br>

                        <span class="registration-role-display">

                            ${
                                selectedRole === '1'
                                    ? 'Supervisor'
                                    : 'Administrator'
                            }

                        </span>

                    </div>


                    <div>

                        <label
                            class="registration-label"
                            for="swal-name"
                        >

                            Name

                        </label>


                        <input
                            id="swal-name"
                            class="registration-field"
                            type="text"
                            placeholder="Enter full name"
                            autocomplete="off"
                        >

                    </div>


                    <div>

                        <label
                            class="registration-label"
                            for="swal-email"
                        >

                            Email

                        </label>


                        <input
                            id="swal-email"
                            class="registration-field"
                            type="email"
                            placeholder="Enter email address"
                            autocomplete="off"
                        >

                    </div>


                    <div>

                        <label
                            class="registration-label"
                            for="swal-phone"
                        >

                            Phone

                        </label>


                        <input
                            id="swal-phone"
                            class="registration-field"
                            type="tel"
                            placeholder="Enter phone number"
                            autocomplete="off"
                        >

                    </div>


                    <div>

                        <label
                            class="registration-label"
                            for="swal-role"
                        >

                            User Role

                        </label>


                        <div class="registration-role-wrapper">

                            <select
                                id="swal-role"
                                class="registration-field"
                            >

                                <option value="">
                                    Select user role
                                </option>

                                <option value="2">
                                    Administrator
                                </option>

                            </select>


                            <i class="mdi mdi-chevron-down"></i>

                        </div>

                    </div>

                `,

                didOpen: () => {

                    const roleField =
                        document.getElementById('swal-role');

                    if (roleField && selectedRole) {

                        roleField.value = selectedRole;

                    }

                },


                preConfirm: () => {

                    const name =
                        document
                            .getElementById('swal-name')
                            .value
                            .trim();


                    const email =
                        document
                            .getElementById('swal-email')
                            .value
                            .trim();


                    const phone =
                        document
                            .getElementById('swal-phone')
                            .value
                            .trim();


                    const role =
                        document
                            .getElementById('swal-role')
                            .value
                            .trim();


                    if (!name) {

                        Swal.showValidationMessage(
                            'Please enter the name'
                        );

                        return false;

                    }


                    if (!email) {

                        Swal.showValidationMessage(
                            'Please enter the email address'
                        );

                        return false;

                    }


                    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {

                        Swal.showValidationMessage(
                            'Please enter a valid email address'
                        );

                        return false;

                    }


                    if (!phone) {

                        Swal.showValidationMessage(
                            'Please enter the phone number'
                        );

                        return false;

                    }


                    if (!role) {

                        Swal.showValidationMessage(
                            'Please select a user role'
                        );

                        return false;

                    }


                    return {
                        name: name,
                        email: email,
                        phone: phone,
                        role: role
                    };

                }

            }).then((result) => {

                if (result.isConfirmed) {

                    console.log(
                        'Registration data:',
                        result.value
                    );


                    Swal.fire({

                        customClass: {
                            popup: 'registration-popup',
                            title: 'registration-title'
                        },

                        background: '#191c24',

                        color: '#ffffff',

                        icon: 'success',

                        title: 'Registration Submitted',

                        text:
                            (
                                result.value.role === '1'
                                    ? 'Supervisor'
                                    : 'Administrator'
                            ) +
                            ' registration information has been submitted.',

                        confirmButtonText: 'OK',

                        buttonsStyling: false

                    });

                }

            });

        });

    });

});

</script>


<!-- ==========================================================
     PLUGINS
     ========================================================== -->

<script src="views/assets/backend/vendors/js/vendor.bundle.base.js"></script>

<script src="views/assets/backend/vendors/chart.js/chart.umd.js"></script>

<script src="views/assets/backend/vendors/progressbar.js/progressbar.min.js"></script>

<script src="views/assets/backend/vendors/jvectormap/jquery-jvectormap.min.js"></script>

<script src="views/assets/backend/vendors/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<script src="views/assets/backend/vendors/owl-carousel-2/owl.carousel.min.js"></script>

<script
    src="views/assets/backend/js/jquery.cookie.js"
    type="text/javascript"
></script>

<script src="views/assets/backend/js/off-canvas.js"></script>

<script src="views/assets/backend/js/misc.js"></script>

<script src="views/assets/backend/js/settings.js"></script>

<script src="views/assets/backend/js/todolist.js"></script>

<script src="views/assets/backend/js/proBanner.js"></script>

<script src="views/assets/backend/js/dashboard.js"></script>


<!-- ==========================================================
     DATATABLES
     ========================================================== -->

<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>


<script>

$(document).ready(function () {

    $('#dashboardDataTable').DataTable({

        pageLength: 5,

        lengthMenu: [
            [5, 10, 25, 50, -1],
            [5, 10, 25, 50, "All"]
        ],

        ordering: true,

        searching: true,

        paging: true,

        info: true,

        autoWidth: false,

        responsive: false,

        columnDefs: [

            {
                targets: 0,
                searchable: false,
                orderable: false
            },

            {
                targets: 6,
                searchable: false,
                orderable: false
            }

        ],

        order: [
            [4, 'desc']
        ],

        language: {

            search: "Search:",

            lengthMenu:
                "Show _MENU_ entries",

            info:
                "Showing _START_ to _END_ of _TOTAL_ entries",

            infoEmpty:
                "Showing 0 to 0 of 0 entries",

            zeroRecords:
                "No matching records found",

            emptyTable:
                "No data available in table",

            paginate: {

                first: "First",

                last: "Last",

                next: "›",

                previous: "‹"

            }

        },


        drawCallback: function () {

            const api = this.api();

            api.column(0, {
                search: 'applied',
                order: 'applied'
            }).nodes().each(function (cell, i) {

                cell.innerHTML = i + 1;

            });

        }

    });

});

</script>


<!-- ==========================================================
     PHP SUCCESS / ERROR ALERT
     ========================================================== -->

<script>

document.addEventListener('DOMContentLoaded', function() {

<?php if (isset($showAlert) && $showAlert): ?>

    Swal.fire({

        title: 'Successful!',

        text:
            '<?= htmlspecialchars(
                $msgtext,
                ENT_QUOTES,
                'UTF-8'
            ); ?>',

        icon: 'info',

        confirmButtonText: 'OK',

        allowOutsideClick: true,

        allowEscapeKey: true

    }).then((result) => {

        if (
            result.isConfirmed ||
            result.dismiss
        ) {

            window.location.href =
                '<?= htmlspecialchars(
                    $url,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>';

        }

    });

<?php elseif (isset($showAlert) && !$showAlert): ?>

    Swal.fire({

        title: 'Error',

        text:
            '<?= htmlspecialchars(
                $msgtext,
                ENT_QUOTES,
                'UTF-8'
            ); ?>',

        icon: 'error',

        confirmButtonText: 'OK',

        allowOutsideClick: true,

        allowEscapeKey: true

    }).then((result) => {

        if (
            result.isConfirmed ||
            result.dismiss
        ) {

            window.location.href =
                '<?= htmlspecialchars(
                    $url,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>';

        }

    });

<?php endif; ?>

});

</script>


</body>

</html>