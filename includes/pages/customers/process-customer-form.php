<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 26-03-2019
 * Time: 04:45 PM
 */
header('Content-Type: application/json');
require_once ('db/models/Customer.class.php');
require_once ('helpers/status-echor.php');
if(isset($_POST[$operation]))
{
    if($operation == ADD_CUSTOMER){
        $msg = "added";
        $func = "insert";
    }
    else if($operation == EDIT_CUSTOMER){
        $msg = "edited";
        $func = "update";
    }
    try
    {
        $array = $_POST;//adding the form data to an array
        unset($array[$operation]);//unset the submit button that was pressed

        $arrayKeys = array_keys($array);//getting all the filed names that we want to add in db

        $customer = new Customer();

        foreach ($arrayKeys as $item) {
            $customer->$item = $array[$item];
        }
        if($customer->$func()){
            //showing a toast when a customer is successfully added
            echoStatus("success","Customer $msg successfully");
        }
        else{
            echoStatus("error","Customer already exists");
        }
    }catch (Exception $ex){
        echoStatus("error","Something went wrong");
    }
}