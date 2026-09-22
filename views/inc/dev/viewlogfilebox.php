<div class="table-responsive">
    <table id="logDataTable" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Log Entry</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (file_exists($company_logfile_url)) {


            $logcontent = file_get_contents($company_logfile_url);

            $loglines = preg_split('/\r\n|\r|\n/', $logcontent);

            $loglines = array_reverse($loglines);

            foreach ($loglines as $logline) {

                if (trim($logline) !== '') {
                    echo '<tr>';
                    echo '<td style="font-family:monospace; white-space:pre-wrap;">'
                        . htmlspecialchars($logline)
                        . '</td>';
                    echo '</tr>';
                }
            }

        } else {
            echo '<tr>';
            echo '<td>Log file not found.</td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>


</div>

<script>
$(document).ready(function () {
    $('#logDataTable').DataTable({
        pageLength: 25,
        order: [],
        searching: true
    });
});
</script>
