<?php

$table_name = "request";
$totalrequest_sn = 0;

$ticket_no = '';
$ticketer_email = '';
$ticketer_name = '';
$ticket_status = '';

?>

<!-- =========================================================
     REQUEST TABLE - SUMMARY SECTION
========================================================= -->

<section class="request-summary">

    <div class="request-summary-counters">

        <?php if (!empty($wellhead_status_counts) && is_array($wellhead_status_counts)): ?>

            <?php foreach ($wellhead_status_counts as $status_count): ?>

                <?php
                    $status_name = (string)($status_count['name'] ?? '');
                    $status_total = (int)($status_count['total'] ?? 0);
                    $status_color = trim((string)($status_count['color'] ?? '#3b6fd4'));

                    if (!preg_match('/^#[a-fA-F0-9]{3,8}$/', $status_color)) {
                        $status_color = '#3b6fd4';
                    }
                ?>

                <div class="request-counter"
                     style="--counter-color: <?= htmlspecialchars($status_color, ENT_QUOTES, 'UTF-8') ?>">

                    <span><?= htmlspecialchars($status_name, ENT_QUOTES, 'UTF-8') ?></span>

                    <strong><?= $status_total ?></strong>

                </div>

            <?php endforeach; ?>

        <?php endif; ?>

    </div>

    <div class="request-summary-actions">

        <button type="button"
                class="request-btn request-btn-danger"
                id="deleteSelectedBtn"
                style="display: none;"
                disabled>
            <i class="mdi mdi-delete-outline"></i>
            Delete Selected
        </button>

        <button type="button"
                class="request-btn request-btn-primary"
                id="createRequestBtn">
            <i class="mdi mdi-plus-circle-outline"></i>
            Create Request
        </button>

        <label class="request-auto-reload">
            <input type="checkbox" id="autoReload">
            <span>Auto reload page</span>
        </label>

    </div>

</section>


<!-- =========================================================
     REQUEST TABLE
========================================================= -->

