<nav class="sidebar sidebar-offcanvas" id="sidebar">

    <div
        class="sidebar-brand-wrapper d-none d-lg-flex align-items-center justify-content-center fixed-top"
    >

        <a
            class="sidebar-brand brand-logo"
            style="color:aliceblue; text-decoration:none;"
            href="index?action=index"
        >

            <img
                style="
                    width:50px !important;
                    height:50px !important;
                    object-fit:contain !important;
                "
                src="views/uploads/img/<?= htmlspecialchars($company_logo) ?>"
                alt="logo"
            >

            <?= htmlspecialchars($company_alias) ?>

        </a>

        <a
            class="sidebar-brand brand-logo-mini"
            href="index?action=index"
        >

            <img
                src="views/uploads/img/<?= htmlspecialchars($company_logo) ?>"
                alt="logo"
            >

        </a>

    </div>

    <ul class="nav">

        <li class="nav-item profile">

            <div class="profile-desc">

                <div class="profile-pic">

                    <div class="count-indicator">

                        <img
                            class="img-xs rounded-circle"
                            src="views/uploads/img/profile/<?= $user_image ?>"
                            alt=""
                        >

                        <span class="count bg-success"></span>

                    </div>

                    <div class="profile-name">

                        <h5 class="mb-0 font-weight-normal">

                            <?= htmlspecialchars($AbrvName) ?>

                        </h5>

                        <span>

                            <?= ucfirst(htmlspecialchars($role_name)) ?>

                        </span>

                    </div>

                </div>

            </div>

        </li>

        <li class="nav-item nav-category">

            <span class="nav-link">
                Navigation
            </span>

        </li>


        <li class="nav-item menu-items <?= $page_name === 'dashboard' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=dashboard"
                style="<?= $page_name === 'dashboard' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $page_name === 'dashboard' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-view-dashboard"
                        style="<?= $page_name === 'dashboard' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $page_name === 'dashboard' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Dashboard

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $page_name === 'total request' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=totalrequest"
                style="<?= $page_name === 'total request' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $page_name === 'total request' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-file-document-multiple"
                        style="<?= $page_name === 'total request' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $page_name === 'total request' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Total request

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $page_name === 'users' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=users"
                style="<?= $page_name === 'users' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $page_name === 'users' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-account-multiple"
                        style="<?= $page_name === 'users' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $page_name === 'users' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Users

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $tb_name === 'corridor' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=corridors"
                style="<?= $tb_name === 'corridor' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $tb_name === 'corridor' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-account-multiple"
                        style="<?= $tb_name === 'corridor' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $tb_name === 'corridor' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Corridors

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $tb_name === 'incidence_source' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=incidence_source"
                style="<?= $tb_name === 'incidence_source' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $tb_name === 'incidence_source' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-source-branch"
                        style="<?= $tb_name === 'incidence_source' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $tb_name === 'incidence_source' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Incidence Source

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $tb_name === 'operator' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=operator"
                style="<?= $tb_name === 'operator' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $tb_name === 'operator' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-account-hard-hat"
                        style="<?= $tb_name === 'operator' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $tb_name === 'operator' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Operators

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $tb_name === 'owner' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=owners"
                style="<?= $tb_name === 'owner' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $tb_name === 'owner' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-account-star"
                        style="<?= $tb_name === 'owner' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $tb_name === 'owner' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Owners

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $tb_name === 'pipeline' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=pipelines"
                style="<?= $tb_name === 'pipeline' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $tb_name === 'pipeline' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-pipe"
                        style="<?= $tb_name === 'pipeline' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $tb_name === 'pipeline' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Pipelines

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $tb_name === 'pipeline_type' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=pipeline_types"
                style="<?= $tb_name === 'pipeline_type' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $tb_name === 'pipeline_type' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-pipe-disconnected"
                        style="<?= $tb_name === 'pipeline_type' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $tb_name === 'pipeline_type' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Pipeline Types

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $tb_name === 'priority' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=priority"
                style="<?= $tb_name === 'priority' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $tb_name === 'priority' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-alert-circle"
                        style="<?= $tb_name === 'priority' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $tb_name === 'priority' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Priority

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $tb_name === 'zone' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=zones"
                style="<?= $tb_name === 'zone' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $tb_name === 'zone' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-map-marker-multiple"
                        style="<?= $tb_name === 'zone' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $tb_name === 'zone' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Zones

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $tb_name === 'wellhead_status' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=wellhead_status"
                style="<?= $tb_name === 'wellhead_status' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $tb_name === 'wellhead_status' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-oil"
                        style="<?= $tb_name === 'wellhead_status' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $tb_name === 'wellhead_status' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Wellhead Status

                </span>

            </a>

        </li>


        <li class="nav-item menu-items <?= $tb_name === 'report_type' ? 'active' : '' ?>">

            <a
                class="nav-link"
                href="index.php?action=report_types"
                style="<?= $tb_name === 'report_type' ? 'color:lawngreen !important;' : '' ?>"
            >

                <span
                    class="menu-icon"
                    style="<?= $tb_name === 'report_type' ? 'color:lawngreen !important;' : '' ?>"
                >

                    <i
                        class="mdi mdi-file-chart"
                        style="<?= $tb_name === 'report_type' ? 'color:green !important;' : '' ?>"
                    ></i>

                </span>

                <span
                    class="menu-title"
                    style="<?= $tb_name === 'report_type' ? 'color:lawngreen !important;' : '' ?>"
                >

                    Report Types

                </span>

            </a>

        </li>

    </ul>

</nav>