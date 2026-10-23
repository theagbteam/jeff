<?php $token = rawurlencode(base64_encode((string)$_SESSION['userid'])); ?>
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
            <!-- <button class="btn create-ticket-btn" type="button">Create request</button> -->

        <?php elseif ($page_link_title=="manage_users")  : ?>
            <div class="dropdown">
                <button
                    class="btn create-user-btn dropdown-toggle"
                    type="button"
                    id="createUserDropdownToggle"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                >
                    <i class="bi bi-person-plus-fill me-1"></i> User
                </button>

                <div
                    class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list create-user-dropdown"
                    aria-labelledby="createUserDropdownToggle"
                >
                    <div class="dropdown-header px-3 py-2">
                        <small class="text-uppercase fw-bold text-muted">Create user / chief head</small>
                    </div>
                    <div class="dropdown-divider"></div>

                    <!-- ADMINISTRATOR -->
                    <a
                        href="#"
                        class="dropdown-item preview-item register-user-btn"
                        data-role="administrator"
                    >
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-gradient-danger rounded-circle">
                                <i class="bi bi-person-badge-fill text-white"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 fw-semibold">
                                Create Administrator
                            </p>
                            <p class="text-muted small mb-0">Full system access</p>
                        </div>
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- REPORTER -->
                    <a
                        href="#"
                        class="dropdown-item preview-item create-user-role-btn"
                        data-role="reporter"
                        data-bs-toggle="modal"
                        data-bs-target="#createUserModal"
                    >
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-gradient-info rounded-circle">
                                <i class="bi bi-person-fill text-white"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 fw-semibold">
                               Create Reporter
                            </p>
                            <p class="text-muted small mb-0">Limited access</p>
                        </div>
                    </a>

                    <div class="dropdown-divider"></div>

                    <!-- ASSIGN CHIEF S.P (now opens its own modal) -->
                    <a
                        href="#"
                        class="dropdown-item preview-item"
                        id="assignChiefSPTrigger"
                        role="button"
                    >
                        <div class="preview-thumbnail">
                            <div class="preview-icon bg-gradient-warning rounded-circle">
                                <i class="bi bi-shield-fill-check text-white"></i>
                            </div>
                        </div>
                        <div class="preview-item-content">
                            <p class="preview-subject ellipsis mb-1 fw-semibold">
                               Assign chief S.P
                            </p>
                            <p class="text-muted small mb-0">Chief Supervisor</p>
                        </div>
                    </a>

                    <div class="dropdown-divider"></div>
                </div>
            </div>
        <?php endif; ?>

        <!-- ==================================================
             USER PROFILE DROPDOWN
             ================================================== -->
        <div class="user-profile-dropdown" id="userProfileDropdown">
            <div class="user-profile" id="userProfileTrigger" role="button" tabindex="0" aria-haspopup="true" aria-expanded="false">
                <div class="user-avatar">
                    <img width="30px" height="30px" class="img-xs rounded-circle" src="views/uploads/img/profile/<?= $user_image ?>" alt="">
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
                <a href="?action=myprofile&amp;token_edit=<?= $token ?>"><i class="bi bi-person-circle"></i> My Profile</a>
                <a href="index.php?action=user_requests"><i class="bi bi-file-earmark-text"></i> Requests</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#updatePasswordModal"><i class="bi bi-lock"></i> Update Password</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#accountSettingsModal"><i class="bi bi-gear"></i> Account Settings</a>
                <div class="profile-dropdown-divider"></div>
                <a href="index?action=logout" class="logout-link"><i class="bi bi-box-arrow-right"></i> Logout</a>
            </div>
        </div>
    </div>
</nav>


