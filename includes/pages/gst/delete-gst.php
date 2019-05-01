<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 26-03-2019
 * Time: 04:45 PM
 */
require_once ('db/models/GST.class.php');
require_once ('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if(isset($_GET['hsn_code'])) {
    try {
        $flag = true;
        $hsn_code = $_GET['hsn_code'];

        //finding category object
        $gsts = GST::select("*", 0,"hsn_code = ?",$hsn_code);
        if ($gsts) {
            CRUD::setAutoCommitOn(false);
            foreach ($gsts->fetchAll() as $gstFetch) {
                $gst = new GST($gstFetch);
                if ($gst->isUsed() || !$gst->delete()) {
                    $flag = false;
                    setStatusAndMsg("error", "GST entry cannot be deleted");
                    redirect_to(VIEW_ALL_GST);
                    break;
                }
            }
            if ($flag) {
                CRUD::commit();
                setStatusAndMsg("success", "GST entry deleted successfully");
                redirect_to(VIEW_ALL_GST);
            }else{
                CRUD::rollback();
            }
            CRUD::setAutoCommitOn(true);
        } else {
            setStatusAndMsg("error", "GST entry do not exists");
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
    }
}