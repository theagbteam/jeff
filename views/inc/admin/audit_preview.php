
<?php

$table_name = "audit_trail";
$audit_trail_sn = 0;

?>

<!-- =========================================================
     AUDIT TRAIL MANAGEMENT
========================================================= -->

<div class="row audit-trail-row">

    <div class="col-12 grid-margin stretch-card">

        <div class="card audit-trail-card">

            <div class="card-body">

                <!-- HEADER -->

                <div class="audit-trail-heading">

                    <div>
                        <h4 class="card-title mb-1">Audit Trail Management</h4>

                        <p class="text-muted mb-0">
                            Monitor user activities, recorded actions, dates and IP addresses.
                        </p>
                    </div>

                    <div class="audit-trail-total">
                        <i class="mdi mdi-shield-check-outline"></i>
                        <span>
                            Total Records:
                            <strong><?= number_format(is_array($LoadAuditTrailTable ?? null) ? count($LoadAuditTrailTable) : 0) ?></strong>
                        </span>
                    </div>

                </div>

                <!-- TOOLBAR -->

                <div class="audit-trail-toolbar">

                    <div class="audit-trail-search-box">
                        <i class="mdi mdi-magnify"></i>

                        <input type="search"
                               id="auditTrailSearch"
                               placeholder="Search audit trail..."
                               aria-label="Search audit trail">
                    </div>

                    <div class="audit-trail-filters">

                        <select id="auditTrailActionFilter"
                                class="audit-trail-filter"
                                aria-label="Filter by action">

                            <option value="">All Actions</option>

                        </select>

                        <input type="date"
                               id="auditTrailDateFilter"
                               class="audit-trail-filter"
                               aria-label="Filter by date">

                        <button type="button"
                                id="clearAuditTrailFilters"
                                class="audit-trail-clear-btn">

                            <i class="mdi mdi-filter-remove-outline"></i>
                            Clear Filters

                        </button>

                    </div>

                </div>

                <!-- TABLE -->

                <div class="audit-trail-table-wrapper">

                    <table class="table audit-trail-table"
                           id="dashboardDataTable">

                        <thead>

                            <tr>
                                <th>S/N</th>
                                <th>Date &amp; Time</th>
                                <th>User ID</th>
                                <th>Full Name</th>
                                <th>Role</th>
                                <th>Role Name</th>
                                <th>Action</th>
                                <th>IP Address</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php if (!empty($LoadAuditTrailTable) && is_array($LoadAuditTrailTable)): ?>

                                <?php foreach ($LoadAuditTrailTable as $audit_trail): ?>

                                    <?php

                                    $audit_date = trim((string)($audit_trail['date'] ?? ''));
                                    $audit_userid = (string)($audit_trail['userid'] ?? '');
                                    $audit_full_name = (string)($audit_trail['full_name'] ?? '');
                                    $audit_role = (string)($audit_trail['role'] ?? '');
                                    $audit_role_name = (string)($audit_trail['role_name'] ?? '');
                                    $audit_action = (string)($audit_trail['Action'] ?? '');
                                    $audit_ip = (string)($audit_trail['ip'] ?? '');

                                    $formatted_audit_date = 'N/A';

                                    if ($audit_date !== '' && strtotime($audit_date) !== false) {
                                        $formatted_audit_date = date('d M Y, h:i:s A', strtotime($audit_date));
                                    }

                                    $audit_date_filter = '';

                                    if ($audit_date !== '' && strtotime($audit_date) !== false) {
                                        $audit_date_filter = date('Y-m-d', strtotime($audit_date));
                                    }

                                    ?>

                                    <tr>

                                        <!-- SERIAL NUMBER -->

                                        <td>
                                            <span class="audit-trail-serial"></span>
                                        </td>

                                        <!-- DATE -->

                                        <td data-order="<?= htmlspecialchars(
                                            $audit_date !== '' && strtotime($audit_date) !== false
                                                ? (string)strtotime($audit_date)
                                                : '0',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ) ?>"
                                            data-date="<?= htmlspecialchars(
                                                $audit_date_filter,
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>">

                                            <span class="audit-trail-date">
                                                <i class="mdi mdi-calendar-clock"></i>

                                                <?= htmlspecialchars(
                                                    $formatted_audit_date,
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </span>

                                        </td>

                                        <!-- USER ID -->

                                        <td>
                                            <span class="audit-trail-userid">
                                                <?= htmlspecialchars(
                                                    $audit_userid !== '' ? $audit_userid : 'N/A',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </span>
                                        </td>

                                        <!-- FULL NAME -->

                                        <td>
                                            <div class="audit-trail-user">

                                                <div class="audit-trail-avatar">
                                                    <i class="mdi mdi-account-outline"></i>
                                                </div>

                                                <span class="audit-trail-fullname">
                                                    <?= htmlspecialchars(
                                                        $audit_full_name !== '' ? $audit_full_name : 'N/A',
                                                        ENT_QUOTES,
                                                        'UTF-8'
                                                    ) ?>
                                                </span>

                                            </div>
                                        </td>

                                        <!-- ROLE -->

                                        <td>
                                            <span class="audit-trail-role">
                                                <?= htmlspecialchars(
                                                    $audit_role !== '' ? $audit_role : 'N/A',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </span>
                                        </td>

                                        <!-- ROLE NAME -->

                                        <td>
                                            <?= htmlspecialchars(
                                                $audit_role_name !== '' ? $audit_role_name : 'N/A',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ) ?>
                                        </td>

                                        <!-- ACTION -->

                                        <td>
                                            <span class="audit-trail-action">
                                                <i class="mdi mdi-history"></i>

                                                <?= htmlspecialchars(
                                                    $audit_action !== '' ? $audit_action : 'N/A',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ) ?>
                                            </span>
                                        </td>

                                        <!-- IP ADDRESS -->

                                        <td>
                                            <span class="audit-trail-ip">
                                                <i class="mdi mdi-ip-network-outline"></i>

                                                <?= htmlspecialchars(
                                                    $audit_ip !== '' ? $audit_ip : 'N/A',
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

                <div class="audit-trail-footer">

                    <span id="auditTrailResultCount">
                        Audit trail records
                    </span>

                    <span class="audit-trail-footer-note">
                        <i class="mdi mdi-shield-lock-outline"></i>
                        Activity monitoring
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     AUDIT TRAIL STYLES
========================================================= -->

<style>

.audit-trail-row {
    max-width: 100%;
    min-width: 0;
    margin-left: 0;
    margin-right: 0;
}

.audit-trail-row > .col-12 {
    min-width: 0;
}

.audit-trail-card {
    width: 100%;
    max-width: 100%;
    min-width: 0;
    overflow: hidden;
    border: 1px solid #dfe3ea;
    border-radius: 14px;
    background: #f7f8fb;
    box-shadow: 0 5px 22px rgba(15, 23, 42, .04);
}

.audit-trail-card > .card-body {
    min-width: 0;
    padding: 24px;
}

.audit-trail-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
    margin-bottom: 25px;
}

.audit-trail-heading .card-title {
    color: #2c3545;
    font-size: 19px;
    font-weight: 700;
}

.audit-trail-heading p {
    color: #6b7280;
    font-size: 13px;
}

.audit-trail-total {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 10px 14px;
    border: 1px solid rgba(59, 111, 212, .20);
    border-radius: 9px;
    background: rgba(59, 111, 212, .07);
    color: #6b7280;
    font-size: 12px;
    white-space: nowrap;
}

.audit-trail-total > i {
    color: #3b6fd4;
    font-size: 20px;
}

.audit-trail-total strong {
    color: #3b6fd4;
}

.audit-trail-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 13px;
    margin-bottom: 18px;
}

.audit-trail-search-box {
    display: flex;
    align-items: center;
    gap: 9px;
    width: min(100%, 310px);
    min-height: 42px;
    padding: 0 13px;
    border: 1px solid #dfe3ea;
    border-radius: 9px;
    background: #eef1f6;
    color: #6b7280;
}

.audit-trail-search-box > i {
    font-size: 19px;
}

.audit-trail-search-box input {
    width: 100%;
    min-width: 0;
    border: 0;
    outline: 0;
    background: transparent;
    color: #2c3545;
    font-size: 13px;
}

.audit-trail-search-box input::placeholder {
    color: #8b95a5;
}

.audit-trail-filters {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 9px;
}

.audit-trail-filter {
    min-height: 42px;
    max-width: 100%;
    padding: 0 11px;
    border: 1px solid #dfe3ea;
    border-radius: 9px;
    outline: none;
    background: #eef1f6;
    color: #2c3545;
    font-family: inherit;
    font-size: 12px;
    color-scheme: light;
}

.audit-trail-filter:focus {
    border-color: #3b6fd4;
}

.audit-trail-clear-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 42px;
    padding: 0 12px;
    border: 1px solid #dfe3ea;
    border-radius: 9px;
    background: #eef1f6;
    color: #6b7280;
    font-size: 12px;
    cursor: pointer;
    transition: .2s ease;
}

.audit-trail-clear-btn:hover {
    border-color: rgba(59, 111, 212, .35);
    background: rgba(59, 111, 212, .08);
    color: #3b6fd4;
}

.audit-trail-table-wrapper {
    width: 100%;
    max-width: 100%;
    min-width: 0;
    overflow-x: auto;
    overflow-y: hidden;
    border: 1px solid #dfe3ea;
    border-radius: 10px;
    -webkit-overflow-scrolling: touch;
}

.audit-trail-table {
    width: 100%;
    min-width: 1000px;
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
    background: #f7f8fb;
    font-size: 12px;
}

.audit-trail-table thead th {
    padding: 15px 13px;
    border: 0;
    border-bottom: 1px solid #dfe3ea;
    background: #eaedf3;
    color: #6b7280;
    font-size: 10px;
    font-weight: 700;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: .45px;
    white-space: nowrap;
}

.audit-trail-table tbody td {
    padding: 14px 13px;
    border: 0;
    border-bottom: 1px solid #e5e8ef;
    background: #f7f8fb;
    color: #475569;
    vertical-align: middle;
}

.audit-trail-table tbody tr:last-child td {
    border-bottom: 0;
}

.audit-trail-table tbody tr:hover td {
    background: #e8eef9;
}

.audit-trail-serial {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 28px;
    height: 28px;
    border-radius: 7px;
    background: rgba(59, 111, 212, .08);
    color: #3b6fd4;
    font-size: 11px;
    font-weight: 700;
}

.audit-trail-date {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    color: #6b7280;
    white-space: nowrap;
}

.audit-trail-date i {
    color: #3b6fd4;
    font-size: 16px;
}

.audit-trail-userid {
    color: #3b6fd4;
    font-weight: 600;
    white-space: nowrap;
}

.audit-trail-user {
    display: flex;
    align-items: center;
    gap: 9px;
    min-width: 145px;
}

.audit-trail-avatar {
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    width: 32px;
    height: 32px;
    border-radius: 9px;
    background: rgba(59, 111, 212, .09);
    color: #3b6fd4;
    font-size: 18px;
}

.audit-trail-fullname {
    color: #2c3545;
    font-weight: 600;
    overflow-wrap: anywhere;
}

.audit-trail-role {
    display: inline-flex;
    align-items: center;
    padding: 5px 9px;
    border: 1px solid #dfe3ea;
    border-radius: 6px;
    background: #eef1f6;
    color: #64748b;
    font-size: 11px;
    font-weight: 600;
}

.audit-trail-action {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    max-width: 280px;
    color: #3b6fd4;
    font-weight: 600;
    overflow-wrap: anywhere;
}

.audit-trail-action i {
    flex-shrink: 0;
    font-size: 16px;
}

.audit-trail-ip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: #64748b;
    font-family: monospace;
    font-size: 11px;
    white-space: nowrap;
}

