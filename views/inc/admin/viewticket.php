<?php
/**
 * Expects (from controller):
 *   $ViewTicketListing        — array (single row or [0 => row])
 *   $LoadAllReplies           — replies for THIS ticket (already filtered by controller)
 *   $LoadAllTicketCategories  — optional status list (wellhead_status)
 *   $company_name             — optional
 *   $token                    — optional
 */
$t = $ViewTicketListing ?? [];
if (is_array($t) && isset($t[0]) && is_array($t[0])) $t = $t[0];
elseif (is_object($t))                                $t = (array) $t;
if (!is_array($t))                                    $t = [];

$val = function ($k, $d = '') use ($t) {
    return isset($t[$k]) && $t[$k] !== null && $t[$k] !== '' ? $t[$k] : $d;
};

$company_name = $company_name ?? 'NNPCL COMMAND AND CONTROL CENTER';
$token        = $val('token', $token ?? '');

$ticketId      = $val('ticket_id', '—');
$statusText    = $val('status_text', 'New');
$category      = $val('category', '—');
$priority      = $val('priority', '—');
$priorityColor = $val('priority_color', '');
$color         = $val('color', '');
$owner         = trim((string) $val('owner', ''));
$owner_userid  = trim((string) $val('owner_userid', ''));
$pipeline      = $val('pipeline', '');
$pipelineType  = $val('pipeline_type', '');
$rawSubject    = trim((string) $val('subject', ''));
$message       = $val('message', '');
$description   = $val('description_of_reported_incidence', '');
$name          = $val('name', '—');
$email         = $val('email', '');
$phone         = $val('phone_no', '—');
$incDate       = $val('incidence_date', '—');
$incSource     = $val('incidence_source', '—');
$state         = $val('state', '');
$community     = $val('community', '');
$lga           = $val('local_government', '');
$operator      = $val('operator', '');
$zone          = $val('zone', '');
$corridor      = $val('corridor', '—');

$suspects      = $val('number_of_arrested_suspects', '0');
$vehicle       = $val('vehicle_arrested_destroyed', '0');
$boat          = $val('wooden_boat_speed_boat_arrested_destroyed', '0');
$vessel        = $val('vessel_arrested_destroyed', '0');
$lat           = $val('location_coordinate_latitude', '0');
$lng           = $val('location_coordinate_longitude', '0');
$crude         = $val('quantity_of_crude_recovered_destroyed_ltr', '0');
$ago           = $val('quantity_of_ago_recovered_destroyed_ltr', '0');
$pms           = $val('quantity_of_pms_recovered_destroyed_ltr', '0');
$dpk           = $val('dpk_recovered_destroyed_ltr', '0');
$dumpSites     = $val('illegal_storage_dump_sites', '0');

$dateCreated   = $val('date_created', '');
$dateUpdated   = $val('date_updated', '');
$dueDate       = $val('due_date', '');
$rawNote       = $val('note', '');
$createdIso    = $dateCreated ? date('c', strtotime($dateCreated)) : '';

/* ------------------------------------------------------------------
 * Parse the stored "note" column into structured entries.
 *
 * The model stores each note as:
 *   [YYYY-MM-DD HH:MM:SS] Note by Name (Role) - ID:
 *   <body text>
 *
 * Multiple notes are separated by "\n\n---\n\n".
 * ------------------------------------------------------------------ */
$noteEntries = [];
if (trim((string) $rawNote) !== '') {
    $chunks = preg_split('/\r?\n\s*---\s*\r?\n/', (string) $rawNote);
    foreach ($chunks as $chunk) {
        $chunk = trim($chunk);
        if ($chunk === '') continue;

        $entry = ['time' => '', 'author' => '', 'body' => $chunk];

        // Strip leading [timestamp]
        if (preg_match('/^\[([^\]]+)\]\s*(.*)$/s', $chunk, $m)) {
            $entry['time'] = trim($m[1]);
            $chunk         = trim($m[2]);
        }

        // Strip leading "Note by ... :" line
        if (preg_match('/^Note\s+by\s+(.+?):\s*(.*)$/s', $chunk, $m)) {
            $entry['author'] = trim($m[1]);
            $entry['body']   = trim($m[2]);
        } else {
            $entry['body'] = $chunk;
        }

        $noteEntries[] = $entry;
    }
    // newest first
    usort($noteEntries, function ($a, $b) {
        return strcmp((string)($b['time'] ?? ''), (string)($a['time'] ?? ''));
    });
}
$noteCount = count($noteEntries);

/* Replies — load only rows from ticket_replies whose ticket_id matches
 * the ticket currently being viewed ($ticketId from ticket_reports). */
$LoadAllReplies = isset($LoadAllReplies) && is_array($LoadAllReplies) ? $LoadAllReplies : [];

$currentTicketId = trim((string) $ticketId);
if ($currentTicketId === '—') {
    $currentTicketId = '';
}
/* Fallback: derive from raw viewtoken if the row came back empty */
if ($currentTicketId === '' && !empty($_GET['viewtoken'])) {
    $raw = urldecode((string) $_GET['viewtoken']);
    $decoded = base64_decode($raw);
    if ($decoded !== false && trim($decoded) !== '') {
        $currentTicketId = trim((string) $decoded);
    }
}

$replies = [];
if ($currentTicketId !== '') {
    foreach ($LoadAllReplies as $replyRow) {
        if (!is_array($replyRow)) {
            continue;
        }

        $replyTicketId = isset($replyRow['ticket_id']) ? trim((string) $replyRow['ticket_id']) : '';

        if ($replyTicketId === '') {
            continue;
        }

        if (strcasecmp(trim($replyTicketId), trim($currentTicketId)) === 0) {
            $replies[] = $replyRow;
        }
    }
}

usort($replies, function ($a, $b) {
    $da = (string)($a['date'] ?? '');
    $db = (string)($b['date'] ?? '');
    if ($da === $db) return ((int)($b['sn'] ?? 0)) <=> ((int)($a['sn'] ?? 0));
    return strcmp($db, $da);
});
$repliesCount = count($replies);

$prettyDate = '';
if ($incDate && $incDate !== '—') {
    $ts = strtotime($incDate);
    $prettyDate = $ts ? date('j F Y', $ts) : $incDate;
}

$subjectUsable = false;
if ($rawSubject !== '') {
    $hasSpace = preg_match('/\s/', $rawSubject) === 1;
    $letters  = preg_match_all('/[A-Za-z]/', $rawSubject);
    $vowels   = preg_match_all('/[aeiouAEIOU]/', $rawSubject);
    if ($letters >= 8 && $hasSpace)                     $subjectUsable = true;
    elseif ($letters >= 4 && $hasSpace && $vowels >= 2) $subjectUsable = true;
}

$headingParts = [];
if ($subjectUsable) {
    $headingParts[] = $rawSubject;
    if (stripos($rawSubject, 'AS OF') === false && $prettyDate !== '') {
        $headingParts[] = 'AS OF ' . $prettyDate;
    }
} else {
    $catLabel = ($category && $category !== '—') ? strtoupper($category) : '';
    if ($catLabel !== '') {
        $headingParts[] = $catLabel . ' REPORT';
        if ($prettyDate !== '') $headingParts[] = 'AS OF ' . $prettyDate;
    } else {
        $headingParts[] = 'TICKET ' . $ticketId;
        if ($prettyDate !== '') $headingParts[] = '— ' . $prettyDate;
    }
}
$headline = trim(implode(' ', $headingParts));

$hasRealOwner = $owner !== '' && strcasecmp($owner, 'unassigned') !== 0;
$nonZero = function ($v) { return $v !== '' && $v !== null && (float) $v !== 0.0; };

