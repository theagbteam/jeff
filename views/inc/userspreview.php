<?php

$table_name = "users";
$user_sn = 0;

?>

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
                            Overview of recent system users
                        </p>

                    </div>

                    <?php if ($page_name == "dashboard") : ?>

                        <a
                            href="index?action=users"
                            class="btn btn-primary"
                        >
                            View All
                        </a>

                    <?php endif; ?>

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
                                <th>Title</th>
                                <th>Role</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>

                        </thead>


                        <tbody>

                            <?php if (!empty($LoadUsersAndLoginTable)): ?>

                                <?php $sn = 1; ?>

                                <?php foreach ($LoadUsersAndLoginTable as $user): ?>

                                    <?php

                                    $user_image = "noimage2.png";

                                    $user_sn = $user['user_sn'] ?? 0;

                                    if ($user['user_image'] != "") {
                                        $user_image = $user['user_image'];
                                    }

                                    $user_id = $user['user_userid'] ?? '';
                                    $user_name = $user['user_fullname'] ?? 'N/A';

                                    ?>

                                    <tr>

                                        <!-- S/N -->
                                        <td>
                                            <?= $sn++; ?>
                                        </td>


                                        <!-- USER -->
                                        <td>

                                            <div class="dashboard-table-user">

                                                <img
                                                    class="dashboard-table-avatar"
                                                    src="views/uploads/img/profile/<?= htmlspecialchars($user_image); ?>"
                                                    alt="User"
                                                >

                                                <div>

                                                    <div class="dashboard-table-user-name">

                                                        <?= ucfirst(
                                                            htmlspecialchars(
                                                                $user['user_fullname'] ?? 'N/A'
                                                            )
                                                        ); ?>

                                                    </div>

                                                    <div class="dashboard-table-user-email">

                                                        <?= htmlspecialchars(
                                                            $user['user_email'] ?? 'N/A'
                                                        ); ?>

                                                    </div>

                                                </div>

                                            </div>

                                        </td>


                                        <!-- TITLE -->
                                        <td>

                                            <?= ucfirst(
                                                htmlspecialchars(
                                                    $user['user_title'] ?? 'N/A'
                                                )
                                            ); ?>

                                        </td>


                                        <!-- ROLE -->
                                        <td>

                                            <span class="dashboard-role">

                                                <?= ucfirst(
                                                    htmlspecialchars(
                                                        $user['login_role_name'] ?? 'N/A'
                                                    )
                                                ); ?>

                                            </span>

                                        </td>


                                        <!-- DATE -->
                                        <td>

                                            <?= !empty($user['user_date'])
                                                ? date(
                                                    'd M Y, h:i A',
                                                    strtotime($user['user_date'])
                                                )
                                                : 'N/A';
                                            ?>

                                        </td>


                                        <!-- STATUS -->
                                        <td>

                                            <?php if (($user['login_status'] ?? '') == 1): ?>

                                                <span class="dashboard-status dashboard-status-active">
                                                    Active
                                                </span>

                                            <?php elseif (($user['login_status'] ?? '') == 0): ?>

                                                <span class="dashboard-status dashboard-status-pending">
                                                    Inactive
                                                </span>

                                            <?php else: ?>

                                                <span
                                                    class="dashboard-status dashboard-status-danger"
                                                    style="
                                                        background-color: #fee2e2;
                                                        color: #dc2626;
                                                        border: 1px solid #fecaca;
                                                    "
                                                >
                                                    Deleted
                                                </span>

                                            <?php endif; ?>

                                        </td>


                                        <!-- ACTION -->
                                        <td>

                                            <?php if ($user['login_status'] == 0 || $user['login_status'] == 1): ?>

                                                <!-- EDIT BUTTON -->
                                                <!-- EDIT PASSES ONLY USER SN -->
                                                <button
                                                    type="button"
                                                    class="dashboard-table-action"
                                                    title="Edit"
                                                    onclick="window.location.href='index?action=edit_user&sn=<?= urlencode($user_sn); ?>'"
                                                >
                                                    <i class="mdi mdi-pencil"></i>
                                                </button>


                                                <!-- DELETE BUTTON -->
                                                <!-- DELETE PASSES SN + TABLE NAME -->
                                                <button
                                                    type="button"
                                                    class="dashboard-table-action delete-user-btn"
                                                    title="Delete"
                                                    onclick="showDeleteModal(
                                                        '<?= htmlspecialchars($user_sn, ENT_QUOTES); ?>',
                                                        '<?= htmlspecialchars($user_name, ENT_QUOTES); ?>',
                                                        '<?= htmlspecialchars($table_name, ENT_QUOTES); ?>'
                                                    )"
                                                >

                                                    <i class="mdi mdi-delete"></i>

                                                </button>

                                            <?php else: ?>

                                                <!-- RESTORE BUTTON -->
                                                <!-- RESTORE WILL ASK FOR CONFIRMATION FIRST -->
                                                <button
                                                    type="button"
                                                    class="dashboard-table-action recycle-user-btn"
                                                    title="Restore"
                                                    onclick="showRestoreModal(
                                                        '<?= htmlspecialchars($user_sn, ENT_QUOTES); ?>',
                                                        '<?= htmlspecialchars($user_name, ENT_QUOTES); ?>',
                                                        '<?= htmlspecialchars($table_name, ENT_QUOTES); ?>'
                                                    )"
                                                >

                                                    <i class="mdi mdi-recycle"></i>

                                                </button>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>


                            <?php else: ?>

                                <tr>

                                    <td
                                        colspan="7"
                                        class="text-center"
                                    >
                                        No recent activity found.
                                    </td>

                                </tr>

                            <?php endif; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>



