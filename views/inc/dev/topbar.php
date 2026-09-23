
<nav class="navbar p-0 fixed-top d-flex flex-row">

    <div
        class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center"
    >

        <a
            class="navbar-brand brand-logo-mini"
            href="index?action=index"
            style="color:aliceblue !important;"
        >

            <img
                style="
                    width:80px !important;
                    height:50px !important;
                    object-fit:contain !important;
                "
                src="views/uploads/img/<?= htmlspecialchars($company_logo) ?>"
                alt="logo"
            >

            <?= htmlspecialchars($company_alias) ?>

        </a>

    </div>

    <div
        class="navbar-menu-wrapper flex-grow d-flex align-items-stretch"
    >

        <button
            class="navbar-toggler navbar-toggler align-self-center"
            type="button"
            data-toggle="minimize"
        >

            <span class="mdi mdi-menu"></span>

        </button>

        <ul class="navbar-nav w-100">

            <li class="nav-item w-100"></li>

        </ul>

        <ul class="navbar-nav navbar-nav-right">

            <li class="nav-item dropdown">

                <a
                    class="nav-link btn btn-success create-new-button"
                    id="createbuttonDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    href="#"
                >

                    + Create User

                </a>

                <div
                    class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list"
                    aria-labelledby="createbuttonDropdown"
                >

                    <div class="dropdown-divider"></div>

                    <div class="dropdown-divider"></div>

                    <a
                        href="#"
                        class="dropdown-item preview-item register-user-btn"
                        data-role="2"
                    >

                        <div class="preview-thumbnail">

                            <div class="preview-icon bg-dark rounded-circle">

                                <i class="mdi mdi-layers text-danger"></i>

                            </div>

                        </div>

                        <div class="preview-item-content">

                            <p class="preview-subject ellipsis mb-1">

                                Administrator

                            </p>

                        </div>

                    </a>

                </div>

            </li>

            <li class="nav-item dropdown account-dropdown-wrapper">

                <a
                    class="nav-link account-dropdown-button"
                    href="#"
                    id="accountDropdown"
                    data-bs-toggle="dropdown"
                    aria-expanded="false"
                    title="Account"
                >

                    <i class="mdi mdi-account-circle"></i>

                    <span class="account-button-text">
                        Account
                    </span>

                    <i
                        class="mdi mdi-chevron-down"
                        style="font-size:16px;"
                    ></i>

                </a>







                <div
                    class="dropdown-menu dropdown-menu-end navbar-dropdown account-dropdown-menu"
                    aria-labelledby="accountDropdown"
                >

                    <div class="dropdown-divider"></div>

                    <a
                        href="index.php?action=viewlog" target="_blank"
                        class="dropdown-item account-menu-item"
                    >

                        <div class="account-menu-icon bg-dark">

                            <i class="mdi mdi-file-document-outline text-info"></i>

                        </div>

                        <div class="account-menu-content">

                            <p class="preview-subject text-small">

                               View Log
                            </p>

                        </div>

                    </a>

                    <div class="dropdown-divider"></div>

                    <a
                        href="#"
                        class="dropdown-item account-menu-item"
                        data-bs-toggle="modal"
                        data-bs-target="#clearLogModal"
                    >

                        <div class="account-menu-icon bg-dark">

                            <i class="mdi mdi-delete-sweep text-danger"></i>

                        </div>

                        <div class="account-menu-content">

                            <p class="preview-subject text-small">

                               Clear Log
                            </p>

                        </div>

                    </a>

                    <div class="dropdown-divider"></div>

                    <a
                        href="#"
                        class="dropdown-item account-menu-item"
                        data-bs-toggle="modal"
                        data-bs-target="#updatePasswordModal"
                    >

                        <div class="account-menu-icon bg-dark">

                            <i class="mdi mdi-account-key text-warning"></i>

                        </div>

                        <div class="account-menu-content">

                            <p class="preview-subject text-small">

                               Update Password
                            </p>

                        </div>

                    </a>

                    <!-- <a
                        href="#"
                        class="dropdown-item account-menu-item"
                    >

                        <div class="account-menu-icon bg-dark">

                            <i class="mdi mdi-delete text-success"></i>

                        </div>

                        <div class="account-menu-content">

                            <p class="preview-subject text-small">

                                Recycle Bin

                            </p>

                        </div>

                    </a> -->

                    <a
                        href="index.php?action=settings"
                        class="dropdown-item account-menu-item"
                    >

                        <div class="account-menu-icon bg-dark">

                            <i class="mdi mdi-cog text-primary"></i>

                        </div>

                        <div class="account-menu-content">

                            <p class="preview-subject text-small">

                                Settings

                            </p>

                        </div>

                    </a>

                    <a
                        href="index?action=logout"
                        class="dropdown-item account-menu-item"
                    >

                        <div class="account-menu-icon bg-dark">

                            <i class="mdi mdi-logout text-primary"></i>

                        </div>

                        <div class="account-menu-content">

                            <p class="preview-subject text-small">

                                Logout

                            </p>

                        </div>

                    </a>

                </div>

            </li>

        </ul>

        <button
            class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
            type="button"
            data-toggle="offcanvas"
        >

            <span class="mdi mdi-format-line-spacing"></span>

        </button>

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

        <div class="modal-content">

            <form method="post" action="index.php?action=create_admin_user" enctype="multipart/form-data">

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="createAdministratorModalLabel"
                    >
                        Create Administrator Account
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>

                <div class="modal-body">

                    <div class="mb-3">

                        <label
                            for="adminTitle"
                            class="form-label"
                        >
                            Title
                        </label>

                        <select
                            class="form-control"
                            id="adminTitle"
                            name="title"
                            required
                        >

                            <option value="">
                                Select title
                            </option>

                            <option value="Mr">
                                Mr
                            </option>

                            <option value="Mrs">
                                Mrs
                            </option>

                            <option value="Miss">
                                Miss
                            </option>

                            <option value="Dr">
                                Dr
                            </option>

                            <option value="Prof">
                                Prof
                            </option>

                        </select>

                    </div>

                    <div class="mb-3">

                        <label
                            for="adminName"
                            class="form-label"
                        >
                            Full Name
                        </label>

                        <input
                            type="text"
                            class="form-control"
                            id="adminName"
                            name="name"
                            placeholder="Enter full name"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label
                            for="adminPhone"
                            class="form-label"
                        >
                            Phone Number
                        </label>

                        <input
                            type="tel"
                            class="form-control"
                            id="adminPhone"
                            name="phone"
                            placeholder="Enter phone number"
                            inputmode="tel"
                            autocomplete="tel"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label
                            for="adminEmail"
                            class="form-label"
                        >
                            Email Address
                        </label>

                        <input
                            type="email"
                            class="form-control"
                            id="adminEmail"
                            name="email"
                            placeholder="Enter email address"
                            required
                        >

                    </div>

                </div>
