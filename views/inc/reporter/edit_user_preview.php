<?php
/*
|--------------------------------------------------------------------------
| LOAD SELECTED USER
|--------------------------------------------------------------------------
*/

$result = $LoadAParticularUsersAndLoginTableForAdmin ?? [];

$user      = [];
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

$Luser_sn = (int)($user['login_sn'] ?? 0);
$user_sn  = (int)($user['user_sn'] ?? 0);

if (($user['user_image'] ?? '') == '') {
    $IsImageUploaded = "no";
}

$user_image = !empty($user['user_image'])
    ? $user['user_image']
    : 'noimage2.png';

$user_id   = $user['user_userid'] ?? '';
$user_name = $user['user_fullname'] ?? 'N/A';

$login_status         = (int)($user['login_status'] ?? 0);
$login_role           = $user['login_role'] ?? '';
$login_edit_user      = (int)($user['login_edit_user'] ?? 0);
$login_create_user    = (int)($user['login_create_user'] ?? 0);
$login_delete_user    = (int)($user['login_delete_user'] ?? 0);
$login_approve_user   = (int)($user['login_approve_user'] ?? 0);
$login_create_report  = (int)($user['login_create_report'] ?? 0);
$login_approve_report = (int)($user['login_approve_report'] ?? 0);
$login_edit_report    = (int)($user['login_edit_report'] ?? 0);
$login_delete_report  = (int)($user['login_delete_report'] ?? 0);
$login_comment        = (int)($user['login_comment'] ?? 0);

$user_msg_notification = (int)($user['user_msg_notification'] ?? 0);
?>

