
<?php

$table_name = "tickets";
$report_start_date = $_GET['from_date'] ?? '2026-10-01';
$report_end_date = $_GET['to_date'] ?? '2026-10-09';
$report_type = $_GET['report_type'] ?? 'tickets_per_day';

$report_start_date = preg_match('/^\d{4}-\d{2}-\d{2}$/', $report_start_date)
    ? $report_start_date : '2026-10-01';

$report_end_date = preg_match('/^\d{4}-\d{2}-\d{2}$/', $report_end_date)
    ? $report_end_date : '2026-10-09';

$sample_report = [
    ['date' => '2026-10-01', 'new_tickets' => 3,  'open' => 1,  'resolved' => 2, 'time_worked' => '00:00:21'],
    ['date' => '2026-10-02', 'new_tickets' => 8,  'open' => 1,  'resolved' => 7, 'time_worked' => '00:13:49'],
    ['date' => '2026-10-03', 'new_tickets' => 4,  'open' => 3,  'resolved' => 1, 'time_worked' => '00:02:39'],
    ['date' => '2026-10-04', 'new_tickets' => 10, 'open' => 3,  'resolved' => 7, 'time_worked' => '00:01:20'],
    ['date' => '2026-10-05', 'new_tickets' => 8,  'open' => 2,  'resolved' => 6, 'time_worked' => '07:18:44'],
    ['date' => '2026-10-06', 'new_tickets' => 3,  'open' => 1,  'resolved' => 2, 'time_worked' => ''],
    ['date' => '2026-10-07', 'new_tickets' => 4,  'open' => 1,  'resolved' => 3, 'time_worked' => ''],
    ['date' => '2026-10-08', 'new_tickets' => 13, 'open' => 11, 'resolved' => 2, 'time_worked' => '01:00:50'],
    ['date' => '2026-10-09', 'new_tickets' => 1,  'open' => 1,  'resolved' => 0, 'time_worked' => ''],
];

$report_rows = isset($LoadTicketsPerDayReport) && is_array($LoadTicketsPerDayReport)
    ? $LoadTicketsPerDayReport
    : $sample_report;

$report_rows = array_values(array_filter($report_rows, function ($row) use ($report_start_date, $report_end_date) {
    $date = $row['date'] ?? '';
    return $date >= $report_start_date && $date <= $report_end_date;
}));

usort($report_rows, function ($a, $b) {
    return strcmp($a['date'] ?? '', $b['date'] ?? '');
});

$total_new = 0;
$total_open = 0;
$total_resolved = 0;
$total_seconds = 0;

foreach ($report_rows as $row) {
    $total_new += (int)($row['new_tickets'] ?? 0);
    $total_open += (int)($row['open'] ?? 0);
    $total_resolved += (int)($row['resolved'] ?? 0);

    $time = trim((string)($row['time_worked'] ?? ''));

    if ($time !== '' && preg_match('/^\d+:\d{2}:\d{2}$/', $time)) {
        [$hours, $minutes, $seconds] = array_map('intval', explode(':', $time));
        $total_seconds += ($hours * 3600) + ($minutes * 60) + $seconds;
    }
}

$total_time = sprintf(
    '%02d:%02d:%02d',
    intdiv($total_seconds, 3600),
    intdiv($total_seconds % 3600, 60),
    $total_seconds % 60
);

$format_report_date = function ($date) {
    $timestamp = strtotime($date);
    return $timestamp !== false
        ? date('l, F j, Y', $timestamp)
        : 'Invalid date';
};

$report_period = $report_rows
    ? date('F j, Y', strtotime($report_rows[0]['date'])) . ' - ' .
      date('F j, Y', strtotime($report_rows[count($report_rows) - 1]['date']))
    : 'No report data for the selected period';

?>

