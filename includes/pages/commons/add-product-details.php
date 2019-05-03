<button class='btn btn-primary add-product float-right' role='button' type='button'><i class='fa fa-plus'></i></button>
<h3>Product details</h3>
<hr>
<div id=list-of-products>
    <div class="form-row">
        <div class='col-md-3'>
            <label data-toggle='tooltip' data-placement='right' title='' >Select Category <i class='fa fa-question-circle'></i></label>
        </div>

        <div class='form-group col-md-4'>
            <label data-toggle='tooltip' data-placement='right' title='' >Select Product <i class='fa fa-question-circle'></i></label>
        </div>

        <div class='form-group col-md-2'>
            <label data-toggle='tooltip' data-placement='right' title='' >Enter quantity <i class='fa fa-question-circle'></i></label>
        </div>
        <div class='form-group col-md-3'>
            <label for='rate_of_purchase' data-toggle='tooltip' data-placement='right' title='' >Rate of purchase
                <i class='fa fa-question-circle'></i>
            </label>
        </div>
    </div>
</div>
<?php
    if(isset($script_var)){
        echo "<script>var defaultEntries = {$script_var}</script>";
    }
?>
<script src=js/add-product-details.js></script>