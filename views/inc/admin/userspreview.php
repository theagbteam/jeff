<?php

$Ltable_name = "login";
$users_table_name = "users";
$Ltable_sn = $user_sn = 0;
$page_controller = base64_encode("users");

// ------------------------------------------------------------
// SUMMARY COUNTS (active / inactive / deleted)
// Read counts from the controller
// ------------------------------------------------------------
$statusCounts = $statusCounts ?? [];

$totalActiveUsers   = (int) ($statusCounts['active'] ?? 0);
$totalInactiveUsers = (int) ($statusCounts['inactive'] ?? 0);
$totalDeletedUsers  = (int) ($statusCounts['deleted'] ?? 0);

// Total users excludes deleted users
$totalAllUsers = $totalActiveUsers + $totalInactiveUsers;

?>


<div class="row">

    <div class="col-12">

        <div class="users-activity-card">

            <div class="users-activity-header">

                <div>
                    <h4 class="users-activity-title">Users summary</h4>
                    <p class="users-activity-description">Overview of recent system users</p>
                </div>

                <?php if ($page_name == "dashboard") : ?>

                    <a href="index?action=users" class="btn-view-all">
                        <i class="mdi mdi-account-multiple-outline"></i>
                        View All
                    </a>

                <?php endif; ?>

            </div>

            <!-- ============================================
                 USER STATUS SUMMARY CARDS
            ============================================ -->
            <div class="users-summary-stats">

                <div class="summary-stat-card summary-stat-total">
                    <div class="summary-stat-icon">
                        <i class="mdi mdi-account-group-outline"></i>
                    </div>
                    <div class="summary-stat-info">
                        <span class="summary-stat-value"><?= number_format($totalAllUsers); ?></span>
                        <span class="summary-stat-label">Total Users</span>
                    </div>
                </div>

                <div class="summary-stat-card summary-stat-active">
                    <div class="summary-stat-icon">
                        <i class="mdi mdi-account-check-outline"></i>
                    </div>
                    <div class="summary-stat-info">
                        <span class="summary-stat-value"><?= number_format($totalActiveUsers); ?></span>
                        <span class="summary-stat-label">Active</span>
                    </div>
                </div>

                <div class="summary-stat-card summary-stat-inactive">
                    <div class="summary-stat-icon">
                        <i class="mdi mdi-account-clock-outline"></i>
                    </div>
                    <div class="summary-stat-info">
                        <span class="summary-stat-value"><?= number_format($totalInactiveUsers); ?></span>
                        <span class="summary-stat-label">Inactive</span>
                    </div>
                </div>

                <div class="summary-stat-card summary-stat-deleted">
                    <div class="summary-stat-icon">
                        <i class="mdi mdi-account-remove-outline"></i>
                    </div>
                    <div class="summary-stat-info">
                        <span class="summary-stat-value"><?= number_format($totalDeletedUsers); ?></span>
                        <span class="summary-stat-label">All deleted</span>
                    </div>
                </div>

            </div>

            <div class="table-container users-activity-table-container">

                <table class="dashboard-datatable ticket-table" id="dashboardDataTable">

                    <thead>
                        <tr>
                            <th class="center-header">S/N</th>
                            <th>User</th>
                            <th>Corridor</th>
                            <th>Status</th>
                            <th>Date &amp; Time</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php if (!empty($LoadAllUsersAndLoginTableForAdmin['all'])): ?>

                            <?php $sn = 1; ?>

                            <?php foreach ($LoadAllUsersAndLoginTableForAdmin['all'] as $user): ?>

                                <?php

                                $user_image = "noimage2.png";

                                $Luser_sn = $user['login_sn'];
                               
                                $user_sn = $user['user_sn'] ?? 0;

                                if (!empty($user['user_image'])) {
                                    $user_image = $user['user_image'];
                                }

                                $user_id = $user['user_userid'] ?? '';
                                
                                $user_name = $user['user_fullname'] ?? 'N/A';

                                // determine status ball class
                                $login_status = $user['login_status'] ?? null;

                                if ($login_status == 1) {
                                    $status_ball_class = 'status-ball-active';
                                    $status_text = 'Active';
                                } elseif ($login_status == 0) {
                                    $status_ball_class = 'status-ball-inactive';
                                    $status_text = 'Inactive';
                                } else {
                                    $status_ball_class = 'status-ball-deleted';
                                    $status_text = 'Deleted';
                                }

                                ?>

                                <tr>

                                    <td class="center-cell">
                                        <?= $sn++; ?>
                                    </td>

                                    <td>
                                        <div class="dashboard-table-user">

                                            <img
                                                class="dashboard-table-avatar"
                                                src="views/uploads/img/profile/<?= htmlspecialchars($user_image, ENT_QUOTES, 'UTF-8'); ?>"
                                                alt="User"
                                                loading="lazy"
                                                onerror="this.onerror=null;this.src='views/uploads/img/noimage2.png';"
                                            >

                                            <div class="dashboard-table-user-details">

                                                <div class="dashboard-table-user-name">
                                                    <span class="status-ball <?= $status_ball_class; ?>" aria-hidden="true"></span>
                                                    <?= ucfirst(htmlspecialchars($user['user_title'])) ." " .ucfirst(htmlspecialchars($user['user_fullname'] ." (". ucfirst(htmlspecialchars($user['login_role'])).")" ?? 'N/A', ENT_QUOTES, 'UTF-8')); ?>
                                                    <?php if ($company_supervisorseniorman == $user['user_userid']): ?>
                                                        <span class="supervisor-crown" aria-label="Supervisor" title="Supervisor">👑</span>
                                                    <?php endif; ?>
                                             <?php if ( $company_adminseniorman == $user['user_userid']){ echo "👑"; } ?>
                                                </div>

                                                <div class="dashboard-table-user-email">
                                                    <?= htmlspecialchars($user['user_email'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                                </div>

                                            </div>

                                        </div>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($user['user_corridor'] ?? 'N/A', ENT_QUOTES, 'UTF-8'); ?>
                                    </td>

                                    <td class="users-status-cell">
                                        <span class="status-badge <?= $status_ball_class; ?>">
                                            <?= $status_text; ?>
                                        </span>
                                    </td>

                                    <td class="users-activity-date">
                                        <?= !empty($user['user_date'])
                                            ? date('d M Y, h:i A', strtotime($user['user_date']))
                                            : 'N/A';
                                        ?>
                                    </td>

                                    <td class="users-activity-action-cell">

                                      
                                    
                                    <!-- start here -->
                                    <?php if (($user['login_status'] ?? '') == 0 || ($user['login_status'] ?? '') == 1): ?>
                                    
                                  <?php if (($user['login_role'] == "administrator" ) AND ( $company_adminseniorman != $_SESSION['userid'])) : ?>
                                    
 <?php elseif (($user['login_role'] == "administrator" ) AND ($_SESSION['userid']=="administrator")) : ?>

    <?php else :  ?>

                                            <?php if ($login_edit_user == 1 || $company_adminseniorman == $_SESSION['userid']) : ?>
                                            <button
                                                type="button"
                                                class="dashboard-table-action"
                                                title="Edit"
                                                aria-label="Edit user"
                                                onclick="window.location.href='index?action=edit_user&token_edit=<?= urlencode(base64_encode($user_id)); ?>'"
                                            >
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                            <?php endif; ?>

                                            <?php if (($user['login_status'] ?? '') == 0): ?>
                                                <?php if (!($company_acct_approval == 0 && $company_adminseniorman != $_SESSION['userid'])) : ?>
                                                <button
                                                    type="button"
                                                    class="dashboard-table-action reset-user-btn"
                                                    title="Reset"
                                                    aria-label="Reset user"
                                                    onclick="showResetModal(
                                                        '<?= urlencode(base64_encode($user_id)); ?>',
                                                        <?= htmlspecialchars(json_encode($user_name, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8'); ?>
                                                    )"
                                                >
                                                    <i class="mdi mdi-lock-reset"></i>
                                                </button>
                                                <?php endif; ?>
                                            <?php endif; ?>

                                            <?php if ($login_delete_user == 1 || $company_adminseniorman == $_SESSION['userid']) : ?>
                                            <button
                                                type="button"
                                                class="dashboard-table-action delete-user-btn"
                                                title="Delete"
                                                aria-label="Delete user"
                                                onclick="showDeleteModal(
                                                    '<?= htmlspecialchars((string) $user_sn, ENT_QUOTES, 'UTF-8'); ?>',
                                                    '<?= htmlspecialchars((string) $Luser_sn, ENT_QUOTES, 'UTF-8'); ?>',
                                                    <?= htmlspecialchars(json_encode($user_name, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP), ENT_QUOTES, 'UTF-8'); ?>,
                                                    '<?= htmlspecialchars($users_table_name, ENT_QUOTES, 'UTF-8'); ?>',
                                                    '<?= htmlspecialchars($Ltable_name, ENT_QUOTES, 'UTF-8'); ?>'
                                                )"
                                            >
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                            <?php endif; ?>

                                      
                                        <?php endif; ?>
<?php endif; ?>
 <!-- end here -->   


                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

<!-- DELETE CONFIRMATION MODAL -->

<div id="deleteModal" class="delete-modal-overlay" aria-hidden="true">

    <div class="delete-modal-box" role="dialog" aria-modal="true" aria-labelledby="deleteModalTitle">

        <button type="button" class="delete-modal-close" onclick="closeDeleteModal()" aria-label="Close">
            &times;
        </button>

        <div class="delete-modal-icon">
            <i class="mdi mdi-delete-alert-outline"></i>
        </div>

        <h3 id="deleteModalTitle">Are you sure?</h3>

        <p>
            Do you truly want to delete
            <strong id="deleteUserName">this user</strong>?
        </p>

        <div class="delete-modal-actions">

            <button type="button" class="delete-modal-cancel" onclick="closeDeleteModal()">
                Cancel
            </button>

            <button type="button" class="delete-modal-confirm" id="confirmDeleteBtn">
                <i class="mdi mdi-delete-outline"></i>
                Yes, Delete
            </button>

        </div>

    </div>

</div>

<!-- RESET CONFIRMATION MODAL -->

<div id="resetModal" class="reset-modal-overlay" aria-hidden="true">

    <div class="reset-modal-box" role="dialog" aria-modal="true" aria-labelledby="resetModalTitle">

        <button type="button" class="reset-modal-close" onclick="closeResetModal()" aria-label="Close">
            &times;
        </button>

        <div class="reset-modal-icon">
            <i class="mdi mdi-lock-reset"></i>
        </div>

        <h3 id="resetModalTitle">Reset Account?</h3>

        <p>
            Resetting <strong id="resetUserName">this account</strong> will also
            <strong>activate it</strong> and <strong>notify the user</strong>.
            Continue?
        </p>

        <div class="reset-modal-actions">

            <button type="button" class="reset-modal-cancel" onclick="closeResetModal()">
                Cancel
            </button>

            <button type="button" class="reset-modal-confirm" id="confirmResetBtn">
                <i class="mdi mdi-check-circle-outline"></i>
                Yes, Reset
            </button>

        </div>

    </div>

</div>

<!-- RESTORE CONFIRMATION MODAL -->

<div id="restoreModal" class="restore-modal-overlay" aria-hidden="true">

    <div class="restore-modal-box" role="dialog" aria-modal="true" aria-labelledby="restoreModalTitle">

        <button type="button" class="restore-modal-close" onclick="closeRestoreModal()" aria-label="Close">
            &times;
        </button>

        <div class="restore-modal-icon">
            <i class="mdi mdi-recycle"></i>
        </div>

        <h3 id="restoreModalTitle">Restore User?</h3>

        <p>
            Do you want to restore
            <strong id="restoreUserName">this user</strong>?
        </p>

        <div class="restore-modal-actions">

            <button type="button" class="restore-modal-cancel" onclick="closeRestoreModal()">
                Cancel
            </button>

            <button type="button" class="restore-modal-confirm" id="confirmRestoreBtn">
                <i class="mdi mdi-restore"></i>
                Yes, Restore
            </button>

        </div>

    </div>

</div>

<style>
/* ============================================
   USER SUMMARY STATS CARDS
============================================ */
.users-summary-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 12px;
    margin-bottom: 18px;
}

.summary-stat-card {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 14px 16px;
    border: 1px solid var(--surface-border);
    border-radius: 12px;
    background: var(--surface-soft);
    transition: transform .18s ease, box-shadow .18s ease, border-color .18s ease;
    min-width: 0;
}

.summary-stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(15, 23, 42, .07);
}

