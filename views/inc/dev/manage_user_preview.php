
<?php

$Ltable_name = "login";
$Ltable_sn = $user_sn = 0;
$page_controller = base64_encode("users");

/*
|--------------------------------------------------------------------------
| LOAD SELECTED USER
|--------------------------------------------------------------------------
*/

$user = !empty($LoadUsersAndLoginTable)
    ? $LoadUsersAndLoginTable[0]
    : [];

$Luser_sn = $user['login_sn'] ?? 0;
$user_sn = $user['user_sn'] ?? 0;

if (empty($user['user_image'])) {
    $user_image = "noimage2.png";
}else {
     $user_image = $user['user_image'];
}

$user_id = $user['user_userid'] ?? '';
$user_name = $user['user_fullname'] ?? 'N/A';
?>

<div class="row">

<div class="col-12 grid-margin stretch-card">

<div class="card user-dark-card">


<div class="card-body">

    <div
        class="d-flex flex-row justify-content-between align-items-center dashboard-table-heading user-dark-heading"
    >

        <div>

            <h4 class="card-title mb-1">
                User Information
            </h4>

            <p class="text-muted mb-0">
                View and manage user account information
            </p>

        </div>

    </div>


    <?php if (!empty($user)): ?>

        <form
            method="POST"
            action="index.php?action=edit_user"
            enctype="multipart/form-data"
        >

            <div class="row mt-4">


                <!-- =====================================================
                     COLUMN 1
                ====================================================== -->

                <div class="col-md-6">

                    <div class="user-form-column">

                        <div class="user-form-column-title">
                            User Information
                        </div>


                        <!-- TITLE -->

                        <div class="user-form-group">

                            <label for="title">
                                Title
                            </label>

                            <select
                                class="form-control"
                                id="title"
                                name="title"
                                required
                            >

                                <option
                                    value="<?= htmlspecialchars($user['user_title'] ?? ''); ?>"
                                >
                                    <?= htmlspecialchars($user['user_title'] ?? ''); ?>
                                </option>

                                <!-- <option
                                    value=""
                                >
                                    Select Title
                                </option> -->

                                <option
                                    value="Mr"
                                >
                                    Mr
                                </option>

                                <option
                                    value="Mrs"
                                >
                                    Mrs
                                </option>

                                <option
                                    value="Miss"
                                >
                                    Miss
                                </option>

                                <option
                                    value="Ms"
                                >
                                    Ms
                                </option>

                                <option
                                    value="Dr"
                                >
                                    Dr
                                </option>

                                <option
                                    value="Prof"
                                >
                                    Prof
                                </option>

                            </select>

                        </div>


                        <!-- USER IMAGE -->

                        <div class="user-form-group">

                            <label>
                                User Image
                            </label>

                            <div class="user-image-preview">

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

                            <label for="userid">
                                User ID
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="userid"
                                name="user_id"
                                value="<?= htmlspecialchars($user['user_userid'] ?? ''); ?>"
                                required
                            >

                        </div>


                        <!-- EMAIL -->

                        <div class="user-form-group">

                            <label for="email">
                                Email
                            </label>

                            <input
                                type="email"
                                class="form-control"
                                id="email"
                                name="email"
                                value="<?= htmlspecialchars($user['user_email'] ?? ''); ?>"
                                required
                            >

                        </div>


                        <!-- PHONE -->

                        <div class="user-form-group">

                            <label for="phone">
                                Phone
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="phone"
                                name="phone"
                                value="<?= htmlspecialchars($user['user_phone'] ?? ''); ?>"
                                required
                            >

                        </div>


                        <!-- MESSAGE NOTIFICATION -->

                        <div class="user-form-group">

                            <label for="msg_notification">
                                Message Notification 
                            </label>

                            <select
                                class="form-control"
                                id="msg_notification"
                                name="msg_notification"
                                required
                            >

                                <option
                                    value="<?= $user['user_msg_notification'] ?>"
                                >
             <?php if ($user['user_msg_notification'] == 1) { echo "Enabled"; }else{ echo "Disabled"; } ?>
                                </option>

                                <option
                                    value="1"
                                >
                                    Enabled
                                </option>

                                <option
                                    value="0"
                                >
                                    Disabled
                                </option>

                            </select>

                        </div>


                        <!-- MESSAGE -->

                        <div class="user-form-group">

                            <label for="msg">
                                Message(Current message)
                            </label>

                            <textarea
                                class="form-control"
                                id="msg"
                                name="msg"
                                rows="5"
                            ><?= htmlspecialchars($user['user_msg'] ?? ''); ?></textarea>

                        </div>


                        <!-- FULL NAME -->

                        <div class="user-form-group">

                            <label for="fullname">
                                Full Name
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                id="fullname"
                                name="fullname"
                                value="<?= htmlspecialchars($user['user_fullname'] ?? ''); ?>"
                                required
                            >

                        </div>


                        <!-- STATUS -->

                        <div class="user-form-group">

                            <label for="status">
                                Status
                            </label>

                            <select
                                class="form-control"
                                id="status"
                                name="status"
                                required
                            >

                                <option value="<?= $user['login_status'] ?>">
                                    <?php
                                    if ($user['login_status'] == 1) {
                                        echo "Active";
                                    } elseif ($user['login_status'] == 0) {
                                        echo "Inactive";
                                    } else {
                                        echo "Deleted";
                                    }
                                    ?>
                                </option>

                                <option value="1">
                                    Active
                                </option>

                                <option value="0">
                                    Inactive
                                </option>

                                <option value="-1">
                                    Deleted
                                </option>

                            </select>


                        </div>

                    </div>

                </div>


                <!-- =====================================================
                     COLUMN 2
                ====================================================== -->

                <div class="col-md-6">

                    <div class="user-form-column">

                        <div class="user-form-column-title">
                            User Role & Permissions
                        </div>


                        <!-- ROLE -->

                        <div class="user-form-group">

                            <label for="role">
                                Role
                            </label>

                            <select
                                class="form-control"
                                id="role"
                                name="role"
                                required
                            >

                                <option
                                    value="<?= htmlspecialchars($user['login_role'] ?? ''); ?>"
                                >
                                    <?= htmlspecialchars(ucfirst($user['login_role'] ?? '')); ?>
                                </option>

                                <!-- <option
                                    value=""
                                >
                                    Select Role
                                </option> -->

                                <option
                                    value="administrator"
                                >
                                    Administrator
                                </option>

                                <option
                                    value="supervisor"
                                >
                                    Supervisor
                                </option>

                                <option
                                    value="reporter"
                                >
                                    Reporter
                                </option>

                            </select>

                        </div>


                        <!-- ROLE EDIT USER -->

                        <div class="user-form-group">

                            <label for="Role_edit_user">
                                Role Edit User
                            </label>

                            <select
                                class="form-control"
                                id="Role_edit_user"
                                name="Role_edit_user"
                                required
                            >

                                <option value="<?= $user['login_edit_user'] ?>">
                                    <?php if ($user['login_edit_user'] == 1) { echo "Allowed"; } else { echo "Not allowed"; } ?>
                                </option>

                                <option value="1">
                                    Allowed
                                </option>

                                <option value="0">
                                    Not allowed
                                </option>

                            </select>

                        </div>


                        <!-- ROLE CREATE USER -->

                        <div class="user-form-group">

                            <label for="Role_create_user">
                                Role Create User
                            </label>

                            <select
                                class="form-control"
                                id="Role_create_user"
                                name="Role_create_user"
                                required
                            >

                                <option value="<?= $user['login_create_user'] ?>">
                                    <?php if ($user['login_create_user'] == 1) { echo "Allowed"; } else { echo "Not allowed"; } ?>
                                </option>

                                <option value="1">
                                    Allowed
                                </option>

                                <option value="0">
                                    Not allowed
                                </option>

                            </select>

                        </div>


                        <!-- ROLE DELETE USER -->

                        <div class="user-form-group">

                            <label for="Role_delete_user">
                                Role Delete User
                            </label>

                            <select
                                class="form-control"
                                id="Role_delete_user"
                                name="Role_delete_user"
                                required
                            >

                                <option value="<?= $user['login_delete_user'] ?>">
                                    <?php if ($user['login_delete_user'] == 1) { echo "Allowed"; } else { echo "Not allowed"; } ?>
                                </option>

                                <option value="1">
                                    Allowed
                                </option>

                                <option value="0">
                                    Not allowed
                                </option>

                            </select>

                        </div>


                        <!-- ROLE APPROVE USER -->

                        <div class="user-form-group">

                            <label for="Role_approve_user">
                                Role Approve User
                            </label>

                            <select
                                class="form-control"
                                id="Role_approve_user"
                                name="Role_approve_user"
                                required
                            >

                                <option value="<?= $user['login_approve_user'] ?>">
                                    <?php if ($user['login_approve_user'] == 1) { echo "Allowed"; } else { echo "Not allowed"; } ?>
                                </option>

                                <option value="1">
                                    Allowed
                                </option>

                                <option value="0">
                                    Not allowed
                                </option>

                            </select>

                        </div>


                        <!-- ROLE CREATE REPORT -->

                        <div class="user-form-group">

                            <label for="Role_create_report">
                                Role Create Report
                            </label>

                            <select
                                class="form-control"
                                id="Role_create_report"
                                name="Role_create_report"
                                required
                            >

                                <option value="<?= $user['login_create_report'] ?>">
                                    <?php if ($user['login_create_report'] == 1) { echo "Allowed"; } else { echo "Not allowed"; } ?>
                                </option>

                                <option value="1">
                                    Allowed
                                </option>

                                <option value="0">
                                    Not allowed
                                </option>

                            </select>

                        </div>


                        <!-- ROLE APPROVE REPORT -->

                        <div class="user-form-group">

                            <label for="Role_approve_report">
                                Role Approve Report
                            </label>

                            <select
                                class="form-control"
                                id="Role_approve_report"
                                name="Role_approve_report"
                                required
                            >

                                <option value="<?= $user['login_approve_report'] ?>">
                                    <?php if ($user['login_approve_report'] == 1) { echo "Allowed"; } else { echo "Not allowed"; } ?>
                                </option>

                                <option value="1">
                                    Allowed
                                </option>

                                <option value="0">
                                    Not allowed
                                </option>

                            </select>

                        </div>


                        <!-- ROLE EDIT REPORT -->

                        <div class="user-form-group">

                            <label for="Role_edit_report">
                                Role Edit Report
                            </label>

                            <select
                                class="form-control"
                                id="Role_edit_report"
                                name="Role_edit_report"
                                required
                            >

                                <option value="<?= $user['login_edit_report'] ?>">
                                    <?php if ($user['login_edit_report'] == 1) { echo "Allowed"; } else { echo "Not allowed"; } ?>
                                </option>

                                <option value="1">
                                    Allowed
                                </option>

                                <option value="0">
                                    Not allowed
                                </option>

                            </select>

                        </div>


                        <!-- ROLE DELETE REPORT -->

                        <div class="user-form-group">

                            <label for="Role_delete_report">
                                Role Delete Report
                            </label>

                            <select
                                class="form-control"
                                id="Role_delete_report"
                                name="Role_delete_report"
                                required
                            >

                                <option value="<?= $user['login_delete_report'] ?>">
                                    <?php if ($user['login_delete_report'] == 1) { echo "Allowed"; } else { echo "Not allowed"; } ?>
                                </option>

                                <option value="1">
                                    Allowed
                                </option>

                                <option value="0">
                                    Not allowed
                                </option>

                            </select>

                        </div>


                        <!-- ROLE COMMENT -->

                        <div class="user-form-group">

                            <label for="Role_comment">
                                Role Comment
                            </label>

                            <select
                                class="form-control"
                                id="Role_comment"
                                name="Role_comment"
                                required
                            >

                                <option value="<?= $user['login_comment'] ?>">
                                    <?php if ($user['login_comment'] == 1) { echo "Allowed"; } else { echo "Not allowed"; } ?>
                                </option>

                                <option value="1">
                                    Allowed
                                </option>

                                <option value="0">
                                    Not allowed
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            <!-- =====================================================
                 FORM ACTIONS
            ====================================================== -->

            <div class="user-form-actions">

                <button
                    type="submit"
                    class="btn btn-primary"
                    name="dev_update_user"
                >

                    <i class="mdi mdi-content-save-outline"></i>

                    Save Changes

                </button>

                <button
                    type="button"
                    class="btn btn-dark"
                    onclick="window.history.back()"
                >

                    Cancel

                </button>

            </div>

        </form>

    <?php else: ?>

        <div class="user-form-empty">

            <i class="mdi mdi-account-alert-outline"></i>

            <h4>
                User Not Found
            </h4>

            <p>
                No user information was found.
            </p>

        </div>

    <?php endif; ?>

