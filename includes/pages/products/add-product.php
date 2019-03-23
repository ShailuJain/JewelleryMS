<?php
require_once ('db/models/Product.class.php');
if(isset($_POST['add_product']))
{
    try
    {
        //creating a new product object and adding the fields.
        $product = new Product();
        $product->product_name = $_POST['product_name'];
        $product->product_quantity = $_POST['product_quantity'];
        $product->additional_specifications = $_POST['additional_specifications'];


        $product->insert();
    }catch (Exception $ex)
    {
        print_r($ex);
    }
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <legend>Add New Product</legend>
            <hr>

            <div class="form-group">
                <label for="product_name">Product Name</label>
                <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter name of product">
            </div>

            <div class="form-group">
                <label for="product_quantity">Product Quantity</label>
                <input type="number" class="form-control" name="product_quantity" id="product_quantity" placeholder="Enter quantity of product">
            </div>

            <div class="form-group">
                <label for="product_add_specification">Additional Specification</label>
                <textarea class="form-control" id="additional_specifications" name="additional_specifications" placeholder="Enter additional specification"></textarea>
            </div>


            <div class="form-group">
                <label for="category_id">Category Name</label>
                <select name="category_id" id="category_id" class="form-control" autocomplete="on" type="text">
                    <option value="0">Select Category Name</option>
                    <?php
                        $result = CRUD::select("categories");
                        foreach ($result as $cat){
                            echo "<option value='$cat->category_id'>$cat->category_name</option>";
                        }
                    ?>
                </select>
            </div>

            <button type="submit" name="add_product" id="add_product" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>