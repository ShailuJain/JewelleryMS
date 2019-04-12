<?php
function setStatusAndMsg($status, $msg){
    $_SESSION['resp'] = array(
        "status" => $status,
        "msg" => $msg,
    );
}
function inner($status, $msg){
    echo "<script>";
    echo "(function(){";
    if($status === "success"){
        echo<<<TOAST
iziToast.success({
             message: "$msg",
             position: "bottomRight",
         });
TOAST;
    }else if($status === "error"){
        echo<<<TOAST
iziToast.error({
             message: "$msg",
             position: "bottomRight",
         });
TOAST;
    }
    echo "})();";
    echo "</script>";
}
function redirect_to($location){
    $_SESSION['redirect_to'] = $location;
}