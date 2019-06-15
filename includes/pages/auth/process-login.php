<?php
include_once("db/models/User.class.php");
if (isset($_POST['login'])) {
    $password = $_POST['user_password'];
    $rs = User::select("user_id,username,password", 0, "username = ?", "sakshi");
    $row = $rs->rowCount();
    $db_password = "";
    if ($row == 1) {
        $details = $rs->fetch();
        $user_id = $details->user_id;
        $username = $details->username;
        $db_password = $details->password;
        if (password_verify($password, $db_password)) {
            if (!isset($_SESSION['user_id'])) {
                session_start();
            }
            $_SESSION['user_id'] = $user_id;
            header("Location: index.php");
            setStatusAndMsg("success", "Logged in Successfully");
        } else {
            $wrong = "<i class='fa fa-times'></i> Wrong Password";
        }
    }
}
