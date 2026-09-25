<?php

$table_name = "request";
$totalrequest_sn = 0;

/*
|--------------------------------------------------------------------------
| DEFAULT VALUES
|--------------------------------------------------------------------------
| Prevent undefined variable warnings when the request table is empty.
|--------------------------------------------------------------------------
*/

$ticket_no = '';
$ticketer_email = '';
$ticketer_name = '';
$ticket_status = '';

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
                    Recent Requests
                </h4>

                <p class="text-muted mb-0">
                    Overview of recent user complaints and requests
                </p>

            </div>

            <?php if ($page_name == "dashboard") : ?>

                <a
                    href="index?action=totalrequests"
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
                        <th>Ticket ID</th>
                        <th>Complaint</th>
                        <th>Role</th>
                        <th>Subject / Complain</th>
                        <th>Priority</th>
                        <th>Date & Time</th>
                        <th>Status</th>
                        <th>Action</th>

                    </tr>

                </thead>


                <tbody>

                    <?php if (
                        !empty($LoadUsersAndRequestTable)
                        && is_array($LoadUsersAndRequestTable)
                    ): ?>

                        <?php $sn = 1; ?>

                        <?php foreach ($LoadUsersAndRequestTable as $totalrequest): ?>

                            <?php

                            $ticket_sn = $totalrequest['ticket_sn'] ?? 0;
                            $ticket_no = $totalrequest['ticket_no'] ?? 0;

                            $totalrequest_sn = $ticket_sn;

                            $ticketer_name =
                                $totalrequest['user_fullname'] ?? 'N/A';

                            $ticketer_email =
                                $totalrequest['user_email'] ?? 'N/A';

                            $ticketer_role =
                                $totalrequest['ticket_category'] ?? 'N/A';

                            $ticket_subject =
                                $totalrequest['ticket_subject'] ?? 'N/A';

                            $ticket_complain =
                                $totalrequest['ticket_complain'] ?? 'N/A';

                            $ticket_priority =
                                $totalrequest['ticket_priority'] ?? 'N/A';

                            $ticket_date =
                                $totalrequest['ticket_date'] ?? '';

                            $ticket_status =
                                $totalrequest['ticket_status'] ?? '';

                            ?>


                            <tr>

                                <!-- S/N -->
                                <td>
                                    <?= $sn++; ?>
                                </td>


                                <!-- TICKET ID -->
                                <td>

                                    <strong>
                                        <?= htmlspecialchars(
                                            $ticket_no,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?>
                                    </strong>

                                </td>


                                <!-- USER -->
                                <td>

                                    <div class="dashboard-table-user">

                                        <div>

                                            <div class="dashboard-table-user-name">

                                                <?= ucfirst(
                                                    htmlspecialchars(
                                                        $ticketer_name,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    )
                                                ); ?>

                                            </div>

                                            <div class="dashboard-table-user-email">

                                                <?= htmlspecialchars(
                                                    $ticketer_email,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>

                                            </div>

                                        </div>

                                    </div>

                                </td>


                                <!-- CATEGORY -->
                                <td>

                                    <span class="dashboard-role">

                                        <?= ucfirst(
                                            htmlspecialchars(
                                                $ticketer_role,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                        ); ?>

                                    </span>

                                </td>


                                <!-- SUBJECT / COMPLAINT -->
                                <td>

                                    <button
                                        type="button"
                                        class="dashboard-subject-btn"
                                        onclick="showComplaintModal(
                                            <?= htmlspecialchars(
                                                json_encode(
                                                    $ticket_subject
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>,
                                            <?= htmlspecialchars(
                                                json_encode(
                                                    $ticket_complain
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>
                                        )"
                                    >

                                        <?= ucfirst(
                                            htmlspecialchars(
                                                $ticket_subject,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            )
                                        ); ?>

                                    </button>

                                </td>


                                <!-- PRIORITY -->
                                <td>

                                    <?php if (
                                        (int)$ticket_priority === 2
                                    ): ?>

                                        <!-- HIGH = RED -->

                                        <span
                                            class="dashboard-status dashboard-status-danger"
                                            style="
                                                background-color: #fee2e2;
                                                color: #dc2626;
                                                border: 1px solid #fecaca;
                                            "
                                        >
                                            High
                                        </span>

                                    <?php elseif (
                                        (int)$ticket_priority === 1
                                    ): ?>

                                        <!-- MEDIUM = ORANGE/YELLOW -->

                                        <span
                                            class="dashboard-status dashboard-status-pending"
                                            style="
                                                background-color: #fef3c7;
                                                color: #d97706;
                                                border: 1px solid #fde68a;
                                            "
                                        >
                                            Medium
                                        </span>

                                    <?php else: ?>

                                        <!-- LOW = GREEN -->

                                        <span
                                            class="dashboard-status dashboard-status-active"
                                            style="
                                                background-color: #dcfce7;
                                                color: #16a34a;
                                                border: 1px solid #bbf7d0;
                                            "
                                        >
                                            Low
                                        </span>

                                    <?php endif; ?>

                                </td>


                                <!-- DATE -->
                                <td>

                                    <?= !empty($ticket_date)
                                        ? date(
                                            'd M Y, h:i A',
                                            strtotime($ticket_date)
                                        )
                                        : 'N/A';
                                    ?>

                                </td>


                                <!-- STATUS -->
                                <td>

                                    <?php if ($ticket_status == 0): ?>

                                        <span
                                            class="dashboard-status dashboard-status-pending"
                                        >
                                            New
                                        </span>

                                    <?php elseif ($ticket_status == 1): ?>

                                        <span
                                            class="dashboard-status dashboard-status-active"
                                        >
                                            Opened
                                        </span>

                                    <?php elseif ($ticket_status == 2): ?>

                                        <span
                                            class="dashboard-status dashboard-status-pending"
                                        >
                                            In Progress
                                        </span>

                                    <?php elseif ($ticket_status == 3): ?>

                                        <span
                                            class="dashboard-status dashboard-status-active"
                                        >
                                            Replied
                                        </span>

                                    <?php elseif ($ticket_status == 4): ?>

                                        <span
                                            class="dashboard-status dashboard-status-active"
                                        >
                                            Resolved
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

                                    <!-- <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="View Request"
                                        onclick="window.location.href='index?action=view_totalrequest&sn=<?= urlencode($totalrequest_sn); ?>&table_name=<?= urlencode($table_name); ?>'"
                                    >
                                        <i class="mdi mdi-eye"></i>
                                    </button> -->


                                    <?php if ($ticket_status == -1): ?>

                                        <!-- RESTORE BUTTON -->

                                        <!-- <button
                                            type="button"
                                            class="dashboard-table-action recycle-totalrequest-btn"
                                            title="Restore"
                                            onclick="showRestoreModal(
                                                '<?= htmlspecialchars(
                                                    $totalrequest_sn,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>',
                                                '<?= htmlspecialchars(
                                                    $ticket_no,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>',
                                                '<?= htmlspecialchars(
                                                    $table_name,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>'
                                            )"
                                        >

                                            <i class="mdi mdi-recycle"></i>

                                        </button> -->

                                    <?php else: ?>

                                        <!-- REPLY BUTTON -->

                                        <?php if ($ticket_status != 4): ?>

                                            <button
                                                type="button"
                                                class="dashboard-table-action"
                                                title="Reply"
                                                onclick="showReplyModal(
                                                    '<?= htmlspecialchars(
                                                        $totalrequest_sn,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>',
                                                    <?= htmlspecialchars(
                                                        json_encode(
                                                            $ticket_subject
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>,
                                                    '<?= htmlspecialchars(
                                                        $ticket_status,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ); ?>'
                                                )"
                                            >

                                                <i class="mdi mdi-reply"></i>

                                            </button>

                                        <?php endif; ?>


                                        <!-- DELETE BUTTON -->

                                        <!-- <button
                                            type="button"
                                            class="dashboard-table-action delete-totalrequest-btn"
                                            title="Delete"
                                            onclick="showDeleteModal(
                                                '<?= htmlspecialchars(
                                                    $totalrequest_sn,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>',
                                                '<?= htmlspecialchars(
                                                    $ticket_no,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>',
                                                '<?= htmlspecialchars(
                                                    $table_name,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>'
                                            )"
                                        >

                                            <i class="mdi mdi-delete"></i>

                                        </button> -->

                                    <?php endif; ?>

                                </td>

                            </tr>

                        <?php endforeach; ?>


                    <?php else: ?>

                        <!-- EMPTY TABLE STATE -->

                        <tr>

                            <td
                                colspan="9"
                                class="text-center"
                            >
                                No requests or complaints found.
                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>
```

</div>

</div>

<!-- =========================================================
     COMPLAINT READING MODAL
========================================================= -->

<div
    id="complaintModal"
    class="complaint-modal-overlay"
    aria-hidden="true"
>

<div
    class="complaint-modal-box"
    role="dialog"
    aria-modal="true"
    aria-labelledby="complaintModalTitle"
>

```
<button
    type="button"
    class="complaint-modal-close"
    onclick="closeComplaintModal()"
    aria-label="Close"
>
    &times;
</button>


<div class="complaint-modal-header">

    <div class="complaint-modal-icon">

        <i class="mdi mdi-text-box-outline"></i>

    </div>

    <div>

        <span class="complaint-modal-label">
            Ticket Subject
        </span>

        <h3 id="complaintModalTitle">
            Subject
        </h3>

    </div>

</div>


<div class="complaint-modal-content">

    <div class="complaint-modal-content-label">
        Complaint / Request
    </div>

    <div
        id="complaintModalBody"
        class="complaint-modal-body"
    >
        Complaint details
    </div>

</div>


<div class="complaint-modal-footer">

    <button
        type="button"
        class="complaint-modal-close-btn"
        onclick="closeComplaintModal()"
    >
        Close
    </button>

</div>
```

</div>

</div>

<!-- =========================================================
     REPLY / UPDATE MODAL
========================================================= -->

<div
    id="replyModal"
    class="reply-modal-overlay"
    aria-hidden="true"
>

<div
    class="reply-modal-box"
    role="dialog"
    aria-modal="true"
    aria-labelledby="replyModalTitle"
>

```
<button
    type="button"
    class="reply-modal-close"
    onclick="closeReplyModal()"
    aria-label="Close"
>
    &times;
</button>


<div class="reply-modal-icon">

    <i class="mdi mdi-reply"></i>

</div>


<h3 id="replyModalTitle">
    Update Request
</h3>


<form
    method="POST"
    enctype="multipart/form-data"
    action="index.php?action=totalrequest"
>

    <input
        type="hidden"
        name="sn"
        id="replyTicketSn"
        value="<?= htmlspecialchars(
            $totalrequest_sn,
            ENT_QUOTES,
            'UTF-8'
        ); ?>"
    >

    <input
        type="hidden"
        name="ticketer_email"
        id="replyTicketEmail"
        value="<?= htmlspecialchars(
            $ticketer_email,
            ENT_QUOTES,
            'UTF-8'
        ); ?>"
    >

    <input
        type="hidden"
        name="table_name"
        value="<?= htmlspecialchars(
            $table_name,
            ENT_QUOTES,
            'UTF-8'
        ); ?>"
    >

    <input
        type="hidden"
        name="ticket_no"
        value="<?= htmlspecialchars(
            $ticket_no,
            ENT_QUOTES,
            'UTF-8'
        ); ?>"
    >

    <input
        type="hidden"
        name="ticketer_name"
        value="<?= htmlspecialchars(
            $ticketer_name,
            ENT_QUOTES,
            'UTF-8'
        ); ?>"
    >

    <input
        type="hidden"
        name="ticket_status"
        value="<?= htmlspecialchars(
            $ticket_status,
            ENT_QUOTES,
            'UTF-8'
        ); ?>"
    >


    <div class="reply-form-group">

        <label for="replySubject">
            Subject
        </label>

        <div
            id="replySubject"
            class="reply-subject-display"
        >
            Subject
        </div>

    </div>


    <div class="reply-form-group">

        <label for="replyStatus">
            Change Status
        </label>

        <select
            name="status"
            id="replyStatus"
            class="reply-form-control"
            required
            style="
                background-color: #ffffff !important;
                color: #334155 !important;
                border-color: #e2e8f0 !important;
                color-scheme: light;
            "
        >

            <option value="0">
                New
            </option>

            <option value="1">
                Opened
            </option>

            <option value="2">
                In Progress
            </option>

            <option value="3">
                Replied
            </option>

            <option value="4">
                Resolved
            </option>

        </select>

    </div>


    <div class="reply-modal-actions">

        <button
            type="button"
            class="reply-modal-cancel"
            onclick="closeReplyModal()"
        >
            Cancel
        </button>


        <button
            type="submit"
            name="requestreply"
            class="reply-modal-submit"
        >

            <i class="mdi mdi-send"></i>

            Post Update

        </button>

    </div>

