
<?php
// $page_name="corridors";
include "views/inc/dev/head.php"  ; ?>

<body>
   
    <!-- PAGE LOADER -->
<div id="pageLoader">
    <div class="loader-content">
        <div class="spinner"></div>
        <div class="loader-text">Loading...</div>
    </div>
</div>
<div class="container-scroller">
    <div class="row p-0 m-0 proBanner" id="proBanner">
        <div class="col-md-12 p-0 m-0"></div>
    </div>
    
<?php include "views/inc/dev/sidebar.php"  ?>
    <div class="container-fluid page-body-wrapper">
<?php include "views/inc/dev/topbar.php"  ?>

        <div class="main-panel">

            <div class="content-wrapper">
                
<!-- <?php include "views/inc/dev/summaryboxes.php"  ?> -->

<?php include "views/inc/dev/preview_corridor.php"  ?>

            </div>
<?php include "views/inc/dev/footer.php"  ?>

        </div>

    </div>

</div>
 <?php include "views/inc/dev/footerscripts.php"  ?> 
</body>

</html>