<!-- =========================================================
     DELETE CONFIRMATION MODAL
========================================================= -->

<div
    id="deleteModal"
    class="delete-modal-overlay"
    aria-hidden="true"
>

    <div
        class="delete-modal-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="deleteModalTitle"
    >

        <!-- CLOSE BUTTON -->
        <button
            type="button"
            class="delete-modal-close"
            onclick="closeDeleteModal()"
            aria-label="Close"
        >
            &times;
        </button>


        <!-- DELETE ICON -->
        <div class="delete-modal-icon">

            <i class="mdi mdi-delete-alert-outline"></i>

        </div>


        <!-- TITLE -->
        <h3 id="deleteModalTitle">
            Are you sure?
        </h3>


        <!-- MESSAGE -->
        <p>

            Do you truly want to delete

            <strong id="deleteUserName">
                this user
            </strong>?

        </p>


        <!-- WARNING -->
        <!-- <div class="delete-modal-warning">

            <i class="mdi mdi-alert-circle-outline"></i>

            <span>
                This action cannot be undone.
            </span>

        </div> -->


        <!-- ACTION BUTTONS -->
        <div class="delete-modal-actions">

            <button
                type="button"
                class="delete-modal-cancel"
                onclick="closeDeleteModal()"
            >
                Cancel
            </button>


            <button
                type="button"
                class="delete-modal-confirm"
                id="confirmDeleteBtn"
            >

                <i class="mdi mdi-delete-outline"></i>

                Yes, Delete

            </button>

        </div>

    </div>

</div>



<!-- =========================================================
     RESTORE CONFIRMATION MODAL
========================================================= -->

<div
    id="restoreModal"
    class="restore-modal-overlay"
    aria-hidden="true"
>

    <div
        class="restore-modal-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="restoreModalTitle"
    >

        <!-- CLOSE BUTTON -->
        <button
            type="button"
            class="restore-modal-close"
            onclick="closeRestoreModal()"
            aria-label="Close"
        >
            &times;
        </button>


        <!-- RESTORE ICON -->
        <div class="restore-modal-icon">

            <i class="mdi mdi-recycle"></i>

        </div>


        <!-- TITLE -->
        <h3 id="restoreModalTitle">
            Restore User?
        </h3>


        <!-- MESSAGE -->
        <p>

            Do you want to restore

            <strong id="restoreUserName">
                this user
            </strong>?

        </p>


        <!-- ACTION BUTTONS -->
        <div class="restore-modal-actions">

            <button
                type="button"
                class="restore-modal-cancel"
                onclick="closeRestoreModal()"
            >
                Cancel
            </button>


            <button
                type="button"
                class="restore-modal-confirm"
                id="confirmRestoreBtn"
            >

                <i class="mdi mdi-restore"></i>

                Yes, Restore

            </button>

        </div>

    </div>

</div>



<!-- =========================================================
     DELETE MODAL CSS
========================================================= -->

<style>

/* ---------------------------------------------------------
   DELETE BUTTON
--------------------------------------------------------- */

.delete-user-btn {
    color: #dc2626;
}

.delete-user-btn:hover {
    color: #b91c1c;
}


/* ---------------------------------------------------------
   RECYCLE / RESTORE BUTTON
--------------------------------------------------------- */

.recycle-user-btn {
    color: #16a34a;
}

.recycle-user-btn:hover {
    color: #15803d;
}