</form>
```

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

```
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

    Are you sure you want to delete ticket

    <strong id="deleteUserName">
        this ticket
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
```

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

```
<button
    type="button"
    class="restore-modal-close"
    onclick="closeRestoreModal()"
    aria-label="Close"
>
    &times;
</button>


<div class="restore-modal-icon">

    <i class="mdi mdi-recycle"></i>

</div>


<h3 id="restoreModalTitle">
    Restore Request
</h3>


<p>

    Do you want to restore ticket

    <strong id="restoreUserName">
        this ticket
    </strong>?

</p>


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
```

</div>

</div>

<style>

/* ---------------------------------------------------------
   SUBJECT BUTTON
--------------------------------------------------------- */

.dashboard-subject-btn {

    padding: 0;

    border: none;

    background: transparent;

    color: #2563eb;

    font: inherit;

    font-weight: 500;

    text-align: left;

    cursor: pointer;

    transition: all 0.2s ease;

}

.dashboard-subject-btn:hover {

    color: #1d4ed8;

    text-decoration: underline;

}


/* =========================================================
   COMPLAINT MODAL
========================================================= */

.complaint-modal-overlay,
.reply-modal-overlay,
.delete-modal-overlay,
.restore-modal-overlay {

    position: fixed;

    inset: 0;

    display: flex;

    align-items: center;

    justify-content: center;

    padding: 20px;

    backdrop-filter: blur(7px);

    -webkit-backdrop-filter: blur(7px);

    opacity: 0;

    visibility: hidden;

    pointer-events: none;

    transition:
        opacity 0.25s ease,
        visibility 0.25s ease;

}

.complaint-modal-overlay {

    z-index: 99998;

    background: rgba(15, 23, 42, 0.68);

}

.reply-modal-overlay {

    z-index: 99999;

    background: rgba(15, 23, 42, 0.68);

}

.delete-modal-overlay {

    z-index: 100000;

    background: rgba(15, 23, 42, 0.68);

}

.restore-modal-overlay {

    z-index: 100000;

    background: rgba(15, 23, 42, 0.62);

}


.complaint-modal-overlay.show,
.reply-modal-overlay.show,
.delete-modal-overlay.show,
.restore-modal-overlay.show {

    opacity: 1;

    visibility: visible;

    pointer-events: auto;

}


/* =========================================================
   COMPLAINT MODAL BOX
========================================================= */

.complaint-modal-box {

    position: relative;

    width: 100%;

    max-width: 650px;

    max-height: 85vh;

    padding: 30px;

    background: #ffffff;

    border-radius: 22px;

    box-shadow:
        0 30px 80px rgba(15, 23, 42, 0.30),
        0 10px 30px rgba(15, 23, 42, 0.15);

    transform: translateY(25px) scale(0.94);

    transition:
        transform 0.3s cubic-bezier(.2,.8,.2,1),
        opacity 0.3s ease;

    opacity: 0;

    overflow: hidden;

}

.complaint-modal-overlay.show .complaint-modal-box {

    transform: translateY(0) scale(1);

    opacity: 1;

}


.complaint-modal-close {

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

.complaint-modal-close:hover {

    background: #eff6ff;

    color: #2563eb;

    transform: rotate(90deg);

}


.complaint-modal-header {

    display: flex;

    align-items: flex-start;

    gap: 15px;

    padding-right: 40px;

    margin-bottom: 24px;

}


.complaint-modal-icon {

    flex: 0 0 auto;

    width: 52px;

    height: 52px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 14px;

    background: #eff6ff;

    border: 1px solid #dbeafe;

    color: #2563eb;

    font-size: 25px;

}


.complaint-modal-label {

    display: block;

    margin-bottom: 4px;

    color: #94a3b8;

    font-size: 12px;

    font-weight: 700;

    text-transform: uppercase;

    letter-spacing: 0.7px;

}


.complaint-modal-header h3 {

    margin: 0;

    color: #1e293b;

    font-size: 21px;

    font-weight: 700;

    line-height: 1.4;

}


.complaint-modal-content {

    padding: 20px;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    border-radius: 15px;

}


.complaint-modal-content-label {

    margin-bottom: 10px;

    color: #475569;

    font-size: 13px;

    font-weight: 700;

}


.complaint-modal-body {

    max-height: 45vh;

    overflow-y: auto;

    color: #475569;

    font-size: 15px;

    line-height: 1.75;

    white-space: pre-wrap;

    word-break: break-word;

}


.complaint-modal-footer {

    display: flex;

    justify-content: flex-end;

    margin-top: 20px;

}


.complaint-modal-close-btn {

    min-height: 44px;

    padding: 0 22px;

    border: 1px solid #e2e8f0;

    border-radius: 10px;

    background: #ffffff;

    color: #475569;

    font-size: 14px;

    font-weight: 600;

    cursor: pointer;

}


/* =========================================================
   REPLY MODAL
========================================================= */

.reply-modal-box {

    position: relative;

    width: 100%;

    max-width: 520px;

    padding: 34px 30px 28px;

    background: #ffffff;

    border-radius: 22px;

    box-shadow:
        0 30px 80px rgba(15, 23, 42, 0.30),
        0 10px 30px rgba(15, 23, 42, 0.15);

    transform: translateY(25px) scale(0.94);

    transition:
        transform 0.3s cubic-bezier(.2,.8,.2,1),
        opacity 0.3s ease;

    opacity: 0;

}


.reply-modal-overlay.show .reply-modal-box {

    transform: translateY(0) scale(1);

    opacity: 1;

}


.reply-modal-close {

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


.reply-modal-close:hover {

    background: #eff6ff;

    color: #2563eb;

    transform: rotate(90deg);

}


.reply-modal-icon {

    width: 64px;

    height: 64px;

    margin: 0 auto 18px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    background: #eff6ff;

    border: 8px solid #dbeafe;

    color: #2563eb;

    font-size: 28px;

}


.reply-modal-box h3 {

    margin: 0 0 25px;

    color: #1e293b;

    font-size: 24px;

    font-weight: 700;

    text-align: center;

}


.reply-form-group {

    margin-bottom: 20px;

}


.reply-form-group label {

    display: block;

    margin-bottom: 8px;

    color: #334155;

    font-size: 14px;

    font-weight: 600;

}


.reply-subject-display {

    min-height: 48px;

    padding: 13px 15px;

    display: flex;

    align-items: center;

    background: #f8fafc;

    border: 1px solid #e2e8f0;

    border-radius: 10px;

    color: #475569;

    font-size: 14px;

    line-height: 1.5;

}


.reply-form-control {

    width: 100%;

    min-height: 48px;

    padding: 0 14px;

    border: 1px solid #e2e8f0;

    border-radius: 10px;

    background: #ffffff;

    color: #334155;

    font-size: 14px;

    outline: none;

    cursor: pointer;

    color-scheme: light;

}


.reply-form-control:focus {

    border-color: #2563eb;

    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);

}


.reply-modal-actions {

    display: flex;

    gap: 12px;

    width: 100%;

    margin-top: 25px;

}


.reply-modal-cancel,
.reply-modal-submit {

    flex: 1;

    min-height: 48px;

    padding: 0 18px;

    border-radius: 11px;

    font-size: 14px;

    font-weight: 600;

    cursor: pointer;

    transition: all 0.2s ease;

}


.reply-modal-cancel {

    border: 1px solid #e2e8f0;

    background: #ffffff;

    color: #475569;

}


.reply-modal-cancel:hover {

    background: #f8fafc;

    border-color: #cbd5e1;

}


.reply-modal-submit {

    border: 1px solid #2563eb;

    background: #2563eb;

    color: #ffffff;

    box-shadow: 0 6px 16px rgba(37, 99, 235, 0.20);

}


.reply-modal-submit:hover {

    background: #1d4ed8;

    border-color: #1d4ed8;

    transform: translateY(-1px);

}


.reply-modal-submit i {

    margin-right: 5px;

}


/* =========================================================
   DELETE / RESTORE
========================================================= */

.delete-totalrequest-btn {

    color: #dc2626;

}

.delete-totalrequest-btn:hover {

    color: #b91c1c;

}


.recycle-totalrequest-btn {

    color: #16a34a;

}

.recycle-totalrequest-btn:hover {

    color: #15803d;

}


.delete-modal-box,
.restore-modal-box {

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


.delete-modal-overlay.show .delete-modal-box,
.restore-modal-overlay.show .restore-modal-box {

    transform: translateY(0) scale(1);

    opacity: 1;

}


.delete-modal-close,
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


.restore-modal-close {

    background: #f0fdf4;

}


.restore-modal-close:hover {

    background: #dcfce7;

    color: #16a34a;

    transform: rotate(90deg);

}


.delete-modal-icon,
.restore-modal-icon {

    width: 82px;

    height: 82px;

    margin: 0 auto 20px;

    display: flex;

    align-items: center;

    justify-content: center;

    border-radius: 50%;

    font-size: 34px;

}


.delete-modal-icon {

    background: #fff1f2;

    border: 8px solid #ffe4e6;

    color: #dc2626;

    box-shadow: 0 10px 25px rgba(220, 38, 38, 0.12);

}


.restore-modal-icon {

    background: #f0fdf4;

    border: 8px solid #dcfce7;

    color: #16a34a;

    box-shadow: 0 10px 25px rgba(22, 163, 74, 0.14);

}


.delete-modal-box h3,
.restore-modal-box h3 {

    margin: 0 0 10px;

    font-size: 25px;

    font-weight: 700;

}


.delete-modal-box h3 {

    color: #1e293b;

}


.restore-modal-box h3 {

    color: #14532d;

}


.delete-modal-box p,
.restore-modal-box p {

    margin: 0 auto 20px;

    max-width: 350px;

    color: #64748b;

    font-size: 15px;

    line-height: 1.65;

}


.delete-modal-box p strong {

    color: #334155;

}


.restore-modal-box p strong {

    color: #166534;

}


.delete-modal-actions,
.restore-modal-actions {

    display: flex;

    gap: 12px;

    width: 100%;

}


.delete-modal-cancel,
.delete-modal-confirm,
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


.delete-modal-cancel,
.restore-modal-cancel {

    border: 1px solid #e2e8f0;

    background: #ffffff;

    color: #475569;

}


.delete-modal-confirm {

    border: 1px solid #dc2626;

    background: #dc2626;

    color: #ffffff;

}


.restore-modal-confirm {

    border: 1px solid #16a34a;

    background: #16a34a;

    color: #ffffff;

}


.delete-modal-confirm:hover {

    background: #b91c1c;

    border-color: #b91c1c;

}


.restore-modal-confirm:hover {

    background: #15803d;

    border-color: #15803d;

}


.delete-modal-confirm i,
.restore-modal-confirm i {

    margin-right: 5px;

}


/* =========================================================
   MOBILE
========================================================= */

@media (max-width: 480px) {

    .complaint-modal-box {

        max-width: 100%;

        max-height: 90vh;

        padding: 24px 20px 20px;

        border-radius: 18px;

    }


    .reply-modal-box {

        max-width: 100%;

        padding: 30px 20px 24px;

        border-radius: 18px;

    }


    .delete-modal-box,
    .restore-modal-box {

        max-width: 100%;

        padding: 35px 20px 24px;

        border-radius: 18px;

    }


    .reply-modal-actions,
    .delete-modal-actions,
    .restore-modal-actions {

        flex-direction: column-reverse;

    }


    .reply-modal-cancel,
    .reply-modal-submit,
    .delete-modal-cancel,
    .delete-modal-confirm,
    .restore-modal-cancel,
    .restore-modal-confirm {

        width: 100%;

        flex: none;

    }

}

</style>

<script>

let deletetotalrequestSn = null;

let deleteTableName = null;

let restoretotalrequestSn = null;

let restoreTableName = null;


/*
|--------------------------------------------------------------------------
| SHOW COMPLAINT MODAL
|--------------------------------------------------------------------------
*/

function showComplaintModal(subject, complaint) {

    const modal = document.getElementById('complaintModal');

    const subjectElement =
        document.getElementById('complaintModalTitle');

    const complaintElement =
        document.getElementById('complaintModalBody');

    subjectElement.textContent = subject || 'N/A';

    complaintElement.textContent = complaint || 'N/A';

    modal.classList.add('show');

    modal.setAttribute('aria-hidden', 'false');

    document.body.style.overflow = 'hidden';

}


/*
|--------------------------------------------------------------------------
| CLOSE COMPLAINT MODAL
|--------------------------------------------------------------------------
*/

function closeComplaintModal() {

    const modal = document.getElementById('complaintModal');

    modal.classList.remove('show');

    modal.setAttribute('aria-hidden', 'true');

    document.body.style.overflow = '';

}


/*
|--------------------------------------------------------------------------
| SHOW REPLY MODAL
|--------------------------------------------------------------------------
*/

function showReplyModal(ticketSn, subject, status) {

    const modal = document.getElementById('replyModal');

    const ticketSnElement =
        document.getElementById('replyTicketSn');

    const subjectElement =
        document.getElementById('replySubject');

    const statusElement =
        document.getElementById('replyStatus');

    ticketSnElement.value = ticketSn || '';

    subjectElement.textContent = subject || 'N/A';

    statusElement.value = status;

    modal.classList.add('show');

    modal.setAttribute('aria-hidden', 'false');

    document.body.style.overflow = 'hidden';

}


/*
|--------------------------------------------------------------------------
| CLOSE REPLY MODAL
|--------------------------------------------------------------------------
*/

function closeReplyModal() {

    const modal = document.getElementById('replyModal');

    modal.classList.remove('show');

    modal.setAttribute('aria-hidden', 'true');

    document.body.style.overflow = '';

}


/*
|--------------------------------------------------------------------------
| SHOW DELETE MODAL
|--------------------------------------------------------------------------
*/

function showDeleteModal(totalrequestSn, totalrequestId, tableName) {

    deletetotalrequestSn = totalrequestSn;

    deleteTableName = tableName;

    const modal = document.getElementById('deleteModal');

    const totalrequestIdElement =
        document.getElementById('deleteUserName');

    totalrequestIdElement.textContent = totalrequestId;

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

    deletetotalrequestSn = null;

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

        if (!deletetotalrequestSn || !deleteTableName) {

            return;

        }

        window.location.href =
            'index?action=delete_totalrequest' +
            '&sn=' + encodeURIComponent(deletetotalrequestSn) +
            '&table_name=' + encodeURIComponent(deleteTableName);

    });


/*
|--------------------------------------------------------------------------
| SHOW RESTORE MODAL
|--------------------------------------------------------------------------
*/

function showRestoreModal(totalrequestSn, totalrequestId, tableName) {

    restoretotalrequestSn = totalrequestSn;

    restoreTableName = tableName;

    const modal = document.getElementById('restoreModal');

    const totalrequestIdElement =
        document.getElementById('restoreUserName');

    totalrequestIdElement.textContent = totalrequestId;

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

    restoretotalrequestSn = null;

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

        if (!restoretotalrequestSn || !restoreTableName) {

            return;

        }

        window.location.href =
            'index?action=restore_totalrequest' +
            '&sn=' + encodeURIComponent(restoretotalrequestSn) +
            '&table_name=' + encodeURIComponent(restoreTableName);

    });


/*
|--------------------------------------------------------------------------
| CLOSE MODALS WHEN CLICKING OUTSIDE
|--------------------------------------------------------------------------
*/

document
    .getElementById('complaintModal')
    .addEventListener('click', function (event) {

        if (event.target === this) {

            closeComplaintModal();

        }

    });


document
    .getElementById('replyModal')
    .addEventListener('click', function (event) {

        if (event.target === this) {

            closeReplyModal();

        }

    });


document
    .getElementById('deleteModal')
    .addEventListener('click', function (event) {

        if (event.target === this) {

            closeDeleteModal();

        }

    });


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

    if (event.key !== 'Escape') {

        return;

    }


    if (
        document
            .getElementById('complaintModal')
            .classList.contains('show')
    ) {

        closeComplaintModal();

    }


    if (
        document
            .getElementById('replyModal')
            .classList.contains('show')
    ) {

        closeReplyModal();

    }


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

});

</script>