.summary-stat-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 44px;
    height: 44px;
    min-width: 44px;
    border-radius: 11px;
    font-size: 22px;
    border: 1px solid transparent;
}

.summary-stat-info {
    display: flex;
    flex-direction: column;
    min-width: 0;
}

.summary-stat-value {
    font-size: 22px;
    font-weight: 800;
    line-height: 1.15;
    letter-spacing: -.5px;
    color: var(--body-text);
}

.summary-stat-label {
    font-size: 11px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: .4px;
    color: var(--secondary-text);
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Total */
.summary-stat-total .summary-stat-icon {
    background: rgba(59, 111, 212, .10);
    border-color: rgba(59, 111, 212, .28);
    color: #3b6fd4;
}
.summary-stat-total:hover {
    border-color: rgba(59, 111, 212, .45);
}

/* Active */
.summary-stat-active .summary-stat-icon {
    background: rgba(22, 163, 74, .10);
    border-color: rgba(22, 163, 74, .28);
    color: #16804a;
}
.summary-stat-active:hover {
    border-color: rgba(22, 163, 74, .45);
}
.summary-stat-active .summary-stat-value {
    color: #16804a;
}

/* Inactive */
.summary-stat-inactive .summary-stat-icon {
    background: rgba(234, 179, 8, .12);
    border-color: rgba(234, 179, 8, .30);
    color: #b45309;
}
.summary-stat-inactive:hover {
    border-color: rgba(234, 179, 8, .48);
}
.summary-stat-inactive .summary-stat-value {
    color: #b45309;
}

/* Deleted */
.summary-stat-deleted .summary-stat-icon {
    background: rgba(220, 38, 38, .10);
    border-color: rgba(220, 38, 38, .28);
    color: #c93642;
}
.summary-stat-deleted:hover {
    border-color: rgba(220, 38, 38, .45);
}
.summary-stat-deleted .summary-stat-value {
    color: #c93642;
}

/* Dark theme adjustments */
:root[data-theme="dark"] .summary-stat-total .summary-stat-icon {
    background: rgba(96, 165, 250, .12);
    border-color: rgba(96, 165, 250, .32);
    color: #93c5fd;
}
:root[data-theme="dark"] .summary-stat-active .summary-stat-icon {
    background: rgba(74, 222, 128, .12);
    border-color: rgba(74, 222, 128, .32);
    color: #6ee7a0;
}
:root[data-theme="dark"] .summary-stat-active .summary-stat-value {
    color: #6ee7a0;
}
:root[data-theme="dark"] .summary-stat-inactive .summary-stat-icon {
    background: rgba(250, 204, 21, .12);
    border-color: rgba(250, 204, 21, .32);
    color: #facc15;
}
:root[data-theme="dark"] .summary-stat-inactive .summary-stat-value {
    color: #facc15;
}
:root[data-theme="dark"] .summary-stat-deleted .summary-stat-icon {
    background: rgba(248, 113, 113, .12);
    border-color: rgba(248, 113, 113, .32);
    color: #ff9aa6;
}
:root[data-theme="dark"] .summary-stat-deleted .summary-stat-value {
    color: #ff9aa6;
}

.users-activity-card {
    margin: 0 16px 20px;
    padding: 18px 16px 20px;
    background: var(--surface-bg);
    color: var(--body-text);
    border: 1px solid var(--surface-border);
    border-radius: 16px;
    box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    width: auto;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
    overflow: hidden;
}

.users-activity-card *,
.users-activity-card *::before,
.users-activity-card *::after {
    box-sizing: border-box;
}

.users-activity-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 18px;
}

