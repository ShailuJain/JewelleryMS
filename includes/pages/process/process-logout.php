<?php
    session_start();
    $_SESSION['user_id'] = null;
    $_SESSION['role'] = null;
    session_unset();
    header("Location: ../../../login.php");
