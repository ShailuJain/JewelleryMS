<?php
require_once ('db/models/Product.class.php');
require_once ('db/models/Category.class.php');
if(isset($id)){
    $prod_to_edit = Product::find("product_id = ?",$id);
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form id="form" action="process-form.php?form=products/edit" method="post" role="form" enctype="multipart/form-data">
            <h3>Edit Product</h3>
            <hr>
            <div class="form-group">
                <label for="category_id">Category Name</label>
                <select name="category_id" id="category_id" class="form-control" required>
                    <option value="">Select Category Name</option>
                    <?php
                    $result = Category::select();
                    foreach ($result as $cat){
                        if($cat->category_id === $prod_to_edit->category_id)
                            $selected = "selected";
                        else
                            $selected = "";
                        echo "<option value='$cat->category_id' $selected>$cat->category_name</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="product_name">Product Name</label>
                    <input type="text" class="form-control" name="product_name" id="product_name" placeholder="Enter name of product" required maxlength="150" pattern="^[a-zA-z][a-zA-Z0-9 \(\)]*$" title="Product name is not valid" value="<?php echo $prod_to_edit->product_name; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="product_quantity">Adjust Stock</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="product_quantity" id="product_quantity" placeholder="Enter opening stock of product" aria-describedby="per-gm" required min="0" value="<?php echo $prod_to_edit->product_quantity; ?>">
                        <div class="input-group-append">
                            <span class="input-group-text" id="per-gm">gm's</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="additional_specifications">Additional Specification (Max. 250 chars)</label>
                <textarea class="form-control" id="additional_specifications" name="additional_specifications" placeholder="Enter additional specification" maxlength="250"><?php echo $prod_to_edit->additional_specifications; ?></textarea>
            </div>

            <button type="submit" name="add_product" id="add_product" class="btn btn-primary">Edit Product</button>
        </form>
    </div>
</div>
<?php
}
?>