.users-activity-title {
    margin: 0 0 6px;
    color: var(--body-text);
    font-size: 17px;
    font-weight: 700;
    letter-spacing: -.2px;
}

.users-activity-description {
    margin: 0;
    color: var(--secondary-text);
    font-size: 12px;
    line-height: 1.6;
}

.users-activity-header .btn-view-all {
    text-decoration: none;
}

.users-activity-table-container {
    margin: 0;
    padding: 12px 8px 16px;
    border-radius: 12px;
    box-shadow: none;
    overflow-x: auto;
    overflow-y: hidden;
    width: 100%;
    max-width: 100%;
    min-width: 0;
    -webkit-overflow-scrolling: touch;
}

/* TABLE WIDTH AND COLUMN SIZING */

#dashboardDataTable_wrapper {
    width: 100%;
    max-width: 100%;
    min-width: 0;
}

.dashboard-datatable {
    width: 100% !important;
    max-width: 100% !important;
    min-width: 0 !important;
    border-collapse: collapse !important;
    margin: 0 !important;
    table-layout: fixed !important;
}

/* ALIGN EVERY COLUMN HEADER TO THE LEFT */

#dashboardDataTable thead th {
    height: 40px;
    padding: 7px 5px;
    background: var(--table-head-bg);
    color: var(--secondary-text);
    border-bottom: 1px solid var(--surface-border);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .2px;
    text-transform: uppercase;
    vertical-align: middle;
    text-align: left !important;
    white-space: normal;
    overflow-wrap: anywhere;
}

/* CENTER THE S/N HEADER ONLY */

#dashboardDataTable thead th.center-header {
    text-align: center !important;
}

.dashboard-datatable thead th:nth-child(1) {
    width: 6%;
}

.dashboard-datatable thead th:nth-child(2) {
    width: 34%;
}

.dashboard-datatable thead th:nth-child(3) {
    width: 14%;
}

.dashboard-datatable thead th:nth-child(4) {
    width: 12%;
}

.dashboard-datatable thead th:nth-child(5) {
    width: 19%;
}

.dashboard-datatable thead th:nth-child(6) {
    width: 15%;
}

/* ALIGN ROW VALUES TO THE LEFT BY DEFAULT */

#dashboardDataTable tbody td {
    padding: 9px 5px;
    background: var(--table-cell-bg);
    color: var(--body-text);
    border-bottom: 1px solid var(--surface-border);
    font-size: 11px;
    line-height: 1.5;
    vertical-align: middle;
    text-align: left !important;
    min-width: 0;
    max-width: 0;
    overflow-wrap: anywhere;
    word-break: normal;
}

/* CENTER ONLY THE S/N VALUES; KEEP ITS HEADER LEFT-ALIGNED */

#dashboardDataTable tbody td.center-cell {
    text-align: center !important;
}

.dashboard-datatable tbody tr:hover td {
    background: var(--table-hover-bg);
}

.dashboard-datatable tbody tr:last-child td {
    border-bottom: 0;
}

.dashboard-table-user {
    display: flex;
    align-items: center;
    gap: 7px;
    width: 100%;
    min-width: 0;
}

.dashboard-table-avatar {
    width: 30px;
    height: 30px;
    min-width: 30px;
    flex-shrink: 0;
    border-radius: 50%;
    object-fit: cover;
    background: var(--surface-soft);
    border: 1px solid var(--surface-border);
}

.dashboard-table-user-details {
    display: flex;
    flex-direction: column;
    justify-content: center;
    width: 100%;
    min-width: 0;
    gap: 2px;
}

.dashboard-table-user-name {
    color: var(--body-text);
    font-size: 10px;
    font-weight: 700;
    line-height: 1.4;
    min-width: 0;
    overflow-wrap: anywhere;
    word-break: break-word;
}

/* Status ball placed before the user name. */

