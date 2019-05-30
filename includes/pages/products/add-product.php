<?php
require_once ('db/models/Product.class.php');
require_once ('db/models/Category.class.php');
require_once 'constants.php';
require_once ('helpers/redirect-helper.php');
if(isset($_POST[ADD_PRODUCT])){
    try
    {
        $arr = $_POST;
        unset($arr[ADD_PRODUCT]);
        $arrKeys = array_keys($arr);

        //creating a new product object and adding the fields.
        $product = new Product();

        //finding category object
        $category = Category::find("category_id = ?", $arr['category_id']);
        if($category){
            foreach ($arrKeys as $item) {
                $product->$item = $arr[$item];
            }
            if($product->insert()){
                setStatusAndMsg("success","Product added successfully");
            }
            else{
                setStatusAndMsg("error","Product already exists");
            }
        }else{
            setStatusAndMsg("error","Category do not exists");
        }
    }catch (Exception $ex){
        setStatusAndMsg("error","Something went wrong");
    }
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form id="form" action="" method="post" role="form" enctype="multipart/form-data">
            <h3>Add New Product<span class="float-right"><a href="<?php require_once ('helpers/redirect-constants.php'); echo VIEW_ALL_PRODUCTS; ?>" class='btn btn-info text-white'>View All Products <i class='fa fa-eye'></i></a></span></h3>
            <hr>
            <div class="form-group">
                <label for="category_id" data-toggle="tooltip" data-placement="right" title="" >Category Name <i class="fa fa-question-circle"></i></label>
                <select name="category_id" id="category_id" class="form-control selectize" required>
                    <option value="">Select Category Name</option>
                    <?php
                    $result = Category::select();
                    foreach ($result as $cat){
                        echo "<option value='$cat->category_id'>$cat->category_name</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="product_name" data-toggle="tooltip" data-placement="right" title="" >Product Name <i class="fa fa-question-circle"></i></label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter name of product" required maxlength="150" pattern="^[a-zA-z][a-zA-Z0-9 \(\)]*$" title="Product name is not valid">
                </div>
                <div class="form-group col-md-6">
                    <label for="product_quantity" data-toggle="tooltip" data-placement="right" title="" >Opening Stock <i class="fa fa-question-circle"></i></label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="product_quantity" id="product_quantity" placeholder="Enter opening stock of product" aria-describedby="per-gm" required min="0" step="any">
                        <div class="input-group-append">
                            <span class="input-group-text" id="per-gm">gm's</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="additional_specifications" data-toggle="tooltip" data-placement="right" title="" >Additional Specification (Max. 250 chars) <i class="fa fa-question-circle"></i></label>
                <textarea class="form-control" id="additional_specifications" name="additional_specifications" placeholder="Enter additional specification" maxlength="250"></textarea>
            </div>

            <button type="submit" name="<?php echo ADD_PRODUCT; ?>" id="<?php echo ADD_PRODUCT; ?>" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>