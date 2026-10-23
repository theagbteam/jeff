<!-- <pre><?php
echo '<strong>Wellhead Status Counts Debug:</strong>';
echo "\n";
var_dump($wellhead_status_counts);
?></pre> -->
<section class="summary-section">
    <div class="summary-counters">
        <?php foreach ($wellhead_status_counts as $status_count): ?>
            <?php
                $status_name  = (string)($status_count['name'] ?? '');
                $status_total = (int)($status_count['total'] ?? 0);
                $status_color = trim((string)($status_count['color'] ?? ''));

                if ($status_color === '') {
                    $status_color = '#3b6fd4';
                }

                $r = 59; $g = 111; $b = 212;

                $hex = ltrim($status_color, '#');
                if (preg_match('/^[a-fA-F0-9]{3}$/', $hex)) {
                    $r = hexdec(str_repeat($hex[0], 2));
                    $g = hexdec(str_repeat($hex[1], 2));
                    $b = hexdec(str_repeat($hex[2], 2));
                } elseif (preg_match('/^[a-fA-F0-9]{6}$/', $hex)) {
                    $r = hexdec(substr($hex, 0, 2));
                    $g = hexdec(substr($hex, 2, 2));
                    $b = hexdec(substr($hex, 4, 2));
                } elseif (preg_match('/rgba?\(\s*(\d+)\s*,\s*(\d+)\s*,\s*(\d+)/', $status_color, $m)) {
                    $r = (int)$m[1]; $g = (int)$m[2]; $b = (int)$m[3];
                }

                $status_text   = "rgb($r, $g, $b)";
                $status_bg     = "rgba($r, $g, $b, 0.10)";
                $status_border = "rgba($r, $g, $b, 0.35)";
            ?>
            <div class="summary-counter wellhead-status"
                 style="
                    --status-color:  <?= htmlspecialchars($status_text, ENT_QUOTES, 'UTF-8') ?>;
                    --status-bg:     <?= htmlspecialchars($status_bg, ENT_QUOTES, 'UTF-8') ?>;
                    --status-border: <?= htmlspecialchars($status_border, ENT_QUOTES, 'UTF-8') ?>;
                 ">
                <span>
                    <?= htmlspecialchars($status_name, ENT_QUOTES, 'UTF-8') ?>
                </span>
                <strong>
                    <?= number_format($status_total) ?>
                </strong>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="summary-actions">
        <button class="btn-delete-selected" id="deleteSelectedBtn" type="button" disabled>
            <i class="bi bi-trash3"></i> Delete Selected
        </button>
        <button class="btn-view-all" id="viewAllBtn" type="button">
            <i class="bi bi-list-ul"></i> All tickets (<?= number_format($TotalNoTickets) ?>)
        </button>
        <label class="auto-reload">
            <input type="checkbox" id="autoReload">
            <span>Auto reload page</span>
        </label>
    </div>
</section>

