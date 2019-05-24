<?php
require_once('db/models/Category.class.php');
require_once('helpers/redirect-helper.php');
require_once('helpers/redirect-constants.php');
if (isset($_GET['id'])) {
    try {
        $category_id = $_GET['id'];

        //finding category object
        $category = Category::find("category_id = ?", $category_id);
        if ($category) {
            if (!$category->isUsed() && $category->delete()) {
                setStatusAndMsg("success", "Category deleted successfully");
                redirect_to(VIEW_ALL_CATEGORIES);
            }else {
                setStatusAndMsg("error", "Category could not be deleted");
            }
        } else {
            setStatusAndMsg("error", "Category does not exists");
        }
    } catch (Exception $ex) {
        setStatusAndMsg("error", "Something went wrong");
    }
}