<button class='btn btn-primary add-product float-right' role='button' type='button'><i class='fa fa-plus'></i></button>
<h3>Product details</h3>
<hr>
<div id=list-of-products>
</div>
<?php
    if(isset($script_var)){
        echo<<<SCRIPT
<script>
    var defaultEntries = {$script_var};
</script>
SCRIPT;
    }
    echo "<script>
    let page = 'invoice';
    var label_texts = [
        \"Select Category\",
        \"Select Product\",
        \"Select Quantity in gm's\",
        \"Select Rate for category\",
        \"Making charges per gm\",
    ];
</script>"
?>
<script src=js/add-product-details.js></script>