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
                    } elseif (preg_match('/^[a-fA-F0-9]{6}/', $hex)) {
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
                        --status-color:  <?= htmlspecialchars($status_text,   ENT_QUOTES, 'UTF-8') ?>;
                        --status-bg:     <?= htmlspecialchars($status_bg,     ENT_QUOTES, 'UTF-8') ?>;
                        --status-border: <?= htmlspecialchars($status_border, ENT_QUOTES, 'UTF-8') ?>;
                     ">
                    <span>
                        <?= htmlspecialchars($status_name, ENT_QUOTES, 'UTF-8') ?>
                    </span>
                    <strong>
                        <?= $status_total ?>
                    </strong>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="summary-actions">
            <button class="btn-delete-selected" id="deleteSelectedBtn" type="button" disabled>
                <i class="bi bi-trash3"></i> Delete Selected
            </button>
            <button class="btn-view-all" id="viewAllBtn" type="button">
                <i class="bi bi-list-ul"></i> All tickets (<?=  number_format($TotalNoTickets) ?>)
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
                    <th class="owner-cell">Owner <i class="bi bi-arrow-down-up sort-icon"></i></th>
                    <th class="incident-date-cell">Incident Date <i class="bi bi-arrow-down-up sort-icon"></i></th>
                    <th class="source-cell">Incident Source <i class="bi bi-arrow-down-up sort-icon"></i></th>
                    <th class="state-cell">State <i class="bi bi-arrow-down-up sort-icon"></i></th>
                    <th class="zone-cell">Zone <i class="bi bi-arrow-down-up sort-icon"></i></th>
                    <th class="corridor-cell">Corridor <i class="bi bi-arrow-down-up sort-icon"></i></th>
                    <th class="priority-cell">Priority <i class="bi bi-arrow-down-up sort-icon"></i></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="checkbox-cell"><input type="checkbox" class="ticket-checkbox" aria-label="Select ticket 22783"></td>
                    <td class="id-cell center-cell"><a href="#">22783</a></td>
                    <td><a href="#">7P5-R7H-D920</a></td>
                    <td>2026-08-13<br>12:48:53</td>
                    <td>2026-08-13<br>12:48:53</td>
                    <td>ILLEGAL CONNECTION</td>
                    <td>Oando</td>
                    <td><a href="#">Illegal Connection</a></td>
                    <td class="status-new">New</td>
                    <td>Unassigned</td>
                    <td>August 9, 2026</td>
                    <td>OANDO</td>
                    <td>Rivers</td>
                    <td>OANDO Zone B - Area 8</td>
                    <td>Central</td>
                    <td><span class="priority-label"><span class="priority-indicator"></span>Critical</span></td>
                </tr>
               
            </tbody>
        </table>
    </div>