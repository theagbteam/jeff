<style>
    .ticket-form-wrapper {
        max-width: 1100px;
        margin: 24px auto 32px;
        font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
        color: var(--body-text);
        font-size: 13px;
    }

    .ticket-form-wrapper * { box-sizing: border-box; }

    /* ============================================================
       HEADER
       ============================================================ */
    .ticket-form-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        background: linear-gradient(135deg, #1e2b42 0%, #3b6fd4 100%);
        border: 1px solid var(--surface-border);
        border-bottom: none;
        border-radius: 16px 16px 0 0;
        color: #ffffff;
    }

    .ticket-form-header h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .ticket-form-header .header-meta {
        font-size: 12px;
        opacity: 0.85;
    }

    .ticket-form-header .header-meta .req { color: #fca5a5; }

    /* ============================================================
       FORM CONTAINER
       ============================================================ */
    .ticket-form {
        background: var(--surface-bg);
        border: 1px solid var(--surface-border);
        border-top: none;
        border-radius: 0 0 16px 16px;
        padding: 0;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .form-section {
        padding: 22px 24px;
        border-bottom: 1px solid var(--surface-border);
    }

    .form-section:last-of-type { border-bottom: none; }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        color: var(--link-color);
        margin: 0 0 18px 0;
        padding-bottom: 10px;
        border-bottom: 1px solid var(--surface-border);
    }

    .section-title .section-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        background: #3b6fd4;
        color: #ffffff;
        border-radius: 50%;
        font-size: 11px;
        font-weight: 700;
    }

    /* ============================================================
       GRID
       ============================================================ */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px 20px;
    }

    .form-grid.cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    .form-grid.cols-1 { grid-template-columns: 1fr; }

    .form-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
    }

    .form-field.span-2 { grid-column: span 2; }
    .form-field.span-3 { grid-column: span 3; }

    .form-field label {
        font-size: 12px;
        font-weight: 600;
        color: var(--body-text);
    }

    .form-field .required {
        color: #d9535e;
        margin-left: 2px;
    }

    .form-field .hint {
        font-size: 11px;
        color: var(--secondary-text);
    }

    /* ============================================================
       INPUTS / SELECTS / TEXTAREAS
       ============================================================ */
    .form-field input[type="text"],
    .form-field input[type="email"],
    .form-field input[type="number"],
    .form-field input[type="date"],
    .form-field select,
    .form-field textarea {
        width: 100%;
        padding: 9px 12px;
        font-size: 13px;
        color: var(--body-text);
        background: var(--surface-soft);
        border: 1px solid var(--surface-border);
        border-radius: 10px;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
        font-family: inherit;
    }

    /* ============================================================
       SELECT — remove ALL custom dropdown arrows
       ============================================================ */
    .form-field select {
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: none;
        background-repeat: no-repeat;
        background-position: right 12px center;
        background-size: 0;
        padding-right: 12px;
        cursor: pointer;
    }

    .form-field select::-ms-expand {
        display: none;
    }

    .form-field input::placeholder,
    .form-field textarea::placeholder {
        color: var(--secondary-text);
        opacity: .7;
    }

    .form-field input[readonly] {
        background: var(--table-head-bg);
        color: var(--secondary-text);
        cursor: not-allowed;
    }

    .form-field input:focus,
    .form-field select:focus,
    .form-field textarea:focus {
        outline: none;
        border-color: #3b6fd4;
        box-shadow: 0 0 0 3px rgba(59, 111, 212, .12);
        background: var(--surface-bg);
    }

    .form-field textarea {
        resize: vertical;
        min-height: 110px;
    }

    /* ============================================================
       VALIDATION STATES (HTML5 pattern / required)
       ============================================================ */
    .form-field input:invalid,
    .form-field select:invalid,
    .form-field textarea:invalid {
        border-color: #d9535e;
        background: rgba(217, 83, 94, .05);
    }

    .form-field input:invalid:focus,
    .form-field select:invalid:focus,
    .form-field textarea:invalid:focus {
        box-shadow: 0 0 0 3px rgba(217, 83, 94, .15);
    }

    /* Only show invalid styling after the user has interacted */
    .form-field input:not(:placeholder-shown):invalid,
    .form-field textarea:not(:placeholder-shown):invalid {
        border-color: #d9535e;
    }

    /* ============================================================
       DATE INPUT (native picker) tweaks
       ============================================================ */
    .form-field input[type="date"] {
        cursor: pointer;
    }

    .form-field input[type="date"]::-webkit-calendar-picker-indicator {
        cursor: pointer;
        opacity: .6;
    }

    .form-field input[type="date"]::-webkit-calendar-picker-indicator:hover {
        opacity: 1;
    }

    :root[data-theme="dark"] .form-field input[type="date"]::-webkit-calendar-picker-indicator {
        filter: invert(1);
    }

    /* ============================================================
       PRIORITY SEGMENTED CONTROL
       ============================================================ */
    .priority-group {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

    .priority-option { position: relative; }

    .priority-option input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .priority-option label {
        display: inline-block;
        padding: 8px 16px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid var(--surface-border);
        border-radius: 10px;
        cursor: pointer;
        background: var(--surface-soft);
        color: var(--body-text);
        transition: all .15s ease;
        user-select: none;
    }

    .priority-option label:hover { background: var(--table-hover-bg); }

    .priority-option input:checked + label {
        color: #ffffff;
        border-color: transparent;
    }

    .priority-option input[value="3"]:checked + label { background: #16a34a; }
    .priority-option input[value="2"]:checked + label { background: #ca8a04; }
    .priority-option input[value="1"]:checked + label { background: #ea580c; }
    .priority-option input[value="0"]:checked + label { background: #dc2626; }

    /* ============================================================
       RADIO CHIPS (pipeline type)
       ============================================================ */
    .radio-list {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .radio-chip { position: relative; }

    .radio-chip input {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .radio-chip label {
        display: inline-block;
        padding: 7px 14px;
        font-size: 12px;
        border: 1px solid var(--surface-border);
        border-radius: 10px;
        cursor: pointer;
        background: var(--surface-soft);
        color: var(--body-text);
        transition: all .15s ease;
        user-select: none;
    }

    .radio-chip label:hover { background: var(--table-hover-bg); }

    .radio-chip input:checked + label {
        background: rgba(59, 111, 212, .12);
        border-color: #3b6fd4;
        color: var(--link-color);
        font-weight: 600;
    }

    /* ============================================================
       ATTACHMENTS
       ============================================================ */
    .attachment-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 12px;
    }

    .attachment-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 12px;
        background: var(--surface-soft);
        border: 1px dashed var(--surface-border);
        border-radius: 10px;
        font-size: 12px;
        color: var(--secondary-text);
        transition: border-color .15s ease, background .15s ease;
    }

    .attachment-item:hover {
        border-color: #3b6fd4;
        background: var(--table-hover-bg);
    }

    .attachment-item input[type="file"] {
        flex: 1;
        min-width: 0;
        font-size: 12px;
        color: var(--body-text);
    }

    .attachment-item input[type="file"]::file-selector-button {
        background: var(--surface-bg);
        color: var(--body-text);
        border: 1px solid var(--surface-border);
        border-radius: 8px;
        padding: 5px 10px;
        font-size: 11px;
        font-weight: 600;
        margin-right: 8px;
        cursor: pointer;
        transition: background .15s ease, border-color .15s ease;
    }

    .attachment-item input[type="file"]::file-selector-button:hover {
        background: var(--table-hover-bg);
        border-color: #3b6fd4;
    }

    .attachment-item .att-num {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 22px;
        height: 22px;
        background: var(--table-head-bg);
        border: 1px solid var(--surface-border);
        border-radius: 50%;
        font-size: 11px;
        font-weight: 700;
        color: var(--secondary-text);
        flex-shrink: 0;
    }

    /* ============================================================
       OPTIONS LIST
       ============================================================ */
    .options-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .option-check {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 12px;
        color: var(--body-text);
        cursor: pointer;
        user-select: none;
    }

    .option-check input[type="checkbox"] {
        width: 16px;
        height: 16px;
        accent-color: #3b6fd4;
        cursor: pointer;
    }

    /* ============================================================
       FOOTER
       ============================================================ */
    .form-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        padding: 18px 24px;
        background: var(--surface-soft);
        border-top: 1px solid var(--surface-border);
        border-radius: 0 0 16px 16px;
        flex-wrap: wrap;
    }

    .form-footer .footer-note {
        font-size: 12px;
        color: var(--secondary-text);
    }

    .btn-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 24px;
        font-size: 13px;
        font-weight: 600;
        color: #ffffff;
        background: #3b6fd4;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background .15s ease, transform .05s ease;
    }

    .btn-submit:hover { background: #2f5cb8; }
    .btn-submit:active { transform: translateY(1px); }

    /* ============================================================
       FILE LIMITS LINK
       ============================================================ */
    .file-limits-link {
        display: inline-block;
        margin-top: 10px;
        font-size: 12px;
        color: var(--link-color);
        text-decoration: none;
        font-weight: 600;
        background: none;
        border: none;
        padding: 0;
        cursor: pointer;
        font-family: inherit;
    }

    .file-limits-link:hover { text-decoration: underline; }

    /* ============================================================
       FILE LIMITS MODAL
       ============================================================ */
    .file-limits-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .55);
        backdrop-filter: blur(2px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9999;
        padding: 20px;
    }

    .file-limits-overlay.open { display: flex; }

    .file-limits-modal {
        background: var(--surface-bg);
        color: var(--body-text);
        width: 100%;
        max-width: 520px;
        border: 1px solid var(--surface-border);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(15, 23, 42, .28);
        overflow: hidden;
        animation: flm-pop .18s ease-out;
    }

    @keyframes flm-pop {
        from { opacity: 0; transform: translateY(8px) scale(.98); }
        to   { opacity: 1; transform: translateY(0)   scale(1); }
    }

    .file-limits-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: linear-gradient(135deg, #1e2b42 0%, #3b6fd4 100%);
        color: #ffffff;
    }

    .file-limits-modal-header h3 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }

    .file-limits-modal-close {
        background: transparent;
        border: none;
        color: #ffffff;
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
        opacity: .85;
        padding: 0 4px;
    }

    .file-limits-modal-close:hover { opacity: 1; }

    .file-limits-modal-body {
        padding: 20px 22px;
        font-size: 13px;
    }

    .file-limits-list {
        list-style: none;
        margin: 0 0 16px 0;
        padding: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .file-limits-list li {
        display: flex;
        align-items: flex-start;
        gap: 8px;
        color: var(--body-text);
    }

    .file-limits-list li::before {
        content: "»";
        color: #3b6fd4;
        font-weight: 700;
        flex-shrink: 0;
    }

    .file-limits-ext-label {
        display: block;
        margin-bottom: 8px;
        font-size: 12px;
        font-weight: 600;
        color: var(--secondary-text);
    }

    .file-limits-exts {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
        padding: 12px;
        background: var(--surface-soft);
        border: 1px solid var(--surface-border);
        border-radius: 10px;
    }

    .file-limits-exts .ext {
        display: inline-block;
        padding: 3px 8px;
        font-size: 11px;
        font-weight: 600;
        background: var(--surface-bg);
        color: var(--link-color);
        border: 1px solid var(--surface-border);
        border-radius: 6px;
    }

    .file-limits-modal-footer {
        display: flex;
        justify-content: flex-end;
        padding: 14px 20px;
        background: var(--surface-soft);
        border-top: 1px solid var(--surface-border);
    }

    .file-limits-modal-footer .btn-close-modal {
        padding: 8px 18px;
        font-size: 12px;
        font-weight: 600;
        color: #ffffff;
        background: #3b6fd4;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background .15s ease;
    }

    .file-limits-modal-footer .btn-close-modal:hover { background: #2f5cb8; }

    /* ============================================================
       CALENDAR FIELD
       ============================================================ */
    .calendar-field {
        position: relative;
        display: flex;
        align-items: center;
    }

    .calendar-field input { padding-left: 40px; }

    .calendar-field .cal-icon {
        position: absolute;
        left: 12px;
        width: 16px;
        height: 16px;
        color: var(--secondary-text);
        pointer-events: none;
    }

    /* ============================================================
       SELECTIZE OVERRIDES (match theme) — no custom arrow
       ============================================================ */
    .selectize-control.single .selectize-input {
        background: var(--surface-soft) !important;
        border: 1px solid var(--surface-border) !important;
        border-radius: 10px !important;
        color: var(--body-text) !important;
        font-size: 13px !important;
        padding: 9px 12px !important;
        box-shadow: none !important;
        min-height: 40px !important;
        line-height: 1.4 !important;
    }

    .selectize-control.single .selectize-input.focus {
        border-color: #3b6fd4 !important;
        box-shadow: 0 0 0 3px rgba(59, 111, 212, .12) !important;
        background: var(--surface-bg) !important;
    }

    .selectize-control.single .selectize-input > input {
        color: var(--body-text) !important;
    }

    /* Hide selectize’s built-in dropdown arrow (the “inverted pyramid”) */
    .selectize-control.single .selectize-input::after {
        display: none !important;
        content: none !important;
        border: none !important;
    }

    .selectize-dropdown {
        background: var(--surface-bg) !important;
        border: 1px solid var(--surface-border) !important;
        border-radius: 10px !important;
        color: var(--body-text) !important;
        font-size: 13px !important;
        box-shadow: 0 8px 30px rgba(15, 23, 42, .12) !important;
        margin-top: 4px !important;
    }

    .selectize-dropdown .option {
        padding: 8px 12px !important;
        color: var(--body-text) !important;
    }

    .selectize-dropdown .option.active {
        background: var(--table-hover-bg) !important;
        color: var(--link-color) !important;
    }

    .selectize-dropdown .option.selected {
        background: rgba(59, 111, 212, .10) !important;
        color: var(--link-color) !important;
        font-weight: 600;
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 991.98px) {
        .ticket-form-wrapper { margin: 16px 12px 24px; }
        .form-grid.cols-3 { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .form-field.span-3 { grid-column: span 2; }
    }

    @media (max-width: 767.98px) {
        .form-grid,
        .form-grid.cols-3,
        .attachment-grid {
            grid-template-columns: 1fr;
        }
        .form-field.span-2,
        .form-field.span-3 { grid-column: span 1; }

        .ticket-form-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 6px;
        }

        .form-section { padding: 18px 16px; }
        .form-footer { padding: 16px; }
        .btn-submit { width: 100%; justify-content: center; }
    }
     .priority-option {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 2px 4px;
    border-radius: 10px;
    cursor: pointer;
    transition: background-color 0.2s ease;
    /* KEY: nothing inside should have its own background */
}

/* Remove any default backgrounds from children */
.priority-option input[type="radio"],
.priority-option label {
    background: transparent !important;
    margin: 0;
    border: none;
}

/* Make text readable on colored backgrounds */
.priority-option label {
    cursor: pointer;
    font-weight: 500;
    color: #fff;   /* change to #000 if some of your colors are light */
}
.priority-option,
.priority-option * {
    background-color: inherit;
}
.priority-option { 
    background-color: transparent; 
}

</style>


<div class="ticket-form-wrapper">

    <!-- ===== HEADER ===== -->
    <div class="ticket-form-header">
        <h2>Create New Ticket</h2>
        <span class="header-meta">All fields marked <span class="req">*</span> are required</span>
    </div>

    <form method="post" class="ticket-form" action="index.php?action=create_ticket"
          name="form1" enctype="multipart/form-data">

        <!-- ===== SECTION 1: TICKET INFO ===== -->
        <div class="form-section">
            <h3 class="section-title"><span class="section-num">1</span> Ticket Information</h3>

            <div class="form-grid cols-3">
                <div class="form-field">
                    <label for="category">Category <span class="required">*</span></label>
                    <select name="category" id="category" required>
                        <option value="<?=  $Tk_RowSearchValue ?>"><?=  $Tk_RowSearchValue  ?></option>

                       <?php
                    $ticket_category_serial = 1;
                    foreach ($LoadTicketcategories as $LoadTicketcategory):
                    ?>
     <option value="<?= htmlspecialchars($LoadTicketcategory['name'] ?? '') ?>"><?= htmlspecialchars($LoadTicketcategory['name'] ?? '') ?></option>
                       <?php
                        $ticket_category_serial++;
                    endforeach;
                    ?>
                    </select>
                </div>

                <div class="form-field">
                    <label>Tracking ID</label>
                    <input type="text" name="ticket_id" value="<?= $ticket_id ?>" readonly>
                </div>

                <div class="form-field">
                    <label>Priority <span class="required">*</span></label>

      <div class="priority-group">
    <?php $first = true; ?>
    <?php foreach ($LoadPriorityColumnForSelect as $priority_options): ?>
        <div class="priority-option" data-color="<?= $priority_options['color'] ?>" style="background-color: <?= $first ? $priority_options['color'] : 'transparent' ?>;">
            <input  type="radio" name="priority" id="pri_<?= $priority_options['sn'] ?>"
                   value="<?= $priority_options['name'] ?? 'Undefined' ?>"
                   <?= $first ? 'checked' : '' ?> required>
            <label for="pri_<?= $priority_options['sn'] ?>"  style="<?php if ($template_mode != 'dark'){echo 'color:black' ;} ?>">
                <?= $priority_options['name'] ?>
            </label>
        </div>
        <?php $first = false; ?>
    <?php endforeach; ?>
</div>










                </div>

               <div class="form-field">
    <label>Submitted</label>
    <input type="text" name="date_created" value="<?= date('Y-m-d H:i:s') ?>" readonly>
</div>

                <div class="form-field">
                    <label>Updated</label>
                    <input type="text" name="date_updated" value="Nil" readonly>
                </div>

                <div class="form-field">
                    <label>Incident Date <span class="required">*</span></label>
                    <div class="calendar-field">
                        <svg class="cal-icon" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                        <input name="incidence_date" value="" type="date" required
                               max="<?= date('Y-m-d') ?>">
                    </div>
                </div>
            </div>
        </div>

        <!-- ===== SECTION 2: REPORTER DETAILS ===== -->
        <div class="form-section">
            <h3 class="section-title"><span class="section-num">2</span> Reporter Details</h3>

            <div class="form-grid">
                <div class="form-field">
                    <label for="create_name">Name <span class="required"></span></label>
                    <input type="text" id="create_name" name="name" maxlength="50" value="<?= $fullname ?>" placeholder="Full name" readonly>
                </div>

                <div class="form-field">
                    <label for="email">Email <span class="required"></span></label>
                    <input type="email" id="email" name="email" maxlength="50"
                           placeholder="name@company.com" value="<?= $user_email ?>"
                           readonly>
                    <div id="email_suggestions"></div>
                </div>

                <div class="form-field">
                    <label>Phone No</label>
                    <input type="text" name="phone_no" value="<?= $user_phone ?>" maxlength="255"
                           placeholder="+234 ..." readonly
                           pattern="[0-9+\-\s()]{7,20}">
                </div>

                <div class="form-field">
                    <label for="incidence_source">Incident Source <span class="required">*</span></label>
                    <select name="incidence_source" id="incidence_source" required>
                        <option value="">— Select source —</option>
                        <?php foreach ($LoadIncidenceSourceColumnForSelect as $Incidence_options): ?>
                        <option value="<?= $Incidence_options['name'] ?>"><?= $Incidence_options['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div>

        <!-- ===== SECTION 3: LOCATION ===== -->
        <div class="form-section">
            <h3 class="section-title"><span class="section-num">3</span> Location &amp; Asset</h3>

            <div class="form-grid cols-3">
                   <div class="form-field">
        <label for="state_of_origin">State <span class="required">*</span></label>
        <select name="state" id="state_of_origin" required>
            <option value="">— Select state —</option>
            <?php foreach ($LoadAllNigeriaStates as $states): ?>
                <option value="<?= htmlspecialchars($states['id']) ?>">
                    <?= htmlspecialchars($states['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div class="error-message">Please select state of origin</div>
    </div>

                    <div class="form-field">
        <label for="lga">Local Government Area <span class="required">*</span></label>
        <select name="local_government" id="lga" disabled required>
            <option value="">— Select LGA —</option>
        </select>
        <div class="error-message">Please select LGA</div>
    </div>


                <div class="form-field">
                    <label>Community</label>
                    <input required type="text" name="community" maxlength="50" placeholder="Community name"
                           pattern="[A-Za-z0-9\s\-',.]{2,50}">
                </div>

               

                <div class="form-field">
                    <label for="operator">Operator <span class="required">*</span></label>
                    <select name="operator" id="operator" required>
                        <option value="">— Select operator —</option>
                            <?php foreach ($LoadOperatorColumnForSelect as $Operator_options): ?>
                        <option value="<?= $Operator_options['name'] ?>"><?= $Operator_options['name'] ?></option>
                          <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-field">
                    <label for="zone">Zone <span class="required">*</span></label>
                    <select name="zone" id="zone" required>
                        <option value="">— Select zone —</option>
                          <?php foreach ($LoadZoneColumnForSelect as $Zone_options): ?>
                        <option value="<?= $Zone_options['name'] ?>"><?= $Zone_options['name'] ?></option>
                          <?php endforeach; ?>
                       
                       
                    </select>
                </div>

                <!-- ===== CORRIDOR: text field, read-only ===== -->
                <div class="form-field">
                    <label for="corridor">Corridor <span class="required"></span></label>
                    <input type="text" value="<?= $user_corridor ?>" name="corridor" id="corridor" maxlength="255" placeholder="Enter corridor" readonly>
                </div>

               

               <div class="form-field span-3">
    <label>Pipeline Type <span class="required">*</span></label>
    <div class="radio-list">

        <div class="radio-chip">
            <input type="radio" id="pt_select_none" name="pipeline_type " value="Select" checked >
            <label for="pt_select_none">Select</label>
        </div>

        <?php foreach ($LoadPipelineTypeColumnForSelect as $index => $Ptype_options): ?>
            <div class="radio-chip">
                <input type="radio" required
                       id="pt_select_<?= $index ?>"
                       name="pipeline_type"
                       value="<?= htmlspecialchars($Ptype_options['name']) ?>">
                <label for="pt_select_<?= $index ?>"><?= htmlspecialchars($Ptype_options['name']) ?></label>
            </div>
        <?php endforeach ?>

    </div>
</div>
 <div class="form-field">
                    <label for="custom19">Pipeline <span class="required">*</span></label>
                    <select name="pipeline" id="custom19" required>
                        <option value="">— Select pipeline —</option>
                         <?php foreach ($LoadPipelineColumnForSelect as $Pipeline_options): ?>
                        <option value="<?= $Pipeline_options['name'] ?>"><?= $Pipeline_options['name'] ?></option>
                          <?php endforeach; ?>
                       
                    </select>
                </div>
                <!-- <div class="form-field">
                    <label for="custom46"> Status <span class="required">*</span></label>
                    <select name="custom46" id="custom46">
                        <option value="">— Select status —</option>
                        <option>Active</option><option>Inactive</option>
                        <option>Unknown</option><option>N/A</option>
                    </select>
                </div> -->

                <div class="form-field">
                    <label>Latitude <span class="required">*</span></label>
                    <input type="text" name="location_coordinate_latitude" maxlength="255" value="0"
                           placeholder="e.g. 4.8156" required
                           pattern="^-?\d{1,3}(\.\d{1,8})?$"
                           title="Enter a valid latitude (e.g. 4.8156)">
                </div>

                <div class="form-field">
                    <label>Longitude <span class="required">*</span></label>
                    <input type="text" name="location_coordinate_longitude" maxlength="255" value="0"
                           placeholder="e.g. 7.0498" required
                           pattern="^-?\d{1,3}(\.\d{1,8})?$"
                           title="Enter a valid longitude (e.g. 7.0498)">
                </div>
            </div>
        </div>

        <!-- ===== SECTION 4: INCIDENT DETAILS ===== -->
        <div class="form-section">
            <h3 class="section-title"><span class="section-num">4</span> Incident Details</h3>

            <div class="form-grid cols-3">
                <div class="form-field">
                    <label>Arrested Suspects <span class="required">*</span></label>
                    <input type="number" name="number_of_arrested_suspects" maxlength="255" value="0"
                           min="0" step="1" required
                           title="Enter a whole number (0 or more)">
                </div>
                <div class="form-field">
                    <label>Vehicles Arrested/Destroyed <span class="required">*</span></label>
                    <input type="number" name="vehicle_arrested_destroyed" maxlength="255" value="0"
                           min="0" step="1" required>
                </div>
                <div class="form-field">
                    <label>Boats Arrested/Destroyed</label>
                    <input type="number" name="wooden_boat_speed_boat_arrested_destroyed" maxlength="255" value="0"
                           min="0" step="1">
                </div>
                <div class="form-field">
                    <label>Vessels Arrested/Destroyed</label>
                    <input type="number" name="vessel_arrested_destroyed" maxlength="255" value="0"
                           min="0" step="1">
                </div>
                <div class="form-field">
                    <label>Crude Recovered/Destroyed (Ltr) <span class="required">*</span></label>
                    <input type="number" name="quantity_of_crude_recovered_destroyed_ltr" maxlength="255" value="0"
                           min="0" step="0.01" required>
                </div>
                <div class="form-field">
                    <label>AGO Recovered/Destroyed (Ltr) <span class="required">*</span></label>
                    <input type="number" name="quantity_of_ago_recovered_destroyed_ltr" maxlength="255" value="0"
                           min="0" step="0.01" required>
                </div>
                <div class="form-field">
                    <label>PMS Recovered/Destroyed (Ltr) <span class="required">*</span></label>
                    <input type="number" name="quantity_of_pms_recovered_destroyed_ltr" maxlength="255" value="0"
                           min="0" step="0.01" required>
                </div>
                <div class="form-field">
                    <label>DPK Recovered/Destroyed (Ltr) <span class="required">*</span></label>
                    <input type="number" name="dpk_recovered_destroyed_ltr " maxlength="255" value="0"
                           min="0" step="0.01" required>
                </div>
                <div class="form-field">
                    <label>Illegal Storage/Dump Sites <span class="required">*</span></label>
                    <input type="number" name="illegal_storage_dump_sites" maxlength="255" value="0"
                           min="0" step="1" required>
                </div>
            </div>
        </div>

        <!-- ===== SECTION 5: SUBJECT & MESSAGE ===== -->
        <div class="form-section">
            <h3 class="section-title"><span class="section-num">5</span> Subject &amp; Message</h3>

            <div class="form-grid cols-1">
                <div class="form-field">
                    <label for="subject">Subject <span class="required">*</span></label>
                    <input type="text" id="subject" name="subject" maxlength="70"
                           value="Illegal Connection" placeholder="Brief subject" required
                           pattern=".{3,70}"
                           title="Subject must be between 3 and 70 characters">
                </div>

                <div class="form-field">
                    <label for="message">Message <span class="required">*</span></label>
                    <textarea id="message" name="message" rows="6"
                              placeholder="Describe the incident..." required
                              minlength="10"
                              title="Please provide at least 10 characters"></textarea>
                </div>

                <div class="form-field">
                    <label>Description of the Spill Location</label>
                    <textarea name="description_of_reported_incidence" rows="4"
                              placeholder="Additional details about the spill location..."
                              minlength="5"></textarea>
                </div>
            </div>
        </div>

        <!-- ===== SECTION 6: ATTACHMENTS ===== -->
        <div class="form-section">
            <h3 class="section-title"><span class="section-num">6</span> Attachments</h3>

            <div class="attachment-grid">
                <div class="attachment-item">
                    <span class="att-num">1</span>
                    <input type="file" name="attachment[1]">
                </div>
                <div class="attachment-item">
                    <span class="att-num">2</span>
                    <input type="file" name="attachment[2]">
                </div>
                <div class="attachment-item">
                    <span class="att-num">3</span>
                    <input type="file" name="attachment[3]">
                </div>
                <div class="attachment-item">
                    <span class="att-num">4</span>
                    <input type="file" name="attachment[4]">
                </div>
                <div class="attachment-item">
                    <span class="att-num">5</span>
                    <input type="file" name="attachment[5]">
                </div>
                <div class="attachment-item">
                    <span class="att-num">6</span>
                    <input type="file" name="attachment[6]">
                </div>
                <div class="attachment-item">
                    <span class="att-num">7</span>
                    <input type="file" name="attachment[7]">
                </div>
                <div class="attachment-item">
                    <span class="att-num">8</span>
                    <input type="file" name="attachment[8]">
                </div>
            </div>

            <button type="button" class="file-limits-link" id="openFileLimits">
                View file upload limits
            </button>
        </div>

        <!-- ===== SECTION 7: OPTIONS & DUE DATE ===== -->
        <div class="form-section">
            <h3 class="section-title"><span class="section-num">7</span> Options</h3>

            <div class="form-grid">
                <div class="form-field">
                    <label>Notification</label>
                    <div class="options-list">
                        <label class="option-check">
                            <input type="checkbox" name="notify" value="1" checked>
                            Send email notification to the customer
                        </label>
                        <label class="option-check">
                            <input type="checkbox" name="show" value="1" checked>
                            Show the ticket after submission
                        </label>
                    </div>
                </div>

                <div class="form-field">
                    <label>Due Date</label>
                    <div class="calendar-field">
                        <svg class="cal-icon" viewBox="0 0 16 16" fill="currentColor">
                            <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z"/>
                        </svg>
                        <input name="due_date" value="" type="date"
                               min="<?= date('Y-m-d') ?>">
                    </div>
                </div>
            </div>
        </div>
     <input type="hidden" name="CreateNewTicket">
        <!-- ===== FOOTER ===== -->
        <div class="form-footer">
            <span class="footer-note">Please review all details before submitting.</span>
            <input type="hidden" name="token" value="b39045cb91a74fbf58ed3b593e77a8abf419e841">
            <button type="submit" name="create_ticket" class="btn-submit">
                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                    <path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11z"/>
                </svg>
                Submit Ticket
            </button>
        </div>

    </form>
</div>

<!-- ============================================================
     FILE LIMITS MODAL
     ============================================================ -->
<div class="file-limits-overlay" id="fileLimitsOverlay" role="dialog" aria-modal="true" aria-labelledby="fileLimitsTitle">
    <div class="file-limits-modal">
        <div class="file-limits-modal-header">
            <h3 id="fileLimitsTitle">File upload limits</h3>
            <button type="button" class="file-limits-modal-close" id="fileLimitsClose" aria-label="Close">×</button>
        </div>

        <div class="file-limits-modal-body">
            <ul class="file-limits-list">
                <li><span><strong>Maximum number of attachments:</strong> 8</span></li>
                <li><span><strong>Maximum size per attachment:</strong> 992097152 B</span></li>
            </ul>

            <span class="file-limits-ext-label">You may upload files ending with:</span>
            <div class="file-limits-exts">
                <span class="ext">.gif</span>
                <span class="ext">.jpg</span>
                <span class="ext">.png</span>
                <span class="ext">.zip</span>
                <span class="ext">.rar</span>
                <span class="ext">.csv</span>
                <span class="ext">.doc</span>
                <span class="ext">.docx</span>
                <span class="ext">.xls</span>
                <span class="ext">.xlsx</span>
                <span class="ext">.txt</span>
                <span class="ext">.pdf</span>
                <span class="ext">.jpeg</span>
                <span class="ext">.mp4</span>
            </div>
        </div>

        <div class="file-limits-modal-footer">
            <button type="button" class="btn-close-modal" id="fileLimitsCloseBtn">Close</button>
        </div>
    </div>
</div>

<script>
    // Initialize selectize on the custom selects
    // NOTE: #corridor (Corridor) removed — it is now a text input
    (function () {
        var ids = ['#category', '#incidence_source', '#custom11', '#operator', '#zone', '#custom19', '#custom46'];
        if (typeof jQuery !== 'undefined' && jQuery.fn.selectize) {
            ids.forEach(function (id) {
                if (jQuery(id).length) jQuery(id).selectize();
            });
        }
    })();

    // ===== File upload limits modal =====
    (function () {
        var overlay   = document.getElementById('fileLimitsOverlay');
        var openBtn   = document.getElementById('openFileLimits');
        var closeX    = document.getElementById('fileLimitsClose');
        var closeBtn  = document.getElementById('fileLimitsCloseBtn');

        function openModal()  { overlay.classList.add('open');    document.body.style.overflow = 'hidden'; }
        function closeModal() { overlay.classList.remove('open'); document.body.style.overflow = ''; }

        openBtn.addEventListener('click', openModal);
        closeX.addEventListener('click', closeModal);
        closeBtn.addEventListener('click', closeModal);

        // Close when clicking the dark backdrop (but not the modal itself)
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeModal();
        });

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal();
        });
    })();
</script>
<script>
    document.querySelectorAll('.priority-option').forEach(option => {
    option.addEventListener('click', function() {
        // Reset all options to transparent
        document.querySelectorAll('.priority-option').forEach(opt => {
            opt.style.backgroundColor = 'transparent';
        });
        
        // Apply the clicked option's color
        this.style.backgroundColor = this.dataset.color;
        
        // Check the radio input inside this option
        this.querySelector('input[type="radio"]').checked = true;
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const stateSelect = document.getElementById('state_of_origin');
    const lgaSelect   = document.getElementById('lga');

    stateSelect.addEventListener('change', function () {
        const stateId = this.value;

        // Reset LGA dropdown
        lgaSelect.innerHTML = '<option value="">— Loading... —</option>';
        lgaSelect.disabled = true;

        if (!stateId) {
            lgaSelect.innerHTML = '<option value="">— Select LGA —</option>';
            return;
        }

        fetch('index.php?action=get_lgas&state_id=' + encodeURIComponent(stateId))
            .then(res => res.json())
            .then(result => {
                lgaSelect.innerHTML = '<option value="">— Select LGA —</option>';

                if (result.success && result.data.length > 0) {
                    result.data.forEach(lga => {
                        const opt = document.createElement('option');
                        opt.value = lga.id;
                        opt.textContent = lga.name;
                        lgaSelect.appendChild(opt);
                    });
                    lgaSelect.disabled = false;
                } else {
                    lgaSelect.innerHTML = '<option value="">No LGAs found</option>';
                }
            })
            .catch(err => {
                console.error(err);
                lgaSelect.innerHTML = '<option value="">Error loading LGAs</option>';
            });
    });
});
</script>