<?php
include 'db/db_con.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}
$sql = "SELECT * FROM users";
$result = $con->query($sql);
        
        // ADD PRODUCT
        if ($con) {
            if (isset($_POST['add_user'])) {
                $firstname = mysqli_real_escape_string($con, $_POST['firstname']);
                $lastname = mysqli_real_escape_string($con, $_POST['lastname']);
                $username = mysqli_real_escape_string($con, $_POST['username']);
                $password = mysqli_real_escape_string($con, $_POST['password']);
                $position = mysqli_real_escape_string($con, $_POST['position']);
                $contact = mysqli_real_escape_string($con, $_POST['contact']);
            
                if (empty($firstname) || empty($lastname) || empty($username) || empty($position) || empty($contact)) {
                    $_SESSION['alert-fail'] = "All fields are required.";
                    header("Location: user.php");
                    exit(0);
                }
            
                
                $check_user_sql = "SELECT * FROM users WHERE username = '$username'";
                $check_user_result = $con->query($check_user_sql);
                if ($check_cat_result->num_rows > 0) {
                    $_SESSION['alert-fail-cat'] = "User already exists.";
                    header("Location: user.php");
                    exit(0);
                } else {
                    $sql_user = "INSERT INTO users (firstname,lastname,username,password,position,contact) 
                                        VALUES ('$firstname','$lastname','$username','$password',
                                        '$position','$contact')";

                    $try_query = mysqli_query($con, $sql_user);
                    if ($try_query) {
                        $_SESSION['message'] = "User added.";
                        header("Location: user.php");
                        exit(0);
                    } else {
                        $_SESSION['alert-fail'] = "Error adding user.";
                        header("Location: user.php");
                        exit(0);
                    }
                }
            }
        }
        
        // EDIT PRODUCT
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['submit_edit'])) {

                $userid = $_POST['user_id'];
                $firstname = $_POST['firstname'];
                $lastname = $_POST['lastname'];
                $username = $_POST['username'];
                $password = $_POST['password'];
                $position = $_POST['position'];
                $contact  = $_POST['contact'];

                $check_user_sql   = "SELECT * FROM users WHERE username = '$username'";
                $check_user_result = $con->query($check_user_sql);
        
                    $sql = "UPDATE users 
                            SET firstname='$firstname', lastname='$lastname', username='$username', password='$password', position='$position' , contact='$contact'  
                            WHERE user_id = $userid";
        
                    if ($con->query($sql) === TRUE) {
                        $_SESSION['message'] = "User details successfully edited.";
                        header("Location: user.php");
                        exit(0);
                    } else {
                        $_SESSION['alert-fail'] = "Error editing user details.";
                        header("Location: user.php");
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
        if (isset($_POST['user_id'])) {
            $user_id = mysqli_real_escape_string($con, $_POST['user_id']);
        
            $sql = "DELETE FROM users WHERE user_id = $user_id";
            $delete_query = mysqli_query($con, $sql);
        
            if ($delete_query) {
                $_SESSION['message'] = " User deleted successfully";
                header("Location: user.php");
                exit(0);
            } else {
                $_SESSION['alert-fail'] = "Error deleting user";
                header("Location: user.php");
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
       <div class="modal fade" id="user_add_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" 
        aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-light">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_add_prod">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="user.php" method="POST">
                        <div class="mb-3">
                            <input type="text" class="form-control" id="user_id" name="prod_id" hidden>
                            <label for="firstname" class="form-label">First name:</label>
                            <input type="text" class="form-control" id="firstname" min="18" name="firstname" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last name:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="Position" class="form-label">Position:</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact:</label>
                            <input type="text" class="form-control" id="contact" name="contact" required>                        
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" name="add_user" class="btn btn-primary">Submit</button>
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
                    <h5 class="modal-title" id="editModalLabel">Edit user details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="user.php" method="POST">
                        <input type="hidden" id="edit_id" name="user_id">
                        <div class="mb-3">
                            <label for="firstname" class="form-label">First name:</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastname" class="form-label">Last name:</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username:</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password:</label>
                            <input type="text" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="Position" class="form-label">Position:</label>
                            <input type="text" class="form-control" id="position" name="position" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact" class="form-label">Contact:</label>
                            <input type="text" class="form-control" id="contact" name="contact" required>                        
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
            var userId = button.getAttribute('data-id');
            var userFirst = button.getAttribute('data-first');
            var userLast = button.getAttribute('data-last');
            var userUser = button.getAttribute('data-username');
            var userPass = button.getAttribute('data-password');
            var userPos = button.getAttribute('data-position');
            var userContact = button.getAttribute('data-contact');

            // Fill modal inputs
            editModal.querySelector('#edit_id').value = userId;
            editModal.querySelector('#firstname').value = userFirst;
            editModal.querySelector('#lastname').value = userLast;
            editModal.querySelector('#username').value = userUser;
            editModal.querySelector('#password').value = userPass;
            editModal.querySelector('#position').value = userPos;
            editModal.querySelector('#contact').value = userContact;
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
                    Are you sure you want to delete this user? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="user.php">
                        <input type="hidden" id="delete_id" name="user_id" value="">
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
                    var userId = button.getAttribute('data-user-id'); // Extract info from data-* attributes
                    var modalInput = deleteModal.querySelector('#delete_id'); // Find the input in the modal
                    modalInput.value = userId; // Update the input's value
                });
            });
        </script>

    <!-- Page Wrapper -->
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
                        <span>Dashboard</span>
                    </a>
                </li>


                <!-- Divider -->
                <hr class="sidebar-divider">

                <!-- Heading -->
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
                            <a class="collapse-item " href="Record.php">Category/Brand</a>
                            <a class="collapse-item" href="Product.php">Product</a>
                            <a class="collapse-item active" href="User.php">User</a>
                        </div>
                    </div>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="cashier.php">
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
                <hr class="sidebar-divider d-none d-md-block">
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
                        <h1 class="h3 m-0 mb-2 text-gray-800">User Management</h1>
                        <hr>
                        <!-- ALERTS ROW -->
                        

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
                                            data-bs-toggle="modal" data-bs-target="#user_add_modal">
                                            Record User
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>First name</th>
                                                        <th>Last name</th>
                                                        <th>Username</th>
                                                        <th>Position</th>
                                                        <th>Contact</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>First name</th>
                                                        <th>Last name</th>
                                                        <th>Username</th>
                                                        <th>Position</th>
                                                        <th>Contact</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                                <tbody>
                                                <?php
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                            echo "<tr class='text-center text-uppercase'>";
                                                            echo "<td>" . $row["user_id"] . "</td>";
                                                            echo "<td>" . $row["firstname"] . "</td>";
                                                            echo "<td>" . $row["lastname"] . "</td>";
                                                            echo "<td>" . $row["username"] . "</td>";
                                                            echo "<td>" . $row["position"] . "</td>";
                                                            echo "<td>" . $row["contact"] . "</td>";
                                                            echo "<td>
                                                                    <button class='btn btn-primary edit-btn btn-sm' 
                                                                        data-id='" . $row["user_id"] . "' 
                                                                        data-first='" . $row["firstname"] . "' 
                                                                        data-last='" . $row["lastname"] . "'
                                                                        data-username='" . $row["username"] . "' 
                                                                        data-password='" . $row["password"] . "' 
                                                                        data-position='" . $row["position"] . "' 
                                                                        data-contact='" . $row["contact"] . "' 
                                                                        data-bs-toggle='modal' 
                                                                        data-bs-target='#modal_edit'>
                                                                        EDIT
                                                                    </button>
                                                                    <button class='btn btn-danger btn-sm' data-bs-toggle='modal' data-bs-target='#modal_delete'
                                                                    data-user-id='{$row['user_id']}'>DELETE</button>
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
            <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
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