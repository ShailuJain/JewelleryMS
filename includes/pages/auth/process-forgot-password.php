<?php
if(isset($_POST['forgot-password'])) {
    $user_email = $_POST['email_address'];
    $user = User::find("user_email=?", $user_email);
    if($user){
        $length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($length));
        $user->token = $token;
        $user->update();
        $to = $user_email;
        $subject = "Reset Password";

        $message = "To reset your password please click the above link<br>";
        $message .= "<a href = 'http://localhost/JewelleryMS/reset.php?token={$token}'>http://localhost/JewelleryMS/reset.php?token={$token}</a>";

        $header = "From:noreply@cms.com\r\n";
        $header .= "MIME-version: 1.0\r\n";
        $header .= "Content-Type: text/html\r\n";
        if (mail($to, $subject, $message, $header)) {
            echo "sent";
        } else {
            echo "Error";
        }
    }
    else{
        echo "NO USER FOUNDDD";
    }
}
