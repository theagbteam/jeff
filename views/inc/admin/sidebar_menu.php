<style>
    .dropdown_active{
background-color: slategray;

    }
</style>
<aside class="sidebar" id="sidebar">
    <div class="sidebar-brand">  <img width="30px" height="30px"  src="views/uploads/img/<?= $company_logo ?>" alt="">
               <?= $company_alias ?> </div>
    <ul class="sidebar-nav">
        <li><a href="index.php?action=tickets" class="<?php if ($page_link_title=='tickets' || $page_link_title=='cr_ticket') {echo 'active';} ?>"><span>Tickets</span></a></li>
          <li>
            <div   class="dropdown-toggle <?php if ($page_link_title=='run_reports' || $page_link_title=='export_tickets') {echo 'dropdown_active';} ?>"  id="reportsToggle" role="button" tabindex="0" aria-expanded="false">
                <span >Reports</span>
                <!-- <i class="bi bi-chevron-down nav-arrow"></i> -->
            </div>
            <div class="dropdown-menu" id="reportsMenu">
    <a href="index.php?action=run_reports" class="<?php if ($page_link_title=='run_reports') {echo 'active';} ?>">Run reports</a>
                <a href="index.php?action=export_tickets" class="<?php if ($page_link_title=='export_tickets') {echo 'active';} ?>">Export tickets</a>
            </div>
        </li>
        <!-- <li><a href="#"><span>Knowledgebase</span></a></li> -->
        <li>
            <div class="dropdown-toggle <?php if ($page_link_title=='transfers' || $page_link_title=='manage_users' || $page_link_title=='user_requests' || $page_link_title=='edit_user') {echo 'dropdown_active';} ?>" id="usersToggle" role="button" tabindex="0" aria-expanded="false">
                <span>Users</span>
                <!-- <i class="bi bi-chevron-down nav-arrow"></i> -->
            </div>
            <div class="dropdown-menu" id="usersMenu">
                <a href="index.php?action=manage_users" class="<?php if ($page_link_title=='manage_users' || $page_link_title=='edit_user') {echo 'active';} ?>">Manage users</a>
                <!-- <a href="index.php?action=user_requests" class="<?php if ($page_link_title=='user_requests') {echo 'active';} ?>">User requests</a> -->
                <a href="index.php?action=transfers" class="<?php if ($page_link_title=='transfers') {echo 'active';} ?>">Transfer users </a>
                <!-- <a href="index.php?action=promotions">Promotions </a> -->
                </div>
        </li>
        <li>
            <div class="dropdown-toggle <?php if ($page_link_title=='user_library' || $page_link_title=='audit_trail') {echo 'dropdown_active';} ?>" id="modulesToggle" role="button" tabindex="0" aria-expanded="false">
                <span>Modules</span>
                <!-- <i class="bi bi-chevron-down nav-arrow"></i> -->
            </div>
            <div class="dropdown-menu" id="modulesMenu">
                 <a href="index.php?action=user_library" class="<?php if ($page_link_title=='user_library') {echo 'active';} ?>">Upload library </a>
                    <a href="index.php?action=audit_trail" class="<?php if ($page_link_title=='audit_trail') {echo 'active';} ?>">Audit Trail</a>
                <!-- <a href="#">Requests</a> -->
                <!-- <a href="#">User Management</a> -->
            </div>
        </li>
    </ul>
</aside>