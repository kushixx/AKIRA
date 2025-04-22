        <?php
        
        include 'db/db_con.php';
        session_start();
        $sql = "SELECT * FROM products";
        $result_prod = $con->query($sql);
        
        $sql_brand = "SELECT * FROM brands";
        $result_brand = $con->query($sql_brand);

        $sql_cat = "SELECT * FROM categories";
        $result_category = $con->query($sql_cat);

        //ADD Category
        if (isset($_POST['add_category'])) {
            $category_name = mysqli_real_escape_string($con, $_POST['category_name']);

            if (empty($category_name)) {
                $_SESSION['alert-fail-cat'] = "All fields are required.";
                header("Location: Record.php");
                exit(0);
            }

            $check_category_sql = "SELECT * FROM categories WHERE category_name = '$category_name'";
            $check_cat_result = $con->query($check_category_sql);
            if ($check_cat_result->num_rows > 0) {
                $_SESSION['alert-fail-cat'] = "Category already exists.";
                header("Location: record.php");
                exit(0);
            } else {
                $sql_cat = "INSERT INTO categories (category_name) 
                                    VALUES ('$category_name')";

                $try_query = mysqli_query($con, $sql_cat);
                if ($try_query) {
                    $_SESSION['alert-success-cat'] = "Category added.";
                    header("Location: record.php");
                    exit(0);
                } else {
                    $_SESSION['alert-fail-cat'] = "Error adding category.";
                    header("Location: record.php");
                    exit(0);
                }
            }
        }
        //EDIT CATEGORY
        if (isset($_POST['submit_edit_cat'])) {
            $id = mysqli_real_escape_string($con, $_POST['id']);
            $category_name = mysqli_real_escape_string($con, $_POST['category_name']);
        
            if (empty($category_name)) {
                $_SESSION['alert-fail-cat'] = "Category name is required.";
                header("Location: record.php"); 
                exit(0);
            }

            $sql_update_category = "UPDATE categories SET category_name = '$category_name' WHERE id = $id";
            $try_update_category_query = mysqli_query($con, $sql_update_category);
        
            if ($try_update_category_query) {
                $_SESSION['alert-success-cat'] = "Category updated successfully.";
                header("Location: record.php");
                exit(0);
            } else {
                $_SESSION['alert-fail-cat'] = "Error updating category.";
                header("Location: record.php");
                exit(0);
            }
        }
        //DELETE CATEGORY
        if (isset($_POST['cat_id'])) {
            $cat_id = mysqli_real_escape_string($con, $_POST['cat_id']);

            $sql = "DELETE FROM categories WHERE id = $cat_id";
            $delete_query = mysqli_query($con, $sql);

            if ($delete_query) {
                $_SESSION['alert-success-cat'] = "Category deleted successfully";
                header("Location: record.php");
                exit(0);
            } else {
                $_SESSION['alert-fail-cat'] = "Error deleting category";
                header("Location: record.php");
                exit(0);
            }
        }
        
        //ADD BRAND
        if (isset($_POST['add_brand'])) {
            $brand_name = mysqli_real_escape_string($con, $_POST['brand_name']);

            if (empty($brand_name)) {
                $_SESSION['alert-fail-brand'] = "All fields are required.";
                header("Location: Record.php");
                exit(0);
            }

            $check_brand_sql = "SELECT * FROM brands WHERE brand_name = '$brand_name'";
            $check_brand_result = $con->query($check_brand_sql);
            if ($check_brand_result->num_rows > 0) {
                $_SESSION['alert-fail-brand'] = "Brand already exists.";
                header("Location: record.php");
                exit(0);
            } else {
                $sql_brand = "INSERT INTO brands (brand_name) 
                                    VALUES ('$brand_name')";

                $try_query = mysqli_query($con, $sql_brand);
                if ($try_query) {
                    $_SESSION['alert-success-brand'] = "Brand added.";
                    header("Location: record.php");
                    exit(0);
                } else {
                    $_SESSION['alert-fail-brand'] = "Error adding category.";
                    header("Location: record.php");
                    exit(0);
                }
            }
        }
        //EDIT BRAND
        if (isset($_POST['submit_edit_brand'])) {
            $id = mysqli_real_escape_string($con, $_POST['id']);
            $brand_name = mysqli_real_escape_string($con, $_POST['brand']);
        
            if (empty($brand_name)) {
                $_SESSION['alert-fail-brand'] = "Brand name is required.";
                header("Location: record.php"); 
                exit(0);
            }

            $sql_update_brand = "UPDATE brands SET brand_name = '$brand_name' WHERE id = $id";
            $try_update_brand_query = mysqli_query($con, $sql_update_brand);
        
            if ($try_update_brand_query) {
                $_SESSION['alert-success-brand'] = "Brand updated successfully.";
                header("Location: record.php");
                exit(0);
            } else {
                $_SESSION['alert-fail-brand'] = "Error updating brand.";
                header("Location: record.php");
                exit(0);
            }
        }
        //DELETE BRAND
        if (isset($_POST['brand_id'])) {
            $brand_id = mysqli_real_escape_string($con, $_POST['brand_id']);

            $sql = "DELETE FROM brands WHERE id = $brand_id";
            $delete_query = mysqli_query($con, $sql);

            if ($delete_query) {
                $_SESSION['alert-success-brand'] = "Brand deleted successfully";
                header("Location: record.php");
                exit(0);
            } else {
                $_SESSION['alert-fail-brand'] = "Error deleting brand";
                header("Location: record.php");
                exit(0);
            }
        }
        ?>

        <!-- DELETE CATEGORY MODAL -->
        <div class="modal fade" id="modal_delete_cat" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this category? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form method="POST" action="record.php">
                            <input type="hidden" id="delete_id_cat" name="cat_id" value="">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ADD ID TO CATEGORY DELETE MODAL -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var deleteModal = document.getElementById('modal_delete_cat');
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget; // Button that triggered the modal
                    var cat_Id = button.getAttribute('data-cat-id'); // Extract info from data-* attributes
                    var modalInput = deleteModal.querySelector('#delete_id_cat'); // Find the input in the modal
                    modalInput.value = cat_Id; // Update the input's value
                });
            });
        </script>

        <!-- DELETE BRAND MODAL -->
        <div class="modal fade" id="modal_delete_brand" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-light">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this brand? This action cannot be undone.
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <form method="POST" action="record.php">
                            <input type="hidden" id="delete_id_brand" name="brand_id" value="">
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- ADD ID TO BRAND DELETE MODAL -->
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var deleteModal = document.getElementById('modal_delete_brand');
                deleteModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget; // Button that triggered the modal
                    var brand_Id = button.getAttribute('data-brand-id'); // Extract info from data-* attributes
                    var modalInput = deleteModal.querySelector('#delete_id_brand'); // Find the input in the modal
                    modalInput.value = brand_Id; // Update the input's value
                });
            });
        </script>
        

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
    <title>AKIRASAN CONVENIENCE STORE</title>
    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