.dashboard-table-user-name .status-ball {
    display: inline-block;
    width: 8px;
    height: 8px;
    border-radius: 50%;
    margin-right: 5px;
    vertical-align: middle;
    flex-shrink: 0;
    box-shadow: 0 0 0 1px rgba(0, 0, 0, .08);
}

/* Blue crown for the supervisor user (placed after the role parentheses). */

.dashboard-table-user-name .supervisor-crown {
    display: inline-block;
    margin-left: 4px;
    vertical-align: middle;
    font-size: 12px;
    line-height: 1;
    color: #3b6fd4;
    filter: hue-rotate(0deg) saturate(1.4);
}

.status-ball-active {
    background: #16a34a;
    box-shadow: 0 0 0 2px rgba(22, 163, 74, .20);
}

.status-ball-inactive {
    background: #eab308;
    box-shadow: 0 0 0 2px rgba(234, 179, 8, .20);
}

.status-ball-deleted {
    background: #dc2626;
    box-shadow: 0 0 0 2px rgba(220, 38, 38, .20);
}

/* STATUS BADGE */

.users-status-cell {
    white-space: nowrap;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 3px 9px;
    border-radius: 999px;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: .3px;
    text-transform: uppercase;
    line-height: 1.4;
    border: 1px solid transparent;
}

.status-badge.status-ball-active {
    background: rgba(22, 163, 74, .12);
    border-color: rgba(22, 163, 74, .30);
    color: #16804a;
    box-shadow: none;
}

.status-badge.status-ball-inactive {
    background: rgba(234, 179, 8, .14);
    border-color: rgba(234, 179, 8, .34);
    color: #b45309;
    box-shadow: none;
}

.status-badge.status-ball-deleted {
    background: rgba(220, 38, 38, .12);
    border-color: rgba(220, 38, 38, .30);
    color: #c93642;
    box-shadow: none;
}

:root[data-theme="dark"] .status-badge.status-ball-active {
    background: rgba(74, 222, 128, .14);
    border-color: rgba(74, 222, 128, .34);
    color: #6ee7a0;
}

:root[data-theme="dark"] .status-badge.status-ball-inactive {
    background: rgba(250, 204, 21, .14);
    border-color: rgba(250, 204, 21, .34);
    color: #facc15;
}

:root[data-theme="dark"] .status-badge.status-ball-deleted {
    background: rgba(248, 113, 113, .14);
    border-color: rgba(248, 113, 113, .34);
    color: #ff9aa6;
}

.dashboard-table-user-email {
    color: var(--secondary-text);
    font-size: 9px;
    line-height: 1.4;
    overflow-wrap: anywhere;
    word-break: break-word;
}

.dashboard-admin-crown {
    display: inline-block;
    margin-left: 3px;
    font-size: 12px;
}

.users-activity-date {
    white-space: normal;
    overflow-wrap: anywhere;
    word-break: break-word;
    color: var(--secondary-text) !important;
    font-size: 9px;
    text-align: left !important;
}

/* LEFT-ALIGNED ACTION COLUMN */

.users-activity-action-cell {
    width: 1%;
    min-width: 56px;
    max-width: 75px;
    padding-left: 5px !important;
    padding-right: 2px !important;
    text-align: left !important;
    white-space: nowrap !important;
    overflow: visible !important;
}

.dashboard-table-action {
    display: inline-flex !important;
    align-items: center;
    justify-content: center;
    flex: 0 0 auto;
    width: 27px;
    height: 27px;
    padding: 0;
    margin: 2px 1px;
    border: 1px solid var(--surface-border);
    border-radius: 7px;
    background: var(--surface-soft);
    color: var(--link-color);
    font-size: 15px;
    line-height: 1;
    vertical-align: middle;
    cursor: pointer;
    overflow: visible;
    transition: background .18s ease, border-color .18s ease, color .18s ease;
}

.dashboard-table-action:hover {
    background: var(--table-hover-bg);
    border-color: var(--link-color);
    color: var(--link-color);
}

/* Preserve Material Design Icons inside action buttons. */

.dashboard-table-action i.mdi {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    font-family: "Material Design Icons" !important;
    font-style: normal !important;
    font-weight: normal !important;
    font-size: 15px !important;
    line-height: 1 !important;
    speak: never;
}

.dashboard-table-action i.mdi::before {
    display: inline-block !important;
    visibility: visible !important;
    opacity: 1 !important;
    font-family: "Material Design Icons" !important;
    font-style: normal !important;
    font-weight: normal !important;
    line-height: 1 !important;
}

.delete-user-btn {
    color: #c93642;
}

.delete-user-btn:hover {
    color: #b91c1c;
    border-color: #d9535e;
}

.recycle-user-btn {
    color: #16804a;
}

.recycle-user-btn:hover {
    color: #15803d;
    border-color: #16a34a;
}

.reset-user-btn {
    color: #b45309;
}

.reset-user-btn:hover {
    color: #92400e;
    border-color: #eab308;
}

:root[data-theme="dark"] .delete-user-btn {
    color: #ff9aa6;
}

:root[data-theme="dark"] .recycle-user-btn {
    color: #6ee7a0;
}

:root[data-theme="dark"] .reset-user-btn {
    color: #facc15;
}

:root[data-theme="dark"] .status-ball-active {
    background: #4ade80;
    box-shadow: 0 0 0 2px rgba(74, 222, 128, .25);
}

:root[data-theme="dark"] .status-ball-inactive {
    background: #facc15;
    box-shadow: 0 0 0 2px rgba(250, 204, 21, .25);
}

:root[data-theme="dark"] .status-ball-deleted {
    background: #f87171;
    box-shadow: 0 0 0 2px rgba(248, 113, 113, .25);
}

/* DATATABLES SEARCH AND LENGTH */

#dashboardDataTable_wrapper .dataTables_filter {
    margin-bottom: 12px;
    text-align: right;
    font-size: 12px;
}

#dashboardDataTable_wrapper .dataTables_filter label {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
    margin: 0;
    color: var(--secondary-text);
    font-weight: 500;
}

#dashboardDataTable_wrapper .dataTables_filter input {
    width: 180px;
    max-width: 100%;
    margin-left: 0;
    padding: 6px 10px;
    border: 1px solid var(--surface-border);
    border-radius: 8px;
    outline: none;
    background: var(--surface-soft);
    color: var(--body-text);
    font-size: 12px;
    transition: border-color .2s ease, box-shadow .2s ease;
}

#dashboardDataTable_wrapper .dataTables_filter input:focus {
    border-color: #3b6fd4;
    box-shadow: 0 0 0 3px rgba(59, 111, 212, .12);
    background: var(--surface-bg);
}

#dashboardDataTable_wrapper .dataTables_length {
    margin-bottom: 12px;
    color: var(--secondary-text);
    font-size: 12px;
}