<div class="row run-reports-row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card run-reports-card">
            <div class="card-body">

                <div class="run-reports-heading">
                    <div>
                        <h4 class="card-title mb-1">Run Reports</h4>
                        <p class="text-muted mb-0">
                            Generate and export ticket activity reports.
                        </p>
                    </div>

                    <div class="run-reports-total">
                        <i class="mdi mdi-chart-box-outline"></i>
                        <span>
                            Report records:
                            <strong><?= number_format(count($report_rows)) ?></strong>
                        </span>
                    </div>
                </div>

                <form method="GET" class="run-reports-filters" id="runReportsForm">

                    <?php if (isset($_GET['action'])): ?>
                        <input type="hidden" name="action"
                               value="<?= htmlspecialchars($_GET['action'], ENT_QUOTES, 'UTF-8') ?>">
                    <?php endif; ?>

                    <div class="run-report-field">
                        <label for="reportRange">Date range</label>
                        <select id="reportRange" class="run-report-input">
                            <option value="this_month">This month</option>
                            <option value="last_month">Last month</option>
                            <option value="last_7_days">Last 7 days</option>
                            <option value="last_30_days">Last 30 days</option>
                            <option value="custom">Custom date range</option>
                        </select>
                    </div>

                    <div class="run-report-field">
                        <label for="fromDate">From</label>
                        <input type="date" name="from_date" id="fromDate"
                               class="run-report-input"
                               value="<?= htmlspecialchars($report_start_date, ENT_QUOTES, 'UTF-8') ?>"
                               required>
                    </div>

                    <div class="run-report-field">
                        <label for="toDate">To</label>
                        <input type="date" name="to_date" id="toDate"
                               class="run-report-input"
                               value="<?= htmlspecialchars($report_end_date, ENT_QUOTES, 'UTF-8') ?>"
                               required>
                    </div>

                    <div class="run-report-field">
                        <label for="reportType">Report type</label>
                        <select name="report_type" id="reportType" class="run-report-input">
                            <option value="tickets_per_day"
                                <?= $report_type === 'tickets_per_day' ? 'selected' : '' ?>>
                                Tickets per day
                            </option>
                        </select>
                    </div>

                    <div class="run-report-field run-report-submit">
                        <label>&nbsp;</label>
                        <button type="submit" class="run-report-display-btn">
                            <i class="mdi mdi-chart-bar"></i>
                            Display Report
                        </button>
                    </div>

                </form>

                <div class="run-report-summary">
                    <div class="run-report-summary-heading">
                        <div>
                            <h5>Tickets per day</h5>
                            <p><?= htmlspecialchars($report_period, ENT_QUOTES, 'UTF-8') ?></p>
                        </div>
                        <span class="run-report-period-badge">
                            <i class="mdi mdi-calendar-range"></i>
                            <?= count($report_rows) ?> days
                        </span>
                    </div>

                    <div class="run-report-stats">
                        <div class="run-report-stat new-stat">
                            <span>New tickets</span>
                            <strong><?= number_format($total_new) ?></strong>
                        </div>

                        <div class="run-report-stat open-stat">
                            <span>Open</span>
                            <strong><?= number_format($total_open) ?></strong>
                        </div>

                        <div class="run-report-stat resolved-stat">
                            <span>Resolved</span>
                            <strong><?= number_format($total_resolved) ?></strong>
                        </div>

                        <div class="run-report-stat time-stat">
                            <span>Time worked</span>
                            <strong><?= htmlspecialchars($total_time, ENT_QUOTES, 'UTF-8') ?></strong>
                        </div>
                    </div>
                </div>

                <div class="run-report-table-wrapper">
                    <table class="table run-report-table" id="dashboardDataTable">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>New tickets</th>
                                <th>Open</th>
                                <th>Resolved</th>
                                <th>Time worked</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($report_rows as $row): ?>
                                <?php
                                $date = (string)($row['date'] ?? '');
                                $new_tickets = (int)($row['new_tickets'] ?? 0);
                                $open = (int)($row['open'] ?? 0);
                                $resolved = (int)($row['resolved'] ?? 0);
                                $time_worked = trim((string)($row['time_worked'] ?? ''));
                                ?>
                                <tr>
                                    <td data-order="<?= htmlspecialchars($date, ENT_QUOTES, 'UTF-8') ?>">
                                        <span class="run-report-date">
                                            <i class="mdi mdi-calendar-blank-outline"></i>
                                            <?= htmlspecialchars($format_report_date($date), ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </td>
                                    <td data-order="<?= $new_tickets ?>">
                                        <span class="report-number new-number"><?= number_format($new_tickets) ?></span>
                                    </td>
                                    <td data-order="<?= $open ?>">
                                        <span class="report-number open-number"><?= number_format($open) ?></span>
                                    </td>
                                    <td data-order="<?= $resolved ?>">
                                        <span class="report-number resolved-number"><?= number_format($resolved) ?></span>
                                    </td>
                                    <td data-order="<?= htmlspecialchars($time_worked, ENT_QUOTES, 'UTF-8') ?>">
                                        <span class="run-report-time">
                                            <?= htmlspecialchars($time_worked, ENT_QUOTES, 'UTF-8') ?>
                                        </span>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>

                        <tfoot>
                            <tr>
                                <th>Totals</th>
                                <th><?= number_format($total_new) ?></th>
                                <th><?= number_format($total_open) ?></th>
                                <th><?= number_format($total_resolved) ?></th>
                                <th><?= htmlspecialchars($total_time, ENT_QUOTES, 'UTF-8') ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="run-report-footer">
                    <span id="runReportResultCount">
                        <?= count($report_rows) ?> daily records
                    </span>
                    <span>
                        <i class="mdi mdi-file-chart-outline"></i>
                        Ticket reporting
                    </span>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
.run-reports-row {
    max-width: 100%;
    min-width: 0;
    margin: 0;
}

.run-reports-card {
    width: 100%;
    min-width: 0;
    overflow: hidden;
    border: 1px solid #dfe3ea;
    border-radius: 14px;
    background: #f7f8fb;
    box-shadow: 0 5px 22px rgba(15, 23, 42, .04);
}

.run-reports-card > .card-body {
    padding: 24px;
    min-width: 0;
}

.run-reports-heading,
.run-report-summary-heading {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
}

.run-reports-heading {
    margin-bottom: 25px;
}

.run-reports-heading .card-title {
    color: #2c3545;
    font-size: 19px;
    font-weight: 700;
}

.run-reports-heading p,
.run-report-summary-heading p {
    margin: 5px 0 0;
    color: #6b7280;
    font-size: 13px;
}

.run-reports-total {
    display: inline-flex;
    align-items: center;
    gap: 9px;
    padding: 10px 14px;
    border: 1px solid rgba(59, 111, 212, .20);
    border-radius: 9px;
    background: rgba(59, 111, 212, .07);
    color: #6b7280;
    font-size: 12px;
}

.run-reports-total i,
.run-reports-total strong {
    color: #3b6fd4;
}

.run-reports-total i {
    font-size: 20px;
}

.run-reports-filters {
    display: grid;
    grid-template-columns: 1.2fr 1fr 1fr 1.2fr auto;
    align-items: end;
    gap: 14px;
    padding: 18px;
    margin-bottom: 25px;
    border: 1px solid #dfe3ea;
    border-radius: 11px;
    background: rgba(234, 237, 243, .55);
}

.run-report-field {
    min-width: 0;
}

.run-report-field label {
    display: block;
    margin-bottom: 8px;
    color: #6b7280;
    font-size: 12px;
    font-weight: 700;
}

.run-report-input {
    width: 100%;
    min-width: 0;
    height: 42px;
    padding: 0 10px;
    border: 1px solid #dfe3ea;
    border-radius: 8px;
    outline: none;
    background: #f7f8fb;
    color: #2c3545;
    font-family: inherit;
    font-size: 12px;
    color-scheme: light;
}

.run-report-input:focus {
    border-color: #3b6fd4;
}

.run-report-display-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    min-height: 42px;
    padding: 0 15px;
    border: 1px solid #3b6fd4;
    border-radius: 8px;
    background: #3b6fd4;
    color: #fff;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
    cursor: pointer;
    transition: .2s ease;
}