<div class="row">

    <div class="col-12 grid-margin stretch-card">

        <div class="card user-page-card">

            <div class="card-body">

                <div class="d-flex flex-row justify-content-between align-items-center page-heading">

                    <div>
                        <h4 class="card-title mb-1">
                            Profile Information
                        </h4>

                        <p class="text-muted mb-0">
                            View and manage user account information
                        </p>
                    </div>

                </div>

                <?php if (!empty($user)): ?>

                    <form method="POST" action="index.php?action=edit_user" enctype="multipart/form-data">

                        <!-- Hidden identifiers -->
                        <input type="hidden" name="login_sn" value="<?= $Luser_sn ?>">
                        <input type="hidden" name="user_sn" value="<?= $user_sn ?>">

                        <div class="row mt-4">

                            <!-- =====================================================
                                 COLUMN 1: USER INFORMATION
                            ====================================================== -->

                            <div class="col-md-6">

                                <div class="user-form-column">

                                    <div class="user-form-column-title">
                                        User Information
                                    </div>

                                    <!-- TITLE -->
                                    <div class="user-form-group">
                                        <label for="title">Title</label>

                                        <select class="form-control" id="title" name="title" required>
                                            <option value="<?= htmlspecialchars($user['user_title'] ?? ''); ?>">
                                                <?= htmlspecialchars($user['user_title'] ?? ''); ?>
                                            </option>
                                            <option value="Mr">Mr</option>
                                            <option value="Mrs">Mrs</option>
                                            <option value="Miss">Miss</option>
                                            <option value="Ms">Ms</option>
                                            <option value="Dr">Dr</option>
                                            <option value="Prof">Prof</option>
                                        </select>
                                    </div>

                                    <!-- USER IMAGE -->
                                    <div class="user-form-group">
                                        <label>User Image</label>

                                        <div class="user-image-preview">

                                            <input type="hidden" name="IsImageUploaded" value="<?= $sImageUploaded ?>">

                                            <img
                                                id="userImagePreview"
                                                src="views/uploads/img/profile/<?= htmlspecialchars($user_image); ?>"
                                                alt="User"
                                            >

                                        </div>

                                        <input
                                            type="file"
                                            class="form-control mt-3"
                                            id="user_image"
                                            name="user_image"
                                            accept="image/*"
                                        >
                                    </div>

                                    <!-- USER ID -->
                                    <div class="user-form-group">
                                        <label for="userid">User ID</label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            id="userid"
                                            name="user_id"
                                            readonly
                                           value="<?= htmlspecialchars($user['user_userid'] ?? ''); ?>"
                                            required
                                        >
                                    </div>

                                    <!-- FULL NAME -->
                                    <div class="user-form-group">
                                        <label for="fullname">Full Name</label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            id="fullname"
                                            name="fullname"
                                            <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>readonly<?php endif; ?>
                                            value="<?= htmlspecialchars($user['user_fullname'] ?? ''); ?>"
                                            required
                                        >
                                    </div>

                                    <!-- EMAIL -->
                                    <div class="user-form-group">
                                        <label for="email">Email</label>

                                        <input
                                            type="email"
                                            <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>readonly<?php endif; ?>
                                            class="form-control"
                                            id="email"
                                            name="email"
                                            value="<?= htmlspecialchars($user['user_email'] ?? ''); ?>"
                                            required
                                        >
                                    </div>

                                    <!-- PHONE -->
                                    <div class="user-form-group">
                                        <label for="phone">Phone</label>

                                        <input
                                            type="text"
                                            class="form-control"
                                            id="phone"
                                            name="phone"
                                            <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>readonly<?php endif; ?>
                                            value="<?= htmlspecialchars($user['user_phone'] ?? ''); ?>"
                                            required
                                        >
                                    </div>

                                    <!-- MESSAGE NOTIFICATION -->
                                    <div class="user-form-group">
                                        <input
                                            type="hidden"
                                            name="msg_notification"
                                            value="<?= $user_msg_notification ?>"
                                        >
                                    </div>

                                    <!-- MESSAGE -->
                                    <div class="user-form-group">
                                        <input
                                            type="hidden"
                                            name="msg"
                                            value="<?= htmlspecialchars($user['user_msg'] ?? ''); ?>"
                                        >
                                    </div>

                                    <!-- STATUS -->
                                    <div class="user-form-group">
                                        <label for="status">Status</label>

                                        <select class="form-control" id="status" name="status" required
                                            <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                            <option value="<?= $login_status ?>">
                                                <?php
                                                if ($login_status == 1) {
                                                    echo "Active";
                                                } elseif ($login_status == 0) {
                                                    echo "Inactive";
                                                } else {
                                                    echo "Deleted";
                                                }
                                                ?>
                                            </option>
                                      <?php if (!($company_acct_approval == 0 && $company_adminseniorman != $_SESSION['userid'])) : ?>
                                     <option value="1">Active</option>
                                        <?php endif; ?>
                                            <option value="0">Inactive</option>

                                          <?php if ($login_delete_user == 1 || $company_adminseniorman == $_SESSION['userid']) : ?>
                                        <option value="-1">Delete</option>
                                        <?php endif; ?>
                                        </select>

                                        <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>
                                            <input type="hidden" name="status" value="<?= $login_status ?>">
                                        <?php endif; ?>
                                    </div>

                                </div>

                            </div>

                            <!-- =====================================================
                                 COLUMN 2: YOUR ROLE & PERMISSIONS
                                 ALL SELECT FIELDS ARE READ-ONLY
                            ====================================================== -->

                            <div class="col-md-6">

                                <div class="user-form-column">

                                    <div class="user-form-column-title">
                                        Your Role &amp; Permissions
                                    </div>

                                    <!-- ROLE -->
                                    <div class="user-form-group">
                                        <label for="role">Role</label>

                                        <select class="form-control" id="role" name="role" required disabled>
                                            <option value="<?= htmlspecialchars($login_role); ?>">
                                                <?= htmlspecialchars(ucfirst($login_role)); ?>
                                            </option>
                                        </select>

                                        <input
                                            type="hidden"
                                            name="role"
                                            value="<?= htmlspecialchars($login_role); ?>"
                                        >
                                    </div>

                                    <!-- CORRIDOR -->
                                    <div class="user-form-group">

                                        <?php if ($company_adminseniorman == $_SESSION['userid']): ?>

                                            <label for="corridor">Corridor</label>

                                            <select class="form-control" id="corridor" name="corridor" <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                                <option value="<?= htmlspecialchars($user['user_corridor'] ?? ''); ?>">
                                                    <?= htmlspecialchars($user['user_corridor'] ?? ''); ?>
                                                </option>

                                                <?php foreach ($LoadCorridorColumnForSelect as $corridor_options): ?>
                                                    <option value="<?= htmlspecialchars($corridor_options['name']); ?>">
                                                        <?= htmlspecialchars($corridor_options['name']); ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>

                                            <input
                                                type="hidden"
                                                name="corridor"
                                                value="<?= htmlspecialchars($user['user_corridor'] ?? ''); ?>"
                                            >

                                        <?php else: ?>

                                            <input
                                                type="hidden"
                                                name="corridor"
                                                value="<?= htmlspecialchars($user['user_corridor'] ?? ''); ?>"
                                            >

                                        <?php endif; ?>

                                    </div>

                                    <!-- ROLE EDIT USER -->
                                    <div class="user-form-group">
                                        <label for="Role_edit_user">Role Edit User</label>

                                        <select class="form-control" id="Role_edit_user" name="Role_edit_user" required <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                            <option value="<?= $login_edit_user ?>">
                                                <?= $login_edit_user == 1 ? "Allowed" : "Not allowed"; ?>
                                            </option>
                                            <?php if ($company_adminseniorman == $_SESSION['userid']): ?>
                                                <option value="1">Allowed</option>
                                                <option value="0">Not allowed</option>
                                            <?php endif; ?>
                                        </select>

                                        <input
                                            type="hidden"
                                            name="Role_edit_user"
                                            value="<?= $login_edit_user ?>"
                                        >
                                    </div>

                                    <!-- ROLE CREATE USER -->
                                    <div class="user-form-group">
                                        <label for="Role_create_user">Role Create User</label>

                                        <select class="form-control" id="Role_create_user" name="Role_create_user" required <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                            <option value="<?= $login_create_user ?>">
                                                <?= $login_create_user == 1 ? "Allowed" : "Not allowed"; ?>
                                            </option>
                                            <?php if ($company_adminseniorman == $_SESSION['userid']): ?>
                                                <option value="1">Allowed</option>
                                                <option value="0">Not allowed</option>
                                            <?php endif; ?>
                                        </select>

                                        <input
                                            type="hidden"
                                            name="Role_create_user"
                                            value="<?= $login_create_user ?>"
                                        >
                                    </div>

                                    <!-- ROLE DELETE USER -->
                                    <div class="user-form-group">
                                        <label for="Role_delete_user">Role Delete User</label>

                                        <select class="form-control" id="Role_delete_user" name="Role_delete_user" required <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                            <option value="<?= $login_delete_user ?>">
                                                <?= $login_delete_user == 1 ? "Allowed" : "Not allowed"; ?>
                                            </option>
                                            <?php if ($company_adminseniorman == $_SESSION['userid']): ?>
                                                <option value="1">Allowed</option>
                                                <option value="0">Not allowed</option>
                                            <?php endif; ?>
                                        </select>

                                        <input
                                            type="hidden"
                                            name="Role_delete_user"
                                            value="<?= $login_delete_user ?>"
                                        >
                                    </div>

                                    <!-- ROLE APPROVE USER -->
                                    <div class="user-form-group">
                                        <label for="Role_approve_user">Role Approve User</label>

                                        <select class="form-control" id="Role_approve_user" name="Role_approve_user" required <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                            <option value="<?= $login_approve_user ?>">
                                                <?= $login_approve_user == 1 ? "Allowed" : "Not allowed"; ?>
                                            </option>
                                            <?php if ($company_adminseniorman == $_SESSION['userid']): ?>
                                                <option value="1">Allowed</option>
                                                <option value="0">Not allowed</option>
                                            <?php endif; ?>
                                        </select>

                                        <input
                                            type="hidden"
                                            name="Role_approve_user"
                                            value="<?= $login_approve_user ?>"
                                        >
                                    </div>

                                    <!-- ROLE CREATE REPORT -->
                                    <div class="user-form-group">
                                        <label for="Role_create_report">Role Create Report</label>

                                        <select class="form-control" id="Role_create_report" name="Role_create_report" required <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                            <option value="<?= $login_create_report ?>">
                                                <?= $login_create_report == 1 ? "Allowed" : "Not allowed"; ?>
                                            </option>
                                            <?php if ($company_adminseniorman == $_SESSION['userid']): ?>
                                                <option value="1">Allowed</option>
                                                <option value="0">Not allowed</option>
                                            <?php endif; ?>
                                        </select>

                                        <input
                                            type="hidden"
                                            name="Role_create_report"
                                            value="<?= $login_create_report ?>"
                                        >
                                    </div>

                                    <!-- ROLE APPROVE REPORT -->
                                    <div class="user-form-group">
                                        <label for="Role_approve_report">Role Approve Report</label>

                                        <select class="form-control" id="Role_approve_report" name="Role_approve_report" required <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                            <option value="<?= $login_approve_report ?>">
                                                <?= $login_approve_report == 1 ? "Allowed" : "Not allowed"; ?>
                                            </option>
                                            <?php if ($company_adminseniorman == $_SESSION['userid']): ?>
                                                <option value="1">Allowed</option>
                                                <option value="0">Not allowed</option>
                                            <?php endif; ?>
                                        </select>

                                        <input
                                            type="hidden"
                                            name="Role_approve_report"
                                            value="<?= $login_approve_report ?>"
                                        >
                                    </div>

                                    <!-- ROLE EDIT REPORT -->
                                    <div class="user-form-group">
                                        <label for="Role_edit_report">Role Edit Report</label>

                                        <select class="form-control" id="Role_edit_report" name="Role_edit_report" required <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                            <option value="<?= $login_edit_report ?>">
                                                <?= $login_edit_report == 1 ? "Allowed" : "Not allowed"; ?>
                                            </option>
                                            <?php if ($company_adminseniorman == $_SESSION['userid']): ?>
                                                <option value="1">Allowed</option>
                                                <option value="0">Not allowed</option>
                                            <?php endif; ?>
                                        </select>

                                        <input
                                            type="hidden"
                                            name="Role_edit_report"
                                            value="<?= $login_edit_report ?>"
                                        >
                                    </div>

                                    <!-- ROLE DELETE REPORT -->
                                    <div class="user-form-group">
                                        <label for="Role_delete_report">Role Delete Report</label>

                                        <select class="form-control" id="Role_delete_report" name="Role_delete_report" required <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                            <option value="<?= $login_delete_report ?>">
                                                <?= $login_delete_report == 1 ? "Allowed" : "Not allowed"; ?>
                                            </option>
                                            <?php if ($company_adminseniorman == $_SESSION['userid']): ?>
                                                <option value="1">Allowed</option>
                                                <option value="0">Not allowed</option>
                                            <?php endif; ?>
                                        </select>

                                        <input
                                            type="hidden"
                                            name="Role_delete_report"
                                            value="<?= $login_delete_report ?>"
                                        >
                                    </div>

                                    <!-- ROLE COMMENT -->
                                    <div class="user-form-group">
                                        <label for="Role_comment">Role Comment</label>

                                        <select class="form-control" id="Role_comment" name="Role_comment" required <?php if (!($company_adminseniorman == $_SESSION['userid'])): ?>disabled<?php endif; ?>>
                                            <option value="<?= $login_comment ?>">
                                                <?= $login_comment == 1 ? "Allowed" : "Not allowed"; ?>
                                            </option>
                                            <?php if ($company_adminseniorman == $_SESSION['userid']): ?>
                                                <option value="1">Allowed</option>
                                                <option value="0">Not allowed</option>
                                            <?php endif; ?>
                                        </select>

                                        <input
                                            type="hidden"
                                            name="Role_comment"
                                            value="<?= $login_comment ?>"
                                        >
                                    </div>

                                </div>

                            </div>

                        </div>

                        <div class="cf-turnstile" data-sitekey="0x4AAAAAAE_lhXRw6nDkauM7"></div>

                        <!-- =====================================================
                             FORM ACTIONS
                        ====================================================== -->

                        <div class="user-form-actions">

                            <button type="submit" class="btn btn-primary" name="dev_update_user">
                                <i class="mdi mdi-content-save-outline"></i>
                                Save Changes
                            </button>

                            <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                Cancel
                            </button>

                        </div>

                    </form>

                <?php else: ?>

                    <div class="user-form-empty">
                        <i class="mdi mdi-account-alert-outline"></i>
                        <h4>User Not Found</h4>
                        <p><?= htmlspecialchars($loadError !== '' ? $loadError : 'No user information was found.'); ?></p>
                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     USER PAGE STYLES — ADAPTED TO TEMPLATE THEME VARIABLES
