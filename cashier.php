<?php 
include 'db/db_con.php';
session_start();
$sql = "SELECT * FROM products";
$result = $con->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <title>Cashier</title>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="sidebar-brand-text mx-3">AKIRASAN</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Addons
            </div>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRecord"
                    aria-expanded="true" aria-controls="collapseRecord">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Record</span>
                </a>
                <div id="collapseRecord" class="collapse"  aria-labelledby="headingRecord" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item " href="Record.php">Category/Brand</a>
                        <a class="collapse-item" href="Product.php">Product</a>
                        <!-- Add more items here as needed -->
                    </div>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="Cashier.php">
                    <i class="fas fa-solid fa-users"></i>
                    <span>Cashier</span></a>
            </li>

            <li class="nav-item ">
                <a class="nav-link" href="stock.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Stock</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="users.php">
                    <i class="fas fa-solid fa-users"></i>
                    <span>Users</span></a>
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include('topbar.php'); ?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="row ">
                        <div class="col-xl-8 col-lg-12">
                            <div class="cashier-container">
                                <h1>Cashier Interface</h1>
                                <div class="scan-area">
                                    <label for="barcode">Scan Product Barcode:</label>
                                    <input type="text" id="barcode" autofocus placeholder="Scan Barcode..." autocomplete="off">
                                </div>

                                <div id="quantity-container" class="hidden">
                                    <label for="quantity">Enter Quantity:</label>
                                    <input type="number" id="quantity" min="1" value="1">
                                </div>

                                <div id="product-info" class="hidden">
                                    <p>Product: <span id="product-name"></span></p>
                                    <p>Price: $<span id="product-price"></span></p>
                                </div>

                                <div class="actions">
                                    <button id="add-to-cart" class="hidden">Add to Cart</button>
                                </div>

                                <!-- Cart and Checkout Form -->
                                <form action="db/dbconnect.php" method="POST" id="checkout-form">
                                    <div class="cart">
                                        <h2>Shopping Cart</h2>
                                        <table id="cart-table">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Quantity</th>
                                                    <th>Price per Item</th>
                                                    <th>Total Cost</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cart-body">
                                                <!-- Cart items will be dynamically inserted here -->
                                            </tbody>
                                        </table>
                                        <div class="total-cost">
                                            <strong>Total: $<span id="grand-total">0.00</span></strong>
                                        </div>
                                    </div>
                                    <!-- Hidden input to store cart data -->
                                    <input type="hidden" name="cart" id="cart-data">
                                    <button type="submit">Checkout</button>
                                </form>
                            </div>
                        </div>
                        
                        <div class="col-xl-4 col-lg-5">
                            <!-- Calculator -->
                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="js/demo/datatables-demo.js"></script>

        <script src="cashier.js"></script>

    </div>
</body>

</html>