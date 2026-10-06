<?php
$template_mode = 'auto';

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

$current_action = $page_name;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<script>
    (function () {
        const templateMode = <?= json_encode($template_mode) ?>;
        const currentHour = new Date().getHours();
        let theme;
        if (templateMode === 'dark') {
            theme = 'dark';
        } else if (templateMode === 'light') {
            theme = 'light';
        } else {
            theme = currentHour >= 19 || currentHour < 6 ? 'dark' : 'light';
        }
        document.documentElement.setAttribute('data-theme', theme);
    })();
</script>

<title>NNPC IMRA - Tickets Dashboard</title>
<script src="views/inc/sweetalert/sweetalert2@11.js"></script>
<script src="views/inc/sweetalert/jquery-3.6.4.min.js"></script>
<link rel="stylesheet" href="views/inc/sweetalert/sweetalert2.min.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">

<style>
    /* ============================================================
       SOFT LIGHT MODE PALETTE
       ============================================================ */
    :root {
        --sidebar-width: 245px;
        --sidebar-bg: #1e2b42;
        --sidebar-dark: #2a3f5f;
        --primary-blue: #3b6fd4;
        --border-color: #dfe3ea;
        --text-color: #2c3545;
        --muted-color: #6b7280;
        --page-bg: #eef1f6;
        --table-bg: #f7f8fb;
        --table-border: #e2e6ed;

        --surface-bg: #f7f8fb;
        --surface-soft: #eef1f6;
        --surface-border: #dfe3ea;
        --table-head-bg: #eaedf3;
        --table-cell-bg: #f7f8fb;
        --table-hover-bg: #e8eef9;
        --body-text: #2c3545;
        --secondary-text: #6b7280;
        --navbar-bg: #f2f4f8;
        --counter-bg: #f2f4f8;
        --link-color: #3b6fd4;
    }

    /* ============================================================
       DARK MODE PALETTE
       ============================================================ */
    :root[data-theme="dark"] {
        color-scheme: dark;
        --sidebar-bg: #0b1220;
        --sidebar-dark: #1e3a5f;
        --border-color: #29364a;
        --text-color: #e5edf8;
        --muted-color: #9aabc2;
        --page-bg: #0b1220;
        --table-bg: #111c2e;
        --table-border: #26364d;
        --surface-bg: #111c2e;
        --surface-soft: #172438;
        --surface-border: #29364a;
        --table-head-bg: #172438;
        --table-cell-bg: #111c2e;
        --table-hover-bg: #1a2a42;
        --body-text: #e5edf8;
        --secondary-text: #a7b6cb;
        --navbar-bg: #111c2e;
        --counter-bg: #111c2e;
        --link-color: #8bb8ff;
    }

    * { box-sizing: border-box; }

    body {
        margin: 0; padding: 0;
        font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
        font-size: 13px;
        color: var(--body-text);
        background: var(--page-bg);
    }

    /* ============================================================
       TOP NAVBAR
       ============================================================ */
    .top-navbar {
        position: fixed; top: 0; left: 0; right: 0; height: 68px;
        background: var(--navbar-bg);
        border-bottom: 1px solid var(--surface-border);
        display: flex; align-items: center; justify-content: space-between;
        padding: 0 28px; z-index: 1000;
        box-shadow: 0 2px 12px rgba(15, 23, 42, .04);
        transition: left .25s ease, background .2s ease;
    }

    .navbar-left { display: flex; align-items: center; gap: 10px; }

    .navbar-left .nav-icon {
        display: inline-flex; align-items: center; justify-content: center;
        width: 40px; height: 40px;
        border: 1px solid var(--surface-border);
        border-radius: 12px;
        background: var(--surface-bg);
        color: var(--body-text);
        font-size: 21px; cursor: pointer;
        transition: background .2s ease;
    }

    .navbar-left .nav-icon:hover { background: var(--table-hover-bg); }

    .navbar-right { display: flex; align-items: center; gap: 10px; }

    .create-ticket-btn {
        height: 40px; border: 0; border-radius: 10px;
        background: #3b6fd4; font-size: 12px; font-weight: 600;
        padding: 0 18px; color: #ffffff;
    }

    .create-ticket-btn:hover { background: #2f5cb8; color: #ffffff; }

    /* ============================================================
       USER PROFILE DROPDOWN
       ============================================================ */
    .user-profile-dropdown {
        position: relative;
        margin-left: 12px;
    }

    .user-profile {
        display: flex; align-items: center; gap: 10px;
        color: var(--secondary-text); font-size: 12px; font-weight: 600;
        white-space: nowrap; cursor: pointer; padding: 6px 8px;
        border-radius: 10px; transition: background .2s ease;
        user-select: none;
    }

    .user-profile:hover { background: var(--table-hover-bg); }

    .user-avatar {
        width: 36px; height: 36px; border-radius: 50%;
        background: #dbe4f5;
        display: flex; align-items: center; justify-content: center;
        color: #3b6fd4; font-size: 16px;
        flex-shrink: 0;
    }

    :root[data-theme="dark"] .user-avatar { background: #1e2d47; color: #8bb8ff; }

    .user-info {
        display: flex; flex-direction: column;
        line-height: 1.3;
    }

    .user-info .user-org {
        font-size: 11px; font-weight: 700; color: var(--body-text);
        text-transform: uppercase; letter-spacing: .3px;
    }

    .user-info .user-role {
        font-size: 11px; font-weight: 600; color: var(--secondary-text);
    }

    .user-profile .dropdown-caret {
        font-size: 10px; color: var(--secondary-text);
        margin-left: 2px; transition: transform .2s ease;
    }

    .user-profile-dropdown.open .dropdown-caret {
        transform: rotate(180deg);
    }

    .profile-dropdown-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        min-width: 220px;
        background: var(--surface-bg);
        border: 1px solid var(--surface-border);
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(15, 23, 42, .12);
        padding: 8px;
        z-index: 2000;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-6px);
        transition: opacity .18s ease, transform .18s ease, visibility .18s ease;
    }

    .user-profile-dropdown.open .profile-dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .profile-dropdown-header {
        padding: 10px 12px;
        border-bottom: 1px solid var(--surface-border);
        margin-bottom: 6px;
    }

    .profile-dropdown-header .pd-name {
        font-size: 13px; font-weight: 700; color: var(--body-text);
    }

    .profile-dropdown-header .pd-role {
        font-size: 11px; color: var(--secondary-text);
        margin-top: 2px;
    }

    .profile-dropdown-menu a {
        display: flex; align-items: center; gap: 10px;
        padding: 9px 12px;
        border-radius: 8px;
        color: var(--body-text);
        text-decoration: none;
        font-size: 12px;
        font-weight: 500;
        transition: background .15s ease;
    }

    .profile-dropdown-menu a:hover {
        background: var(--table-hover-bg);
        color: var(--body-text);
    }

    .profile-dropdown-menu a i {
        font-size: 14px;
        color: var(--secondary-text);
        width: 18px;
        text-align: center;
    }

    .profile-dropdown-divider {
        height: 1px;
        background: var(--surface-border);
        margin: 6px 4px;
    }

    .profile-dropdown-menu a.logout-link {
        color: #d9535e;
    }

    .profile-dropdown-menu a.logout-link i {
        color: #d9535e;
    }

    :root[data-theme="dark"] .profile-dropdown-menu a.logout-link {
        color: #ff9aa6;
    }

    :root[data-theme="dark"] .profile-dropdown-menu a.logout-link i {
        color: #ff9aa6;
    }

    /* ============================================================
       SIDEBAR
       ============================================================ */
    .sidebar {
        position: fixed; top: 0; left: 0; bottom: 0; width: var(--sidebar-width);
        background: linear-gradient(180deg, #1e2b42, #16202f);
        color: #ffffff; z-index: 1200; overflow-y: auto;
        box-shadow: 8px 0 30px rgba(15, 23, 42, .12);
        transform: translateX(-105%); transition: transform .25s ease;
    }

    .sidebar.show { transform: translateX(0); }

    .sidebar-brand {
        height: 68px; display: flex; align-items: center; padding: 0 26px;
        font-size: 18px; font-weight: 600; color: #ffffff;
        background: rgba(255, 255, 255, .04); white-space: nowrap;
    }

    .sidebar-nav { padding: 18px 12px; margin: 0; list-style: none; }

    .sidebar-nav li { border: 0; margin-bottom: 6px; }

    .sidebar-nav a {
        display: flex; align-items: center; justify-content: space-between;
        min-height: 46px; padding: 0 16px; border-radius: 10px;
        color: #c5d1e4; text-decoration: none; font-size: 13px;
        transition: background .2s ease;
    }

    .sidebar-nav a:hover { background: rgba(255, 255, 255, .08); color: #ffffff; }

    .sidebar-nav a.active { background: #2d4f80; color: #ffffff; box-shadow: inset 3px 0 #78a9ff; }

    .sidebar-nav .nav-arrow { font-size: 10px; opacity: 0.8; }

    /* Dropdown within sidebar */
    .sidebar-nav .dropdown-toggle {
        display: flex; align-items: center; justify-content: space-between;
        min-height: 46px; padding: 0 16px; border-radius: 10px;
        color: #c5d1e4; text-decoration: none; font-size: 13px;
        transition: background .2s ease;
        cursor: pointer;
        user-select: none;
    }

    .sidebar-nav .dropdown-toggle:hover { background: rgba(255, 255, 255, .08); color: #ffffff; }

    .sidebar-nav .dropdown-toggle .nav-arrow {
        font-size: 10px; transition: transform .2s ease;
    }

    .sidebar-nav .dropdown-toggle.open .nav-arrow {
        transform: rotate(180deg);
    }

    .sidebar-nav .dropdown-menu {
        position: static;
        float: none;
        width: 100%;
        padding: 0 0 0 12px;
        margin: 0;
        background: transparent;
        border: none;
        display: none;
    }

    .sidebar-nav .dropdown-menu.show {
        display: block;
    }

    .sidebar-nav .dropdown-menu a {
        min-height: 38px;
        padding: 0 16px;
        font-size: 12px;
        color: #aebdd4;
        border-radius: 8px;
        margin-bottom: 2px;
    }

    .sidebar-nav .dropdown-menu a:hover {
        background: rgba(255, 255, 255, .06);
        color: #ffffff;
    }

    .sidebar-nav .dropdown-menu a.active {
        background: #2d4f80;
        color: #ffffff;
        box-shadow: inset 3px 0 #78a9ff;
    }

    /* ============================================================
       MAIN CONTENT
       ============================================================ */
    .main-content {
        margin-left: 0; padding-top: 68px; min-height: 100vh;
        background: var(--page-bg); transition: margin-left .25s ease;
    }

    body.sidebar-open .top-navbar { left: var(--sidebar-width); }

    body.sidebar-open .main-content { margin-left: var(--sidebar-width); }

    .content-header { min-height: 28px; border: 0; }

    /* ============================================================
       SUMMARY SECTION
       ============================================================ */
    .summary-section {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 18px;
        margin: 0 24px 18px; padding: 22px 24px;
        border: 1px solid var(--surface-border); border-radius: 16px;
        background: var(--surface-bg);
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .summary-counters { display: flex; align-items: center; gap: 10px; flex-wrap: wrap; }

    .summary-counter {
        display: inline-flex; flex-direction: column; align-items: flex-start;
        justify-content: center; gap: 8px;
        min-height: 66px; min-width: 135px;
        padding: 12px 16px;
        border: 1px solid var(--surface-border); border-radius: 12px;
        background: var(--counter-bg); color: var(--secondary-text); font-size: 11px;
        white-space: nowrap;
    }

    .summary-counter strong { font-weight: 700; color: var(--body-text); font-size: 22px; }

    /* ============================================================
       WELLHEAD / STATUS BOXES — FADED LIKE THE BLUE REFERENCE
       ============================================================ */
    .summary-counter.wellhead-status {
        border-color: var(--status-border);
        background: var(--status-bg);
    }

    .summary-counter.wellhead-status span {
        color: var(--status-color);
        font-weight: 600;
    }

    .summary-counter.wellhead-status strong {
        color: var(--status-color);
    }

    /* ============================================================
       SPECIAL SUMMARY BOXES (blue reference style)
       ============================================================ */
    .summary-counter.filtered {
        background: rgba(59, 111, 212, 0.10);
        border-color: rgba(59, 111, 212, 0.35);
    }

    .summary-counter.filtered strong {
        color: #3b6fd4;
    }

    .summary-counter.due {
        background: rgba(220, 190, 70, 0.10);
        border-color: rgba(220, 190, 70, 0.35);
    }

    .summary-counter.due strong {
        color: #b89b2e;
    }

    .summary-counter.overdue {
        background: rgba(217, 83, 94, 0.10);
        border-color: rgba(217, 83, 94, 0.35);
    }

    .summary-counter.overdue strong {
        color: #c94b56;
    }

    /* ============================================================
       DARK MODE FADED BOXES
       ============================================================ */
    :root[data-theme="dark"] .summary-counter {
        background: rgba(255, 255, 255, 0.025);
    }

    :root[data-theme="dark"] .summary-counter.filtered {
        background: rgba(59, 111, 212, 0.10);
        border-color: rgba(91, 145, 218, 0.40);
    }

    :root[data-theme="dark"] .summary-counter.filtered strong {
        color: #8bb8ff;
    }

    :root[data-theme="dark"] .summary-counter.due {
        background: rgba(220, 190, 70, 0.08);
        border-color: rgba(220, 190, 70, 0.35);
    }

    :root[data-theme="dark"] .summary-counter.due strong {
        color: #f1d66a;
    }

    :root[data-theme="dark"] .summary-counter.overdue {
        background: rgba(217, 83, 94, 0.08);
        border-color: rgba(217, 83, 94, 0.35);
    }

    :root[data-theme="dark"] .summary-counter.overdue strong {
        color: #ff9aa6;
    }

    .summary-actions {
        display: flex;
        align-items: center;
        gap: 14px;
        flex-wrap: wrap;
        margin-left: auto;
    }

    .auto-reload {
        display: flex; align-items: center; gap: 5px; white-space: nowrap;
        font-size: 12px; color: var(--secondary-text); cursor: pointer;
        user-select: none;
    }

    .auto-reload input { width: 16px; height: 16px; margin: 0; cursor: pointer; }

    /* ============================================================
       DELETE BUTTON
       ============================================================ */
    .btn-delete-selected {
        display: inline-flex; align-items: center; gap: 6px;
        height: 38px; padding: 0 16px;
        border: 1px solid #e2b8be;
        border-radius: 10px;
        background: #fdf0f1;
        color: #b8454f;
        font-size: 12px; font-weight: 600;
        transition: background .2s ease, border-color .2s ease, color .2s ease;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-delete-selected:hover {
        background: #f8d7da;
        border-color: #d9535e;
        color: #9a2e36;
    }

    .btn-delete-selected:disabled,
    .btn-delete-selected.disabled {
        opacity: .45;
        cursor: not-allowed;
        background: var(--surface-soft);
        border-color: var(--surface-border);
        color: var(--secondary-text);
    }

    :root[data-theme="dark"] .btn-delete-selected {
        background: #351e2a;
        border-color: #75404e;
        color: #ff9aa6;
    }

    :root[data-theme="dark"] .btn-delete-selected:hover {
        background: #4a2836;
        border-color: #ff9aa6;
        color: #ffb3bd;
    }

    :root[data-theme="dark"] .btn-delete-selected:disabled,
    :root[data-theme="dark"] .btn-delete-selected.disabled {
        background: var(--surface-soft);
        border-color: var(--surface-border);
        color: var(--secondary-text);
    }

    .btn-delete-selected i {
        font-size: 14px;
    }

    /* ============================================================
       VIEW ALL BUTTON
       ============================================================ */
    .btn-view-all {
        display: inline-flex; align-items: center; gap: 6px;
        height: 38px; padding: 0 16px;
        border: 1px solid var(--surface-border);
        border-radius: 10px;
        background: var(--surface-soft);
        color: var(--body-text);
        font-size: 12px; font-weight: 600;
        transition: background .2s ease, border-color .2s ease;
        white-space: nowrap;
        cursor: pointer;
    }

    .btn-view-all:hover {
        background: var(--table-hover-bg);
        border-color: #3b6fd4;
        color: #3b6fd4;
    }

    :root[data-theme="dark"] .btn-view-all:hover {
        border-color: #8bb8ff;
        color: #8bb8ff;
    }

    .btn-view-all i {
        font-size: 14px;
    }

    /* ============================================================
       TABLE CONTAINER & DATATABLE
       ============================================================ */
    .table-container {
        margin: 0 24px 28px;
        border: 1px solid var(--surface-border);
        border-radius: 16px;
        overflow-x: auto;
        overflow-y: hidden;
        background: var(--surface-bg);
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
        padding: 16px 20px 20px;
    }

    /* DataTables live search */
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 14px;
        font-size: 12px;
        text-align: right;
    }

    .dataTables_wrapper .dataTables_filter label {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 8px;
        font-weight: 500;
        color: var(--secondary-text);
        margin: 0;
    }

    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid var(--surface-border);
        border-radius: 8px;
        padding: 7px 12px;
        font-size: 12px;
        color: var(--body-text);
        background: var(--surface-soft);
        width: 240px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        outline: none;
        border-color: #3b6fd4;
        box-shadow: 0 0 0 3px rgba(59, 111, 212, .12);
        background: var(--surface-bg);
    }

    .dataTables_wrapper .dataTables_filter input::placeholder {
        color: var(--secondary-text);
        opacity: .7;
    }

    .dataTables_wrapper .dataTables_length {
        margin-bottom: 14px;
        font-size: 12px;
        color: var(--secondary-text);
    }

    .dataTables_wrapper .dataTables_length select {
        border: 1px solid var(--surface-border);
        border-radius: 8px;
        padding: 6px 10px;
        font-size: 12px;
        color: var(--body-text);
        background: var(--surface-soft);
        margin: 0 4px;
    }

    .dataTables_wrapper .dataTables_length select:focus {
        outline: none;
        border-color: #3b6fd4;
        box-shadow: 0 0 0 3px rgba(59, 111, 212, .12);
    }

    .dataTables_wrapper .dataTables_info {
        font-size: 12px;
        color: var(--secondary-text);
        padding-top: 12px;
    }

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 12px;
        padding-top: 12px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-radius: 8px !important;
        border: 1px solid var(--surface-border) !important;
        background: var(--surface-soft) !important;
        color: var(--body-text) !important;
        font-size: 12px;
        padding: 5px 11px !important;
        margin: 0 3px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #3b6fd4 !important;
        border-color: #3b6fd4 !important;
        color: #ffffff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: var(--table-hover-bg) !important;
        border-color: var(--surface-border) !important;
        color: var(--body-text) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #2f5cb8 !important;
        border-color: #2f5cb8 !important;
        color: #ffffff !important;
    }

    /* ============================================================
       TICKET TABLE
       ============================================================ */
    table.dataTable {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
    }

    .ticket-table { min-width: 1300px; }

    .ticket-table th {
        height: 50px; padding: 12px;
        background: var(--table-head-bg);
        border-bottom: 1px solid var(--surface-border);
        color: var(--secondary-text);
        font-size: 10px; font-weight: 700; letter-spacing: .45px;
        text-transform: uppercase; vertical-align: middle; white-space: nowrap;
    }

    .ticket-table td {
        padding: 15px 12px;
        background: var(--table-cell-bg);
        border-bottom: 1px solid var(--surface-border);
        color: var(--body-text);
        font-size: 12px; line-height: 1.6; vertical-align: top;
        overflow-wrap: break-word; word-break: normal;
    }

    .ticket-table tbody tr:hover td { background: var(--table-hover-bg); }

    .ticket-table a { color: var(--link-color); font-weight: 600; text-decoration: none; }
    .ticket-table a:hover { color: #2f5cb8; text-decoration: underline; }
    :root[data-theme="dark"] .ticket-table a:hover { color: #a6c8ff; }

    .ticket-table .sort-icon { font-size: 8px; margin-left: 5px; color: var(--secondary-text); }

    .ticket-table .checkbox-cell { width: 45px; text-align: center; vertical-align: middle; }
    .ticket-table .checkbox-cell input { width: 14px; height: 14px; cursor: pointer; }

    .ticket-table .id-cell { width: 76px; text-align: center; vertical-align: middle; }
    .ticket-table .tracking-cell { width: 100px; }
    .ticket-table .date-cell { width: 90px; }
    .ticket-table .category-cell { width: 110px; }
    .ticket-table .name-cell { width: 120px; }
    .ticket-table .subject-cell { width: 150px; }
    .ticket-table .status-cell { width: 80px; }
    .ticket-table .owner-cell { width: 120px; }
    .ticket-table .incident-date-cell { width: 110px; }
    .ticket-table .source-cell { width: 130px; }
    .ticket-table .state-cell { width: 70px; }
    .ticket-table .zone-cell { width: 120px; }
    .ticket-table .corridor-cell { width: 90px; }
    .ticket-table .priority-cell { width: 90px; }

    .ticket-table tbody tr { height: 78px; }

    .ticket-table .status-new { color: #b8454f; font-weight: 700; }
    :root[data-theme="dark"] .ticket-table .status-new { color: #ff9aa6; }

    .priority-label { display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; }
    .priority-label .priority-indicator {
        width: 8px; height: 8px; border-radius: 50%;
        display: inline-block; background: #d9535e;
    }
    :root[data-theme="dark"] .priority-label .priority-indicator { background: #ff6b7a; }

    .ticket-table .center-cell { vertical-align: middle; }

    .ticket-table thead th.checkbox-cell::before,
    .ticket-table thead th.checkbox-cell::after { display: none !important; }

    /* ============================================================
       THEME TOGGLE
       ============================================================ */
    .theme-toggle {
        display: inline-flex; align-items: center; justify-content: center;
        width: 40px; height: 40px;
        border: 1px solid var(--surface-border); border-radius: 12px;
        background: var(--surface-bg); color: var(--body-text);
        font-size: 17px; cursor: pointer;
        transition: background .2s ease, color .2s ease, border-color .2s ease;
    }

    .theme-toggle:hover { background: var(--table-hover-bg); }


    /* ============================================================
       CREATE TICKET CATEGORY MODAL
       ============================================================ */
    .ticket-category-modal .modal-dialog {
        max-width: 900px;
    }

    .ticket-category-modal .modal-content {
        background: var(--surface-bg);
        color: var(--body-text);
        border: 1px solid var(--surface-border);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(15, 23, 42, .20);
        overflow: hidden;
    }

    .ticket-category-modal .modal-header {
        border-bottom: 1px solid var(--surface-border);
        padding: 18px 22px;
        background: var(--navbar-bg);
    }

    .ticket-category-modal .modal-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--body-text);
    }

    .ticket-category-modal .btn-close {
        filter: var(--modal-close-filter, none);
        opacity: .7;
    }

    :root[data-theme="dark"] .ticket-category-modal .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%);
    }

    .ticket-category-modal .modal-body {
        padding: 20px;
        max-height: 72vh;
        overflow-y: auto;
    }

    .ticket-category-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .ticket-category-item {
        display: flex;
        align-items: center;
        min-height: 62px;
        padding: 12px 14px;
        border: 1px solid var(--surface-border);
        border-radius: 12px;
        background: var(--surface-soft);
        color: var(--body-text);
        text-decoration: none;
        font-size: 11px;
        font-weight: 600;
        line-height: 1.45;
        transition: background .18s ease, border-color .18s ease, transform .18s ease;
    }

    .ticket-category-item:hover {
        background: var(--table-hover-bg);
        border-color: #3b6fd4;
        color: var(--body-text);
        transform: translateY(-1px);
    }

    .ticket-category-number {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 30px;
        height: 30px;
        min-width: 30px;
        margin-right: 10px;
        border-radius: 9px;
        background: rgba(59, 111, 212, .10);
        border: 1px solid rgba(59, 111, 212, .25);
        color: #3b6fd4;
        font-size: 10px;
        font-weight: 700;
    }

    :root[data-theme="dark"] .ticket-category-item {
        background: rgba(255, 255, 255, .025);
    }

    :root[data-theme="dark"] .ticket-category-number {
        background: rgba(59, 111, 212, .14);
        border-color: rgba(91, 145, 218, .35);
        color: #8bb8ff;
    }

    @media (max-width: 767.98px) {
        .ticket-category-modal .modal-body {
            padding: 14px;
        }

        .ticket-category-grid {
            grid-template-columns: 1fr;
            gap: 8px;
        }
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .ticket-category-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 991.98px) {
        .sidebar-brand { padding: 0 15px; font-size: 14px; }
        .sidebar-nav a { padding: 0 17px; }
        .summary-section { padding: 16px; margin: 0 12px 14px; }
        .table-container { margin: 0 12px 18px; padding: 12px 14px 16px; }
        .summary-counters { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .summary-counter { min-width: 0; }
        .dataTables_wrapper .dataTables_filter input { width: 170px; }
        .summary-actions { margin-left: 0; }
    }

    @media (max-width: 767.98px) {
        .top-navbar { padding: 0 14px; }
        body.sidebar-open .top-navbar { left: 0; }
        body.sidebar-open .main-content { margin-left: 0; }
        .sidebar { width: 260px; }
        .main-content { margin-left: 0; }
        .content-header { min-height: 42px; padding: 0 12px; }
        .summary-section { align-items: flex-start; flex-direction: column; gap: 12px; padding: 16px; }
        .summary-counters { width: 100%; gap: 8px; }
        .summary-counter { font-size: 10px; padding: 8px 12px; min-height: 56px; }
        .summary-counter strong { font-size: 18px; }
        .table-container { margin: 0 12px 18px; padding: 10px 12px 14px; }
        .dataTables_wrapper .dataTables_filter { text-align: left; }
        .dataTables_wrapper .dataTables_filter label { justify-content: flex-start; }
        .dataTables_wrapper .dataTables_filter input { width: 100%; }
        .user-info { display: none; }
        .profile-dropdown-menu { min-width: 200px; }
        .summary-actions {
            width: 100%;
            justify-content: flex-start;
            margin-left: 0;
        }
        .btn-delete-selected,
        .btn-view-all {
            font-size: 11px;
            height: 34px;
            padding: 0 12px;
        }
    }

    @media (max-width: 480px) {
        .summary-counters { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .summary-counter { font-size: 9px; min-height: 50px; }
        .summary-counter strong { font-size: 16px; }
        .table-container { margin: 0 7px 12px; padding: 8px 10px 12px; }
        .summary-actions {
            flex-direction: column;
            align-items: stretch;
        }
        .btn-delete-selected,
        .btn-view-all {
            justify-content: center;
            width: 100%;
        }
        .auto-reload {
            justify-content: center;
        }
    }
</style>
</head>
<?php include "views/inc/notification.php" ?>