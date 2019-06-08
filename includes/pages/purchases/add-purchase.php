<?php
require_once ('db/models/Purchase.class.php');
require_once ('db/models/Product.class.php');
require_once ('db/models/Category.class.php');
    require_once 'constants.php';
    require_once ('helpers/redirect-helper.php');
    if(isset($_POST[ADD_PURCHASE])){
        try
        {
            //data to be inserted in purchase table
            $purchase = new Purchase();
            $purchase->supplier_detail = $_POST['supplier_detail'];
            $purchase->purchase_no = $_POST['purchase_no'];
            $purchase->date_of_purchase = $_POST['date_of_purchase'];
            $purchase->purchase_rate = $_POST['purchase_rate'];
            $purchase->purchase_quantity = $_POST['purchase_quantity'];
            $purchase->total_purchase_amount = $_POST['total_purchase_amount'];

            //inserting in purchase table
            if($purchase->insert())
            {
                setStatusAndMsg("success","Purchase created successfully");
            }else{
                setStatusAndMsg("error","Purchase cannot be created");
            }
        }catch (Exception $ex){
            setStatusAndMsg("error","Something went wrong : ".$ex);
        }
    }
try{
    $pur_no_res = CRUD::query("SELECT purchase_id FROM purchases ORDER BY purchase_id DESC LIMIT 1");
    if($pur_no_res->rowCount() > 0){
        $pur_no = $pur_no_res->fetch()->purchase_id;
    }else{
        $pur_no = 0;
    }
}catch (Exception $e){
        $pur_no = 0;
}
?>
<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="post" role="form" enctype="multipart/form-data">
            <h3>New Purchase - Purchase details<span class="float-right print-hidden"><a href="<?php require_once ('helpers/redirect-constants.php'); echo VIEW_ALL_PURCHASES; ?>" class='btn btn-info text-white'>View All Purchases <i class='fa fa-eye'></i></a></span></h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="purchase_no" data-toggle="tooltip" data-placement="right" title="" >Purchase No <i class="fa fa-question-circle"></i></label>
                    <input type="text" class="form-control" name="purchase_no" id="purchase_no" min="0" placeholder="Enter Purchase no" value="PURSJ-<?php echo $pur_no+1; ?>">
                </div>
                <div class="form-group col-md-6">
                    <label for="date_of_purchase" data-toggle="tooltip" data-placement="right" title="" >Date Of Purchase <i class="fa fa-question-circle"></i></label>
                    <input type="date" class="form-control" name="date_of_purchase" id="date_of_purchase" required value="<?php echo date('Y-m-d'); ?>">
                </div>

            </div>
            <h3>Supplier details</h3>
            <hr>
            <div class="form-group">
                <label for="supplier_detail" data-toggle="tooltip" data-placement="right" title="" >Supplier Detail <i class="fa fa-question-circle"></i></label>
                <input name="supplier_detail" id="supplier_detail" class="form-control supplier" required placeholder="Enter supplier detail">
            </div>

            <h3>Product details</h3>
            <hr>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="purchase_quantity" data-toggle="tooltip" data-placement="right" title="" >Product Quantity <i class="fa fa-question-circle"></i></label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="purchase_quantity" id="purchase_quantity" placeholder="Enter product quantity" aria-describedby="per-gm" required step="any">
                        <div class="input-group-append">
                            <span class="input-group-text" id="per-gm">gm's</span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="purchase_rate" data-toggle="tooltip" data-placement="right" title="" >Product Rate <i class="fa fa-question-circle"></i></label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="purchase_rate" id="purchase_rate" placeholder="Enter rate of purchase" aria-describedby="rs" required step="any">
                        <div class="input-group-append">
                            <span class="input-group-text" id="rs">&#8377;</span>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="total_purchase_amount" data-toggle="tooltip" data-placement="right" title="" >Total Amount <i class="fa fa-question-circle"></i></label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="total_purchase_amount" id="total_purchase_amount" placeholder="Enter total purchase amount" aria-describedby="rs" required step="any">
                        <div class="input-group-append">
                            <span class="input-group-text" id="rs">&#8377;</span>
                        </div>
                    </div>
                </div>
            </div>
            <button type="submit" name="add_purchase" id="add_purchase" class="btn btn-primary">Add Purchase</button>
        </form>
    </div>
</div>