<div class="row">

    <div class="col-12 grid-margin stretch-card">

        <div class="card request-card">

            <div class="card-body">

                <div class="request-heading">

                    <div>
                        <h4 class="card-title mb-1">Request Management</h4>

                        <p class="text-muted mb-0">
                            Manage user requests, complaints and ticket updates.
                        </p>
                    </div>

                    <?php if (($page_name ?? '') === 'dashboard'): ?>

                        <a href="index?action=totalrequests"
                           class="btn btn-primary">
                            View All
                        </a>

                    <?php endif; ?>

                </div>

                <div class="request-table-toolbar">

                    <div class="request-search-box">
                        <i class="mdi mdi-magnify"></i>

                        <input type="search"
                               id="requestSearch"
                               placeholder="Search requests..."
                               aria-label="Search requests">
                    </div>

                    <select id="requestStatusFilter"
                            class="request-filter"
                            aria-label="Filter requests by status">

                        <option value="">All statuses</option>
                        <option value="new">New</option>
                        <option value="opened">Opened</option>
                        <option value="in progress">In Progress</option>
                        <option value="replied">Replied</option>
                        <option value="resolved">Resolved</option>
                        <option value="deleted">Deleted</option>

                    </select>

                </div>

                <div class="request-table-wrapper">

                    <table class="request-management-datatable request-table"
                           id="dashboardDataTable">

                        <thead>

                            <tr>

                                <!-- <th class="request-checkbox-cell">
                                    <input type="checkbox"
                                           id="selectAll"
                                           aria-label="Select all requests">
                                </th> -->

                                <th style="text-align: center;">S/N</th>
                                <th>Ticket ID</th>
                                <th>User</th>
                                <th>Name</th>
                                <th>Subject / Complaint</th>
                                <th>Priority</th>
                                <th>Date &amp; Time</th>
                                <th>Status</th>

                            </tr>

                        </thead>

                        <tbody>

                        <?php if (!empty($LoadAllRequest) && is_array($LoadAllRequest)): ?>

                            <?php $sn = 1; ?>

                            <?php foreach ($LoadAllRequest as $totalrequest): ?>

                                <?php

                                    $ticket_sn = $totalrequest['ticket_sn'] ?? 0;
                                    $ticket_no = $totalrequest['ticket_no'] ?? '';

                                    $totalrequest_sn = $ticket_sn;

                                    $ticket_userid = $totalrequest['ticket_userid'] ?? '';

                                    $ticketer_name = $ticket_userid !== '' ? ($ticket_userid) : 'N/A';
                                    $ticketer_email = '';

                                    $ticketer_role = $totalrequest['category'] ?? 'N/A';

                                    $ticket_subject = $totalrequest['subject'] ?? 'N/A';
                                    $ticket_complain = $totalrequest['complain'] ?? 'N/A';

                                    $ticket_priority = $totalrequest['priority'] ?? 0;
                                    $ticket_date = $totalrequest['date'] ?? '';
                                    $ticket_status = $totalrequest['status'] ?? '';

                                    /* Name column — map from the table's name field */
                                    $ticket_name = $totalrequest['name'] ?? 'N/A';

                                    $status_map = [
                                        0 => ['New', 'pending'],
                                        1 => ['Opened', 'active'],
                                        2 => ['In Progress', 'pending'],
                                        3 => ['Replied', 'active'],
                                        4 => ['Resolved', 'active'],
                                        -1 => ['Deleted', 'danger']
                                    ];

                                    $current_status = $status_map[(int)$ticket_status]
                                        ?? ['Deleted', 'danger'];

                                    $priority_map = [
                                        2 => ['High', 'danger'],
                                        1 => ['Medium', 'warning']
                                    ];

                                    $current_priority = $priority_map[(int)$ticket_priority]
                                        ?? ['Low', 'success'];

                                    $safe_ticket_sn = htmlspecialchars(
                                        (string)$totalrequest_sn,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );

                                    $safe_ticket_no = htmlspecialchars(
                                        (string)$ticket_no,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    );

                                ?>

                                <tr>

                                    <!-- SELECT -->
                                    <!-- <td class="request-checkbox-cell">

                                        <input type="checkbox"
                                               class="request-checkbox"
                                               value="<?= $safe_ticket_sn ?>"
                                               aria-label="Select request <?= $safe_ticket_no ?>">

                                    </td> -->

                                    <!-- SERIAL NUMBER -->
                                    <td style="text-align: center;">
                                        <span class="request-serial">
                                            <?= $sn++ ?>
                                        </span>
                                    </td>

                                    <!-- TICKET ID -->
                                    <td>
                                        <strong class="request-ticket-id">
                                            <?= $safe_ticket_no ?>
                                        </strong>
                                    </td>

                                    <!-- USER (REQUESTER) -->
                                    <td>

                                        <div class="dashboard-table-user">

                                            <div class="request-avatar">
                                                <i class="mdi mdi-account-outline"></i>
                                            </div>

                                            <div>

                                                <div class="dashboard-table-user-name">
                                                    <?= htmlspecialchars(
                                                        ucfirst((string)$ticketer_name),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>
                                                </div>

                                                <div class="dashboard-table-user-email">
                                                    <?= htmlspecialchars(
                                                        (string)$ticketer_email,
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>
                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    <!-- NAME -->
                                    <td>

                                        <span class="dashboard-role">
                                            <?= htmlspecialchars(
                                                ucfirst((string)$ticket_name),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </span>

                                    </td>

                                    <!-- SUBJECT / COMPLAINT -->
                                    <td>

                                        <button type="button"
                                                class="dashboard-subject-btn"
                                                onclick="showComplaintModal(
                                                    <?= htmlspecialchars(
                                                        json_encode(
                                                            (string)$ticket_subject,
                                                            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>,
                                                    <?= htmlspecialchars(
                                                        json_encode(
                                                            (string)$ticket_complain,
                                                            JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP
                                                        ),
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>
                                                )">

                                            <?= htmlspecialchars(
                                                ucfirst((string)$ticket_subject),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </button>

                                        <div class="request-complaint-preview">
                                            <?= htmlspecialchars(
                                                mb_strimwidth(
                                                    (string)$ticket_complain,
                                                    0,
                                                    55,
                                                    '...',
                                                    'UTF-8'
                                                ),
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </div>

                                    </td>

                                    <!-- PRIORITY -->
                                    <td>

                                        <span class="dashboard-status dashboard-status-<?= $current_priority[1] ?>">

                                            <span class="request-priority-dot"></span>

                                            <?= $current_priority[0] ?>

                                        </span>

                                    </td>

                                    <!-- DATE -->
                                    <td class="request-date">

                                        <?= !empty($ticket_date) && strtotime($ticket_date) !== false
                                            ? date('d M Y, h:i A', strtotime($ticket_date))
                                            : 'N/A' ?>

                                    </td>

                                    <!-- STATUS -->
                                    <td>

                                        <span class="dashboard-status dashboard-status-<?= $current_status[1] ?>">

                                            <?= htmlspecialchars(
                                                $current_status[0],
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>

                                        </span>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php else: ?>

                            <tr>

                                <td colspan="9" class="request-empty-state">

                                    <div class="request-empty-icon">
                                        <i class="mdi mdi-inbox-outline"></i>
                                    </div>

                                    <strong>No requests found</strong>

                                    <p>New requests and complaints will appear here.</p>

                                </td>

                            </tr>

                        <?php endif; ?>

                        </tbody>

                    </table>

                </div>

                <div class="request-table-footer">

                    <span id="requestResultCount">
                        Showing requests
                    </span>

                    <button type="button"
                            class="request-clear-filters"
                            id="clearRequestFilters">
                        Clear filters
                    </button>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     COMPLAINT MODAL
========================================================= -->

<div id="complaintModal"
     class="request-modal-overlay"
     aria-hidden="true">

    <div class="request-modal-box complaint-modal-box"
         role="dialog"
         aria-modal="true"
         aria-labelledby="complaintModalTitle">

        <button type="button"
                class="request-modal-close"
                onclick="closeComplaintModal()"
                aria-label="Close">
            &times;
        </button>

        <div class="request-modal-heading">

            <div class="request-modal-icon">
                <i class="mdi mdi-text-box-outline"></i>
            </div>

            <div>
                <span class="request-modal-eyebrow">Request details</span>
                <h3 id="complaintModalTitle">Subject</h3>
            </div>

        </div>

        <div class="request-modal-content">

            <span class="request-modal-content-label">
                Complaint / Request
            </span>

            <div id="complaintModalBody"
                 class="request-modal-body">Request details</div>

        </div>

        <div class="request-modal-footer">

            <button type="button"
                    class="request-modal-btn request-modal-btn-secondary"
                    onclick="closeComplaintModal()">
                Close
            </button>

        </div>

    </div>

</div>


<!-- =========================================================
     CREATE REQUEST MODAL
========================================================= -->

<div id="createRequestModal"
     class="request-modal-overlay"
     aria-hidden="true">

    <div class="request-modal-box"
         role="dialog"
         aria-modal="true"
         aria-labelledby="createRequestModalTitle">

        <button type="button"
                class="request-modal-close"
                onclick="closeCreateRequestModal()"
                aria-label="Close">
            &times;
        </button>

        <div class="request-modal-centered-icon">
            <i class="mdi mdi-plus-circle-outline"></i>
        </div>

        <h3 id="createRequestModalTitle" class="request-modal-title">
            Create Request
        </h3>

        <form method="POST"
              action="index.php?action=create_request" enctype="application/x-www-form-urlencoded">

            <div class="request-form-group">

                <label for="createPriority">Priority</label>

                <select name="priority"
                        id="createPriority"
                        class="request-form-control"
                        required>

                    <option value="">Select priority</option>
                    <option value="2">High</option>
                    <option value="1">Medium</option>
                    <option value="0">Low</option>

                </select>

            </div>

            <div class="request-form-group">

                <label for="createSubject">Subject</label>

                <input type="text"
                       name="subject"
                       id="createSubject"
                       class="request-form-control"
                       required>

            </div>

            <div class="request-form-group">

                <label for="createComplain">Complain / Request</label>

                <textarea name="complain"
                          id="createComplain"
                          class="request-form-control"
                          rows="5"
                          required></textarea>

            </div>
<input  type="hidden" name="create_request" >
            <div class="request-modal-actions">

                <button type="button"
                        class="request-modal-btn request-modal-btn-secondary"
                        onclick="closeCreateRequestModal()">
                    Cancel
                </button>

                <button type="submit"
                        name="create_request"
                        class="request-modal-btn request-modal-btn-primary">

                    <i class="mdi mdi-send"></i>
                    Create

                </button>

            </div>

        </form>

    </div>

</div>


<!-- =========================================================
     REPLY / UPDATE MODAL
========================================================= -->

<div id="replyModal"
     class="request-modal-overlay"
     aria-hidden="true">

    <div class="request-modal-box"
         role="dialog"
         aria-modal="true"
         aria-labelledby="replyModalTitle">

        <button type="button"
                class="request-modal-close"
                onclick="closeReplyModal()"
                aria-label="Close">
            &times;
        </button>

        <div class="request-modal-centered-icon">
            <i class="mdi mdi-reply"></i>
        </div>

        <h3 id="replyModalTitle" class="request-modal-title">
            Update Request
        </h3>

        <form method="POST"
              enctype="multipart/form-data"
              action="index.php?action=totalrequest">

            <input type="hidden" name="sn" id="replyTicketSn">

            <input type="hidden" name="ticketer_email" id="replyTicketEmail">

            <input type="hidden"
                   name="table_name"
                   value="request">

            <input type="hidden" name="ticket_no" id="replyTicketNo">

            <input type="hidden" name="ticketer_name" id="replyTicketName">

            <input type="hidden" name="ticket_status" id="replyCurrentStatus">

            <div class="request-form-group">

                <label for="replySubject">Subject</label>

                <div id="replySubject"
                     class="request-subject-display">Subject</div>

            </div>

            <div class="request-form-group">

                <label for="replyStatus">Change Status</label>

                <select name="status"
                        id="replyStatus"
                        class="request-form-control"
                        required>

                    <option value="0">New</option>
                    <option value="1">Opened</option>
                    <option value="2">In Progress</option>
                    <option value="3">Replied</option>
                    <option value="4">Resolved</option>

                </select>

            </div>

            <div class="request-modal-actions">

                <button type="button"
                        class="request-modal-btn request-modal-btn-secondary"
                        onclick="closeReplyModal()">
                    Cancel
                </button>

                <button type="submit"
                        name="requestreply"
                        class="request-modal-btn request-modal-btn-primary">

                    <i class="mdi mdi-send"></i>
                    Post Update

                </button>

            </div>

        </form>

    </div>

</div>


<!-- =========================================================
     DELETE CONFIRMATION MODAL
========================================================= -->

<div id="deleteModal"
     class="request-modal-overlay"
     aria-hidden="true">

    <div class="request-modal-box request-confirm-box"
         role="dialog"
         aria-modal="true"
         aria-labelledby="deleteModalTitle">

        <button type="button"
                class="request-modal-close"
                onclick="closeDeleteModal()"
                aria-label="Close">&times;</button>

        <div class="request-confirm-icon request-confirm-icon-danger">
            <i class="mdi mdi-delete-alert-outline"></i>
        </div>

        <h3 id="deleteModalTitle">Delete Request?</h3>

        <p>
            Are you sure you want to delete ticket
            <strong id="deleteUserName">this ticket</strong>?
        </p>

        <div class="request-modal-actions">

            <button type="button"
                    class="request-modal-btn request-modal-btn-secondary"
                    onclick="closeDeleteModal()">
                Cancel
            </button>

            <button type="button"
                    class="request-modal-btn request-modal-btn-danger"
                    id="confirmDeleteBtn">
                <i class="mdi mdi-delete-outline"></i>
                Yes, Delete
            </button>

        </div>

    </div>

</div>


<!-- =========================================================
     RESTORE CONFIRMATION MODAL
========================================================= -->

<div id="restoreModal"
     class="request-modal-overlay"
     aria-hidden="true">

    <div class="request-modal-box request-confirm-box"
         role="dialog"
         aria-modal="true"
         aria-labelledby="restoreModalTitle">

        <button type="button"
                class="request-modal-close"
                onclick="closeRestoreModal()"
                aria-label="Close">&times;</button>

        <div class="request-confirm-icon request-confirm-icon-success">
            <i class="mdi mdi-recycle"></i>
        </div>

        <h3 id="restoreModalTitle">Restore Request?</h3>

        <p>
            Do you want to restore ticket
            <strong id="restoreUserName">this ticket</strong>?
        </p>

        <div class="request-modal-actions">

            <button type="button"
                    class="request-modal-btn request-modal-btn-secondary"
                    onclick="closeRestoreModal()">
                Cancel
            </button>

            <button type="button"
                    class="request-modal-btn request-modal-btn-success"
                    id="confirmRestoreBtn">
                <i class="mdi mdi-restore"></i>
                Yes, Restore
            </button>

        </div>

    </div>

</div>


<!-- =========================================================
     REQUEST TABLE STYLES
========================================================= -->

<style>

.request-summary {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 25px;
}

.request-summary-counters {
    display: flex;
    flex-wrap: wrap;
    gap: 12px;
}

.request-counter {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 18px;
    min-width: 125px;
    padding: 13px 16px;
    background: #fff;
    border: 1px solid #e8edf4;
    border-left: 3px solid var(--counter-color, #3b6fd4);
    border-radius: 10px;
    color: #64748b;
    font-size: 13px;
}

.request-counter strong {
    color: var(--counter-color, #3b6fd4);
    font-size: 19px;
}

.request-summary-actions {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.request-btn {
    min-height: 40px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 9px 15px;
    border: 1px solid transparent;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none !important;
    cursor: pointer;
    transition: .2s ease;
}

.request-btn-primary {
    color: #fff !important;
    background: #2563eb;
}

.request-btn-primary:hover {
    background: #1d4ed8;
}

.request-btn-danger {
    color: #dc2626;
    background: #fff;
    border-color: #fecaca;
}

.request-btn-danger:hover:not(:disabled) {
    background: #fef2f2;
}

.request-btn:disabled {
    opacity: .45;
    cursor: not-allowed;
}

.request-auto-reload {
    display: flex;
    align-items: center;
    gap: 7px;
    color: #64748b;
    font-size: 12px;
    cursor: pointer;
}

.request-auto-reload input {
    accent-color: #2563eb;
}

.request-card {
    border: 1px solid #e9edf5;
    border-radius: 14px;
    box-shadow: 0 5px 22px rgba(15, 23, 42, .04);
}

.request-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 15px;
    margin-bottom: 25px;
}

.request-heading .card-title {
    color: #1e293b;
    font-weight: 700;
}

.request-heading p {
    font-size: 13px;
}

.request-table-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 18px;
}

.request-search-box {
    display: flex;
    align-items: center;
    gap: 9px;
    width: min(100%, 340px);
    min-height: 42px;
    padding: 0 13px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    background: #fff;
    color: #94a3b8;
}

.request-search-box input {
    width: 100%;
    min-width: 0;
    border: 0;
    outline: 0;
    background: transparent;
    color: #334155;
    font-size: 13px;
}

.request-filter {
    min-height: 42px;
    padding: 0 12px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    background: #fff;
    color: #475569;
    font-size: 13px;
    outline: none;
}

.request-table-wrapper {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #edf0f5;
    border-radius: 10px;
}

.request-table {
    width: 100%;
    min-width: 1150px;
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 12px;
}

.request-table thead th {
    padding: 15px 13px;
    background: #f8fafc;
    border-bottom: 1px solid #e8edf4;
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: .35px;
    white-space: nowrap;
}

.request-table tbody td {
    padding: 15px 13px;
    border-bottom: 1px solid #f0f2f6;
    color: #475569;
    vertical-align: middle;
}

.request-table tbody tr:last-child td {
    border-bottom: 0;
}

.request-table tbody tr:hover {
    background: #fafcff;
}

.request-checkbox-cell {
    width: 38px;
    text-align: center !important;
}

.request-checkbox-cell input {
    width: 15px;
    height: 15px;
    accent-color: #2563eb;
    cursor: pointer;
}

.request-serial {
    display: inline-block;
    color: #94a3b8;
    font-weight: 600;
    text-align: center;
}

.request-ticket-id {
    color: #2563eb;
    white-space: nowrap;
}

.dashboard-table-user {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 155px;
}

.request-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 35px;
    height: 35px;
    border-radius: 10px;
    background: #eff6ff;
    color: #2563eb;
    font-size: 19px;
}

.dashboard-table-user-name {
    color: #334155;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.dashboard-table-user-email {
    max-width: 175px;
    margin-top: 4px;
    color: #94a3b8;
    font-size: 11px;
    overflow-wrap: anywhere;
}

.dashboard-role {
    display: inline-flex;
    padding: 5px 9px;
    border-radius: 6px;
    background: #f1f5f9;
    color: #475569;
    font-size: 11px;
    font-weight: 600;
}

.dashboard-subject-btn {
    display: block;
    max-width: 220px;
    padding: 0;
    overflow: hidden;
    border: 0;
    background: transparent;
    color: #2563eb;
    font-family: inherit;
    font-size: 12px;
    font-weight: 600;
    text-align: left;
    text-overflow: ellipsis;
    white-space: nowrap;
    cursor: pointer;
}

.dashboard-subject-btn:hover {
    color: #1d4ed8;
    text-decoration: underline;
}

.request-complaint-preview {
    max-width: 220px;
    margin-top: 5px;
    color: #94a3b8;
    font-size: 11px;
    line-height: 1.5;
    overflow-wrap: anywhere;
}

.dashboard-status {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 5px;
    padding: 6px 9px;
    border: 1px solid transparent;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.dashboard-status-pending {
    background: #fef3c7;
    color: #b45309;
    border-color: #fde68a;
}

.dashboard-status-active {
    background: #dcfce7;
    color: #15803d;
    border-color: #bbf7d0;
}

.dashboard-status-danger {
    background: #fee2e2;
    color: #dc2626;
    border-color: #fecaca;
}

.dashboard-status-warning {
    background: #fef3c7;
    color: #b45309;
    border-color: #fde68a;
}

.dashboard-status-success {
    background: #dcfce7;
    color: #15803d;
    border-color: #bbf7d0;
}

.request-priority-dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: currentColor;
}

.request-date {
    min-width: 125px;
    color: #64748b !important;
    white-space: nowrap;
}

.request-action-group {
    display: flex;
    align-items: center;
    gap: 5px;
}

.dashboard-table-action {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 33px;
    height: 33px;
    padding: 0;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    background: #fff;
    color: #64748b;
    font-size: 17px;
    cursor: pointer;
    transition: .2s ease;
}

.dashboard-table-action:hover {
    background: #eff6ff;
    border-color: #bfdbfe;
    color: #2563eb;
}

.request-action-delete:hover {
    background: #fef2f2;
    border-color: #fecaca;
    color: #dc2626;
}

.request-action-restore:hover {
    background: #f0fdf4;
    border-color: #bbf7d0;
    color: #16a34a;
}

.request-empty-state {
    padding: 50px 20px !important;
    text-align: center;
}

.request-empty-icon {
    margin-bottom: 12px;
    color: #94a3b8;
    font-size: 36px;
}

.request-empty-state strong {
    display: block;
    color: #334155;
    font-size: 15px;
}

.request-empty-state p {
    margin: 6px 0 0;
    color: #94a3b8;
    font-size: 12px;
}

.request-table-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
    margin-top: 16px;
    color: #94a3b8;
    font-size: 12px;
}

.request-clear-filters {
    padding: 6px 10px;
    border: 0;
    border-radius: 6px;
    background: #eff6ff;
    color: #2563eb;
    font-size: 12px;
    cursor: pointer;
}


/* MODALS */

.request-modal-overlay {
    position: fixed;
    inset: 0;
    z-index: 99998;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(15, 23, 42, .65);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    opacity: 0;
    visibility: hidden;
    pointer-events: none;
    transition: opacity .22s ease, visibility .22s ease;
}

.request-modal-overlay.show {
    opacity: 1;
    visibility: visible;
    pointer-events: auto;
}

.request-modal-box {
    position: relative;
    width: 100%;
    max-width: 500px;
    max-height: 88vh;
    padding: 30px;
    overflow-y: auto;
    border-radius: 18px;
    background: #fff;
    box-shadow: 0 25px 70px rgba(15, 23, 42, .25);
    transform: translateY(15px) scale(.98);
    transition: transform .22s ease;
}

.request-modal-overlay.show .request-modal-box {
    transform: translateY(0) scale(1);
}

.complaint-modal-box {
    max-width: 640px;
}

.request-modal-close {
    position: absolute;
    top: 12px;
    right: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border: 0;
    border-radius: 50%;
    background: #f1f5f9;
    color: #64748b;
    font-size: 25px;
    cursor: pointer;
}

.request-modal-heading {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    padding-right: 28px;
    margin-bottom: 22px;
}

.request-modal-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 48px;
    height: 48px;
    border-radius: 13px;
    background: #eff6ff;
    color: #2563eb;
    font-size: 24px;
}

.request-modal-eyebrow {
    color: #94a3b8;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .8px;
}

.request-modal-heading h3 {
    margin: 4px 0 0;
    color: #1e293b;
    font-size: 20px;
    overflow-wrap: anywhere;
}

.request-modal-content {
    padding: 18px;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    background: #f8fafc;
}

.request-modal-content-label {
    display: block;
    margin-bottom: 10px;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
}

.request-modal-body {
    max-height: 40vh;
    overflow-y: auto;
    color: #475569;
    font-size: 14px;
    line-height: 1.8;
    white-space: pre-wrap;
    overflow-wrap: anywhere;
}

.request-modal-footer {
    display: flex;
    justify-content: flex-end;
    margin-top: 18px;
}

.request-modal-centered-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    border: 7px solid #dbeafe;
    border-radius: 50%;
    background: #eff6ff;
    color: #2563eb;
    font-size: 25px;
}

.request-modal-title {
    margin: 0 0 23px;
    color: #1e293b;
    font-size: 22px;
    font-weight: 700;
    text-align: center;
}

.request-form-group {
    margin-bottom: 18px;
}

.request-form-group label {
    display: block;
    margin-bottom: 8px;
    color: #334155;
    font-size: 13px;
    font-weight: 600;
}

.request-subject-display {
    padding: 12px 14px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    background: #f8fafc;
    color: #475569;
    font-size: 13px;
    overflow-wrap: anywhere;
}

.request-form-control {
    width: 100%;
    min-height: 45px;
    padding: 0 12px;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    background: #fff;
    color: #334155;
    font-size: 13px;
    color-scheme: light;
}

textarea.request-form-control {
    padding: 10px 12px;
    resize: vertical;
}

.request-form-control:focus {
    border-color: #2563eb;
    outline: 2px solid rgba(37, 99, 235, .12);
}

.request-modal-actions {
    display: flex;
    gap: 10px;
    margin-top: 23px;
}

.request-modal-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex: 1;
    gap: 6px;
    min-height: 44px;
    padding: 10px 15px;
    border: 1px solid transparent;
    border-radius: 9px;
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: .2s ease;
}

.request-modal-btn-secondary {
    border-color: #e2e8f0;
    background: #fff;
    color: #475569;
}

.request-modal-btn-primary {
    background: #2563eb;
    color: #fff;
}

.request-modal-btn-danger {
    background: #dc2626;
    color: #fff;
}

.request-modal-btn-success {
    background: #16a34a;
    color: #fff;
}

.request-modal-btn-primary:hover {
    background: #1d4ed8;
}

.request-modal-btn-danger:hover {
    background: #b91c1c;
}

.request-modal-btn-success:hover {
    background: #15803d;
}

.request-confirm-box {
    max-width: 420px;
    text-align: center;
}

.request-confirm-box h3 {
    margin: 0 0 10px;
    color: #1e293b;
    font-size: 23px;
}

.request-confirm-box p {
    margin: 0 auto;
    color: #64748b;
    font-size: 13px;
    line-height: 1.8;
}

.request-confirm-box p strong {
    color: #334155;
    overflow-wrap: anywhere;
}

.request-confirm-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 70px;
    height: 70px;
    margin: 0 auto 18px;
    border: 7px solid;
    border-radius: 50%;
    font-size: 28px;
}

.request-confirm-icon-danger {
    border-color: #fee2e2;
    background: #fff1f2;
    color: #dc2626;
}

.request-confirm-icon-success {
    border-color: #dcfce7;
    background: #f0fdf4;
    color: #16a34a;
}

@media (max-width: 768px) {

    .request-summary {
        align-items: stretch;
    }

    .request-summary-actions {
        width: 100%;
    }

    .request-heading {
        align-items: flex-start;
    }

    .request-search-box {
        width: 100%;
    }

    .request-filter {
        width: 100%;
    }

    .request-table-footer {
        align-items: flex-start;
    }

}

@media (max-width: 480px) {

    .request-counter {
        flex: 1;
        min-width: 110px;
    }

    .request-summary-actions {
        align-items: stretch;
        flex-direction: column;
    }

    .request-btn {
        width: 100%;
    }

    .request-auto-reload {
        padding: 5px 0;
    }

    .request-modal-box {
        padding: 25px 20px;
        border-radius: 15px;
    }

    .request-modal-actions {
        flex-direction: column-reverse;
    }

    .request-modal-btn {
        width: 100%;
        flex: none;
    }

}

/* =========================================================
   COLOR THEME COMPATIBILITY — MATCHES THE SHARED HEADER CSS
   Styling only: existing markup, PHP, IDs, and JavaScript remain unchanged.
========================================================= */
:root {
    --request-primary: #3b6fd4;
    --request-primary-hover: #2f5cb8;
    --request-border: #dfe3ea;
    --request-text: #2c3545;
    --request-muted: #6b7280;
    --request-page-bg: #eef1f6;
    --request-surface-bg: #f7f8fb;
    --request-surface-soft: #eef1f6;
    --request-surface-border: #dfe3ea;
    --request-table-head-bg: #eaedf3;
    --request-table-cell-bg: #f7f8fb;
    --request-table-hover-bg: #e8eef9;
    --request-secondary-text: #6b7280;
    --request-link-color: #3b6fd4;
    --request-input-bg: #eef1f6;
}

:root[data-theme="dark"] {
    color-scheme: dark;
    --request-primary: #8bb8ff;
    --request-primary-hover: #a6c8ff;
    --request-border: #29364a;
    --request-text: #e5edf8;
    --request-muted: #9aabc2;
    --request-page-bg: #0b1220;
    --request-surface-bg: #111c2e;
    --request-surface-soft: #172438;
    --request-surface-border: #29364a;
    --request-table-head-bg: #172438;
    --request-table-cell-bg: #111c2e;
    --request-table-hover-bg: #1a2a42;
    --request-secondary-text: #a7b6cb;
    --request-link-color: #8bb8ff;
    --request-input-bg: #172438;
}

.request-counter {
    background: var(--request-surface-bg);
    border-color: var(--request-surface-border);
    border-left-color: var(--counter-color, #3b6fd4);
    color: var(--request-secondary-text);
}

.request-counter strong {
    color: var(--counter-color, var(--request-primary));
}

.request-btn-primary,
.request-modal-btn-primary {
    background: #3b6fd4;
    color: #ffffff !important;
}

.request-btn-primary:hover,
.request-modal-btn-primary:hover {
    background: #2f5cb8;
}

.request-btn-danger {
    color: #c94b56;
    background: var(--request-surface-bg);
    border-color: rgba(217, 83, 94, .35);
}

.request-btn-danger:hover:not(:disabled) {
    background: rgba(217, 83, 94, .10);
}

.request-auto-reload,
.request-table-footer {
    color: var(--request-secondary-text);
}

.request-auto-reload input,
.request-checkbox-cell input {
    accent-color: #3b6fd4;
}

.request-card {
    background: var(--request-surface-bg);
    border-color: var(--request-surface-border);
    color: var(--request-text);
}

.request-heading .card-title,
.request-modal-heading h3,
.request-modal-title,
.request-confirm-box h3,
.request-empty-state strong {
    color: var(--request-text);
}

.request-search-box,
.request-filter,
.request-table-wrapper,
.dashboard-table-action,
.request-modal-content,
.request-subject-display,
.request-form-control,
.request-modal-btn-secondary {
    border-color: var(--request-surface-border);
    background: var(--request-surface-bg);
    color: var(--request-text);
}

.request-search-box input,
.request-form-control {
    color: var(--request-text);
}

.request-search-box input::placeholder,
.dashboard-table-user-email,
.request-complaint-preview,
.request-empty-icon,
.request-empty-state p,
.request-modal-eyebrow {
    color: var(--request-secondary-text);
}

.request-table {
    background: var(--request-surface-bg);
}

.request-table thead th {
    background: var(--request-table-head-bg);
    border-bottom-color: var(--request-surface-border);
    color: var(--request-secondary-text);
}

.request-table tbody td {
    background: var(--request-table-cell-bg);
    border-bottom-color: var(--request-surface-border);
    color: var(--request-text);
}

.request-table tbody tr:hover td {
    background: var(--request-table-hover-bg);
}

.request-ticket-id,
.dashboard-subject-btn,
.request-clear-filters {
    color: var(--request-link-color);
}

.dashboard-subject-btn:hover {
    color: var(--request-primary-hover);
}

.request-clear-filters,
.request-avatar,
.request-modal-icon,
.request-modal-centered-icon {
    background: rgba(59, 111, 212, .10);
    color: var(--request-link-color);
}

.dashboard-table-user-name,
.request-form-group label,
.request-modal-content-label,
.request-modal-body,
.request-confirm-box p strong {
    color: var(--request-text);
}

.dashboard-role,
.request-modal-close {
    background: var(--request-surface-soft);
    color: var(--request-secondary-text);
}

.dashboard-table-action {
    background: var(--request-surface-bg);
    color: var(--request-secondary-text);
}

.dashboard-table-action:hover {
    background: rgba(59, 111, 212, .10);
    border-color: rgba(59, 111, 212, .35);
    color: var(--request-link-color);
}

.request-modal-overlay {
    background: rgba(11, 18, 32, .65);
}

.request-modal-box {
    background: var(--request-surface-bg);
    color: var(--request-text);
    border: 1px solid var(--request-surface-border);
}

.request-modal-content,
.request-subject-display {
    background: var(--request-surface-soft);
}

.request-form-control:focus {
    border-color: #3b6fd4;
    outline-color: rgba(59, 111, 212, .12);
}

.request-modal-btn-secondary {
    background: var(--request-surface-soft);
    color: var(--request-text);
}

.request-confirm-box p {
    color: var(--request-secondary-text);
}

.request-confirm-icon-danger {
    border-color: rgba(217, 83, 94, .25);
    background: rgba(217, 83, 94, .10);
    color: #c94b56;
}

.request-confirm-icon-success {
    border-color: rgba(46, 160, 104, .25);
    background: rgba(46, 160, 104, .10);
    color: #238653;
}

:root[data-theme="dark"] .request-btn-danger {
    background: #351e2a;
    border-color: #75404e;
    color: #ff9aa6;
}

:root[data-theme="dark"] .request-btn-danger:hover:not(:disabled) {
    background: #4a2836;
    border-color: #ff9aa6;
    color: #ffb3bd;
}

:root[data-theme="dark"] .request-counter {
    background: rgba(255, 255, 255, .025);
}

:root[data-theme="dark"] .request-modal-close {
    background: #172438;
    color: #a7b6cb;
}

:root[data-theme="dark"] .request-modal-box {
    box-shadow: 0 20px 60px rgba(0, 0, 0, .35);
}

:root[data-theme="dark"] .dashboard-status-pending,
:root[data-theme="dark"] .dashboard-status-warning {
    background: rgba(220, 190, 70, .12);
    color: #f1d66a;
    border-color: rgba(220, 190, 70, .30);
}

:root[data-theme="dark"] .dashboard-status-active,
:root[data-theme="dark"] .dashboard-status-success {
    background: rgba(46, 160, 104, .12);
    color: #75d6a2;
    border-color: rgba(46, 160, 104, .30);
}

:root[data-theme="dark"] .dashboard-status-danger {
    background: rgba(217, 83, 94, .12);
    color: #ff9aa6;
    border-color: rgba(217, 83, 94, .30);
}

:root[data-theme="dark"] .request-confirm-icon-danger {
    color: #ff9aa6;
}

:root[data-theme="dark"] .request-confirm-icon-success {
    color: #75d6a2;
}

/* =========================================================
   REQUEST TABLE WIDTH FIX — KEEP THE TABLE INSIDE THE PAGE
   The table can scroll horizontally inside its own wrapper.
========================================================= */
.row:has(> .col-12 > .request-card) {
    max-width: 100%;
    min-width: 0;
    margin-left: 0;
    margin-right: 0;
}

.col-12.grid-margin.stretch-card:has(> .request-card),
.request-card,
.request-card > .card-body,
.request-table-wrapper {
    box-sizing: border-box;
    width: 100%;
    max-width: 100%;
    min-width: 0;
}

.request-table-wrapper {
    display: block;
    overflow-x: auto;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
}

.request-table {
    width: 100%;
    min-width: 1150px;
    table-layout: auto;
}

@media (max-width: 767px) {
    .request-card > .card-body {
        padding-left: 12px;
        padding-right: 12px;
    }
}

/* Keep the status counters and auto-reload control away from page edges. */
.request-summary {
    box-sizing: border-box;
    padding-left: 18px;
    padding-right: 18px;
}

@media (max-width: 767px) {
    .request-summary {
        padding-left: 10px;
        padding-right: 10px;
    }
}

</style>


<!-- =========================================================
     REQUEST TABLE JAVASCRIPT
========================================================= -->

<script>

(function () {

    'use strict';

    const table = document.getElementById('dashboardDataTable');

    if (!table) {
        return;
    }

    const tbody = table.querySelector('tbody');
    const selectAll = document.getElementById('selectAll');
    const deleteSelectedBtn = document.getElementById('deleteSelectedBtn');
    const searchInput = document.getElementById('requestSearch');
    const statusFilter = document.getElementById('requestStatusFilter');
    const resultCount = document.getElementById('requestResultCount');
    const clearFiltersBtn = document.getElementById('clearRequestFilters');
    const autoReload = document.getElementById('autoReload');

    let deleteRequestSn = null;
    let deleteTableName = null;
    let restoreRequestSn = null;
    let restoreTableName = null;

    function getRequestRows() {
        return Array.from(tbody.querySelectorAll('tr')).filter(function (row) {
            return row.querySelector('.request-checkbox') !== null;
        });
    }

    function updateSelection() {

        const checkboxes = Array.from(
            tbody.querySelectorAll('.request-checkbox')
        );

        const checked = checkboxes.filter(function (checkbox) {
            return checkbox.checked;
        });

        deleteSelectedBtn.disabled = checked.length === 0;

        if (selectAll) {
            selectAll.checked =
                checkboxes.length > 0 &&
                checked.length === checkboxes.length;

            selectAll.indeterminate =
                checked.length > 0 &&
                checked.length < checkboxes.length;
        }
    }

    function filterRequests() {

        const query = (searchInput.value || '').trim().toLowerCase();
        const status = (statusFilter.value || '').toLowerCase();

        let visibleCount = 0;

        getRequestRows().forEach(function (row) {

            const rowText = row.textContent.toLowerCase();

            const statusElement = row.cells[7];

            const rowStatus = statusElement
                ? statusElement.textContent.trim().toLowerCase()
                : '';

            const matchesSearch = !query || rowText.includes(query);
            const matchesStatus = !status || rowStatus === status;

            const visible = matchesSearch && matchesStatus;

            row.hidden = !visible;

            if (visible) {
                visibleCount++;
            }

        });

        resultCount.textContent =
            'Showing ' + visibleCount + ' of ' +
            getRequestRows().length + ' requests';

        updateSelection();
    }

    if (selectAll) {

        selectAll.addEventListener('change', function () {

            getRequestRows().forEach(function (row) {

                if (!row.hidden) {

                    const checkbox = row.querySelector('.request-checkbox');

                    if (checkbox) {
                        checkbox.checked = selectAll.checked;
                    }

                }

            });

            updateSelection();

        });

    }

    tbody.addEventListener('change', function (event) {

        if (event.target.classList.contains('request-checkbox')) {
            updateSelection();
        }

    });

    searchInput.addEventListener('input', filterRequests);
    statusFilter.addEventListener('change', filterRequests);

    clearFiltersBtn.addEventListener('click', function () {

        searchInput.value = '';
        statusFilter.value = '';

        filterRequests();

    });

    /*
     * Bulk deletion is intentionally not submitted to an invented endpoint.
     * Connect this button to your authenticated bulk-delete PHP handler.
     */

    deleteSelectedBtn.addEventListener('click', function () {

        const selected = Array.from(
            tbody.querySelectorAll('.request-checkbox:checked')
        ).map(function (checkbox) {
            return checkbox.value;
        });

        if (selected.length === 0) {
            return;
        }

        alert(
            'You selected ' + selected.length +
            ' request(s). Connect this action to your server-side bulk-delete handler.'
        );

    });

    /*
     * Optional page auto-reload.
     * Keep the user's choice through each page reload in this tab.
     */

    const autoReloadStorageKey = 'requestTableAutoReloadEnabled';
    const autoReloadInterval = 49000;

    function stopRequestAutoReload() {

        if (window.requestAutoReload) {
            window.clearInterval(window.requestAutoReload);
            window.requestAutoReload = null;
        }

    }

    function startRequestAutoReload() {

        stopRequestAutoReload();

        window.requestAutoReload = window.setInterval(function () {
            window.location.reload();
        }, autoReloadInterval);

    }

    try {
        autoReload.checked = sessionStorage.getItem(autoReloadStorageKey) === 'true';
    } catch (error) {
        autoReload.checked = false;
    }

    if (autoReload.checked) {
        startRequestAutoReload();
    }

    autoReload.addEventListener('change', function () {

        if (autoReload.checked) {

            try {
                sessionStorage.setItem(autoReloadStorageKey, 'true');
            } catch (error) {
                /* Auto-reload still works when session storage is unavailable. */
            }

            startRequestAutoReload();

        } else {

            try {
                sessionStorage.removeItem(autoReloadStorageKey);
            } catch (error) {
                /* The reload timer is still stopped when storage is unavailable. */
            }

            stopRequestAutoReload();

        }

    });

    /*
     * Modal helpers
     */

    function openModal(id) {

        const modal = document.getElementById(id);

        modal.classList.add('show');
        modal.setAttribute('aria-hidden', 'false');

        document.body.style.overflow = 'hidden';

    }

    function closeModal(id) {

        const modal = document.getElementById(id);

        modal.classList.remove('show');
        modal.setAttribute('aria-hidden', 'true');

        if (!document.querySelector('.request-modal-overlay.show')) {
            document.body.style.overflow = '';
        }

    }

    window.showComplaintModal = function (subject, complaint) {

        document.getElementById('complaintModalTitle').textContent =
            subject || 'N/A';

        document.getElementById('complaintModalBody').textContent =
            complaint || 'N/A';

        openModal('complaintModal');

    };

    window.closeComplaintModal = function () {
        closeModal('complaintModal');
    };

    window.showCreateRequestModal = function () {
        openModal('createRequestModal');
    };

    window.closeCreateRequestModal = function () {
        closeModal('createRequestModal');
    };

    document.getElementById('createRequestBtn').addEventListener(
        'click',
        function () {
            window.showCreateRequestModal();
        }
    );

    window.showReplyModal = function (
        ticketSn,
        subject,
        status,
        email,
        ticketNo,
        ticketName
    ) {

        document.getElementById('replyTicketSn').value = ticketSn || '';
        document.getElementById('replyTicketEmail').value = email || '';
        document.getElementById('replyTicketNo').value = ticketNo || '';
        document.getElementById('replyTicketName').value = ticketName || '';
        document.getElementById('replyCurrentStatus').value = status || '0';

        document.getElementById('replySubject').textContent =
            subject || 'N/A';

        document.getElementById('replyStatus').value = String(status);

        openModal('replyModal');

    };

    window.closeReplyModal = function () {
        closeModal('replyModal');
    };

    window.showDeleteModal = function (requestSn, ticketNo, tableName) {

        deleteRequestSn = requestSn;
        deleteTableName = tableName;

        document.getElementById('deleteUserName').textContent =
            ticketNo || 'this ticket';

        openModal('deleteModal');

    };

    window.closeDeleteModal = function () {

        closeModal('deleteModal');

        deleteRequestSn = null;
        deleteTableName = null;

    };

    document.getElementById('confirmDeleteBtn').addEventListener(
        'click',
        function () {

            if (
                deleteRequestSn === null ||
                deleteRequestSn === '' ||
                !deleteTableName
            ) {
                return;
            }

            window.location.href =
                'index?action=delete_totalrequest' +
                '&sn=' + encodeURIComponent(deleteRequestSn) +
                '&table_name=' + encodeURIComponent(deleteTableName);

        }
    );

    window.showRestoreModal = function (requestSn, ticketNo, tableName) {

        restoreRequestSn = requestSn;
        restoreTableName = tableName;

        document.getElementById('restoreUserName').textContent =
            ticketNo || 'this ticket';

        openModal('restoreModal');

    };

    window.closeRestoreModal = function () {

        closeModal('restoreModal');

        restoreRequestSn = null;
        restoreTableName = null;

    };

    document.getElementById('confirmRestoreBtn').addEventListener(
        'click',
        function () {

            if (
                restoreRequestSn === null ||
                restoreRequestSn === '' ||
                !restoreTableName
            ) {
                return;
            }

            window.location.href =
                'index?action=restore_totalrequest' +
                '&sn=' + encodeURIComponent(restoreRequestSn) +
                '&table_name=' + encodeURIComponent(restoreTableName);

        }
    );

    document.querySelectorAll('.request-modal-overlay').forEach(
        function (modal) {

            modal.addEventListener('click', function (event) {

                if (event.target !== modal) {
                    return;
                }

                switch (modal.id) {

                    case 'complaintModal':
                        window.closeComplaintModal();
                        break;

                    case 'createRequestModal':
                        window.closeCreateRequestModal();
                        break;

                    case 'replyModal':
                        window.closeReplyModal();
                        break;

                    case 'deleteModal':
                        window.closeDeleteModal();
                        break;

                    case 'restoreModal':
                        window.closeRestoreModal();
                        break;

                }

            });

        }
    );

    document.addEventListener('keydown', function (event) {

        if (event.key !== 'Escape') {
            return;
        }

        if (document.getElementById('complaintModal').classList.contains('show')) {
            window.closeComplaintModal();
        }

        if (document.getElementById('createRequestModal').classList.contains('show')) {
            window.closeCreateRequestModal();
        }

        if (document.getElementById('replyModal').classList.contains('show')) {
            window.closeReplyModal();
        }

        if (document.getElementById('deleteModal').classList.contains('show')) {
            window.closeDeleteModal();
        }

        if (document.getElementById('restoreModal').classList.contains('show')) {
            window.closeRestoreModal();
        }

    });

    filterRequests();

})();

</script>