/* ------------------------------------------------------------------
 * Permission check for showing priority / status selectors.
 * ------------------------------------------------------------------
 * $company_adminseniorman and $_SESSION['userid'] are expected to be
 * available from the controller. We use a safe check so that the view
 * does not break if they are not defined.
 */
$currentUserId = $_SESSION['userid'] ?? null;

$canChangePriority = false;
$canChangeStatus   = false;

if ($currentUserId !== null) {
    // Admin senior man can always change
    if (isset($company_adminseniorman) && (string) $company_adminseniorman === (string) $currentUserId) {
        $canChangePriority = true;
        $canChangeStatus   = true;
    }
    // Ticket owner can change
    if ($owner_userid !== '' && (string) $owner_userid === (string) $currentUserId) {
        $canChangePriority = true;
        $canChangeStatus   = true;
    }
}

/* Default option labels for the selects */
$defaultPriorityLabel = 'Select new priority';
if ($priority !== '' && $priority !== '—') {
    $defaultPriorityLabel = 'Current: ' . ucfirst($priority);
}

$defaultStatusLabel = 'No status change';
if ($statusText !== '' && $statusText !== '—' && strcasecmp($statusText, 'new') !== 0) {
    // We show the current status as the first option (pre-selected) but still
    // allow “No status change”.
    $defaultStatusLabel = 'Keep status: ' . ucfirst($statusText);
}

/* ------------------------------------------------------------------
 * Map status text to a color (mirrors the listing behaviour).
 * ------------------------------------------------------------------ */
$statusColor = '';
$statusKey   = strtolower(trim((string) $statusText));

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

/* ------------------------------------------------------------------
 * Map priority text to a color (mirrors the listing behaviour).
 * ------------------------------------------------------------------ */
$priorityKey   = strtolower(trim((string) $priority));
$priorityColorResolved = '';

switch ($priorityKey) {
    case 'critical':
    case 'urgent':
    case 'p1':
        $priorityColorResolved = '#dc3545'; // red
        break;
    case 'high':
    case 'p2':
        $priorityColorResolved = '#fd7e14'; // orange
        break;
    case 'medium':
    case 'normal':
    case 'p3':
        $priorityColorResolved = '#ffc107'; // amber/yellow
        break;
    case 'low':
    case 'p4':
        $priorityColorResolved = '#198754'; // green
        break;
    default:
        $priorityColorResolved = $priorityColor ?: '#6c757d'; // fall back to provided colour or grey
        break;
}

function getReplyAttachments(array $row): array
{
    if (!isset($row['attachments']) || $row['attachments'] === null || $row['attachments'] === '') return [];
    $raw = $row['attachments'];
    if (is_array($raw)) return array_values(array_filter($raw, fn($v) => is_string($v) && trim($v) !== ''));
    if (is_string($raw)) {
        $trim = trim($raw);
        if ($trim === '') return [];
        if ($trim[0] === '[' || $trim[0] === '{') {
            $decoded = json_decode($trim, true);
            if (is_array($decoded)) {
                $out = [];
                foreach ($decoded as $item) {
                    if (is_string($item) && trim($item) !== '') $out[] = $item;
                    elseif (is_array($item)) {
                        $path = $item['path'] ?? $item['file'] ?? $item['name'] ?? $item['url'] ?? '';
                        if (is_string($path) && trim($path) !== '') $out[] = $path;
                    }
                }
                return array_values($out);
            }
        }
        return array_values(array_filter(preg_split('/\s*[,|;]\s*/', $trim), fn($v) => is_string($v) && trim($v) !== ''));
    }
    return [];
}

/**
 * Build a browser-usable URL for a stored reply attachment.
 *
 * Controller (Pasted text.txt) saves physically to:
 *   __DIR__ . '/../views/uploads/ticket_library/replies/'
 * and stores ONLY the bare filename in ticket_replies.attachments.
 *
 * This view is rendered by index.php (app root), so URLs must resolve
 * from the app root — hence "views/..." with NO leading "../".
 */
function attachmentHref(string $path): string
{
    $p = trim($path);
    if ($p === '') return '';

    // Already absolute / protocol URLs — leave untouched.
    if (preg_match('~^(?:https?:)?//~i', $p)
        || preg_match('~^[a-z][a-z0-9+.-]*:~i', $p)
        || $p[0] === '/') {
        return $p;
    }

    // Bare filename (what the controller stores). Guard against traversal
    // and encode so spaces/unicode survive the URL.
    $file = basename($p);
    if ($file === '' || $file === '.' || $file === '..') return '';

    return 'views/uploads/ticket_library/replies/' . rawurlencode($file);
}