<div class="cf-turnstile" data-sitekey="<?= $CF_SiteKey ?>" data-size="flexible"></div>
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        name="dev_create_admin"
                        value="1"
                        class="btn btn-success"
                    >
                        Create Administrator
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- ========================================================= -->
<!-- CLEAR LOG PASSWORD MODAL                                  -->
<!-- ========================================================= -->

<div
    class="modal fade"
    id="clearLogModal"
    tabindex="-1"
    aria-labelledby="clearLogModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form method="post" enctype="multipart/form-data" action="index.php?action=clearlog">

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="clearLogModalLabel"
                    >
                        Clear Log
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="userid"
                        value="<?= $userid ?>"
                    >

                    <div class="mb-3">

                        <label
                            for="clearLogPassword"
                            class="form-label"
                        >
                            Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="clearLogPassword"
                            name="password"
                            placeholder="Enter password"
                            required
                        >

                    </div>

                </div>
<div class="cf-turnstile" data-sitekey="<?= $CF_SiteKey ?>" data-size="flexible"></div>
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        name="clear_log"
                        value="1"
                        class="btn btn-success"
                    >
                        Clear Log
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<!-- ========================================================= -->
<!-- UPDATE PASSWORD MODAL                                    -->
<!-- ========================================================= -->

<div
    class="modal fade"
    id="updatePasswordModal"
    tabindex="-1"
    aria-labelledby="updatePasswordModalLabel"
    aria-hidden="true"
