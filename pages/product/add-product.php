
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="" role="form" enctype="multipart/form-data">
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
                <textarea class="form-control" id="product_add_specification" name="product_add_specification" placeholder="Enter additonal specification"></textarea>
            </div>


            <div class="form-group">
                <label for="product_cat_name">Category Name</label>
                <select name="product_cat_name" id="product_cat_name" class="form-control">
                    <option value="0">Select Category Name</option>
                </select>
            </div>

            <button type="submit" name="add_product" id="add_product" class="btn btn-primary">Add Product</button>
        </form>
    </div>
</div>