</div>

</div>

</div>

</div>

<!-- =========================================================
     DARK MODE FORM CSS
========================================================= -->

<style>

.user-dark-card {
    background: #191c24 !important;
    border: 1px solid #2a2e38 !important;
    color: #ffffff !important;
}


.user-dark-card .card-body {
    background: #191c24 !important;
}


.user-dark-heading {
    border-bottom: 1px solid #2a2e38;
    padding-bottom: 18px;
}


.user-dark-heading .card-title {
    color: #ffffff !important;
}


.user-dark-heading .text-muted {
    color: #8f95a5 !important;
}


/* ---------------------------------------------------------
   FORM COLUMN
--------------------------------------------------------- */

.user-form-column {
    width: 100%;
    padding: 24px;
    background: #20232c;
    border: 1px solid #303541;
    border-radius: 14px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.18);
}


.user-form-column-title {
    margin-bottom: 25px;
    padding-bottom: 15px;
    border-bottom: 1px solid #303541;
    color: #ffffff;
    font-size: 18px;
    font-weight: 700;
}


/* ---------------------------------------------------------
   FORM GROUP
--------------------------------------------------------- */

.user-form-group {
    margin-bottom: 20px;
}


.user-form-group label {
    display: block;
    margin-bottom: 8px;
    color: #c7cbd5;
    font-size: 14px;
    font-weight: 600;
}


