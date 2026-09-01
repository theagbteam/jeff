
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
                                href="#"
                                class="dropdown-item account-menu-item"
                            >

                                <div class="account-menu-icon bg-dark">

                                    <i class="mdi mdi-onepassword text-info"></i>

                                </div>

                                <div class="account-menu-content">

                                    <p class="preview-subject text-small">

                                        Update info

                                    </p>

                                </div>

                            </a>

                            <div class="dropdown-divider"></div>

                            <a
                                href="#"
                                class="dropdown-item account-menu-item"
                            >

                                <div class="account-menu-icon bg-dark">

                                    <i class="mdi mdi-account-key text-warning"></i>

                                </div>

                                <div class="account-menu-content">

                                    <p class="preview-subject text-small">

                                        User Roles

                                    </p>

                                </div>

                            </a>

                            <a
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

                            </a>

                            <a
                                href="#"
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