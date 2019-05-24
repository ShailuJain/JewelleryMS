<div class="row">
    <?php
        require_once ('db/models/Category.class.php');
        $result = Category::select();
        $count = min($result->rowCount(), 4);

        for ($i = 0; $i< $count; $i++)
        {
            $cat = $result->fetch();
            $quantity = Category::getTotalQuantity($cat->category_id);
            echo<<<CARD
    <!-- Category quantity card -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">$cat->category_name Quantity</div>
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