.audit-trail-ip i {
    color: #3b6fd4;
    font-size: 15px;
}

.audit-trail-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 17px;
    color: #6b7280;
    font-size: 12px;
}

.audit-trail-footer-note {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.audit-trail-footer-note i {
    color: #3b6fd4;
    font-size: 16px;
}

/* DATATABLES EXPORT BUTTONS */

.audit-trail-card .dt-buttons {
    display: inline-flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 7px;
    margin-bottom: 15px;
}

.audit-trail-card .dt-buttons .dt-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    min-height: 36px;
    padding: 8px 12px;
    border: 1px solid rgba(59, 111, 212, .25);
    border-radius: 8px;
    background: rgba(59, 111, 212, .07);
    color: #3b6fd4;
    font-family: inherit;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: .2s ease;
}

.audit-trail-card .dt-buttons .dt-button:hover {
    border-color: #3b6fd4;
    background: #3b6fd4;
    color: #fff;
}

.audit-trail-card .dataTables_length {
    margin-bottom: 12px;
    color: #6b7280;
    font-size: 12px;
}

.audit-trail-card .dataTables_length select {
    min-height: 34px;
    margin: 0 5px;
    padding: 4px 25px 4px 8px;
    border: 1px solid #dfe3ea;
    border-radius: 7px;
    background: #eef1f6;
    color: #2c3545;
}

