<?php include 'views/inc/admin/head.php'   ?>
<body>
<?php include 'views/inc/admin/sidebar_menu.php'   ?>


<?php include 'views/inc/admin/top_navbar.php'   ?>

<!-- ============================================================
     CREATE NEW TICKET CATEGORY MODAL
     ============================================================ -->
<div class="modal fade ticket-category-modal" id="ticketCategoryModal" tabindex="-1" aria-labelledby="ticketCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ticketCategoryModalLabel">Select ticket category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="ticket-category-grid">
                    <?php
                    $ticket_category_serial = 1;
                    foreach ($LoadTicketcategories as $LoadTicketcategory):
                    ?>
                        <a class="ticket-category-item" href="index.php?action=cr_ticket&sn=<?= urlencode($LoadTicketcategory['sn'] ?? '') ?>"
                            <span class="ticket-category-number"><?= $ticket_category_serial ?></span>
                            <span><?= htmlspecialchars($LoadTicketcategory['name'] ?? '') ?></span>
                        </a>
                    <?php
                        $ticket_category_serial++;
                    endforeach;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<main class="main-content">
    <div class="content-header"></div>
<?php if ($page_link_title=="tickets")  : ?>
   <?php include 'views/inc/admin/ticket_categoryheader.php'   ?>
<?php elseif ($page_link_title=="cr_ticket")  : ?>
   <?php include 'views/inc/admin/cr_ticket.php'   ?>
<?php elseif ($page_link_title=="user_requests")  : ?>
   <?php include 'views/inc/admin/request_preview.php'   ?>
<?php elseif ($page_link_title=="audit_trail")  : ?>
   <?php include 'views/inc/admin/audit_preview.php'   ?>
<?php elseif ($page_link_title=="run_reports")  : ?>
   <?php include 'views/inc/admin/runreport_preview.php'   ?>
<?php elseif ($page_link_title=="export_tickets")  : ?>
   <?php include 'views/inc/admin/exportreport_preview.php'   ?>
<?php elseif ($page_link_title=="transfers")  : ?>
   <?php include 'views/inc/admin/transfer_history.php'   ?>
<?php elseif ($page_link_title=="manage_users")  : ?>
   <?php include 'views/inc/admin/userspreview.php'   ?>