#dashboardDataTable_wrapper .dataTables_length select {
    margin: 0 4px;
    padding: 5px 8px;
    border: 1px solid var(--surface-border);
    border-radius: 8px;
    background: var(--surface-soft);
    color: var(--body-text);
    font-size: 12px;
}

#dashboardDataTable_wrapper .dataTables_info {
    padding-top: 10px;
    color: var(--secondary-text);
    font-size: 12px;
}

#dashboardDataTable_wrapper .dataTables_paginate {
    padding-top: 10px;
    margin-top: 10px;
}

#dashboardDataTable_wrapper .dataTables_paginate .paginate_button {
    margin: 0 2px;
    padding: 4px 9px !important;
    border: 1px solid var(--surface-border) !important;
    border-radius: 7px !important;
    background: var(--surface-soft) !important;
    color: var(--body-text) !important;
    font-size: 11px;
}

#dashboardDataTable_wrapper .dataTables_paginate .paginate_button.current {
    border-color: #3b6fd4 !important;
    background: #3b6fd4 !important;
    color: #fff !important;
}

#dashboardDataTable_wrapper .dataTables_paginate .paginate_button:hover {
    border-color: var(--surface-border) !important;
    background: var(--table-hover-bg) !important;
    color: var(--body-text) !important;
}

#dashboardDataTable_wrapper .dataTables_paginate .paginate_button.current:hover {
    border-color: #2f5cb8 !important;
    background: #2f5cb8 !important;
    color: #fff !important;
}

:root[data-theme="dark"] .dashboard-datatable {
    color: var(--body-text);
}

:root[data-theme="dark"] .dashboard-datatable thead th,
:root[data-theme="dark"] .dashboard-datatable tbody td {
    border-color: var(--surface-border);
}

:root[data-theme="dark"] #dashboardDataTable_wrapper .dataTables_filter input,
:root[data-theme="dark"] #dashboardDataTable_wrapper .dataTables_length select {
    color-scheme: dark;
}

/* DATATABLES EXPORT BUTTONS */

#dashboardDataTable_wrapper .dt-top {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 14px;
    max-width: 100%;
}

#dashboardDataTable_wrapper .dt-buttons {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 5px;
    max-width: 100%;
}

#dashboardDataTable_wrapper .dt-buttons .dt-button {
    margin: 0;
    padding: 6px 10px;
    border: 1px solid var(--surface-border);
    border-radius: 6px;
    background: var(--surface-soft);
    color: var(--body-text);
    font-size: 10px;
    font-weight: 600;
    cursor: pointer;
    transition: background .18s ease, border-color .18s ease;
}

#dashboardDataTable_wrapper .dt-buttons .dt-button:hover,
#dashboardDataTable_wrapper .dt-buttons .dt-button:focus {
    border-color: #3b6fd4;
    background: rgba(59, 111, 212, .10);
    color: var(--body-text);
}

#dashboardDataTable_wrapper .dt-buttons .dt-button.disabled {
    opacity: .5;
    cursor: not-allowed;
}

#dashboardDataTable_wrapper .dt-top .dataTables_filter {
    margin: 0;
}

#dashboardDataTable_wrapper .dt-bottom {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 8px;
    margin-top: 10px;
    max-width: 100%;
}

/* RESPONSIVE DETAILS */

#dashboardDataTable_wrapper td.child {
    padding: 10px 12px !important;
    background: var(--surface-soft) !important;
    white-space: normal !important;
    text-align: left !important;
}

#dashboardDataTable_wrapper td.child ul.dtr-details {
    display: block;
    width: 100%;
    margin: 0;
    padding: 0;
    list-style: none;
}

#dashboardDataTable_wrapper td.child ul.dtr-details li {
    display: flex;
    align-items: flex-start;
    flex-wrap: wrap;
    gap: 5px;
    padding: 7px 0;
    border-bottom: 1px solid var(--surface-border);
    white-space: normal;
    text-align: left !important;
    overflow-wrap: anywhere;
}

#dashboardDataTable_wrapper td.child ul.dtr-details li:last-child {
    border-bottom: 0;
}

#dashboardDataTable_wrapper .dtr-title {
    color: var(--secondary-text);
    font-weight: 700;
}

#dashboardDataTable_wrapper .dtr-data {
    color: var(--body-text);
    white-space: normal;
    overflow-wrap: anywhere;
    text-align: left !important;
}

#dashboardDataTable_wrapper .dtr-control {
    cursor: pointer;
    text-align: left !important;
}

#dashboardDataTable_wrapper .dataTables_empty {
    text-align: left !important;
    padding: 18px 8px !important;
}

/* DELETE BUTTON */

.delete-user-btn {
    color: #c93642;
}

.delete-user-btn:hover {
    color: #b91c1c;
}

/* MODAL OVERLAYS */

.delete-modal-overlay,
.reset-modal-overlay,
.restore-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 99999;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(15, 23, 42, .68);
    backdrop-filter: blur(7px);
    -webkit-backdrop-filter: blur(7px);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity .25s ease, visibility .25s ease;
}

.delete-modal-overlay.show,
.reset-modal-overlay.show,
.restore-modal-overlay.show {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

/* MODAL BOXES */

.delete-modal-box,
.reset-modal-box,
.restore-modal-box {
    position: relative;
    width: 100%;
    max-width: 440px;
    padding: 36px 30px 28px;
    border: 1px solid var(--surface-border);
    border-radius: 18px;
    background: var(--surface-bg);
    color: var(--body-text);
    text-align: center;
    box-shadow: 0 25px 70px rgba(15, 23, 42, .28);
    transform: translateY(20px) scale(.96);
    opacity: 0;
    transition: transform .25s ease, opacity .25s ease;
}

.delete-modal-overlay.show .delete-modal-box,
.reset-modal-overlay.show .reset-modal-box,
.restore-modal-overlay.show .restore-modal-box {
    transform: translateY(0) scale(1);
    opacity: 1;
}

/* MODAL CLOSE BUTTONS */

.delete-modal-close,
.reset-modal-close,
.restore-modal-close {
    position: absolute;
    top: 13px;
    right: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 34px;
    height: 34px;
    border: 1px solid var(--surface-border);
    border-radius: 9px;
    background: var(--surface-soft);
    color: var(--secondary-text);
    font-size: 24px;
    line-height: 1;
    cursor: pointer;
    transition: background .18s ease, color .18s ease, border-color .18s ease;
}

.delete-modal-close:hover {
    background: rgba(217, 83, 94, .12);
    border-color: rgba(217, 83, 94, .35);
    color: #d9535e;
}

.reset-modal-close:hover {
    background: rgba(234, 179, 8, .12);
    border-color: rgba(234, 179, 8, .35);
    color: #b45309;
}

.restore-modal-close:hover {
    background: rgba(22, 163, 74, .10);
    border-color: rgba(22, 163, 74, .35);
    color: #16a34a;
}

/* MODAL ICONS */

.delete-modal-icon,
.reset-modal-icon,
.restore-modal-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 72px;
    height: 72px;
    margin: 0 auto 20px;
    border: 1px solid transparent;
    border-radius: 16px;
    font-size: 32px;
}

