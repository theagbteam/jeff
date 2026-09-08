<nav class="sidebar sidebar-offcanvas"id="sidebar">

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
<!-- <br> -->
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

    <a class="nav-link"
       href="index.php?action=dashboard"
       style="<?= $page_name === 'dashboard' ? 'color:lawngreen !important;' : '' ?>">

      <span class="menu-icon"
      style="<?= $page_name === 'dashboard' ? 'color:lawngreen !important;' : '' ?>">

    <i class="mdi mdi-view-dashboard"
       style="<?= $page_name === 'dashboard' ? 'color:green !important;' : '' ?>"></i>

</span>

        <span class="menu-title"
              style="<?= $page_name === 'dashboard' ? 'color:lawngreen !important;' : '' ?>">

            Dashboard

        </span>

    </a>

</li>

    
<li class="nav-item menu-items <?= $page_name === 'total request' ? 'active' : '' ?>">

    <a class="nav-link"
       href="index.php?action=totalrequest"
       style="<?= $page_name === 'total request' ? 'color:lawngreen !important;' : '' ?>">

      <span class="menu-icon"
      style="<?= $page_name === 'total request' ? 'color:lawngreen !important;' : '' ?>">

    <i class="mdi mdi-file-document-multiple"
       style="<?= $page_name === 'total request' ? 'color:green !important;' : '' ?>"></i>

</span>

        <span class="menu-title"
              style="<?= $page_name === 'total request' ? 'color:lawngreen !important;' : '' ?>">

            Total request

        </span>

    </a>

</li>






<li class="nav-item menu-items <?= $page_name === 'users' ? 'active' : '' ?>">

    <a class="nav-link"
       href="index.php?action=users"
       style="<?= $page_name === 'users' ? 'color:lawngreen !important;' : '' ?>">

      <span class="menu-icon"
      style="<?= $page_name === 'users' ? 'color:lawngreen !important;' : '' ?>">

    <i class="mdi mdi-account-multiple"
       style="<?= $page_name === 'users' ? 'color:green !important;' : '' ?>"></i>

</span>

        <span class="menu-title"
              style="<?= $page_name === 'users' ? 'color:lawngreen !important;' : '' ?>">

            Users

        </span>

    </a>

</li>



            <li
                class="nav-item menu-items <?= $page_name === 'deleted_items' ? 'active' : '' ?>"
            >

            </li>

            <li
                class="nav-item menu-items <?= $page_name === 'corridors' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=corridors"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-road-variant"></i>

                    </span>

                    <span class="menu-title">

                        Corridors

                    </span>

                </a>

            </li>

            <li
                class="nav-item menu-items <?= $page_name === 'incidence_source' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=incidence_source"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-source-branch"></i>

                    </span>

                    <span class="menu-title">

                        Incidence Source

                    </span>

                </a>

            </li>

            <li
                class="nav-item menu-items <?= $page_name === 'operators' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=operators"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-account-hard-hat"></i>

                    </span>

                    <span class="menu-title">

                        Operators

                    </span>

                </a>

            </li>

            <li
                class="nav-item menu-items <?= $page_name === 'owners' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=owners"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-account-star"></i>

                    </span>

                    <span class="menu-title">

                        Owners

                    </span>

                </a>

            </li>

            <li
                class="nav-item menu-items <?= $page_name === 'pipelines' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=pipelines"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-pipe"></i>

                    </span>

                    <span class="menu-title">

                        Pipelines

                    </span>

                </a>

            </li>

            <li
                class="nav-item menu-items <?= $page_name === 'pipeline_types' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=pipeline_types"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-pipe-disconnected"></i>

                    </span>

                    <span class="menu-title">

                        Pipeline Types

                    </span>

                </a>

            </li>

            <li
                class="nav-item menu-items <?= $page_name === 'priority' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=priority"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-alert-circle"></i>

                    </span>

                    <span class="menu-title">

                        Priority

                    </span>

                </a>

            </li>

            <li
                class="nav-item menu-items <?= $page_name === 'zones' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=zones"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-map-marker-multiple"></i>

                    </span>

                    <span class="menu-title">

                        Zones

                    </span>

                </a>

            </li>

            <li
                class="nav-item menu-items <?= $page_name === 'wellhead_status' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=wellhead_status"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-oil"></i>

                    </span>

                    <span class="menu-title">

                        Wellhead Status

                    </span>

                </a>

            </li>

            <li
                class="nav-item menu-items <?= $page_name === 'report_types' ? 'active' : '' ?>"
            >

                <a
                    class="nav-link"
                    href="index?action=report_types"
                >

                    <span class="menu-icon">

                        <i class="mdi mdi-file-chart"></i>

                    </span>

                    <span class="menu-title">

                        Report Types

                    </span>

                </a>

            </li>

        </ul>

    </nav>
