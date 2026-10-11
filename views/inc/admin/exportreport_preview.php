
<?php
$template_mode = 'auto';

if (isset($_SESSION['success'])) {
    $msgtext = $_SESSION['success'];
    $url = "#";
    $showAlert = true;
    unset($_SESSION['success']);
}

if (isset($_SESSION['error'])) {
    $msgtext = $_SESSION['error'];
    $url = "#";
    $showAlert = false;
    unset($_SESSION['error']);
}

$tickets = isset($LoadTicketsTable) && is_array($LoadTicketsTable)
    ? $LoadTicketsTable
    : [];

function exportTicketValue($ticket, $keys, $default = '')
{
    foreach ($keys as $key) {
        if (isset($ticket[$key]) && $ticket[$key] !== '') {
            return $ticket[$key];
        }
    }

    return $default;
}

function exportTicketDate($value)
{
    if ($value === '' || $value === null) {
        return '';
    }

    $timestamp = strtotime((string) $value);

    return $timestamp !== false ? date('Y-m-d', $timestamp) : '';
}

function exportTicketDateTime($value)
{
    if ($value === '' || $value === null) {
        return '';
    }

    $timestamp = strtotime((string) $value);

    return $timestamp !== false
        ? date('d/m/Y H:i', $timestamp)
        : (string) $value;
}
?>

