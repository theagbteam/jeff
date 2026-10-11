<?php

/*
|--------------------------------------------------------------------------
| TRANSFER HISTORY MODULE
|--------------------------------------------------------------------------
| This file is included inside the existing dashboard layout.
| It uses the existing header's theme variables and shared CSS.
|
| Expected data variables:
| $transfer_users          = available users
| $transfer_locations      = available corridor/location records
| $transfer_history        = previous transfer records
| $wellhead_status_counts  = existing status counters
| $TotalNoTickets          = existing total-ticket count, if required
|--------------------------------------------------------------------------
*/

$transfer_users = $transfer_users ?? [];
$transfer_locations = $transfer_locations ?? [];
$transfer_history = $transfer_history ?? [];
$wellhead_status_counts = $wellhead_status_counts ?? [];
$TotalNoTickets = $TotalNoTickets ?? 0;

?>

<style>
/* ============================================================
   TRANSFER HISTORY — EXISTING HEADER THEME
   ============================================================ */

.transfer-history-page {
    width: 100%;
    min-width: 0;
    color: var(--body-text);
}

.transfer-history-card {
    margin: 0 24px 20px;
    padding: 22px 24px;
    border: 1px solid var(--surface-border);
    border-radius: 16px;
    background: var(--surface-bg);
    box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
}

.transfer-history-heading {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 22px;
}

.transfer-history-heading-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 42px;
    height: 42px;
    flex-shrink: 0;
    border: 1px solid rgba(59, 111, 212, .28);
    border-radius: 12px;
    background: rgba(59, 111, 212, .10);
    color: var(--primary-blue);
    font-size: 19px;
}

.transfer-history-heading h5 {
    margin: 0;
    color: var(--body-text);
    font-size: 16px;
    font-weight: 700;
}

.transfer-history-heading p {
    margin: 5px 0 0;
    color: var(--secondary-text);
    font-size: 12px;
    line-height: 1.5;
}

.transfer-history-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}

.transfer-history-toolbar-text {
    color: var(--secondary-text);
    font-size: 12px;
    line-height: 1.6;
}

.transfer-history-open-modal {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 43px;
    padding: 0 19px;
    border: 1px solid #3b6fd4;
    border-radius: 9px;
    background: #3b6fd4;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    transition: background .2s ease, transform .2s ease;
}

.transfer-history-open-modal:hover {
    background: #2f5cb8;
    color: #fff;
    transform: translateY(-1px);
}

.transfer-history-open-modal:focus-visible {
    outline: 3px solid rgba(59, 111, 212, .25);
    outline-offset: 3px;
}

/* ============================================================
   TRANSFER MODAL
   ============================================================ */

.transfer-history-modal {
    position: fixed;
    inset: 0;
    z-index: 10050;
    display: none;
    align-items: center;
    justify-content: center;
    padding: 20px;
    background: rgba(15, 23, 42, .58);
    backdrop-filter: blur(3px);
    -webkit-backdrop-filter: blur(3px);
}

.transfer-history-modal.is-open {
    display: flex;
}

.transfer-history-modal-dialog {
    width: 100%;
    max-width: 760px;
    max-height: calc(100vh - 40px);
    overflow: hidden;
    border: 1px solid var(--surface-border);
    border-radius: 16px;
    background: var(--surface-bg);
    box-shadow: 0 24px 70px rgba(0, 0, 0, .24);
    animation: transferModalAppear .18s ease-out;
}

@keyframes transferModalAppear {
    from {
        opacity: 0;
        transform: translateY(8px) scale(.99);
    }

    to {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}

.transfer-history-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
    padding: 20px 23px;
    border-bottom: 1px solid var(--surface-border);
    background: var(--surface-bg);
}

.transfer-history-modal-title-wrap {
    display: flex;
    align-items: center;
    gap: 12px;
    min-width: 0;
}

.transfer-history-modal-header h5 {
    margin: 0;
    color: var(--body-text);
    font-size: 16px;
    font-weight: 700;
}

.transfer-history-modal-header p {
    margin: 5px 0 0;
    color: var(--secondary-text);
    font-size: 12px;
    line-height: 1.5;
}

.transfer-history-modal-close {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 36px;
    height: 36px;
    flex-shrink: 0;
    border: 1px solid var(--surface-border);
    border-radius: 9px;
    background: var(--surface-soft);
    color: var(--secondary-text);
    font-size: 18px;
    cursor: pointer;
    transition: background .2s ease, color .2s ease;
}

.transfer-history-modal-close:hover {
    background: var(--table-hover-bg);
    color: var(--body-text);
}

