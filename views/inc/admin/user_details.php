<?php

/*
|--------------------------------------------------------------------------
| LOAD SELECTED USER
|--------------------------------------------------------------------------
*/

$result = $LoadAParticularUsersAndLoginTableForAdmin ?? [];

$user = [];
$loadError = '';

if (!empty($result['success']) && !empty($result['user'])) {
    $user = $result['user'];
} elseif (!empty($result['error'])) {
    $loadError = $result['error'];
} else {
    $loadError = 'User not found.';
}

/*
|--------------------------------------------------------------------------
| SAFE DEFAULTS
|--------------------------------------------------------------------------
*/

$e = static function ($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES, 'UTF-8');
};

$Luser_sn = (int)($user['login_sn'] ?? 0);
$user_sn  = (int)($user['user_sn'] ?? 0);

$user_image = !empty($user['user_image'])
    ? $user['user_image']
    : 'noimage2.png';

$user_id   = $user['user_userid'] ?? '';
$user_name = $user['user_fullname'] ?? 'N/A';
$user_title = $user['user_title'] ?? '';
$user_email = $user['user_email'] ?? '';
$user_phone = $user['user_phone'] ?? '';
$user_corridor = $user['user_corridor'] ?? 'N/A';
$user_message = $user['user_msg'] ?? '';

$login_status = (int)($user['login_status'] ?? 0);
$login_role = $user['login_role'] ?? '';

$user_msg_notification = (int)($user['user_msg_notification'] ?? 0);

/*
|--------------------------------------------------------------------------
| ACCOUNT STATUS
|--------------------------------------------------------------------------
*/

if ($login_status === 1) {
    $status_text = 'Active';
    $status_class = 'profile-status-active';
    $status_icon = 'mdi-check-circle';
} elseif ($login_status === 0) {
    $status_text = 'Inactive';
    $status_class = 'profile-status-inactive';
    $status_icon = 'mdi-pause-circle';
} else {
    $status_text = 'Deleted';
    $status_class = 'profile-status-deleted';
    $status_icon = 'mdi-delete-circle';
}

/*
|--------------------------------------------------------------------------
| USER PERMISSIONS
|--------------------------------------------------------------------------
*/

$permissions = [
    'User Management' => [
        'Edit User'     => (int)($user['login_edit_user'] ?? 0),
        'Create User'   => (int)($user['login_create_user'] ?? 0),
        'Delete User'   => (int)($user['login_delete_user'] ?? 0),
        'Approve User'  => (int)($user['login_approve_user'] ?? 0),
    ],
    'Report Management' => [
        'Create Report'  => (int)($user['login_create_report'] ?? 0),
        'Approve Report' => (int)($user['login_approve_report'] ?? 0),
        'Edit Report'    => (int)($user['login_edit_report'] ?? 0),
        'Delete Report'  => (int)($user['login_delete_report'] ?? 0),
    ],
    'Communication' => [
        'Comment' => (int)($user['login_comment'] ?? 0),
    ],
];

?>