<style>
    /* ============================================================
       EXPORT TICKETS — USE THE EXISTING HEADER THEME COLORS
       ============================================================ */

    .export-tickets-wrapper {
        width: 100%;
        max-width: 100%;
        overflow-x: hidden;
        color: var(--body-text);
    }

    .export-tickets-card {
        background: var(--surface-bg);
        color: var(--body-text);
        border: 1px solid var(--surface-border);
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .export-tickets-card .card-body {
        padding: 18px 20px;
        background: var(--surface-bg);
        color: var(--body-text);
    }

    .export-tickets-title {
        color: var(--body-text);
        font-size: 18px;
        font-weight: 700;
        margin-bottom: 4px;
    }

    .export-tickets-subtitle {
        color: var(--secondary-text);
        font-size: 12px;
        margin-bottom: 16px;
    }

    .export-filter-label {
        display: block;
        color: var(--secondary-text);
        font-size: 12px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .export-filter-control {
        display: block;
        width: 100%;
        min-width: 0;
        min-height: 36px;
        padding: 6px 9px;
        border: 1px solid var(--surface-border);
        border-radius: 8px;
        background: var(--surface-soft);
        color: var(--body-text);
        font-family: inherit;
        font-size: 12px;
        outline: none;
        color-scheme: inherit;
    }

    .export-filter-control:focus {
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(59, 111, 212, .12);
        background: var(--surface-bg);
        color: var(--body-text);
    }

    .export-filter-control option {
        background: var(--surface-bg);
        color: var(--body-text);
    }

    /* Date range, From, and To in one horizontal row */
    .export-date-filter-row {
        display: grid;
        grid-template-columns: 1.25fr 1fr 1fr;
        gap: 12px;
        align-items: end;
        margin-bottom: 14px;
    }

    /* Order, Status, and Priority in one horizontal row */
    .export-filter-row {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
        align-items: end;
        margin-bottom: 14px;
    }

    .export-filter-section {
        min-width: 0;
    }

    .export-action-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin-top: 12px;
    }

    .export-hint {
        color: var(--secondary-text);
        font-size: 11px;
    }

    .export-action-buttons {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .export-tickets-btn {
        display: inline-flex;
        justify-content: center;
        align-items: center;
        gap: 7px;
        min-height: 36px;
        padding: 8px 14px;
        border: 1px solid var(--surface-border);
        border-radius: 10px;
        background: var(--surface-soft);
        color: var(--body-text);
        font-family: inherit;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s ease, border-color .2s ease;
    }

    .export-tickets-btn:hover {
        background: var(--table-hover-bg);
        border-color: var(--primary-blue);
        color: var(--body-text);
    }

    .export-tickets-btn.primary {
        background: var(--primary-blue);
        border-color: var(--primary-blue);
        color: #ffffff;
    }

    .export-tickets-btn.primary:hover {
        background: #2f5cb8;
        border-color: #2f5cb8;
        color: #ffffff;
    }

    .export-table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    #dashboardDataTable {
        width: 100% !important;
        border-collapse: collapse !important;
        margin: 0 !important;
        color: var(--body-text);
        font-size: 12px;
    }

    #dashboardDataTable thead th {
        padding: 12px;
        background: var(--table-head-bg);
        color: var(--secondary-text);
        border-bottom: 1px solid var(--surface-border);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .45px;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
    }

    #dashboardDataTable tbody td {
        padding: 12px;
        background: var(--table-cell-bg);
        color: var(--body-text);
        border-bottom: 1px solid var(--surface-border);
        vertical-align: middle;
        white-space: nowrap;
    }

    #dashboardDataTable tbody tr:hover td {
        background: var(--table-hover-bg);
    }

    .export-status-badge,
    .export-priority-badge {
        display: inline-block;
        padding: 4px 8px;
        border: 1px solid var(--surface-border);
        border-radius: 6px;
        background: var(--surface-soft);
        color: var(--body-text);
        font-size: 10px;
        font-weight: 600;
    }

    .dataTables_wrapper {
        color: var(--body-text);
    }

    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_info {
        color: var(--secondary-text) !important;
        font-size: 12px;
    }

    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 14px;
    }

    .dataTables_wrapper .dataTables_filter input,
    .dataTables_wrapper .dataTables_length select {
        padding: 6px 10px;
        border: 1px solid var(--surface-border);
        border-radius: 8px;
        background: var(--surface-soft);
        color: var(--body-text);
        font-size: 12px;
    }

    .dataTables_wrapper .dataTables_filter input:focus,
    .dataTables_wrapper .dataTables_length select:focus {
        outline: none;
        border-color: var(--primary-blue);
        box-shadow: 0 0 0 3px rgba(59, 111, 212, .12);
    }

    .dataTables_wrapper .dataTables_paginate {
        margin-top: 12px;
        padding-top: 12px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 5px 11px !important;
        margin: 0 3px;
        border: 1px solid var(--surface-border) !important;
        border-radius: 8px !important;
        background: var(--surface-soft) !important;
        color: var(--body-text) !important;
        font-size: 12px;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        border-color: var(--primary-blue) !important;
        background: var(--primary-blue) !important;
        color: #ffffff !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        border-color: var(--surface-border) !important;
        background: var(--table-hover-bg) !important;
        color: var(--body-text) !important;
    }

    .dt-buttons {
        display: none !important;
    }

    @media (max-width: 767px) {
        .export-tickets-card .card-body {
            padding: 13px;
        }

        .export-date-filter-row {
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 8px;
        }

        .export-filter-row {
            gap: 8px;
        }

        .export-filter-control {
            padding: 6px;
            font-size: 11px;
        }

        .export-filter-label {
            font-size: 11px;
        }
    }

    @media (max-width: 480px) {
        .export-date-filter-row {
            grid-template-columns: 1fr;
        }

        .export-filter-row {
            grid-template-columns: repeat(3, minmax(0, 1fr));
        }

        .export-action-row {
            align-items: stretch;
        }

        .export-action-buttons {
            width: 100%;
        }

        .export-tickets-btn {
            flex: 1;
        }
    }
</style>

