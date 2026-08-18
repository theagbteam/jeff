<script src="app/views/assets/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        <?php if ($showAlert): ?>
            Swal.fire({
                title: 'Successful!',
                text: '<?php echo htmlspecialchars($msgtext, ENT_QUOTES, 'UTF-8'); ?>',
                icon: 'info',
                confirmButtonText: 'OK',
                allowOutsideClick: true,
                allowEscapeKey: true
            }).then((result) => {
                if (result.isConfirmed || result.dismiss) {
                    window.location.href = '<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>';
                }
            });
        <?php else: ?>
            Swal.fire({
                title: 'Error',
                text: '<?php echo htmlspecialchars($msgtext, ENT_QUOTES, 'UTF-8'); ?>',
                icon: 'error',
                confirmButtonText: 'OK',
                allowOutsideClick: true,
                allowEscapeKey: true
            }).then((result) => {
                if (result.isConfirmed || result.dismiss) {
                    window.location.href = '<?php echo htmlspecialchars($url, ENT_QUOTES, 'UTF-8'); ?>';
                }
            });
        <?php endif; ?>
    });
</script>

<script src="app/views/assets/js/jquery.dataTables.min.js"></script>
<script src="app/views/assets/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
    $('#monthlyReportTable').DataTable({
        pageLength: <?= (int)$page_length ?>,
        lengthMenu: [<?= json_encode($lengthMenu) ?>, <?= json_encode($lengthMenu) ?>],
        ordering: true,
        responsive: true
    });
});
</script>


</body>
</html>