/* ---------------------------------------------------------
   DELETE MODAL OVERLAY
--------------------------------------------------------- */

.delete-modal-overlay {

    position: fixed;

    inset: 0;

    z-index: 99999;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 20px;

    background: rgba(15, 23, 42, 0.68);

    backdrop-filter: blur(7px);

    -webkit-backdrop-filter: blur(7px);

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transition:
        opacity 0.25s ease,
        visibility 0.25s ease;

}


/* SHOW DELETE MODAL */

.delete-modal-overlay.show {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

}


/* ---------------------------------------------------------
   DELETE MODAL BOX
--------------------------------------------------------- */

.delete-modal-box {

    position: relative;

    width: 100%;

    max-width: 440px;

    padding: 38px 32px 30px;

    background: #ffffff;

    border-radius: 22px;

    text-align: center;

    box-shadow:

        0 30px 80px rgba(15, 23, 42, 0.30),

        0 10px 30px rgba(15, 23, 42, 0.15);

    transform: translateY(25px) scale(0.94);

    transition:

        transform 0.3s cubic-bezier(.2,.8,.2,1),

        opacity 0.3s ease;

    opacity: 0;

}


/* DELETE MODAL ANIMATION */

.delete-modal-overlay.show .delete-modal-box {

    transform: translateY(0) scale(1);

    opacity: 1;

}


/* ---------------------------------------------------------
   DELETE CLOSE BUTTON
--------------------------------------------------------- */

.delete-modal-close {

    position: absolute;

    top: 15px;

    right: 17px;

    width: 36px;

    height: 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    border: none;

    border-radius: 50%;

    background: #f8fafc;

    color: #64748b;

    font-size: 26px;

    line-height: 1;

    cursor: pointer;

    transition: all 0.2s ease;

}


.delete-modal-close:hover {

    background: #fee2e2;

    color: #dc2626;

    transform: rotate(90deg);

}


/* ---------------------------------------------------------
   DELETE ICON
--------------------------------------------------------- */

.delete-modal-icon {

    width: 82px;

    height: 82px;

    margin: 0 auto 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #fff1f2;

    border: 8px solid #ffe4e6;

    color: #dc2626;

    font-size: 34px;

    box-shadow:

        0 10px 25px rgba(220, 38, 38, 0.12);

}


/* ---------------------------------------------------------
   DELETE TITLE
--------------------------------------------------------- */

.delete-modal-box h3 {

    margin: 0 0 10px;

    color: #1e293b;

    font-size: 25px;

    font-weight: 700;

    letter-spacing: -0.3px;

}


/* ---------------------------------------------------------
   DELETE MESSAGE
--------------------------------------------------------- */

.delete-modal-box p {

    margin: 0 auto 20px;

    max-width: 350px;

    color: #64748b;

    font-size: 15px;

    line-height: 1.65;

}


.delete-modal-box p strong {

    color: #334155;

    font-weight: 700;

}


/* ---------------------------------------------------------
   DELETE ACTION BUTTONS
--------------------------------------------------------- */

.delete-modal-actions {

    display: flex;

    gap: 12px;

    width: 100%;

}


.delete-modal-cancel,
.delete-modal-confirm {

    flex: 1;

    min-height: 48px;

    padding: 0 18px;

    border-radius: 11px;

    font-size: 14px;

    font-weight: 600;

    cursor: pointer;

    transition: all 0.2s ease;

}


/* DELETE CANCEL */

.delete-modal-cancel {

    border: 1px solid #e2e8f0;

    background: #ffffff;

    color: #475569;

}


.delete-modal-cancel:hover {

    background: #f8fafc;

    border-color: #cbd5e1;

    color: #1e293b;

}


/* DELETE CONFIRM */

.delete-modal-confirm {

    border: 1px solid #dc2626;

    background: #dc2626;

    color: #ffffff;

    box-shadow:

        0 6px 16px rgba(220, 38, 38, 0.20);

}


.delete-modal-confirm:hover {

    background: #b91c1c;

    border-color: #b91c1c;

    transform: translateY(-1px);

    box-shadow:

        0 8px 20px rgba(220, 38, 38, 0.28);

}


.delete-modal-confirm:active {

    transform: translateY(0);

}


.delete-modal-confirm i {

    margin-right: 5px;

}


/* =========================================================
   RESTORE MODAL
========================================================= */


/* ---------------------------------------------------------
   RESTORE MODAL OVERLAY
--------------------------------------------------------- */

