<?php
include_once("db/models/User.class.php");
if (isset($_POST['login'])) {
    $user_email = $_POST['user_email'];
    $password = $_POST['user_password'];
    $rs = User::select("user_id,username,user_email,password", 0, "user_email= ?", $user_email);
    $row = $rs->rowCount();
    $db_password = "";
    echo"hi";
    echo"$row";
    if ($row == 1) {
        $details = $rs->fetch();
        $user_id = $details->user_id;
        $username = $details->username;
        $db_user_email = $details->user_email;
        $db_password = $details->password;
        if (password_verify($password, $db_password)) {
            if (!isset($_SESSION['user_id'])) {
                session_start();
            }
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php");
            setStatusAndMsg("success", "Logged in Successfully");
        } else {
            echo "Login unsuccessfull";
        }
    }
}