.transfer-history-modal-body {
    max-height: calc(100vh - 180px);
    overflow-y: auto;
    padding: 22px 23px;
}

.transfer-history-modal-form {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px 16px;
}

.transfer-history-field {
    min-width: 0;
}

.transfer-history-field.full-width {
    grid-column: 1 / -1;
}

.transfer-history-field label {
    display: block;
    margin-bottom: 8px;
    color: var(--body-text);
    font-size: 12px;
    font-weight: 600;
}

.transfer-history-field label i {
    margin-right: 5px;
    color: var(--primary-blue);
}

.transfer-history-field input,
.transfer-history-field select,
.transfer-history-field textarea {
    display: block;
    width: 100%;
    min-height: 43px;
    padding: 10px 12px;
    border: 1px solid var(--surface-border);
    border-radius: 9px;
    outline: none;
    background-color: var(--surface-soft);
    color: var(--body-text);
    font-family: inherit;
    font-size: 12px;
    transition: border-color .2s ease, box-shadow .2s ease;
}

.transfer-history-field textarea {
    min-height: 95px;
    resize: vertical;
    line-height: 1.6;
}

.transfer-history-field input:focus,
.transfer-history-field select:focus,
.transfer-history-field textarea:focus {
    border-color: var(--primary-blue);
    box-shadow: 0 0 0 3px rgba(59, 111, 212, .12);
}

.transfer-history-field input::placeholder,
.transfer-history-field textarea::placeholder {
    color: var(--secondary-text);
    opacity: .8;
}

.transfer-history-field select option {
    background: var(--surface-bg);
    color: var(--body-text);
}

.transfer-history-modal-footer {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 10px;
    padding: 16px 23px 20px;
    border-top: 1px solid var(--surface-border);
    background: var(--surface-bg);
}

.transfer-history-cancel {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 41px;
    padding: 0 16px;
    border: 1px solid var(--surface-border);
    border-radius: 9px;
    background: var(--surface-soft);
    color: var(--body-text);
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: background .2s ease;
}

.transfer-history-cancel:hover {
    background: var(--table-hover-bg);
}

.transfer-history-submit {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 41px;
    padding: 0 19px;
    border: 1px solid #3b6fd4;
    border-radius: 9px;
    background: #3b6fd4;
    color: #fff;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    transition: background .2s ease, transform .2s ease;
}

.transfer-history-submit:hover {
    background: #2f5cb8;
    color: #fff;
    transform: translateY(-1px);
}

.transfer-history-submit:disabled {
    opacity: .55;
    cursor: not-allowed;
    transform: none;
}

.transfer-history-notice {
    display: none;
    margin-top: 15px;
    padding: 11px 13px;
    border: 1px solid var(--surface-border);
    border-radius: 9px;
    font-size: 12px;
    line-height: 1.5;
}

.transfer-history-notice.visible {
    display: block;
}

.transfer-history-notice.error {
    border-color: rgba(217, 83, 94, .35);
    background: rgba(217, 83, 94, .10);
    color: #c94b56;
}

.transfer-history-notice.success {
    border-color: rgba(0, 210, 87, .30);
    background: rgba(0, 210, 87, .08);
    color: #218653;
}

/* ============================================================
   SUMMARY COUNTERS — ORIGINAL FADED STATUS COLORS
   ============================================================ */

.transfer-history-page .summary-section {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 18px;
    margin: 0 24px 18px;
    padding: 22px 24px;
    border: 1px solid var(--surface-border);
    border-radius: 16px;
    background: var(--surface-bg);
    box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
}