<div class="row profile-page-row">

    <div class="col-12">

        <div class="card single-user-profile-card">

            <div class="card-body">

                <!-- PAGE HEADING -->

                <div class="profile-page-heading">

                    <div>
                        <div class="profile-eyebrow">
                            USER MANAGEMENT
                        </div>

                        <h4 class="profile-page-title">
                            User Details
                        </h4>

                        <p class="profile-page-subtitle">
                            View the selected user's profile, account information
                            and assigned permissions.
                        </p>
                    </div>

                    <div class="profile-heading-actions">

                        <button type="button"
                                class="btn profile-back-btn"
                                onclick="window.history.back()">

                            <i class="mdi mdi-arrow-left"></i>
                            Back
                        </button>

                    </div>

                </div>

                <?php if (!empty($user)): ?>

                    <!-- =================================================
                         PROFILE HEADER
                    ================================================== -->

                    <div class="profile-hero">

                        <div class="profile-hero-main">

                            <div class="profile-avatar-wrap">

                                <img
                                    src="views/uploads/img/profile/<?= $e($user_image) ?>"
                                    alt="<?= $e($user_name) ?>"
                                    class="profile-avatar"
                                    onerror="this.onerror=null;this.src='views/uploads/img/noimage2.png';"
                                >

                                <span class="profile-avatar-indicator <?= $e($status_class) ?>"></span>

                            </div>

                            <div class="profile-identity">

                                <div class="profile-name-row">

                                    <h3 class="profile-user-name">
                                        <?= $e(trim($user_title . ' ' . $user_name)) ?>
                                    </h3>

                                    <span class="profile-status-badge <?= $e($status_class) ?>">
                                        <i class="mdi <?= $e($status_icon) ?>"></i>
                                        <?= $e($status_text) ?>
                                    </span>

                                </div>

                                <div class="profile-user-role">
                                    <i class="mdi mdi-shield-account-outline"></i>
                                    <?= $e(ucfirst((string)$login_role ?: 'Unassigned')) ?>
                                </div>

                                <div class="profile-identity-meta">

                                    <span>
                                        <i class="mdi mdi-account-outline"></i>
                                        <?= $e($user_id ?: 'No user ID') ?>
                                    </span>

                                    <span class="profile-meta-divider"></span>

                                    <span>
                                        <i class="mdi mdi-map-marker-outline"></i>
                                        <?= $e($user_corridor ?: 'N/A') ?>
                                    </span>

                                </div>

                            </div>

                        </div>

                        <div class="profile-hero-side">

                            <div class="profile-account-label">
                                ACCOUNT STATUS
                            </div>

                            <div class="profile-account-status <?= $e($status_class) ?>">
                                <?= $e($status_text) ?>
                            </div>

                            <div class="profile-account-caption">
                                Current account state
                            </div>

                        </div>

                    </div>

                    <!-- =================================================
                         PROFILE CONTENT
                    ================================================== -->

                    <div class="profile-content-grid">

                        <!-- PERSONAL INFORMATION -->

                        <section class="profile-section">

                            <div class="profile-section-heading">

                                <div class="profile-section-icon">
                                    <i class="mdi mdi-account-box-outline"></i>
                                </div>

                                <div>
                                    <h5>Personal Information</h5>
                                    <p>Basic details associated with this user.</p>
                                </div>

                            </div>

                            <div class="profile-details-grid">

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">Full Name</span>
                                    <div class="profile-detail-value">
                                        <?= $e($user_name ?: 'N/A') ?>
                                    </div>
                                </div>

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">Title</span>
                                    <div class="profile-detail-value">
                                        <?= $e($user_title ?: 'N/A') ?>
                                    </div>
                                </div>

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">User ID</span>
                                    <div class="profile-detail-value profile-monospace">
                                        <?= $e($user_id ?: 'N/A') ?>
                                    </div>
                                </div>

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">Email Address</span>
                                    <div class="profile-detail-value profile-break">
                                        <?php if (!empty($user_email)): ?>
                                            <a href="mailto:<?= $e($user_email) ?>">
                                                <?= $e($user_email) ?>
                                            </a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">Phone Number</span>
                                    <div class="profile-detail-value">
                                        <?php if (!empty($user_phone)): ?>
                                            <a href="tel:<?= $e($user_phone) ?>">
                                                <?= $e($user_phone) ?>
                                            </a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">Assigned Corridor</span>
                                    <div class="profile-detail-value">
                                        <span class="profile-corridor-value">
                                            <i class="mdi mdi-map-marker-outline"></i>
                                            <?= $e($user_corridor ?: 'N/A') ?>
                                        </span>
                                    </div>
                                </div>

                            </div>

                        </section>

                        <!-- ACCOUNT INFORMATION -->

                        <section class="profile-section">

                            <div class="profile-section-heading">

                                <div class="profile-section-icon">
                                    <i class="mdi mdi-account-cog-outline"></i>
                                </div>

                                <div>
                                    <h5>Account Information</h5>
                                    <p>Account access and communication preferences.</p>
                                </div>

                            </div>

                            <div class="profile-details-grid">

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">Account Role</span>
                                    <div class="profile-detail-value">
                                        <span class="profile-role-badge">
                                            <i class="mdi mdi-shield-account-outline"></i>
                                            <?= $e(ucfirst((string)$login_role ?: 'Unassigned')) ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">Account Status</span>
                                    <div class="profile-detail-value">
                                        <span class="profile-status-badge <?= $e($status_class) ?>">
                                            <i class="mdi <?= $e($status_icon) ?>"></i>
                                            <?= $e($status_text) ?>
                                        </span>
                                    </div>
                                </div>

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">Message Notifications</span>
                                    <div class="profile-detail-value">

                                        <?php if ($user_msg_notification === 1): ?>

                                            <span class="profile-notification-enabled">
                                                <i class="mdi mdi-bell-check-outline"></i>
                                                Enabled
                                            </span>

                                        <?php else: ?>

                                            <span class="profile-notification-disabled">
                                                <i class="mdi mdi-bell-off-outline"></i>
                                                Disabled
                                            </span>

                                        <?php endif; ?>

                                    </div>
                                </div>

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">Login Record</span>
                                    <div class="profile-detail-value profile-monospace">
                                        <?= $Luser_sn > 0 ? '#' . $Luser_sn : 'N/A' ?>
                                    </div>
                                </div>

                                <div class="profile-detail-item">
                                    <span class="profile-detail-label">User Record</span>
                                    <div class="profile-detail-value profile-monospace">
                                        <?= $user_sn > 0 ? '#' . $user_sn : 'N/A' ?>
                                    </div>
                                </div>

                            </div>

                        </section>

                    </div>

                    <!-- =================================================
                         USER MESSAGE
                    ================================================== -->

                    <section class="profile-section profile-message-section">

                        <div class="profile-section-heading">

                            <div class="profile-section-icon">
                                <i class="mdi mdi-message-text-outline"></i>
                            </div>

                            <div>
                                <h5>Current Message</h5>
                                <p>The message currently associated with this user.</p>
                            </div>

                        </div>

                        <div class="profile-message-content">

                            <?php if (trim((string)$user_message) !== ''): ?>

                                <?= nl2br($e($user_message)) ?>

                            <?php else: ?>

                                <span class="profile-empty-value">
                                    <i class="mdi mdi-information-outline"></i>
                                    No message available for this user.
                                </span>

                            <?php endif; ?>

                        </div>

                    </section>

                    <!-- =================================================
                         PERMISSIONS
                    ================================================== -->

                    <section class="profile-section profile-permissions-section">

                        <div class="profile-section-heading profile-permissions-heading">

                            <div class="profile-section-heading-main">

                                <div class="profile-section-icon">
                                    <i class="mdi mdi-shield-key-outline"></i>
                                </div>

                                <div>
                                    <h5>Role &amp; Permissions</h5>
                                    <p>Read-only overview of the permissions assigned to this account.</p>
                                </div>

                            </div>

                            <?php
                            $permissionCount = 0;
                            $allowedCount = 0;

                            foreach ($permissions as $groupPermissions) {
                                foreach ($groupPermissions as $allowed) {
                                    $permissionCount++;
                                    if ($allowed === 1) {
                                        $allowedCount++;
                                    }
                                }
                            }
                            ?>

                            <div class="profile-permission-summary">
                                <span class="profile-permission-count">
                                    <?= $allowedCount ?> / <?= $permissionCount ?>
                                </span>
                                <span class="profile-permission-caption">
                                    Permissions allowed
                                </span>
                            </div>

                        </div>

                        <div class="profile-permissions-groups">

                            <?php foreach ($permissions as $groupName => $groupPermissions): ?>

                                <div class="profile-permission-group">

                                    <div class="profile-permission-group-title">
                                        <?= $e($groupName) ?>
                                    </div>

                                    <div class="profile-permission-list">

                                        <?php foreach ($groupPermissions as $permissionName => $allowed): ?>

                                            <div class="profile-permission-item">

                                                <div class="profile-permission-name">
                                                    <span class="profile-permission-dot <?= $allowed === 1 ? 'is-allowed' : 'is-denied' ?>"></span>
                                                    <?= $e($permissionName) ?>
                                                </div>

                                                <?php if ($allowed === 1): ?>

                                                    <span class="profile-permission-badge is-allowed">
                                                        <i class="mdi mdi-check-circle-outline"></i>
                                                        Allowed
                                                    </span>

                                                <?php else: ?>

                                                    <span class="profile-permission-badge is-denied">
                                                        <i class="mdi mdi-close-circle-outline"></i>
                                                        Not allowed
                                                    </span>

                                                <?php endif; ?>

                                            </div>

                                        <?php endforeach; ?>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        </div>

                    </section>

                    <!-- =================================================
                         BOTTOM ACTIONS
                    ================================================== -->

                    <div class="profile-bottom-actions">

                        <div class="profile-bottom-note">
                            <i class="mdi mdi-information-outline"></i>
                            This is a read-only preview of the user's account information.
                        </div>

                        <div class="profile-bottom-buttons">

                            <button type="button"
                                    class="btn profile-back-btn"
                                    onclick="window.history.back()">
                                <i class="mdi mdi-arrow-left"></i>
                                Back
                            </button>

                        </div>

                    </div>

                <?php else: ?>

                    <!-- USER NOT FOUND -->

                    <div class="profile-empty-state">

                        <div class="profile-empty-icon">
                            <i class="mdi mdi-account-alert-outline"></i>
                        </div>

                        <h4>User Not Found</h4>

                        <p>
                            <?= $e($loadError !== '' ? $loadError : 'No user information was found.') ?>
                        </p>

                        <button type="button"
                                class="btn profile-back-btn"
                                onclick="window.history.back()">
                            <i class="mdi mdi-arrow-left"></i>
                            Go Back
                        </button>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>

