<nav class="top-navbar">
    <div class="navbar-left">
        <i class="bi bi-list nav-icon" id="sidebarToggle" role="button" tabindex="0" aria-label="Open sidebar" aria-expanded="false"></i>
    </div>
    <div class="navbar-right">
        <button class="theme-toggle" type="button" id="themeToggle" aria-label="Switch to dark mode" title="Switch theme">
            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
        </button>
        <button class="btn create-ticket-btn" type="button">Create New Ticket</button>

        <!-- ==================================================
             USER PROFILE DROPDOWN
             ================================================== -->
        <div class="user-profile-dropdown" id="userProfileDropdown">
            <div class="user-profile" id="userProfileTrigger" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
                <div class="user-avatar">
                 <img width="30px" height="30px" class="img-xs rounded-circle" src="views/uploads/img/profile/<?= $user_image ?>" alt="">
                    <!-- <i class="bi bi-person-badge-fill"></i> -->
                </div>
                <div class="user-info">
                    <span class="user-org"><?= $AbrvName ?></span>
                    <?php if ($company_adminseniorman==$userid) : ?>
                    <span class="user-role"><?= ucfirst($role_name). "👑" ?></span>
                    <?php else : ?>
                 <span class="user-role"><?= ucfirst($role_name) ?></span>
                      <?php endif ;?>
                </div>
                <i class="bi bi-chevron-down dropdown-caret"></i>
            </div>

            <div class="profile-dropdown-menu" id="profileDropdownMenu">
                <div class="profile-dropdown-header">
                    <div class="pd-name">Last Login</div>
                    <div class="pd-role"><?= $last_login ?></div>
                </div>
                <a href="#"><i class="bi bi-person-circle"></i> My Profile</a>
                <a href="#"><i class="bi bi-lock"></i> Update Password</a>
                <a href="#"><i class="bi bi-gear"></i> Account Settings</a>
                <!-- <a href="#"><i class="bi bi-bell"></i> Notifications</a> -->
                <div class="profile-dropdown-divider"></div>
                <a href="index?action=logout" class="logout-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </div>
</nav>