<!-- ========================================================= -->
<!-- CREATE ADMINISTRATOR ACCOUNT MODAL                        -->
<!-- ========================================================= -->
<div
    class="modal fade"
    id="createAdministratorModal"
    tabindex="-1"
    aria-labelledby="createAdministratorModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content create-user-modal-content">

            <form method="post" action="index.php?action=manage_users"
                  enctype="multipart/form-data"
                  onsubmit="return checkTurnstile(event) && disableSubmitButton(this);">

                <input type="hidden" name="action_token" value="<?= htmlspecialchars($_SESSION['action_token'] ?? '') ?>">
               <input type="hidden" name="role"  value="administrator">
                <div class="modal-header create-user-modal-header">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon-circle me-3">
                            <i class="bi bi-person-badge-fill"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="createAdministratorModalLabel">
                                Create Administrator Account
                            </h5>
                            <small class="text-muted">Full system access</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body create-user-modal-body">

                    <div class="mb-3">
                        <label for="adminTitle" class="form-label fw-semibold">
                            <i class="bi bi-person-vcard me-1 text-primary"></i> Title
                        </label>
                        <select class="form-select form-select-lg" id="adminTitle" name="title" required>
                            <option value="">Select title</option>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Miss">Miss</option>
                            <option value="Dr">Dr</option>
                            <option value="Prof">Prof</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <input type="hidden" name="user_corridor" value="General">
                    </div>

                    <div class="mb-3">
                        <label for="adminFullname" class="form-label fw-semibold">
                            <i class="bi bi-person me-1 text-primary"></i> Full Name
                        </label>
                        <input type="text" class="form-control form-control-lg" id="adminFullname" name="fullname"
                               placeholder="Enter full name" required>
                    </div>

                    <div class="mb-3">
                        <label for="adminPhone" class="form-label fw-semibold">
                            <i class="bi bi-telephone me-1 text-primary"></i> Phone Number
                        </label>
                        <input type="tel" class="form-control form-control-lg" id="adminPhone" name="phone"
                               placeholder="Enter phone number" inputmode="tel" autocomplete="tel" required>
                    </div>

                    <div class="mb-3">
                        <label for="adminEmail" class="form-label fw-semibold">
                            <i class="bi bi-envelope me-1 text-primary"></i> Email Address
                        </label>
                        <input type="email" class="form-control form-control-lg" id="adminEmail" name="email"
                               placeholder="Enter email address" required>
                    </div>

                </div>

                <div class="modal-footer create-user-modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <input type="hidden" name="create_user_account" value="1">
                    <button type="submit" name="create_admin_user" value="1" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-check-circle me-1"></i> Create Administrator
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- ==================================================
     CREATE USER MODAL (Reporter / General)
     ================================================== -->
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content create-user-modal-content">

            <form method="post" action="index.php?action=manage_users" onsubmit="disableSubmitButton(this); return validateCreateUserForm(this);">

                <input type="hidden" name="action_token" value="<?= htmlspecialchars($_SESSION['action_token'] ?? '') ?>">
                <input type="hidden" name="role"  value="reporter" id="createUserRole">

                <div class="modal-header create-user-modal-header">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon-circle me-3">
                            <i class="bi bi-person-plus-fill"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="createUserModalLabel">
                                Create Reporter Account
                            </h5>
                            <small class="text-muted">Limited access</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body create-user-modal-body">

                    <div class="mb-3">
                        <label for="createUserTitle" class="form-label fw-semibold">
                            <i class="bi bi-person-vcard me-1 text-primary"></i> Title
                        </label>
                        <select class="form-select form-select-lg" id="createUserTitle" name="title" required>
                            <option value="">Select title</option>
                            <option value="Mr">Mr</option>
                            <option value="Mrs">Mrs</option>
                            <option value="Miss">Miss</option>
                            <option value="Dr">Dr</option>
                            <option value="Prof">Prof</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="createUserCorridor" class="form-label fw-semibold">
                            <i class="bi bi-diagram-3 me-1 text-primary"></i> Corridor
                        </label>
                        <select class="form-select form-select-lg" id="createUserCorridor" name="user_corridor" required>
                            <option value="" selected disabled>Select corridor</option>
                            <?php foreach ($LoadCorridorColumnForSelect as $corridor): ?>
                                <option value="<?= htmlspecialchars($corridor['name'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($corridor['name'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="createUserFullname" class="form-label fw-semibold">
                            <i class="bi bi-person me-1 text-primary"></i> Full Name
                        </label>
                        <input type="text" class="form-control form-control-lg" id="createUserFullname" name="fullname"
                               placeholder="Enter full name" required>
                    </div>

                    <div class="mb-3">
                        <label for="createUserPhone" class="form-label fw-semibold">
                            <i class="bi bi-telephone me-1 text-primary"></i> Phone Number
                        </label>
                        <input type="tel" class="form-control form-control-lg" id="createUserPhone" name="phone"
                               placeholder="Enter phone number" inputmode="tel" autocomplete="tel" required>
                    </div>

                    <div class="mb-3">
                        <label for="createUserEmail" class="form-label fw-semibold">
                            <i class="bi bi-envelope me-1 text-primary"></i> Email Address
                        </label>
                        <input type="email" class="form-control form-control-lg" id="createUserEmail" name="email"
                               placeholder="Enter email address" required>
                    </div>

                </div>

                <div class="modal-footer create-user-modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <input type="hidden" name="create_user_account" value="1">
                    <button type="submit" name="create_admin_user" value="1" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-check-circle me-1"></i> Create Reporter
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- ==================================================
     ASSIGN CHIEF SUPERVISOR MODAL
     ================================================== -->
