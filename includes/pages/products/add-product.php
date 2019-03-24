<?php
require_once ('db/models/Product.class.php');
require_once ('db/models/Category.class.php');
if(isset($_POST['add_product']))
{
    try
    {
        $arr = $_POST;
        unset($arr['add_product']);
        $arrKeys = array_keys($arr);

        //creating a new product object and adding the fields.
        $product = new Product();

        //finding category object
        $category = Category::find("category_id = {$arr['category_id']}");

        foreach ($arrKeys as $item) {
            $product->$item = $arr[$item];
        }

//        $product->insert();
    }catch (Exception $ex)
    {
        print_r($ex);
    }
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>Add New Product</h3>
            <hr>
            <div class="form-group">
                <label for="category_id">Category Name</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category Name</option>
                    <?php
                    $result = CRUD::select("categories");
                    foreach ($result as $cat){
                        echo "<option value='$cat->category_id'>$cat->category_name</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter name of product" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="product_quantity">Opening Stock</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="product_quantity" id="product_quantity" placeholder="Enter opening stock of product" aria-describedby="per-gm" required min="0">
                        <div class="input-group-append">
                            <span class="input-group-text" id="per-gm">gm's</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="product_add_specification">Additional Specification (Max. 250 chars)</label>
                <textarea class="form-control" id="additional_specifications" name="additional_specifications" placeholder="Enter additional specification" maxlength="250"></textarea>
            </div>

            <button type="submit" name="add_product" id="add_product" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>