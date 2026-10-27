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

/*
|--------------------------------------------------------------------------
| Tickets data
|--------------------------------------------------------------------------
| Loaded in the controller:
|   $tb_name = "ticket_reports";
|   $LoadAllTickets = $callUserModel->GeneralSelectAnyTable($tb_name);
|
| Expected columns (full ticket_reports schema):
|   date_created, date_updated, ticket_id, name, priority,
|   corridor, subject, category, status_text, incidence_date,
|   note, userid, role, owner, subcontractor, noofsubcontractors,
|   email, pipeline, pipeline_type, message, phone_no,
|   incidence_source, state, community, operator, zone,
|   number_of_arrested_suspects, vehicle_arrested_destroyed,
|   wooden_boat_speed_boat_arrested_destroyed,
|   vessel_arrested_destroyed, location_coordinate_latitude,
|   location_coordinate_longitude, quantity_of_crude_recovered_destroyed_ltr,
|   quantity_of_ago_recovered_destroyed_ltr,
|   quantity_of_pms_recovered_destroyed_ltr,
|   description_of_reported_incidence, illegal_storage_dump_sites,
|   dpk_recovered_destroyed_ltr, due_date, attachments
*/
$tickets = isset($LoadAllTickets) && is_array($LoadAllTickets)
    ? $LoadAllTickets
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

/*
|--------------------------------------------------------------------------
| Resolve a numeric state ID to its actual state name.
| Mirrors the tickets page logic:
|   foreach ($LoadAllNigeriaStates as $state) {
|       if ((int)$state['id'] === (int)$ticket_history['state']) { ... }
|   }
|
| NOTE: the states array is passed in explicitly because $LoadAllNigeriaStates
| is in scope of the required view but NOT in the global scope, so a
| `global $LoadAllNigeriaStates;` lookup inside this function would return
| NULL. Passing it in as a parameter makes the lookup reliable.
|--------------------------------------------------------------------------
*/
function exportTicketStateName($ticket, $statesLookup = null)
{
    $stateRaw = exportTicketValue($ticket, ['state']);

    if ($stateRaw === '' || $stateRaw === null) {
        return '';
    }

    // Already a name (non-numeric) — return as-is.
    if (!is_numeric($stateRaw)) {
        return (string) $stateRaw;
    }

    if (is_array($statesLookup)) {
        foreach ($statesLookup as $stateRow) {
            if ((int)($stateRow['id'] ?? -1) === (int)$stateRaw) {
                return (string) ($stateRow['name'] ?? $stateRaw);
            }
        }
    }

    // Fallback: couldn't resolve, return the raw value.
    return (string) $stateRaw;
}

/*
|--------------------------------------------------------------------------
| Merge subcontractor names + counts into a single display string.
| e.g. "edwin(2), Jeff(3)"
|--------------------------------------------------------------------------
*/
function exportTicketSubcontractors($ticket)
{
    $namesRaw = trim((string) exportTicketValue($ticket, ['subcontractor']));
    $countsRaw = trim((string) exportTicketValue($ticket, ['noofsubcontractors']));

    if ($namesRaw === '' && $countsRaw === '') {
        return '';
    }

    $nameParts = array_values(array_filter(array_map('trim', preg_split('/[,;|\r\n]+/', $namesRaw))));
    $countParts = array_values(array_filter(array_map('trim', preg_split('/[,;|\r\n]+/', $countsRaw))));

    $combined = [];

    foreach ($nameParts as $index => $name) {
        if ($name === '') {
            continue;
        }

        $count = isset($countParts[$index]) ? $countParts[$index] : '';

        $combined[] = $count !== ''
            ? $name . '(' . $count . ')'
            : $name;
    }

    if (empty($combined)) {
        return $countsRaw;
    }

    return implode(', ', $combined);
}

