<?php

$Ltable_name = "login";
$Ltable_sn = $user_sn = 0;
$page_controller = base64_encode("users");

$users_preview = $LoadUsersAndLoginTableForAdmin['all'] ?? [];
$is_sample_user = false;

if (empty($users_preview)) {
    $is_sample_user = true;

    $users_preview = [
        [
            'login_sn' => 0,
            'user_sn' => 0,
            'user_userid' => 'sample_user',
            'user_fullname' => 'John Doe',
            'user_email' => 'john.doe@example.com',
            'user_title' => 'System Administrator',
            'login_role' => 'Administrator',
            'user_date' => date('Y-m-d H:i:s'),
            'login_status' => 1,
            'status' => 1,
            'user_image' => 'noimage2.png',
            'corridor_name' => 'Lagos Corridor'
        ]
    ];
}

?>

<style>
/* =========================================================
   USER PREVIEW
   Theme-aware styles: preserves the existing application
   palette and adapts to the active light/dark theme.
========================================================= */

.user-preview-page {
    --up-bg: var(--surface-bg, var(--bs-card-bg, #ffffff));
    --up-soft-bg: var(--surface-soft, var(--bs-tertiary-bg, #f4f6fa));
    --up-text: var(--body-text, var(--bs-body-color, #343a40));
    --up-muted: var(--text-muted, var(--bs-secondary-color, #6c7293));
    --up-border: var(--surface-border, var(--bs-border-color, #dee2e6));
    --up-head-bg: var(--table-head-bg, var(--up-soft-bg));
    --up-cell-bg: var(--table-cell-bg, var(--up-bg));
    --up-hover-bg: var(--table-hover-bg, rgba(108, 114, 147, 0.08));

    width: 100%;
    min-width: 0;
    color: var(--up-text);
}

.user-preview-page .user-preview-card {
    margin: 0 24px 20px;
    padding: 22px 24px;
    color: var(--up-text);
    background: var(--up-bg);
    border: 1px solid var(--up-border);
    border-radius: 16px;
    box-shadow: 0 4px 18px rgba(0, 0, 0, 0.045);
}

.user-preview-page .user-preview-heading {
    color: var(--up-text);
    font-size: 1.15rem;
    font-weight: 600;
    margin: 0 0 5px;
}

.user-preview-page .user-preview-subtitle {
    color: var(--up-muted);
    font-size: 0.875rem;
    margin: 0;
}

.user-preview-page .user-preview-view-all {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    padding: 8px 13px;
    border: 1px solid var(--up-border);
    border-radius: 8px;
    color: var(--up-text);
    background: var(--up-soft-bg);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    transition: background 0.2s ease, border-color 0.2s ease;
}

.user-preview-page .user-preview-view-all:hover {
    background: var(--up-hover-bg);
    border-color: var(--up-muted);
    color: var(--up-text);
    text-decoration: none;
}

.user-preview-page .user-preview-notice {
    color: var(--up-text);
    background: var(--up-soft-bg);
    border: 1px solid var(--up-border);
    border-radius: 8px;
    padding: 10px 13px;
    margin: 18px 0;
    font-size: 0.84rem;
}

.user-preview-page .user-preview-table-wrap {
    width: 100%;
    padding: 16px 20px 20px;
    border: 1px solid var(--up-border);
    border-radius: 12px;
    background: var(--up-bg);
}

.user-preview-page #dashboardDataTable {
    width: 100% !important;
    margin-bottom: 0 !important;
    color: var(--up-text);
    border-color: var(--up-border);
}

.user-preview-page #dashboardDataTable thead th {
    color: var(--up-text) !important;
    background: var(--up-head-bg) !important;
    border-color: var(--up-border) !important;
    font-size: 0.79rem;
    font-weight: 600;
    padding: 13px 11px;
    vertical-align: middle;
    white-space: nowrap;
}

.user-preview-page #dashboardDataTable tbody td {
    color: var(--up-text) !important;
    background: var(--up-cell-bg) !important;
    border-color: var(--up-border) !important;
    padding: 12px 11px;
    vertical-align: middle;
    font-size: 0.82rem;
}

.user-preview-page #dashboardDataTable tbody tr:hover td {
    background: var(--up-hover-bg) !important;
}

.user-preview-page .user-preview-person {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 175px;
}

.user-preview-page .user-preview-avatar {
    width: 39px;
    height: 39px;
    min-width: 39px;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid var(--up-border);
    background: var(--up-soft-bg);
}

.user-preview-page .user-preview-person-name {
    color: var(--up-text);
    font-weight: 600;
    line-height: 1.4;
    overflow-wrap: anywhere;
}

.user-preview-page .user-preview-person-email {
    color: var(--up-muted);
    font-size: 0.75rem;
    margin-top: 2px;
    overflow-wrap: anywhere;
}

.user-preview-page .user-preview-muted {
    color: var(--up-muted) !important;
}

.user-preview-page .user-preview-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 5px 9px;
    border-radius: 6px;
    font-size: 0.75rem;
    font-weight: 600;
    white-space: nowrap;
}

.user-preview-page .user-preview-status-active {
    color: #16834a;
    background: rgba(40, 167, 69, 0.13);
    border: 1px solid rgba(40, 167, 69, 0.28);
}

.user-preview-page .user-preview-status-inactive {
    color: #a66a00;
    background: rgba(230, 166, 35, 0.14);
    border: 1px solid rgba(230, 166, 35, 0.3);
}

.user-preview-page .user-preview-status-deleted {
    color: #cf4b55;
    background: rgba(220, 53, 69, 0.12);
    border: 1px solid rgba(220, 53, 69, 0.28);
}

/* Action buttons: text and inline SVG remain visible without icon fonts. */

.user-preview-page .user-preview-actions {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: nowrap;
    gap: 7px;
    min-width: 125px;
}

.user-preview-page .user-preview-action {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 34px;
    padding: 6px 9px;
    border: 1px solid var(--up-border);
    border-radius: 7px;
    font-size: 0.78rem;
    font-weight: 600;
    line-height: 1.2;
    text-decoration: none !important;
    white-space: nowrap;
    cursor: pointer;
    opacity: 1 !important;
    visibility: visible !important;
    box-shadow: none;
    transition: background 0.18s ease, border-color 0.18s ease;
}

.user-preview-page .user-preview-action svg {
    display: block !important;
    width: 16px !important;
    height: 16px !important;
    min-width: 16px;
    fill: none;
    stroke: currentColor;
    stroke-width: 1.8;
    stroke-linecap: round;
    stroke-linejoin: round;
    visibility: visible !important;
    opacity: 1 !important;
}

.user-preview-page .user-preview-action-edit {
    color: #2474c7 !important;
    background: rgba(36, 116, 199, 0.10) !important;
    border-color: rgba(36, 116, 199, 0.35) !important;
}

.user-preview-page .user-preview-action-edit:hover {
    color: #ffffff !important;
    background: #2474c7 !important;
    border-color: #2474c7 !important;
}

.user-preview-page .user-preview-action-delete {
    color: #d44752 !important;
    background: rgba(212, 71, 82, 0.10) !important;
    border-color: rgba(212, 71, 82, 0.35) !important;
}

.user-preview-page .user-preview-action-delete:hover {
    color: #ffffff !important;
    background: #c93642 !important;
    border-color: #c93642 !important;
}

.user-preview-page .user-preview-action-restore {
    color: #16834a !important;
    background: rgba(40, 167, 69, 0.10) !important;
    border-color: rgba(40, 167, 69, 0.35) !important;
}

.user-preview-page .user-preview-action-restore:hover {
    color: #ffffff !important;
    background: #16834a !important;
    border-color: #16834a !important;
}

.user-preview-page .user-preview-action-disabled {
    opacity: 0.55 !important;
    cursor: not-allowed !important;
}

/* DataTables controls follow the current theme. */

.user-preview-page .dataTables_wrapper,
.user-preview-page .dataTables_wrapper label,
.user-preview-page .dataTables_info,
.user-preview-page .dataTables_length,
.user-preview-page .dataTables_filter {
    color: var(--up-text) !important;
}

.user-preview-page .dataTables_wrapper .dataTables_filter input,
.user-preview-page .dataTables_wrapper .dataTables_length select {
    color: var(--up-text) !important;
    background: var(--up-soft-bg) !important;
    border: 1px solid var(--up-border) !important;
    border-radius: 7px;
    padding: 7px 10px;
    outline: none;
}

.user-preview-page .dataTables_wrapper .dataTables_filter input::placeholder {
    color: var(--up-muted) !important;
    opacity: 1;
}

.user-preview-page .dataTables_wrapper .dataTables_paginate .paginate_button {
    color: var(--up-text) !important;
    background: var(--up-bg) !important;
    border: 1px solid var(--up-border) !important;
    border-radius: 6px;
    margin: 0 2px;
}

.user-preview-page .dataTables_wrapper .dataTables_paginate .paginate_button.current,
.user-preview-page .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
    color: #ffffff !important;
    background: #2474c7 !important;
    border-color: #2474c7 !important;
}

.user-preview-page .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    color: var(--up-text) !important;
    background: var(--up-hover-bg) !important;
    border-color: var(--up-border) !important;
}

.user-preview-page .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
    color: var(--up-muted) !important;
    opacity: 0.55;
}

/* Export buttons (Excel, PDF) styling */

.user-preview-page .dt-buttons {
    display: inline-flex;
    flex-wrap: wrap;
    gap: 6px;
    margin-left: 12px;
    vertical-align: middle;
}

.user-preview-page .dt-button {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 34px;
    padding: 6px 12px !important;
    border: 1px solid var(--up-border) !important;
    border-radius: 7px !important;
    background: var(--up-soft-bg) !important;
    color: var(--up-text) !important;
    font-size: 0.78rem !important;
    font-weight: 600 !important;
    line-height: 1.2 !important;
    text-decoration: none !important;
    white-space: nowrap;
    cursor: pointer;
    box-shadow: none !important;
    transition: background 0.18s ease, border-color 0.18s ease;
}

.user-preview-page .dt-button:hover {
    background: var(--up-hover-bg) !important;
    border-color: var(--up-muted) !important;
    color: var(--up-text) !important;
}

.user-preview-page .dt-button.buttons-excel {
    color: #1f7a3d !important;
    background: rgba(31, 122, 61, 0.10) !important;
    border-color: rgba(31, 122, 61, 0.35) !important;
}

.user-preview-page .dt-button.buttons-excel:hover {
    color: #ffffff !important;
    background: #1f7a3d !important;
    border-color: #1f7a3d !important;
}

.user-preview-page .dt-button.buttons-pdf {
    color: #c93642 !important;
    background: rgba(201, 54, 66, 0.10) !important;
    border-color: rgba(201, 54, 66, 0.35) !important;
}

.user-preview-page .dt-button.buttons-pdf:hover {
    color: #ffffff !important;
    background: #c93642 !important;
    border-color: #c93642 !important;
}

/* Delete and restore modals. */

.user-preview-modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 99990;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(0, 0, 0, 0.58);
}

.user-preview-modal-backdrop.is-open {
    display: flex;
}

.user-preview-modal {
    width: 100%;
    max-width: 440px;
    color: var(--body-text, var(--bs-body-color, #343a40));
    background: var(--surface-bg, var(--bs-card-bg, #ffffff));
    border: 1px solid var(--surface-border, var(--bs-border-color, #dee2e6));
    border-radius: 14px;
    padding: 24px;
    box-shadow: 0 16px 50px rgba(0, 0, 0, 0.25);
}

.user-preview-modal h5 {
    color: var(--body-text, var(--bs-body-color, #343a40));
    margin: 0 0 12px;
    font-size: 1.05rem;
    font-weight: 600;
}

.user-preview-modal p {
    color: var(--body-text, var(--bs-body-color, #343a40));
    margin: 0 0 20px;
    line-height: 1.6;
    font-size: 0.9rem;
}

.user-preview-modal-actions {
    display: flex;
    justify-content: flex-end;
    gap: 9px;
    flex-wrap: wrap;
}

.user-preview-modal-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-height: 36px;
    padding: 8px 14px;
    border-radius: 7px;
    border: 1px solid var(--surface-border, var(--bs-border-color, #dee2e6));
    font-size: 0.85rem;
    font-weight: 600;
    cursor: pointer;
}

.user-preview-modal-cancel {
    color: var(--body-text, var(--bs-body-color, #343a40));
    background: var(--surface-soft, var(--bs-tertiary-bg, #f4f6fa));
}

.user-preview-modal-delete {
    color: #ffffff;
    background: #c93642;
    border-color: #c93642;
}

.user-preview-modal-restore {
    color: #ffffff;
    background: #16834a;
    border-color: #16834a;
}

@media (max-width: 768px) {
    .user-preview-page .user-preview-card {
        margin: 0 8px 16px;
        padding: 16px 12px;
    }

    .user-preview-page .user-preview-table-wrap {
        padding: 10px;
    }

    .user-preview-page .user-preview-actions {
        gap: 5px;
    }

    .user-preview-page .user-preview-action {
        padding: 6px;
    }

    .user-preview-page .user-preview-action-label {
        display: none;
    }

    .user-preview-page .dt-buttons {
        margin-left: 0;
        margin-top: 8px;
        width: 100%;
    }
}
</style>

<!-- DataTables + Buttons CSS (ensure these are loaded; if already in layout, you may remove duplicates) -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css">

<section class="user-preview-page">
    <div class="user-preview-card">

        <div class="d-flex justify-content-between align-items-center flex-wrap"
             style="gap: 14px; margin-bottom: 20px;">

            <div>
                <h4 class="user-preview-heading">Recent Activity</h4>
                <p class="user-preview-subtitle">
                    Overview of recent system users
                </p>
            </div>

            <?php if (($page_name ?? '') === 'dashboard') { ?>
                <a href="index?action=users" class="user-preview-view-all">
                    View All
                    <svg viewBox="0 0 24 24" width="16" height="16"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round"
                         aria-hidden="true">
                        <path d="M5 12h14"></path>
                        <path d="m13 6 6 6-6 6"></path>
                    </svg>
                </a>
            <?php } ?>
        </div>

        <?php if ($is_sample_user) { ?>
            <div class="user-preview-notice">
                <strong>Preview mode:</strong>
                This is a sample record displayed because no user records
                were returned. It is not saved in the database.
            </div>
        <?php } ?>

        <div class="user-preview-table-wrap">
            <div class="table-responsive">
                <table id="dashboardDataTable"
                       class="table table-hover align-middle"
                       style="width:100%;">

                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>User</th>
                            <th>Title</th>
                            <th>Role</th>
                            <th>Corridor</th>
                            <th>Date &amp; Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                    <?php
                    $Ltable_sn = 0;

                    foreach ($users_preview as $user) {
                        $Ltable_sn++;

                        $Luser_sn = (int)($user['user_sn'] ?? 0);
                        $Llogin_sn = (int)($user['login_sn'] ?? 0);
                        $user_id = $user['user_userid'] ?? '';
                        $user_name = $user['user_fullname'] ?? 'N/A';
                        $user_email = $user['user_email'] ?? 'N/A';
                        $user_title = $user['user_title'] ?? 'N/A';
                        $user_role = $user['login_role'] ?? 'N/A';
                        $user_date = $user['user_date'] ?? '';
                        $user_image = $user['user_image'] ?? 'noimage2.png';

                        $user_corridor =
                            $user['corridor_name']
                            ?? $user['user_corridor']
                            ?? $user['corridor']
                            ?? $user['corridorname']
                            ?? $user['user_corridor_name']
                            ?? 'N/A';

                        $user_status = (int)(
                            $user['login_status']
                            ?? $user['status']
                            ?? 0
                        );

                        if ($user_status === 1) {
                            $status_text = 'Active';
                            $status_class = 'user-preview-status-active';
                        } elseif ($user_status === 0) {
                            $status_text = 'Inactive';
                            $status_class = 'user-preview-status-inactive';
                        } else {
                            $status_text = 'Deleted';
                            $status_class = 'user-preview-status-deleted';
                        }

                        $is_admin_user = (
                            isset($company_adminseniorman, $user_id)
                            && (string)$company_adminseniorman === (string)$user_id
                        );

                        $is_sample_row = !empty($user['_is_sample'])
                            || ($is_sample_user && $Ltable_sn === 1);

                        $image_file = basename((string)$user_image);
                        $image_path = 'views/uploads/img/profile/' . $image_file;

                        $edit_url = 'index?action=edit_user&token='
                            . urlencode(base64_encode((string)$user_id));

                        $delete_token = base64_encode(json_encode([
                            'sn' => $Luser_sn,
                            'table_name' => $Ltable_name,
                            'user_name' => $user_name,
                            'page_controller' => $page_controller
                        ]));

                        $delete_url = 'index?action=delete_user&sn='
                            . urlencode((string)$Llogin_sn)
                            . '&table_name='
                            . urlencode($Ltable_name);
                    ?>
                        <tr>
                            <td><?= $Ltable_sn; ?></td>

                            <td>
                                <div class="user-preview-person">
                                    <img
                                        src="<?= htmlspecialchars($image_path, ENT_QUOTES, 'UTF-8'); ?>"
                                        class="user-preview-avatar"
                                        alt="User"
                                        onerror="this.onerror=null;this.src='views/uploads/img/profile/noimage2.png';">

                                    <div>
                                        <div class="user-preview-person-name">
                                            <?= htmlspecialchars((string)$user_name, ENT_QUOTES, 'UTF-8'); ?>

                                            <?php if ($is_admin_user) { ?>
                                                <span title="Senior Administrator"
                                                      style="color:#d6a52d; margin-left:3px;">
                                                    ★
                                                </span>
                                            <?php } ?>
                                        </div>

                                        <div class="user-preview-person-email">
                                            <?= htmlspecialchars((string)$user_email, ENT_QUOTES, 'UTF-8'); ?>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <td><?= htmlspecialchars((string)$user_title, ENT_QUOTES, 'UTF-8'); ?></td>

                            <td><?= htmlspecialchars((string)$user_role, ENT_QUOTES, 'UTF-8'); ?></td>

                            <td>
                                <?= htmlspecialchars((string)$user_corridor, ENT_QUOTES, 'UTF-8'); ?>
                            </td>

                            <td>
                                <?php if (!empty($user_date)) { ?>
                                    <?= htmlspecialchars((string)$user_date, ENT_QUOTES, 'UTF-8'); ?>
                                <?php } else { ?>
                                    <span class="user-preview-muted">N/A</span>
                                <?php } ?>
                            </td>

                            <td>
                                <span class="user-preview-status <?= $status_class; ?>">
                                    <?= htmlspecialchars($status_text, ENT_QUOTES, 'UTF-8'); ?>
                                </span>
                            </td>

                            <td>
                                <div class="user-preview-actions">
                                    <?php if (!$is_sample_row && $user_status !== -1) { ?>

                                        <a
                                            href="<?= htmlspecialchars($edit_url, ENT_QUOTES, 'UTF-8'); ?>"
                                            class="user-preview-action user-preview-action-edit"
                                            title="Edit user"
                                            aria-label="Edit user">

                                            <svg viewBox="0 0 24 24"
                                                 aria-hidden="true">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"></path>
                                            </svg>

                                            <span class="user-preview-action-label">Edit</span>
                                        </a>

                                    <?php } ?>

                                    <?php if (!$is_sample_row && $user_status === -1) { ?>

                                        <button
                                            type="button"
                                            class="user-preview-action user-preview-action-restore"
                                            title="Restore user"
                                            aria-label="Restore user"
                                            onclick="showRestoreModal(
                                                <?= htmlspecialchars(json_encode((string)$delete_token), ENT_QUOTES, 'UTF-8'); ?>
                                            )">

                                            <svg viewBox="0 0 24 24"
                                                 aria-hidden="true">
                                                <path d="M3 12a9 9 0 1 0 3-6.7"></path>
                                                <path d="M3 4v5h5"></path>
                                                <path d="M12 7v5l3 2"></path>
                                            </svg>

                                            <span class="user-preview-action-label">Restore</span>
                                        </button>

                                    <?php } elseif (!$is_sample_row) { ?>

                                        <button
                                            type="button"
                                            class="user-preview-action user-preview-action-delete"
                                            title="Delete user"
                                            aria-label="Delete user"
                                            onclick="showDeleteModal(
                                                <?= (int)$Llogin_sn; ?>,
                                                <?= htmlspecialchars(json_encode((string)$Ltable_name), ENT_QUOTES, 'UTF-8'); ?>
                                            )">

                                            <svg viewBox="0 0 24 24"
                                                 aria-hidden="true">
                                                <path d="M3 6h18"></path>
                                                <path d="M8 6V4h8v2"></path>
                                                <path d="m19 6-1 14H6L5 6"></path>
                                                <path d="M10 11v5"></path>
                                                <path d="M14 11v5"></path>
                                            </svg>

                                            <span class="user-preview-action-label">Delete</span>
                                        </button>

                                    <?php } else { ?>

                                        <span
                                            class="user-preview-action user-preview-action-edit user-preview-action-disabled"
                                            title="Sample preview only">
                                            <svg viewBox="0 0 24 24"
                                                 aria-hidden="true">
                                                <path d="M12 20h9"></path>
                                                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"></path>
                                            </svg>
                                            <span class="user-preview-action-label">Edit</span>
                                        </span>

                                        <span
                                            class="user-preview-action user-preview-action-delete user-preview-action-disabled"
                                            title="Sample preview only">
                                            <svg viewBox="0 0 24 24"
                                                 aria-hidden="true">
                                                <path d="M3 6h18"></path>
                                                <path d="M8 6V4h8v2"></path>
                                                <path d="m19 6-1 14H6L5 6"></path>
                                                <path d="M10 11v5"></path>
                                                <path d="M14 11v5"></path>
                                            </svg>
                                            <span class="user-preview-action-label">Delete</span>
                                        </span>

                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>

                </table>
            </div>
        </div>
    </div>
</section>

<!-- Delete confirmation modal -->
<div class="user-preview-modal-backdrop"
     id="deleteModal"
     role="dialog"
     aria-modal="true"
     aria-labelledby="userPreviewDeleteTitle">

    <div class="user-preview-modal">
        <h5 id="userPreviewDeleteTitle">Confirm Delete</h5>

        <p>
            Are you sure you want to delete this user?
            This action cannot be undone from this confirmation.
        </p>

        <div class="user-preview-modal-actions">
            <button type="button"
                    class="user-preview-modal-btn user-preview-modal-cancel"
                    onclick="closeUserPreviewModal('deleteModal')">
                Cancel
            </button>

            <button type="button"
                    class="user-preview-modal-btn user-preview-modal-delete"
                    id="confirmDeleteBtn">
                Delete User
            </button>
        </div>
    </div>
</div>

<!-- Restore confirmation modal -->
<div class="user-preview-modal-backdrop"
     id="restoreModal"
     role="dialog"
     aria-modal="true"
     aria-labelledby="userPreviewRestoreTitle">

    <div class="user-preview-modal">
        <h5 id="userPreviewRestoreTitle">Restore User</h5>

        <p>
            Are you sure you want to restore this user?
        </p>

        <div class="user-preview-modal-actions">
            <button type="button"
                    class="user-preview-modal-btn user-preview-modal-cancel"
                    onclick="closeUserPreviewModal('restoreModal')">
                Cancel
            </button>

            <button type="button"
                    class="user-preview-modal-btn user-preview-modal-restore"
                    id="confirmRestoreBtn">
                Restore User
            </button>
        </div>
    </div>
</div>

<!-- DataTables & Buttons JS libraries -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script>
(function () {
    'use strict';

    let userPreviewDeleteSn = null;
    let userPreviewDeleteTable = 'login';
    let userPreviewRestoreToken = null;

    window.showDeleteModal = function (sn, tableName) {
        userPreviewDeleteSn = sn;
        userPreviewDeleteTable = tableName || 'login';

        const modal = document.getElementById('deleteModal');

        if (modal) {
            modal.classList.add('is-open');
        }
    };

    window.showRestoreModal = function (token) {
        userPreviewRestoreToken = token;

        const modal = document.getElementById('restoreModal');

        if (modal) {
            modal.classList.add('is-open');
        }
    };

    window.closeUserPreviewModal = function (modalId) {
        const modal = document.getElementById(modalId);

        if (modal) {
            modal.classList.remove('is-open');
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const confirmRestoreBtn = document.getElementById('confirmRestoreBtn');

        if (confirmDeleteBtn) {
            confirmDeleteBtn.addEventListener('click', function () {
                if (userPreviewDeleteSn === null) {
                    return;
                }

                const url = 'index?action=delete_user'
                    + '&sn=' + encodeURIComponent(userPreviewDeleteSn)
                    + '&table_name=' + encodeURIComponent(userPreviewDeleteTable);

                window.location.href = url;
            });
        }

        if (confirmRestoreBtn) {
            confirmRestoreBtn.addEventListener('click', function () {
                if (!userPreviewRestoreToken) {
                    return;
                }

                const pageController = <?= json_encode((string)$page_controller); ?>;

                window.location.href = 'index?action=restore_user'
                    + '&token=' + encodeURIComponent(userPreviewRestoreToken)
                    + '&page_controller=' + encodeURIComponent(pageController);
            });
        }

        document.querySelectorAll('.user-preview-modal-backdrop').forEach(function (modal) {
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    modal.classList.remove('is-open');
                }
            });
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.user-preview-modal-backdrop.is-open')
                    .forEach(function (modal) {
                        modal.classList.remove('is-open');
                    });
            }
        });

        if (window.jQuery && jQuery.fn && jQuery.fn.DataTable) {
            if (!jQuery.fn.DataTable.isDataTable('#dashboardDataTable')) {
                jQuery('#dashboardDataTable').DataTable({
                    pageLength: 10,
                    lengthMenu: [10, 25, 50, 100],
                    searching: true,
                    ordering: true,
                    responsive: false,
                    autoWidth: false,
                    order: [],
                    dom: '<"row align-items-center"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
                         '<"row align-items-center"<"col-sm-12 col-md-6"B><"col-sm-12 col-md-6"i>>' +
                         '<"row"<"col-sm-12"tr>>' +
                         '<"row align-items-center"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            text: '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;margin-right:4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="12" y1="18" x2="12" y2="12"></line><polyline points="9 15 12 12 15 15"></polyline></svg> Excel',
                            className: 'buttons-excel',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6],
                                format: {
                                    body: function (data, row, column, node) {
                                        // Strip HTML tags from User column (index 1) for export
                                        if (column === 1) {
                                            var tempDiv = document.createElement('div');
                                            tempDiv.innerHTML = data;
                                            var name = tempDiv.querySelector('.user-preview-person-name');
                                            var email = tempDiv.querySelector('.user-preview-person-email');
                                            var result = '';
                                            if (name) result += name.textContent.trim();
                                            if (email) result += ' (' + email.textContent.trim() + ')';
                                            return result || data;
                                        }
                                        return data;
                                    }
                                }
                            },
                            title: 'User Activity Export'
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" style="display:inline-block;vertical-align:middle;margin-right:4px;"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg> PDF',
                            className: 'buttons-pdf',
                            exportOptions: {
                                columns: [0, 1, 2, 3, 4, 5, 6],
                                format: {
                                    body: function (data, row, column, node) {
                                        if (column === 1) {
                                            var tempDiv = document.createElement('div');
                                            tempDiv.innerHTML = data;
                                            var name = tempDiv.querySelector('.user-preview-person-name');
                                            var email = tempDiv.querySelector('.user-preview-person-email');
                                            var result = '';
                                            if (name) result += name.textContent.trim();
                                            if (email) result += ' (' + email.textContent.trim() + ')';
                                            return result || data;
                                        }
                                        return data;
                                    }
                                }
                            },
                            title: 'User Activity Report',
                            orientation: 'landscape',
                            pageSize: 'A4',
                            customize: function (doc) {
                                // Optional: adjust PDF styling
                                doc.styles.tableHeader.fillColor = '#f4f6fa';
                                doc.styles.tableHeader.color = '#343a40';
                                doc.styles.tableHeader.bold = true;
                            }
                        }
                    ],
                    columnDefs: [
                        {
                            targets: [0, 7],
                            orderable: false
                        },
                        {
                            targets: 7,
                            visible: false // Hide Action column in export via exportOptions
                        }
                    ],
                    language: {
                        search: 'Search:',
                        searchPlaceholder: 'Search users...',
                        lengthMenu: 'Show _MENU_ records',
                        info: 'Showing _START_ to _END_ of _TOTAL_ records',
                        infoEmpty: 'Showing 0 to 0 of 0 records',
                        zeroRecords: 'No matching users found',
                        emptyTable: 'No user records available',
                        paginate: {
                            previous: 'Previous',
                            next: 'Next'
                        },
                        buttons: {
                            excel: 'Excel',
                            pdf: 'PDF'
                        }
                    }
                });
            }
        }
    });
})();
</script>