<!-- =========================================================
     SINGLE USER PROFILE STYLES
     Adapts to the existing template light/dark theme variables
========================================================= -->

<style>

.profile-page-row {
    margin-bottom: 24px;
}

.single-user-profile-card {
    margin: 0 24px 24px;
    border: 1px solid var(--surface-border);
    border-radius: 16px;
    background: var(--surface-bg);
    color: var(--body-text);
    box-shadow: 0 8px 28px rgba(15, 23, 42, .055);
    overflow: hidden;
    transition: box-shadow .25s ease, border-color .25s ease;
}

.single-user-profile-card > .card-body {
    padding: 26px;
    background: var(--surface-bg);
}

/* PAGE HEADING */

.profile-page-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 18px;
    padding-bottom: 22px;
    margin-bottom: 24px;
    border-bottom: 1px solid var(--surface-border);
}

.profile-eyebrow {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    margin-bottom: 7px;
    color: #4f83db;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.6px;
}

.profile-eyebrow::before {
    content: "";
    display: inline-block;
    width: 19px;
    height: 2px;
    border-radius: 3px;
    background: #4f83db;
}

.profile-page-title {
    margin: 0 0 7px;
    color: var(--body-text);
    font-size: 24px;
    font-weight: 750;
    letter-spacing: -.6px;
}