<div class="modal fade" id="assignChiefSPModal" tabindex="-1" aria-labelledby="assignChiefSPModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content create-user-modal-content">

            <form method="post" action="index.php?action=manage_users"
                  onsubmit="return checkTurnstile(event) && disableSubmitButton(this);">

                <input type="hidden" name="action_token" value="<?= htmlspecialchars($_SESSION['action_token'] ?? '') ?>">
                <input type="hidden" name="assign_chief_sp" value="1">

                <div class="modal-header create-user-modal-header">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon-circle me-3">
                            <i class="bi bi-shield-fill-check"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="assignChiefSPModalLabel">
                                Assign Chief Supervisor
                            </h5>
                            <small class="text-muted">Supervisory authority</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body create-user-modal-body">

                    <div class="mb-3">
                        <label for="chiefSupervisorSelect" class="form-label fw-semibold">
                            <i class="bi bi-person-check me-1 text-primary"></i> Select Supervisor
                        </label>
                        <select class="form-select form-select-lg" id="chiefSupervisorSelect" name="supervisor_userid" required>
                            <option value="" selected disabled>Select a supervisor</option>
                            <?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
?>
                            <?php if (!empty($LoadAllUsersAndLoginTableForAdmin['supervisor'])): ?>
                                <?php foreach ($LoadAllUsersAndLoginTableForAdmin['supervisor'] as $sup): ?>
                                      <?php  
                                        $supervisors_userid_list = htmlspecialchars($sup['user_userid'], ENT_QUOTES, 'UTF-8');
                                        $supervisors_corridor_list = htmlspecialchars($sup['user_corridor'], ENT_QUOTES, 'UTF-8');
                                        if ($supervisors_corridor_list!="" ) { $supervisors_corridor_list =" (".$supervisors_corridor_list . " corridor)";}
                                        $supervisors_fullname_list = htmlspecialchars($sup['user_fullname'], ENT_QUOTES, 'UTF-8');
                                        
                                        ?>


                                    <option value="<?= $supervisors_userid_list ?>">
                                        <?= ucfirst($supervisors_fullname_list). $supervisors_corridor_list. " - ". $supervisors_userid_list  ?>
                                      
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option value="" disabled>No supervisors available</option>
                            <?php endif; ?>
                        </select>
                    </div>

                    <div class="alert alert-info d-flex align-items-start mb-0" role="alert">
                        <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                        <div class="small">
                            The selected supervisor will replace the current Chief Supervisor and gain supervisory authority over the supervisor team. An email will be sent to notify them.
                        </div>
                    </div>

                </div>

                <div class="modal-footer create-user-modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" class="btn btn-warning btn-lg px-4">
                        <i class="bi bi-shield-check me-1"></i> Assign Chief S.P
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- ==================================================
     UPDATE PASSWORD MODAL
     ================================================== -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content update-password-modal-content">

            <form method="post" action="index.php?action=updateuserpwd" enctype="multipart/form-data"
                  onsubmit="return checkTurnstile(event) && disableSubmitButton(this);">

                 <input type="hidden" name="action_token" value="<?= htmlspecialchars($_SESSION['action_token'] ?? '') ?>">
               <input type="hidden" name="updateuserpwd"  value="1">
                <div class="modal-header update-password-modal-header">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon-circle me-3">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="updatePasswordModalLabel">
                                Update Password
                            </h5>
                            <small class="text-muted">Keep your account secure</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body update-password-modal-body">

                    <input type="hidden" name="userid" value="<?= $userid ?>">

                    <div class="mb-3">
                        <label for="oldPassword" class="form-label fw-semibold">
                            <i class="bi bi-key me-1 text-primary"></i> Old Password
                        </label>
                        <input type="password" class="form-control form-control-lg" id="oldPassword"
                               name="old_password" placeholder="Enter old password" required>
                    </div>

                    <div class="mb-3">
                        <label for="newPassword" class="form-label fw-semibold">
                            <i class="bi bi-lock me-1 text-primary"></i> New Password
                        </label>
                        <input type="password" class="form-control form-control-lg" id="newPassword"
                               name="new_password" placeholder="Enter new password" required>
                    </div>

                    <div class="mb-3">
                        <label for="verifyPassword" class="form-label fw-semibold">
                            <i class="bi bi-check2-circle me-1 text-primary"></i> Verify Password
                        </label>
                        <input type="password" class="form-control form-control-lg" id="verifyPassword"
                               name="verify_password" placeholder="Verify new password" required>
                    </div>

                </div>

                <div class="modal-footer update-password-modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" name="update_user_password" value="1" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-check-circle me-1"></i> Update Password
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<!-- ==================================================
     ACCOUNT SETTINGS MODAL
     ================================================== -->