.delete-modal-icon {
    background: rgba(217, 83, 94, .10);
    border-color: rgba(217, 83, 94, .28);
    color: #c93642;
}

.reset-modal-icon {
    background: rgba(234, 179, 8, .12);
    border-color: rgba(234, 179, 8, .30);
    color: #b45309;
}

.restore-modal-icon {
    background: rgba(22, 163, 74, .10);
    border-color: rgba(22, 163, 74, .28);
    color: #16804a;
}

:root[data-theme="dark"] .delete-modal-icon {
    color: #ff9aa6;
}

:root[data-theme="dark"] .reset-modal-icon {
    color: #facc15;
}

:root[data-theme="dark"] .restore-modal-icon {
    color: #6ee7a0;
}

/* MODAL TITLES AND MESSAGES */

.delete-modal-box h3,
.reset-modal-box h3,
.restore-modal-box h3 {
    margin: 0 0 10px;
    color: var(--body-text);
    font-size: 21px;
    font-weight: 700;
    letter-spacing: -.3px;
}

.delete-modal-box p,
.reset-modal-box p,
.restore-modal-box p {
    max-width: 350px;
    margin: 0 auto 24px;
    color: var(--secondary-text);
    font-size: 13px;
    line-height: 1.7;
    overflow-wrap: anywhere;
}

.delete-modal-box p strong {
    color: #c93642;
    font-weight: 700;
}

.reset-modal-box p strong {
    color: #b45309;
    font-weight: 700;
}

.restore-modal-box p strong {
    color: #16804a;
    font-weight: 700;
}

:root[data-theme="dark"] .delete-modal-box p strong {
    color: #ff9aa6;
}

:root[data-theme="dark"] .reset-modal-box p strong {
    color: #facc15;
}

:root[data-theme="dark"] .restore-modal-box p strong {
    color: #6ee7a0;
}

/* MODAL ACTION BUTTONS */

.delete-modal-actions,
.reset-modal-actions,
.restore-modal-actions {
    display: flex;
    gap: 10px;
    width: 100%;
}

.delete-modal-cancel,
.delete-modal-confirm,
.reset-modal-cancel,
.reset-modal-confirm,
.restore-modal-cancel,
.restore-modal-confirm {
    display: inline-flex;
    flex: 1;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 42px;
    padding: 0 14px;
    border: 1px solid transparent;
    border-radius: 9px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background .18s ease, border-color .18s ease, color .18s ease;
}

.delete-modal-cancel,
.reset-modal-cancel,
.restore-modal-cancel {
    border-color: var(--surface-border);
    background: var(--surface-soft);
    color: var(--body-text);
}

.delete-modal-cancel:hover,
.reset-modal-cancel:hover,
.restore-modal-cancel:hover {
    border-color: var(--link-color);
    background: var(--table-hover-bg);
}

.delete-modal-confirm {
    border-color: #c93642;
    background: #c93642;
    color: #fff;
}

.delete-modal-confirm:hover {
    border-color: #b91c1c;
    background: #b91c1c;
}

.reset-modal-confirm {
    border-color: #b45309;
    background: #b45309;
    color: #fff;
}

.reset-modal-confirm:hover {
    border-color: #92400e;
    background: #92400e;
}

.restore-modal-confirm {
    border-color: #16804a;
    background: #16804a;
    color: #fff;
}

.restore-modal-confirm:hover {
    border-color: #12683c;
    background: #12683c;
}

.delete-modal-confirm i,
.reset-modal-confirm i,
.restore-modal-confirm i {
    font-size: 15px;
}

/* RESPONSIVE */

@media (max-width: 991.98px) {
    .users-summary-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .users-activity-card {
        margin: 0 10px 16px;
        padding: 16px 12px;
    }

    .users-activity-table-container {
        padding: 10px 6px 14px;
    }

    .dashboard-datatable thead th,
    .dashboard-datatable tbody td {
        padding: 7px 4px;
        text-align: left !important;
    }

    #dashboardDataTable thead th.center-header {
        text-align: center !important;
    }

    #dashboardDataTable tbody td.center-cell {
        text-align: center !important;
    }

    .dashboard-table-avatar {
        width: 27px;
        height: 27px;
        min-width: 27px;
    }

    .dashboard-table-user-name {
        font-size: 10px;
    }

    .dashboard-table-user-email {
        font-size: 9px;
    }

    .users-activity-date {
        font-size: 9px;
    }

    .status-badge {
        font-size: 8px;
        padding: 3px 7px;
    }

    .dashboard-table-action {
        width: 26px;
        height: 26px;
        font-size: 14px;
    }

    .dashboard-table-action i.mdi,
    .dashboard-table-action i.mdi::before {
        font-size: 14px !important;
    }
}