.profile-page-subtitle {
    margin: 0;
    color: var(--secondary-text);
    font-size: 12px;
    line-height: 1.8;
}

.profile-heading-actions,
.profile-bottom-buttons {
    display: flex;
    align-items: center;
    gap: 10px;
}

.profile-back-btn,
.profile-edit-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 40px;
    padding: 9px 16px;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: background .2s ease, border-color .2s ease, transform .2s ease;
}

.profile-back-btn {
    border: 1px solid var(--surface-border);
    background: var(--surface-bg);
    color: var(--body-text);
}

.profile-back-btn:hover {
    border-color: #7197d8;
    background: var(--surface-soft);
    color: var(--body-text);
    transform: translateY(-1px);
}

.profile-edit-btn {
    border: 1px solid #376ac4;
    background: #376ac4;
    color: #fff;
}

.profile-edit-btn:hover {
    border-color: #2857a8;
    background: #2857a8;
    color: #fff;
    transform: translateY(-1px);
}

.profile-back-btn i,
.profile-edit-btn i {
    font-size: 17px;
}

/* PROFILE HERO */

.profile-hero {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 24px;
    padding: 30px;
    margin-bottom: 25px;
    overflow: hidden;
    border: 1px solid var(--surface-border);
    border-radius: 14px;
    background:
        radial-gradient(circle at 95% 0%, rgba(91, 134, 213, .12), transparent 32%),
        linear-gradient(115deg, rgba(59, 111, 212, .10), transparent 68%),
        var(--surface-soft);
}

.profile-hero::after {
    content: "";
    position: absolute;
    top: -75px;
    right: -45px;
    width: 200px;
    height: 200px;
    border: 1px solid rgba(86, 132, 211, .16);
    border-radius: 50%;
    pointer-events: none;
}