<div class="modal fade" id="accountSettingsModal" tabindex="-1" aria-labelledby="accountSettingsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content update-password-modal-content">

            <form method="post" action="index.php?action=updateaccountsettings" enctype="multipart/form-data"
                  onsubmit="return checkTurnstile(event) && disableSubmitButton(this);">

                <input type="hidden" name="action_token" value="<?= htmlspecialchars($_SESSION['action_token'] ?? '') ?>">

                <div class="modal-header update-password-modal-header">
                    <div class="d-flex align-items-center">
                        <div class="modal-icon-circle me-3">
                            <i class="bi bi-gear-fill"></i>
                        </div>
                        <div>
                            <h5 class="modal-title mb-0" id="accountSettingsModalLabel">
                                Account Settings
                            </h5>
                            <small class="text-muted">Manage your preferences</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body update-password-modal-body">

                    <div class="mb-3">
                        <label for="template_mode" class="form-label fw-semibold">
                            My account template mode
                        </label>
                        <select class="form-select form-select-lg" id="template_mode" name="template_mode" required>
                            <option value="<?= $template_mode ?>"><?= ucfirst($template_mode) ?></option>
                            <option value="dark">Dark</option>
                            <option value="light">Light</option>
                            <option value="auto">Auto</option>
                        </select>
                    </div>

                    <?php if ( $company_adminseniorman==$_SESSION['userid']) : ?>
                    <div class="mb-3">
                        <label for="company_allownotification" class="form-label fw-semibold">
                            Allow notification
                        </label>
                        <select class="form-select form-select-lg" id="company_allownotification" name="company_allownotification" required>
                            <option value="<?= $company_allownotification ?>"><?= ucfirst($company_allownotification_text) ?></option>
                            <option value="1">Allow</option>
                            <option value="0">Disallow</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="allow_signup" class="form-label fw-semibold">
                            Allow users to create new account
                        </label>
                        <select class="form-select form-select-lg" id="allow_signup" name="allow_signup" required>
                            <option value="<?= $company_Allow_signup ?>"><?= ucfirst($company_Allow_signup_text) ?></option>
                            <option value="1">Allow</option>
                            <option value="0">Disallow</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="auto_approval" class="form-label fw-semibold">
                            Auto account approval
                        </label>
                        <select class="form-select form-select-lg" id="auto_approval" name="auto_approval" required>
                            <option value="<?= $company_acct_approval ?>"><?= ucfirst($company_acct_approval_text) ?></option>
                            <option value="1">Allow</option>
                            <option value="0">Disallow</option>
                        </select>
                    </div>
                  <?php else: ?>
                <input type="hidden" name="allow_signup" value="<?= $company_Allow_signup ?>">
                <input type="hidden" name="auto_approval" value="<?= $company_acct_approval ?>">
                <input type="hidden" name="company_allownotification" value="<?= $company_allownotification ?>">
                  <?php endif ?>
                </div>

