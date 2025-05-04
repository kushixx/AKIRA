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
                        <a class="collapse-item" href="User.php">User</a>
                    </div>
                </div>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="Cashier.php">
                    <i class="fas fa-solid fa-users"></i>
                    <span>Cashier</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvent"
                    aria-expanded="true" aria-controls="collapseRecord">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Inventory</span>
                </a>
                <div id="collapseInvent" class="collapse"  aria-labelledby="headingInvent" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="ProductManagement.php">Product Management</a>
                        <a class="collapse-item" href="StockLevel.php">Monitor Stock Level</a>
                        <a class="collapse-item" href="PurchaseOrder.php">Purchase Order</a>
                    </div>
                </div>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
                    aria-expanded="true" aria-controls="collapseRecord">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Reports</span>
                </a>
                <div id="collapseReport" class="collapse"  aria-labelledby="headingInvent" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item" href="SalesReport.php">Sales Report</a>
                        <a class="collapse-item" href="InventoryReport.php">Inventory eport </a>
                        <a class="collapse-item" href="StockLevelReport.php">Stock Level Report</a>
                        <a class="collapse-item" href="PurchaseOrderReport.php">Purchase Order Report</a>
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

        <script>
            document.getElementById('add-item').addEventListener('click', function() {
                var itemDiv = document.createElement('div');
                itemDiv.className = 'form-group item';
                itemDiv.style.border = "1px solid #ddd";
                itemDiv.style.padding = "10px";
                itemDiv.innerHTML = `
                    <div class="input-group" style="margin-top: 10px;">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-th-large"></i>
                        </span>
                        <input type="text" class="form-control" name="item-name[]" placeholder="Item Name">
                    </div>
                    <div class="input-group" style="margin-top: 10px;">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-shopping-cart"></i>
                        </span>
                        <input type="number" class="form-control" name="quantity[]" placeholder="Quantity">
                    </div>
                    <div class="input-group" style="margin-top: 10px;">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-scale"></i>
                        </span>
                        <input type="text" class="form-control" name="unit[]" placeholder="Unit">
                    </div>
                    <div class="input-group" style="margin-top: 10px;">
                        <span class="input-group-addon">
                            <i class="glyphicon glyphicon-usd"></i>
                        </span>
                        <input type="number" step="0.01" class="form-control" name="unit_cost[]" placeholder="Unit Cost">
                    </div>
                    <button type="button" class="btn btn-danger remove-item" style="margin-top: 10px;">Remove</button>
                `;

                document.getElementById('items').appendChild(itemDiv);

                // Add event listener to remove button
                itemDiv.querySelector('.remove-item').addEventListener('click', function() {
                    itemDiv.remove();
                });
            });
            </script>
    </div>
</body>

</html>