<?php endif;  ?>
  
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    /* ============================================================
       THEME HANDLING
       ============================================================ */
    const templateMode = <?= json_encode($template_mode) ?>;
    const themeToggle = document.getElementById('themeToggle');
    const themeIcon = document.getElementById('themeIcon');

    function setTheme(theme) {
        document.documentElement.setAttribute('data-theme', theme);
        const isDark = theme === 'dark';
        themeIcon.className = isDark ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill';
        themeToggle.setAttribute('aria-label', isDark ? 'Switch to light mode' : 'Switch to dark mode');
    }

    const initialTheme = document.documentElement.getAttribute('data-theme') || 'light';
    setTheme(initialTheme);

    themeToggle.addEventListener('click', function () {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        setTheme(newTheme);
    });

    /* ============================================================
       SIDEBAR MENU
       ============================================================ */
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');

    function toggleSidebar() {
        const isOpen = document.body.classList.toggle('sidebar-open');
        sidebar.classList.toggle('show', isOpen);
        sidebarToggle.className = isOpen
            ? 'bi bi-x-lg nav-icon'
            : 'bi bi-list nav-icon';
        sidebarToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
        sidebarToggle.setAttribute(
            'aria-label',
            isOpen ? 'Close sidebar' : 'Open sidebar'
        );
    }

    sidebarToggle.addEventListener('click', function () {
        toggleSidebar();
    });

    sidebarToggle.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            toggleSidebar();
        }
    });

    /* ============================================================
       SIDEBAR DROPDOWNS (Reports, Users, Modules)
       ============================================================ */
    function setupSidebarDropdown(toggleId, menuId) {
        const toggle = document.getElementById(toggleId);
        const menu = document.getElementById(menuId);

        if (!toggle || !menu) return;

        toggle.addEventListener('click', function (event) {
            event.stopPropagation();
            const isOpen = toggle.classList.contains('open');

            document.querySelectorAll('.sidebar-nav .dropdown-toggle').forEach(function (el) {
                if (el !== toggle) {
                    el.classList.remove('open');
                    el.setAttribute('aria-expanded', 'false');
                }
            });

            document.querySelectorAll('.sidebar-nav .dropdown-menu').forEach(function (el) {
                if (el !== menu) {
                    el.classList.remove('show');
                }
            });

            if (isOpen) {
                toggle.classList.remove('open');
                toggle.setAttribute('aria-expanded', 'false');
                menu.classList.remove('show');
            } else {
                toggle.classList.add('open');
                toggle.setAttribute('aria-expanded', 'true');
                menu.classList.add('show');
            }
        });

        toggle.addEventListener('keydown', function (event) {
            if (event.key === 'Enter' || event.key === ' ') {
                event.preventDefault();
                toggle.click();
            }
        });
    }

    setupSidebarDropdown('reportsToggle', 'reportsMenu');
    setupSidebarDropdown('usersToggle', 'usersMenu');
    setupSidebarDropdown('modulesToggle', 'modulesMenu');

    /* ============================================================
       CLOSE SIDEBAR WHEN CLICKING OUTSIDE
       ============================================================ */
    document.addEventListener('click', function (event) {
        if (
            sidebar.classList.contains('show') &&
            !sidebar.contains(event.target) &&
            !sidebarToggle.contains(event.target)
        ) {
            document.body.classList.remove('sidebar-open');
            sidebar.classList.remove('show');
            sidebarToggle.className = 'bi bi-list nav-icon';
            sidebarToggle.setAttribute('aria-expanded', 'false');
            sidebarToggle.setAttribute('aria-label', 'Open sidebar');
        }
    });

    /* ============================================================
       CLOSE SIDEBAR WHEN CLICKING A MENU ITEM
       ============================================================ */
    document.querySelectorAll('.sidebar-nav a').forEach(function (link) {
        link.addEventListener('click', function () {
            if (window.innerWidth <= 767.98) {
                document.body.classList.remove('sidebar-open');
                sidebar.classList.remove('show');
                sidebarToggle.className = 'bi bi-list nav-icon';
                sidebarToggle.setAttribute('aria-expanded', 'false');
                sidebarToggle.setAttribute('aria-label', 'Open sidebar');
            }
        });
    });

    /* ============================================================
       USER PROFILE DROPDOWN
       ============================================================ */
    const userProfileDropdown = document.getElementById('userProfileDropdown');
    const userProfileTrigger = document.getElementById('userProfileTrigger');

    function toggleProfileDropdown(forceState) {
        const isOpen = typeof forceState === 'boolean'
            ? forceState
            : !userProfileDropdown.classList.contains('open');

        userProfileDropdown.classList.toggle('open', isOpen);
        userProfileTrigger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    }

    userProfileTrigger.addEventListener('click', function (event) {
        event.stopPropagation();
        toggleProfileDropdown();
    });

    userProfileTrigger.addEventListener('keydown', function (event) {
        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            toggleProfileDropdown();
        } else if (event.key === 'Escape') {
            toggleProfileDropdown(false);
        }
    });

    document.addEventListener('click', function (event) {
        if (
            userProfileDropdown.classList.contains('open') &&
            !userProfileDropdown.contains(event.target)
        ) {
            toggleProfileDropdown(false);
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && userProfileDropdown.classList.contains('open')) {
            toggleProfileDropdown(false);
        }
    });

    document.querySelectorAll('#profileDropdownMenu a').forEach(function (item) {
        item.addEventListener('click', function () {
            toggleProfileDropdown(false);
        });
    });

    /* ============================================================
       CREATE NEW TICKET
       ============================================================ */
    const createTicketButton = document.querySelector('.create-ticket-btn');
    const ticketCategoryModalElement = document.getElementById('ticketCategoryModal');

    if (createTicketButton && ticketCategoryModalElement) {
        const ticketCategoryModal = new bootstrap.Modal(ticketCategoryModalElement);

        createTicketButton.addEventListener('click', function () {
            ticketCategoryModal.show();
        });
    }

    /* ============================================================
       DATATABLE
       ============================================================ */
    $(document).ready(function () {
        const ticketsTable = $('#ticketsTable').DataTable({
            searching: true,
            paging: true,
            info: true,
            ordering: true,
            pageLength: 10,
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            columnDefs: [
                {
                    orderable: false,
                    targets: 0
                }
            ],
            language: {
                search: "Search:",
                searchPlaceholder: "Search tickets...",
                lengthMenu: "Show _MENU_ tickets",
                info: "Showing _START_ to _END_ of _TOTAL_ tickets",
                infoEmpty: "Showing 0 to 0 of 0 tickets",
                zeroRecords: "No matching tickets found",
                emptyTable: "No tickets available",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                }
            },
            order: [
                [1, 'desc']
            ]
        });

        /* ========================================================
           UPDATE DELETE BUTTON STATE
           ======================================================== */
        function updateDeleteButtonState() {
            const visibleCheckboxes = ticketsTable.rows({
                search: 'applied'
            }).nodes().to$().find('.ticket-checkbox');

            const checkedCheckboxes = visibleCheckboxes.filter(':checked');
            const hasChecked = checkedCheckboxes.length > 0;

            $('#deleteSelectedBtn').prop('disabled', !hasChecked);
            $('#deleteSelectedBtn').toggleClass('disabled', !hasChecked);

            $('#selectAll').prop(
                'checked',
                visibleCheckboxes.length > 0 &&
                checkedCheckboxes.length === visibleCheckboxes.length
            );

            $('#selectAll').prop(
                'indeterminate',
                checkedCheckboxes.length > 0 &&
                checkedCheckboxes.length < visibleCheckboxes.length
            );
        }

        /* ========================================================
           SELECT ALL TICKETS
           ======================================================== */
        $('#selectAll').on('change', function () {
            const checked = this.checked;

            ticketsTable.rows({
                search: 'applied'
            }).nodes().to$().find('.ticket-checkbox').prop('checked', checked);

            updateDeleteButtonState();
        });

        /* ========================================================
           INDIVIDUAL TICKET CHECKBOXES
           ======================================================== */
        $('#ticketsTable tbody').on('change', '.ticket-checkbox', function () {
            updateDeleteButtonState();
        });

        /* ========================================================
           RESET SELECT ALL WHEN DATATABLE SEARCH/PAGING CHANGES
           ======================================================== */
        ticketsTable.on('draw', function () {
            updateDeleteButtonState();
        });

        /* ========================================================
           DELETE SELECTED TICKETS
           ======================================================== */
        $('#deleteSelectedBtn').on('click', function () {
            const checkedCheckboxes = ticketsTable.rows({
                search: 'applied'
            }).nodes().to$().find('.ticket-checkbox:checked');

            if (checkedCheckboxes.length === 0) {
                return;
            }

            const selectedIds = [];

            checkedCheckboxes.each(function () {
                const row = $(this).closest('tr');
                const id = row.find('td').eq(1).text().trim();
                selectedIds.push(id);
            });

            if (confirm(`Are you sure you want to delete ${selectedIds.length} selected ticket(s)?`)) {
                checkedCheckboxes.each(function () {
                    ticketsTable.row($(this).closest('tr')).remove();
                });

                ticketsTable.draw();
                $('#selectAll').prop('checked', false).prop('indeterminate', false);
                updateDeleteButtonState();
            }
        });

        /* ========================================================
           VIEW ALL BUTTON
           ======================================================== */
        $('#viewAllBtn').on('click', function () {
            ticketsTable.search('').draw();
            ticketsTable.page.len(-1).draw();
        });

        updateDeleteButtonState();
    });

    /* ============================================================
       AUTO RELOAD PAGE
       ============================================================ */
    const autoReload = document.getElementById('autoReload');
    let autoReloadTimer = null;

    function startAutoReload() {
        if (autoReloadTimer !== null) {
            clearInterval(autoReloadTimer);
            autoReloadTimer = null;
        }

        if (autoReload.checked) {
            autoReloadTimer = setInterval(function () {
                window.location.reload();
            }, 49000);
        }
    }

    autoReload.addEventListener('change', function () {
        startAutoReload();
    });

    window.addEventListener('beforeunload', function () {
        if (autoReloadTimer !== null) {
            clearInterval(autoReloadTimer);
            autoReloadTimer = null;
        }
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
<?php if (isset($showAlert) && $showAlert): ?>
    Swal.fire({
        title: 'Successful!',
        text:
            '<?= htmlspecialchars(
                $msgtext,
                ENT_QUOTES,
                'UTF-8'
            ); ?>',
        icon: 'info',
        confirmButtonText: 'OK',
        allowOutsideClick: true,
        allowEscapeKey: true
    }).then((result) => {
        if (
            result.isConfirmed ||
            result.dismiss
        ) {
            window.location.href =
                '<?= htmlspecialchars(
                    $url,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>';
        }
    });
<?php elseif (isset($showAlert) && !$showAlert): ?>
    Swal.fire({
        title: 'Error',
        text:
            '<?= htmlspecialchars(
                $msgtext,
                ENT_QUOTES,
                'UTF-8'
            ); ?>',
        icon: 'error',
        confirmButtonText: 'OK',
        allowOutsideClick: true,
        allowEscapeKey: true
    }).then((result) => {
        if (
            result.isConfirmed ||
            result.dismiss
        ) {
            window.location.href =
                '<?= htmlspecialchars(
                    $url,
                    ENT_QUOTES,
                    'UTF-8'
                ); ?>';
        }
    });
<?php endif; ?>
});
</script>
</body>
</html>