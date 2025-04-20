<?php 
include 'db/db_con.php';
session_start();

$sql = "SELECT * FROM products";
$result = $con->query($sql);

// ADD PRODUCT
if ($con) {
    if (isset($_POST['add_prod'])) {
        $prod_code = mysqli_real_escape_string($con, $_POST['prod_code']);
        $category_name = mysqli_real_escape_string($con, $_POST['category']);
        $brand_name = mysqli_real_escape_string($con, $_POST['brand']);
        $Product_name = mysqli_real_escape_string($con, $_POST['Product_name']);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    
        if (empty($prod_code) || empty($category_name) || empty($brand_name) || empty($Product_name) || empty($price) || empty($quantity)) {
            $_SESSION['alert-fail'] = "All fields are required.";
            header("Location: Stock.php");
            exit(0);
        }
    
        $check_product_sql = "SELECT * FROM products WHERE prod_code = '$prod_code'";
        $check_code_result = $con->query($check_product_sql);
    
        if ($check_code_result->num_rows > 0) {
            $_SESSION['alert-fail'] = "Product already exists.";
            header("Location: Stock.php");
            exit(0);
        } else {
            $get_category_id_sql = "SELECT id FROM categories WHERE category_name = '$category_name'";
            $category_id_result = $con->query($get_category_id_sql);
    
            if ($category_id_result->num_rows > 0) {
                $row_category = $category_id_result->fetch_assoc();
                $category_id = $row_category['id'];
    
                $get_brand_id_sql = "SELECT id FROM brands WHERE brand_name = '$brand_name'";
                $brand_id_result = $con->query($get_brand_id_sql);
    
                if ($brand_id_result->num_rows > 0) {
                    $row_brand = $brand_id_result->fetch_assoc();
                    $brand_id = $row_brand['id'];
                    $sql_products = "INSERT INTO products (prod_code, category_id, brand_id, name, price, quantity) 
                                     VALUES ('$prod_code', '$category_id', '$brand_id', '$Product_name', '$price', '$quantity')";
    
                    $try_query = mysqli_query($con, $sql_products);
    
                    if ($try_query) {
                        $_SESSION['message'] = "product added.";
                        header("Location: Stock.php");
                        exit(0);
                    } else {
                        $_SESSION['alert-fail'] = "Error adding product.";
                        header("Location: Stock.php");
                        exit(0);
                    }
                } else {
                    $_SESSION['alert-fail'] = "Brand not found.";
                    header("Location: Stock.php");
                    exit(0);
                }
            } else {
                $_SESSION['alert-fail'] = "Category not found.";
                header("Location: Stock.php");
                exit(0);
            }
        }
    }
}

// EDIT PRODUCT
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['submit_edit'])) {
        $prod_id      = $_POST['prod_id'];
        $prod_code    = $_POST['prod_code'];
        $Product_name = $_POST['Product_name'];
        $price        = $_POST['price'];
        $quantity     = $_POST['quantity'];

        $check_user_sql   = "SELECT * FROM products WHERE prod_code = '$prod_code'";
        $check_user_result = $con->query($check_user_sql);

            $sql = "UPDATE products 
                    SET prod_code='$prod_code', name='$Product_name', price='$price', quantity='$quantity' 
                    WHERE prod_id = $prod_id";

            if ($con->query($sql) === TRUE) {
                $_SESSION['message'] = "Product successfully edited.";
                header("Location: Stock.php");
                exit(0);
            } else {
                $_SESSION['alert-fail'] = "Error editing product.";
                header("Location: Stock.php");
                exit(0);
            }
    }
} elseif (isset($_GET['id'])) {
    // POPULATE EDIT FORM
    $prod_id   = $_GET['id'];
    $sql_edit  = "SELECT * FROM products WHERE prod_id = $prod_id";
    $result_edit = $con->query($sql_edit);

    if ($result_edit->num_rows == 1) {
        $row = $result_edit->fetch_assoc();
    } else {
        echo "Product not found";
    }
}
//DELETE
if (isset($_POST['prod_id'])) {
    $item_id = mysqli_real_escape_string($con, $_POST['prod_id']);

    $sql = "DELETE FROM products WHERE prod_id = $item_id";
    $delete_query = mysqli_query($con, $sql);

    if ($delete_query) {
        $_SESSION['message'] = " Product deleted successfully";
        header("Location: Stock.php");
        exit(0);
    } else {
        $_SESSION['alert-fail'] = "Error deleting product";
        header("Location: Stock.php");
        exit(0);
    }
}

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
    <title>Stock</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,300,400,600,700,800,900" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">

    <!-- ADD MODAL -->
    <div class="modal fade" id="prod_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_add_prod">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Stock.php" method="POST">
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
                    <form action="Stock.php" method="POST">
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
                    <form method="POST" action="Stock.php">
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
                    <span>Dashboard</span>
                </a>
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
                <a class="nav-link" href="Cashier.php">
                    <i class="fas fa-solid fa-users"></i>
                    <span>Cashier</span>
                </a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="Stock.php">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Stock</span>
                </a>
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
                    <h1 class="h3 mb-2 text-gray-800">Manage Products</h1>
                    <hr>
                    <button type="button" class="btn btn-add mt-1 mb-1" style="background-color: #00246B; color:#ffffff;" 
                            data-bs-toggle="modal" data-bs-target="#prod_modal">
                        Add Product
                    </button>
                    <hr>
                    <div class="row justify-content-center">
                        <div class="col-xl-4 col-lg-5">
                            <?php include('alert_success.php'); ?>
                            <?php include('alert_fail.php'); ?>
                        </div>
                        <!-- Table -->
                        <div class="col-xl-12 col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">Products</h6>
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
                </div>
                <!-- End of Main Content -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
        <!-- End of Page Wrapper -->

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" 
            integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" 
            crossorigin="anonymous"></script>

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

    <script src="bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