.restore-modal-overlay {

    position: fixed;

    inset: 0;

    z-index: 99999;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 20px;

    background: rgba(15, 23, 42, 0.62);

    backdrop-filter: blur(7px);

    -webkit-backdrop-filter: blur(7px);

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transition:
        opacity 0.25s ease,
        visibility 0.25s ease;

}


/* SHOW RESTORE MODAL */

.restore-modal-overlay.show {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

}


/* ---------------------------------------------------------
   RESTORE MODAL BOX
--------------------------------------------------------- */

.restore-modal-box {

    position: relative;

    width: 100%;

    max-width: 440px;

    padding: 38px 32px 30px;

    background: #ffffff;

    border-radius: 22px;

    text-align: center;

    box-shadow:

        0 30px 80px rgba(15, 23, 42, 0.25),

        0 10px 30px rgba(15, 23, 42, 0.12);

    transform: translateY(25px) scale(0.94);

    transition:

        transform 0.3s cubic-bezier(.2,.8,.2,1),

        opacity 0.3s ease;

    opacity: 0;

}


/* RESTORE MODAL ANIMATION */

.restore-modal-overlay.show .restore-modal-box {

    transform: translateY(0) scale(1);

    opacity: 1;

}


/* ---------------------------------------------------------
   RESTORE CLOSE BUTTON
--------------------------------------------------------- */

.restore-modal-close {

    position: absolute;

    top: 15px;

    right: 17px;

    width: 36px;

    height: 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    border: none;

    border-radius: 50%;

    background: #f0fdf4;

    color: #64748b;

    font-size: 26px;

    line-height: 1;

    cursor: pointer;

    transition: all 0.2s ease;

}


.restore-modal-close:hover {

    background: #dcfce7;

    color: #16a34a;

    transform: rotate(90deg);

}


/* ---------------------------------------------------------
   RESTORE ICON
--------------------------------------------------------- */

.restore-modal-icon {

    width: 82px;

    height: 82px;

    margin: 0 auto 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #f0fdf4;

    border: 8px solid #dcfce7;

    color: #16a34a;

    font-size: 34px;

    box-shadow:

        0 10px 25px rgba(22, 163, 74, 0.14);

}


/* ---------------------------------------------------------
   RESTORE TITLE
--------------------------------------------------------- */

.restore-modal-box h3 {

    margin: 0 0 10px;

    color: #14532d;

    font-size: 25px;

    font-weight: 700;

    letter-spacing: -0.3px;

}


/* ---------------------------------------------------------
   RESTORE MESSAGE
--------------------------------------------------------- */

.restore-modal-box p {

    margin: 0 auto 20px;

    max-width: 350px;

    color: #64748b;

    font-size: 15px;

    line-height: 1.65;

}


.restore-modal-box p strong {

    color: #166534;

    font-weight: 700;

}


/* ---------------------------------------------------------
   RESTORE ACTION BUTTONS
--------------------------------------------------------- */

.restore-modal-actions {

    display: flex;

    gap: 12px;

    width: 100%;

}


.restore-modal-cancel,
.restore-modal-confirm {

    flex: 1;

    min-height: 48px;

    padding: 0 18px;

    border-radius: 11px;

    font-size: 14px;

    font-weight: 600;

    cursor: pointer;

    transition: all 0.2s ease;

}


/* RESTORE CANCEL */

.restore-modal-cancel {

    border: 1px solid #e2e8f0;

    background: #ffffff;

    color: #475569;

}


.restore-modal-cancel:hover {

    background: #f8fafc;

    border-color: #cbd5e1;

    color: #1e293b;

}


/* RESTORE CONFIRM */

.restore-modal-confirm {

    border: 1px solid #16a34a;

    background: #16a34a;

    color: #ffffff;

    box-shadow:

        0 6px 16px rgba(22, 163, 74, 0.20);

}


.restore-modal-confirm:hover {

    background: #15803d;

    border-color: #15803d;

    transform: translateY(-1px);

    box-shadow:

        0 8px 20px rgba(22, 163, 74, 0.28);

}


.restore-modal-confirm:active {

    transform: translateY(0);

}


.restore-modal-confirm i {

    margin-right: 5px;

}


/* ---------------------------------------------------------
   MOBILE
--------------------------------------------------------- */

@media (max-width: 480px) {

    .delete-modal-box,
    .restore-modal-box {

        max-width: 100%;

        padding: 35px 20px 24px;

        border-radius: 18px;

    }


    .delete-modal-icon,
    .restore-modal-icon {

        width: 72px;

        height: 72px;

        font-size: 30px;

    }


    .delete-modal-box h3,
    .restore-modal-box h3 {

        font-size: 22px;

    }


    .delete-modal-actions,
    .restore-modal-actions {

        flex-direction: column-reverse;

    }


    .delete-modal-cancel,
    .delete-modal-confirm,
    .restore-modal-cancel,
    .restore-modal-confirm {

        width: 100%;

        flex: none;

    }

}

