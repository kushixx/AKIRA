<?php 
include 'db/dbconnect.php';
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

    <title>Users</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

</head>

<body id="page-top">

    <!-- ADD MODAL -->
    <div class="modal fade" id="add_stock" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_add_prod">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Product.php" method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="prod_id" name="prod_id" hidden>
                            <label for="prod_code" class="form-label">Product code:</label>
                            <input type="text" class="form-control" id="prod_code" min="18" name="prod_code" required>
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category:</label>
                            <input type="text" class="form-control" id="category" name="category" list="categoryList" required>
                            <datalist id="categoryList">
                                <?php
                                $sqlCategories = "SELECT category_name FROM categories";
                                $resultCategories = $con->query($sqlCategories);

                                if ($resultCategories->num_rows > 0) {
                                    while ($rowCategory = $resultCategories->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($rowCategory['category_name']) . '">';
                                    }
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand:</label>
                            <input type="text" class="form-control" id="brand" name="brand" list="brandList" required>
                            <datalist id="brandList">
                                <?php
                                $sqlBrands = "SELECT brand_name FROM brands";
                                $resultBrands = $con->query($sqlBrands);

                                if ($resultBrands->num_rows > 0) {
                                    while ($rowBrand = $resultBrands->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($rowBrand['brand_name']) . '">';
                                    }
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="prod_name" class="form-label">Product name:</label>
                            <input type="text" class="form-control" id="Product_name" name="Product_name" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price:</label>
                            <input type="number" class="form-control" id="price" name="price" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity:</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="add_prod" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
                                
    <!-- EDIT MODAL -->
    <div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Product.php" method="POST">
                        <input type="hidden" id="edit_id" name="prod_id">
                        <div class="mb-3">
                            <label for="edit_code" class="form-label">Product Code:</label>
                            <input type="text" class="form-control" id="edit_code" name="prod_code">
                        </div>
                        <div class="mb-3">
                            <label for="category" class="form-label">Category:</label>
                            <input type="text" class="form-control" id="category" name="category" list="categoryList" required>
                            <datalist id="categoryList">
                                <?php
                                // Assuming $con is your database connection
                                $sqlCategories = "SELECT category_name FROM categories";
                                $resultCategories = $con->query($sqlCategories);

                                if ($resultCategories->num_rows > 0) {
                                    while ($rowCategory = $resultCategories->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($rowCategory['category_name']) . '">';
                                    }
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="brand" class="form-label">Brand:</label>
                            <input type="text" class="form-control" id="brand" name="brand" list="brandList" required>
                            <datalist id="brandList">
                                <?php
                                // Assuming $con is your database connection
                                $sqlBrands = "SELECT brand_name FROM brands";
                                $resultBrands = $con->query($sqlBrands);

                                if ($resultBrands->num_rows > 0) {
                                    while ($rowBrand = $resultBrands->fetch_assoc()) {
                                        echo '<option value="' . htmlspecialchars($rowBrand['brand_name']) . '">';
                                    }
                                }
                                ?>
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="edit_name" class="form-label">Product Name:</label>
                            <input type="text" class="form-control" id="edit_name" name="Product_name">
                        </div>
                        <div class="mb-3">
                            <label for="edit_price" class="form-label">Price:</label>
                            <input type="number" class="form-control" id="edit_price" name="price">
                        </div>
                        <div class="mb-3">
                            <label for="edit_quantity" class="form-label">Quantity:</label>
                            <input type="number" class="form-control" id="edit_quantity" name="quantity">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="submit_edit" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- JAVASCRIPT TO POPULATE EDIT MODAL -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('modal_edit');

        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget; // Button that triggered the modal

            // Extract values from button data attributes
            var prodId = button.getAttribute('data-id');
            var prodCode = button.getAttribute('data-code');
            var prodName = button.getAttribute('data-cat');
            var prodName = button.getAttribute('data-brand');
            var prodName = button.getAttribute('data-name');
            var prodPrice = button.getAttribute('data-price');
            var prodQuantity = button.getAttribute('data-quantity');

            // Fill modal inputs
            editModal.querySelector('#edit_id').value = prodId;
            editModal.querySelector('#edit_code').value = prodCode;
            editModal.querySelector('#edit_cat').value = prodCode;
            editModal.querySelector('#edit_brand').value = prodName;
            editModal.querySelector('#edit_name').value = prodName;
            editModal.querySelector('#edit_price').value = prodPrice;
            editModal.querySelector('#edit_quantity').value = prodQuantity;
        });
    });
    </script>

        
    <!-- DELETE MODAL -->
    <div class="modal fade" id="modal_delete" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="Product.php">
                        <input type="hidden" id="delete_id" name="prod_id" value="">
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- ADD ID TO DELETE MODAL -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var deleteModal = document.getElementById('modal_delete');
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget; // Button that triggered the modal
                    var prodId = button.getAttribute('data-prod-id'); // Extract info from data-* attributes
                    var modalInput = deleteModal.querySelector('#delete_id'); // Find the input in the modal
                    modalInput.value = prodId; // Update the input's value
                });
            });
        </script>
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php
            ">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="sidebar-brand-text mx-3">AKIRASAN</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item ">
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
                        <a class="collapse-item" href="Record.php">Category/Brand</a>
                        <a class="collapse-item" href="Product.php">Product</a>
                        <a class="collapse-item" href="User.php">User</a>
                    </div>
                </div>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="cashier.php">
                    <i class="fas fa-solid fa-users"></i>
                    <span>Cashier</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseInvent"
                    aria-expanded="true" aria-controls="collapseRecord">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Inventory</span>
                </a>
                <div id="collapseInvent" class="collapse show"  aria-labelledby="headingInvent" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item active" href="ProductManagement.php">Product Management</a>
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
                <?php include('topbar.php');?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 m-0 mb-2 text-gray-800">STOCK IN</h1>
                    <hr>
                    <!-- ALERTS ROW -->
                    <div class="row">
                        
                    </div>

                    <!-- TABLES -->
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-lg-5">
                            <?php include('alert_success.php'); ?>
                            <?php include('alert_fail.php'); ?>
                        </div>
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <button type="button" class="btn btn-add mt-1 mb-1" style="background-color: #00246B; color:#ffffff;"
                                        data-bs-toggle="modal" data-bs-target="#add_stock">
                                        Add stock
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Code</th>
                                                    <th>Category</th>
                                                    <th>Brand</th>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Code</th>
                                                    <th>Category</th>
                                                    <th>Brand</th>
                                                    <th>Product</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                            <?php
                                                if ($result->num_rows > 0) {
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr class='text-center text-uppercase'>";
                                                        echo "<td>" . $row["prod_id"] . "</td>";
                                                        echo "<td>" . $row["prod_code"] . "</td>";
                                                        echo "<td>" . $row["category_id"] . "</td>";
                                                        echo "<td>" . $row["brand_id"] . "</td>";
                                                        echo "<td>" . $row["name"] . "</td>";
                                                        echo "<td>" . $row["price"] . "</td>";
                                                        echo "<td>" . $row["quantity"] . "</td>";
                                                        echo "<td>
                                                                <button class='btn btn-primary edit-btn btn-sm' 
                                                                    data-id='" . $row["prod_id"] . "' 
                                                                    data-code='" . $row["prod_code"] . "' 
                                                                    data-cat='" . $row["category_id"] . "'
                                                                    data-brand='" . $row["brand_id"] . "' 
                                                                    data-name='" . $row["name"] . "' 
                                                                    data-price='" . $row["price"] . "' 
                                                                    data-quantity='" . $row["quantity"] . "'
                                                                    data-bs-toggle='modal' 
                                                                    data-bs-target='#modal_edit'>
                                                                    EDIT
                                                                </button>
                                                                <button class='btn btn-danger btn-sm' data-bs-toggle='modal'data-bs-target='#modal_delete'
                                                                data-prod-id='{$row['prod_id']}'>DELETE</button>
                                                            </td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6'>No records found</td></tr>";
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                    <!-- END TABLES -->
                </div>
                <!-- /.container-fluid -->

            </div>

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

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

</body>

</html>