.audit-trail-card .dataTables_info {
    padding-top: 15px;
    color: #6b7280;
    font-size: 12px;
}

.audit-trail-card .dataTables_paginate {
    padding-top: 10px;
}

.audit-trail-card .dataTables_paginate .paginate_button {
    margin: 2px;
    padding: 6px 10px !important;
    border: 1px solid transparent !important;
    border-radius: 7px !important;
    background: transparent !important;
    color: #6b7280 !important;
    font-size: 12px;
}

.audit-trail-card .dataTables_paginate .paginate_button.current,
.audit-trail-card .dataTables_paginate .paginate_button.current:hover {
    border-color: #3b6fd4 !important;
    background: #3b6fd4 !important;
    color: #fff !important;
}

.audit-trail-card .dataTables_paginate .paginate_button:hover {
    border-color: rgba(59, 111, 212, .2) !important;
    background: rgba(59, 111, 212, .08) !important;
    color: #3b6fd4 !important;
}

.audit-trail-card .dataTables_empty {
    padding: 35px 15px !important;
    color: #6b7280 !important;
    text-align: center !important;
}

.audit-trail-card .dataTables_wrapper {
    width: 100%;
    min-width: 0;
}

.audit-trail-card .dataTables_wrapper::after {
    display: block;
    clear: both;
    content: "";
}