========================================================= -->

<style>

    .user-page-card {
        margin: 0 24px 28px;
        border: 1px solid var(--surface-border);
        border-radius: 16px;
        background: var(--surface-bg);
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
        color: var(--body-text);
    }

    .user-page-card .card-body {
        background: var(--surface-bg);
        padding: 22px 24px;
    }

    .page-heading {
        border-bottom: 1px solid var(--surface-border);
        padding-bottom: 18px;
        margin-bottom: 6px;
    }

    .page-heading .card-title {
        color: var(--body-text);
        font-weight: 700;
    }

    .page-heading .text-muted {
        color: var(--secondary-text) !important;
        font-size: 12px;
    }

    .user-form-column {
        width: 100%;
        padding: 24px;
        background: var(--surface-soft);
        border: 1px solid var(--surface-border);
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, .04);
        color: var(--body-text);
    }

    .user-form-column-title {
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--surface-border);
        color: var(--body-text);
        font-size: 15px;
        font-weight: 700;
    }

    .user-form-group {
        margin-bottom: 20px;
    }

    .user-form-group label {
        display: block;
        margin-bottom: 8px;
        color: var(--secondary-text);
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .3px;
    }

    .user-form-group .form-control {
        width: 100%;
        min-height: 45px;
        border: 1px solid var(--surface-border) !important;
        border-radius: 8px;
        background: var(--surface-bg) !important;
        color: var(--body-text) !important;
        font-size: 13px;
        transition: border-color .2s ease, box-shadow .2s ease;
    }

    .user-form-group .form-control::placeholder {
        color: var(--secondary-text) !important;
        opacity: .7;
    }

    .user-form-group .form-control:focus {
        border-color: #3b6fd4 !important;
        background: var(--surface-bg) !important;
        color: var(--body-text) !important;
        box-shadow: 0 0 0 0.15rem rgba(59, 111, 212, .15) !important;
        outline: none;
    }

    /* SELECT */
    .user-form-group select.form-control {
        appearance: auto;
        -webkit-appearance: auto;
        cursor: pointer;
    }

    /* Keep read-only permission selects visually consistent */
    .user-form-group select.form-control:disabled {
        opacity: 1;
        cursor: not-allowed;
        background: var(--surface-bg) !important;
        color: var(--body-text) !important;
    }

    .user-form-group select.form-control option {
        background: var(--surface-bg);
        color: var(--body-text);
    }

    /* TEXTAREA */
    .user-form-group textarea.form-control {
        min-height: 120px;
        resize: vertical;
    }

    /* FILE INPUT */
    .user-form-group input[type="file"] {
        padding: 9px 12px;
    }

    .user-form-group input[type="file"]::file-selector-button {
        margin-right: 10px;
        padding: 7px 12px;
        border: 1px solid var(--surface-border);
        border-radius: 6px;
        background: var(--surface-soft);
        color: var(--body-text);
        cursor: pointer;
        transition: background .2s ease;
    }

    .user-form-group input[type="file"]::file-selector-button:hover {
        background: var(--table-hover-bg);
    }

    /* USER IMAGE PREVIEW */
    .user-image-preview {
        width: 110px;
        height: 110px;
        overflow: hidden;
        border-radius: 12px;
        border: 1px solid var(--surface-border);
        background: var(--surface-bg);
    }

    .user-image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    /* FORM ACTIONS */
    .user-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 12px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid var(--surface-border);
    }

    .user-form-actions .btn {
        min-height: 45px;
        padding: 0 22px;
        border-radius: 8px;
        font-weight: 600;
        font-size: 13px;
    }

    .user-form-actions .btn i {
        margin-right: 5px;
    }

    /* EMPTY STATE */
    .user-form-empty {
        padding: 60px 20px;
        text-align: center;
        color: var(--secondary-text);
    }

    .user-form-empty i {
        display: block;
        margin-bottom: 15px;
        color: var(--secondary-text);
        opacity: .5;
        font-size: 55px;
    }

    .user-form-empty h4 {
        margin-bottom: 8px;
        color: var(--body-text);
    }

    .user-form-empty p {
        margin: 0;
        color: var(--secondary-text);
    }

    /* MOBILE */
    @media (max-width: 991.98px) {
        .user-page-card {
            margin: 0 12px 18px;
        }

        .user-page-card .card-body {
            padding: 16px;
        }
    }

    @media (max-width: 767px) {
        .user-form-column {
            margin-bottom: 20px;
            padding: 18px;
        }

        .user-form-actions {
            flex-direction: column;
        }

        .user-form-actions .btn {
            width: 100%;
        }
    }

</style>


<!-- =========================================================
     IMAGE PREVIEW JAVASCRIPT (safe-guarded)
========================================================= -->

<script>
    (function () {
        var input = document.getElementById('user_image');
        var preview = document.getElementById('userImagePreview');

        if (!input || !preview) return;

        input.addEventListener('change', function (event) {
            var file = event.target.files[0];

            if (!file) return;

            if (!file.type.startsWith('image/')) {
                event.target.value = '';
                return;
            }

            var reader = new FileReader();

            reader.onload = function (e) {
                preview.src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
    })();
</script>