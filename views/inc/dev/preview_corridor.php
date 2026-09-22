<?php

$Ltable_name = $tb_name;

$Ltable_sn = $corridor_sn = 0;

?>

<div class="row">

    <div class="col-12 grid-margin stretch-card">

        <div class="card">

            <div class="card-body">

                <div class="d-flex flex-row justify-content-between align-items-center dashboard-table-heading">

                    <div>

                        <h4 class="card-title mb-1">
                           <?= $page_name  ?>
                        </h4>

                        <p class="text-muted mb-0">
                            Overview of system <?= $page_name  ?>
                        </p>

                    </div>

                    <button
                        type="button"
                        class="btn btn-primary"
                        onclick="showCreateCorridorModal()"
                    >
                        Create new <?= $page_name  ?>
                    </button>

                </div>

                <div class="dashboard-datatable-wrapper mt-4">

                    <table
                        class="dashboard-datatable"
                        id="corridorDataTable"
                        style="width:100%;"
                    >

                        <thead>

                            <tr>

                                <th>S/N</th>

                                <th>Created By</th>

                                <th>Date Created</th>

                                <th><?= $page_name  ?> Name</th>

                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php

                            if (
                                !empty($LoadCorridorsAndItLikes) &&
                                is_array($LoadCorridorsAndItLikes)
                            ) {

                                $sn = 1;

                                foreach (
                                    $LoadCorridorsAndItLikes
                                    as $corridor
                                ) {

                                    $corridor_sn =
                                        $corridor['sn'] ?? 0;

                                    $corridor_name =
                                        $corridor['name'] ?? 'N/A';

                                    $creator_role =
                                        $corridor['creator_role'] ?? '';

                                    $created_by =
                                        $corridor['creator_name'] ?? 'N/A';

                                    if (
                                        $creator_role !== ''
                                    ) {

                                        $created_by .=
                                            " (" .
                                            $creator_role .
                                            ")";

                                    }

                                    $date_created =
                                        $corridor['date_created'] ?? '';

                                    $token_table_name =
                                        base64_encode(
                                            $Ltable_name
                                        );

                                    $token_corridor_sn =
                                        base64_encode(
                                            (string)$corridor_sn
                                        );

                            ?>

                                    <tr>

                                        <td>
                                            <?= $sn++; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                ucfirst(
                                                    $created_by
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>

                                            <?php

                                            if (
                                                !empty(
                                                    $date_created
                                                )
                                            ) {

                                                $timestamp =
                                                    strtotime(
                                                        $date_created
                                                    );

                                                echo $timestamp !== false
                                                    ? date(
                                                        'd M Y, h:i A',
                                                        $timestamp
                                                    )
                                                    : 'N/A';

                                            } else {

                                                echo 'N/A';

                                            }

                                            ?>

                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                ucfirst(
                                                    $corridor_name
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        </td>

                                        <td>

                                            <button
                                                type="button"
                                                class="dashboard-table-action delete-corridor-btn"
                                                title="Delete"
                                                onclick="showDeleteModal(
                                                    '<?= htmlspecialchars(
                                                        $token_corridor_sn,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>',
                                                    '<?= htmlspecialchars(
                                                        $corridor_name,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>',
                                                    '<?= htmlspecialchars(
                                                        $token_table_name,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>'
                                                )"
                                            >

                                                <i class="mdi mdi-delete"></i>

                                            </button>

                                        </td>

                                    </tr>

                            <?php

                                }

                            }

                            ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     CREATE CORRIDOR MODAL
========================================================= -->

<div
    id="createCorridorModal"
    class="create-corridor-modal-overlay"
    aria-hidden="true"
>

    <div
        class="create-corridor-modal-box"
        role="dialog"
        aria-modal="true"
        aria-labelledby="createCorridorModalTitle"
    >

        <button
            type="button"
            class="create-corridor-modal-close"
            onclick="closeCreateCorridorModal()"
            aria-label="Close"
        >
            &times;
        </button>

        <h3 id="createCorridorModalTitle">
            Create New <?= $page_name  ?>
        </h3>

        <form
            method="POST"
            enctype="multipart/form-data"
            action="index.php?action=create_corridor"
        >

            <div class="create-corridor-form-group">

                <label for="corridor_name">
                    <?= $page_name  ?> Name
                </label>

<input type="hidden" name="tb" required value="<?= $tb_name ?>">


                <input
                    type="text"
                    class="create-corridor-input"
                    id="corridor_name"
                    name="corridor_name"
                    placeholder="Enter <?= $page_name  ?> name"
                    required
                >

            </div>

            <button
                type="submit"
                name="create_corridor"
                class="create-corridor-create-btn"
            >
                Create
            </button>

        </form>

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

        <button
            type="button"
            class="delete-modal-close"
            onclick="closeDeleteModal()"
            aria-label="Close"
        >
            &times;
        </button>

        <div class="delete-modal-icon">

            <i class="mdi mdi-delete-alert-outline"></i>

        </div>

        <h3 id="deleteModalTitle">
            Are you sure?
        </h3>

        <p>
            Do you truly want to delete
            <strong id="deleteUserName">
                this corridor
            </strong>?
        </p>

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
     CSS
========================================================= -->

<style>

.create-corridor-modal-overlay {

    position: fixed;

    inset: 0;

    z-index: 99998;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 20px;

    background: rgba(15, 23, 42, 0.72);

    backdrop-filter: blur(7px);

    -webkit-backdrop-filter: blur(7px);

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transition:
        opacity 0.25s ease,
        visibility 0.25s ease;

}

.create-corridor-modal-overlay.show {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

}

.create-corridor-modal-box {

    position: relative;

    width: 100%;

    max-width: 440px;

    padding: 32px;

    background: #1e293b;

    border: 1px solid #334155;

    border-radius: 18px;

    box-shadow:
        0 30px 80px rgba(0, 0, 0, 0.45),
        0 10px 30px rgba(0, 0, 0, 0.25);

    transform: translateY(25px) scale(0.94);

    transition:
        transform 0.3s cubic-bezier(.2,.8,.2,1),
        opacity 0.3s ease;

    opacity: 0;

}

.create-corridor-modal-overlay.show
.create-corridor-modal-box {

    transform: translateY(0) scale(1);

    opacity: 1;

}

.create-corridor-modal-close {

    position: absolute;

    top: 13px;

    right: 15px;

    width: 36px;

    height: 36px;

    display: flex;

    align-items: center;

    justify-content: center;

    border: none;

    border-radius: 50%;

    background: #334155;

    color: #cbd5e1;

    font-size: 26px;

    line-height: 1;

    cursor: pointer;

    transition: all 0.2s ease;

}

.create-corridor-modal-close:hover {

    background: #475569;

    color: #ffffff;

    transform: rotate(90deg);

}

.create-corridor-modal-box h3 {

    margin: 0 0 25px;

    color: #ffffff;

    font-size: 22px;

    font-weight: 700;

}

.create-corridor-form-group {

    margin-bottom: 22px;

}

.create-corridor-form-group label {

    display: block;

    margin-bottom: 9px;

    color: #cbd5e1;

    font-size: 14px;

    font-weight: 600;

}

.create-corridor-input {

    width: 100%;

    min-height: 48px;

    padding: 0 14px;

    border: 1px solid #475569;

    border-radius: 10px;

    outline: none;

    background: #0f172a;

    color: #ffffff;

    font-size: 14px;

    box-sizing: border-box;

}

.create-corridor-input::placeholder {

    color: #64748b;

}

.create-corridor-input:focus {

    border-color: #3b82f6;

    box-shadow:
        0 0 0 3px rgba(59, 130, 246, 0.15);

}

.create-corridor-create-btn {

    width: 100%;

    min-height: 48px;

    border: 1px solid #3b82f6;

    border-radius: 10px;

    background: #3b82f6;

    color: #ffffff;

    font-size: 14px;

    font-weight: 600;

    cursor: pointer;

}

.create-corridor-create-btn:hover {

    background: #2563eb;

    border-color: #2563eb;

}

.delete-corridor-btn {

    color: #dc2626;

}

.delete-corridor-btn:hover {

    color: #b91c1c;

}

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

.delete-modal-overlay.show {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

}

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

.delete-modal-overlay.show .delete-modal-box {

    transform: translateY(0) scale(1);

    opacity: 1;

}

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

}