</style>



<!-- =========================================================
     DELETE & RESTORE JAVASCRIPT
========================================================= -->

<script>

let deleteUserSn = null;

let deleteTableName = null;

let restoreUserSn = null;

let restoreTableName = null;


/*
|--------------------------------------------------------------------------
| SHOW DELETE MODAL
|--------------------------------------------------------------------------
*/

function showDeleteModal(userSn, userName, tableName) {

    deleteUserSn = userSn;

    deleteTableName = tableName;

    const modal = document.getElementById('deleteModal');

    const userNameElement = document.getElementById('deleteUserName');

    userNameElement.textContent = userName;

    modal.classList.add('show');

    modal.setAttribute('aria-hidden', 'false');

    document.body.style.overflow = 'hidden';

}


/*
|--------------------------------------------------------------------------
| CLOSE DELETE MODAL
|--------------------------------------------------------------------------
*/

function closeDeleteModal() {

    const modal = document.getElementById('deleteModal');

    modal.classList.remove('show');

    modal.setAttribute('aria-hidden', 'true');

    document.body.style.overflow = '';

    deleteUserSn = null;

    deleteTableName = null;

}


/*
|--------------------------------------------------------------------------
| CONFIRM DELETE
|--------------------------------------------------------------------------
*/

document
    .getElementById('confirmDeleteBtn')
    .addEventListener('click', function () {

        if (!deleteUserSn || !deleteTableName) {
            return;
        }


        window.location.href =
            'index?action=delete_user' +
            '&sn=' + encodeURIComponent(deleteUserSn) +
            '&table_name=' + encodeURIComponent(deleteTableName);

    });


/*
|--------------------------------------------------------------------------
| SHOW RESTORE MODAL
|--------------------------------------------------------------------------
*/

function showRestoreModal(userSn, userName, tableName) {

    restoreUserSn = userSn;

    restoreTableName = tableName;

    const modal = document.getElementById('restoreModal');

    const userNameElement = document.getElementById('restoreUserName');

    userNameElement.textContent = userName;

    modal.classList.add('show');

    modal.setAttribute('aria-hidden', 'false');

    document.body.style.overflow = 'hidden';

}


/*
|--------------------------------------------------------------------------
| CLOSE RESTORE MODAL
|--------------------------------------------------------------------------
*/

function closeRestoreModal() {

    const modal = document.getElementById('restoreModal');

    modal.classList.remove('show');

    modal.setAttribute('aria-hidden', 'true');

    document.body.style.overflow = '';

    restoreUserSn = null;

    restoreTableName = null;

}


/*
|--------------------------------------------------------------------------
| CONFIRM RESTORE
|--------------------------------------------------------------------------
*/

document
    .getElementById('confirmRestoreBtn')
    .addEventListener('click', function () {

        if (!restoreUserSn || !restoreTableName) {
            return;
        }


        /*
         * RESTORE passes:
         * sn
         * table_name
         */

        window.location.href =
            'index?action=restore_user' +
            '&sn=' + encodeURIComponent(restoreUserSn) +
            '&table_name=' + encodeURIComponent(restoreTableName);

    });


/*
|--------------------------------------------------------------------------
| CLOSE DELETE MODAL WHEN CLICKING OUTSIDE
|--------------------------------------------------------------------------
*/

document
    .getElementById('deleteModal')
    .addEventListener('click', function (event) {

        if (event.target === this) {

            closeDeleteModal();

        }

    });


/*
|--------------------------------------------------------------------------
| CLOSE RESTORE MODAL WHEN CLICKING OUTSIDE
|--------------------------------------------------------------------------
*/

document
    .getElementById('restoreModal')
    .addEventListener('click', function (event) {

        if (event.target === this) {

            closeRestoreModal();

        }

    });


/*
|--------------------------------------------------------------------------
| CLOSE MODALS WITH ESC KEY
|--------------------------------------------------------------------------
*/

document.addEventListener('keydown', function (event) {

    if (event.key === 'Escape') {

        if (
            document
                .getElementById('deleteModal')
                .classList.contains('show')
        ) {

            closeDeleteModal();

        }


        if (
            document
                .getElementById('restoreModal')
                .classList.contains('show')
        ) {

            closeRestoreModal();

        }

    }

});

</script>