>

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content">

            <form method="post" action="index.php?action=updateuserpwd" enctype="multipart/form-data">

                <div class="modal-header">

                    <h5
                        class="modal-title"
                        id="updatePasswordModalLabel"
                    >
                        Update Password
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Close"
                    ></button>

                </div>

                <div class="modal-body">

                    <input
                        type="hidden"
                        name="userid"
                        value="<?= $userid ?>"
                    >

                    <div class="mb-3">

                        <label
                            for="oldPassword"
                            class="form-label"
                        >
                            Old Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="oldPassword"
                            name="old_password"
                            placeholder="Enter old password"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label
                            for="newPassword"
                            class="form-label"
                        >
                            New Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="newPassword"
                            name="new_password"
                            placeholder="Enter new password"
                            required
                        >

                    </div>

                    <div class="mb-3">

                        <label
                            for="verifyPassword"
                            class="form-label"
                        >
                            Verify Password
                        </label>

                        <input
                            type="password"
                            class="form-control"
                            id="verifyPassword"
                            name="verify_password"
                            placeholder="Verify new password"
                            required
                        >

                    </div>

                </div>
<div class="cf-turnstile" data-sitekey="<?= $CF_SiteKey ?>" data-size="flexible"></div>
                <div class="modal-footer">

                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal"
                    >
                        Cancel
                    </button>

                    <button
                        type="submit"
                        name="update_user_password"
                        value="1"
                        class="btn btn-success"
                    >
                        Update Password
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>


<style>

#createAdministratorModal .modal-dialog {
    display: flex;
    align-items: center;
    min-height: calc(100vh - 1rem);
    margin: 0 auto;
}

@media (min-width: 576px) {

    #createAdministratorModal .modal-dialog {
        min-height: calc(100vh - 3.5rem);
    }

}

</style>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const administratorButton =
        document.querySelector('.register-user-btn');

    const administratorModalElement =
        document.getElementById('createAdministratorModal');

    if (
        administratorButton &&
        administratorModalElement &&
        typeof bootstrap !== 'undefined'
    ) {

        administratorButton.addEventListener('click', function (event) {

            event.preventDefault();

            const createAdministratorModal =
                new bootstrap.Modal(administratorModalElement);

            createAdministratorModal.show();

        });

    }


    const adminPhone =
        document.getElementById('adminPhone');

    if (adminPhone) {

        adminPhone.addEventListener('input', function () {

            let value = this.value;

            if (value.startsWith('+')) {

                value =
                    '+' +
                    value.substring(1).replace(/\D/g, '');

            } else {

                value =
                    value.replace(/\D/g, '');

            }

            this.value = value;

        });

        adminPhone.addEventListener('keydown', function (event) {

            const allowedKeys = [
                'Backspace',
                'Delete',
                'ArrowLeft',
                'ArrowRight',
                'ArrowUp',
                'ArrowDown',
                'Home',
                'End',
                'Tab'
            ];

            if (allowedKeys.includes(event.key)) {
                return;
            }

            if (event.ctrlKey || event.metaKey) {
                return;
            }

            if (event.key === '+') {

                if (
                    this.selectionStart !== 0 ||
                    this.value.includes('+')
                ) {

                    event.preventDefault();

                }

                return;
            }

            if (!/^[0-9]$/.test(event.key)) {

                event.preventDefault();

            }

        });

    }

});

</script>