<input type="hidden" name="update_settings" >

                <div class="modal-footer update-password-modal-footer">
                    <button type="button" class="btn btn-outline-secondary btn-lg" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <button type="submit" name="update_settings" value="1" class="btn btn-success btn-lg px-4">
                        <i class="bi bi-check-circle me-1"></i> Save Settings
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>


<style>
/* ===== Create User Modal Styles ===== */
#createUserModal .modal-dialog,
#createAdministratorModal .modal-dialog,
#assignChiefSPModal .modal-dialog {
    display: flex;
    align-items: center;
    min-height: calc(100vh - 1rem);
    margin: 0 auto;
}

@media (min-width: 576px) {
    #createUserModal .modal-dialog,
    #createAdministratorModal .modal-dialog,
    #assignChiefSPModal .modal-dialog {
        min-height: calc(100vh - 3.5rem);
    }
}

.create-user-modal-content {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.create-user-modal-header {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: #fff;
    border-bottom: none;
    padding: 1.25rem 1.5rem;
}

.create-user-modal-header .modal-title { color: #fff; font-weight: 600; }
.create-user-modal-header .text-muted { color: rgba(255, 255, 255, 0.7) !important; }

.modal-icon-circle {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.4rem;
    color: #fff;
}

.create-user-modal-body {
    padding: 1.5rem;
    background: #f8f9fc;
}

.create-user-modal-body .form-label {
    color: #2c3e50;
    font-size: 0.9rem;
    margin-bottom: 0.4rem;
}

.create-user-modal-body .form-control,
.create-user-modal-body .form-select {
    border: 1.5px solid #e0e6ed;
    border-radius: 10px;
    padding: 0.6rem 1rem;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    background: #fff;
}

.create-user-modal-body .form-control:focus,
.create-user-modal-body .form-select:focus {
    border-color: #2a5298;
    box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.15);
}

.create-user-modal-footer {
    background: #fff;
    border-top: 1px solid #eef1f6;
    padding: 1rem 1.5rem;
    gap: 0.5rem;
}

.create-user-modal-footer .btn {
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.create-user-modal-footer .btn-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    border: none;
    box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
}

.create-user-modal-footer .btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(17, 153, 142, 0.4);
}

/* ===== Create User Button & Dropdown ===== */
.create-user-btn {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 500;
    padding: 0.5rem 1.1rem;
    transition: all 0.2s ease;
    box-shadow: 0 4px 12px rgba(30, 60, 114, 0.25);
}

