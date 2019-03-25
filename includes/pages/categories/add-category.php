<?php
require_once('db/models/Category.class.php');
require_once('db/models/GST.class.php');
if(isset($_POST['add_category'])){
    try{
        CRUD::init();
        CRUD::query("SET AUTOCOMMIT=OFF");
        if(!empty($_POST['category_name']) && !empty($_POST['hsn_code']) && !empty($_POST['gst_rate'])){
            $category = new category();
            $GST = new GST();
            $category->category_name = $_POST['category_name'];
            $category->hsn_code = $GST->hsn_code = $_POST['hsn_code'];
            $GST->gst_rate = $_POST['gst_rate'];
            $result = CRUD::select("gst","*", "hsn_code = $GST->hsn_code");
            $row = $result->fetch();
            $result1 = CRUD::select("categories","*","category_name = '$category->category_name'");
            $row1 = $result1->fetch();
            if(!$row1 && !$row){
                if($category->insert() and $GST->insert()){
                    crud::query("COMMIT");
                    echo "INSERTED SUCCESSFULLY";
                    //UI FOR SUCCESSFULL INSERTION
                }
                else{
                    crud::query("ROLLBACK");
                    echo"ERROR INSERTING";
                    //UI FOR ERRORS WHILE INSERTING
                }
            }
            else{
                if($row){
                    echo "HSN code already Exist";
                    //UI FOR SAME HSN
                }
                else{
                    echo "Category already exist";
                    //UI FOR SAME CATEGORY
                }
                //UI FOR HSN ALREADY EXISTING
            }
        }
        else{
            echo"PLEASE ENTER ALL DETAILS PROPERLY";
            //UI FOR ALL FIELDS
        }
    }
    catch(Exception $e){
        crud::query("ROLLBACK");
    }
    crud::select("ROLLBACK");
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>Add New Category</h3>
            <hr>

            <div class="form-group">
                <label for="category_name">Category Name</label>
                <input type="text" class="form-control" name="category_name" id="category_name" placeholder="Enter category name">
            </div>

            <div class="form-group">
                <label for="hsn_code">Hsn Code</label>
                <input type="number" class="form-control" name="hsn_code" id="hsn_code" placeholder="Enter hsn-code">
            </div>

            <div class="form-group">
                <label for="gst_rate">GST Rate</label>
                <input type="number" class="form-control" name="gst_rate" id="gst_rate" placeholder="Enter GST rate">
            </div>
            <button type="submit" name="add_category" id="add_category" class="btn btn-primary">Add Category</button>
        </form>
    </div>
</div>