.profile-hero-main {
    position: relative;
    z-index: 1;
    display: flex;
    align-items: center;
    gap: 22px;
    min-width: 0;
    flex: 1 1 420px;
}

.profile-avatar-wrap {
    position: relative;
    flex-shrink: 0;
    width: 104px;
    height: 104px;
}

.profile-avatar {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
    border: 4px solid var(--surface-bg);
    border-radius: 18px;
    background: var(--surface-bg);
    box-shadow: 0 5px 18px rgba(15, 23, 42, .14);
}

.profile-avatar-indicator {
    position: absolute;
    right: -4px;
    bottom: -4px;
    width: 20px;
    height: 20px;
    border: 4px solid var(--surface-bg);
    border-radius: 50%;
}

.profile-identity {
    min-width: 0;
}

.profile-name-row {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 9px;
}

.profile-user-name {
    margin: 0;
    color: var(--body-text);
    font-size: 22px;
    font-weight: 750;
    line-height: 1.4;
    overflow-wrap: anywhere;
}

.profile-user-role {
    display: flex;
    align-items: center;
    gap: 6px;
    margin-bottom: 14px;
    color: var(--secondary-text);
    font-size: 12px;
    font-weight: 600;
}

.profile-user-role i {
    color: #5d86d2;
    font-size: 17px;
}

.profile-identity-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
    color: var(--secondary-text);
    font-size: 11px;
}

.profile-identity-meta span:not(.profile-meta-divider) {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    overflow-wrap: anywhere;
}

.profile-identity-meta i {
    color: #5d86d2;
    font-size: 15px;
}

.profile-meta-divider {
    width: 3px;
    height: 3px;
    border-radius: 50%;
    background: var(--secondary-text);
}

.profile-hero-side {
    position: relative;
    z-index: 1;
    min-width: 145px;
    padding: 17px 19px;
    border: 1px solid var(--surface-border);
    border-radius: 11px;
    background: var(--surface-bg);
    box-shadow: 0 3px 12px rgba(15, 23, 42, .035);
}

.profile-account-label {
    margin-bottom: 8px;
    color: var(--secondary-text);
    font-size: 9px;
    font-weight: 800;
    letter-spacing: 1px;
}

.profile-account-status {
    font-size: 16px;
    font-weight: 750;
}

.profile-account-caption {
    margin-top: 5px;
    color: var(--secondary-text);
    font-size: 10px;
}

/* STATUS AND ROLE BADGES */

.profile-status-badge,
.profile-role-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 6px 9px;
    border: 1px solid transparent;
    border-radius: 6px;
    font-size: 10px;
    font-weight: 750;
    white-space: nowrap;
}

.profile-status-badge i,
.profile-role-badge i {
    font-size: 14px;
}

.profile-status-active {
    color: #21845a;
}

.profile-status-badge.profile-status-active {
    border-color: rgba(33, 132, 90, .18);
    background: rgba(33, 132, 90, .09);
}

.profile-avatar-indicator.profile-status-active {
    background: #279b68;
}

.profile-status-inactive {
    color: #b78120;
}

.profile-status-badge.profile-status-inactive {
    border-color: rgba(183, 129, 32, .20);
    background: rgba(183, 129, 32, .10);
}

.profile-avatar-indicator.profile-status-inactive {
    background: #d5a13b;
}

.profile-status-deleted {
    color: #cf505b;
}

.profile-status-badge.profile-status-deleted {
    border-color: rgba(207, 80, 91, .20);
    background: rgba(207, 80, 91, .10);
}

.profile-avatar-indicator.profile-status-deleted {
    background: #cf505b;
}

.profile-role-badge {
    border-color: rgba(59, 111, 212, .18);
    background: rgba(59, 111, 212, .09);
    color: #5480d0;
}

/* PROFILE LAYOUT */

.profile-content-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 20px;
    margin-bottom: 20px;
}

.profile-section {
    min-width: 0;
    padding: 24px;
    border: 1px solid var(--surface-border);
    border-radius: 12px;
    background: var(--surface-bg);
    box-shadow: 0 2px 9px rgba(15, 23, 42, .018);
    transition: border-color .2s ease, box-shadow .2s ease;
}

