<?php
if(isset($_POST['add_product']))
{
    require_once ('db/models/Product.class.php');
    $product = new Product();
    $product->product_name = $_POST['product_name'];
    $product->product_quantity = $_POST['product_quantity'];
    $product->additional_specifications = $_POST['additional_specifications'];
    echo $product->insert();
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
                <label for="product_cat_name">Category Name</label>
                <select name="category_id" id="category_id" class="form-control">
                    <option value="0">Select Category Name</option>
                </select>
            </div>

            <button type="submit" name="add_product" id="add_product" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>