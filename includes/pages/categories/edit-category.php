<?php
require_once('db/models/Category.class.php');
require_once('db/models/GST.class.php');
require_once 'constants.php';
require_once ('helpers/redirect-helper.php');
if(isset($_POST[EDIT_CATEGORY])){
    try{
        if(!empty($_POST['category_name'])){

            $category = new Category();
            $category->category_id = $_POST['category_id'];
            $category->category_name = $_POST['category_name'];
            if($category->update()){
                redirect_to(VIEW_ALL_CATEGORIES);
                setStatusAndMsg("success","Category updated successfully");
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
                           placeholder="Enter category name" value="<?php echo $cat_to_edit->category_name; ?>" required>
                </div>
                <button type="submit" name="edit_category" id="edit_category" class="btn btn-primary">Add Category
                </button>
            </form>
        </div>
    </div>
    <?php
}
    ?>