.profile-section:hover {
    border-color: rgba(91, 134, 213, .30);
    box-shadow: 0 5px 16px rgba(15, 23, 42, .035);
}

.profile-section-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 23px;
}

.profile-section-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 42px;
    height: 42px;
    border: 1px solid rgba(59, 111, 212, .14);
    border-radius: 10px;
    background: rgba(59, 111, 212, .08);
    color: #5b86d5;
    font-size: 22px;
}

.profile-section-heading h5 {
    margin: 0 0 5px;
    color: var(--body-text);
    font-size: 14px;
    font-weight: 750;
}

.profile-section-heading p {
    margin: 0;
    color: var(--secondary-text);
    font-size: 10px;
    line-height: 1.6;
}

/* DETAIL FIELDS */

.profile-details-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    column-gap: 22px;
    row-gap: 0;
}

.profile-detail-item {
    min-width: 0;
    padding: 14px 0;
    border-bottom: 1px solid var(--surface-border);
}

.profile-detail-item:nth-last-child(-n+2) {
    border-bottom: none;
}

.profile-detail-label {
    display: block;
    margin-bottom: 7px;
    color: var(--secondary-text);
    font-size: 10px;
    font-weight: 650;
    letter-spacing: .2px;
}

.profile-detail-value {
    min-width: 0;
    color: var(--body-text);
    font-size: 12px;
    font-weight: 650;
    line-height: 1.7;
    overflow-wrap: anywhere;
}

.profile-detail-value a {
    color: var(--body-text);
    text-decoration: none;
    overflow-wrap: anywhere;
}

.profile-detail-value a:hover {
    color: #5480d0;
    text-decoration: underline;
}

.profile-monospace {
    font-family: Consolas, "Courier New", monospace;
    font-size: 11px;
}

.profile-break {
    word-break: break-word;
}

.profile-corridor-value {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    color: var(--body-text);
}

.profile-corridor-value i {
    color: #5b86d5;
    font-size: 15px;
}

.profile-notification-enabled,
.profile-notification-disabled {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    font-size: 11px;
    font-weight: 700;
}

.profile-notification-enabled {
    color: #21845a;
}

.profile-notification-disabled {
    color: var(--secondary-text);
}

/* CURRENT MESSAGE */

.profile-message-section {
    margin-bottom: 20px;
}

.profile-message-content {
    padding: 17px;
    border: 1px solid var(--surface-border);
    border-radius: 9px;
    background: var(--surface-soft);
    color: var(--body-text);
    font-size: 12px;
    line-height: 1.9;
    overflow-wrap: anywhere;
}

.profile-empty-value {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: var(--secondary-text);
}

/* PERMISSIONS */

.profile-permissions-section {
    margin-bottom: 20px;
}

.profile-permissions-heading {
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
}

.profile-section-heading-main {
    display: flex;
    align-items: center;
    gap: 12px;
}

.profile-permission-summary {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 4px;
}

.profile-permission-count {
    color: #5480d0;
    font-size: 18px;
    font-weight: 800;
}

.profile-permission-caption {
    color: var(--secondary-text);
    font-size: 10px;
}

.profile-permissions-groups {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 16px;
}

.profile-permission-group {
    min-width: 0;
    padding: 16px;
    border: 1px solid var(--surface-border);
    border-radius: 9px;
    background: var(--surface-soft);
    transition: border-color .2s ease;
}

.profile-permission-group:hover {
    border-color: rgba(91, 134, 213, .30);
}

.profile-permission-group-title {
    padding-bottom: 12px;
    margin-bottom: 3px;
    border-bottom: 1px solid var(--surface-border);
    color: var(--body-text);
    font-size: 12px;
    font-weight: 750;
}

.profile-permission-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding: 12px 0;
    border-bottom: 1px solid var(--surface-border);
}

.profile-permission-item:last-child {
    padding-bottom: 0;
    border-bottom: none;
}

.profile-permission-name {
    display: flex;
    align-items: center;
    gap: 8px;
    min-width: 0;
    color: var(--body-text);
    font-size: 11px;
    line-height: 1.5;
}

.profile-permission-dot {
    flex-shrink: 0;
    width: 7px;
    height: 7px;
    border-radius: 50%;
}

