<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion print-hidden" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3 text-left">Sakshi Jewellers</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Inventory
    </div>


    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
           aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>Category</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item ajax-link" href="categories.php?src=add-category">Add category</a>
                <a class="collapse-item ajax-link" href="categories.php?src=view-all-categories">View All Categories</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseProducts"
           aria-expanded="true" aria-controls="collapseProducts">
            <i class="fas fa-fw fa-ring"></i>
            <span>Product</span>
        </a>
        <div id="collapseProducts" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item ajax-link" href="products.php?src=add-product">Add product</a>
                <a class="collapse-item ajax-link" href="products.php?src=view-all-products">View All Products</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvoice"
           aria-expanded="true" aria-controls="collapseInvoice">
            <i class="fas fa-fw fa-money-bill-alt"></i>
            <span>Invoice</span>
        </a>
        <div id="collapseInvoice" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item ajax-link" href="invoices.php?src=add-invoice">Create Invoice</a>
                <a class="collapse-item ajax-link" href="invoices.php?src=view-all-invoices">View All Invoices</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <!--    <li class="nav-item">-->
    <!--        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePayment" aria-expanded="true" aria-controls="collapsePayment">-->
    <!--            <i class="fas fa-fw fa-money-bill-wave"></i>-->
    <!--            <span>Udhaari</span>-->
    <!--        </a>-->
    <!--        <div id="collapsePayment" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">-->
    <!--            <div class="bg-white py-2 collapse-inner rounded">-->
    <!--                <a class="collapse-item ajax-link" href="udhaari.php?src=add-udhaari">Create Udhaari</a>-->
    <!--                <a class="collapse-item ajax-link" href="udhaari.php?src=view-all-udhaaris">View All Udhaari</a>-->
    <!--                <a class="collapse-item ajax-link" href="payments.php?src=view-all-payments&p-of=udhaari">View Udhaari Payments</a>-->
    <!--            </div>-->
    <!--        </div>-->
    <!--    </li>-->
    <?php
    if (isset($_SESSION['user_id'])) {
        ?>
        <li class="nav-item">
            <a class="nav-link" href="udhaari-dashboard.php">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>Udhaari</span></a>
        </li>
        <?php
    }
    ?>


    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCustomer"
           aria-expanded="true" aria-controls="collapseCustomer">
            <i class="fas fa-fw fa-user-friends"></i>
            <span>Customer</span>
        </a>
        <div id="collapseCustomer" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item ajax-link" href="customers.php?src=add-customer">Add Customer</a>
                <a class="collapse-item ajax-link" href="customers.php?src=view-all-customers">View All Customers</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Settings
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGST" aria-expanded="true"
           aria-controls="collapseGST">
            <i class="fas fa-fw fa-user"></i>
            <span>GST Entries</span>
        </a>
        <div id="collapseGST" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item ajax-link" href="gst.php?src=add-gst">Add GST entry</a>
                <a class="collapse-item ajax-link" href="gst.php?src=view-all-gst">View All GST entries</a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->