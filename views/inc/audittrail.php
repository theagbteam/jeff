
<div class="row">

    <div class="col-12 grid-margin stretch-card">

        <div class="card">

            <div class="card-body">

                <div
                    class="d-flex flex-row justify-content-between align-items-center dashboard-table-heading"
                >

                    <div>

                        <h4 class="card-title mb-1">
                            Recent Activity
                        </h4>

                        <p class="text-muted mb-0">
                            Overview of recent system users
                        </p>

                    </div>
<?php  if ($page_name=="dashboard") :  ?>
                    <a
                        href="index?action=users"
                        class="btn btn-primary"
                    >
                        View All
                    </a>
<?php endif;  ?>
                </div>

                <div class="dashboard-datatable-wrapper mt-4">

                    <table
                        class="dashboard-datatable"
                        id="dashboardDataTable"
                    >

                        <thead>

                            <tr>

                                <th>S/N</th>
                                <th>User</th>
                                <th>Activity</th>
                                <th>Category</th>
                                <th>Date & Time</th>
                                <th>Status</th>
                                <th>Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            <tr>

                                <td>1</td>

                                <td>

                                    <div class="dashboard-table-user">

                                        <img
                                            class="dashboard-table-avatar"
                                            src="views/uploads/img/profile//admin.png"
                                            alt="User"
                                        >

                                        <div>

                                            <div class="dashboard-table-user-name">
                                                Henry Klein
                                            </div>

                                            <div class="dashboard-table-user-email">
                                                admin@example.com
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    User account created
                                </td>

                                <td>

                                    <span class="dashboard-role">
                                        Users
                                    </span>

                                </td>

                                <td>
                                    24 Aug 2026, 09:15 AM
                                </td>

                                <td>

                                    <span class="dashboard-status dashboard-status-active">
                                        Completed
                                    </span>

                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Edit"
                                    >
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Delete"
                                    >
                                        <i class="mdi mdi-delete"></i>
                                    </button>

                                </td>

                            </tr>


                            <tr>

                                <td>2</td>

                                <td>

                                    <div class="dashboard-table-user">

                                        <img
                                            class="dashboard-table-avatar"
                                            src="views/uploads/img/profile//admin.png"
                                            alt="User"
                                        >

                                        <div>

                                            <div class="dashboard-table-user-name">
                                                Operations Manager
                                            </div>

                                            <div class="dashboard-table-user-email">
                                                manager@example.com
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    Pipeline information updated
                                </td>

                                <td>

                                    <span class="dashboard-role">
                                        Pipelines
                                    </span>

                                </td>

                                <td>
                                    24 Aug 2026, 08:52 AM
                                </td>

                                <td>

                                    <span class="dashboard-status dashboard-status-active">
                                        Completed
                                    </span>

                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Edit"
                                    >
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Delete"
                                    >
                                        <i class="mdi mdi-delete"></i>
                                    </button>

                                </td>

                            </tr>


                            <tr>

                                <td>3</td>

                                <td>

                                    <div class="dashboard-table-user">

                                        <img
                                            class="dashboard-table-avatar"
                                            src="views/uploads/img/profile//admin.png"
                                            alt="User"
                                        >

                                        <div class="dashboard-table-user-name">
                                            Field Supervisor
                                        </div>

                                    </div>

                                </td>

                                <td>
                                    New incident report submitted
                                </td>

                                <td>

                                    <span class="dashboard-role">
                                        Incidence
                                    </span>

                                </td>

                                <td>
                                    24 Aug 2026, 08:31 AM
                                </td>

                                <td>

                                    <span class="dashboard-status dashboard-status-pending">
                                        Pending
                                    </span>

                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Edit"
                                    >
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Delete"
                                    >
                                        <i class="mdi mdi-delete"></i>
                                    </button>

                                </td>

                            </tr>


                            <tr>

                                <td>4</td>

                                <td>

                                    <div class="dashboard-table-user">

                                        <img
                                            class="dashboard-table-avatar"
                                            src="views/uploads/img/profile//admin.png"
                                            alt="User"
                                        >

                                        <div>

                                            <div class="dashboard-table-user-name">
                                                John Operator
                                            </div>

                                            <div class="dashboard-table-user-email">
                                                operator@example.com
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    Wellhead status updated
                                </td>

                                <td>

                                    <span class="dashboard-role">
                                        Wellhead
                                    </span>

                                </td>

                                <td>
                                    24 Aug 2026, 08:14 AM
                                </td>

                                <td>

                                    <span class="dashboard-status dashboard-status-active">
                                        Completed
                                    </span>

                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Edit"
                                    >
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Delete"
                                    >
                                        <i class="mdi mdi-delete"></i>
                                    </button>

                                </td>

                            </tr>


                            <tr>

                                <td>5</td>

                                <td>

                                    <div class="dashboard-table-user">

                                        <img
                                            class="dashboard-table-avatar"
                                            src="views/uploads/img/profile//admin.png"
                                            alt="User"
                                        >

                                        <div>

                                            <div class="dashboard-table-user-name">
                                                Zone Administrator
                                            </div>

                                            <div class="dashboard-table-user-email">
                                                zone@example.com
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    Zone information modified
                                </td>

                                <td>

                                    <span class="dashboard-role">
                                        Zones
                                    </span>

                                </td>

                                <td>
                                    23 Aug 2026, 05:42 PM
                                </td>

                                <td>

                                    <span class="dashboard-status dashboard-status-active">
                                        Completed
                                    </span>

                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Edit"
                                    >
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Delete"
                                    >
                                        <i class="mdi mdi-delete"></i>
                                    </button>

                                </td>

                            </tr>


                            <tr>

                                <td>6</td>

                                <td>

                                    <div class="dashboard-table-user">

                                        <img
                                            class="dashboard-table-avatar"
                                            src="views/uploads/img/profile//admin.png"
                                            alt="User"
                                        >

                                        <div>

                                            <div class="dashboard-table-user-name">
                                                System Administrator
                                            </div>

                                            <div class="dashboard-table-user-email">
                                                system@example.com
                                            </div>

                                        </div>

                                    </div>

                                </td>

                                <td>
                                    Report type configuration updated
                                </td>

                                <td>

                                    <span class="dashboard-role">
                                        Reports
                                    </span>

                                </td>

                                <td>
                                    23 Aug 2026, 04:27 PM
                                </td>

                                <td>

                                    <span class="dashboard-status dashboard-status-active">
                                        Completed
                                    </span>

                                </td>

                                <td>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Edit"
                                    >
                                        <i class="mdi mdi-pencil"></i>
                                    </button>

                                    <button
                                        type="button"
                                        class="dashboard-table-action"
                                        title="Delete"
                                    >
                                        <i class="mdi mdi-delete"></i>
                                    </button>

                                </td>

                            </tr>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