.create-user-btn:hover,
.create-user-btn:focus {
    background: linear-gradient(135deg, #16305c 0%, #1e3c72 100%);
    color: #fff;
    transform: translateY(-1px);
    box-shadow: 0 6px 18px rgba(30, 60, 114, 0.35);
}

.create-user-btn::after { margin-left: 0.5rem; vertical-align: 0.15em; }

.create-user-dropdown {
    border: none;
    border-radius: 14px;
    box-shadow: 0 12px 40px rgba(0, 0, 0, 0.18);
    padding: 0.5rem;
    min-width: 260px;
    animation: dropdownFadeIn 0.2s ease;
}

@keyframes dropdownFadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to   { opacity: 1; transform: translateY(0); }
}

.create-user-dropdown .dropdown-header {
    color: #8898aa;
    font-size: 0.72rem;
    letter-spacing: 0.8px;
}

.create-user-dropdown .dropdown-item {
    border-radius: 10px;
    padding: 0.65rem 0.75rem;
    transition: all 0.15s ease;
    display: flex;
    align-items: center;
}

.create-user-dropdown .dropdown-item:hover {
    background: #f0f4ff;
    transform: translateX(3px);
}

.create-user-dropdown .preview-thumbnail {
    margin-right: 0.75rem;
    flex-shrink: 0;
}

.create-user-dropdown .preview-icon {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.1rem;
}

