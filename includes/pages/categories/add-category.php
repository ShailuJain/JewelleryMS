<?php
require_once('db/models/Category.class.php');
require_once('db/models/GST.class.php');
require_once 'constants.php';
require_once ('helpers/redirect-helper.php');
if(isset($_POST[ADD_CATEGORY])){
    try{
        if(!empty($_POST['category_name']) && !empty($_POST['gst_id'])){

            $category = new Category();
            $category->category_name = $_POST['category_name'];
            $gst_id = $_POST['gst_id'];
            $category->gst_id = $gst_id;
            if($category->insert()){
                setStatusAndMsg("success","Category added successfully");
            }else {
                setStatusAndMsg("error", "Category already exists");
            }
        }
        else{
            setStatusAndMsg("error","Enter valid details");
        }
    } catch(Exception $e){
        setStatusAndMsg("error", "Something went wrong");
    }
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>Add New Category</h3>
            <hr>

            <div class="form-group">
                <label for="category_name" data-toggle="tooltip" data-placement="right" title="" >Category Name <i class="fa fa-question-circle"></i></label>
                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter category name">
            </div>

            <div class="form-group">
                <label for="gst_id" data-toggle="tooltip" data-placement="right" title="" >HSN Code <i class="fa fa-question-circle"></i></label>
                <select name="gst_id" id="gst_id" class="form-control selectize" required>
                    <option value="">Select HSN Code</option>
                    <?php
                    $result = GST::viewAll();
                    foreach ($result as $hsn){
                        echo "<option value='$hsn->gst_id'>$hsn->hsn_code</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" name="add_category" id="add_category" class="btn btn-primary">Add Category</button>
        </form>
    </div>
</div>
