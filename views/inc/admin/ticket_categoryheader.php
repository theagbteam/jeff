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
            ?>
                <tr>
                    <td class="checkbox-cell">
                        <input
                            type="checkbox"
                            class="ticket-checkbox"
                            aria-label="Select ticket <?= htmlspecialchars($ticket_history['ticket_id'] ?? $ticket_history['id'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                        >
                    </td>

                    <td class="id-cell center-cell">
                        <a href="#"><?= $sn++ ?></a>
                    </td>

                    <td>
                        <a href="#"><?= htmlspecialchars($ticket_history['ticket_id'] ?? '', ENT_QUOTES, 'UTF-8') ?></a>
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
                        <a href="#"><?= htmlspecialchars($ticket_history['subject'] ?? '', ENT_QUOTES, 'UTF-8') ?></a>
                    </td>

                    <td class="status-new">
                        <?= htmlspecialchars($ticket_history['status_text'] ?? 'New', ENT_QUOTES, 'UTF-8') ?>
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
                        <span class="priority-label">
                            <span class="priority-indicator"></span>
                            <?= htmlspecialchars($ticket_history['priority'] ?? '', ENT_QUOTES, 'UTF-8') ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>