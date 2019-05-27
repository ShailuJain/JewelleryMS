<div class="col-xl-8 col-lg-7">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Top 5 Customers - Pending</h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">Actions:</div>
                    <a class="dropdown-item" href="<?php require_once ('helpers/redirect-constants.php'); echo VIEW_ALL_INVOICES; ?>">View All</a>
                </div>
            </div>
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