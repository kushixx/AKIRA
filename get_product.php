<?php
include 'db/db_con.php'; // Include your database connection file

if (isset($_GET['barcode'])) {
    $barcode = $_GET['barcode'];
    $sql = "SELECT * FROM products WHERE prod_code = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product);
    } else {
        echo json_encode(null);
    }
} else {
    echo json_encode(null);
}
?>