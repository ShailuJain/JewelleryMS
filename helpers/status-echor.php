<?php
function echoStatus($status, $msg){
    echo json_encode(array(
        "status" => $status,
        "msg" => $msg
    ));
}