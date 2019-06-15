<?php
    session_start();
    unset($_SESSION['user_id']);
    session_unset();
    header("Location: ../../../index.php");
