<div class="container">
    <h1 class="h3 mb-0 text-gray-800">Udhaari Dashboard</h1>
    <hr>
    <?php
    require_once ('db/models/Udhaari.class.php');
        $pending = number_format((float) Udhaari::getTotalPendingUdhaari(), 2);
        if(empty($pending)){
            $pending = 0;
        }
        echo<<<CARD
    <!-- Category quantity card -->
    <div class="offset-4 col-md-4 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Pending Udhaari</div>
                        <div class="quantity-font mb-0 font-weight-bold text-gray-800">&#8377; $pending</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
CARD;
    ?>
</div>
<hr>
<div class="col-md-10 offset-1">
    <div class="row">
        <div class="col-md-4 text-right"><a class="btn btn-info" href="udhaari.php?src=add-udhaari"><i
                        class="fa fa-plus"></i> Create Udhaari</a></div>
        <div class="col-md-4 text-center"><a class="btn btn-info" href="udhaari.php?src=view-all-udhaaris"><i
                        class="fa fa-eye"></i> View All Udhaari</a></div>
        <div class="col-md-4 text-left"><a class="btn btn-info"
                                           href="payments.php?src=view-all-payments&p-of=udhaari"><i
                        class="fa fa-eye"></i> View Payments</a></div>
    </div>
</div>
<hr>
<div class="mb-5"></div>
<?php
require_once('includes/charts/top-customers-pending.php');