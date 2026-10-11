
<nav class="top-navbar">
    <div class="navbar-left">
        <i class="bi bi-list nav-icon" id="sidebarToggle" role="button" tabindex="0" aria-label="Open sidebar" aria-expanded="false"></i>
   <b><?= ucfirst($page_name) ?> </b>
</div>

    <div class="navbar-right">
        <button class="theme-toggle" type="button" id="themeToggle" aria-label="Switch to dark mode" title="Switch theme">
            <i class="bi bi-moon-stars-fill" id="themeIcon"></i>
        </button>
        <?php if ($page_link_title=="tickets" || $page_link_title=="cr_ticket")  : ?>
        <button class="btn create-ticket-btn" type="button">Create New Ticket</button>
        <?php elseif ($page_link_title=="user_requests")  : ?>
        <button class="btn create-ticket-btn" type="button"> Create request</button>
        <?php elseif ($page_link_title=="manage_users")  : ?>
        <button class="btn create-ticket-btn" type="button"> Create user</button>
        <?php endif; ?>

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
                    <?php if ($company_adminseniorman == $userid) : ?>
                        <span class="user-role"><?= ucfirst($role_name) . "👑" ?></span>
                    <?php else : ?>
                        <span class="user-role"><?= ucfirst($role_name) ?></span>
                    <?php endif; ?>
                </div>
                <i class="bi bi-chevron-down dropdown-caret"></i>
            </div>

            <div class="profile-dropdown-menu" id="profileDropdownMenu">
                <div class="profile-dropdown-header">
                    <div class="pd-name">Last Login</div>
                    <div class="pd-role"><?= $last_login ?></div>
                </div>
                <a href="#"><i class="bi bi-person-circle"></i> My Profile</a>
                <a href="#" id="openUpdatePasswordModal"><i class="bi bi-lock"></i> Update Password</a>
                <a href="#"><i class="bi bi-gear"></i> Account Settings</a>
                <!-- <a href="#"><i class="bi bi-bell"></i> Notifications</a> -->
                <div class="profile-dropdown-divider"></div>
                <a href="index?action=logout" class="logout-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </div>
    
</nav>

<!-- ==================================================
     UPDATE PASSWORD MODAL
     ================================================== -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <form method="post" action="index?action=updateuserpwd" onsubmit="if (!checkTurnstile(event)) return false; disableSubmitButton(this); return true;">

                <input type="hidden" name="action_token" value="<?= htmlspecialchars($_SESSION['action_token'] ?? '') ?>">

                <div class="modal-header">
                    <h5 class="modal-title" id="updatePasswordModalLabel">
                        Update Password
                    </h5>
                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="userid" value="<?= $userid ?>">

                    <div class="mb-3">
                        <label for="oldPassword" class="form-label">Old Password</label>
                        <input type="password"
                               class="form-control"
                               id="oldPassword"
                               name="old_password"
                               placeholder="Enter old password"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password"
                               class="form-control"
                               id="newPassword"
                               name="new_password"
                               placeholder="Enter new password"
                               required>
                    </div>

                    <div class="mb-3">
                        <label for="verifyPassword" class="form-label">Verify Password</label>
                        <input type="password"
                               class="form-control"
                               id="verifyPassword"
                               name="verify_password"
                               placeholder="Verify new password"
                               required>
                    </div>

                </div>

                <!-- Turnstile widget (uncomment when ready to enforce) -->
                <!-- <div class="cf-turnstile" data-sitekey="<?= $CF_SiteKey ?>" data-callback="turnstileSuccess" data-size="flexible"></div> -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit"
                            name="update_user_password" 
                            value="1"
                            class="btn btn-success">
                        Update Password
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- ==================================================
     OPEN MODAL WHEN "UPDATE PASSWORD" IS CLICKED
     ================================================== -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    var trigger = document.getElementById('openUpdatePasswordModal');
    if (!trigger) return;

    trigger.addEventListener('click', function (e) {
        e.preventDefault();

        // If a Bootstrap modal instance already exists, reuse it
        var modalEl = document.getElementById('updatePasswordModal');
        var modal = bootstrap.Modal.getOrCreateInstance(modalEl);
        modal.show();
    });
});

/* Stub for checkTurnstile — safe if Turnstile is not loaded yet */
function checkTurnstile(event) {
    // If Turnstile is not present on the page, allow submission
    if (typeof turnstile === 'undefined') return true;

    // If widget exists, verify a token was obtained (adjust selector to your setup)
    var responseInput = document.querySelector('input[name="cf-turnstile-response"]');
    if (responseInput && responseInput.value) return true;

    event.preventDefault();
    alert('Please complete the verification challenge.');
    return false;
}

/* Disable submit button to prevent double submits */
function disableSubmitButton(form) {
    var btn = form.querySelector('button[type="submit"][name="update_user_password"]');
    if (btn) {
        btn.disabled = true;
        btn.innerHTML = 'Updating...';
    }
}
</script>