@media (max-width: 767.98px) {
    .users-summary-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px;
    }

    .summary-stat-card {
        padding: 11px 12px;
        gap: 10px;
    }

    .summary-stat-icon {
        width: 38px;
        height: 38px;
        min-width: 38px;
        font-size: 19px;
        border-radius: 9px;
    }

    .summary-stat-value {
        font-size: 18px;
    }

    .summary-stat-label {
        font-size: 10px;
    }

    .users-activity-card {
        margin: 0 8px 14px;
        padding: 14px 10px;
        border-radius: 12px;
    }

    .users-activity-header {
        align-items: flex-start;
        gap: 10px;
    }

    .users-activity-title {
        font-size: 15px;
    }

    .users-activity-description {
        font-size: 11px;
    }

    .users-activity-table-container {
        padding: 8px 4px 12px;
    }

    #dashboardDataTable_wrapper .dataTables_filter {
        text-align: left;
    }

    #dashboardDataTable_wrapper .dataTables_filter label {
        justify-content: flex-start;
        flex-wrap: wrap;
        width: 100%;
    }

    #dashboardDataTable_wrapper .dataTables_filter input {
        width: 100%;
        margin-top: 5px;
    }

    #dashboardDataTable_wrapper .dataTables_length {
        margin-bottom: 10px;
    }

    #dashboardDataTable_wrapper .dataTables_paginate {
        text-align: left;
        overflow-x: auto;
        white-space: nowrap;
        max-width: 100%;
    }

    #dashboardDataTable_wrapper .dt-top {
        align-items: stretch;
        flex-direction: column;
    }

    #dashboardDataTable_wrapper .dt-buttons {
        width: 100%;
    }

    #dashboardDataTable_wrapper .dt-top .dataTables_filter {
        width: 100%;
        text-align: left;
    }

    #dashboardDataTable_wrapper .dt-top .dataTables_filter input {
        width: 100%;
    }

    #dashboardDataTable_wrapper .dt-bottom {
        align-items: flex-start;
        flex-direction: column;
    }

    .dashboard-datatable thead th,
    .dashboard-datatable tbody td {
        padding: 6px 3px;
        font-size: 9px;
        text-align: left !important;
    }

    #dashboardDataTable thead th.center-header {
        text-align: center !important;
    }

    #dashboardDataTable tbody td.center-cell {
        text-align: center !important;
    }

    .dashboard-table-user {
        gap: 5px;
    }

    .dashboard-table-avatar {
        width: 24px;
        height: 24px;
        min-width: 24px;
    }

    .dashboard-table-user-name {
        font-size: 9px;
    }

    .dashboard-table-user-email {
        font-size: 8px;
    }

    .users-activity-date {
        font-size: 8px;
    }

    .status-badge {
        font-size: 8px;
        padding: 2px 6px;
    }

    .dashboard-table-action {
        width: 25px;
        height: 25px;
        font-size: 13px;
        border-radius: 6px;
        margin: 2px 0;
    }

    .dashboard-table-action i.mdi,
    .dashboard-table-action i.mdi::before {
        font-size: 13px !important;
    }

    .users-activity-action-cell {
        min-width: 55px;
        text-align: left !important;
    }

    .delete-modal-box,
    .reset-modal-box,
    .restore-modal-box {
        max-width: 420px;
        padding: 34px 22px 24px;
    }
}

@media (max-width: 480px) {
    .users-summary-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 8px;
    }

    .summary-stat-card {
        padding: 10px 10px;
        gap: 8px;
        border-radius: 10px;
    }

    .summary-stat-icon {
        width: 34px;
        height: 34px;
        min-width: 34px;
        font-size: 17px;
        border-radius: 8px;
    }

    .summary-stat-value {
        font-size: 16px;
    }

    .summary-stat-label {
        font-size: 9px;
        letter-spacing: .2px;
    }

    .users-activity-card {
        margin: 0 5px 10px;
        padding: 12px 8px;
    }

    .users-activity-header {
        flex-direction: column;
        align-items: stretch;
    }

    .users-activity-header .btn-view-all {
        justify-content: center;
        width: 100%;
    }

    .users-activity-table-container {
        padding: 6px 3px 10px;
    }

    .dashboard-datatable thead th,
    .dashboard-datatable tbody td {
        padding: 5px 2px;
        font-size: 8px;
        text-align: left !important;
    }

    #dashboardDataTable thead th.center-header {
        text-align: center !important;
    }

    #dashboardDataTable tbody td.center-cell {
        text-align: center !important;
    }

    .dashboard-table-avatar {
        width: 22px;
        height: 22px;
        min-width: 22px;
    }

    .dashboard-table-user {
        gap: 4px;
    }

    .dashboard-table-user-name {
        font-size: 8px;
    }

    .dashboard-table-user-email {
        font-size: 7px;
    }

    .users-activity-date {
        font-size: 7px;
    }

    .status-badge {
        font-size: 7px;
        padding: 2px 5px;
    }

    .dashboard-table-user-name .status-ball {
        width: 6px;
        height: 6px;
        margin-right: 3px;
    }

    .dashboard-table-action {
        width: 23px;
        height: 23px;
        font-size: 12px;
        border-radius: 5px;
        margin: 1px 0;
    }

    .dashboard-table-action i.mdi,
    .dashboard-table-action i.mdi::before {
        font-size: 12px !important;
    }

    .users-activity-action-cell {
        min-width: 49px;
        text-align: left !important;
    }

    .delete-modal-box,
    .reset-modal-box,
    .restore-modal-box {
        max-width: 100%;
        padding: 34px 18px 22px;
        border-radius: 14px;
    }

    .delete-modal-icon,
    .reset-modal-icon,
    .restore-modal-icon {
        width: 64px;
        height: 64px;
        font-size: 28px;
    }

    .delete-modal-box h3,
    .reset-modal-box h3,
    .restore-modal-box h3 {
        font-size: 19px;
    }

    .delete-modal-actions,
    .reset-modal-actions,
    .restore-modal-actions {
        flex-direction: column-reverse;
    }

    .delete-modal-cancel,
    .delete-modal-confirm,
    .reset-modal-cancel,
    .reset-modal-confirm,
    .restore-modal-cancel,
    .restore-modal-confirm {
        width: 100%;
        min-height: 40px;
        flex: none;
    }
}

@media (prefers-reduced-motion: reduce) {
    .delete-modal-overlay,
    .reset-modal-overlay,
    .restore-modal-overlay,
    .delete-modal-box,
    .reset-modal-box,
    .restore-modal-box,
    .dashboard-table-action,
    .summary-stat-card {
        transition-duration: .01ms !important;
    }
}
</style>

<script>
let deleteUserSn = null;
let deleteLoginSn = null;
let deleteUsersTableName = null;
let deleteLoginTableName = null;
let restoreUserSn = null;
let restoreTableName = null;
let restoreUserName = null;
let resetUserId = null;
let resetUserName = null;

function showDeleteModal(userSn, loginSn, userName, usersTableName, loginTableName) {
    deleteUserSn = userSn;
    deleteLoginSn = loginSn;
    deleteUsersTableName = usersTableName;
    deleteLoginTableName = loginTableName;

    const modal = document.getElementById('deleteModal');
    const userNameElement = document.getElementById('deleteUserName');

    userNameElement.textContent = userName;
    modal.classList.add('show');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteModal');

    modal.classList.remove('show');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';

    deleteUserSn = null;
    deleteLoginSn = null;
    deleteUsersTableName = null;
    deleteLoginTableName = null;
}

document.getElementById('confirmDeleteBtn').addEventListener('click', function () {
    if (
        !deleteUserSn ||
        !deleteLoginSn ||
        !deleteUsersTableName ||
        !deleteLoginTableName
    ) {
        return;
    }

    // Generate a cryptographically random, non-empty token value.
    // The current controller only checks that token is non-empty; it does
    // not verify a signature or bind the token to these values.
    const tokenBytes = new Uint8Array(32);
    window.crypto.getRandomValues(tokenBytes);
    const deleteToken = Array.from(tokenBytes, byte => byte.toString(16).padStart(2, '0')).join('');

    const params = new URLSearchParams({
        token: deleteToken,
        user_sn: btoa(String(deleteUserSn)),
        login_sn: btoa(String(deleteLoginSn)),
        users_column: btoa(String(deleteUsersTableName)),
        login_column: btoa(String(deleteLoginTableName))
    });

    window.location.href = 'index?action=delete_user&' + params.toString();
});