/* DARK THEME */

:root[data-theme="dark"] .audit-trail-card {
    border-color: #29364a;
    background: #111c2e;
    color: #e5edf8;
}

:root[data-theme="dark"] .audit-trail-heading .card-title,
:root[data-theme="dark"] .audit-trail-fullname {
    color: #e5edf8;
}

:root[data-theme="dark"] .audit-trail-heading p,
:root[data-theme="dark"] .audit-trail-date,
:root[data-theme="dark"] .audit-trail-footer,
:root[data-theme="dark"] .audit-trail-total {
    color: #a7b6cb;
}

:root[data-theme="dark"] .audit-trail-total {
    border-color: rgba(139, 184, 255, .2);
    background: rgba(139, 184, 255, .06);
}

:root[data-theme="dark"] .audit-trail-total strong,
:root[data-theme="dark"] .audit-trail-total > i {
    color: #8bb8ff;
}

:root[data-theme="dark"] .audit-trail-search-box,
:root[data-theme="dark"] .audit-trail-filter,
:root[data-theme="dark"] .audit-trail-clear-btn,
:root[data-theme="dark"] .audit-trail-table-wrapper {
    border-color: #29364a;
    background: #172438;
    color: #e5edf8;
}

:root[data-theme="dark"] .audit-trail-search-box input {
    color: #e5edf8;
}

:root[data-theme="dark"] .audit-trail-table {
    background: #111c2e;
}

:root[data-theme="dark"] .audit-trail-table thead th {
    border-bottom-color: #29364a;
    background: #172438;
    color: #a7b6cb;
}

:root[data-theme="dark"] .audit-trail-table tbody td {
    border-bottom-color: #29364a;
    background: #111c2e;
    color: #cbd5e1;
}

:root[data-theme="dark"] .audit-trail-table tbody tr:hover td {
    background: #1a2a42;
}

:root[data-theme="dark"] .audit-trail-serial,
:root[data-theme="dark"] .audit-trail-avatar {
    background: rgba(139, 184, 255, .10);
    color: #8bb8ff;
}

:root[data-theme="dark"] .audit-trail-date i,
:root[data-theme="dark"] .audit-trail-userid,
:root[data-theme="dark"] .audit-trail-action,
:root[data-theme="dark"] .audit-trail-ip i,
:root[data-theme="dark"] .audit-trail-footer-note i {
    color: #8bb8ff;
}

:root[data-theme="dark"] .audit-trail-role {
    border-color: #29364a;
    background: #172438;
    color: #a7b6cb;
}

:root[data-theme="dark"] .audit-trail-ip {
    color: #a7b6cb;
}

:root[data-theme="dark"] .audit-trail-card .dt-buttons .dt-button {
    border-color: rgba(139, 184, 255, .25);
    background: rgba(139, 184, 255, .07);
    color: #8bb8ff;
}

:root[data-theme="dark"] .audit-trail-card .dt-buttons .dt-button:hover {
    border-color: #3b6fd4;
    background: #3b6fd4;
    color: #fff;
}

