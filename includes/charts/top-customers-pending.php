<div class="col-md-10 offset-1">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-danger">Pending customers - Due date passed</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <?php
                require_once ('helpers/get-pending-customers.php');
                echo getPendingAmountCustomersHtml();
            ?>
        </div>
    </div>
</div>
<div class="col-md-10 offset-1">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Customers pending amount - Upcoming udhaaris</h6>
        </div>
        <!-- Card Body -->
        <div class="card-body">
            <?php
            require_once ('helpers/get-pending-customers.php');
            echo getPendingAmountCustomersHtml();
            ?>
        </div>
    </div>
</div>