function attachmentLabel(string $path): string
{
    $p = trim($path);
    if ($p === '') return '';
    $p = preg_replace('/[?#].*$/', '', $p);
    $base = basename($p);
    $decoded = rawurldecode($base);
    return $decoded !== '' ? $decoded : $p;
}
?>
<style>
    .main__content.ticket { max-width: 1200px; margin: 0 auto; padding: 18px 24px 28px; display: flex; flex-wrap: wrap; gap: 22px; }
    .ticket__body { flex: 1 1 620px; min-width: 0; }
    .ticket__params { flex: 0 1 340px; min-width: 280px; }
    .ticket__body_block { background: var(--surface-bg); border: 1px solid var(--surface-border); border-radius: 16px; box-shadow: 0 5px 20px rgba(15,23,42,.04); padding: 20px 22px; margin-bottom: 18px; }
    .ticket__body_block h3 { font-size: 18px; font-weight: 800; letter-spacing: .2px; color: var(--body-text); margin: 0 0 12px; line-height: 1.35; }
    .ticket__body_block .block--head { display: flex; flex-wrap: wrap; gap: 10px 20px; align-items: center; justify-content: space-between; padding-bottom: 12px; margin-bottom: 12px; border-bottom: 1px solid var(--surface-border); font-size: 12px; color: var(--secondary-text); }
    .ticket__body_block .block--head .contact { display: flex; flex-wrap: wrap; gap: 6px; align-items: center; }
    .ticket__body_block .block--head time { font-size: 12px; color: var(--secondary-text); }
    .custom-field-title { font-weight: 700; color: var(--secondary-text); font-size: 12px; display: inline-block; min-width: 190px; }
    .ticket__body_block > div { padding: 4px 0; font-size: 13px; }
    .block--description { margin-top: 14px; padding: 14px 16px; background: var(--surface-soft); border: 1px solid var(--surface-border); border-radius: 12px; font-size: 13px; line-height: 1.7; color: var(--body-text); white-space: pre-line; }
    .block--description p { margin: 0; }
    .block--description__label { display: block; font-size: 11px; font-weight: 700; letter-spacing: .5px; text-transform: uppercase; color: var(--secondary-text); margin-bottom: 8px; }
    .block--notes { margin-top: 16px; }
    .group-title { font-weight: 700; font-size: 11px; letter-spacing: .5px; text-transform: uppercase; color: var(--secondary-text); margin: 16px 0 2px; padding-top: 12px; border-top: 1px dashed var(--surface-border); }
    .group-title:first-of-type { margin-top: 8px; padding-top: 0; border-top: 0; }
    .status-chip { display: inline-block; padding: 2px 10px; border-radius: 999px; font-size: 11px; font-weight: 700; letter-spacing: .2px; color: #fff; background: #64748b; }
    .email-pill { display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border: 1px solid var(--surface-border); border-radius: 999px; background: var(--surface-soft); font-size: 12px; font-weight: 600; color: var(--body-text); text-decoration: none; transition: background .2s ease, border-color .2s ease, color .2s ease; }
    .email-pill:hover { background: var(--table-hover-bg); border-color: #3b6fd4; color: #3b6fd4; text-decoration: none; }
    .email-pill .icon { width: 13px; height: 13px; flex-shrink: 0; }
    .btn--blue-border { display: inline-flex; align-items: center; height: 38px; padding: 0 16px; border: 1px solid var(--surface-border); border-radius: 10px; background: var(--surface-soft); color: var(--body-text); font-size: 12px; font-weight: 600; cursor: pointer; transition: background .2s ease, border-color .2s ease, color .2s ease; }
    .btn--blue-border:hover { background: var(--table-hover-bg); border-color: #3b6fd4; color: #3b6fd4; text-decoration: none; }
    :root[data-theme="dark"] .btn--blue-border:hover { border-color: #8bb8ff; color: #8bb8ff; }
    .btn--blue-border:disabled, .btn--blue-border[disabled] { opacity: .5; cursor: not-allowed; pointer-events: none; background: var(--surface-soft); border-color: var(--surface-border); color: var(--secondary-text); }
    .btn-full { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 22px; border: 0; border-radius: 10px; background: #3b6fd4; color: #ffffff; font-size: 12px; font-weight: 600; cursor: pointer; transition: background .2s ease; text-decoration: none; }
    .btn-full:hover { background: #2f5cb8; color: #ffffff; text-decoration: none; }
    .btn-border { display: inline-flex; align-items: center; justify-content: center; min-height: 40px; padding: 0 22px; border: 1px solid var(--surface-border); border-radius: 10px; background: var(--surface-soft); color: var(--body-text); font-size: 12px; font-weight: 600; cursor: pointer; transition: background .2s ease, border-color .2s ease, color .2s ease; text-decoration: none; }
    .btn-border:hover { background: var(--table-hover-bg); border-color: #3b6fd4; color: #3b6fd4; text-decoration: none; }
    .form { width: 100%; }
    .form-control, textarea.form-control, select.form-control { width: 100%; border: 1px solid var(--surface-border); border-radius: 10px; padding: 9px 12px; font-size: 13px; color: var(--body-text); background: var(--surface-soft); transition: border-color .2s ease, box-shadow .2s ease, background .2s ease; }
    .form-control:focus, textarea.form-control:focus, select.form-control:focus { outline: none; border-color: #3b6fd4; box-shadow: 0 0 0 3px rgba(59,111,212,.12); background: var(--surface-bg); }
    textarea#message { width: 100%; min-height: 180px; resize: vertical; border: 1px solid var(--surface-border); border-radius: 12px; padding: 12px 14px; font-size: 13px; line-height: 1.6; color: var(--body-text); background: var(--surface-soft); }
    textarea#message:focus { outline: none; border-color: #3b6fd4; box-shadow: 0 0 0 3px rgba(59,111,212,.12); }
    .block--message { margin: 14px 0; }
    .block--attach { display: flex; align-items: flex-start; gap: 8px; margin-top: 14px; font-size: 12px; color: var(--secondary-text); }
    .block--attach .icon { width: 16px; height: 16px; flex-shrink: 0; margin-top: 2px; }
    input[type="file"] { font-size: 12px; color: var(--secondary-text); margin-bottom: 6px; max-width: 100%; }
    .block--checkboxs { display: flex; flex-direction: column; gap: 10px; margin: 14px 0; padding-top: 14px; border-top: 1px solid var(--surface-border); }
    .checkbox-custom { display: flex; align-items: center; gap: 8px; font-size: 12px; flex-wrap: wrap; }
    .checkbox-custom input[type="checkbox"] { width: 15px; height: 15px; margin: 0; cursor: pointer; accent-color: #3b6fd4; }
    .checkbox-custom label { margin: 0; color: var(--body-text); cursor: pointer; }
    .dropdown-select.priority select { border: 1px solid var(--surface-border); border-radius: 8px; padding: 5px 10px; font-size: 12px; color: var(--body-text); background: var(--surface-soft); }
    .block--submit { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; margin-top: 16px; }
    .submit-us select { border: 1px solid var(--surface-border); border-radius: 10px; padding: 8px 12px; font-size: 12px; font-weight: 600; color: var(--body-text); background: var(--surface-soft); cursor: pointer; }
    .ticket__params .params--bar { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: center; padding: 12px 16px; border: 1px solid var(--surface-border); border-radius: 12px; background: var(--surface-bg); margin-bottom: 14px; font-size: 12px; }
    .ticket__params .params--bar .btn-print { display: inline-flex; align-items: center; justify-content: center; gap: 6px; min-height: 36px; padding: 0 20px; border: 1px solid var(--surface-border); border-radius: 8px; background: var(--surface-soft); color: var(--body-text); font-size: 12px; font-weight: 600; cursor: pointer; text-decoration: none; transition: background .2s ease, border-color .2s ease, color .2s ease; }
    .ticket__params .params--bar .btn-print:hover { background: var(--table-hover-bg); border-color: #3b6fd4; color: #3b6fd4; text-decoration: none; }
    .params--block { border: 1px solid var(--surface-border); border-radius: 14px; background: var(--surface-bg); box-shadow: 0 5px 20px rgba(15,23,42,.04); margin-bottom: 16px; overflow: hidden; }
    .params--block .accordion-title { display: flex; align-items: center; justify-content: space-between; margin: 0; padding: 14px 18px; font-size: 13px; font-weight: 700; color: var(--body-text); background: var(--table-head-bg); border-bottom: 1px solid var(--surface-border); cursor: pointer; user-select: none; }
    .params--block .accordion-title .icon { width: 14px; height: 14px; color: var(--secondary-text); transition: transform .2s ease; }
    .params--block .accordion-body { padding: 14px 18px; }
    .params--block .row { display: flex; align-items: flex-start; justify-content: space-between; gap: 12px; padding: 7px 0; border-bottom: 1px dashed var(--surface-border); font-size: 12px; }
    .params--block .row:last-child { border-bottom: 0; }
    .params--block .row .title { color: var(--secondary-text); font-weight: 600; flex: 0 0 auto; }
    .params--block .row .value { color: var(--body-text); text-align: right; word-break: break-word; }
    .params--block .row .value b { color: var(--body-text); }
    .params--block.params { padding: 8px 16px; box-sizing: border-box; }
    .params--block.params > .row { width: 100%; margin: 0; padding: 12px 0; gap: 12px; align-items: center; box-sizing: border-box; }
    .params--block.params > .row > .title { flex: 0 0 42%; min-width: 0; margin: 0; text-align: left; line-height: 1.5; }
    .params--block.params > .row > .value { flex: 1 1 0; min-width: 0; margin: 0; text-align: right; box-sizing: border-box; }
    .params--block.params > .row:last-child { align-items: center; border-bottom: 0; padding-bottom: 12px; }
    .params--block.params .row .value.value-label { font-weight: 700; color: var(--body-text); }
    .users-online { margin: 0 24px 28px; padding: 10px 16px; border: 1px solid var(--surface-border); border-radius: 12px; background: var(--surface-bg); font-size: 12px; color: var(--secondary-text); display: flex; align-items: center; flex-wrap: wrap; gap: 6px; }
    .users-online .icon { width: 14px; height: 14px; }
    .back-to-top { position: fixed; right: 22px; bottom: 22px; display: inline-flex; align-items: center; justify-content: center; height: 40px; padding: 0 16px; border: 1px solid var(--surface-border); border-radius: 10px; background: var(--surface-bg); color: var(--body-text); font-size: 12px; font-weight: 600; box-shadow: 0 6px 22px rgba(15,23,42,.10); z-index: 800; }
    .back-to-top:hover { background: var(--table-hover-bg); text-decoration: none; }
    @media print {
        .back-to-top, .users-online, .ticket__params .params--bar, .block--notes, .replies-modal-overlay,
        .note-modal-overlay,
        .ticket__body_block:last-child, .block--attach, .block--checkboxs, .block--submit, input[type="file"],
        .file-limits-overlay { display: none !important; }
        .main__content.ticket { display: block; max-width: 100%; padding: 0; }
        .ticket__body, .ticket__params { flex: 1 1 100% !important; max-width: 100% !important; }
        .ticket__body_block, .params--block { box-shadow: none; border: 1px solid #ccc; page-break-inside: avoid; }
        body { background: #fff !important; }
    }
    @media (max-width: 991.98px) {
        .main__content.ticket { padding: 14px 16px 22px; }
        .ticket__params { flex: 1 1 100%; }
        .users-online { margin: 0 12px 18px; }
    }
    @media (max-width: 767.98px) {
        .main__content.ticket { padding: 12px 10px 18px; }
        .custom-field-title { min-width: 130px; }
        .ticket__params .params--bar { padding: 10px 12px; }
        .params--block .accordion-title, .params--block .accordion-body { padding: 12px 14px; }
        .params--block.params { padding: 6px 12px; }
        .params--block.params > .row { gap: 8px; padding: 11px 0; }
        .params--block.params > .row > .title { flex-basis: 42%; }
        .users-online { margin: 0 10px 16px; padding: 8px 12px; }
    }
    @media (max-width: 480px) {
        .block--submit { flex-direction: column; align-items: stretch; }
        .btn-full, .btn-border { width: 100%; }
    }
    @media (prefers-reduced-motion: reduce) {
        *, *::before, *::after { animation-duration: 0.01ms !important; animation-iteration-count: 1 !important; transition-duration: 0.01ms !important; scroll-behavior: auto !important; }
    }
    .replies-modal-overlay { position: fixed; inset: 0; background: rgba(15,23,42,.55); z-index: 9500; display: none; align-items: center; justify-content: center; padding: 20px; }
    .replies-modal-overlay.is-open { display: flex; }
    .replies-modal { background: var(--surface-bg); border: 1px solid var(--surface-border); border-radius: 16px; box-shadow: 0 20px 60px rgba(15,23,42,.28); width: 100%; max-width: 1000px; max-height: 85vh; display: flex; flex-direction: column; overflow: hidden; }
    .replies-modal__head { display: flex; align-items: center; justify-content: space-between; padding: 16px 20px; border-bottom: 1px solid var(--surface-border); background: var(--table-head-bg); }
    .replies-modal__head h3 { margin: 0; font-size: 14px; font-weight: 700; color: var(--body-text); }
    .replies-modal__close { display: inline-flex; align-items: center; justify-content: center; width: 32px; height: 32px; border: 1px solid var(--surface-border); border-radius: 8px; background: var(--surface-soft); color: var(--body-text); font-size: 18px; line-height: 1; cursor: pointer; transition: background .2s ease, color .2s ease; }
    .replies-modal__close:hover { background: var(--table-hover-bg); color: #3b6fd4; }
    .replies-modal__body { padding: 16px 20px 20px; overflow: auto; }
    .replies-table-wrap { width: 100%; overflow-x: auto; }
    table.replies-datatable { width: 100%; border-collapse: collapse; font-size: 12px; color: var(--body-text); }
    table.replies-datatable thead th { background: var(--table-head-bg); color: var(--secondary-text); font-weight: 700; text-align: left; padding: 10px 12px; border-bottom: 1px solid var(--surface-border); white-space: nowrap; }
    table.replies-datatable tbody td { padding: 10px 12px; border-bottom: 1px dashed var(--surface-border); vertical-align: top; }
    table.replies-datatable tbody tr:hover { background: var(--table-hover-bg); }
    table.replies-datatable tbody td.col-sn { width: 40px; text-align: center; color: var(--secondary-text); font-variant-numeric: tabular-nums; }
    table.replies-datatable tbody td.col-comment { max-width: 280px; word-break: break-word; white-space: pre-line; }
    table.replies-datatable tbody td.col-attachments { min-width: 140px; max-width: 220px; }
    .replies-toolbar { display: flex; flex-wrap: wrap; gap: 10px; align-items: center; justify-content: space-between; margin-bottom: 10px; font-size: 12px; }
    .replies-toolbar input[type="search"] { border: 1px solid var(--surface-border); border-radius: 8px; padding: 7px 10px; font-size: 12px; color: var(--body-text); background: var(--surface-soft); min-width: 200px; }
    .replies-toolbar .dt-info { color: var(--secondary-text); }
    .replies-empty { padding: 30px 10px; text-align: center; color: var(--secondary-text); font-size: 13px; }
    .attachment-list { display: flex; flex-direction: column; gap: 4px; }
    .attachment-item { display: inline-flex; align-items: center; gap: 5px; max-width: 100%; font-size: 11px; color: var(--link-color); text-decoration: none; padding: 2px 8px; border: 1px solid var(--surface-border); border-radius: 999px; background: var(--surface-soft); transition: background .2s ease, border-color .2s ease, color .2s ease; }
    .attachment-item:hover { background: var(--table-hover-bg); border-color: #3b6fd4; color: #3b6fd4; text-decoration: none; }
    .attachment-item .icon { width: 12px; height: 12px; flex-shrink: 0; }
    .attachment-item span { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }
    .attachment-none { color: var(--secondary-text); font-size: 11px; }

    /* ============================================================
       NOTES PANEL (presentable)
       ============================================================ */
    .notes-panel {
        margin-top: 18px;
        border: 1px solid var(--surface-border);
        border-radius: 14px;
        background: var(--surface-bg);
        box-shadow: 0 5px 20px rgba(15,23,42,.04);
        overflow: hidden;
    }
    .notes-panel__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 14px 18px;
        background: linear-gradient(135deg, rgba(59,111,212,.10) 0%, rgba(184,134,11,.10) 100%);
        border-bottom: 1px solid var(--surface-border);
    }
    .notes-panel__head h4 {
        margin: 0;
        font-size: 13px;
        font-weight: 800;
        letter-spacing: .3px;
        text-transform: uppercase;
        color: var(--body-text);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .notes-panel__head h4 .icon { width: 16px; height: 16px; color: #b8860b; }
    .notes-panel__count {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 700;
        background: #b8860b;
        color: #fff;
        letter-spacing: .2px;
    }
    .notes-panel__list {
        display: flex;
        flex-direction: column;
        padding: 8px;
        gap: 8px;
        max-height: 460px;
        overflow-y: auto;
    }
    .note-entry {
        border: 1px solid var(--surface-border);
        border-left: 4px solid #b8860b;
        border-radius: 12px;
        background: var(--surface-soft);
        padding: 12px 14px;
        font-size: 13px;
        color: var(--body-text);
        line-height: 1.6;
        transition: background .2s ease, border-color .2s ease;
    }
    .note-entry:hover { background: var(--table-hover-bg); }
    .note-entry__meta {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        gap: 8px;
        margin-bottom: 8px;
        font-size: 11px;
    }
    .note-entry__time {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        color: var(--secondary-text);
        font-weight: 600;
        font-variant-numeric: tabular-nums;
    }
    .note-entry__time .icon { width: 12px; height: 12px; }
    .note-entry__author {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 2px 10px;
        border-radius: 999px;
        background: #b8860b;
        color: #fff;
        font-weight: 700;
        letter-spacing: .2px;
    }
    .note-entry__author .icon { width: 12px; height: 12px; }
    .note-entry__body {
        white-space: pre-line;
        word-break: break-word;
        color: var(--body-text);
    }
    .notes-panel__empty {
        padding: 30px 10px;
        text-align: center;
        color: var(--secondary-text);
        font-size: 13px;
        font-style: italic;
    }

    /* ============================================================
       FILE LIMITS MODAL (self-contained, no hesk_window)
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

    /* Style the trigger link so it looks like a link, not a default anchor */
    .file-limits-trigger {
        color: var(--link-color);
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
    }
    .file-limits-trigger:hover { text-decoration: underline; }

    /* ============================================================
       ADD NOTE MODAL (fancy popup)
       ============================================================ */
    .note-modal-overlay {
        position: fixed;
        inset: 0;
        background: rgba(15, 23, 42, .55);
        backdrop-filter: blur(2px);
        display: none;
        align-items: center;
        justify-content: center;
        z-index: 9700;
        padding: 20px;
    }
    .note-modal-overlay.open { display: flex; }

    .note-modal {
        background: var(--surface-bg);
        color: var(--body-text);
        width: 100%;
        max-width: 560px;
        border: 1px solid var(--surface-border);
        border-radius: 16px;
        box-shadow: 0 20px 60px rgba(15, 23, 42, .28);
        overflow: hidden;
        animation: note-pop .18s ease-out;
    }
    @keyframes note-pop {
        from { opacity: 0; transform: translateY(10px) scale(.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }
    .note-modal__head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: linear-gradient(135deg, #1e2b42 0%, #3b6fd4 100%);
        color: #fff;
    }
    .note-modal__head h3 {
        margin: 0;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .3px;
        display: inline-flex;
        align-items: center;
    }
    .note-modal__close {
        background: transparent;
        border: none;
        color: #fff;
        font-size: 22px;
        line-height: 1;
        cursor: pointer;
        opacity: .85;
        padding: 0 4px;
    }
    .note-modal__close:hover { opacity: 1; }

    .note-modal__body { padding: 20px 22px; }

    .note-modal__hint {
        font-size: 12px;
        color: var(--secondary-text);
        background: var(--surface-soft);
        border: 1px solid var(--surface-border);
        border-radius: 10px;
        padding: 10px 12px;
        margin: 0 0 16px;
        line-height: 1.5;
    }
    .note-modal__hint strong { color: var(--body-text); }

    .note-modal__label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: var(--secondary-text);
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: .4px;
    }
    .note-modal__textarea {
        width: 100%;
        min-height: 160px;
        resize: vertical;
        border: 1px solid var(--surface-border);
        border-radius: 12px;
        padding: 12px 14px;
        font-size: 13px;
        line-height: 1.6;
        color: var(--body-text);
        background: var(--surface-soft);
        font-family: inherit;
        transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
    }
    .note-modal__textarea:focus {
        outline: none;
        border-color: #3b6fd4;
        box-shadow: 0 0 0 3px rgba(59,111,212,.12);
        background: var(--surface-bg);
    }

    .note-modal__meta {
        margin-top: 12px;
        font-size: 12px;
        color: var(--secondary-text);
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .note-modal__meta strong { color: var(--body-text); }

    .note-modal__footer {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 18px;
        padding-top: 16px;
        border-top: 1px solid var(--surface-border);
    }

    @media (max-width: 480px) {
        .note-modal__footer { flex-direction: column-reverse; }
        .note-modal__footer .btn-full,
        .note-modal__footer .btn-border { width: 100%; }
    }
</style>

<main class="main-content" style="margin-top:-7%">
    <div class="main__content ticket">
        <div class="ticket__body" style="max-width:800px">

            <article class="ticket__body_block original-message">
                <h3><?= htmlspecialchars($headline) ?></h3>
                <div class="block--head">
                    <div class="contact">
                        <div class="dropdown left out-close">
                            <label>
                                <span><?= htmlspecialchars($name) ?></span>
                                <svg class="icon icon-chevron-down" style="width:12px;height:12px;">
                                    <use xlink:href="../img/sprite.svg#icon-chevron-down"></use>
                                </svg>
                            </label>
                            <ul class="dropdown-list">
                                <?php if ($email): ?>
                                <li class="noclose">
                                    <span class="title">Email:</span>
                                    <span class="value">
                                        <a class="email-pill" href="mailto:<?= htmlspecialchars($email) ?>">
                                            <svg class="icon icon-mail-small"><use xlink:href="../img/sprite.svg#icon-mail-small"></use></svg>
                                            <?= htmlspecialchars($email) ?>
                                        </a>
                                    </span>
                                </li>
                                <li class="separator"></li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                    <?php if ($dateCreated): ?>
                        <time class="timeago tooltip" datetime="<?= htmlspecialchars($createdIso) ?>" title="<?= htmlspecialchars($dateCreated) ?>"><?= htmlspecialchars($dateCreated) ?></time>
                    <?php endif; ?>
                </div>

                <div class="group-title">Identification</div>
                <div><span class="custom-field-title">Ticket ID:</span><span><?= htmlspecialchars($ticketId) ?></span></div>
                <div>
                    <span class="custom-field-title">Status:</span>
                    <span class="status-chip" style="background: <?= htmlspecialchars($statusColor) ?>;"><?= htmlspecialchars($statusText) ?></span>
                </div>
                <div><span class="custom-field-title">Category:</span><span><?= htmlspecialchars($category) ?></span></div>
                <div><span class="custom-field-title">Subject:</span><span><?= htmlspecialchars($rawSubject !== '' ? $rawSubject : '—') ?></span></div>
                <?php if ($hasRealOwner): ?>
                <div><span class="custom-field-title">Assigned to:</span><span><?= htmlspecialchars($owner) ?></span></div>
                <?php endif; ?>
                <?php if ($operator !== ''): ?>
                <div><span class="custom-field-title">Operator:</span><span><?= htmlspecialchars($operator) ?></span></div>
                <?php endif; ?>

                <div class="group-title">Reporter &amp; Source</div>
                <div><span class="custom-field-title">Name:</span><span><?= htmlspecialchars($name) ?></span></div>
                <div><span class="custom-field-title">Phone No:</span><span><?= htmlspecialchars($phone) ?></span></div>
                <?php if ($email): ?>
                <div><span class="custom-field-title">Email:</span><span><a class="email-pill" href="mailto:<?= htmlspecialchars($email) ?>"><?= htmlspecialchars($email) ?></a></span></div>
                <?php endif; ?>
                <div><span class="custom-field-title">Incidence Date:</span><span><?= htmlspecialchars($prettyDate ?: $incDate) ?></span></div>
                <div><span class="custom-field-title">Incidence Source:</span><span><?= htmlspecialchars($incSource) ?></span></div>

                <?php if ($state || $community || $lga || $zone || $corridor !== '—'): ?>
                <div class="group-title">Location</div>
                <?php if ($state): ?><div><span class="custom-field-title">State:</span><span><?= htmlspecialchars($state) ?></span></div><?php endif; ?>
                <?php if ($community): ?><div><span class="custom-field-title">Community:</span><span><?= htmlspecialchars($community) ?></span></div><?php endif; ?>
                <?php if ($lga): ?><div><span class="custom-field-title">Local Government:</span><span><?= htmlspecialchars($lga) ?></span></div><?php endif; ?>
                <?php if ($zone): ?><div><span class="custom-field-title">Zone:</span><span><?= htmlspecialchars($zone) ?></span></div><?php endif; ?>
                <div><span class="custom-field-title">Corridor:</span><span><?= htmlspecialchars($corridor) ?></span></div>
                <div><span class="custom-field-title">Location Coordinate (Latitude):</span><span><?= htmlspecialchars($lat) ?></span></div>
                <div><span class="custom-field-title">Location Coordinate (Longitude):</span><span><?= htmlspecialchars($lng) ?></span></div>
                <?php endif; ?>

                <?php if ($pipeline || $pipelineType): ?>
                <div class="group-title">Pipeline</div>
                <?php if ($pipeline): ?><div><span class="custom-field-title">Pipeline:</span><span><?= htmlspecialchars($pipeline) ?></span></div><?php endif; ?>
                <?php if ($pipelineType): ?><div><span class="custom-field-title">Pipeline Type:</span><span><?= htmlspecialchars($pipelineType) ?></span></div><?php endif; ?>
                <?php endif; ?>

                <?php if ($nonZero($vessel) || $nonZero($vehicle) || $nonZero($boat) || $nonZero($suspects)): ?>
                <div class="group-title">Arrests &amp; Destruction</div>
                <div><span class="custom-field-title">Vessel Arrested/Destroyed:</span><span><?= htmlspecialchars($vessel) ?></span></div>
                <div><span class="custom-field-title">Vehicle Arrested/Destroyed:</span><span><?= htmlspecialchars($vehicle) ?></span></div>
                <div><span class="custom-field-title">Wooden/Speed Boat Arrested/Destroyed:</span><span><?= htmlspecialchars($boat) ?></span></div>
                <div><span class="custom-field-title">Number of Arrested Suspects:</span><span><?= htmlspecialchars($suspects) ?></span></div>
                <?php endif; ?>

                <?php if ($nonZero($crude) || $nonZero($ago) || $nonZero($pms) || $nonZero($dpk) || $nonZero($dumpSites)): ?>
                <div class="group-title">Recovered / Destroyed (Litres) &amp; Sites</div>
                <?php if ($nonZero($crude)): ?><div><span class="custom-field-title">Crude (Ltr):</span><span><?= htmlspecialchars($crude) ?></span></div><?php endif; ?>
                <?php if ($nonZero($ago)): ?><div><span class="custom-field-title">AGO (Ltr):</span><span><?= htmlspecialchars($ago) ?></span></div><?php endif; ?>
                <?php if ($nonZero($pms)): ?><div><span class="custom-field-title">PMS (Ltr):</span><span><?= htmlspecialchars($pms) ?></span></div><?php endif; ?>
                <?php if ($nonZero($dpk)): ?><div><span class="custom-field-title">DPK (Ltr):</span><span><?= htmlspecialchars($dpk) ?></span></div><?php endif; ?>
                <?php if ($nonZero($dumpSites)): ?><div><span class="custom-field-title">Illegal Storage / Dump Sites:</span><span><?= htmlspecialchars($dumpSites) ?></span></div><?php endif; ?>
                <?php endif; ?>

                <?php if ($hasRealOwner): ?>
                <div style="background-color: rgba(184,134,11,.25); color: var(--body-text); padding: 10px 16px; border-radius: 8px; margin-top: 12px; font-size: 13px; font-weight: 600;">
                    This ticket is assigned to <?= htmlspecialchars($owner) ?>
                </div>
                <?php endif; ?>

                <?php if ($description || $message): ?>
                <div class="block--description browser-default">
                    <span class="block--description__label">Incident Description</span>
                    <p><?= nl2br(htmlspecialchars($description ?: $message)) ?></p>
                </div>
                <?php endif; ?>

                <div class="block--notes">
                    <button class="btn--blue-border" type="button" id="open-note-modal">
                        <svg class="icon icon-note" style="width:14px;height:14px;"><use xlink:href="../img/sprite.svg#icon-note"></use></svg>
                        &nbsp; Add note
                    </button>
                    <button class="btn--blue-border" type="button" id="view-replies-btn" style="margin-left:8px;" <?= $repliesCount === 0 ? 'disabled' : '' ?>>
                        <svg class="icon icon-note" style="width:14px;height:14px;"><use xlink:href="../img/sprite.svg#icon-team"></use></svg>
                        &nbsp; View Replies (<span id="replies-count-badge"><?= (int) $repliesCount ?></span>)
                    </button>
                </div>

                <!-- ============================================================
                     NOTES PANEL — presentable list of internal notes
                     ============================================================ -->
                <div class="notes-panel">
                    <div class="notes-panel__head">
                        <h4>
                            <svg class="icon icon-note"><use xlink:href="../img/sprite.svg#icon-note"></use></svg>
                            Internal Notes
                        </h4>
                        <span class="notes-panel__count"><?= (int) $noteCount ?></span>
                    </div>

                    <?php if ($noteCount === 0): ?>
                        <div class="notes-panel__empty">No internal notes have been added yet.</div>
                    <?php else: ?>
                        <div class="notes-panel__list">
                            <?php foreach ($noteEntries as $entry): ?>
                                <div class="note-entry">
                                    <div class="note-entry__meta">
                                        <?php if ($entry['time'] !== ''): ?>
                                        <span class="note-entry__time">
                                            <svg class="icon"><use xlink:href="../img/sprite.svg#icon-clock"></use></svg>
                                            <?= htmlspecialchars($entry['time']) ?>
                                        </span>
                                        <?php endif; ?>
                                        <?php if ($entry['author'] !== ''): ?>
                                        <span class="note-entry__author">
                                            <svg class="icon"><use xlink:href="../img/sprite.svg#icon-user"></use></svg>
                                            <?= htmlspecialchars($entry['author']) ?>
                                        </span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="note-entry__body"><?= nl2br(htmlspecialchars($entry['body'])) ?></div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </article>

            <article class="ticket__body_block">
                <form method="post" class="form"
                      action="index.php?action=viewticket&viewtoken=<?= urlencode(base64_encode($ticketId)) ?>"
                      enctype="multipart/form-data">
                    <div class="block--message" id="message-block">
                        <textarea name="message" id="message" placeholder="Type your message" required></textarea>
                    </div>

                    <div class="block--attach">
                        <svg class="icon icon-attach" style="width:16px;height:16px;"><use xlink:href="../img/sprite.svg#icon-attach"></use></svg>
                        <div>Attachments (<a class="link file-limits-trigger" href="javascript:void(0)" id="openFileLimits">File upload limits</a>):</div>
                    </div>
                    <?php for ($i = 0; $i < 8; $i++): ?>
                        <input type="file" name="attachment[<?= $i ?>]" size="50" style="margin-bottom:4px;"><br>
                    <?php endfor; ?>

                    <section class="block--checkboxs">
                        <?php if ($canChangePriority): ?>
                        <div class="checkbox-custom">
                            <input type="checkbox" id="set_priority" name="set_priority" value="1">
                            <label for="set_priority">Change priority to</label>
                            <div class="dropdown-select center out-close priority" data-value="low">
                                <select id="replypriority" name="priority">
                                    <option value="" selected><?= htmlspecialchars($defaultPriorityLabel) ?></option>
                                    <?php if (!empty($LoadPriorityColumnForSelect)): ?>
                                        <?php foreach ($LoadPriorityColumnForSelect as $priority_options): ?>
                                            <option value="<?= htmlspecialchars($priority_options['name']) ?>"><?= htmlspecialchars($priority_options['name']) ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class="checkbox-custom">
                            <input type="checkbox" id="no_notify" name="no_notify" value="1">
                            <label for="no_notify">Don't send email notification of this reply to the customer</label>
                        </div>
                    </section>

                    <section class="block--submit">
                        <input type="hidden" name="submit_reply" value="1">
                        <input type="hidden" name="orig_id" value="<?= htmlspecialchars($ticketId) ?>">
                        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                        <input class="btn-full" type="submit" value="Submit reply">
                        <?php if ($canChangeStatus): ?>
                        <div class="submit-us dropdown-select out-close" data-value="" id="submit-as-div">
                            <select id="submit_as_select" name="submit_as">
                                <option value="" selected><?= htmlspecialchars($defaultStatusLabel) ?></option>
                                <?php if (!empty($LoadAllTicketCategories)): ?>
                                    <?php foreach ($LoadAllTicketCategories as $status_listing): ?>
                                        <option value="<?= htmlspecialchars($status_listing['name']) ?>"><?= htmlspecialchars(ucfirst($status_listing['name'])) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <?php endif; ?>
                    </section>
                </form>
            </article>
        </div>

        <div class="ticket__params">
            <section class="params--bar" style="padding-left: 0">
                <a href="Javascript:void(0)" title="Print" class="btn-print" onclick="window.print();return false;">
                    <svg class="icon icon-print" style="width:14px;height:14px;"><use xlink:href="../img/sprite.svg#icon-print"></use></svg>
                    Print
                </a>
            </section>

            <section class="params--block params">
                <div class="row ts" id="ticket-status-div">
                    <div class="title"><label for="select_s">Ticket status:</label></div>
                    <div class="value value-label" style="color: <?= htmlspecialchars($statusColor) ?>;"><?= htmlspecialchars($statusText) ?></div>
                </div>
                <div class="row">
                    <div class="title"><label for="select_category">Category:</label></div>
                    <div class="value center out-close"><?= htmlspecialchars($category) ?></div>
                </div>
                <div class="row">
                    <div class="title"><label for="select_priority">Priority:</label></div>
                    <div class="value value-label" style="color: <?= htmlspecialchars($priorityColorResolved) ?>;"><?= htmlspecialchars($priority) ?></div>
                </div>
                <div class="row">
                    <div class="title"><label for="select_owner">Assigned to:</label></div>
                    <div class="value center out-close"><b><?= htmlspecialchars($hasRealOwner ? $owner : 'Unassigned') ?></b></div>
                </div>
            </section>

            <section class="params--block details accordion visible">
                <h4 class="accordion-title">
                    <span>Ticket Details</span>
                    <svg class="icon icon-chevron-down" style="width:14px;height:14px;"><use xlink:href="../img/sprite.svg#icon-chevron-down"></use></svg>
                </h4>
                <div class="accordion-body" style="display:block">
                    <div class="row"><div class="title">Tracking ID:</div><div class="value"><?= htmlspecialchars($ticketId) ?></div></div>
                    <div class="row"><div class="title">Ticket number:</div><div class="value"><?= htmlspecialchars($ticketId) ?></div></div>
                    <div class="row"><div class="title">Subject:</div><div class="value"><?= htmlspecialchars($rawSubject !== '' ? $rawSubject : '—') ?></div></div>
                    <div class="row"><div class="title">Created on:</div><div class="value"><?= htmlspecialchars($dateCreated ?: '—') ?></div></div>
                    <div class="row"><div class="title">Updated:</div><div class="value"><?= htmlspecialchars($dateUpdated ?: '—') ?></div></div>
                    <div class="row"><div class="title">Replies:</div><div class="value"><?= (int) $repliesCount ?></div></div>
                    <div class="row"><div class="title">Last replier:</div><div class="value"><?= htmlspecialchars($incSource ?: '—') ?></div></div>
                    <div class="row">
                        <div class="title">Due date</div>
                        <div class="value">
                            <a href="javascript:" onclick="hesk_toggleLayerDisplay('modifyduedate')"><?= htmlspecialchars($dueDate ?: 'None') ?></a>
                        </div>
                    </div>
                </div>
            </section>

            <section class="params--block history accordion">
                <h4 class="accordion-title">
                    <span>Ticket History</span>
                    <svg class="icon icon-chevron-down" style="width:14px;height:14px;"><use xlink:href="../img/sprite.svg#icon-chevron-down"></use></svg>
                </h4>
                <div class="accordion-body">
                    <div class="row" style="flex-direction:column;align-items:flex-start;">
                        <div class="title"><?= htmlspecialchars($dateCreated ?: '—') ?></div>
                        <div class="value">ticket created by <?= htmlspecialchars($incSource ?: $name) ?></div>
                    </div>
                    <?php if ($dateUpdated && $dateUpdated !== $dateCreated): ?>
                    <div class="row" style="flex-direction:column;align-items:flex-start;">
                        <div class="title"><?= htmlspecialchars($dateUpdated) ?></div>
                        <div class="value">ticket updated</div>
                    </div>
                    <?php endif; ?>
                </div>
            </section>
        </div>
    </div>

    <div class="users-online">
        <svg class="icon icon-team" style="width:14px;height:14px;"><use xlink:href="../img/sprite.svg#icon-team"></use></svg>
        <span><?= htmlspecialchars($company_name) ?></span>
    </div>

    <a href="#" class="back-to-top">Back to Top</a>
</main>

<div class="replies-modal-overlay" id="replies-modal-overlay" aria-hidden="true">
    <div class="replies-modal" role="dialog" aria-modal="true" aria-labelledby="replies-modal-title">
        <div class="replies-modal__head">
            <h3 id="replies-modal-title">Replies</h3>
            <button type="button" class="replies-modal__close" id="replies-modal-close" aria-label="Close">&times;</button>
        </div>
        <div class="replies-modal__body">
            <div class="replies-toolbar">
                <input type="search" id="replies-search" placeholder="Search replies…" aria-label="Search replies">
                <span class="dt-info" id="replies-count"><?= (int) $repliesCount ?> replies</span>
            </div>
            <div class="replies-table-wrap">
                <table class="replies-datatable" id="replies-datatable">
                    <thead>
                        <tr>
                            <th>SN</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Role</th>
                            <th>Comment</th>
                            <th>Attachments</th>
                        </tr>
                    </thead>
                    <tbody id="replies-tbody"></tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- ============================================================
     ADD NOTE MODAL
     ============================================================ -->
<div class="note-modal-overlay" id="noteModalOverlay" role="dialog" aria-modal="true" aria-labelledby="noteModalTitle">
    <div class="note-modal">
        <div class="note-modal__head">
            <h3 id="noteModalTitle">
                <svg class="icon icon-note" style="width:16px;height:16px;"><use xlink:href="../img/sprite.svg#icon-note"></use></svg>
                &nbsp; Add Internal Note
            </h3>
            <button type="button" class="note-modal__close" id="noteModalClose" aria-label="Close">&times;</button>
        </div>

        <form method="post"
              action="index.php?action=viewticket&viewtoken=<?= urlencode(base64_encode($ticketId)) ?>"
              class="note-modal__body" id="noteForm">
            <input type="hidden" name="add_ticket_note" value="1">
            <input type="hidden" name="note_ticket_id" value="<?= htmlspecialchars($ticketId) ?>">
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">

            <p class="note-modal__hint">
                <svg class="icon" style="width:14px;height:14px;vertical-align:-2px;">
                    <use xlink:href="../img/sprite.svg#icon-note"></use>
                </svg>
                Notes are <strong>internal only</strong> and are hidden from the customer. The ticket owner
                will be notified by email that a note was added.
            </p>

            <label class="note-modal__label" for="note_body">Note</label>
            <textarea id="note_body" name="note_body" class="note-modal__textarea"
                      placeholder="Type your note here…" required></textarea>

            <div class="note-modal__meta">
                <span>Adding as:</span>
                <strong><?= htmlspecialchars(($admin_fn ?? 'User') . ' (' . ($admin_lrn ?? ($_SESSION['role'] ?? '')) . ') - ' . ($_SESSION['userid'] ?? '')) ?></strong>
            </div>

            <div class="note-modal__footer">
                <button type="button" class="btn-border" id="noteCancelBtn">Cancel</button>
                <button type="submit" class="btn-full" id="noteSubmitBtn">
                    <svg class="icon" style="width:14px;height:14px;"><use xlink:href="../img/sprite.svg#icon-save"></use></svg>
                    &nbsp; Save Note &amp; Notify
                </button>
            </div>
        </form>
    </div>
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

<input type="hidden" name="HESK_PATH" value="../">
<script src="../js/svg4everybody.min.js"></script>
<script src="../js/datepicker.min.js"></script>
<script>
(function ($) { $.fn.datepicker.language['en'] = {
    days: ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'],
    daysShort: ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'],
    daysMin: ['Su','Mo','Tu','We','Th','Fr','Sa'],
    months: ['January','February','March','April','May','June','July','August','September','October','November','December'],
    monthsShort: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
    today: 'Today', clear: 'Clear',
    dateFormat: 'mm/dd/yyyy', timeFormat: 'hh:ii aa', firstDay: 0
}; })(jQuery);
</script>
<script src="../js/app.min.js"></script>

<script>
(function () {
    var REPLIES = <?= json_encode(array_values(array_map(function ($r) {
        $attachments = getReplyAttachments($r);
        $attOut = [];
        foreach ($attachments as $att) {
            $attOut[] = [
                'path'  => attachmentHref($att),
                'label' => attachmentLabel($att),
            ];
        }
        return [
            'date'        => $r['date']          ?? '',
            'name'        => $r['replyer_name']  ?? '',
            'role'        => $r['role']          ?? '',
            'comment'     => $r['comment']       ?? '',
            'attachments' => $attOut,
        ];
    }, $replies)), JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    var overlay    = document.getElementById('replies-modal-overlay');
    var openBtn    = document.getElementById('view-replies-btn');
    var closeBtn   = document.getElementById('replies-modal-close');
    var tbody      = document.getElementById('replies-tbody');
    var searchEl   = document.getElementById('replies-search');
    var countEl    = document.getElementById('replies-count');
    var countBadge = document.getElementById('replies-count-badge');

    function syncRepliesButton() {
        var total = REPLIES.length;
        if (countBadge) countBadge.textContent = total;
        if (openBtn) {
            if (total > 0) { openBtn.disabled = false; openBtn.removeAttribute('disabled'); }
            else { openBtn.disabled = true; openBtn.setAttribute('disabled', 'disabled'); }
        }
    }

    function escapeHtml(str) {
        return String(str == null ? '' : str)
            .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
    }

    function renderAttachmentChips(attachments) {
        if (!attachments || !attachments.length) {
            return '<span class="attachment-none">—</span>';
        }
        var html = '<div class="attachment-list">';
        for (var i = 0; i < attachments.length; i++) {
            var att = attachments[i];
            var label = att && att.label ? att.label : '';
            var href  = att && att.path ? att.path : '';
            if (!href) continue;
            html +=
                '<a class="attachment-item" href="' + escapeHtml(href) + '" target="_blank" rel="noopener noreferrer" title="' + escapeHtml(label) + '">' +
                    '<svg class="icon icon-attach"><use xlink:href="../img/sprite.svg#icon-attach"></use></svg>' +
                    '<span>' + escapeHtml(label) + '</span>' +
                '</a>';
        }
        html += '</div>';
        return html;
    }

    function renderRows(data) {
        if (!data.length) {
            tbody.innerHTML = '<tr><td colspan="6" class="replies-empty">No replies found.</td></tr>';
        } else {
            tbody.innerHTML = data.map(function (r, idx) {
                return '<tr>' +
                    '<td class="col-sn">' + (idx + 1) + '</td>' +
                    '<td>' + escapeHtml(r.date) + '</td>' +
                    '<td>' + escapeHtml(r.name) + '</td>' +
                    '<td>' + escapeHtml(r.role) + '</td>' +
                    '<td class="col-comment">' + escapeHtml(r.comment) + '</td>' +
                    '<td class="col-attachments">' + renderAttachmentChips(r.attachments) + '</td>' +
                '</tr>';
            }).join('');
        }
        if (countEl) countEl.textContent = data.length + ' repl' + (data.length === 1 ? 'y' : 'ies');
    }

    function filterRows() {
        var q = (searchEl.value || '').toLowerCase().trim();
        if (!q) { renderRows(REPLIES); return; }
        renderRows(REPLIES.filter(function (r) {
            var hay = r.date + ' ' + r.name + ' ' + r.role + ' ' + r.comment;
            if (r.attachments && r.attachments.length) {
                for (var i = 0; i < r.attachments.length; i++) hay += ' ' + (r.attachments[i].label || '');
            }
            return hay.toLowerCase().indexOf(q) !== -1;
        }));
    }

    function openModal() {
        if (!REPLIES.length) return;
        renderRows(REPLIES);
        overlay.classList.add('is-open');
        overlay.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        searchEl.value = '';
        searchEl.focus();
    }
    function closeModal() {
        overlay.classList.remove('is-open');
        overlay.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    syncRepliesButton();
    if (openBtn)  openBtn.addEventListener('click', openModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);
    if (overlay)  overlay.addEventListener('click', function (e) { if (e.target === overlay) closeModal(); });
    if (searchEl) searchEl.addEventListener('input', filterRows);
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && overlay.classList.contains('is-open')) closeModal(); });
})();
</script>

<script>
/* ============================================================
   ADD NOTE MODAL — fancy popup
   ============================================================ */
(function () {
    var overlay  = document.getElementById('noteModalOverlay');
    var openBtn  = document.getElementById('open-note-modal');
    var closeX   = document.getElementById('noteModalClose');
    var cancel   = document.getElementById('noteCancelBtn');
    var form     = document.getElementById('noteForm');
    var textarea = document.getElementById('note_body');
    var submit   = document.getElementById('noteSubmitBtn');

    if (!overlay || !openBtn) return;

    function openModal() {
        overlay.classList.add('open');
        document.body.style.overflow = 'hidden';
        setTimeout(function () { if (textarea) textarea.focus(); }, 80);
    }
    function closeModal() {
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }

    openBtn.addEventListener('click', function (e) {
        e.preventDefault();
        openModal();
    });
    if (closeX) closeX.addEventListener('click', closeModal);
    if (cancel) cancel.addEventListener('click', closeModal);

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal();
    });

    // Basic client-side guard
    if (form) {
        form.addEventListener('submit', function (e) {
            if (!textarea.value.trim()) {
                e.preventDefault();
                textarea.focus();
                return;
            }
            if (submit) {
                submit.disabled = true;
                submit.innerHTML = 'Saving…';
            }
        });
    }
})();
</script>

<script>
/* ============================================================
   FILE LIMITS MODAL — self-contained, no hesk_window
   ============================================================ */
(function () {
    var overlay   = document.getElementById('fileLimitsOverlay');
    var openBtn   = document.getElementById('openFileLimits');
    var closeX    = document.getElementById('fileLimitsClose');
    var closeBtn  = document.getElementById('fileLimitsCloseBtn');

    if (!overlay || !openBtn) return;

    function openModal()  { overlay.classList.add('open');    document.body.style.overflow = 'hidden'; }
    function closeModal() { overlay.classList.remove('open'); document.body.style.overflow = ''; }

    openBtn.addEventListener('click', function (e) {
        e.preventDefault();
        openModal();
    });
    if (closeX)   closeX.addEventListener('click', closeModal);
    if (closeBtn) closeBtn.addEventListener('click', closeModal);

    overlay.addEventListener('click', function (e) {
        if (e.target === overlay) closeModal();
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && overlay.classList.contains('open')) closeModal();
    });
})();
</script>