function showResetModal(userId, userName) {
    resetUserId = userId;
    resetUserName = userName;

    const modal = document.getElementById('resetModal');
    const userNameElement = document.getElementById('resetUserName');

    userNameElement.textContent = userName;
    modal.classList.add('show');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
}

function closeResetModal() {
    const modal = document.getElementById('resetModal');

    modal.classList.remove('show');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';

    resetUserId = null;
    resetUserName = null;
}

document.getElementById('confirmResetBtn').addEventListener('click', function () {
    if (!resetUserId) {
        return;
    }

    const tokenEdit = resetUserId;

    closeResetModal();

    window.location.href = 'index?action=reset_user&token_reset=' + encodeURIComponent(tokenEdit);
});

function showRestoreModal(userSn, userName, tableName) {
    restoreUserSn = userSn;
    restoreUserName = userName;
    restoreTableName = tableName;

    const modal = document.getElementById('restoreModal');
    const userNameElement = document.getElementById('restoreUserName');

    userNameElement.textContent = userName;
    modal.classList.add('show');
    modal.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
}

function closeRestoreModal() {
    const modal = document.getElementById('restoreModal');

    modal.classList.remove('show');
    modal.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';

    restoreUserSn = null;
    restoreUserName = null;
    restoreTableName = null;
}

document.getElementById('confirmRestoreBtn').addEventListener('click', function () {
    if (!restoreUserSn || !restoreTableName) {
        return;
    }

    const restoreToken = btoa(
        unescape(
            encodeURIComponent(
                JSON.stringify({
                    sn: restoreUserSn,
                    table_name: restoreTableName,
                    user_name: restoreUserName,
                    page_controller: "<?= $page_controller ?>"
                })
            )
        )
    );

    window.location.href =
        'index?action=restore_user' +
        '&token=' + encodeURIComponent(restoreToken) +
        '&page_controller=' + encodeURIComponent("<?= $page_controller ?>");
});

document.getElementById('deleteModal').addEventListener('click', function (event) {
    if (event.target === this) {
        closeDeleteModal();
    }
});

document.getElementById('resetModal').addEventListener('click', function (event) {
    if (event.target === this) {
        closeResetModal();
    }
});

document.getElementById('restoreModal').addEventListener('click', function (event) {
    if (event.target === this) {
        closeRestoreModal();
    }
});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        if (document.getElementById('deleteModal').classList.contains('show')) {
            closeDeleteModal();
        }

        if (document.getElementById('resetModal').classList.contains('show')) {
            closeResetModal();
        }

        if (document.getElementById('restoreModal').classList.contains('show')) {
            closeRestoreModal();
        }
    }
});
</script>

<!-- ============================================================
     DATATABLES INITIALIZATION WITH SEARCH AND EXPORT BUTTONS
     (Buttons extension JS libraries are loaded in the header)
============================================================ -->
<script>
$(document).ready(function () {

    if ($.fn.DataTable.isDataTable('#dashboardDataTable')) {
        $('#dashboardDataTable').DataTable().destroy();
    }

    const usersTable = $('#dashboardDataTable').DataTable({
        responsive: {
            details: {
                type: 'inline',
                target: 0
            }
        },
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [
            [10, 25, 50, 100, -1],
            [10, 25, 50, 100, 'All']
        ],
        order: [],
        dom: '<"dt-top"Bf>rt<"dt-bottom"lip>',
        buttons: [
            {
                extend: 'copyHtml5',
                text: 'Copy',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'csvHtml5',
                text: 'CSV',
                title: 'Recent Activity - Users',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'excelHtml5',
                text: 'Excel',
                title: 'Recent Activity - Users',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'pdfHtml5',
                text: 'PDF',
                title: 'Recent Activity - Users',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            },
            {
                extend: 'print',
                text: 'Print',
                title: 'Recent Activity - Users',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4]
                }
            }
        ],
        language: {
            search: 'Search:',
            searchPlaceholder: 'Search users...',
            lengthMenu: 'Show _MENU_ users',
            info: 'Showing _START_ to _END_ of _TOTAL_ users',
            infoEmpty: 'Showing 0 to 0 of 0 users',
            zeroRecords: 'No matching users found',
            emptyTable: 'No users available',
            paginate: {
                first: 'First',
                last: 'Last',
                next: 'Next',
                previous: 'Previous'
            }
        },
        columnDefs: [
            {
                targets: 0,
                responsivePriority: 3,
                width: '6%',
                className: 'dt-body-center dt-head-center'
            },
            {
                targets: 1,
                responsivePriority: 1,
                width: '34%',
                className: 'dt-body-left dt-head-left',
                render: function (data, type, row, meta) {
                    // For search/filter and sort, only expose the visible
                    // user name + email text. This strips the status-ball
                    // span (whose class/title contained "active"/"inactive")
                    // so searching "active" only matches the Status column.
                    if (type === 'filter' || type === 'sort') {
                        var $cell = $('<div>').html(data);
                        var name = $cell.find('.dashboard-table-user-name').text().trim();
                        var email = $cell.find('.dashboard-table-user-email').text().trim();
                        return (name + ' ' + email).trim();
                    }
                    return data;
                }
            },
            {
                targets: 2,
                responsivePriority: 5,
                width: '14%',
                className: 'dt-body-left dt-head-left'
            },
            {
                targets: 3,
                responsivePriority: 4,
                width: '12%',
                className: 'dt-body-left dt-head-left',
                render: function (data, type, row, meta) {
                    // For search/filter and sort, only expose the visible
                    // badge text (Active / Inactive / Deleted).
                    if (type === 'filter' || type === 'sort') {
                        var $cell = $('<div>').html(data);
                        return $cell.find('.status-badge').text().trim();
                    }
                    return data;
                }
            },
            {
                targets: 4,
                responsivePriority: 6,
                width: '19%',
                className: 'dt-body-left dt-head-left'
            },
            {
                targets: 5,
                responsivePriority: 2,
                orderable: false,
                searchable: false,
                width: '15%',
                className: 'dt-body-left dt-head-left'
            }
        ],
        initComplete: function () {
            this.api().columns.adjust();

            if (this.api().responsive) {
                this.api().responsive.recalc();
            }
        }
    });

    $(window).on('resize', function () {
        usersTable.columns.adjust();

        if (usersTable.responsive) {
            usersTable.responsive.recalc();
        }
    });

});
</script>