<!-- DESK MENU --->

<a class="nav-link active" href="index.php?action=dashboard">🎛️ Command Dashboard</a>

<!--<a class="nav-link" href="#">🪪 Personnel Registry</a>-->

<!-- RECRUIT DROPDOWN -->
<a class="nav-link d-flex justify-content-between align-items-center"
   data-bs-toggle="collapse" href="#personnelMenu">
  <span>🪪  Personnel Registry</span>
  <span>▾</span>
</a>

<div class="collapse" id="personnelMenu">
  <a class="nav-link" href="__DIR__ . '/../index.php?action=newpersonnel">🧑‍✈️ Add Record</a>
  <a class="nav-link" href="recruit-manage">🗂️ Manage Record</a>
</div>

<!-- MONTHLY REPORTS -->
<a class="nav-link d-flex justify-content-between align-items-center"
   data-bs-toggle="collapse" href="#ReportMenu">
  <span>📡 Monthly Reports</span>
  <span>▾</span>
</a>

<div class="collapse" id="ReportMenu">
  <a class="nav-link" href="view-reports">🗃️ View Reports Archive</a>
  <a class="nav-link" href="create-report">📝 File New Report</a>
</div>

<a class="nav-link" href="#">🛂 Leave Administration</a>

<a class="nav-link" href="#">📆 Duty Roster</a>

<a class="nav-link" href="#">🎯 Training & Drills</a>

<!-- PROMOTIONS DROPDOWN -->
<a class="nav-link d-flex justify-content-between align-items-center"
   data-bs-toggle="collapse" href="#promotionsMenu">
  <span>🏅 Rank Promotions</span>
  <span>▾</span>
</a>

<div class="collapse" id="promotionsMenu">
  <a class="nav-link" href="promotion-list">📈 Promotion Roll</a>
  <a class="nav-link" href="promotion-exercise">⚔️ Promotion Exercise</a>
  <a class="nav-link" href="eligible-officers">🧭 Eligible Personnel</a>
  <a class="nav-link" href="promotion-history">📜 Promotion History</a>
</div>

<a class="nav-link" href="#">🗺️ Nominal Roll</a>
<a class="nav-link d-flex justify-content-between align-items-center"
   data-bs-toggle="collapse" href="#DocumentMenu">
  <span>📑 Document samples</span>
  <span>▾</span>
</a>

<div class="collapse" id="DocumentMenu">
  <a class="nav-link" href="view-reports">🗃️View Samples</a>
  <a class="nav-link" href="create-report">📝Upload new sample</a>
</div>

<a class="nav-link" href="#">🔐 System Configuration</a>

<a class="nav-link" href="index.php?action=logout">🚨 Secure Logout</a>


<!-- END OF DESK MENU -->