/* ---------------------------------------------------------
   INPUTS
--------------------------------------------------------- */

.user-form-group .form-control {
    width: 100%;
    min-height: 45px;
    border: 1px solid #3a3f4b !important;
    border-radius: 8px;
    background: #191c24 !important;
    color: #ffffff !important;
    font-size: 14px;
}


.user-form-group .form-control::placeholder {
    color: #777e8e !important;
}


.user-form-group .form-control:focus {
    border-color: #00d25b !important;
    background: #191c24 !important;
    color: #ffffff !important;
    box-shadow: 0 0 0 0.15rem rgba(0, 210, 91, 0.10) !important;
}


/* ---------------------------------------------------------
   SELECT
--------------------------------------------------------- */

.user-form-group select.form-control {
    appearance: auto;
    -webkit-appearance: auto;
    cursor: pointer;
}


.user-form-group select.form-control option {
    background: #191c24;
    color: #ffffff;
}


/* ---------------------------------------------------------
   TEXTAREA
--------------------------------------------------------- */

.user-form-group textarea.form-control {
    min-height: 120px;
    resize: vertical;
}


/* ---------------------------------------------------------
   FILE INPUT
--------------------------------------------------------- */

.user-form-group input[type="file"] {
    padding: 9px 12px;
}


.user-form-group input[type="file"]::file-selector-button {
    margin-right: 10px;
    padding: 7px 12px;
    border: 1px solid #3a3f4b;
    border-radius: 6px;
    background: #2a2e38;
    color: #ffffff;
    cursor: pointer;
}