/*
|--------------------------------------------------------------------------
| Parse subcontractor name/count pairs into an associative array.
|   "jeff, james" + "2, 4"  =>  ["jeff" => "2", "james" => "4"]
|--------------------------------------------------------------------------
*/
function exportTicketSubcontractorPairs($ticket)
{
    $namesRaw = trim((string) exportTicketValue($ticket, ['subcontractor']));
    $countsRaw = trim((string) exportTicketValue($ticket, ['noofsubcontractors']));

    if ($namesRaw === '' && $countsRaw === '') {
        return [];
    }

    $nameParts = array_values(array_filter(array_map('trim', preg_split('/[,;|\r\n]+/', $namesRaw))));
    $countParts = array_values(array_filter(array_map('trim', preg_split('/[,;|\r\n]+/', $countsRaw))));

    $pairs = [];

    foreach ($nameParts as $index => $name) {
        if ($name === '') {
            continue;
        }

        $count = isset($countParts[$index]) ? $countParts[$index] : '';
        // Preserve first-seen casing for the column header.
        $key = strtolower($name);

        if (!isset($pairs[$key])) {
            $pairs[$key] = [
                'name'  => $name,
                'count' => $count
            ];
        } else {
            // Duplicate name within one ticket — sum the counts.
            $existing = $pairs[$key]['count'];
            if ($existing !== '' || $count !== '') {
                $pairs[$key]['count'] = (string) ((float) $existing + (float) $count);
            }
        }
    }

    return $pairs;
}

