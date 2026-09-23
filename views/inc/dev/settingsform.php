<?php

$default_company_banner = $company_settings['company_banner'] ?? '';

$company_logo_name = "../image_upload/" . ($company_logo ?? '');
 $Mailbanner_url = rtrim($company_settings ['company_url'], '/')
            . "/views/uploads/img/"
            . $default_company_banner;
?>

<!-- =========================================================
     COMPANY SUMMARY BOXES
========================================================= -->

<div class="row">

    <!-- COMPANY NAME -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">

                <div class="row">

                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h6 class="text-muted font-weight-normal">
                                COMPANY NAME
                            </h6>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                    </div>

                </div>

                <h5 class="mb-0">
                    <?= ucfirst(
                        htmlspecialchars(
                            $company_settings['company_name'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        )
                    ); ?>
                </h5>

                <h5 class="mb-0">
                    <?= ucfirst(
                        htmlspecialchars(
                            $company_settings['company_alias'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        )
                    ); ?>
                </h5>

                <?php if (!empty($Company_name_alias)): ?>

                    <h5 class="mb-0">
                        (
                        <?= ucfirst(
                            htmlspecialchars(
                                $Company_name_alias,
                                ENT_QUOTES,
                                'UTF-8'
                            )
                        ); ?>
                        )
                    </h5>

                <?php endif; ?>

            </div>
        </div>

    </div>


    <!-- CONTACT -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">

                <div class="row">

                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h6 class="text-muted font-weight-normal">
                                CONTACT
                            </h6>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                    </div>

                </div>

                <h5 class="mb-0">
                    <?= htmlspecialchars(
                        $company_settings['company_email'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>
                </h5>

                <br>

                <h5 class="mb-0">
                    <?= htmlspecialchars(
                        $company_settings['company_phone'] ?? '',
                        ENT_QUOTES,
                        'UTF-8'
                    ); ?>
                </h5>

            </div>
        </div>

    </div>


    <!-- COMPANY ADDRESS -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">

                <div class="row">

                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h6 class="text-muted font-weight-normal">
                                COMPANY ADDRESS
                            </h6>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-arrow-bottom-left icon-item"></span>
                        </div>
                    </div>

                </div>

                <h5 class="mb-0" style="text-align:justify">
                    <?= ucfirst(
                        htmlspecialchars(
                            $company_settings['company_address'] ?? '',
                            ENT_QUOTES,
                            'UTF-8'
                        )
                    ); ?>
                </h5>

            </div>
        </div>

    </div>


    <!-- LOGO REVIEW -->
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card">

        <div class="card">
            <div class="card-body">

                <div class="row">

                    <div class="col-9">
                        <div class="d-flex align-items-center align-self-start">
                            <h6 class="text-muted font-weight-normal">
                                LOGO REVIEW
                            </h6>
                        </div>
                    </div>

                    <div class="col-3">
                        <div class="icon icon-box-success">
                            <span class="mdi mdi-arrow-top-right icon-item"></span>
                        </div>
                    </div>

                </div>

                <h3 class="mb-0">

                    <?php if (!empty($company_logo)): ?>

                        <img
                            src="views/uploads/img/<?= htmlspecialchars(
                                $company_logo,
                                ENT_QUOTES,
                                'UTF-8'
                            ); ?>"
                            alt="Company Logo"
                            style="max-width:30%; height:auto;"
                        >

                    <?php else: ?>

                        <span class="text-muted">
                            No Logo
                        </span>

                    <?php endif; ?>

                </h3>

            </div>
        </div>

    </div>

</div>


<!-- =========================================================
     MANAGE COMPANY DETAILS
========================================================= -->

<div class="row">

    <div class="col-12 grid-margin stretch-card">

        <div class="card">

            <!-- DROPDOWN HEADER -->
            <div
                id="companyDetailsToggle"
                style="cursor:pointer;"
            >

                <div class="card-body">

                    <div class="d-flex flex-row justify-content-between align-items-center">

                        <div>

                            <h4 class="card-title mb-1">
                                Manage Company Details
                            </h4>

                            <p class="text-muted mb-0">
                                Update your company information and settings
                            </p>

                        </div>

                        <div>

                            <span
                                id="companyDetailsArrow"
                                class="mdi mdi-chevron-down"
                                style="font-size:24px;"
                            ></span>

                        </div>

                    </div>

                </div>

            </div>


            <!-- DROPDOWN CONTENT -->
            <div
                id="companyDetailsContent"
                style="display:none;"
            >

                <div class="card-body">

                    <div class="mt-1">

                        <form
                            id="companyDetailsForm"
                            class="forms-sample"
                            action="index?action=updateCompanyDetails"
                            method="post"
                            enctype="multipart/form-data"
                        >

                            <!-- ROW 1 -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_url">
                                            Company URL
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="url"
                                            name="company_url"
                                            class="form-control"
                                            id="company_url"
                                            maxlength="255"
                                            pattern="https?://.+"
                                            placeholder="https://example.com"
                                            title="Enter a valid URL beginning with http:// or https://"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_url'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_logfile_url">
                                            Log File Path
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="text"
                                            name="company_logfile_url"
                                            class="form-control"
                                            id="company_logfile_url"
                                            maxlength="255"
                                            pattern="^[A-Za-z]:[\\/].+|^[/\\\\].+|^[A-Za-z0-9_.-]+([/\\\\][A-Za-z0-9_. -]+)*$"
                                            placeholder="C:\xampp\htdocs\jeff\log\log.log"
                                            title="Enter a valid local or Windows filesystem path"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_logfile_url'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>

                            </div>


                            <!-- ROW 2 -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_userid">
                                            Company User ID
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="number"
                                            name="company_userid"
                                            class="form-control"
                                            id="company_userid"
                                            min="0"
                                            max="2147483647"
                                            step="1"
                                            placeholder="Enter numeric user ID"
                                            title="Enter a whole number between 0 and 2147483647"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_userid'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_signup">
                                            Allow Signup
                                        </label>

                                        <select
                                            style="color:white;"
                                            name="company_signup"
                                            class="form-control"
                                            id="company_signup"
                                            required
                                        >

                                            <option
                                                value="1"
                                                <?= ((string)($company_settings['company_signup'] ?? '') === '1') ? 'selected' : ''; ?>
                                            >
                                                Enabled
                                            </option>

                                            <option
                                                value="0"
                                                <?= ((string)($company_settings['company_signup'] ?? '') === '0') ? 'selected' : ''; ?>
                                            >
                                                Disabled
                                            </option>

                                        </select>

                                    </div>

                                </div>

                            </div>


                            <!-- ROW 3 -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_map">
                                            Company Map
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="text"
                                            name="company_map"
                                            class="form-control"
                                            id="company_map"
                                            maxlength="255"
                                            pattern="^[A-Za-z0-9 .,_:/?&=#%+\-()';&quot;]+$"
                                            placeholder="Enter company map information"
                                            title="Enter valid map information"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_map'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_acct_approval">
                                            Auto Account Approval
                                        </label>

                                        <select
                                            required
                                            style="color:white;"
                                            name="company_acct_approval"
                                            class="form-control"
                                            id="company_acct_approval"
                                        >

                                            <option
                                                value="1"
                                                <?= ((string)($company_settings['company_acct_approval'] ?? '') === '1') ? 'selected' : ''; ?>
                                            >
                                                Enabled
                                            </option>

                                            <option
                                                value="0"
                                                <?= ((string)($company_settings['company_acct_approval'] ?? '') === '0') ? 'selected' : ''; ?>
                                            >
                                                Disabled
                                            </option>

                                        </select>

                                    </div>

                                </div>

                            </div>


                            <!-- ROW 4 -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_auto_ticketing">
                                            Automatic Ticketing
                                        </label>

                                        <select
                                            required
                                            style="color:white;"
                                            name="company_auto_ticketing"
                                            class="form-control"
                                            id="company_auto_ticketing"
                                        >

                                            <option
                                                value="1"
                                                <?= ((string)($company_settings['company_auto_ticketing'] ?? '') === '1') ? 'selected' : ''; ?>
                                            >
                                                Enabled
                                            </option>

                                            <option
                                                value="0"
                                                <?= ((string)($company_settings['company_auto_ticketing'] ?? '') === '0') ? 'selected' : ''; ?>
                                            >
                                                Disabled
                                            </option>

                                        </select>

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_online">
                                            Company Mode
                                        </label>

                                        <select
                                            style="color:white;"
                                            name="company_online"
                                            class="form-control"
                                            id="company_online"
                                            required
                                        >

                                            <option
                                                value="1"
                                                <?= ((string)($company_settings['company_online'] ?? '') === '1') ? 'selected' : ''; ?>
                                            >
                                                Online
                                            </option>

                                            <option
                                                value="0"
                                                <?= ((string)($company_settings['company_online'] ?? '') === '0') ? 'selected' : ''; ?>
                                            >
                                                Offline
                                            </option>

                                        </select>

                                    </div>

                                </div>

                            </div>


                            <!-- ROW 5 -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_name">
                                            Company Name
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="text"
                                            name="company_name"
                                            class="form-control"
                                            id="company_name"
                                            minlength="2"
                                            maxlength="255"
                                            pattern="^[A-Za-z0-9][A-Za-z0-9 .&'()_\-]{1,254}$"
                                            placeholder="Enter company name"
                                            title="Company name must be 2-255 characters and may contain letters, numbers, spaces and basic punctuation"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_name'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_alias">
                                            Company Alias
                                        </label>

                                        <input
                                            style="color:white"
                                            type="text"
                                            name="company_alias"
                                            class="form-control"
                                            id="company_alias"
                                            minlength="1"
                                            maxlength="255"
                                            pattern="^[A-Za-z0-9][A-Za-z0-9._\- ]{0,254}$"
                                            placeholder="Enter company alias"
                                            title="Alias must be 1-255 characters using letters, numbers, spaces, dots, underscores or hyphens"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_alias'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>

                            </div>


                            <!-- ROW 6 -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_email">
                                            Company Email
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="email"
                                            name="company_email"
                                            class="form-control"
                                            id="company_email"
                                            maxlength="255"
                                            placeholder="name@example.com"
                                            title="Enter a valid email address"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_email'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_phone">
                                            Company Phone
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="tel"
                                            name="company_phone"
                                            class="form-control"
                                            id="company_phone"
                                            maxlength="16"
                                            pattern="^\+?[0-9]{7,15}$"
                                            placeholder="08012345678"
                                            title="Enter a valid phone number containing 7-15 digits, optionally beginning with +"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_phone'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>

                            </div>


                            <!-- ROW 7 -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_phone2">
                                            Alternative Phone
                                        </label>

                                        <input
                                            style="color:white"
                                            type="tel"
                                            name="company_phone2"
                                            class="form-control"
                                            id="company_phone2"
                                            maxlength="16"
                                            pattern="^\+?[0-9]{7,15}$"
                                            placeholder="08012345678"
                                            title="Enter a valid phone number containing 7-15 digits, optionally beginning with +"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_phone2'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_address">
                                            Company Address
                                        </label>

                                        <textarea
                                            style="color:white"
                                            required
                                            name="company_address"
                                            class="form-control"
                                            id="company_address"
                                            rows="3"
                                            minlength="3"
                                            maxlength="255"
                                            pattern="^[A-Za-z0-9][A-Za-z0-9 .,#&'()\/\-]{2,254}$"
                                            placeholder="Enter company address"
                                            title="Address must be 3-255 characters"
                                        ><?= htmlspecialchars(
                                            $company_settings['company_address'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?></textarea>

                                    </div>

                                </div>

                            </div>


                            <!-- ROW 8 -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_address2">
                                            Alternative Address
                                        </label>

                                        <textarea
                                            style="color:white"
                                            name="company_address2"
                                            class="form-control"
                                            id="company_address2"
                                            rows="3"
                                            minlength="3"
                                            maxlength="255"
                                            pattern="^[A-Za-z0-9][A-Za-z0-9 .,#&'()\/\-]{2,254}$"
                                            placeholder="Enter alternative address"
                                            title="Address must be 3-255 characters"
                                        ><?= htmlspecialchars(
                                            $company_settings['company_address2'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?></textarea>

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_care">
                                            Customer Care
                                        </label>

                                        <textarea
                                            style="color:white"
                                            name="company_care"
                                            class="form-control"
                                            id="company_care"
                                            rows="3"
                                            minlength="3"
                                            maxlength="255"
                                            pattern="^[A-Za-z0-9][A-Za-z0-9 .,:;@_+#&'()\/\-]{2,254}$"
                                            placeholder="Enter customer care information"
                                            title="Customer care information must be 3-255 characters"
                                        ><?= htmlspecialchars(
                                            $company_settings['company_care'] ?? '',
                                            ENT_QUOTES,
                                            'UTF-8'
                                        ); ?></textarea>

                                    </div>

                                </div>

                            </div>


                            <!-- ROW 9 -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_care2">
                                            Alternative Customer Care
                                        </label>

                                        <input
                                            style="color:white"
                                            type="text"
                                            name="company_care2"
                                            class="form-control"
                                            id="company_care2"
                                            minlength="3"
                                            maxlength="255"
                                            pattern="^[A-Za-z0-9][A-Za-z0-9 .,:;@_+#&'()\/\-]{2,254}$"
                                            placeholder="Enter alternative customer care"
                                            title="Customer care information must be 3-255 characters"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_care2'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_copyright">
                                            Copyright
                                        </label>

                                        <input
                                            style="color:white"
                                            type="text"
                                            name="company_copyright"
                                            class="form-control"
                                            id="company_copyright"
                                            maxlength="255"
                                            pattern="^[A-Za-z0-9][A-Za-z0-9 .,:;@_+#&'()\/\-]{0,254}$"
                                            placeholder="Enter copyright text"
                                            title="Copyright must contain valid text and be no more than 255 characters"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_copyright'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>

                            </div>


                            <!-- ROW 10 -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_copyrightlink">
                                            Copyright Link
                                        </label>

                                        <input
                                            style="color:white"
                                            type="url"
                                            name="company_copyrightlink"
                                            class="form-control"
                                            id="company_copyrightlink"
                                            maxlength="255"
                                            pattern="https?://.+"
                                            placeholder="https://example.com"
                                            title="Enter a valid URL beginning with http:// or https://"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_copyrightlink'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_poweredby">
                                            Powered By
                                        </label>

                                        <input
                                            style="color:white"
                                            type="text"
                                            name="company_poweredby"
                                            class="form-control"
                                            id="company_poweredby"
                                            maxlength="255"
                                            pattern="^[A-Za-z0-9][A-Za-z0-9 .,:;@_+#&'()\/\-]{0,254}$"
                                            placeholder="Enter powered by"
                                            title="Powered by text must contain valid text and be no more than 255 characters"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_poweredby'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>

                            </div>


                            <!-- ROW 11 - LOGO + FAVICON -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="file-upload">
                                            Upload Logo (214px X 70)
                                        </label>

                                        <input
                                            type="file"
                                            name="user_image"
                                            class="file-upload-default"
                                            id="file-upload"
                                            style="display:none;"
                                            accept="image/png,image/jpeg,image/jpg,image/webp"
                                        >

                                        <div class="input-group col-xs-12">

                                            <input
                                                type="text"
                                                name="company_logo_text"
                                                class="form-control file-upload-info"
                                                id="file-upload-info"
                                                style="pointer-events:none;"
                                                placeholder="Upload Image"
                                                value="<?= htmlspecialchars(
                                                    $company_logo ?? '',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                            >

                                            <span class="input-group-append">

                                                <button
                                                    class="file-upload-browse btn btn-primary"
                                                    id="upload-button"
                                                    type="button"
                                                >
                                                    Browse
                                                </button>

                                            </span>

                                        </div>

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="favicon-upload">
                                            Upload Favicon
                                        </label>

                                        <input
                                            type="file"
                                            name="favicon_image"
                                            class="file-upload-default"
                                            id="favicon-upload"
                                            style="display:none;"
                                            accept="image/png,image/x-icon,image/vnd.microsoft.icon,image/jpeg,image/webp"
                                        >

                                        <div class="input-group col-xs-12">

                                            <input
                                                type="text"
                                                name="company_favicon_text"
                                                class="form-control file-upload-info"
                                                id="favicon-upload-info"
                                                style="pointer-events:none;"
                                                placeholder="Upload Favicon"
                                                value="<?= htmlspecialchars(
                                                    $company_favicon ?? '',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                            >

                                            <span class="input-group-append">

                                                <button
                                                    class="file-upload-browse btn btn-primary"
                                                    id="favicon-upload-button"
                                                    type="button"
                                                >
                                                    Browse
                                                </button>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

<div class="cf-turnstile" data-sitekey="<?= $CF_SiteKey ?>" style="width: 100%;"></div>
                            <!-- SUBMIT -->
                            <div class="mt-2">

                                <button
                                    type="submit"
                                    name="company_submit"
                                    class="btn btn-primary me-2"
                                >
                                    Update Now
                                </button>

                                <button
                                    type="reset"
                                    class="btn btn-dark"
                                >
                                    Cancel
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<!-- =========================================================
     MAILER SETTINGS
========================================================= -->

<div class="row">

    <div class="col-12 grid-margin stretch-card">

        <div class="card">

            <div
                id="mailerSettingsToggle"
                style="cursor:pointer;"
            >

                <div class="card-body">

                    <div class="d-flex flex-row justify-content-between align-items-center">

                        <div>

                            <h4 class="card-title mb-1">
                                Mailer Settings
                            </h4>

                            <p class="text-muted mb-0">
                                Configure your email server and mail delivery settings
                            </p>

                        </div>

                        <div>

                            <span
                                id="mailerSettingsArrow"
                                class="mdi mdi-chevron-down"
                                style="font-size:24px;"
                            ></span>

                        </div>

                    </div>

                </div>

            </div>


            <div
                id="mailerSettingsContent"
                style="display:none;"
            >

                <div class="card-body">

                    <div class="mt-1">

                        <form
                            id="mailerSettingsForm"
                            class="forms-sample"
                            action="index?action=updateMailerDetails"
                            method="post"
                            enctype="multipart/form-data"
                        >

                            <!-- MAILER HOST + EMAIL -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_mailer_host">
                                            Mailer Host
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="text"
                                            name="company_mailer_host"
                                            class="form-control"
                                            id="company_mailer_host"
                                            minlength="3"
                                            maxlength="255"
                                            pattern="^(?=.{3,255}$)([A-Za-z0-9](?:[A-Za-z0-9-]{0,61}[A-Za-z0-9])?\.)+[A-Za-z]{2,63}$|^(?:[0-9]{1,3}\.){3}[0-9]{1,3}$|^localhost$"
                                            placeholder="smtp.example.com"
                                            title="Enter a valid mail server hostname, IPv4 address, or localhost"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_mailer_host'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_mailer_email">
                                            Mailer Email
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="email"
                                            name="company_mailer_email"
                                            class="form-control"
                                            id="company_mailer_email"
                                            maxlength="255"
                                            placeholder="mailer@example.com"
                                            title="Enter a valid mailer email address"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_mailer_email'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>

                            </div>


                            <!-- MAILER PORT + PASSWORD -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_mailer_port">
                                            Mailer Port
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="number"
                                            name="company_mailer_port"
                                            class="form-control"
                                            id="company_mailer_port"
                                            min="1"
                                            max="65535"
                                            step="1"
                                            placeholder="587"
                                            title="Enter a valid port between 1 and 65535"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_mailer_port'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_mailer_password">
                                            Mailer Password
                                        </label>

                                        <input
                                            style="color:white"
                                            required
                                            type="password"
                                            name="company_mailer_password"
                                            class="form-control"
                                            id="company_mailer_password"
                                            minlength="1"
                                            maxlength="255"
                                            placeholder="Enter mailer password"
                                            title="Enter the mailer password"
                                            value="<?= htmlspecialchars(
                                                $company_settings['company_mailer_password'] ?? '',
                                                ENT_QUOTES,
                                                'UTF-8'
                                            ); ?>"
                                        >

                                    </div>

                                </div>

                            </div>


                            <!-- MAILER SECURITY + MAIL BANNER -->
                            <div class="row">

                                <div class="col-md-6">

                                    <div class="form-group">

                                        <label for="company_mailer_secure">
                                            Mailer Security
                                        </label>

                                        <select
                                            required
                                            style="color:white;"
                                            name="company_mailer_secure"
                                            class="form-control"
                                            id="company_mailer_secure"
                                        >

                                            <option
                                                value=""
                                                disabled
                                                <?= empty($company_settings['company_mailer_secure']) ? 'selected' : ''; ?>
                                            >
                                                Select Security
                                            </option>

                                            <option
                                                value="tls"
                                                <?= strtolower(
                                                    (string)($company_settings['company_mailer_secure'] ?? '')
                                                ) === 'tls' ? 'selected' : ''; ?>
                                            >
                                                TLS
                                            </option>

                                            <option
                                                value="ssl"
                                                <?= strtolower(
                                                    (string)($company_settings['company_mailer_secure'] ?? '')
                                                ) === 'ssl' ? 'selected' : ''; ?>
                                            >
                                                SSL
                                            </option>

                                        </select>

                                    </div>

                                </div>


                                <div class="col-md-6">

                                    <div class="form-group" >

                                        <label for="company_banner_upload" >
                                            Mail Banner <a target="_blank"  href="<?= $Mailbanner_url ?>" style="text-decoration: none !important; color: orange;">(1400px X 370px)</a>
                                        </label>

                                        <input
                                            type="file"
                                            name="company_banner"
                                            class="file-upload-default"
                                            id="company_banner_upload"
                                            style="display:none;"
                                            accept="image/png,image/jpeg,image/jpg,image/webp"
                                        >

                                        <div class="input-group col-xs-12">

                                            <input
                                                type="text"
                                                name="company_banner_text"
                                                class="form-control file-upload-info"
                                                id="company_banner_upload_info"
                                                style="pointer-events:none;"
                                                placeholder="Upload Mail Banner"
                                                value="<?= htmlspecialchars(
                                                    $company_settings['company_banner'] ?? '',
                                                    ENT_QUOTES,
                                                    'UTF-8'
                                                ); ?>"
                                            >

                                            <span class="input-group-append">

                                                <button
                                                    class="file-upload-browse btn btn-primary"
                                                    id="company_banner_upload_button"
                                                    type="button"
                                                >
                                                    Browse
                                                </button>

                                            </span>

                                        </div>

                                    </div>

                                </div>

                            </div>

<div class="cf-turnstile" data-sitekey="<?= $CF_SiteKey ?>" style="width: 100%;"></div>
                            <!-- SUBMIT -->
                            <div class="mt-2">

                                <button
                                    type="submit"
                                    name="mailer_submit"
                                    class="btn btn-primary me-2"
                                >
                                    Update Now
                                </button>

                                <button
                                    type="reset"
                                    class="btn btn-dark"
                                >
                                    Cancel
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    /* =====================================================
       COMPANY DETAILS DROPDOWN
    ===================================================== */

    const companyDetailsToggle =
        document.getElementById('companyDetailsToggle');

    const companyDetailsContent =
        document.getElementById('companyDetailsContent');

    const companyDetailsArrow =
        document.getElementById('companyDetailsArrow');


    if (
        companyDetailsToggle &&
        companyDetailsContent &&
        companyDetailsArrow
    ) {

        companyDetailsToggle.addEventListener('click', function () {

            if (companyDetailsContent.style.display === 'none') {

                companyDetailsContent.style.display = 'block';

                companyDetailsArrow.classList.remove(
                    'mdi-chevron-down'
                );

                companyDetailsArrow.classList.add(
                    'mdi-chevron-up'
                );

            } else {

                companyDetailsContent.style.display = 'none';

                companyDetailsArrow.classList.remove(
                    'mdi-chevron-up'
                );

                companyDetailsArrow.classList.add(
                    'mdi-chevron-down'
                );

            }

        });

    }


    /* =====================================================
       MAILER SETTINGS DROPDOWN
    ===================================================== */

    const mailerSettingsToggle =
        document.getElementById('mailerSettingsToggle');

    const mailerSettingsContent =
        document.getElementById('mailerSettingsContent');

    const mailerSettingsArrow =
        document.getElementById('mailerSettingsArrow');


    if (
        mailerSettingsToggle &&
        mailerSettingsContent &&
        mailerSettingsArrow
    ) {

        mailerSettingsToggle.addEventListener('click', function () {

            if (mailerSettingsContent.style.display === 'none') {

                mailerSettingsContent.style.display = 'block';

                mailerSettingsArrow.classList.remove(
                    'mdi-chevron-down'
                );

                mailerSettingsArrow.classList.add(
                    'mdi-chevron-up'
                );

            } else {

                mailerSettingsContent.style.display = 'none';

                mailerSettingsArrow.classList.remove(
                    'mdi-chevron-up'
                );

                mailerSettingsArrow.classList.add(
                    'mdi-chevron-down'
                );

            }

        });

    }


    /* =====================================================
       COMPANY LOGO UPLOAD
    ===================================================== */

    const uploadButton =
        document.getElementById('upload-button');

    const fileUpload =
        document.getElementById('file-upload');

    const fileUploadInfo =
        document.getElementById('file-upload-info');


    if (
        uploadButton &&
        fileUpload &&
        fileUploadInfo
    ) {

        uploadButton.addEventListener('click', function () {

            fileUpload.click();

        });


        fileUpload.addEventListener('change', function () {

            if (fileUpload.files.length === 0) {
                return;
            }

            const file = fileUpload.files[0];

            const allowedTypes = [
                'image/png',
                'image/jpeg',
                'image/webp'
            ];

            const maxSize = 2 * 1024 * 1024;


            if (!allowedTypes.includes(file.type)) {

                alert(
                    'Invalid logo file. Please select a PNG, JPG, JPEG or WEBP image.'
                );

                fileUpload.value = '';
                fileUploadInfo.value = '';

                return;

            }


            if (file.size > maxSize) {

                alert(
                    'Logo file is too large. Maximum allowed size is 2MB.'
                );

                fileUpload.value = '';
                fileUploadInfo.value = '';

                return;

            }


            fileUploadInfo.value = file.name;

        });

    }


    /* =====================================================
       FAVICON UPLOAD
    ===================================================== */

    const faviconUploadButton =
        document.getElementById('favicon-upload-button');

    const faviconUpload =
        document.getElementById('favicon-upload');

    const faviconUploadInfo =
        document.getElementById('favicon-upload-info');


    if (
        faviconUploadButton &&
        faviconUpload &&
        faviconUploadInfo
    ) {

        faviconUploadButton.addEventListener('click', function () {

            faviconUpload.click();

        });


        faviconUpload.addEventListener('change', function () {

            if (faviconUpload.files.length === 0) {
                return;
            }

            const file = faviconUpload.files[0];

            const allowedTypes = [
                'image/png',
                'image/x-icon',
                'image/vnd.microsoft.icon',
                'image/jpeg',
                'image/webp'
            ];

            const maxSize = 1 * 1024 * 1024;


            if (!allowedTypes.includes(file.type)) {

                alert(
                    'Invalid favicon file. Please select a PNG, ICO, JPG, JPEG or WEBP image.'
                );

                faviconUpload.value = '';
                faviconUploadInfo.value = '';

                return;

            }


            if (file.size > maxSize) {

                alert(
                    'Favicon file is too large. Maximum allowed size is 1MB.'
                );

                faviconUpload.value = '';
                faviconUploadInfo.value = '';

                return;

            }


            faviconUploadInfo.value = file.name;

        });

    }


    /* =====================================================
       MAIL BANNER UPLOAD
    ===================================================== */

    const companyBannerUploadButton =
        document.getElementById('company_banner_upload_button');

    const companyBannerUpload =
        document.getElementById('company_banner_upload');

    const companyBannerUploadInfo =
        document.getElementById('company_banner_upload_info');


    if (
        companyBannerUploadButton &&
        companyBannerUpload &&
        companyBannerUploadInfo
    ) {

        companyBannerUploadButton.addEventListener('click', function () {

            companyBannerUpload.click();

        });


        companyBannerUpload.addEventListener('change', function () {

            if (companyBannerUpload.files.length === 0) {
                return;
            }

            const file = companyBannerUpload.files[0];

            const allowedTypes = [
                'image/png',
                'image/jpeg',
                'image/webp'
            ];


            if (!allowedTypes.includes(file.type)) {

                alert(
                    'Invalid banner file. Please select a PNG, JPG, JPEG or WEBP image.'
                );

                companyBannerUpload.value = '';
                companyBannerUploadInfo.value = '';

                return;

            }


            const image = new Image();

            image.onload = function () {

                if (
                    image.width !== 1400 ||
                    image.height !== 370
                ) {

                    alert(
                        'Invalid banner dimensions. Please select an image exactly 1400px X 370px.'
                    );

                    companyBannerUpload.value = '';
                    companyBannerUploadInfo.value = <?= json_encode($default_company_banner) ?>;

                    return;

                }


                companyBannerUploadInfo.value = file.name;

            };


            image.onerror = function () {

                alert(
                    'Unable to read the selected banner image.'
                );

                companyBannerUpload.value = '';
                companyBannerUploadInfo.value = '';

            };


            image.src = URL.createObjectURL(file);

        });

    }


    /* =====================================================
       COMPANY FORM VALIDATION
    ===================================================== */

    const companyForm =
        document.getElementById('companyDetailsForm');


    if (companyForm) {

        companyForm.addEventListener('submit', function (event) {

            if (!companyForm.checkValidity()) {

                event.preventDefault();

                companyForm.reportValidity();

                return;

            }


            /* PHONE */

            const phone =
                document.getElementById('company_phone');

            const phone2 =
                document.getElementById('company_phone2');

            const phonePattern =
                /^\+?[0-9]{7,15}$/;


            if (
                phone &&
                !phonePattern.test(phone.value.trim())
            ) {

                event.preventDefault();

                phone.setCustomValidity(
                    'Enter a valid phone number containing 7-15 digits.'
                );

                phone.reportValidity();

                return;

            } else if (phone) {

                phone.setCustomValidity('');

            }


            if (
                phone2 &&
                phone2.value.trim() !== '' &&
                !phonePattern.test(phone2.value.trim())
            ) {

                event.preventDefault();

                phone2.setCustomValidity(
                    'Enter a valid alternative phone number containing 7-15 digits.'
                );

                phone2.reportValidity();

                return;

            } else if (phone2) {

                phone2.setCustomValidity('');

            }


            /* USER ID */

            const userId =
                document.getElementById('company_userid');


            if (userId) {

                const userIdValue =
                    Number(userId.value);


                if (
                    !Number.isInteger(userIdValue) ||
                    userIdValue < 0 ||
                    userIdValue > 2147483647
                ) {

                    event.preventDefault();

                    userId.setCustomValidity(
                        'User ID must be a whole number between 0 and 2147483647.'
                    );

                    userId.reportValidity();

                    return;

                } else {

                    userId.setCustomValidity('');

                }

            }


            /* LOG FILE PATH */

            const logFile =
                document.getElementById('company_logfile_url');


            if (logFile) {

                const logValue =
                    logFile.value.trim();

                const validPath =
                    /^[A-Za-z]:[\\/].+|^[/\\\\].+|^[A-Za-z0-9_.-]+([/\\\\][A-Za-z0-9_. -]+)*$/;


                if (!validPath.test(logValue)) {

                    event.preventDefault();

                    logFile.setCustomValidity(
                        'Enter a valid local or Windows filesystem path.'
                    );

                    logFile.reportValidity();

                    return;

                } else {

                    logFile.setCustomValidity('');

                }

            }


            /* COMPANY URL */

            const companyUrl =
                document.getElementById('company_url');


            if (companyUrl) {

                const urlPattern =
                    /^https?:\/\/.+/i;


                if (!urlPattern.test(companyUrl.value.trim())) {

                    event.preventDefault();

                    companyUrl.setCustomValidity(
                        'Company URL must begin with http:// or https://.'
                    );

                    companyUrl.reportValidity();

                    return;

                } else {

                    companyUrl.setCustomValidity('');

                }

            }


            /* COPYRIGHT LINK */

            const copyrightLink =
                document.getElementById('company_copyrightlink');


            if (
                copyrightLink &&
                copyrightLink.value.trim() !== ''
            ) {

                const urlPattern =
                    /^https?:\/\/.+/i;


                if (!urlPattern.test(copyrightLink.value.trim())) {

                    event.preventDefault();

                    copyrightLink.setCustomValidity(
                        'Copyright link must begin with http:// or https://.'
                    );

                    copyrightLink.reportValidity();

                    return;

                } else {

                    copyrightLink.setCustomValidity('');

                }

            }


            /* BOOLEAN FIELDS */

            const booleanFields = [
                'company_signup',
                'company_acct_approval',
                'company_auto_ticketing',
                'company_online'
            ];


            for (const fieldId of booleanFields) {

                const field =
                    document.getElementById(fieldId);


                if (field) {

                    if (
                        field.value !== '0' &&
                        field.value !== '1'
                    ) {

                        event.preventDefault();

                        alert(
                            'Invalid value detected in ' +
                            fieldId +
                            '.'
                        );

                        field.focus();

                        return;

                    }

                }

            }

        });

    }


    /* =====================================================
       MAILER FORM VALIDATION
    ===================================================== */

    const mailerForm =
        document.getElementById('mailerSettingsForm');


    if (mailerForm) {

        mailerForm.addEventListener('submit', function (event) {

            if (!mailerForm.checkValidity()) {

                event.preventDefault();

                mailerForm.reportValidity();

                return;

            }


            /* MAILER PORT */

            const mailerPort =
                document.getElementById('company_mailer_port');


            if (mailerPort) {

                const port =
                    Number(mailerPort.value);


                if (
                    !Number.isInteger(port) ||
                    port < 1 ||
                    port > 65535
                ) {

                    event.preventDefault();

                    mailerPort.setCustomValidity(
                        'Mailer port must be a whole number between 1 and 65535.'
                    );

                    mailerPort.reportValidity();

                    return;

                } else {

                    mailerPort.setCustomValidity('');

                }

            }


            /* MAILER SECURITY */

            const mailerSecure =
                document.getElementById('company_mailer_secure');


            if (mailerSecure) {

                if (
                    mailerSecure.value !== 'tls' &&
                    mailerSecure.value !== 'ssl'
                ) {

                    event.preventDefault();

                    mailerSecure.setCustomValidity(
                        'Select either TLS or SSL.'
                    );

                    mailerSecure.reportValidity();

                    return;

                } else {

                    mailerSecure.setCustomValidity('');

                }

            }

        });

    }


    /* =====================================================
       CLEAR CUSTOM VALIDATION MESSAGES
    ===================================================== */

    const validationFields =
        document.querySelectorAll(
            'input, textarea, select'
        );


    validationFields.forEach(function (field) {

        field.addEventListener('input', function () {

            this.setCustomValidity('');

        });


        field.addEventListener('change', function () {

            this.setCustomValidity('');

        });

    });

});

</script>