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

// $page_name = "users";

// $current_action = isset($_GET['action'])
//     ? trim($_GET['action'])
//     : 'dashboard';

// if ($current_action === '' || $current_action === 'index') {
//     $current_action = 'dashboard';
// }
$current_action = $page_name;
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
        <?= ucfirst(htmlspecialchars($page_name)) ?>
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

    <link
        rel="stylesheet"
        href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css"
    >

    <link
        rel="shortcut icon"
        href="views/uploads/img/<?= htmlspecialchars($company_favicon) ?>"
    >

    <style>

        .sidebar .nav .nav-item.menu-items {
            margin-bottom: 3px !important;
        }

        .sidebar .nav .nav-item.menu-items .nav-link {
            background: transparent !important;
            color: #6c7293 !important;
            border-radius: 6px !important;
            padding: 10px 12px !important;
            transition: color 0.2s ease;
        }

        .sidebar .nav .nav-item.menu-items .nav-link .menu-title {
            color: #6c7293 !important;
            line-height: 1.2 !important;
            white-space: nowrap;
            transition: color 0.2s ease;
        }

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

        .sidebar .nav .nav-item.menu-items .menu-icon i {
            color: #6c7293 !important;
            font-size: 20px;
            line-height: 1 !important;
            transition: color 0.2s ease;
        }

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

        .registration-popup .swal2-validation-message {
            background: transparent !important;
            color: #ff4747 !important;
            font-weight: 700 !important;
            padding: 0 !important;
            margin: 4px 0 8px !important;
            box-shadow: none !important;
        }

        .registration-popup .swal2-validation-message::before {
            display: none !important;
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

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card .card {
            position: relative;
            overflow: hidden;
            min-height: 145px;
            background:
                linear-gradient(
                    135deg,
                    #191c24 0%,
                    #1c2029 55%,
                    #191c24 100%
                ) !important;
            border: 1px solid rgba(255, 255, 255, 0.055) !important;
            border-radius: 12px !important;
            box-shadow:
                0 8px 25px rgba(0, 0, 0, 0.18),
                inset 0 1px 0 rgba(255, 255, 255, 0.025) !important;
            transition:
                transform 0.25s ease,
                box-shadow 0.25s ease,
                border-color 0.25s ease !important;
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card .card::before {
            content: "";
            position: absolute;
            top: -45px;
            right: -45px;
            width: 125px;
            height: 125px;
            border-radius: 50%;
            background: rgba(0, 210, 91, 0.06);
            transition:
                transform 0.35s ease,
                background 0.35s ease;
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card .card::after {
            content: "";
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 3px;
            background: linear-gradient(
                180deg,
                #00d25b,
                rgba(0, 210, 91, 0.15)
            );
            opacity: 0.85;
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card .card:hover {
            transform: translateY(-4px);
            border-color: rgba(0, 210, 91, 0.22) !important;
            box-shadow:
                0 14px 35px rgba(0, 0, 0, 0.28),
                0 0 25px rgba(0, 210, 91, 0.045) !important;
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card .card:hover::before {
            transform: scale(1.35);
            background: rgba(0, 210, 91, 0.085);
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card .card-body {
            position: relative;
            z-index: 2;
            padding: 22px 21px !important;
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card .card h3 {
            color: #ffffff !important;
            font-size: 27px !important;
            font-weight: 700 !important;
            letter-spacing: -0.5px;
            line-height: 1.15;
            margin-bottom: 8px !important;
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card .card h6 {
            color: #8e929a !important;
            font-size: 12px !important;
            font-weight: 500 !important;
            letter-spacing: 0.25px;
            margin-top: 7px !important;
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card:nth-child(1) .card::after {
            background: linear-gradient(
                180deg,
                #00d25b,
                rgba(0, 210, 91, 0.12)
            );
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card:nth-child(2) .card::after {
            background: linear-gradient(
                180deg,
                #4dabf7,
                rgba(77, 171, 247, 0.12)
            );
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card:nth-child(3) .card::after {
            background: linear-gradient(
                180deg,
                #ffab00,
                rgba(255, 171, 0, 0.12)
            );
        }

        .row > .col-xl-3.col-sm-6.grid-margin.stretch-card:nth-child(4) .card::after {
            background: linear-gradient(
                180deg,
                #a66cff,
                rgba(166, 108, 255, 0.12)
            );
        }

        .dashboard-datatable-wrapper {
            width: 100%;
            overflow-x: auto;
            border: 1px solid rgba(255, 255, 255, 0.055);
            border-radius: 9px;
            background: #15181f;
            box-shadow:
                inset 0 1px 0 rgba(255, 255, 255, 0.015),
                0 8px 25px rgba(0, 0, 0, 0.12);
        }

        .dashboard-datatable {
            width: 100% !important;
            min-width: 850px;
            border-collapse: separate !important;
            border-spacing: 0 !important;
            margin: 0 !important;
        }

        .dashboard-datatable thead th {
            background:
                linear-gradient(
                    180deg,
                    #1d212b 0%,
                    #191c24 100%
                ) !important;
            color: #ffffff !important;
            font-size: 12px !important;
            font-weight: 600 !important;
            letter-spacing: 0.35px;
            padding: 15px 15px !important;
            border: 0 !important;
            border-bottom: 1px solid rgba(0, 210, 91, 0.10) !important;
            white-space: nowrap;
            text-transform: uppercase;
        }

        .dashboard-datatable thead th:first-child {
            border-top-left-radius: 8px;
        }

        .dashboard-datatable thead th:last-child {
            border-top-right-radius: 8px;
        }

        .dashboard-datatable tbody td {
            color: #a7a7a7 !important;
            font-size: 13px;
            padding: 14px 15px !important;
            border-top: 1px solid rgba(255, 255, 255, 0.045) !important;
            vertical-align: middle;
            white-space: nowrap;
            background: transparent !important;
            transition:
                color 0.2s ease,
                background-color 0.2s ease;
        }

        .dashboard-datatable tbody tr {
            transition:
                transform 0.2s ease,
                background-color 0.2s ease;
        }

        .dashboard-datatable tbody tr:hover td {
            background: rgba(0, 210, 91, 0.035) !important;
            color: #c5c7cc !important;
        }

        .dashboard-datatable tbody tr:hover td:first-child {
            color: #00d25b !important;
        }

        .dashboard-table-user {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .dashboard-table-avatar {
            width: 37px;
            height: 37px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(0, 210, 91, 0.15);
            box-shadow:
                0 0 0 3px rgba(0, 210, 91, 0.035);
            transition:
                border-color 0.2s ease,
                transform 0.2s ease;
        }

        .dashboard-datatable tbody tr:hover .dashboard-table-avatar {
            border-color: rgba(0, 210, 91, 0.40);
            transform: scale(1.04);
        }

        .dashboard-table-user-name {
            color: #ffffff !important;
            font-weight: 500;
            line-height: 1.25;
        }

        .dashboard-table-user-email {
            color: #6c7293 !important;
            font-size: 11px;
            margin-top: 3px;
        }

        .dashboard-status {
            display: inline-flex;
            align-items: center;
            padding: 5px 11px;
            border-radius: 20px;
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.2px;
            border: 1px solid transparent;
        }

        .dashboard-status-active {
            color: #00d25b !important;
            background: rgba(0, 210, 91, 0.085);
            border-color: rgba(0, 210, 91, 0.12);
        }

        .dashboard-status-pending {
            color: #ffab00 !important;
            background: rgba(255, 171, 0, 0.085);
            border-color: rgba(255, 171, 0, 0.12);
        }

        .dashboard-status-inactive {
            color: #ff4747 !important;
            background: rgba(255, 71, 71, 0.085);
            border-color: rgba(255, 71, 71, 0.12);
        }

        .dashboard-role {
            display: inline-block;
            color: #00d25b !important;
            font-weight: 500;
            padding: 4px 9px;
            border-radius: 5px;
            background: rgba(0, 210, 91, 0.045);
        }

        .dashboard-table-action {
            width: 34px;
            height: 34px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: 6px;
            background: #191c24;
            color: #6c7293;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition:
                background-color 0.2s ease,
                color 0.2s ease,
                border-color 0.2s ease,
                transform 0.2s ease;
        }

        .dashboard-table-action:hover {
            background: #00d25b;
            border-color: #00d25b;
            color: #111318;
            transform: translateY(-1px);
            box-shadow:
                0 4px 12px rgba(0, 210, 91, 0.18);
        }

        .dataTables_wrapper {
            color: #a7a7a7 !important;
            font-size: 12px;
        }

        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 15px;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: #101217 !important;
            border: 1px solid #343842 !important;
            border-radius: 6px !important;
            color: #ffffff !important;
            outline: none !important;
            padding: 7px 10px !important;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        .dataTables_wrapper .dataTables_filter input {
            margin-left: 8px !important;
        }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: #00d25b !important;
            box-shadow:
                0 0 0 2px rgba(0, 210, 91, 0.08) !important;
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
            border-radius: 5px !important;
            background: #191c24 !important;
            color: #a7a7a7 !important;
            transition:
                background-color 0.2s ease,
                color 0.2s ease,
                border-color 0.2s ease;
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
            box-shadow:
                0 3px 10px rgba(0, 210, 91, 0.15);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled,
        .dataTables_wrapper .dataTables_paginate .paginate_button.disabled:hover {
            background: #191c24 !important;
            border-color: #343842 !important;
            color: #555b68 !important;
        }

        table.dataTable.no-footer {
            border-bottom: 0 !important;
        }

        table.dataTable thead .sorting,
        table.dataTable thead .sorting_asc,
        table.dataTable thead .sorting_desc {
            color: #ffffff !important;
        }

        .dashboard-table-heading {
            padding-bottom: 18px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.045);
        }

        .dashboard-table-heading h4 {
            color: #ffffff !important;
            font-size: 17px !important;
            font-weight: 600 !important;
            letter-spacing: 0.1px;
        }

        .dashboard-table-heading p {
            color: #6c7293 !important;
            font-size: 12px !important;
            margin-top: 3px;
        }

        @media (max-width: 767px) {

            .row > .col-xl-3.col-sm-6.grid-margin.stretch-card .card {
                min-height: 135px;
            }

            .dashboard-datatable-wrapper {
                border-radius: 7px;
            }

            .dashboard-table-heading {
                align-items: flex-start !important;
            }

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

/* =========================
   PAGE LOADER
========================= */

#pageLoader {
    position: fixed;
    inset: 0;
    width: 100%;
    height: 100%;
    background: #ffffff;
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999999;
    opacity: 1;
    visibility: visible;
    transition: opacity 0.4s ease, visibility 0.4s ease;
}

#pageLoader.hide {
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
}

.loader-content {
    text-align: center;
}

.spinner {
    width: 55px;
    height: 55px;
    border: 5px solid #e5e7eb;
    border-top: 5px solid #0d6efd;
    border-radius: 50%;
    animation: loaderSpin 0.8s linear infinite;
    margin: 0 auto 15px;
}

.loader-text {
    font-size: 15px;
    font-weight: 600;
    color: #333;
}

@keyframes loaderSpin {
    from {
        transform: rotate(0deg);
    }

    to {
        transform: rotate(360deg);
    }
}
        
    </style>

</head>
<?php include "views/inc/notification.php"  ?>
