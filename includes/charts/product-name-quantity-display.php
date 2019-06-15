<div class="row">
    <?php
        require_once ('db/models/Product.class.php');
        $result = Product::getUniqueProductNameQuantity();
        $count = $result->rowCount();

        for ($i = 0; $i< $count; $i++)
        {
            $row = $result->fetch();
            $quantity = number_format((float) $row->total_quantity, 4);
            if(empty($quantity)){
                $quantity = 0;
            }
            echo<<<CARD
    <!-- Category quantity card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">$row->product_name Quantity</div>
                        <div class="quantity-font mb-0 font-weight-bold text-gray-800">$quantity gm's</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-balance-scale fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
CARD;

        }
    ?>
</div>