.transfer-history-page .summary-counters {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.transfer-history-page .summary-counter {
    display: inline-flex;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    gap: 8px;
    min-width: 135px;
    min-height: 66px;
    padding: 12px 16px;
    border: 1px solid var(--surface-border);
    border-radius: 12px;
    background: var(--counter-bg);
    color: var(--secondary-text);
    font-size: 11px;
    white-space: nowrap;
}

.transfer-history-page .summary-counter strong {
    color: var(--body-text);
    font-size: 22px;
    font-weight: 700;
}

.transfer-history-page .summary-counter.wellhead-status {
    border-color: var(--status-border);
    background: var(--status-bg);
}

.transfer-history-page .summary-counter.wellhead-status span,
.transfer-history-page .summary-counter.wellhead-status strong {
    color: var(--status-color);
}

.transfer-history-page .summary-counter.wellhead-status span {
    font-weight: 600;
}

:root[data-theme="dark"] .transfer-history-page .summary-counter {
    background: rgba(255, 255, 255, .025);
}

/* ============================================================
   SUMMARY ACTIONS — PRESERVED
   ============================================================ */

.transfer-history-page .summary-actions {
    display: flex;
    align-items: center;
    gap: 14px;
    flex-wrap: wrap;
    margin-left: auto;
}

.transfer-history-page .btn-delete-selected {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    height: 38px;
    padding: 0 16px;
    border: 1px solid #e2b8be;
    border-radius: 10px;
    background: #fdf0f1;
    color: #b8454f;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    transition: background .2s ease, border-color .2s ease;
}

.transfer-history-page .btn-delete-selected:hover:not(:disabled) {
    border-color: #d9535e;
    background: #f8d7da;
    color: #9a2e36;
}

.transfer-history-page .btn-delete-selected:disabled {
    opacity: .45;
    cursor: not-allowed;
    background: var(--surface-soft);
    border-color: var(--surface-border);
    color: var(--secondary-text);
}

:root[data-theme="dark"] .transfer-history-page .btn-delete-selected {
    border-color: #75404e;
    background: #351e2a;
    color: #ff9aa6;
}

.transfer-history-page .btn-view-all {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    height: 38px;
    padding: 0 16px;
    border: 1px solid var(--surface-border);
    border-radius: 10px;
    background: var(--surface-soft);
    color: var(--body-text);
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    cursor: pointer;
    transition: background .2s ease, border-color .2s ease;
}

.transfer-history-page .btn-view-all:hover {
    border-color: var(--primary-blue);
    background: var(--table-hover-bg);
    color: var(--primary-blue);
}

.transfer-history-page .auto-reload {
    display: flex;
    align-items: center;
    gap: 5px;
    color: var(--secondary-text);
    font-size: 12px;
    white-space: nowrap;
    cursor: pointer;
    user-select: none;
}

.transfer-history-page .auto-reload input {
    width: 16px;
    height: 16px;
    margin: 0;
    accent-color: var(--primary-blue);
    cursor: pointer;
}

/* ============================================================
   TRANSFER HISTORY TABLE
   ============================================================ */

.transfer-history-page .table-container {
    margin: 0 24px 28px;
    padding: 16px 20px 20px;
    overflow-x: auto;
    overflow-y: hidden;
    border: 1px solid var(--surface-border);
    border-radius: 16px;
    background: var(--surface-bg);
    box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    -webkit-overflow-scrolling: touch;
}

.transfer-history-page table.ticket-table {
    width: 100% !important;
    min-width: 1120px;
    margin: 0 !important;
    border-collapse: collapse !important;
}

.transfer-history-page .ticket-table th {
    height: 50px;
    padding: 12px;
    border-bottom: 1px solid var(--surface-border);
    background: var(--table-head-bg);
    color: var(--secondary-text);
    font-size: 10px;
    font-weight: 700;
    letter-spacing: .45px;
    text-align: left;
    text-transform: uppercase;
    vertical-align: middle;
    white-space: nowrap;
}

.transfer-history-page .ticket-table td {
    padding: 15px 12px;
    border-bottom: 1px solid var(--surface-border);
    background: var(--table-cell-bg);
    color: var(--body-text);
    font-size: 12px;
    line-height: 1.6;
    vertical-align: middle;
    overflow-wrap: anywhere;
}

.transfer-history-page .ticket-table tbody tr:hover td {
    background: var(--table-hover-bg);
}

.transfer-history-page .ticket-table .sort-icon {
    margin-left: 5px;
    color: var(--secondary-text);
    font-size: 8px;
}

.transfer-history-page .ticket-table .id-cell {
    width: 65px;
    text-align: center;
}

.transfer-history-page .ticket-table .center-cell {
    text-align: center;
    vertical-align: middle;
}

.transfer-history-page .transfer-location-label {
    display: inline-block;
    padding: 5px 9px;
    border: 1px solid rgba(59, 111, 212, .28);
    border-radius: 6px;
    background: rgba(59, 111, 212, .10);
    color: var(--link-color);
    font-size: 11px;
    font-weight: 600;
}

.transfer-history-page .transfer-status-label {
    display: inline-block;
    padding: 5px 9px;
    border: 1px solid rgba(59, 111, 212, .25);
    border-radius: 6px;
    background: rgba(59, 111, 212, .09);
    color: var(--link-color);
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.transfer-history-page .transfer-empty-state {
    padding: 36px 15px !important;
    color: var(--secondary-text) !important;
    text-align: center;
}

.transfer-history-page .transfer-empty-state i {
    display: block;
    margin-bottom: 9px;
    font-size: 25px;
    opacity: .65;
}

/* ============================================================
   DATATABLES — MATCH THE EXISTING HEADER
   ============================================================ */

.transfer-history-page .dataTables_wrapper .dataTables_filter {
    margin-bottom: 14px;
    font-size: 12px;
    text-align: right;
}

.transfer-history-page .dataTables_wrapper .dataTables_filter label {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
    margin: 0;
    color: var(--secondary-text);
    font-weight: 500;
}

.transfer-history-page .dataTables_wrapper .dataTables_filter input {
    width: 240px;
    padding: 7px 12px;
    border: 1px solid var(--surface-border);
    border-radius: 8px;
    background: var(--surface-soft);
    color: var(--body-text);
    font-size: 12px;
}

.transfer-history-page .dataTables_wrapper .dataTables_length {
    margin-bottom: 14px;
    color: var(--secondary-text);
    font-size: 12px;
}

.transfer-history-page .dataTables_wrapper .dataTables_length select {
    margin: 0 4px;
    padding: 6px 10px;
    border: 1px solid var(--surface-border);
    border-radius: 8px;
    background: var(--surface-soft);
    color: var(--body-text);
    font-size: 12px;
}

.transfer-history-page .dataTables_wrapper .dataTables_info {
    padding-top: 12px;
    color: var(--secondary-text);
    font-size: 12px;
}

.transfer-history-page .dataTables_wrapper .dataTables_paginate {
    margin-top: 12px;
    padding-top: 12px;
}

.transfer-history-page .dataTables_wrapper .dataTables_paginate .paginate_button {
    margin: 0 3px;
    padding: 5px 11px !important;
    border: 1px solid var(--surface-border) !important;
    border-radius: 8px !important;
    background: var(--surface-soft) !important;
    color: var(--body-text) !important;
    font-size: 12px;
}

.transfer-history-page .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    border-color: #3b6fd4 !important;
    background: #3b6fd4 !important;
    color: #fff !important;
}

.transfer-history-page .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    border-color: var(--surface-border) !important;
    background: var(--table-hover-bg) !important;
    color: var(--body-text) !important;
}