.delete-modal-close:hover {

    background: #fee2e2;

    color: #dc2626;

    transform: rotate(90deg);

}

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

}

.delete-modal-box h3 {

    margin: 0 0 10px;

    color: #1e293b;

    font-size: 25px;

    font-weight: 700;

}

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

}

.delete-modal-cancel {

    border: 1px solid #e2e8f0;

    background: #ffffff;

    color: #475569;

}

.delete-modal-cancel:hover {

    background: #f8fafc;

    border-color: #cbd5e1;

}

.delete-modal-confirm {

    border: 1px solid #dc2626;

    background: #dc2626;

    color: #ffffff;

}

.delete-modal-confirm:hover {

    background: #b91c1c;

    border-color: #b91c1c;

}

.delete-modal-confirm i {

    margin-right: 5px;

}

@media (max-width: 480px) {

    .create-corridor-modal-box {

        max-width: 100%;

        padding: 28px 20px 24px;

    }

    .delete-modal-box {

        max-width: 100%;

        padding: 35px 20px 24px;

    }

    .delete-modal-actions {

        flex-direction: column-reverse;

    }

    .delete-modal-cancel,
    .delete-modal-confirm {

        width: 100%;

        flex: none;

    }

}

</style>


<!-- =========================================================
     CREATE CORRIDOR JAVASCRIPT
