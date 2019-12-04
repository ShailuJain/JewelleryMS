<?php
require_once ('db/models/Udhaari.class.php');
require_once ('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if(isset($_GET['id'])) {
    try {
        $udhaari_id = $_GET['id'];
        CRUD::setAutoCommitOn(false);

        //finding category object
        $udhaari = Udhaari::find("udhaari_id = ?", $udhaari_id);
        if ($udhaari) {
            if(!Udhaari::isUsed($udhaari->udhaari_id)) {
                if ($udhaari->delete()) {
                    CRUD::commit();
                    setStatusAndMsg("success", "Udhaari deleted successfully");
                    redirect_to(VIEW_ALL_UDHAARIS);
                } else {
                    CRUD::rollback();
                    setStatusAndMsg("error", "Udhaari could not be deleted.");
                    redirect_to(VIEW_UDHAARI_WITH_ID . $udhaari_id);
                }
            }else{
                setStatusAndMsg("error", "Payments exists for this udhaari. Please delete the payments first.");
                redirect_to(VIEW_UDHAARI_WITH_ID . $udhaari_id);
            }
        } else {
            setStatusAndMsg("error", "Udhaari do not exists");
            redirect_to(VIEW_ALL_UDHAARIS);
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
        redirect_to(VIEW_ALL_UDHAARIS);
    }

    CRUD::setAutoCommitOn(true);
}