/*
|--------------------------------------------------------------------------
| Full export column map — every column in ticket_reports.
| The on-screen summary table uses only a subset of these.
|
| NOTE: the "Subcontractor" column is no longer exported as a single
| combined string. Instead, the Excel exporter splits it into one
| column per subcontractor name found in the filtered data, e.g.
|   Subcontractor (jeff) | Subcontractor (james) | ...
| Each ticket row shows that subcontractor's count (or blank if n/a).
|
| NOTE: "User ID" and "Message" columns have been removed.
| NOTE: "State" now resolves to the actual state name.
|--------------------------------------------------------------------------
*/
$exportColumns = [
    ['label' => 'S/N',                                            'keys' => null],
    ['label' => 'Ticket ID',                                      'keys' => ['ticket_id', 'ticketid', 'id', 'refid', 'sn']],
    ['label' => 'Subject',                                        'keys' => ['subject', 'complaint', 'title', 'ticket_subject']],
    ['label' => 'Category',                                       'keys' => ['category', 'category_name', 'ticket_category']],
    ['label' => 'Corridor',                                       'keys' => ['corridor']],
    ['label' => 'Status',                                         'keys' => ['status_text', 'status', 'status_name']],
    ['label' => 'Priority',                                       'keys' => ['priority', 'priority_name']],
    ['label' => 'Name',                                           'keys' => ['name', 'full_name', 'reporter_name', 'created_by']],
    ['label' => 'Incidence Date',                                 'keys' => ['incidence_date']],
    ['label' => 'Created',                                        'keys' => ['date_created', 'created_at', 'date', 'created']],
    ['label' => 'Updated',                                        'keys' => ['date_updated', 'updated_at', 'last_updated', 'updated']],
    ['label' => 'Note',                                           'keys' => ['note']],
    ['label' => 'Role',                                           'keys' => ['role']],
    ['label' => 'Owner',                                          'keys' => ['owner']],
    ['label' => 'Subcontractor',                                  'keys' => ['__subcontractor_combined__']],
    ['label' => 'Email',                                          'keys' => ['email']],
    ['label' => 'Pipeline',                                       'keys' => ['pipeline']],
    ['label' => 'Pipeline Type',                                  'keys' => ['pipeline_type']],
    ['label' => 'Phone No',                                       'keys' => ['phone_no']],
    ['label' => 'Incidence Source',                               'keys' => ['incidence_source']],
    ['label' => 'State',                                          'keys' => ['__state_name__']],
    ['label' => 'Community',                                      'keys' => ['community']],
    ['label' => 'Operator',                                       'keys' => ['operator']],
    ['label' => 'Zone',                                           'keys' => ['zone']],
    ['label' => 'No. of Arrested Suspects',                       'keys' => ['number_of_arrested_suspects']],
    ['label' => 'Vehicle Arrested/Destroyed',                     'keys' => ['vehicle_arrested_destroyed']],
    ['label' => 'Wooden Boat/Speed Boat Arrested/Destroyed',      'keys' => ['wooden_boat_speed_boat_arrested_destroyed']],
    ['label' => 'Vessel Arrested/Destroyed',                      'keys' => ['vessel_arrested_destroyed']],
    ['label' => 'Location Coordinate Latitude',                   'keys' => ['location_coordinate_latitude']],
    ['label' => 'Location Coordinate Longitude',                  'keys' => ['location_coordinate_longitude']],
    ['label' => 'Qty Crude Recovered/Destroyed (Ltr)',            'keys' => ['quantity_of_crude_recovered_destroyed_ltr']],
    ['label' => 'Qty AGO Recovered/Destroyed (Ltr)',              'keys' => ['quantity_of_ago_recovered_destroyed_ltr']],
    ['label' => 'Qty PMS Recovered/Destroyed (Ltr)',              'keys' => ['quantity_of_pms_recovered_destroyed_ltr']],
    ['label' => 'Description of Reported Incidence',              'keys' => ['description_of_reported_incidence']],
    ['label' => 'Illegal Storage Dump Sites',                     'keys' => ['illegal_storage_dump_sites']],
    ['label' => 'DPK Recovered/Destroyed (Ltr)',                  'keys' => ['dpk_recovered_destroyed_ltr']],
    ['label' => 'Due Date',                                       'keys' => ['due_date']],
];
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

    .export-tickets-btn:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    .export-table-wrapper {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Hidden table used only as a data source for PDF/Excel export */
    .export-source-table {
        display: none;
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
                    Filter tickets and export the results to PDF or Excel. Exports include all ticket fields.
                </div>

                <!-- Date range, From and To -->
                <div class="export-date-filter-row">

                    <div class="export-filter-section">
                        <label class="export-filter-label" for="exportDatePreset">
                            Date range
                        </label>

                        <select id="exportDatePreset" class="export-filter-control">
                            <option value="this_month" selected>This month (<?php echo date('F'); ?>)</option>
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
                            <?php
                            $statusOptions = [];
                            foreach ($tickets as $ticketRow) {
                                $rowStatus = trim((string) exportTicketValue($ticketRow, ['status_text', 'status']));
                                if ($rowStatus !== '') {
                                    $statusOptions[strtolower($rowStatus)] = $rowStatus;
                                }
                            }
                            ksort($statusOptions);
                            foreach ($statusOptions as $statusValue => $statusLabel): ?>
                                <option value="<?php echo htmlspecialchars($statusValue, ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars(ucfirst($statusLabel), ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="export-filter-section">
                        <label class="export-filter-label" for="exportPriority">
                            Priority
                        </label>

                        <select id="exportPriority" class="export-filter-control">
                            <option value="">All priorities</option>
                            <?php
                            $priorityOptions = [];
                            foreach ($tickets as $ticketRow) {
                                $rowPriority = trim((string) exportTicketValue($ticketRow, ['priority']));
                                if ($rowPriority !== '') {
                                    $priorityOptions[strtolower($rowPriority)] = $rowPriority;
                                }
                            }
                            ksort($priorityOptions);
                            foreach ($priorityOptions as $priorityValue => $priorityLabel): ?>
                                <option value="<?php echo htmlspecialchars($priorityValue, ENT_QUOTES, 'UTF-8'); ?>">
                                    <?php echo htmlspecialchars(ucfirst($priorityLabel), ENT_QUOTES, 'UTF-8'); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                </div>

                <div class="export-action-row">
                    <span class="export-hint">
                        <i class="bi bi-info-circle"></i>
                        Only filtered tickets will be exported. Exports include all ticket fields.
                    </span>

                    <div class="export-action-buttons">
                        <!-- <button type="button" id="exportTicketsPdf" class="export-tickets-btn">
                            <i class="bi bi-file-earmark-pdf"></i>
                            Export PDF
                        </button> -->

                        <button type="button" id="exportTicketsExcel" class="export-tickets-btn primary">
                            <i class="bi bi-file-earmark-excel"></i>
                            Export Excel
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ============================================================
         ON-SCREEN SUMMARY TABLE (unchanged)
         ============================================================ -->
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
                                <th>Corridor</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Name</th>
                                <th>Incidence Date</th>
                                <th>Created</th>
                                <th>Updated</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $serialNumber = 0;

                            foreach ($tickets as $ticket):
                                $serialNumber++;

                                $ticketId = exportTicketValue($ticket, ['ticket_id', 'ticketid', 'id', 'refid', 'sn']);
                                $subject = exportTicketValue($ticket, ['subject', 'complaint', 'title', 'ticket_subject']);
                                $category = exportTicketValue($ticket, ['category', 'category_name', 'ticket_category']);
                                $status = exportTicketValue($ticket, ['status_text', 'status', 'status_name']);
                                $priority = exportTicketValue($ticket, ['priority', 'priority_name']);
                                $corridor = exportTicketValue($ticket, ['corridor']);
                                $name = exportTicketValue($ticket, ['name', 'full_name', 'reporter_name', 'created_by']);

                                $incidenceRaw = exportTicketValue($ticket, ['incidence_date']);
                                $createdRaw = exportTicketValue($ticket, ['date_created', 'created_at', 'date', 'created']);
                                $updatedRaw = exportTicketValue($ticket, ['date_updated', 'updated_at', 'last_updated', 'updated']);

                                $createdDate = exportTicketDate($createdRaw);
                                $incidenceDate = exportTicketDate($incidenceRaw);
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
                                    data-incidence-date="<?php echo htmlspecialchars($incidenceDate, ENT_QUOTES, 'UTF-8'); ?>"
                                    data-status="<?php echo htmlspecialchars($statusLower, ENT_QUOTES, 'UTF-8'); ?>"
                                    data-priority="<?php echo htmlspecialchars($priorityLower, ENT_QUOTES, 'UTF-8'); ?>"
                                >
                                    <td><?php echo $serialNumber; ?></td>

                                    <td><?php echo htmlspecialchars((string) $ticketId, ENT_QUOTES, 'UTF-8'); ?></td>

                                    <td><?php echo htmlspecialchars((string) $subject, ENT_QUOTES, 'UTF-8'); ?></td>

                                    <td><?php echo htmlspecialchars((string) $category, ENT_QUOTES, 'UTF-8'); ?></td>

                                    <td><?php echo htmlspecialchars((string) $corridor, ENT_QUOTES, 'UTF-8'); ?></td>

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

                                    <td><?php echo htmlspecialchars((string) $name, ENT_QUOTES, 'UTF-8'); ?></td>

                                    <td data-order="<?php echo htmlspecialchars((string) $incidenceRaw, ENT_QUOTES, 'UTF-8'); ?>">
                                        <?php echo htmlspecialchars(exportTicketDate($incidenceRaw), ENT_QUOTES, 'UTF-8'); ?>
                                    </td>

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

    <!-- ============================================================
         HIDDEN EXPORT SOURCE TABLE
         Contains every ticket_reports column so the exported
         PDF/Excel can include fields not shown in the summary.
         One <tr> per ticket, with the same filter data-attributes
         used by the summary table so filters apply identically.

         The "Subcontractor" column carries the COMBINED display
         string ("jeff(2), james(4)") as plain text. The Excel
         exporter IGNORES that cell and instead rebuilds the
         subcontractor breakdown from the data-sc-pairs attribute
         (JSON of {name: count}).

         User ID and Message columns have been removed.
         The "State" column carries the resolved state NAME.
         ============================================================ -->
    <table id="exportSourceTable" class="export-source-table" aria-hidden="true">
        <thead>
            <tr>
                <?php foreach ($exportColumns as $col): ?>
                    <th><?php echo htmlspecialchars($col['label'], ENT_QUOTES, 'UTF-8'); ?></th>
                <?php endforeach; ?>
            </tr>
        </thead>
        <tbody>
            <?php
            $exportSerial = 0;

            foreach ($tickets as $ticket):
                $exportSerial++;

                $createdRaw = exportTicketValue($ticket, ['date_created', 'created_at', 'date', 'created']);
                $incidenceRaw = exportTicketValue($ticket, ['incidence_date']);
                $createdDate = exportTicketDate($createdRaw);
                $incidenceDate = exportTicketDate($incidenceRaw);

                $statusRaw = exportTicketValue($ticket, ['status_text', 'status', 'status_name']);
                $priorityRaw = exportTicketValue($ticket, ['priority', 'priority_name']);
                $statusLower = strtolower(trim((string) $statusRaw));
                $priorityLower = strtolower(trim((string) $priorityRaw));

                // Build the subcontractor pairs for this ticket and
                // serialise them for the Excel exporter.
                $subPairs = exportTicketSubcontractorPairs($ticket);
                $subPairsJson = htmlspecialchars(json_encode($subPairs), ENT_QUOTES, 'UTF-8');
            ?>
                <tr
                    data-created-date="<?php echo htmlspecialchars($createdDate, ENT_QUOTES, 'UTF-8'); ?>"
                    data-incidence-date="<?php echo htmlspecialchars($incidenceDate, ENT_QUOTES, 'UTF-8'); ?>"
                    data-status="<?php echo htmlspecialchars($statusLower, ENT_QUOTES, 'UTF-8'); ?>"
                    data-priority="<?php echo htmlspecialchars($priorityLower, ENT_QUOTES, 'UTF-8'); ?>"
                    data-sc-pairs="<?php echo $subPairsJson; ?>"
                >
                    <?php foreach ($exportColumns as $col): ?>
                        <?php
                        if ($col['keys'] === null) {
                            // S/N column
                            echo '<td>' . $exportSerial . '</td>';
                            continue;
                        }

                        // Combined subcontractor column
                        if (in_array('__subcontractor_combined__', $col['keys'], true)) {
                            echo '<td>' . htmlspecialchars(exportTicketSubcontractors($ticket), ENT_QUOTES, 'UTF-8') . '</td>';
                            continue;
                        }

                        // State column — resolve numeric ID to state name
                        if (in_array('__state_name__', $col['keys'], true)) {
                            echo '<td>' . htmlspecialchars(exportTicketStateName($ticket, $LoadAllNigeriaStates ?? []), ENT_QUOTES, 'UTF-8') . '</td>';
                            continue;
                        }

                        $rawValue = exportTicketValue($ticket, $col['keys']);

                        // Format date-like columns for readability
                        if (in_array('incidence_date', $col['keys'], true)) {
                            $display = exportTicketDate($rawValue);
                        } elseif (
                            in_array('date_created', $col['keys'], true) ||
                            in_array('created_at', $col['keys'], true)
                        ) {
                            $display = exportTicketDateTime($rawValue);
                        } elseif (
                            in_array('date_updated', $col['keys'], true) ||
                            in_array('updated_at', $col['keys'], true) ||
                            in_array('last_updated', $col['keys'], true)
                        ) {
                            $display = exportTicketDateTime($rawValue);
                        } else {
                            $display = $rawValue;
                        }

                        echo '<td>' . htmlspecialchars((string) $display, ENT_QUOTES, 'UTF-8') . '</td>';
                        ?>
                    <?php endforeach; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
(function () {
    'use strict';

    /* ------------------------------------------------------------
       Load PDF/Excel export dependencies once.
       ------------------------------------------------------------ */
    var EXPORT_ASSETS = [
        'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js',
        'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js'
    ];

    var assetsPromise = null;

    function loadScript(src) {
        return new Promise(function (resolve, reject) {
            var existing = document.querySelector('script[data-export-asset="' + src + '"]');

            if (existing) {
                if (existing.getAttribute('data-loaded') === '1') {
                    resolve();
                } else {
                    existing.addEventListener('load', function () { resolve(); });
                    existing.addEventListener('error', function () { reject(new Error('Failed to load ' + src)); });
                }
                return;
            }

            var script = document.createElement('script');
            script.src = src;
            script.async = false;
            script.setAttribute('data-export-asset', src);

            script.onload = function () {
                script.setAttribute('data-loaded', '1');
                resolve();
            };
            script.onerror = function () {
                reject(new Error('Failed to load ' + src));
            };

            document.head.appendChild(script);
        });
    }

    function loadExportAssets() {
        if (assetsPromise) {
            return assetsPromise;
        }

        assetsPromise = EXPORT_ASSETS.reduce(function (chain, src) {
            return chain.then(function () { return loadScript(src); });
        }, Promise.resolve());

        return assetsPromise;
    }

    function initialiseExportTickets() {
        if (!window.jQuery || !jQuery.fn || !jQuery.fn.DataTable) {
            return;
        }

        var $ = jQuery;
        var tableElement = document.getElementById('dashboardDataTable');
        var exportSourceTable = document.getElementById('exportSourceTable');

        if (!tableElement || !exportSourceTable) {
            return;
        }

        if (!$.fn.DataTable.isDataTable(tableElement)) {
            $(tableElement).DataTable({
                pageLength: 10,
                lengthMenu: [10, 25, 50, 100],
                autoWidth: false,
                order: [[0, 'asc']],
                dom: 'lfrtip',           // no Buttons — export is custom
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

        function currentFilters() {
            return {
                fromDate: document.getElementById('exportDateFrom').value,
                toDate: document.getElementById('exportDateTo').value,
                status: normalise(document.getElementById('exportStatus').value),
                priority: normalise(document.getElementById('exportPriority').value),
                order: document.getElementById('exportOrder').value
            };
        }

        function applyFilters() {
            var filters = currentFilters();

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

                if (filters.fromDate && (!rowDate || rowDate < filters.fromDate)) {
                    return false;
                }

                if (filters.toDate && (!rowDate || rowDate > filters.toDate)) {
                    return false;
                }

                if (filters.status && rowStatus !== filters.status) {
                    return false;
                }

                if (filters.priority && rowPriority !== filters.priority) {
                    return false;
                }

                return true;
            };

            ticketFilter._exportTicketsFilter = true;
            $.fn.dataTable.ext.search.push(ticketFilter);

            table.order([0, filters.order]).draw();
        }

        /* --------------------------------------------------------
           Collect matching rows from the hidden export source
           table, honouring the same filters as the summary.
           -------------------------------------------------------- */
        function collectExportRows() {
            var filters = currentFilters();
            var rows = exportSourceTable.querySelectorAll('tbody tr');
            var result = [];

            Array.prototype.forEach.call(rows, function (row) {
                var rowDate = row.getAttribute('data-created-date') || '';
                var rowStatus = normalise(row.getAttribute('data-status'));
                var rowPriority = normalise(row.getAttribute('data-priority'));

                if (filters.fromDate && (!rowDate || rowDate < filters.fromDate)) {
                    return;
                }

                if (filters.toDate && (!rowDate || rowDate > filters.toDate)) {
                    return;
                }

                if (filters.status && rowStatus !== filters.status) {
                    return;
                }

                if (filters.priority && rowPriority !== filters.priority) {
                    return;
                }

                result.push(row);
            });

            return result;
        }

        function getExportHeaders() {
            return Array.prototype.map.call(
                exportSourceTable.querySelectorAll('thead th'),
                function (th) { return th.textContent.trim(); }
            );
        }

        function getRowCells(row) {
            return Array.prototype.map.call(
                row.querySelectorAll('td'),
                function (td) { return td.textContent.trim(); }
            );
        }

        /* --------------------------------------------------------
           Parse a row's data-sc-pairs JSON into
           { lowercaseName: {name, count} }
           -------------------------------------------------------- */
        function getRowSubcontractorPairs(row) {
            var raw = row.getAttribute('data-sc-pairs') || '';
            var pairs = {};

            if (!raw) {
                return pairs;
            }

            try {
                pairs = JSON.parse(raw) || {};
            } catch (e) {
                pairs = {};
            }

            return pairs;
        }

        /* --------------------------------------------------------
           Build the Excel table. Subcontractor names are NOT a
           single column; every distinct subcontractor found in the
           filtered rows becomes its own column:
               "Subcontractor (jeff)", "Subcontractor (james)", ...
           and each row shows that subcontractor's count (or blank).

           Column order:
             1. All columns before "Subcontractor" (as defined)
             2. One column per distinct subcontractor (sorted A-Z)
             3. All columns after "Subcontractor"
           -------------------------------------------------------- */
        function buildExcelTable(rows) {
            var rawHeaders = getExportHeaders();
            var subIndex = rawHeaders.indexOf('Subcontractor');

            if (subIndex === -1) {
                // No subcontractor column found — export as-is.
                return {headers: rawHeaders, data: rows.map(getRowCells)};
            }

            var beforeHeaders = rawHeaders.slice(0, subIndex);
            var afterHeaders = rawHeaders.slice(subIndex + 1);

            // Collect all distinct subcontractor names across the
            // filtered rows, keeping first-seen casing for the label
            // and sorting by lowercase name for a stable column order.
            var subNameMap = {}; // lowerName -> displayName

            rows.forEach(function (row) {
                var pairs = getRowSubcontractorPairs(row);

                Object.keys(pairs).forEach(function (lowerName) {
                    if (!subNameMap[lowerName]) {
                        subNameMap[lowerName] = pairs[lowerName].name || lowerName;
                    }
                });
            });

            var subKeys = Object.keys(subNameMap).sort(function (a, b) {
                return a.localeCompare(b);
            });

            var subHeaders = subKeys.map(function (key) {
                return 'Subcontractor (' + subNameMap[key] + ')';
            });

            var headers = beforeHeaders.concat(subHeaders, afterHeaders);

            var data = rows.map(function (row) {
                var cells = getRowCells(row);
                var before = cells.slice(0, subIndex);
                var after = cells.slice(subIndex + 1);
                var pairs = getRowSubcontractorPairs(row);

                var subCells = subKeys.map(function (key) {
                    var entry = pairs[key];
                    return entry && entry.count !== '' && entry.count !== undefined
                        ? String(entry.count)
                        : '';
                });

                return before.concat(subCells, after);
            });

            return {headers: headers, data: data};
        }

        /* --------------------------------------------------------
           Excel export (client-side, no DataTables Buttons needed)
           -------------------------------------------------------- */
        function exportToExcel() {
            var rows = collectExportRows();

            if (!rows.length) {
                window.alert('No tickets match the current filters.');
                return;
            }

            var built = buildExcelTable(rows);
            var headers = built.headers;
            var dataRows = built.data;

            var html = '<table border="1"><thead><tr>';

            headers.forEach(function (h) {
                html += '<th>' + escapeHtml(h) + '</th>';
            });

            html += '</tr></thead><tbody>';

            dataRows.forEach(function (cells) {
                html += '<tr>';
                cells.forEach(function (c) {
                    html += '<td>' + escapeHtml(c) + '</td>';
                });
                html += '</tr>';
            });

            html += '</tbody></table>';

            var blob = new Blob(
                ['\ufeff<html><head><meta charset="utf-8"></head><body>' + html + '</body></html>'],
                {type: 'application/vnd.ms-excel;charset=utf-8'}
            );

            downloadBlob(blob, 'export_tickets_' + timestampSlug() + '.xls');
        }

        /* --------------------------------------------------------
           PDF export (client-side via pdfmake)
           -------------------------------------------------------- */
        function exportToPdf() {
            var rows = collectExportRows();

            if (!rows.length) {
                window.alert('No tickets match the current filters.');
                return;
            }

            if (!window.pdfMake || !window.pdfMake.vfs) {
                window.alert('PDF library is still loading. Please try again in a moment.');
                return;
            }

            var headers = getExportHeaders();
            var body = [headers.map(function (h) {
                return {text: h, style: 'tableHeader', bold: true};
            })];

            rows.forEach(function (row) {
                var cells = getRowCells(row).map(function (c) {
                    return {text: c, style: 'tableCell'};
                });
                body.push(cells);
            });

            var docDefinition = {
                pageOrientation: 'landscape',
                pageSize: 'A3',
                pageMargins: [20, 25, 20, 25],
                content: [
                    {text: 'Export Tickets', style: 'title'},
                    {text: 'Generated: ' + new Date().toLocaleString(), style: 'subtitle'},
                    {text: '\n'},
                    {
                        table: {
                            headerRows: 1,
                            body: body
                        },
                        layout: 'lightHorizontalLines'
                    }
                ],
                styles: {
                    title: {fontSize: 14, bold: true, margin: [0, 0, 0, 4]},
                    subtitle: {fontSize: 9, color: '#666666'},
                    tableHeader: {fontSize: 8, bold: true, fillColor: '#eef2f7'},
                    tableCell: {fontSize: 8}
                },
                defaultStyle: {
                    fontSize: 8
                }
            };

            window.pdfMake.createPdf(docDefinition).download('export_tickets_' + timestampSlug() + '.pdf');
        }

        function escapeHtml(value) {
            return String(value)
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#39;');
        }

        function timestampSlug() {
            var d = new Date();
            function pad(n) { return String(n).padStart(2, '0'); }
            return d.getFullYear() + pad(d.getMonth() + 1) + pad(d.getDate())
                + '_' + pad(d.getHours()) + pad(d.getMinutes()) + pad(d.getSeconds());
        }

        function downloadBlob(blob, filename) {
            var url = URL.createObjectURL(blob);
            var a = document.createElement('a');
            a.href = url;
            a.download = filename;
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            setTimeout(function () { URL.revokeObjectURL(url); }, 0);
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
                exportToExcel();
            });

        /* PDF export button commented out
        $('#exportTicketsPdf')
            .off('click.exportTickets')
            .on('click.exportTickets', function () {
                exportToPdf();
            });
        */

        applyFilters();

        /* Pre-load pdfmake so the PDF button is ready immediately. */
        loadExportAssets().catch(function (error) {
            console.error('Failed to load export libraries:', error);
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialiseExportTickets);
    } else {
        initialiseExportTickets();
    }
})();
</script>