.profile-permission-dot.is-allowed {
    background: #279b68;
}

.profile-permission-dot.is-denied {
    background: #a4acb8;
}

.profile-permission-badge {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    flex-shrink: 0;
    font-size: 9px;
    font-weight: 700;
    white-space: nowrap;
}

.profile-permission-badge i {
    font-size: 13px;
}

.profile-permission-badge.is-allowed {
    color: #21845a;
}

.profile-permission-badge.is-denied {
    color: var(--secondary-text);
}

/* BOTTOM ACTIONS */

.profile-bottom-actions {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    padding-top: 20px;
    border-top: 1px solid var(--surface-border);
}

.profile-bottom-note {
    display: flex;
    align-items: center;
    gap: 7px;
    color: var(--secondary-text);
    font-size: 11px;
    line-height: 1.7;
}

.profile-bottom-note i {
    color: #5b86d5;
    font-size: 17px;
}

/* EMPTY STATE */

.profile-empty-state {
    padding: 65px 20px;
    text-align: center;
}

.profile-empty-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 76px;
    height: 76px;
    margin: 0 auto 20px;
    border: 1px solid var(--surface-border);
    border-radius: 50%;
    background: var(--surface-soft);
    color: var(--secondary-text);
    font-size: 38px;
}

.profile-empty-state h4 {
    margin-bottom: 9px;
    color: var(--body-text);
    font-size: 18px;
    font-weight: 750;
}

.profile-empty-state p {
    margin-bottom: 22px;
    color: var(--secondary-text);
    font-size: 12px;
    overflow-wrap: anywhere;
}

/* RESPONSIVE */

@media (max-width: 1199.98px) {
    .profile-permissions-groups {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .profile-hero-side {
        min-width: 130px;
    }
}

@media (max-width: 991.98px) {
    .single-user-profile-card {
        margin: 0 12px 18px;
    }

    .single-user-profile-card > .card-body {
        padding: 18px;
    }

    .profile-content-grid {
        grid-template-columns: 1fr;
        gap: 16px;
    }

    .profile-hero {
        padding: 22px;
    }
}

@media (max-width: 767.98px) {
    .single-user-profile-card {
        margin: 0 0 18px;
        border-radius: 12px;
    }

    .single-user-profile-card > .card-body {
        padding: 14px;
    }

    .profile-page-heading {
        align-items: flex-start;
        flex-direction: column;
        gap: 15px;
    }

    .profile-heading-actions {
        width: 100%;
    }

    .profile-heading-actions .btn {
        flex: 1;
    }

    .profile-page-title {
        font-size: 20px;
    }

    .profile-hero {
        align-items: flex-start;
        flex-direction: column;
        padding: 18px;
    }

    .profile-hero-main {
        align-items: flex-start;
        gap: 15px;
        flex-basis: auto;
        width: 100%;
    }

    .profile-avatar-wrap {
        width: 78px;
        height: 78px;
    }

    .profile-user-name {
        font-size: 17px;
    }

    .profile-name-row {
        align-items: flex-start;
        flex-direction: column;
        gap: 7px;
    }

    .profile-identity-meta {
        align-items: flex-start;
        flex-direction: column;
        gap: 7px;
    }

    .profile-meta-divider {
        display: none;
    }

    .profile-hero-side {
        width: 100%;
        min-width: 0;
    }

    .profile-section {
        padding: 17px;
    }

    .profile-details-grid {
        grid-template-columns: 1fr;
    }

    .profile-detail-item:nth-last-child(-n+2) {
        border-bottom: 1px solid var(--surface-border);
    }

    .profile-detail-item:last-child {
        border-bottom: none;
    }

    .profile-permissions-groups {
        grid-template-columns: 1fr;
    }

    .profile-permissions-heading {
        align-items: flex-start;
    }

    .profile-bottom-actions {
        align-items: stretch;
        flex-direction: column;
    }

    .profile-bottom-buttons {
        width: 100%;
    }

    .profile-bottom-buttons .btn {
        flex: 1;
    }

    .profile-permission-summary {
        align-items: flex-start;
    }
}

@media (max-width: 380px) {
    .profile-hero-main {
        flex-direction: column;
    }

    .profile-permission-item {
        align-items: flex-start;
        flex-direction: column;
    }
}

</style>