@media (max-width: 991.98px) {
    .transfer-history-page .transfer-history-card {
        margin: 0 12px 16px;
        padding: 18px;
    }

    .transfer-history-page .summary-section {
        align-items: flex-start;
        margin: 0 12px 14px;
        padding: 16px;
    }

    .transfer-history-page .summary-counters {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .transfer-history-page .summary-counter {
        min-width: 0;
    }

    .transfer-history-page .summary-actions {
        margin-left: 0;
    }

    .transfer-history-page .table-container {
        margin: 0 12px 18px;
        padding: 12px 14px 16px;
    }
}

@media (max-width: 767.98px) {
    .transfer-history-page .summary-section {
        flex-direction: column;
        gap: 12px;
        padding: 16px;
    }

    .transfer-history-page .summary-counters {
        width: 100%;
        gap: 8px;
    }

    .transfer-history-page .summary-counter {
        min-height: 56px;
        padding: 8px 12px;
        font-size: 10px;
    }

    .transfer-history-page .summary-counter strong {
        font-size: 18px;
    }

    .transfer-history-page .summary-actions {
        width: 100%;
        justify-content: flex-start;
        gap: 8px;
    }

    .transfer-history-page .table-container {
        padding: 10px 12px 14px;
    }

    .transfer-history-page .dataTables_wrapper .dataTables_filter {
        text-align: left;
    }

    .transfer-history-page .dataTables_wrapper .dataTables_filter label {
        justify-content: flex-start;
        flex-wrap: wrap;
    }

    .transfer-history-page .dataTables_wrapper .dataTables_filter input {
        width: 100%;
        max-width: 100%;
    }

    .transfer-history-modal {
        padding: 12px;
    }

    .transfer-history-modal-dialog {
        max-height: calc(100vh - 24px);
    }

    .transfer-history-modal-body {
        max-height: calc(100vh - 165px);
        padding: 18px;
    }

    .transfer-history-modal-header {
        padding: 16px 18px;
    }

    .transfer-history-modal-footer {
        padding: 14px 18px 18px;
    }
}

@media (max-width: 480px) {
    .transfer-history-page .transfer-history-card {
        margin: 0 7px 12px;
        padding: 14px;
    }

    .transfer-history-page .transfer-history-toolbar {
        align-items: stretch;
        flex-direction: column;
    }

    .transfer-history-page .transfer-history-open-modal {
        width: 100%;
    }

    .transfer-history-page .summary-section {
        margin: 0 7px 12px;
        padding: 12px;
    }

    .transfer-history-page .summary-counters {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .transfer-history-page .summary-counter {
        min-height: 50px;
        padding: 8px;
        font-size: 9px;
    }

    .transfer-history-page .summary-counter strong {
        font-size: 16px;
    }

    .transfer-history-page .summary-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .transfer-history-page .btn-delete-selected,
    .transfer-history-page .btn-view-all {
        justify-content: center;
        width: 100%;
    }

    .transfer-history-page .auto-reload {
        justify-content: center;
    }

    .transfer-history-page .table-container {
        margin: 0 7px 12px;
        padding: 8px 10px 12px;
    }

    .transfer-history-modal-form {
        grid-template-columns: minmax(0, 1fr);
        gap: 14px;
    }

    .transfer-history-field.full-width {
        grid-column: auto;
    }

    .transfer-history-modal-header h5 {
        font-size: 14px;
    }

    .transfer-history-modal-footer {
        flex-direction: column-reverse;
        align-items: stretch;
    }

    .transfer-history-cancel,
    .transfer-history-modal-footer .transfer-history-submit {
        width: 100%;
    }
}
</style>

<div class="transfer-history-page">

    <!-- ========================================================
         TRANSFER HISTORY HEADER AND MODAL TRIGGER
         ======================================================== -->

    <section class="transfer-history-card">

        <div class="transfer-history-heading">

            <div class="transfer-history-heading-icon">
                <i class="bi bi-arrow-left-right"></i>
            </div>

            <div>
                <h5>Transfer History</h5>
                <p>Initiate user transfers and review previously recorded transfers.</p>
            </div>

        </div>

        <div class="transfer-history-toolbar">

            <div class="transfer-history-toolbar-text">
                Use the button to record a user transfer, including the source corridor,
                destination corridor, expected resumption date and reason.
            </div>

            <button
                type="button"
                class="transfer-history-open-modal"
                id="openTransferModal"
            >
                <i class="bi bi-arrow-left-right"></i>
                Transfer User
            </button>

        </div>

    </section>

    <!-- ========================================================
         TRANSFER USER MODAL
         ======================================================== -->

    <div
        class="transfer-history-modal"
        id="transferHistoryModal"
        aria-hidden="true"
    >

        <div
            class="transfer-history-modal-dialog"
            role="dialog"
            aria-modal="true"
            aria-labelledby="transferHistoryModalTitle"
        >

            <div class="transfer-history-modal-header">

                <div class="transfer-history-modal-title-wrap">

                    <div class="transfer-history-heading-icon">
                        <i class="bi bi-person-arrows"></i>
                    </div>

                    <div>
                        <h5 id="transferHistoryModalTitle">Transfer User</h5>
                        <p>Complete all seven fields to record the transfer details.</p>
                    </div>

                </div>

                <button
                    type="button"
                    class="transfer-history-modal-close"
                    id="closeTransferModal"
                    aria-label="Close transfer form"
                >
                    <i class="bi bi-x-lg"></i>
                </button>

            </div>

            <div class="transfer-history-modal-body">

                <form
                    id="transferUserForm"
                    method="POST"
                    action=""
                    autocomplete="off"
                >

                    <div class="transfer-history-modal-form">

                        <!-- 1. User Transferred -->

                        <div class="transfer-history-field">

                            <label for="transfer_userid">
                                <i class="bi bi-person"></i>
                                Employee
                            </label>

                            <select
                                name="transfer_userid"
                                id="transfer_userid"
                                required
                            >

                                <option value="">Select a user</option>

                                <?php foreach ($transfer_users as $transfer_user): ?>

                                    <?php
                                        $transfer_user_id = (string) (
                                            $transfer_user['userid']
                                            ?? $transfer_user['user_id']
                                            ?? ''
                                        );

                                        $transfer_user_name = (string) (
                                            $transfer_user['full_name']
                                            ?? $transfer_user['name']
                                            ?? $transfer_user['userid']
                                            ?? $transfer_user['user_id']
                                            ?? ''
                                        );
                                    ?>

                                    <option
                                        value="<?= htmlspecialchars(
                                            $transfer_user_id,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                    >
                                        <?= htmlspecialchars(
                                            $transfer_user_name,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                        <!-- 2. From Corridor -->

                        <div class="transfer-history-field">

                            <label for="from_corridor">
                                <i class="bi bi-geo-alt"></i>
                                Destination Corridor
                            </label>

                            <select
                                name="from_corridor"
                                id="from_corridor"
                                required
                            >

                                <option value="">Select source corridor</option>

                                <?php foreach ($transfer_locations as $location): ?>

                                    <?php
                                        $location_id = (string) (
                                            $location['sn']
                                            ?? $location['id']
                                            ?? $location['corridor_id']
                                            ?? ''
                                        );

                                        $location_name = (string) (
                                            $location['name']
                                            ?? $location['location_name']
                                            ?? $location['corridor_name']
                                            ?? ''
                                        );
                                    ?>

                                    <option
                                        value="<?= htmlspecialchars(
                                            $location_id,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                    >
                                        <?= htmlspecialchars(
                                            $location_name,
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>
                                    </option>

                                <?php endforeach; ?>

                            </select>

                        </div>

                       
                       <div class="transfer-history-field">

                             <label for="transfer_initiated_by">
                                <i class="bi bi-person-check"></i>
                                Transfer type
                            </label>

                            <select  name="trasnsfer_type" id="from_corridor" required  >

                                <option value="">Select transfer type</option>
                                <option value="Official transfer">Official transfer</option>
                                <option value="Based on request">Based on request</option>

                                 
                            </select>

                        </div>

                        
                        <!-- 6. Expected Resumption Date -->

                        <div class="transfer-history-field">

                            <label for="expected_resumption_date">
                                <i class="bi bi-calendar-check"></i>
                                Expected Resumption Date
                            </label>

                            <input
                                type="date"
                                name="expected_resumption_date"
                                id="expected_resumption_date"
                                required
                            >

                        </div>

                        <!-- 7. Reason -->

                        <div class="transfer-history-field full-width">

                            <label for="transfer_reason">
                                <i class="bi bi-chat-left-text"></i>
                                Reason
                            </label>

                            <textarea
                                name="reason"
                                id="transfer_reason"
                                placeholder="Enter the reason for this transfer"
                                maxlength="5000"
                                required
                            ></textarea>

                        </div>

                    </div>

                    <div
                        id="transferHistoryNotice"
                        class="transfer-history-notice"
                        role="status"
                        aria-live="polite"
                    ></div>

                    <div class="transfer-history-modal-footer">

                        <button
                            type="button"
                            class="transfer-history-cancel"
                            id="cancelTransferModal"
                        >
                            <i class="bi bi-x-circle"></i>
                            Cancel
                        </button>

                        <button
                            type="submit"
                            class="transfer-history-submit"
                            id="submitTransferBtn"
                            name="transfer_user_action"
                            value="transfer"
                        >
                            <i class="bi bi-arrow-left-right"></i>
                            Submit Transfer
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

    <!-- ========================================================
         EXISTING SUMMARY SECTION
         ======================================================== -->

    <!-- Your existing summary section can remain here unchanged. -->

    <!-- ========================================================
         TRANSFER HISTORY TABLE
         ======================================================== -->

    <div class="table-container">

        <table class="ticket-table" id="ticketsTable">

            <thead>

                <tr>

                    <th class="id-cell">
                        S/N
                        <i class="bi bi-arrow-down-up sort-icon"></i>
                    </th>

                    <th>
                        User Transferred
                        <i class="bi bi-arrow-down-up sort-icon"></i>
                    </th>

                    <th>
                        From Corridor
                        <i class="bi bi-arrow-down-up sort-icon"></i>
                    </th>

                    <th>
                        To Corridor
                        <i class="bi bi-arrow-down-up sort-icon"></i>
                    </th>

                    <th>
                        Transfer Initiated By
                        <i class="bi bi-arrow-down-up sort-icon"></i>
                    </th>

                    <th>
                        Date Transferred
                        <i class="bi bi-arrow-down-up sort-icon"></i>
                    </th>

                    <th>
                        Expected Resumption Date
                        <i class="bi bi-arrow-down-up sort-icon"></i>
                    </th>

                    <th>
                        Reason
                        <i class="bi bi-arrow-down-up sort-icon"></i>
                    </th>

                    <th>
                        Status
                        <i class="bi bi-arrow-down-up sort-icon"></i>
                    </th>

                </tr>

            </thead>

            <tbody>

                <?php if (!empty($transfer_history)): ?>

                    <?php $transfer_serial = 0; ?>

                    <?php foreach ($transfer_history as $transfer): ?>

                        <?php
                            $transfer_serial++;

                            $history_user = (string) (
                                $transfer['user_transfered']
                                ?? $transfer['user_transferred']
                                ?? $transfer['user_name']
                                ?? $transfer['full_name']
                                ?? $transfer['userid']
                                ?? ''
                            );

                            $previous_location = (string) (
                                $transfer['from_corridor']
                                ?? $transfer['previous_location']
                                ?? $transfer['old_corridor']
                                ?? ''
                            );

                            $new_location = (string) (
                                $transfer['to_corridor']
                                ?? $transfer['new_location']
                                ?? $transfer['destination_corridor']
                                ?? ''
                            );

                            $transferred_by = (string) (
                                $transfer['transfer_initiated_by']
                                ?? $transfer['transferred_by']
                                ?? $transfer['initiated_by']
                                ?? ''
                            );

                            $transfer_date = (string) (
                                $transfer['date_transferred']
                                ?? $transfer['date_created']
                                ?? $transfer['date']
                                ?? ''
                            );

                            $expected_resumption_date = (string) (
                                $transfer['expected_resumption_date']
                                ?? $transfer['expected_resumption']
                                ?? ''
                            );

                            $transfer_reason = (string) (
                                $transfer['reason']
                                ?? $transfer['transfer_reason']
                                ?? ''
                            );

                            $transfer_status = (string) (
                                $transfer['status']
                                ?? 'Pending'
                            );

                            if ($transfer_status === '') {
                                $transfer_status = 'Pending';
                            }
                        ?>

                        <tr>

                            <!-- Sequential S/N, not the database ID -->

                            <td class="id-cell center-cell">
                                <?= $transfer_serial ?>
                            </td>

                            <!-- User Transferred -->

                            <td>
                                <?= htmlspecialchars(
                                    $history_user,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <!-- From Corridor -->

                            <td>
                                <?= htmlspecialchars(
                                    $previous_location,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <!-- To Corridor -->

                            <td>
                                <span class="transfer-location-label">
                                    <?= htmlspecialchars(
                                        $new_location,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </span>
                            </td>

                            <!-- Transfer Initiated By -->

                            <td>
                                <?= htmlspecialchars(
                                    $transferred_by,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <!-- Date Transferred -->

                            <td>
                                <?= htmlspecialchars(
                                    $transfer_date,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <!-- Expected Resumption Date -->

                            <td>
                                <?= htmlspecialchars(
                                    $expected_resumption_date,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <!-- Reason -->

                            <td>
                                <?= htmlspecialchars(
                                    $transfer_reason,
                                    ENT_QUOTES,
                                    'UTF-8'
                                ) ?>
                            </td>

                            <!-- Status -->

                            <td>
                                <span class="transfer-status-label">
                                    <?= htmlspecialchars(
                                        $transfer_status,
                                        ENT_QUOTES,
                                        'UTF-8'
                                    ) ?>
                                </span>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

</div>

<script>
(function () {
    'use strict';

    const root = document.querySelector('.transfer-history-page');

    if (!root) {
        return;
    }

    const modal = root.querySelector('#transferHistoryModal');
    const openModalBtn = root.querySelector('#openTransferModal');
    const closeModalBtn = root.querySelector('#closeTransferModal');
    const cancelModalBtn = root.querySelector('#cancelTransferModal');

    const transferForm = root.querySelector('#transferUserForm');
    const transferUser = root.querySelector('#transfer_userid');
    const fromCorridor = root.querySelector('#from_corridor');
    const toCorridor = root.querySelector('#to_corridor');
    const transferInitiatedBy = root.querySelector('#transfer_initiated_by');
    const dateTransferred = root.querySelector('#date_transferred');
    const expectedResumptionDate = root.querySelector('#expected_resumption_date');
    const transferReason = root.querySelector('#transfer_reason');

    const transferNotice = root.querySelector('#transferHistoryNotice');
    const submitTransferBtn = root.querySelector('#submitTransferBtn');

    let previousBodyOverflow = '';

    function showNotice(message, type) {
        if (!transferNotice) {
            return;
        }

        transferNotice.textContent = message;
        transferNotice.className =
            'transfer-history-notice visible ' + type;
    }

    function clearNotice() {
        if (!transferNotice) {
            return;
        }

        transferNotice.textContent = '';
        transferNotice.className = 'transfer-history-notice';
    }

    function openModal() {
        if (!modal) {
            return;
        }

        previousBodyOverflow = document.body.style.overflow;

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';

        clearNotice();

        if (transferUser) {
            window.setTimeout(function () {
                transferUser.focus();
            }, 50);
        }
    }

    function closeModal() {
        if (!modal) {
            return;
        }

        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = previousBodyOverflow;

        if (openModalBtn) {
            openModalBtn.focus();
        }
    }

    if (openModalBtn) {
        openModalBtn.addEventListener('click', openModal);
    }

    if (closeModalBtn) {
        closeModalBtn.addEventListener('click', closeModal);
    }

    if (cancelModalBtn) {
        cancelModalBtn.addEventListener('click', closeModal);
    }

    if (modal) {
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    document.addEventListener('keydown', function (event) {
        if (
            event.key === 'Escape' &&
            modal &&
            modal.classList.contains('is-open')
        ) {
            closeModal();
        }
    });

    /*
     * Prevent choosing the same corridor as both source and destination.
     * This is client-side validation only; the controller must validate it too.
     */
    function validateCorridors() {
        if (
            fromCorridor &&
            toCorridor &&
            fromCorridor.value !== '' &&
            toCorridor.value !== '' &&
            fromCorridor.value === toCorridor.value
        ) {
            toCorridor.setCustomValidity(
                'The source and destination corridors must be different.'
            );

            return false;
        }

        if (toCorridor) {
            toCorridor.setCustomValidity('');
        }

        return true;
    }

    if (fromCorridor) {
        fromCorridor.addEventListener('change', validateCorridors);
    }

    if (toCorridor) {
        toCorridor.addEventListener('change', validateCorridors);
    }

    /*
     * Set today's date as the minimum expected resumption date.
     * The selected transfer date is also used to prevent an earlier
     * expected resumption date.
     */
    function updateResumptionMinimum() {
        if (!expectedResumptionDate) {
            return;
        }

        let minimumDate = '';

        if (dateTransferred && dateTransferred.value) {
            minimumDate = dateTransferred.value.substring(0, 10);
        } else {
            const now = new Date();

            minimumDate =
                now.getFullYear() + '-' +
                String(now.getMonth() + 1).padStart(2, '0') + '-' +
                String(now.getDate()).padStart(2, '0');
        }

        expectedResumptionDate.min = minimumDate;

        if (
            expectedResumptionDate.value &&
            expectedResumptionDate.value < minimumDate
        ) {
            expectedResumptionDate.setCustomValidity(
                'The expected resumption date cannot be earlier than the transfer date.'
            );
        } else {
            expectedResumptionDate.setCustomValidity('');
        }
    }

    if (dateTransferred) {
        dateTransferred.addEventListener('change', updateResumptionMinimum);
    }

    if (expectedResumptionDate) {
        expectedResumptionDate.addEventListener('change', updateResumptionMinimum);
    }

    if (transferForm) {
        transferForm.addEventListener('submit', function (event) {
            clearNotice();

            if (!validateCorridors()) {
                event.preventDefault();

                showNotice(
                    'The source and destination corridors must be different.',
                    'error'
                );

                if (toCorridor) {
                    toCorridor.focus();
                }

                return;
            }

            updateResumptionMinimum();

            if (
                !transferUser ||
                !transferUser.value ||
                !fromCorridor ||
                !fromCorridor.value ||
                !toCorridor ||
                !toCorridor.value ||
                !transferInitiatedBy ||
                !transferInitiatedBy.value.trim() ||
                !dateTransferred ||
                !dateTransferred.value ||
                !expectedResumptionDate ||
                !expectedResumptionDate.value ||
                !transferReason ||
                !transferReason.value.trim()
            ) {
                event.preventDefault();

                showNotice(
                    'Complete all seven fields before submitting the transfer.',
                    'error'
                );

                return;
            }

            if (
                expectedResumptionDate.value <
                dateTransferred.value.substring(0, 10)
            ) {
                event.preventDefault();

                showNotice(
                    'The expected resumption date cannot be earlier than the transfer date.',
                    'error'
                );

                expectedResumptionDate.focus();

                return;
            }

            /*
             * This validates the form only.
             * The parent controller must process the transfer securely,
             * verify permissions, and save the submitted fields to the database.
             */
            if (submitTransferBtn) {
                submitTransferBtn.disabled = true;
                submitTransferBtn.innerHTML =
                    '<i class="bi bi-arrow-repeat"></i> Processing...';
            }
        });
    }

    /*
     * Initialize DataTables only if the shared layout has loaded it.
     * Avoid reinitializing a table initialized elsewhere.
     *
     * An empty tbody is intentional: DataTables displays the empty-table
     * message itself, preventing incorrect column-count warnings.
     */
    if (
        window.jQuery &&
        window.jQuery.fn &&
        window.jQuery.fn.DataTable &&
        !window.jQuery.fn.DataTable.isDataTable('#ticketsTable')
    ) {
        window.jQuery('#ticketsTable').DataTable({
            pageLength: 10,

            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],

            searching: true,
            ordering: true,
            paging: true,
            info: true,
            autoWidth: false,
            order: [],

            columnDefs: [
                {
                    targets: 0,
                    searchable: false
                }
            ],

            language: {
                emptyTable: 'No transfer history records found.',
                zeroRecords: 'No matching transfer history found.',
                search: 'Search:',
                lengthMenu: 'Show _MENU_ records',
                info: 'Showing _START_ to _END_ of _TOTAL_ transfers',
                infoEmpty: 'Showing 0 to 0 of 0 transfers',
                paginate: {
                    previous: 'Previous',
                    next: 'Next'
                }
            }
        });
    }

})();
</script>