:root[data-theme="dark"] .audit-trail-card .dataTables_length,
:root[data-theme="dark"] .audit-trail-card .dataTables_info {
    color: #a7b6cb;
}

:root[data-theme="dark"] .audit-trail-card .dataTables_length select {
    border-color: #29364a;
    background: #172438;
    color: #e5edf8;
}

:root[data-theme="dark"] .audit-trail-card .dataTables_paginate .paginate_button {
    color: #a7b6cb !important;
}

:root[data-theme="dark"] .audit-trail-card .dataTables_paginate .paginate_button.current,
:root[data-theme="dark"] .audit-trail-card .dataTables_paginate .paginate_button.current:hover {
    background: #3b6fd4 !important;
    color: #fff !important;
}

:root[data-theme="dark"] .audit-trail-card .dataTables_empty {
    color: #a7b6cb !important;
}

@media (max-width: 767px) {

    .audit-trail-card > .card-body {
        padding: 14px;
    }

    .audit-trail-heading {
        align-items: flex-start;
    }

    .audit-trail-toolbar,
    .audit-trail-filters {
        width: 100%;
    }

    .audit-trail-search-box {
        width: 100%;
    }

    .audit-trail-filters {
        align-items: stretch;
    }

    .audit-trail-filter {
        flex: 1;
        min-width: 0;
    }

    .audit-trail-clear-btn {
        flex: 1;
    }

    .audit-trail-card .dt-buttons {
        width: 100%;
    }

    .audit-trail-card .dt-buttons .dt-button {
        flex: 1;
    }

}

@media (max-width: 480px) {

    .audit-trail-card > .card-body {
        padding: 11px;
    }

    .audit-trail-total {
        white-space: normal;
    }

    .audit-trail-filters {
        flex-direction: column;
    }

    .audit-trail-filter,
    .audit-trail-clear-btn {
        width: 100%;
        min-height: 40px;
    }

}

</style>


<!-- =========================================================
     DATATABLES EXPORT DEPENDENCIES
     Keep your existing jQuery and DataTables core imports.
     Load these extensions after DataTables core.
========================================================= -->

<link rel="stylesheet"
      href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>

<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>


<!-- =========================================================
     AUDIT TRAIL JAVASCRIPT
========================================================= -->

<script>