/* ---------------------------------------------------------
   USER IMAGE
--------------------------------------------------------- */

.user-image-preview {
    width: 100px;
    height: 100px;
    overflow: hidden;
    border-radius: 12px;
    border: 1px solid #3a3f4b;
    background: #191c24;
}


.user-image-preview img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}


/* ---------------------------------------------------------
   FORM ACTIONS
--------------------------------------------------------- */

.user-form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #2a2e38;
}


.user-form-actions .btn {
    min-height: 45px;
    padding: 0 22px;
    border-radius: 8px;
}


.user-form-actions .btn i {
    margin-right: 5px;
}


/* ---------------------------------------------------------
   EMPTY STATE
--------------------------------------------------------- */

.user-form-empty {
    padding: 60px 20px;
    text-align: center;
    color: #8f95a5;
}


.user-form-empty i {
    display: block;
    margin-bottom: 15px;
    color: #5f6675;
    font-size: 55px;
}


.user-form-empty h4 {
    margin-bottom: 8px;
    color: #ffffff;
}


.user-form-empty p {
    margin: 0;
    color: #8f95a5;
}


/* ---------------------------------------------------------
   MOBILE
--------------------------------------------------------- */

@media (max-width: 767px) {

    .user-form-column {
        margin-bottom: 20px;
        padding: 20px;
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
     IMAGE PREVIEW JAVASCRIPT
========================================================= -->

<script>

document
    .getElementById('user_image')
    .addEventListener('change', function (event) {

        const file = event.target.files[0];

        const preview = document.getElementById('userImagePreview');

        if (!file) {
            return;
        }


        if (!file.type.startsWith('image/')) {

            event.target.value = '';

            return;
        }


        const reader = new FileReader();

        reader.onload = function (e) {

            preview.src = e.target.result;

        };

        reader.readAsDataURL(file);

    });

</script>
