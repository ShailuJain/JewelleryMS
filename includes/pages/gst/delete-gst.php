<?php
/**
 * Created by PhpStorm.
 * User: Shailu
 * Date: 26-03-2019
 * Time: 04:45 PM
 */
require_once ('db/models/GST.class.php');
require_once ('helpers/redirect-helper.php');
require_once ('helpers/redirects.php');
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
                unset($gst->gst_id);
                if (!$gst->delete()) {
                    $flag = false;
                    CRUD::rollback();
                    CRUD::setAutoCommitOn(true);
                    break;
                }
            }
            if ($flag) {
                CRUD::commit();
                CRUD::setAutoCommitOn(true);
                setStatusAndMsg("success", "GST entry deleted successfully");
                redirect_to(VIEW_ALL_GST);
            }
        } else {
            setStatusAndMsg("error", "GST entry do not exists");
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
    }
}