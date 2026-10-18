
<style>
    .transfer-history-card {
        background: var(--surface-bg, #fff);
        border: 1px solid var(--surface-border, #dfe3ea);
        border-radius: 14px;
        padding: 22px;
        margin-bottom: 24px;
        color: var(--body-text, #2c3545);
        box-shadow: 0 4px 18px rgba(20, 40, 80, .04);
        min-width: 0;
    }

    .transfer-history-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        margin-bottom: 20px;
    }

    .transfer-history-title {
        margin: 0;
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--body-text, #2c3545);
    }

    .transfer-history-subtitle {
        margin: 5px 0 0;
        font-size: .88rem;
        color: var(--muted-text, #6b7280);
    }

    .transfer-history-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        border: 0;
        border-radius: 9px;
        padding: 11px 17px;
        background: var(--primary-blue, #3b6fd4);
        color: #fff;
        font-weight: 600;
        transition: opacity .2s ease, transform .2s ease;
    }

    .transfer-history-btn:hover {
        color: #fff;
        opacity: .92;
        transform: translateY(-1px);
    }

    .transfer-history-table-wrap {
        width: 100%;
        max-width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    #transferHistoryTable {
        width: 100% !important;
        min-width: 1100px;
        border-collapse: collapse;
        color: var(--body-text, #2c3545);
        font-size: .9rem;
        table-layout: fixed;
        margin-bottom: 0;
        background: var(--surface-bg, #fff);
        --bs-table-color: var(--body-text, #2c3545);
        --bs-table-bg: var(--surface-bg, #fff);
        --bs-table-border-color: var(--surface-border, #dfe3ea);
        --bs-table-hover-color: var(--body-text, #2c3545);
        --bs-table-hover-bg: var(--table-hover-bg, #e8eef9);
    }

    #transferHistoryTable thead th {
        background: var(--table-head-bg, #eaedf3) !important;
        color: var(--body-text, #2c3545) !important;
        font-weight: 700;
        white-space: nowrap;
        border-bottom: 1px solid var(--surface-border, #dfe3ea);
        padding: 13px 12px;
    }

    #transferHistoryTable tbody td {
        padding: 13px 12px;
        vertical-align: middle;
        border-bottom: 1px solid var(--surface-border, #dfe3ea);
        background-color: var(--surface-bg, #fff);
        color: var(--body-text, #2c3545);
        word-wrap: break-word;
        overflow-wrap: break-word;
        white-space: normal;
    }

    #transferHistoryTable tbody tr:hover td {
        background: var(--table-hover-bg, #e8eef9) !important;
        color: var(--body-text, #2c3545) !important;
    }

    #transferHistoryTable th:nth-child(1),
    #transferHistoryTable td:nth-child(1) { width: 55px; }

    #transferHistoryTable th:nth-child(2),
    #transferHistoryTable td:nth-child(2) { width: 120px; }

    #transferHistoryTable th:nth-child(3),
    #transferHistoryTable td:nth-child(3) { width: 140px; }

    #transferHistoryTable th:nth-child(4),
    #transferHistoryTable td:nth-child(4) { width: 150px; }

    #transferHistoryTable th:nth-child(5),
    #transferHistoryTable td:nth-child(5) { width: 130px; }

    #transferHistoryTable th:nth-child(6),
    #transferHistoryTable td:nth-child(6) { width: 130px; }

    #transferHistoryTable th:nth-child(7),
    #transferHistoryTable td:nth-child(7) { width: 150px; }

    #transferHistoryTable th:nth-child(8),
    #transferHistoryTable td:nth-child(8) { width: 150px; }

    #transferHistoryTable th:nth-child(9),
    #transferHistoryTable td:nth-child(9) { width: 180px; }

    .transfer-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        border-radius: 30px;
        padding: 5px 10px;
        font-size: .78rem;
        font-weight: 700;
        white-space: nowrap;
        background: rgba(59, 111, 212, .10);
        color: var(--primary-blue, #3b6fd4);
    }

    .transfer-status::before {
        content: "";
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .transfer-status.completed {
        color: #16835d;
        background: rgba(22, 131, 93, .10);
    }

    .transfer-status.pending {
        color: #b7791f;
        background: rgba(220, 160, 40, .12);
    }

    .transfer-status.cancelled,
    .transfer-status.rejected {
        color: #d64545;
        background: rgba(214, 69, 69, .10);
    }

    .transfer-actions {
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .transfer-actions .btn {
        border-radius: 7px;
        padding: 5px 9px;
        font-size: .78rem;
        font-weight: 600;
        line-height: 1;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }

    .transfer-modal .modal-content {
        background: var(--surface-bg, #fff);
        color: var(--body-text, #2c3545);
        border: 1px solid var(--surface-border, #dfe3ea);
        border-radius: 15px;
        overflow: hidden;
    }

    .transfer-modal .modal-header {
        border-bottom: 1px solid var(--surface-border, #dfe3ea);
        padding: 20px 24px;
    }

    .transfer-modal .modal-body {
        padding: 24px;
    }

    .transfer-modal .modal-footer {
        border-top: 1px solid var(--surface-border, #dfe3ea);
        padding: 16px 24px;
    }

    .transfer-modal .form-label {
        font-size: .88rem;
        font-weight: 600;
        margin-bottom: 7px;
        color: var(--body-text, #2c3545);
    }

    .transfer-modal .form-control,
    .transfer-modal .form-select {
        min-height: 44px;
        border: 1px solid var(--surface-border, #dfe3ea);
        border-radius: 9px;
        background-color: var(--input-bg, var(--surface-bg, #fff));
        color: var(--body-text, #2c3545);
    }

    .transfer-modal textarea.form-control {
        min-height: 100px;
    }

    .transfer-modal .form-control:focus,
    .transfer-modal .form-select:focus {
        border-color: var(--primary-blue, #3b6fd4);
        box-shadow: 0 0 0 .2rem rgba(59, 111, 212, .12);
    }

    .transfer-modal .btn {
        border-radius: 9px;
        font-weight: 600;
        padding: 10px 17px;
    }

    #transferHistoryTable_wrapper {
        width: 100%;
        max-width: 100%;
        color: var(--body-text, #2c3545);
    }

    #transferHistoryTable_wrapper .dt-top,
    #transferHistoryTable_wrapper .dt-bottom {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin: 12px 0;
        color: var(--body-text, #2c3545);
    }

    #transferHistoryTable_wrapper .dataTables_length,
    #transferHistoryTable_wrapper .dataTables_filter,
    #transferHistoryTable_wrapper .dataTables_info,
    #transferHistoryTable_wrapper .dataTables_paginate {
        color: var(--body-text, #2c3545) !important;
        font-size: .88rem;
    }

    #transferHistoryTable_wrapper .dataTables_filter input,
    #transferHistoryTable_wrapper .dataTables_length select {
        background: var(--surface-bg, #fff) !important;
        color: var(--body-text, #2c3545) !important;
        border: 1px solid var(--surface-border, #dfe3ea) !important;
        border-radius: 7px;
        padding: 6px 9px;
        margin-left: 6px;
    }

    #transferHistoryTable_wrapper .dataTables_filter input:focus,
    #transferHistoryTable_wrapper .dataTables_length select:focus {
        border-color: var(--primary-blue, #3b6fd4) !important;
        outline: none;
        box-shadow: 0 0 0 .15rem rgba(59, 111, 212, .15);
    }

    #transferHistoryTable_wrapper .dt-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 7px;
    }

    #transferHistoryTable_wrapper .dt-buttons .dt-button {
        border: 1px solid var(--surface-border, #dfe3ea);
        border-radius: 7px;
        padding: 7px 11px;
        background: var(--surface-bg, #fff);
        color: var(--body-text, #2c3545);
        font-size: .83rem;
    }

    #transferHistoryTable_wrapper .dt-buttons .dt-button:hover {
        background: var(--primary-blue, #3b6fd4);
        border-color: var(--primary-blue, #3b6fd4);
        color: #fff;
    }

    #transferHistoryTable_wrapper .dataTables_paginate .paginate_button {
        color: var(--body-text, #2c3545) !important;
        border: 1px solid transparent;
        background: transparent;
    }

    #transferHistoryTable_wrapper .dataTables_paginate .paginate_button:hover {
        color: #fff !important;
        background: var(--primary-blue, #3b6fd4) !important;
        border-color: var(--primary-blue, #3b6fd4) !important;
    }

    #transferHistoryTable_wrapper .dataTables_paginate .paginate_button.current,
    #transferHistoryTable_wrapper .dataTables_paginate .paginate_button.current:hover {
        color: #fff !important;
        background: var(--primary-blue, #3b6fd4) !important;
        border-color: var(--primary-blue, #3b6fd4) !important;
    }

    #transferHistoryTable_wrapper .dataTables_paginate .paginate_button.disabled,
    #transferHistoryTable_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        color: var(--muted-text, #6b7280) !important;
        background: transparent !important;
        border-color: transparent !important;
        cursor: default;
    }

    @media (max-width: 767px) {
        .transfer-history-card {
            padding: 15px;
        }

        .transfer-history-header {
            align-items: stretch;
        }

        .transfer-history-btn {
            width: 100%;
        }

        .transfer-modal .modal-body {
            padding: 18px;
        }

        #transferHistoryTable_wrapper .dt-top,
        #transferHistoryTable_wrapper .dt-bottom {
            align-items: stretch;
            flex-direction: column;
        }

        #transferHistoryTable_wrapper .dataTables_filter input {
            max-width: 100%;
        }
    }
</style>

<div class="row">
    <div class="col-12">
        <div class="transfer-history-card">

            <div class="transfer-history-header">
                <div>
                    <h5 class="transfer-history-title">
                        <i class="bi bi-arrow-left-right me-2"></i>Transfer History
                    </h5>
                    <p class="transfer-history-subtitle">
                        View and manage employee corridor transfers.
                    </p>
                </div>

                <button
                    type="submut" name="transfer_user"
                    class="transfer-history-btn"
                    data-bs-toggle="modal"
                    data-bs-target="#transferHistoryModal"
                >
                    <i class="bi bi-plus-circle"></i>
                    Initiate Transfer
                </button>
            </div>

            <div class="transfer-history-table-wrap">
                <table class="table align-middle" id="transferHistoryTable">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Ref ID</th>
                            <th>Date </th>
                            <th>Employee</th>
                            <th>From Corridor</th>
                            <th>To Corridor</th>
                            <th>Transferred By</th>
                            <th>Expected Resumption</th>
                            <th>Reason</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php $transfer_sn = 0; ?>

                        <?php foreach ($LoadTransferHistory as $transfer): ?>
                            <tr>
                                <td><?= $transfer_sn = $transfer_sn + 1 ?></td>

                                <td><?= $transfer['refid'] ?></td>

                                <td>
                                    <?= !empty($transfer['date_transfered'])
                                        ? date('F j, Y', strtotime($transfer['date_transfered']))
                                        : '' ?>
                                </td>

                                <td><?= $transfer['user_transfered'] ?></td>

                                <td><?= $transfer['from_corridor'] ?></td>

                                <td><?= $transfer['to_corridor'] ?></td>

                                <td><?= $transfer['transfer_initilizer'] ?></td>

                                <td>
                                    <?= !empty($transfer['expected_resumption_date'])
                                        ? date('F j, Y', strtotime($transfer['expected_resumption_date']))
                                        : '' ?>
                                </td>

                                <td><?= $transfer['reason'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Initiate Transfer Modal -->
<div
    class="modal fade transfer-modal"
    id="transferHistoryModal"
    tabindex="-1"
    aria-labelledby="transferHistoryModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">

            <form method="POST" action="index.php?action=tr_employee" enctype="multipart/form-data" onsubmit="disableSubmitButton(this);">
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold" id="transferHistoryModalLabel">
                            <i class="bi bi-arrow-left-right me-2"></i>Initiate Employee Transfer
                        </h5>
                        <small class="text-muted">
                            Complete the details below to initiate a corridor transfer.
                        </small>
                    </div>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <input type="hidden" name="initiate_transfer" value="1">
                        <input type="hidden" name="action_token" value="<?= $_SESSION['action_token'] ?>">

                        <div class="col-md-6">
                            <label for="transfer_user" class="form-label">
                                Employee <span class="text-danger">*</span>
                            </label>

                            <select
                                class="form-select"
                                id="transfer_user"
                                name="employee_userid"
                                required
                            >
                                <option value="">Select employee</option>

                                <?php foreach ($LoadAllUsersAndLoginTableForAdmin['all'] as $transfer_user): ?>
                                    <?php
                                    $employee_user = $transfer_user['user_fullname'] . " (" . $transfer_user['user_userid'] . ") - " . $transfer_user['user_corridor'] . " corridor";

                                    if ($transfer_user['login_role'] != "administrator") {
                                        echo '<option value="' . htmlspecialchars($transfer_user['user_userid'], ENT_QUOTES, 'UTF-8') . '" data-corridor="">' .
                                            htmlspecialchars($employee_user, ENT_QUOTES, 'UTF-8') .
                                            '</option>';
                                    }
                                    ?>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="to_corridor" class="form-label">
                                Destination Corridor <span class="text-danger">*</span>
                            </label>

                            <select
                                class="form-select"
                                id="to_corridor"
                                name="to_corridor"
                                required
                            >
                                <option value="">Select destination corridor</option>

                                <?php foreach ($LoadCorridorColumnForSelect as $UserCorridors): ?>
                                    <option value="<?= $UserCorridors['name'] ?>"><?= $UserCorridors['name'] . " corridor" ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="transfer_type" class="form-label">
                                Transfer Type <span class="text-danger">*</span>
                            </label>

                            <select
                                class="form-select"
                                id="transfer_reason"
                                name="transfer_reason"
                                required
                            >
                                <option value="">Select reason for transfer</option>
                                <option value="official">Official</option>
                                <option value="Based on request">Base on request</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="date_effective" class="form-label">
                                Resumption date <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                class="form-control"
                                id="date_effective"
                                name="effective_date"
                                value="<?= date('Y-m-d') ?>"
                                min="<?= date('Y-m-d') ?>"
                                required
                            >
                        </div>

                        <!-- <div class="col-12">
                            <label for="transfer_reason" class="form-label">
                                Reason for Transfer <span class="text-danger">*</span>
                            </label>

                            <textarea
                                maxlength="30"
                                class="form-control"
                                id="transfer_reason"
                                name="reason"
                                rows="4"
                                placeholder="Enter the reason for this transfer..."
                                required
                            ></textarea>
                        </div> -->

                    </div>
                </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-outline-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        class="btn btn-primary"
                        name="initiate_transfer"
                        value="1"
                    >
                        <i class="bi bi-check-circle me-1"></i>
                        Initiate Transfer
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    function initializeTransferHistoryTable() {
        const table = document.getElementById('transferHistoryTable');

        if (!table || !window.jQuery || !window.jQuery.fn.DataTable) {
            return;
        }

        const $ = window.jQuery;

        if ($.fn.DataTable.isDataTable(table)) {
            return;
        }

        const headerRow = table.querySelector('thead tr');

        if (!headerRow) {
            console.error('Transfer History: the table header row is missing.');
            return;
        }

        const expectedColumns = headerRow.querySelectorAll('th').length;
        const invalidRows = [];

        table.querySelectorAll('tbody tr').forEach(function (row, index) {
            const cells = Array.from(row.children).filter(function (cell) {
                return cell.tagName === 'TD' || cell.tagName === 'TH';
            });

            const hasSpan = cells.some(function (cell) {
                return cell.hasAttribute('colspan') ||
                       cell.hasAttribute('rowspan');
            });

            if (cells.length !== expectedColumns || hasSpan) {
                invalidRows.push({
                    row: index + 1,
                    expected: expectedColumns,
                    actual: cells.length,
                    html: row.outerHTML
                });
            }
        });

        if (expectedColumns !== 9 || invalidRows.length > 0) {
            console.error('Transfer History: DataTables column mismatch.', {
                expectedColumns: expectedColumns,
                invalidRows: invalidRows
            });

            return;
        }

        const tableInstance = $(table).DataTable({
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
            dom: '<"dt-top"lfB>rt<"dt-bottom"ip>',
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
                infoFiltered: '(filtered from _MAX_ total transfers)',
                paginate: {
                    previous: 'Previous',
                    next: 'Next'
                }
            }
        });

        if ($.fn.dataTable.Buttons && tableInstance.button) {
            new $.fn.dataTable.Buttons(tableInstance, {
                buttons: [
                    {
                        extend: 'excelHtml5',
                        text: '<i class="bi bi-file-earmark-excel me-1"></i> Excel',
                        title: 'Transfer History',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: '<i class="bi bi-file-earmark-pdf me-1"></i> PDF',
                        title: 'Transfer History',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ]
            });

            tableInstance.buttons().container().appendTo(
                $('#transferHistoryTable_wrapper .dt-top')
            );
        }
    }

    function initializeTransferForm() {
        const employeeSelect = document.getElementById('transfer_user');
        const sourceSelect = document.getElementById('from_corridor');
        const destinationSelect = document.getElementById('to_corridor');
        const transferDate = document.getElementById('date_transferred');
        const resumptionDate = document.getElementById('expected_resumption_date');
        const form = document.querySelector('#transferHistoryModal form');

        if (!form) {
            return;
        }

        if (employeeSelect && sourceSelect) {
            employeeSelect.addEventListener('change', function () {
                const selectedOption =
                    employeeSelect.options[employeeSelect.selectedIndex];

                const employeeCorridor = selectedOption
                    ? selectedOption.getAttribute('data-corridor')
                    : '';

                if (employeeCorridor) {
                    const matchingOption = Array.from(sourceSelect.options).find(
                        function (option) {
                            return option.value === employeeCorridor;
                        }
                    );

                    if (matchingOption) {
                        sourceSelect.value = employeeCorridor;
                    }
                }
            });
        }

        if (sourceSelect && destinationSelect) {
            sourceSelect.addEventListener('change', function () {
                const sourceValue = sourceSelect.value;

                Array.from(destinationSelect.options).forEach(function (option) {
                    option.disabled =
                        option.value !== '' &&
                        option.value === sourceValue;
                });

                if (destinationSelect.value === sourceValue) {
                    destinationSelect.value = '';
                }
            });
        }

        if (transferDate && resumptionDate) {
            resumptionDate.min = transferDate.value;

            transferDate.addEventListener('change', function () {
                resumptionDate.min = transferDate.value || '';

                if (
                    transferDate.value &&
                    resumptionDate.value &&
                    resumptionDate.value < transferDate.value
                ) {
                    resumptionDate.value = '';
                }
            });
        }

        form.addEventListener('submit', function (event) {
            if (
                sourceSelect &&
                destinationSelect &&
                sourceSelect.value &&
                destinationSelect.value &&
                sourceSelect.value === destinationSelect.value
            ) {
                event.preventDefault();

                if (window.Swal) {
                    window.Swal.fire({
                        icon: 'warning',
                        title: 'Invalid corridor selection',
                        text: 'The source and destination corridors cannot be the same.'
                    });
                } else {
                    alert('The source and destination corridors cannot be the same.');
                }

                return;
            }

            if (
                transferDate &&
                resumptionDate &&
                transferDate.value &&
                resumptionDate.value &&
                resumptionDate.value < transferDate.value
            ) {
                event.preventDefault();

                if (window.Swal) {
                    window.Swal.fire({
                        icon: 'warning',
                        title: 'Invalid resumption date',
                        text: 'The expected resumption date cannot be earlier than the transfer date.'
                    });
                } else {
                    alert('The expected resumption date cannot be earlier than the transfer date.');
                }
            }
        });
    }

    function initializeTransferActions(table) {
        if (!table) {
            return;
        }

        table.addEventListener('click', function (event) {
            const cancelBtn = event.target.closest('.transfer-cancel-btn');

            if (cancelBtn) {
                const transferId = cancelBtn.getAttribute('data-transfer-id');

                if (!transferId) {
                    if (window.Swal) {
                        window.Swal.fire({
                            icon: 'info',
                            title: 'Transfer Reference Unavailable',
                            text: 'The transfer reference ID was not returned by the model.'
                        });
                    } else {
                        alert('The transfer reference ID was not returned by the model.');
                    }

                    return;
                }

                if (window.Swal) {
                    window.Swal.fire({
                        icon: 'warning',
                        title: 'Cancel Transfer',
                        text: 'Cancel action selected for transfer reference: ' + transferId,
                        showCancelButton: true,
                        confirmButtonText: 'Yes, cancel',
                        cancelButtonText: 'No, keep transfer'
                    });
                } else {
                    confirm('Cancel transfer reference ' + transferId + '?');
                }
            }
        });
    }

    function initializeTransferHistory() {
        initializeTransferHistoryTable();
        initializeTransferForm();

        const table = document.getElementById('transferHistoryTable');
        initializeTransferActions(table);
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initializeTransferHistory);
    } else {
        initializeTransferHistory();
    }
})();
</script>