.run-report-display-btn:hover {
    background: #2d5db9;
}

.run-report-summary {
    margin-bottom: 22px;
}

.run-report-summary-heading {
    margin-bottom: 15px;
}

.run-report-summary-heading h5 {
    margin: 0;
    color: #2c3545;
    font-size: 15px;
    font-weight: 700;
}

.run-report-period-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 11px;
    border: 1px solid rgba(59, 111, 212, .20);
    border-radius: 8px;
    background: rgba(59, 111, 212, .07);
    color: #3b6fd4;
    font-size: 11px;
}

.run-report-stats {
    display: grid;
    grid-template-columns: repeat(4, minmax(0, 1fr));
    gap: 13px;
}

.run-report-stat {
    display: flex;
    flex-direction: column;
    gap: 10px;
    min-width: 0;
    padding: 15px;
    border: 1px solid;
    border-radius: 10px;
}

.run-report-stat span {
    font-size: 12px;
    color: #6b7280;
}

.run-report-stat strong {
    font-size: 22px;
    font-weight: 700;
    overflow-wrap: anywhere;
}

.new-stat {
    border-color: rgba(59, 111, 212, .22);
    background: rgba(59, 111, 212, .07);
}
.new-stat strong { color: #3b6fd4; }

.open-stat {
    border-color: rgba(220, 160, 50, .25);
    background: rgba(220, 160, 50, .08);
}
.open-stat strong { color: #bd8424; }

.resolved-stat {
    border-color: rgba(40, 167, 110, .22);
    background: rgba(40, 167, 110, .07);
}
.resolved-stat strong { color: #23875c; }

.time-stat {
    border-color: rgba(100, 116, 139, .22);
    background: rgba(100, 116, 139, .07);
}
.time-stat strong {
    color: #64748b;
    font-size: 20px;
}

.run-report-table-wrapper {
    width: 100%;
    overflow-x: auto;
    border: 1px solid #dfe3ea;
    border-radius: 10px;
}

.run-report-table {
    width: 100%;
    min-width: 650px;
    margin: 0;
    border-collapse: separate;
    border-spacing: 0;
    background: #f7f8fb;
    font-size: 12px;
}

.run-report-table thead th {
    padding: 15px;
    border: 0;
    border-bottom: 1px solid #dfe3ea;
    background: #eaedf3;
    color: #6b7280;
    font-size: 10px;
    font-weight: 700;
    text-align: left;
    text-transform: uppercase;
    letter-spacing: .4px;
    white-space: nowrap;
}

.run-report-table tbody td,
.run-report-table tfoot th {
    padding: 14px 15px;
    border: 0;
    border-bottom: 1px solid #e5e8ef;
    background: #f7f8fb;
    color: #475569;
    vertical-align: middle;
}

.run-report-table tbody tr:hover td {
    background: #e8eef9;
}

.run-report-table tfoot th {
    border-top: 1px solid #dfe3ea;
    border-bottom: 0;
    background: #eaedf3;
    color: #2c3545;
    font-weight: 700;
    white-space: nowrap;
}

.run-report-date {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    white-space: nowrap;
    color: #475569;
}

.run-report-date i {
    color: #3b6fd4;
    font-size: 16px;
}

.report-number {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 30px;
    padding: 5px 9px;
    border-radius: 6px;
    font-weight: 700;
}

.new-number {
    background: rgba(59, 111, 212, .09);
    color: #3b6fd4;
}

.open-number {
    background: rgba(220, 160, 50, .10);
    color: #bd8424;
}

.resolved-number {
    background: rgba(40, 167, 110, .09);
    color: #23875c;
}

.run-report-time {
    color: #64748b;
    font-family: monospace;
    white-space: nowrap;
}

.run-report-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 17px;
    color: #6b7280;
    font-size: 12px;
}

.run-report-footer span:last-child {
    display: inline-flex;
    align-items: center;
    gap: 6px;
}

.run-report-footer i {
    color: #3b6fd4;
    font-size: 16px;
}

/* DataTables export buttons */

.run-reports-card .dt-buttons {
    display: flex;
    flex-wrap: wrap;
    gap: 7px;
    margin-bottom: 15px;
}

.run-reports-card .dt-buttons .dt-button {
    padding: 8px 12px;
    border: 1px solid rgba(59, 111, 212, .25);
    border-radius: 8px;
    background: rgba(59, 111, 212, .07);
    color: #3b6fd4;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.run-reports-card .dt-buttons .dt-button:hover {
    background: #3b6fd4;
    color: #fff;
}

.run-reports-card .dataTables_length,
.run-reports-card .dataTables_info {
    color: #6b7280;
    font-size: 12px;
}

.run-reports-card .dataTables_length select {
    margin: 0 5px;
    padding: 5px;
    border: 1px solid #dfe3ea;
    border-radius: 7px;
    background: #eef1f6;
    color: #2c3545;
}

.run-reports-card .dataTables_paginate {
    padding-top: 10px;
}

.run-reports-card .dataTables_paginate .paginate_button {
    margin: 2px;
    padding: 6px 10px !important;
    border: 1px solid transparent !important;
    border-radius: 7px !important;
    background: transparent !important;
    color: #6b7280 !important;
    font-size: 12px;
}

.run-reports-card .dataTables_paginate .paginate_button.current,
.run-reports-card .dataTables_paginate .paginate_button.current:hover {
    border-color: #3b6fd4 !important;
    background: #3b6fd4 !important;
    color: #fff !important;
}

.run-reports-card .dataTables_empty {
    padding: 30px !important;
    color: #6b7280 !important;
    text-align: center !important;
}

/* Dark theme */

:root[data-theme="dark"] .run-reports-card {
    border-color: #29364a;
    background: #111c2e;
}

:root[data-theme="dark"] .run-reports-heading .card-title,
:root[data-theme="dark"] .run-report-summary-heading h5,
:root[data-theme="dark"] .run-report-table tfoot th {
    color: #e5edf8;
}

:root[data-theme="dark"] .run-reports-heading p,
:root[data-theme="dark"] .run-report-summary-heading p,
:root[data-theme="dark"] .run-reports-total,
:root[data-theme="dark"] .run-report-stat span,
:root[data-theme="dark"] .run-report-footer {
    color: #a7b6cb;
}

:root[data-theme="dark"] .run-reports-total {
    border-color: rgba(139, 184, 255, .2);
    background: rgba(139, 184, 255, .06);
}

:root[data-theme="dark"] .run-reports-total i,
:root[data-theme="dark"] .run-reports-total strong {
    color: #8bb8ff;
}

:root[data-theme="dark"] .run-reports-filters {
    border-color: #29364a;
    background: rgba(23, 36, 56, .65);
}

:root[data-theme="dark"] .run-report-input {
    border-color: #29364a;
    background: #172438;
    color: #e5edf8;
    color-scheme: dark;
}

:root[data-theme="dark"] .run-report-field label {
    color: #a7b6cb;
}

:root[data-theme="dark"] .run-report-stat {
    background: rgba(139, 184, 255, .045);
}

:root[data-theme="dark"] .new-stat { border-color: rgba(139, 184, 255, .22); }
:root[data-theme="dark"] .open-stat { border-color: rgba(220, 190, 100, .22); }
:root[data-theme="dark"] .resolved-stat { border-color: rgba(40, 167, 110, .22); }
:root[data-theme="dark"] .time-stat { border-color: rgba(139, 184, 255, .16); }

:root[data-theme="dark"] .new-stat strong,
:root[data-theme="dark"] .run-report-date i,
:root[data-theme="dark"] .run-report-footer i {
    color: #8bb8ff;
}

:root[data-theme="dark"] .open-stat strong { color: #e4bf70; }
:root[data-theme="dark"] .resolved-stat strong { color: #64d6a0; }
:root[data-theme="dark"] .time-stat strong { color: #a7b6cb; }

:root[data-theme="dark"] .run-report-table-wrapper {
    border-color: #29364a;
}

:root[data-theme="dark"] .run-report-table,
:root[data-theme="dark"] .run-report-table tbody td {
    background: #111c2e;
}

:root[data-theme="dark"] .run-report-table thead th,
:root[data-theme="dark"] .run-report-table tfoot th {
    border-color: #29364a;
    background: #172438;
}

:root[data-theme="dark"] .run-report-table thead th {
    color: #a7b6cb;
}

:root[data-theme="dark"] .run-report-table tbody td {
    border-bottom-color: #29364a;
    color: #cbd5e1;
}

:root[data-theme="dark"] .run-report-table tbody tr:hover td {
    background: #1a2a42;
}

:root[data-theme="dark"] .run-report-date,
:root[data-theme="dark"] .run-report-time {
    color: #a7b6cb;
}

:root[data-theme="dark"] .new-number {
    background: rgba(139, 184, 255, .10);
    color: #8bb8ff;
}

:root[data-theme="dark"] .open-number {
    background: rgba(220, 190, 100, .10);
    color: #e4bf70;
}

:root[data-theme="dark"] .resolved-number {
    background: rgba(40, 167, 110, .10);
    color: #64d6a0;
}

:root[data-theme="dark"] .run-report-period-badge {
    border-color: rgba(139, 184, 255, .2);
    background: rgba(139, 184, 255, .06);
    color: #8bb8ff;
}

:root[data-theme="dark"] .run-reports-card .dt-buttons .dt-button {
    border-color: rgba(139, 184, 255, .25);
    background: rgba(139, 184, 255, .07);
    color: #8bb8ff;
}

:root[data-theme="dark"] .run-reports-card .dt-buttons .dt-button:hover {
    background: #3b6fd4;
    color: #fff;
}

:root[data-theme="dark"] .run-reports-card .dataTables_length,
:root[data-theme="dark"] .run-reports-card .dataTables_info {
    color: #a7b6cb;
}

:root[data-theme="dark"] .run-reports-card .dataTables_length select {
    border-color: #29364a;
    background: #172438;
    color: #e5edf8;
}

@media (max-width: 1100px) {
    .run-reports-filters {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .run-report-submit {
        grid-column: 1 / -1;
    }

    .run-report-display-btn {
        width: 100%;
    }
}

@media (max-width: 767px) {
    .run-reports-card > .card-body {
        padding: 14px;
    }

    .run-report-stats {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .run-reports-filters {
        padding: 13px;
        gap: 12px;
    }
}

@media (max-width: 480px) {
    .run-reports-card > .card-body {
        padding: 11px;
    }

    .run-reports-filters,
    .run-report-stats {
        grid-template-columns: 1fr;
    }

    .run-report-stat strong {
        font-size: 20px;
    }
}
</style>

<link rel="stylesheet"
      href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

<script>
(function () {
    'use strict';

    function initialiseRunReports() {
        if (!window.jQuery || !jQuery.fn || !jQuery.fn.DataTable) {
            console.error('Run Reports: jQuery DataTables is not loaded.');
            return;
        }

        if (!jQuery.fn.dataTable.Buttons) {
            console.error('Run Reports: DataTables Buttons extension is not loaded.');
            return;
        }

        const $ = window.jQuery;
        const tableElement = document.getElementById('dashboardDataTable');

        if (!tableElement || $.fn.DataTable.isDataTable(tableElement)) {
            return;
        }

        const $table = $(tableElement);
        const resultCount = document.getElementById('runReportResultCount');

        const dataTable = $table.DataTable({
            autoWidth: false,
            processing: false,
            deferRender: true,
            order: [[0, 'asc']],
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100, -1],
                [10, 25, 50, 100, 'All']
            ],
            dom: '<"report-dt-top"B l>rt<"report-dt-bottom"ip>',
            buttons: [
                {
                    extend: 'excelHtml5',
                    text: '<i class="mdi mdi-microsoft-excel"></i> Excel',
                    title: 'Tickets Per Day Report',
                    filename: 'tickets_per_day_report',
                    footer: true,
                    exportOptions: {
                        columns: ':visible',
                        modifier: { search: 'applied', order: 'applied', page: 'all' }
                    }
                },
                {
                    extend: 'pdfHtml5',
                    text: '<i class="mdi mdi-file-pdf-box"></i> PDF',
                    title: 'Tickets Per Day Report',
                    filename: 'tickets_per_day_report',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    footer: true,
                    exportOptions: {
                        columns: ':visible',
                        modifier: { search: 'applied', order: 'applied', page: 'all' }
                    },
                    customize: function (doc) {
                        doc.defaultStyle.fontSize = 9;
                        doc.styles.title = {
                            fontSize: 15,
                            bold: true,
                            margin: [0, 0, 0, 12]
                        };
                        doc.styles.tableHeader = {
                            bold: true,
                            fontSize: 9,
                            color: '#ffffff',
                            fillColor: '#3b6fd4'
                        };
                        doc.content.forEach(function (item) {
                            if (item.table) {
                                item.table.widths = ['40%', '15%', '15%', '15%', '15%'];
                                item.layout = 'lightHorizontalLines';
                            }
                        });
                    }
                },
                {
                    extend: 'csvHtml5',
                    text: '<i class="mdi mdi-file-delimited-outline"></i> CSV',
                    title: 'Tickets Per Day Report',
                    filename: 'tickets_per_day_report',
                    footer: true,
                    exportOptions: {
                        columns: ':visible',
                        modifier: { search: 'applied', order: 'applied', page: 'all' }
                    }
                },
                {
                    extend: 'print',
                    text: '<i class="mdi mdi-printer-outline"></i> Print',
                    title: 'Tickets Per Day Report',
                    footer: true,
                    exportOptions: {
                        columns: ':visible',
                        modifier: { search: 'applied', order: 'applied', page: 'all' }
                    }
                }
            ],
            columnDefs: [
                { targets: [1, 2, 3, 4], className: 'dt-body-left' }
            ],
            language: {
                emptyTable: 'No report records found for this date range',
                zeroRecords: 'No matching report records found',
                lengthMenu: 'Show _MENU_ records',
                info: 'Showing _START_ to _END_ of _TOTAL_ days',
                infoEmpty: 'Showing 0 to 0 of 0 days',
                infoFiltered: '(filtered from _MAX_ total days)',
                paginate: { previous: 'Previous', next: 'Next' }
            },
            drawCallback: function () {
                const info = this.api().page.info();
                resultCount.textContent =
                    'Showing ' + info.recordsDisplay + ' daily record(s)';
            }
        });

        const rangeSelect = document.getElementById('reportRange');
        const fromDate = document.getElementById('fromDate');
        const toDate = document.getElementById('toDate');

        function localDateString(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return year + '-' + month + '-' + day;
        }

        function applyDateRange(range) {
            const now = new Date();
            let start = new Date(now.getFullYear(), now.getMonth(), 1);
            let end = new Date(now.getFullYear(), now.getMonth() + 1, 0);

            if (range === 'last_month') {
                start = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                end = new Date(now.getFullYear(), now.getMonth(), 0);
            } else if (range === 'last_7_days') {
                end = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                start = new Date(end);
                start.setDate(start.getDate() - 6);
            } else if (range === 'last_30_days') {
                end = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                start = new Date(end);
                start.setDate(start.getDate() - 29);
            } else if (range === 'custom') {
                return;
            }

            fromDate.value = localDateString(start);
            toDate.value = localDateString(end);
        }

        rangeSelect.addEventListener('change', function () {
            applyDateRange(this.value);
        });

        document.getElementById('runReportsForm').addEventListener('submit', function (event) {
            if (fromDate.value && toDate.value && fromDate.value > toDate.value) {
                event.preventDefault();
                alert('The From date cannot be later than the To date.');
                return;
            }

            if (fromDate.value && toDate.value) {
                rangeSelect.value = 'custom';
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initialiseRunReports);
    } else {
        initialiseRunReports();
    }
})();
</script>