</head>

<body id="page-top">



    <!-- ADD CAT MODAL -->
    <div class="modal fade" id="modal_cat" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modal_cat" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_add_prod">Add Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Record.php" method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="id" name="category_id" aria-describedby="emailHelp" hidden>
                            <label for="brand" class="form-label">Category:</label>
                            <input type="text" class="form-control" id="category" name="category_name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="add_category" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- ADD BRAND MODAL -->
    <div class="modal fade" id="modal_brand" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_add_prod">Add Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Record.php" method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="id" name="brand_id" aria-describedby="emailHelp" hidden>
                            <label for="brand" class="form-label">Brand:</label>
                            <input type="text" class="form-control" id="brand" min="18" name="brand_name" required>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="add_brand" class="btn btn-success">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- EDIT CAT MODAL -->
    <div class="modal fade" id="modal_edit_cat" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="record.php" method="POST">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="cat_name" class="form-label">Category:</label>
                            <input type="text" class="form-control" id="cat_name" name="category_name">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="submit_edit_cat" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--POPULATE EDIT MODAL CATEGORY -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editModal = document.getElementById('modal_edit_cat');
            editModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var Id = button.getAttribute('data-id');
                var cat = button.getAttribute('data-cat');
                editModal.querySelector('#id').value = Id;
                editModal.querySelector('#cat_name').value = cat;
            });
        });
    </script>

    <!-- EDIT BRAND MODAL -->
    <div class="modal fade" id="modal_edit" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Brand</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="record.php" method="POST">
                        <input type="hidden" id="id" name="id">
                        <div class="mb-3">
                            <label for="brand_name" class="form-label">Brand:</label>
                            <input type="text" class="form-control" id="brand_name" name="brand">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="submit_edit_brand" class="btn btn-primary">Confirm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!--POPULATE EDIT MODAL BRAND -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var editModal = document.getElementById('modal_edit');
            editModal.addEventListener('show.bs.modal', function (event) {
                var button = event.relatedTarget; // Button that triggered the modal
                var Id = button.getAttribute('data-id');
                var brand = button.getAttribute('data-brand');
                editModal.querySelector('#id').value = Id;
                editModal.querySelector('#brand_name').value = brand;
            });
        });
    </script>

    <div id="wrapper">
        <ul class="navbar-nav bg-gradient-dark sidebar sidebar-dark accordion" id="accordionSidebar">
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-store"></i>
                </div>
                <div class="sidebar-brand-text mx-3">AKIRASAN</div>
            </a>

            <hr class="sidebar-divider my-0">

            <li class="nav-item">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Addons
            </div>

            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRecord"
                    aria-expanded="true" aria-controls="collapseRecord">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Record</span>
                </a>
                <div id="collapseRecord" class="collapse show"  aria-labelledby="headingRecord" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item active" href="Record.php">Category/Brand</a>
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

            <hr class="sidebar-divider d-none d-md-block">

            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>
        </ul>


        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <?php include('topbar.php');?>

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <h1 class="h3 m-0 mb-2 text-gray-800">Brand | Category</h1>
                    <hr>
                    <!-- ALERTS ROW -->
                    <div class="row">
                        <div class="col-xl-6 col-lg-5">
                            <div class="alerts d-flex justify-content-center">
                                <?php include('alert_fail_cat.php'); ?>
                                <?php include('alert_success_cat.php'); ?>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-5">
                            <div class="alerts d-flex justify-content-center">
                                <?php include('alert_fail_brand.php'); ?>
                                <?php include('alert_success_brand.php'); ?>
                            </div>
                        </div>
                    </div>

                    <!-- TABLES -->
                    <div class="row">
                        <!-- CAT TABLE -->
                        <div class="col-xl-6 col-lg-12"> 
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <button type="button" class="btn mb-1 btn-add mt-1" style="background-color: #00246B; color:#ffffff;" data-bs-toggle="modal" data-bs-target="#modal_cat">
                                        Record Category
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="categoriesTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">ID</th>
                                                    <th>Category Name</th>
                                                    <th style="width: 150px;">Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Category Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                    if ($result_category->num_rows > 0) {
                                                        while ($row = $result_category->fetch_assoc()) {
                                                            echo "<tr class='text-center text-uppercase'>";
                                                            echo "<td>" . $row["id"] . "</td>";
                                                            echo "<td>" . $row["category_name"] . "</td>";
                                                            echo "<td>
                                                                    <button class='btn btn-primary btn-sm edit-btn'
                                                                            data-id='" . $row["id"] . "'
                                                                            data-cat='" . $row["category_name"] . "'
                                                                            data-bs-toggle='modal'
                                                                            data-bs-target='#modal_edit_cat'>
                                                                        EDIT
                                                                    </button>
                                                                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modal_delete_cat'
                                                                    data-cat-id='{$row['id']}'>DELETE</button>
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
                        <!-- BRAND TABLE -->
                        <div class="col-xl-6 col-lg-12">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <button type="button" class="btn btn-add mt-1 mb-1" style="background-color: #00246B; color:#ffffff;" data-bs-toggle="modal" data-bs-target="#modal_brand">
                                        Record Brand
                                    </button>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="brandsTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th style="width: 50px;">ID</th>
                                                    <th>Brand Name</th>
                                                    <th style="width: 150px;" >Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th>ID</th>
                                                    <th>Brand Name</th>
                                                    <th>Action</th>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                    if ($result_brand->num_rows > 0) {
                                                        while ($row = $result_brand->fetch_assoc()) {
                                                            echo "<tr class='text-center text-uppercase'>";
                                                            echo "<td>" . $row["id"] . "</td>";
                                                            echo "<td>" . $row["brand_name"] . "</td>";
                                                            echo "<td>
                                                                    <button class='btn btn-primary btn-sm edit-btn'
                                                                        data-id='" . $row["id"] . "'
                                                                        data-brand='" . $row["brand_name"] . "'
                                                                        data-bs-toggle='modal'
                                                                        data-bs-target='#modal_edit'>
                                                                        EDIT
                                                                    </button>
                                                                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modal_delete_brand' 
                                                                        data-brand-id='{$row['id']}'>DELETE</button>
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
            </div>
        </div>

        <!-- SCRIPTS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="bootstrap-5.3.3/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
        <script src="js/sb-admin-2.min.js"></script>
        <script src="vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>
        <script src="js/demo/datatables-demo.js"></script>
        <script>
            $(document).ready(function() {
                $('#brandsTable').DataTable();
                $('#categoriesTable').DataTable();
            });
        </script>
    </div>
</body>

</html>
