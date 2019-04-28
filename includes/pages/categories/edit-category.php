<?php
require_once('db/models/Category.class.php');
require_once('db/models/GST.class.php');
require_once 'constants.php';
require_once ('helpers/redirect-helper.php');
if(isset($_POST[EDIT_CATEGORY])){
    try{
        if(!empty($_POST['category_name']) && !empty($_POST['hsn_code'])){

            $category = new Category();
            $category->category_name = $_POST['category_name'];
            $hsn_code = $_POST['hsn_code'];
            $result = CRUD::query("SELECT * FROM gst WHERE hsn_code = ? AND deleted = 0 ORDER BY wef DESC",$hsn_code);
            if($result){
                $gst = $result->fetch();
                $category->gst_id = $gst->gst_id;
                if($category->insert()){
                    setStatusAndMsg("success","Category added successfully");
                }else{
                    setStatusAndMsg("error","Category already exists");
                }
            }else {
                setStatusAndMsg("error", "Something went wrong");
            }
        }
        else{
            setStatusAndMsg("error","Enter valid details");
        }
    } catch(Exception $e){
        setStatusAndMsg("error", "Something went wrong");
    }
}
if(isset($id)) {
    $cat_to_edit = Category::find("category_id = ?",$id);
    ?>
    <div class="row">
        <div class="offset-1 col-md-10">
            <form action="" method="post" role="form" enctype="multipart/form-data">
                <h3>Edit Category</h3>
                <hr>

                <div class="form-group">
                    <label for="category_name" data-toggle="tooltip" data-placement="right" title="" >Category Name <i class="fa fa-question-circle"></i></label>
                    <input type="text" class="form-control" name="category_name" id="category_name"
                           placeholder="Enter category name" value="<?php echo $cat_to_edit->category_name; ?>">
                </div>

                <div class="form-group">
                    <label for="hsn_code" data-toggle="tooltip" data-placement="right" title="" >HSN Code <i class="fa fa-question-circle"></i></label>
                    <select name="hsn_code" id="hsn_code" class="form-control" required>
                        <option value="">Select HSN Code</option>
                        <?php
                        $result = GST::viewAll();
                        foreach ($result as $hsn) {
                            $selected = "";
                            if($cat_to_edit->gst_id == $hsn->gst_id)
                                $selected = "selected";
                            echo "<option value='$hsn->hsn_code' $selected>$hsn->hsn_code</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" name="add_category" id="add_category" class="btn btn-primary">Add Category
                </button>
            </form>
        </div>
    </div>
    <?php
}
    ?>