.bg-gradient-danger  { background: linear-gradient(135deg, #f5365c 0%, #f56036 100%); }
.bg-gradient-info    { background: linear-gradient(135deg, #11cdef 0%, #1171ef 100%); }
.bg-gradient-warning { background: linear-gradient(135deg, #f5a623 0%, #f5c823 100%); }

.create-user-dropdown .preview-subject { font-size: 0.9rem; color: #2c3e50; }
.create-user-dropdown .dropdown-divider { margin: 0.3rem 0.5rem; border-color: #eef1f6; }

/* ===== Update Password Modal Styles ===== */
.update-password-modal-content {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
}

.update-password-modal-header {
    background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
    color: #fff;
    border-bottom: none;
    padding: 1.25rem 1.5rem;
}

.update-password-modal-header .modal-title { color: #fff; font-weight: 600; }
.update-password-modal-header .text-muted { color: rgba(255, 255, 255, 0.7) !important; }

.update-password-modal-body { padding: 1.5rem; background: #f8f9fc; }

.update-password-modal-body .form-label {
    color: #2c3e50;
    font-size: 0.9rem;
    margin-bottom: 0.4rem;
}

.update-password-modal-body .form-control {
    border: 1.5px solid #e0e6ed;
    border-radius: 10px;
    padding: 0.6rem 1rem;
    font-size: 0.95rem;
    transition: all 0.2s ease;
    background: #fff;
}

.update-password-modal-body .form-control:focus {
    border-color: #2a5298;
    box-shadow: 0 0 0 3px rgba(42, 82, 152, 0.15);
}

.update-password-modal-footer {
    background: #fff;
    border-top: 1px solid #eef1f6;
    padding: 1rem 1.5rem;
    gap: 0.5rem;
}

.update-password-modal-footer .btn {
    border-radius: 10px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.update-password-modal-footer .btn-success {
    background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
    border: none;
    box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
}

.update-password-modal-footer .btn-success:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(17, 153, 142, 0.4);
}
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    /* =========================================================
       ADMINISTRATOR BUTTON  ->  createAdministratorModal
       ========================================================= */
    const administratorButton = document.querySelector('.register-user-btn');
    const administratorModalElement = document.getElementById('createAdministratorModal');

    if (administratorButton && administratorModalElement && typeof bootstrap !== 'undefined') {
        administratorButton.addEventListener('click', function (event) {
            event.preventDefault();

            const createAdministratorModal = new bootstrap.Modal(administratorModalElement);
            createAdministratorModal.show();
        });
    }

    /* =========================================================
       ASSIGN CHIEF S.P TRIGGER  ->  assignChiefSPModal
       ========================================================= */
    var assignChiefTrigger = document.getElementById('assignChiefSPTrigger');
    var assignChiefModalEl = document.getElementById('assignChiefSPModal');

    if (assignChiefTrigger && assignChiefModalEl && typeof bootstrap !== 'undefined') {
        assignChiefTrigger.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation(); // keep the dropdown from swallowing the click

            var modal = bootstrap.Modal.getOrCreateInstance(assignChiefModalEl);
            modal.show();
        });
    }

    /* =========================================================
       REPORTER BUTTON  ->  createUserModal
       ========================================================= */
    var reporterButtons = document.querySelectorAll('.create-user-role-btn');
    var createUserRoleInput = document.getElementById('createUserRole');
    var createUserModalLabel = document.getElementById('createUserModalLabel');

    reporterButtons.forEach(function (button) {
        button.addEventListener('click', function () {
            var selectedRole = this.getAttribute('data-role') || 'reporter';

            if (createUserRoleInput) {
                createUserRoleInput.value = selectedRole;
            }

            if (createUserModalLabel) {
                createUserModalLabel.textContent =
                    selectedRole === 'administrator'
                        ? 'Create Administrator Account'
                        : 'Create Reporter Account';
            }
        });
    });

    /* =========================================================
       UPDATE PASSWORD TRIGGER
       ========================================================= */
    var trigger = document.getElementById('openUpdatePasswordModal');
    if (trigger) {
        trigger.addEventListener('click', function (e) {
            e.preventDefault();
            var modalEl = document.getElementById('updatePasswordModal');
            if (!modalEl || typeof bootstrap === 'undefined') return;
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        });
    }

    /* =========================================================
       PHONE INPUT SANITISER (both modals)
       ========================================================= */
    var createUserPhone = document.getElementById('createUserPhone');
    var adminPhone = document.getElementById('adminPhone');

    function sanitisePhoneInput() {
        var value = this.value;
        if (value.startsWith('+')) {
            value = '+' + value.substring(1).replace(/\D/g, '');
        } else {
            value = value.replace(/\D/g, '');
        }
        this.value = value;
    }

    function blockInvalidPhoneKeys(event) {
        const allowedKeys = [
            'Backspace', 'Delete', 'ArrowLeft', 'ArrowRight',
            'ArrowUp', 'ArrowDown', 'Home', 'End', 'Tab'
        ];
        if (allowedKeys.includes(event.key)) return;
        if (event.ctrlKey || event.metaKey) return;
        if (event.key === '+') {
            if (this.selectionStart !== 0 || this.value.includes('+')) {
                event.preventDefault();
            }
            return;
        }
        if (!/^[0-9]$/.test(event.key)) {
            event.preventDefault();
        }
    }

    if (createUserPhone) {
        createUserPhone.addEventListener('input', sanitisePhoneInput);
        createUserPhone.addEventListener('keydown', blockInvalidPhoneKeys);
    }
    if (adminPhone) {
        adminPhone.addEventListener('input', sanitisePhoneInput);
        adminPhone.addEventListener('keydown', blockInvalidPhoneKeys);
    }
});


/* =========================================================
   CREATE USER FORM VALIDATION
   ========================================================= */
function validateCreateUserForm(form) {
    if (typeof checkTurnstile === 'function') {
        if (!checkTurnstile(event)) return false;
    }
    if (typeof disableSubmitButton === 'function') {
        disableSubmitButton(form);
    } else {
        var button = form.querySelector('button[type="submit"][name="create_user"]');
        if (button) {
            button.disabled = true;
            button.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Creating...';
        }
    }
    return true;
}
</script>

<!-- =========================================================
     SHARED HELPERS
     ========================================================= -->
<script>
function checkTurnstile(event) {
    if (typeof turnstile === 'undefined') return true;
    var responseInput = document.querySelector('input[name="cf-turnstile-response"]');
    if (responseInput && responseInput.value) return true;
    if (event) event.preventDefault();
    alert('Please complete the verification challenge.');
    return false;
}

function disableSubmitButton(form) {
    const button = form.querySelector('button[type="submit"]');
    if (button) {
        button.disabled = true;
        button.innerHTML = 'Processing...';
    }
    return true;
}
</script>