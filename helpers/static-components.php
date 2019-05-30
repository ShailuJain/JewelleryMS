<?php
//ob_start();
if(session_status() !== PHP_SESSION_ACTIVE)
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<?php
include_once ('constants.php');
include_once ("includes/header.php");
?>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

    <?php
    include_once ("includes/sidebar.php");
    ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <?php
            //include_once ("includes/navbar.php");
            ?>
            <div class="mb-5"></div>

            <div id="include">
                <!-- Begin Page Content -->
                <?php
                include_once ("includes/{$include_page}");
                ?>
                <!-- /.container-fluid -->
            </div>

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        <?php
        include_once ("includes/footer.php");
        ?>

        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->


<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<?php
require_once ("includes/core-scripts.php");
if(isset($_SESSION['redirect_to'])){
    echo "<script>";
    $loc = $_SESSION['redirect_to'];
    unset($_SESSION['redirect_to']);
    echo "window.location.replace('{$loc}');";
    echo "</script>";
}else{
    if(isset($_SESSION['resp'])){
        require_once ('helpers/redirect-helper.php');
        $resp = $_SESSION['resp'];
        $status = $resp['status'];
        $msg = $resp['msg'];
        inner($status, $msg);
        unset($_SESSION['resp']);
    }
}
?>

</body>

</html>