========================================================= -->

<script>

function showCreateCorridorModal() {

    const modal =
        document.getElementById(
            'createCorridorModal'
        );

    if (!modal) {
        return;
    }

    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.style.overflow =
        'hidden';

    const input =
        document.getElementById(
            'corridor_name'
        );

    if (input) {

        setTimeout(
            function () {

                input.focus();

            },
            100
        );

    }

}

function closeCreateCorridorModal() {

    const modal =
        document.getElementById(
            'createCorridorModal'
        );

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.style.overflow =
        '';

}

const createCorridorModal =
    document.getElementById(
        'createCorridorModal'
    );

if (createCorridorModal) {

    createCorridorModal.addEventListener(
        'click',
        function (event) {

            if (event.target === this) {

                closeCreateCorridorModal();

            }

        }
    );

}

</script>


<!-- =========================================================
     DELETE JAVASCRIPT
========================================================= -->

<script>

let deleteUserSn = null;

let deleteTableName = null;

function showDeleteModal(
    userSn,
    userName,
    tableName
) {

    deleteUserSn = userSn;

    deleteTableName = tableName;

    const modal =
        document.getElementById(
            'deleteModal'
        );

    const userNameElement =
        document.getElementById(
            'deleteUserName'
        );

    if (!modal) {
        return;
    }

    if (userNameElement) {

        userNameElement.textContent =
            userName;

    }

    modal.classList.add('show');

    modal.setAttribute(
        'aria-hidden',
        'false'
    );

    document.body.style.overflow =
        'hidden';

}

function closeDeleteModal() {

    const modal =
        document.getElementById(
            'deleteModal'
        );

    if (!modal) {
        return;
    }

    modal.classList.remove('show');

    modal.setAttribute(
        'aria-hidden',
        'true'
    );

    document.body.style.overflow =
        '';

    deleteUserSn = null;

    deleteTableName = null;

}

const confirmDeleteBtn =
    document.getElementById(
        'confirmDeleteBtn'
    );

if (confirmDeleteBtn) {

    confirmDeleteBtn.addEventListener(
        'click',
        function () {

            if (
                !deleteUserSn ||
                !deleteTableName
            ) {

                return;

            }

            window.location.href =
                'index.php?action=Er' +
                '&sn=' +
                encodeURIComponent(
                    deleteUserSn
                ) +
                '&tb=' +
                encodeURIComponent(
                    deleteTableName
                );

        }
    );

}

const deleteModal =
    document.getElementById(
        'deleteModal'
    );

if (deleteModal) {

    deleteModal.addEventListener(
        'click',
        function (event) {

            if (event.target === this) {

                closeDeleteModal();

            }

        }
    );

}

document.addEventListener(
    'keydown',
    function (event) {

        if (event.key !== 'Escape') {

            return;

        }

        const createModal =
            document.getElementById(
                'createCorridorModal'
            );

        const deleteModalElement =
            document.getElementById(
                'deleteModal'
            );

        if (
            createModal &&
            createModal.classList.contains(
                'show'
            )
        ) {

            closeCreateCorridorModal();

            return;

        }

        if (
            deleteModalElement &&
            deleteModalElement.classList.contains(
                'show'
            )
        ) {

            closeDeleteModal();

        }

    }
);

</script>