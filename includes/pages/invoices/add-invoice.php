<div class="row">
    <div class="offset-1 col-md-10">
        <form action="" method="" role="form" enctype="multipart/form-data">
            <h3>Add New Invoice</h3>
            <hr>
            <div class="form-group">
                <label for="invoice_total_amt" data-toggle="tooltip" data-placement="right" title="" >Total Amount <i class="fa fa-question-circle"></i></label>
                <input type="number" class="form-control" name="invoice_total_amt" id="invoice_total_amt" placeholder="Enter total amount">
            </div>

            <div class="form-group">
                <label for="invoice_amt_pend" data-toggle="tooltip" data-placement="right" title="" >Balance Amt <i class="fa fa-question-circle"></i></label>
                <input type="number" class="form-control" name="invoice_amt_pend" id="invoice_amt_pend" placeholder="enter balance amount if any">
            </div>

            <div>
                <label for="invoice_date" data-toggle="tooltip" data-placement="right" title="" >Invoice Date <i class="fa fa-question-circle"></i></label>
                <input type="date" class="form-control" name="invoice_date" id="invoice_date">
            </div>

            <div class="form-group">
                <label for="invoice_cat_name" data-toggle="tooltip" data-placement="right" title="" >Category Name <i class="fa fa-question-circle"></i></label>
                <select name="invoice_cat_name" id="invoice_cat_name" class="form-control">
                    <option value="0">Select Category Name</option>
                </select>
            </div>


            <button type="submit" name="add_invoice" id="add_invoice" class="btn btn-primary">Add Invoice</button>
        </form>
    </div>
</div>
