<?php
if(isset($_POST['reset'])){
    $token  = $_POST['token'];
    $password = $_POST['user_password'];
    $confirm_password = $_POST['user_confirm_password'];
    if($password === $confirm_password){
        include_once("db/models/User.class.php");
        $user = User::find("token=?",$token);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $user->password = $hashed_password;
        $user->update();
        header("Location: ../../../login.php");
    }
    else{
        header("Location: reset.php?token=$token");
    }
}