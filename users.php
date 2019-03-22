<!DOCTYPE html>
<html lang="en">

<?php
    $title = "Add User";
    include_once ("includes/header.php");
?>

<body class="bg-gradient-primary">
    <div id="wrapper">
        <?php
        include_once ("includes/sidebar.php");
        ?>
        <div id="content-wrapper">

            <?php
            include_once ("includes/navbar.php");
            ?>
            <div class="container">
                <?php
                    if(isset($_GET['src'])){
                        $ch = $_GET['src'];
                        switch ($ch){
                            case "add-user":
                                include_once('pages/users/add-user-2.php');
                                break;
                            case "view-all-users":
                                include_once('pages/users/view-all-users.php');
                                break;
                        }
                    }
                ?>
            </div>
        </div>
    </div>

    <?php
        include_once("includes/core-scripts.php")
    ?>
</body>

</html>
