<div class="row">
    <div class="col-md-12">
        <form action="" method="" role="form" enctype="multipart/form-data">
            <legend>Add New Invoice</legend>
            <hr>
            <div class="form-group">
                <label for="invoice_total_amt">Total Amount</label>
                <input type="number" class="form-control" name="invoice_total_amt" id="invoice_total_amt" placeholder="Enter total amount">
            </div>

            <div class="form-group">
                <label for="invoice_amt_pend">Balance Amt</label>
                <input type="number" class="form-control" name="invoice_amt_pend" id="invoice_amt_pend" placeholder="enter balance amount if any">
            </div>

            <div>
                <label for="invoice_date">Invoice Date</label>
                <input type="date" class="form-control" name="invoice_date" id="invoice_date">
            </div>

            <div class="form-group">
                <label for="invoice_cat_name">Category Name</label>
                <select name="invoice_cat_name" id="invoice_cat_name" class="form-control">
                    <option value="0">Select Category Name</option>
                </select>
            </div>


            <button type="submit" name="add_invoice" id="add_invoice" class="btn btn-primary">Add Invoice</button>
        </form>
    </div>
</div>