<div class="table-container">
    <table class="ticket-table" id="ticketsTable">
        <thead>
            <tr>
                <th class="checkbox-cell"><input type="checkbox" id="selectAll" aria-label="Select all tickets"></th>
                <th class="id-cell">SN <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="tracking-cell">Tracking ID <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="date-cell">Submitted <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="date-cell">Updated <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="category-cell">Category <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="name-cell">Name <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="owner-cell">Owner <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="subject-cell">Subject <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="status-cell">Status <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="incident-date-cell">Incident Date <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="source-cell">Incident Source <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="state-cell">State <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="zone-cell">Zone <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="corridor-cell">Corridor <i class="bi bi-arrow-down-up sort-icon"></i></th>
                <th class="priority-cell">Priority <i class="bi bi-arrow-down-up sort-icon"></i></th>
            </tr>
        </thead>

        <tbody>
            <?php
            $sn = 1;

            foreach ($LoadAllTickets as $ticket_history):
                if ((int)($ticket_history['status'] ?? -1) < 0) {
                    continue;
                }

                if (trim((string)($ticket_history['narration'] ?? '')) !== '') {
                    continue;
                }
            ?>
                <tr>
                    <td class="checkbox-cell">
                        <input
                            type="checkbox"
                            class="ticket-checkbox"
                            value="<?= htmlspecialchars($ticket_history['ticket_id'] ?? $ticket_history['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                            aria-label="Select ticket <?= htmlspecialchars($ticket_history['ticket_id'] ?? $ticket_history['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        >
                    </td>

                    <td class="id-cell center-cell">
                        <a href="#"><?= $sn++ ?></a>
                    </td>

                    <td>
                        <a href="index.php?action=viewticket&viewtoken=<?= urlencode(base64_encode($ticket_history['ticket_id'])); ?>"><?= htmlspecialchars($ticket_history['ticket_id'] ?? '', ENT_QUOTES, 'UTF-8') ?></a>
                    </td>

                    <td>
                        <?= htmlspecialchars(date('Y-m-d', strtotime($ticket_history['date_created'] ?? '')), ENT_QUOTES, 'UTF-8') ?><br>
                        <?= htmlspecialchars(date('H:i:s', strtotime($ticket_history['date_created'] ?? '')), ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <td>
                        <?php
                        $dateUpdated = trim((string)($ticket_history['date_updated'] ?? ''));
                        $isValidDate = ($dateUpdated !== '' && $dateUpdated !== 'Nil' && strtotime($dateUpdated) !== false);

                        if ($isValidDate):
                            $ts = strtotime($dateUpdated);
                        ?>
                            <?= htmlspecialchars(date('Y-m-d', $ts), ENT_QUOTES, 'UTF-8') ?><br>
                            <?= htmlspecialchars(date('H:i:s', $ts), ENT_QUOTES, 'UTF-8') ?>
                        <?php else: ?>
                            <?= htmlspecialchars($dateUpdated !== '' ? $dateUpdated : 'Nil', ENT_QUOTES, 'UTF-8') ?>
                        <?php endif; ?>
                    </td>

                    <td><?= htmlspecialchars($ticket_history['category'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>

                    <td><?= htmlspecialchars($ticket_history['operator'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>

                    <td>
                        <?php
                        $ownerName = trim((string)($ticket_history['owner'] ?? ''));
                        $ownerDisplay = $ownerName !== '' ? $ownerName : 'Unassigned';
                        $ownerTicketId = (string)($ticket_history['ticket_id'] ?? $ticket_history['id'] ?? '');
                        $ownerCorridor = trim((string)($ticket_history['corridor'] ?? ''));
                        ?>
                        <button type="button"
                                class="owner-popup-trigger"
                                data-ticket-id="<?= htmlspecialchars($ownerTicketId, ENT_QUOTES, 'UTF-8') ?>"
                                data-owner="<?= htmlspecialchars($ownerName, ENT_QUOTES, 'UTF-8') ?>"
                                data-corridor="<?= htmlspecialchars($ownerCorridor, ENT_QUOTES, 'UTF-8') ?>">
                            <?= htmlspecialchars($ownerDisplay, ENT_QUOTES, 'UTF-8') ?>
                        </button>
                    </td>

                    <td>
                  <a href="index.php?action=viewticket&viewtoken=<?= urlencode(base64_encode($ticket_history['ticket_id'])); ?>"><?= htmlspecialchars($ticket_history['subject'] ?? '', ENT_QUOTES, 'UTF-8') ?></a> </td>

                    <td class="status-new">
                        <?php
                        $statusTextRaw = trim((string)($ticket_history['status_text'] ?? 'New'));
                        $statusKey     = strtolower($statusTextRaw);

                        // Map status text to a color
                        switch ($statusKey) {
                            case 'new':
                            case 'open':
                                $statusColor = '#0d6efd'; // blue
                                break;
                            case 'in progress':
                            case 'in-progress':
                            case 'inprogress':
                            case 'ongoing':
                                $statusColor = '#fd7e14'; // orange
                                break;
                            case 'pending':
                            case 'on hold':
                            case 'on-hold':
                            case 'onhold':
                                $statusColor = '#ffc107'; // amber/yellow
                                break;
                            case 'resolved':
                            case 'closed':
                            case 'completed':
                            case 'done':
                                $statusColor = '#198754'; // green
                                break;
                            case 'rejected':
                            case 'cancelled':
                            case 'canceled':
                            case 'declined':
                                $statusColor = '#dc3545'; // red
                                break;
                            default:
                                $statusColor = '#6c757d'; // grey for unknown/empty
                                break;
                        }
                        ?>
                        <span class="status-label" style="color: <?= htmlspecialchars($statusColor, ENT_QUOTES, 'UTF-8') ?>;">
                            <span class="status-indicator" style="background-color: <?= htmlspecialchars($statusColor, ENT_QUOTES, 'UTF-8') ?>;"></span>
                            <?= htmlspecialchars($statusTextRaw, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </td>

                    <td>
                        <?= htmlspecialchars(
                            !empty($ticket_history['incidence_date'])
                                ? date('F j, Y', strtotime($ticket_history['incidence_date']))
                                : '',
                            ENT_QUOTES,
                            'UTF-8'
                        ) ?>
                    </td>

                    <td>
                        <?= htmlspecialchars(strtoupper($ticket_history['operator'] ?? ''), ENT_QUOTES, 'UTF-8') ?>
                    </td>

                    <?php
                    $NameOfState = "";

                    foreach ($LoadAllNigeriaStates as $state) {
                        if ((int)$state['id'] === (int)$ticket_history['state']) {
                            $NameOfState = ucfirst($state['name']);
                            break;
                        }
                    }
                    ?>

                    <td><?= htmlspecialchars(ucwords($NameOfState ?? ''), ENT_QUOTES, 'UTF-8') ?></td>

                    <td><?= htmlspecialchars($ticket_history['zone'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>

                    <td><?= htmlspecialchars($ticket_history['corridor'] ?? '', ENT_QUOTES, 'UTF-8') ?></td>

                    <td>
                        <?php
                        $priorityRaw  = trim((string)($ticket_history['priority'] ?? ''));
                        $priorityKey  = strtolower($priorityRaw);

                        // Map priority type to a color
                        switch ($priorityKey) {
                            case 'critical':
                            case 'urgent':
                            case 'p1':
                                $priorityColor = '#dc3545'; // red
                                break;
                            case 'high':
                            case 'p2':
                                $priorityColor = '#fd7e14'; // orange
                                break;
                            case 'medium':
                            case 'normal':
                            case 'p3':
                                $priorityColor = '#ffc107'; // amber/yellow
                                break;
                            case 'low':
                            case 'p4':
                                $priorityColor = '#198754'; // green
                                break;
                            default:
                                $priorityColor = '#6c757d'; // grey for unknown/empty
                                break;
                        }
                        ?>
                        <span class="priority-label" style="color: <?= htmlspecialchars($priorityColor, ENT_QUOTES, 'UTF-8') ?>;">
                            <span class="priority-indicator" style="background-color: <?= htmlspecialchars($priorityColor, ENT_QUOTES, 'UTF-8') ?>;"></span>
                            <?= htmlspecialchars($priorityRaw, ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<!-- Delete confirmation modal -->
<div class="aciss-modal-overlay" id="deleteConfirmOverlay" aria-hidden="true">
    <div class="aciss-modal" role="dialog" aria-modal="true" aria-labelledby="deleteConfirmTitle">
        <div class="aciss-modal-icon">
            <i class="bi bi-exclamation-triangle-fill"></i>
        </div>
        <h3 class="aciss-modal-title" id="deleteConfirmTitle" hidden></h3>
        <p class="aciss-modal-text" id="deleteConfirmText">
            You are about to delete 1 selected ticket(s). This action cannot be undone.
        </p>
        <div class="aciss-modal-actions">
            <button type="button" class="aciss-btn aciss-btn-cancel" id="deleteCancelBtn">Cancel</button>
            <button type="button" class="aciss-btn aciss-btn-danger" id="deleteConfirmBtn">Yes, delete</button>
        </div>
    </div>
</div>

<!-- Assign owner modal -->
<div class="aciss-modal-overlay" id="assignOwnerOverlay" aria-hidden="true">
    <div class="aciss-modal" role="dialog" aria-modal="true" aria-labelledby="assignOwnerTitle">
        <h3 class="aciss-modal-title" id="assignOwnerTitle">Assign Owner</h3>
        <form method="POST" action="index.php?action=assignowner" id="assignOwnerForm">
            <!-- Hidden field for ticket ID (populated via JS) -->
            <input type="hidden" name="ticket_id" id="assignOwnerTicketIdInput" value="">
            <input type="hidden" name="assign_owner" value="1">
            <div class="aciss-form-group">
                <label for="assignOwnerSelect" class="aciss-form-label">Select Owner</label>
                <select name="owner" id="assignOwnerSelect" class="aciss-form-select" required>
                    <option value="">-- Select Owner --</option>
                    <?php foreach ($LoadAllUsersAndLoginTableForAdmin['supervisor'] as $asignuser): ?>
                        <?php
                            $optUserId   = (string)($asignuser['user_userid'] ?? '');
                            $optCorridor  = (string)($asignuser['user_corridor'] ?? '');
                            if ($optCorridor !="") {$optCorridor = " (". $optCorridor . " corridor)";}
                            $optFullname = (string)($asignuser['user_fullname'] ?? '');
                            $optRole     = (string)($asignuser['login_role'] ?? '');
                            $AssignableUsers = ucfirst($optFullname) .  $optCorridor   ." - " . $optUserId ;

                        ?>
                        <option value="<?= $optUserId ?>">
                            <?= htmlspecialchars($AssignableUsers, ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="aciss-modal-actions">
                <button type="button" class="aciss-btn aciss-btn-cancel" id="assignOwnerCancelBtn">Cancel</button>
                <button type="submit" class="aciss-btn aciss-btn-primary">Assign</button>
            </div>
        </form>
    </div>
</div>

<style>
.aciss-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(15, 23, 42, 0.55);
    backdrop-filter: blur(3px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    opacity: 0;
    pointer-events: none;
    transition: opacity 0.2s ease;
}
.aciss-modal-overlay.is-open {
    opacity: 1;
    pointer-events: auto;
}
.aciss-modal {
    background: #ffffff;
    border-radius: 14px;
    padding: 28px 26px 22px;
    width: 100%;
    max-width: 380px;
    text-align: center;
    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.25);
    transform: translateY(12px) scale(0.97);
    transition: transform 0.22s ease;
    font-family: inherit;
}
.aciss-modal-overlay.is-open .aciss-modal {
    transform: translateY(0) scale(1);
}
.aciss-modal-icon {
    width: 58px;
    height: 58px;
    border-radius: 50%;
    background: rgba(220, 53, 69, 0.12);
    color: #dc3545;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    margin: 0 auto 16px;
}
.aciss-modal-title {
    margin: 0 0 8px;
    font-size: 18px;
    font-weight: 700;
    color: #111827;
}
.aciss-modal-text {
    margin: 0 0 22px;
    font-size: 14px;
    line-height: 1.5;
    color: #6b7280;
}
.aciss-modal-actions {
    display: flex;
    gap: 10px;
}
.aciss-btn {
    flex: 1;
    border: none;
    border-radius: 9px;
    padding: 11px 16px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.15s ease, transform 0.05s ease;
    font-family: inherit;
}
.aciss-btn:active { transform: scale(0.98); }
.aciss-btn-cancel {
    background: #f1f5f9;
    color: #334155;
}
.aciss-btn-cancel:hover { background: #e2e8f0; }
.aciss-btn-danger {
    background: #dc3545;
    color: #ffffff;
}
.aciss-btn-danger:hover { background: #bb2d3b; }
.aciss-btn-primary {
    background: #3b6fd4;
    color: #ffffff;
}
.aciss-btn-primary:hover { background: #2f5bb0; }

/* Owner popup trigger */
.owner-popup-trigger {
    background: none;
    border: none;
    padding: 0;
    margin: 0;
    color: #3b6fd4;
    font: inherit;
    cursor: pointer;
    text-decoration: underline;
    text-decoration-style: dotted;
}
.owner-popup-trigger:hover {
    color: #2f5bb0;
}

/* Assign owner form */
.aciss-form-group {
    text-align: left;
    margin-bottom: 22px;
}
.aciss-form-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 8px;
}
.aciss-form-select {
    width: 100%;
    padding: 10px 12px;
    font-size: 14px;
    font-family: inherit;
    border: 1px solid #d1d5db;
    border-radius: 9px;
    background: #ffffff;
    color: #111827;
    outline: none;
    transition: border-color 0.15s ease, box-shadow 0.15s ease;
}
.aciss-form-select:focus {
    border-color: #3b6fd4;
    box-shadow: 0 0 0 3px rgba(59, 111, 212, 0.15);
}
</style>

<script>
(function () {
    const deleteBtn   = document.getElementById('deleteSelectedBtn');
    const selectAll   = document.getElementById('selectAll');
    const overlay     = document.getElementById('deleteConfirmOverlay');
    const confirmBtn  = document.getElementById('deleteConfirmBtn');
    const cancelBtn   = document.getElementById('deleteCancelBtn');
    const confirmText = document.getElementById('deleteConfirmText');

    const checkboxes = () => Array.from(document.querySelectorAll('.ticket-checkbox'));

    // Returns the unique ticket IDs currently checked
    function getSelectedIds() {
        const ids = checkboxes()
            .filter(cb => cb.checked)
            .map(cb => cb.value);

        return [...new Set(ids)];
    }

    function refreshDeleteBtn() {
        if (!deleteBtn) return;
        deleteBtn.disabled = getSelectedIds().length === 0;
    }

    function openModal(count) {
        confirmText.textContent = 'You are about to delete ' + count + ' selected ticket(s). This action cannot be undone.';
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        confirmBtn.focus();
    }

    function closeModal() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
    }

    if (selectAll) {
        selectAll.addEventListener('change', function () {
            checkboxes().forEach(cb => { cb.checked = selectAll.checked; });
            refreshDeleteBtn();
        });
    }

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('ticket-checkbox')) {
            const all = checkboxes();
            if (selectAll) {
                selectAll.checked = all.length > 0 && all.every(cb => cb.checked);
            }
            refreshDeleteBtn();
        }
    });

    if (deleteBtn) {
        deleteBtn.addEventListener('click', function () {
            const selected = getSelectedIds();
            if (selected.length === 0) return;
            openModal(selected.length);
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', closeModal);
    }

    if (overlay) {
        overlay.addEventListener('click', function (e) {
            if (e.target === overlay) closeModal();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('is-open')) {
            closeModal();
        }
    });

    if (confirmBtn) {
        confirmBtn.addEventListener('click', function () {
            const selected = getSelectedIds();

            if (selected.length === 0) {
                closeModal();
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'index.php?action=tickets';

            const actionInput = document.createElement('input');
            actionInput.type = 'hidden';
            actionInput.name = 'delete_selected_tickets';
            actionInput.value = '1';
            form.appendChild(actionInput);

            selected.forEach(function (ticketId) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'ticket_ids[]';
                input.value = ticketId;
                form.appendChild(input);
            });

            document.body.appendChild(form);
            form.submit();
        });
    }

    refreshDeleteBtn();
})();

/* ---------- Assign Owner Popup ---------- */
(function () {
    const ownerOverlay      = document.getElementById('assignOwnerOverlay');
    const ownerForm         = document.getElementById('assignOwnerForm');
    const ownerTicketIdInput = document.getElementById('assignOwnerTicketIdInput'); // hidden ticket id input
    const ownerSelect       = document.getElementById('assignOwnerSelect');
    const ownerCancelBtn    = document.getElementById('assignOwnerCancelBtn');
    const ownerTitle        = document.getElementById('assignOwnerTitle');

    function openOwnerModal(ticketId, currentOwner, corridor) {
        if (!ownerOverlay) return;

        // Set hidden ticket id field
        if (ownerTicketIdInput) {
            ownerTicketIdInput.value = ticketId || '';
        }

        // Update modal title to show ticket number and corridor name
        if (ownerTitle) {
            const corridorLabel = (corridor || '').trim() || 'No Corridor';
            ownerTitle.textContent = 'Ticket ' + (ticketId || '') + ' of ' + corridorLabel + ' corridor';
        }

        // The form action remains the same, but the hidden field carries the ticket_id.
        ownerForm.action = 'index.php?action=assignowner';

        // Pre-select current owner if it matches an option value or label
        if (ownerSelect) {
            ownerSelect.value = '';
            const current = (currentOwner || '').trim();
            if (current !== '') {
                for (const opt of ownerSelect.options) {
                    if (opt.value === current || opt.textContent.trim() === current) {
                        ownerSelect.value = opt.value;
                        break;
                    }
                }
            }
        }

        ownerOverlay.classList.add('is-open');
        ownerOverlay.setAttribute('aria-hidden', 'false');
        if (ownerSelect) ownerSelect.focus();
    }

    function closeOwnerModal() {
        if (!ownerOverlay) return;
        ownerOverlay.classList.remove('is-open');
        ownerOverlay.setAttribute('aria-hidden', 'true');
    }

    document.addEventListener('click', function (e) {
        const trigger = e.target.closest('.owner-popup-trigger');
        if (!trigger) return;

        e.preventDefault();
        openOwnerModal(trigger.dataset.ticketId, trigger.dataset.owner, trigger.dataset.corridor);
    });

    if (ownerCancelBtn) {
        ownerCancelBtn.addEventListener('click', closeOwnerModal);
    }

    if (ownerOverlay) {
        ownerOverlay.addEventListener('click', function (e) {
            if (e.target === ownerOverlay) closeOwnerModal();
        });
    }

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && ownerOverlay && ownerOverlay.classList.contains('is-open')) {
            closeOwnerModal();
        }
    });
})();
</script>