(function () {

    'use strict';

    function initialiseAuditTrail() {

        if (!window.jQuery || !jQuery.fn || !jQuery.fn.DataTable) {
            console.error('Audit Trail: jQuery DataTables is not loaded.');
            return;
        }

        if (!jQuery.fn.dataTable.Buttons) {
            console.error('Audit Trail: DataTables Buttons extension is not loaded.');
            return;
        }

        const $ = window.jQuery;
        const tableElement = document.getElementById('dashboardDataTable');

        if (!tableElement) {
            return;
        }

        if ($.fn.DataTable.isDataTable(tableElement)) {
            return;
        }

        const $table = $(tableElement);

        const dateFilter = document.getElementById('auditTrailDateFilter');
        const actionFilter = document.getElementById('auditTrailActionFilter');
        const searchInput = document.getElementById('auditTrailSearch');
        const clearButton = document.getElementById('clearAuditTrailFilters');
        const resultCount = document.getElementById('auditTrailResultCount');

        /*
         * Build the action dropdown from the actual audit records.
         */

        const actions = new Set();

        $table.find('tbody tr').each(function () {

            const action = $(this).find('td').eq(6).text().trim();

            if (action && action !== 'N/A') {
                actions.add(action);
            }

        });

        Array.from(actions)
            .sort(function (a, b) {
                return a.localeCompare(b);
            })
            .forEach(function (action) {

                const option = document.createElement('option');

                option.value = action;
                option.textContent = action;

                actionFilter.appendChild(option);

            });

        /*
         * Custom filters for date and action.
         */

        $.fn.dataTable.ext.search.push(function (
            settings,
            data,
            dataIndex
        ) {

            if (settings.nTable !== tableElement) {
                return true;
            }

            const row = settings.aoData[dataIndex].nTr;

            if (!row) {
                return true;
            }

            const selectedDate = dateFilter.value;
            const selectedAction = actionFilter.value;

            const rowDate = row.cells[1]
                ? row.cells[1].getAttribute('data-date') || ''
                : '';

            const rowAction = row.cells[6]
                ? row.cells[6].textContent.trim()
                : '';

            const matchesDate =
                !selectedDate || rowDate === selectedDate;

            const matchesAction =
                !selectedAction || rowAction === selectedAction;

            return matchesDate && matchesAction;

        });

        const dataTable = $table.DataTable({

            /*
             * Use all eight columns in every table row.
             * Serial numbers are recalculated for the current page.
             */

            autoWidth: false,
            processing: false,
            deferRender: true,
            order: [[1, 'desc']],
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],

            dom:
                '<"audit-dt-top"B l>' +
                'rt' +
                '<"audit-dt-bottom"ip>',

            buttons: [

                {
                    extend: 'excelHtml5',
                    text: '<i class="mdi mdi-microsoft-excel"></i> Excel',
                    title: 'Audit Trail Report',
                    filename: 'audit_trail_' + new Date().toISOString().slice(0, 10),
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'all'
                        }
                    }
                },

                {
                    extend: 'pdfHtml5',
                    text: '<i class="mdi mdi-file-pdf-box"></i> PDF',
                    title: 'Audit Trail Report',
                    filename: 'audit_trail_' + new Date().toISOString().slice(0, 10),
                    orientation: 'landscape',
                    pageSize: 'A3',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'all'
                        }
                    },
                    customize: function (doc) {

                        doc.defaultStyle.fontSize = 8;

                        doc.styles.title = {
                            fontSize: 15,
                            bold: true,
                            alignment: 'left',
                            margin: [0, 0, 0, 12]
                        };

                        doc.styles.tableHeader = {
                            bold: true,
                            fontSize: 8,
                            color: '#ffffff',
                            fillColor: '#3b6fd4'
                        };

                        doc.content.forEach(function (item) {

                            if (item.table) {

                                item.table.widths = [
                                    '5%',
                                    '17%',
                                    '11%',
                                    '17%',
                                    '10%',
                                    '13%',
                                    '17%',
                                    '10%'
                                ];

                                item.layout = 'lightHorizontalLines';

                            }

                        });

                    }
                },

                {
                    extend: 'csvHtml5',
                    text: '<i class="mdi mdi-file-delimited-outline"></i> CSV',
                    title: 'Audit Trail Report',
                    filename: 'audit_trail_' + new Date().toISOString().slice(0, 10),
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'all'
                        }
                    }
                },

                {
                    extend: 'print',
                    text: '<i class="mdi mdi-printer-outline"></i> Print',
                    title: 'Audit Trail Report',
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4, 5, 6, 7],
                        modifier: {
                            search: 'applied',
                            order: 'applied',
                            page: 'all'
                        }
                    }
                }

            ],

            columnDefs: [
                {
                    targets: 0,
                    searchable: false,
                    orderable: false
                }
            ],

            language: {
                emptyTable: 'No audit trail records found',
                zeroRecords: 'No matching audit trail records found',
                lengthMenu: 'Show _MENU_ records',
                info: 'Showing _START_ to _END_ of _TOTAL_ records',
                infoEmpty: 'Showing 0 to 0 of 0 records',
                infoFiltered: '(filtered from _MAX_ total records)',
                paginate: {
                    previous: 'Previous',
                    next: 'Next'
                }
            },

            drawCallback: function () {

                const api = this.api();
                const pageInfo = api.page.info();

                api.column(0, {
                    page: 'current',
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function (cell, index) {

                    cell.innerHTML =
                        '<span class="audit-trail-serial">' +
                        (pageInfo.start + index + 1) +
                        '</span>';

                });

                resultCount.textContent =
                    'Showing ' + pageInfo.recordsDisplay +
                    ' matching audit trail record(s)';

            }

        });

        /*
         * Global search.
         */

        searchInput.addEventListener('input', function () {
            dataTable.search(this.value).draw();
        });

        /*
         * Action and date filters.
         */

        actionFilter.addEventListener('change', function () {
            dataTable.draw();
        });

        dateFilter.addEventListener('change', function () {
            dataTable.draw();
        });

        /*
         * Clear every filter.
         */

        clearButton.addEventListener('click', function () {

            searchInput.value = '';
            dateFilter.value = '';
            actionFilter.value = '';

            dataTable.search('').draw();

        });

    }

    if (document.readyState === 'loading') {

        document.addEventListener(
            'DOMContentLoaded',
            initialiseAuditTrail
        );

    } else {

        initialiseAuditTrail();

    }

})();

</script>