<div class="table-container">
    <table class="ticket-table" id="auditTrailTable">
        <thead>
            <tr>
                <th class="checkbox-cell">
                    <input type="checkbox" id="selectAllAudit" aria-label="Select all audit records">
                </th>
                <th class="id-cell">SN <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="date-cell">Date <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="userid-cell">User ID <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="name-cell">Full Name <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="role-cell">Role <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="role-name-cell">Role Name <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="action-cell">Action <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="ip-cell">IP Address <i class="bi bi-arrow-down-up sort-icon"></i></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="checkbox-cell"><input type="checkbox" class="audit-checkbox" aria-label="Select audit record 1"></td>
                <td class="id-cell center-cell">1</td>
                <td>2026-08-13<br>12:48:53</td>
                <td>42</td>
                <td>John Okafor</td>
                <td>admin</td>
                <td>Administrator</td>
                <td class="action-cell"><span class="action-badge action-create">CREATE</span></td>
                <td>192.168.1.10</td>
            </tr>
            <tr>
                <td class="checkbox-cell"><input type="checkbox" class="audit-checkbox" aria-label="Select audit record 2"></td>
                <td class="id-cell center-cell">2</td>
                <td>2026-08-13<br>12:41:01</td>
                <td>42</td>
                <td>John Okafor</td>
                <td>admin</td>
                <td>Administrator</td>
                <td class="action-cell"><span class="action-badge action-update">UPDATE</span></td>
                <td>192.168.1.10</td>
            </tr>
            <tr>
                <td class="checkbox-cell"><input type="checkbox" class="audit-checkbox" aria-label="Select audit record 3"></td>
                <td class="id-cell center-cell">3</td>
                <td>2026-08-13<br>12:17:59</td>
                <td>7</td>
                <td>Amina Bello</td>
                <td>manager</td>
                <td>Zone Manager</td>
                <td class="action-cell"><span class="action-badge action-delete">DELETE</span></td>
                <td>10.0.0.55</td>
            </tr>
            <tr>
                <td class="checkbox-cell"><input type="checkbox" class="audit-checkbox" aria-label="Select audit record 4"></td>
                <td class="id-cell center-cell">4</td>
                <td>2026-08-13<br>05:56:00</td>
                <td>15</td>
                <td>Chidi Nwosu</td>
                <td>viewer</td>
                <td>Read Only</td>
                <td class="action-cell"><span class="action-badge action-login">LOGIN</span></td>
                <td>172.16.0.21</td>
            </tr>
            <tr>
                <td class="checkbox-cell"><input type="checkbox" class="audit-checkbox" aria-label="Select audit record 5"></td>
                <td class="id-cell center-cell">5</td>
                <td>2026-08-12<br>19:32:00</td>
                <td>7</td>
                <td>Amina Bello</td>
                <td>manager</td>
                <td>Zone Manager</td>
                <td class="action-cell"><span class="action-badge action-logout">LOGOUT</span></td>
                <td>10.0.0.55</td>
            </tr>
            <tr>
                <td class="checkbox-cell"><input type="checkbox" class="audit-checkbox" aria-label="Select audit record 6"></td>
                <td class="id-cell center-cell">6</td>
                <td>2026-08-12<br>08:25:24</td>
                <td>3</td>
                <td>Ngozi Eze</td>
                <td>superadmin</td>
                <td>Super Administrator</td>
                <td class="action-cell"><span class="action-badge action-update">UPDATE</span></td>
                <td>192.168.1.5</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- =========================================================
     AUDIT TRAIL CSS (matches ticket-table styling)
========================================================= -->
<style>
    .table-container {
        width: 100%;
        overflow-x: auto;
        background: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.06);
        padding: 4px;
    }

    .ticket-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        color: #334155;
        background: #ffffff;
        white-space: nowrap;
    }

    .ticket-table thead th {
        background: #f1f5f9;
        color: #1e293b;
        font-weight: 700;
        text-align: left;
        padding: 12px 10px;
        border-bottom: 2px solid #e2e8f0;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
        user-select: none;
    }

    .ticket-table thead th .sort-icon {
        font-size: 10px;
        margin-left: 4px;
        opacity: 0.55;
        cursor: pointer;
    }

    .ticket-table thead th .sort-icon:hover {
        opacity: 1;
    }

    .ticket-table tbody td {
        padding: 10px;
        border-bottom: 1px solid #eef2f7;
        vertical-align: middle;
        color: #475569;
    }

    .ticket-table tbody tr:hover {
        background: #f8fafc;
    }

    .ticket-table tbody tr:last-child td {
        border-bottom: none;
    }

    .ticket-table a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    .ticket-table a:hover {
        text-decoration: underline;
    }

    .checkbox-cell {
        width: 36px;
        text-align: center;
    }

    .checkbox-cell input[type="checkbox"] {
        width: 15px;
        height: 15px;
        cursor: pointer;
        accent-color: #2563eb;
    }

    .id-cell {
        width: 70px;
        text-align: center;
    }

    .center-cell {
        text-align: center;
    }

    /* Action badges */
    .action-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.4px;
    }

    .action-create {
        background: #dcfce7;
        color: #15803d;
    }

    .action-update {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .action-delete {
        background: #fee2e2;
        color: #b91c1c;
    }

    .action-login {
        background: #fef9c3;
        color: #a16207;
    }

    .action-logout {
        background: #f3e8ff;
        color: #7e22ce;
    }

    /* DataTables wrapper adjustments (if used) */
    .dataTables_wrapper {
        padding: 10px 0;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter {
        margin-bottom: 10px;
        font-size: 13px;
    }

    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 4px 8px;
        outline: none;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #2563eb;
    }

    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        margin-top: 10px;
        font-size: 13px;
        color: #64748b;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 4px 10px;
        margin: 0 2px;
        border-radius: 6px;
        border: 1px solid #e2e8f0;
        cursor: pointer;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #2563eb;
        color: #ffffff !important;
        border-color: #2563eb;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background: #f1f5f9;
        color: #1e293b !important;
        border-color: #cbd5e1;
    }
</style>

<!-- =========================================================
     DATATABLE INITIALIZATION
========================================================= -->
<script>
    $(document).ready(function () {
        $('#auditTrailTable').DataTable({
            "pageLength": 10,
            "lengthMenu": [10, 25, 50, 100],
            "order": [[2, "desc"]], // sort by Date column descending
            "columnDefs": [
                { "orderable": false, "targets": [0] } // checkbox column not sortable
            ],
            "language": {
                "search": "Search:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
                "zeroRecords": "No audit records found"
            }
        });
    });
</script>