<div class="row export-tickets-wrapper">
    <div class="col-12 grid-margin stretch-card">
        <div class="card export-tickets-card">
            <div class="card-body">

                <div class="export-tickets-title">
                    <i class="bi bi-file-earmark-arrow-down"></i>
                    Export Tickets
                </div>

                <div class="export-tickets-subtitle">
                    Filter tickets and export the results to PDF or Excel.
                </div>

                <!-- Date range, From and To -->
                <div class="export-date-filter-row">

                    <div class="export-filter-section">
                        <label class="export-filter-label" for="exportDatePreset">
                            Date range
                        </label>

                        <select id="exportDatePreset" class="export-filter-control">
                            <option value="this_month" selected>This month (October)</option>
                            <option value="today">Today</option>
                            <option value="yesterday">Yesterday</option>
                            <option value="last_7_days">Last 7 days</option>
                            <option value="last_30_days">Last 30 days</option>
                            <option value="custom">Custom date range</option>
                            <option value="all">All dates</option>
                        </select>
                    </div>

                    <div class="export-filter-section">
                        <label class="export-filter-label" for="exportDateFrom">
                            From
                        </label>

                        <input
                            type="date"
                            id="exportDateFrom"
                            class="export-filter-control"
                            value="<?php echo date('Y-m-01'); ?>"
                        >
                    </div>

                    <div class="export-filter-section">
                        <label class="export-filter-label" for="exportDateTo">
                            To
                        </label>

                        <input
                            type="date"
                            id="exportDateTo"
                            class="export-filter-control"
                            value="<?php echo date('Y-m-d'); ?>"
                        >
                    </div>

                </div>

                <!-- Order, Status and Priority -->
                <div class="export-filter-row">

                    <div class="export-filter-section">
                        <label class="export-filter-label" for="exportOrder">
                            Order
                        </label>

                        <select id="exportOrder" class="export-filter-control">
                            <option value="asc">Ascending</option>
                            <option value="desc" selected>Descending</option>
                        </select>
                    </div>

                    <div class="export-filter-section">
                        <label class="export-filter-label" for="exportStatus">
                            Status
                        </label>

                        <select id="exportStatus" class="export-filter-control">
                            <option value="">All statuses</option>
                            <option value="new">New</option>
                            <option value="waiting reply">Waiting reply</option>
                            <option value="replied">Replied</option>
                            <option value="resolved">Resolved</option>
                            <option value="in progress">In Progress</option>
                            <option value="on hold">On Hold</option>
                        </select>
                    </div>

                    <div class="export-filter-section">
                        <label class="export-filter-label" for="exportPriority">
                            Priority
                        </label>

                        <select id="exportPriority" class="export-filter-control">
                            <option value="">All priorities</option>
                            <option value="critical">Critical</option>
                            <option value="high">High</option>
                            <option value="medium">Medium</option>
                            <option value="low">Low</option>
                        </select>
                    </div>

                </div>

                <div class="export-action-row">
                    <span class="export-hint">
                        <i class="bi bi-info-circle"></i>
                        Only filtered tickets will be exported.
                    </span>

                    <div class="export-action-buttons">
                        <button type="button" id="exportTicketsPdf" class="export-tickets-btn">
                            <i class="bi bi-file-earmark-pdf"></i>
                            Export PDF
                        </button>

                        <button type="button" id="exportTicketsExcel" class="export-tickets-btn primary">
                            <i class="bi bi-file-earmark-excel"></i>
                            Export Excel
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-12 grid-margin stretch-card">
        <div class="card export-tickets-card">
            <div class="card-body">

                <div class="export-table-wrapper">
                    <table id="dashboardDataTable" class="table table-hover">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>Ticket ID</th>
                                <th>Subject</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Assigned To</th>
                                <th>Name</th>
                                <th>Created</th>
                                <th>Updated</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $serialNumber = 0;

                            foreach ($tickets as $ticket):
                                $serialNumber++;

                                $ticketId = exportTicketValue(
                                    $ticket,
                                    ['ticket_id', 'ticketid', 'id', 'refid', 'sn']
                                );

                                $subject = exportTicketValue(
                                    $ticket,
                                    ['subject', 'complaint', 'title', 'ticket_subject']
                                );

                                $category = exportTicketValue(
                                    $ticket,
                                    ['category_name', 'category', 'ticket_category']
                                );

                                $status = exportTicketValue(
                                    $ticket,
                                    ['status_name', 'status', 'ticket_status']
                                );

                                $priority = exportTicketValue(
                                    $ticket,
                                    ['priority_name', 'priority']
                                );

                                $assignedTo = exportTicketValue(
                                    $ticket,
                                    ['assigned_name', 'assigned_to', 'assignee', 'assigned_user']
                                );

                                $name = exportTicketValue(
                                    $ticket,
                                    ['full_name', 'reporter_name', 'name', 'created_by']
                                );

                                $createdRaw = exportTicketValue(
                                    $ticket,
                                    ['date_created', 'created_at', 'date', 'created']
                                );

                                $updatedRaw = exportTicketValue(
                                    $ticket,
                                    ['updated_at', 'date_updated', 'last_updated', 'updated']
                                );

                                $createdDate = exportTicketDate($createdRaw);
                                $statusLower = strtolower(trim((string) $status));
                                $priorityLower = strtolower(trim((string) $priority));

                                $priorityRank = [
                                    'critical' => 1,
                                    'high' => 2,
                                    'medium' => 3,
                                    'low' => 4
                                ];

                                $priorityOrder = $priorityRank[$priorityLower] ?? 99;
                            ?>
                                <tr
                                    data-created-date="<?php echo htmlspecialchars($createdDate, ENT_QUOTES, 'UTF-8'); ?>"
                                    data-status="<?php echo htmlspecialchars($statusLower, ENT_QUOTES, 'UTF-8'); ?>"
                                    data-priority="<?php echo htmlspecialchars($priorityLower, ENT_QUOTES, 'UTF-8'); ?>"
                                >
                                    <td><?php echo $serialNumber; ?></td>

                                    <td><?php echo htmlspecialchars((string) $ticketId, ENT_QUOTES, 'UTF-8'); ?></td>

                                    <td><?php echo htmlspecialchars((string) $subject, ENT_QUOTES, 'UTF-8'); ?></td>

                                    <td><?php echo htmlspecialchars((string) $category, ENT_QUOTES, 'UTF-8'); ?></td>

                                    <td>
                                        <span class="export-status-badge">
                                            <?php echo htmlspecialchars((string) $status, ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </td>

                                    <td data-order="<?php echo $priorityOrder; ?>">
                                        <span class="export-priority-badge">
                                            <?php echo htmlspecialchars((string) $priority, ENT_QUOTES, 'UTF-8'); ?>
                                        </span>
                                    </td>

                                    <td><?php echo htmlspecialchars((string) $assignedTo, ENT_QUOTES, 'UTF-8'); ?></td>

                                    <td><?php echo htmlspecialchars((string) $name, ENT_QUOTES, 'UTF-8'); ?></td>

                                    <td data-order="<?php echo htmlspecialchars((string) $createdRaw, ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars(exportTicketDateTime($createdRaw), ENT_QUOTES, 'UTF-8'); ?>
                                    </td>

                                    <td data-order="<?php echo htmlspecialchars((string) $updatedRaw, ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars(exportTicketDateTime($updatedRaw), ENT_QUOTES, 'UTF-8'); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script>
(function () {
    'use strict';

    function initialiseExportTickets() {
        if (!window.jQuery || !jQuery.fn || !jQuery.fn.DataTable) {
            return;
        }

        var $ = jQuery;
        var tableElement = document.getElementById('dashboardDataTable');

        if (!tableElement) {
            return;
        }

        if (!$.fn.DataTable.isDataTable(tableElement)) {
            $(tableElement).DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                autoWidth: false,
                order: [[0, 'asc']],
                dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        title: 'Export Tickets',
                        filename: 'export_tickets',
                        exportOptions: {
                            columns: ':visible',
                            modifier: {
                                search: 'applied',
                                order: 'applied',
                                page: 'all'
                            }
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Export Tickets',
                        filename: 'export_tickets',
                        orientation: 'landscape',
                        pageSize: 'A3',
                        exportOptions: {
                            columns: ':visible',
                            modifier: {
                                search: 'applied',
                                order: 'applied',
                                page: 'all'
                            }
                        },
                        customize: function (doc) {
                            doc.defaultStyle.fontSize = 8;
                            doc.styles.tableHeader.fontSize = 8;
                            doc.styles.title.fontSize = 14;
                            doc.pageMargins = [20, 25, 20, 25];

                            if (doc.content[1] && doc.content[1].table) {
                                doc.content[1].table.widths = Array(
                                    doc.content[1].table.body[0].length
                                ).fill('*');
                            }
                        }
                    }
                ],
                drawCallback: function () {
                    var api = this.api();
                    var info = api.page.info();

                    api.column(0, {page: 'current'}).nodes().each(function (cell, index) {
                        cell.innerHTML = info.start + index + 1;
                    });
                },
                language: {
                    emptyTable: 'No tickets available',
                    search: 'Search tickets:',
                    lengthMenu: 'Show _MENU_ tickets',
                    info: 'Showing _START_ to _END_ of _TOTAL_ tickets',
                    infoEmpty: 'Showing 0 to 0 of 0 tickets',
                    zeroRecords: 'No matching tickets found',
                    paginate: {
                        previous: 'Previous',
                        next: 'Next'
                    }
                }
            });
        }

        var table = $(tableElement).DataTable();

        function normalise(value) {
            return String(value || '').trim().toLowerCase();
        }

        function formatDate(date) {
            var year = date.getFullYear();
            var month = String(date.getMonth() + 1).padStart(2, '0');
            var day = String(date.getDate()).padStart(2, '0');

            return year + '-' + month + '-' + day;
        }

        function updateDateRange() {
            var preset = document.getElementById('exportDatePreset').value;
            var fromInput = document.getElementById('exportDateFrom');
            var toInput = document.getElementById('exportDateTo');

            var now = new Date();
            var start = new Date(now.getFullYear(), now.getMonth(), 1);
            var end = new Date(now.getFullYear(), now.getMonth(), now.getDate());

            if (preset === 'today') {
                start = new Date(now.getFullYear(), now.getMonth(), now.getDate());
            } else if (preset === 'yesterday') {
                start = new Date(now.getFullYear(), now.getMonth(), now.getDate() - 1);
                end = new Date(start);
            } else if (preset === 'last_7_days') {
                start = new Date(now.getFullYear(), now.getMonth(), now.getDate() - 6);
            } else if (preset === 'last_30_days') {
                start = new Date(now.getFullYear(), now.getMonth(), now.getDate() - 29);
            } else if (preset === 'custom') {
                return;
            } else if (preset === 'all') {
                fromInput.value = '';
                toInput.value = '';
                return;
            }

            fromInput.value = formatDate(start);
            toInput.value = formatDate(end);
        }

        function applyFilters() {
            var fromDate = document.getElementById('exportDateFrom').value;
            var toDate = document.getElementById('exportDateTo').value;
            var selectedStatus = normalise(document.getElementById('exportStatus').value);
            var selectedPriority = normalise(document.getElementById('exportPriority').value);
            var selectedOrder = document.getElementById('exportOrder').value;

            $.fn.dataTable.ext.search = $.fn.dataTable.ext.search.filter(function (fn) {
                return !fn._exportTicketsFilter;
            });

            var ticketFilter = function (settings, data, dataIndex) {
                if (settings.nTable !== tableElement) {
                    return true;
                }

                var row = table.row(dataIndex).node();

                if (!row) {
                    return true;
                }

                var rowDate = row.getAttribute('data-created-date') || '';
                var rowStatus = normalise(row.getAttribute('data-status'));
                var rowPriority = normalise(row.getAttribute('data-priority'));

                if (fromDate && (!rowDate || rowDate < fromDate)) {
                    return false;
                }

                if (toDate && (!rowDate || rowDate > toDate)) {
                    return false;
                }

                if (selectedStatus && rowStatus !== selectedStatus) {
                    return false;
                }

                if (selectedPriority && rowPriority !== selectedPriority) {
                    return false;
                }

                return true;
            };

            ticketFilter._exportTicketsFilter = true;
            $.fn.dataTable.ext.search.push(ticketFilter);

            table.order([0, selectedOrder]).draw();
        }

        $('#exportDatePreset')
            .off('change.exportTickets')
            .on('change.exportTickets', function () {
                updateDateRange();
                applyFilters();
            });

        $('#exportDateFrom, #exportDateTo, #exportStatus, #exportPriority, #exportOrder')
            .off('change.exportTickets')
            .on('change.exportTickets', applyFilters);

        $('#exportTicketsExcel')
            .off('click.exportTickets')
            .on('click.exportTickets', function () {
                table.button('.buttons-excel').trigger();
            });

        $('#exportTicketsPdf')
            .off('click.exportTickets')
            .on('click.exportTickets', function () {
                table.button('.buttons-pdf').trigger();
            });

        applyFilters();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialiseExportTickets);
    } else {
        initialiseExportTickets();
    }
})();
</script>