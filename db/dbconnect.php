<?php

session_start();
include("db_con.php");


    $sql = "SELECT c.category_name AS categories, b.brand_name AS brands, p.name, p.price, p.quantity 
    FROM products p 
    JOIN categories c ON p.category_id = c.id 
    JOIN brands b ON p.brand_id = b.id";

    $result = $con->query($sql);

    $sql_user = "SELECT * FROM users";
    $result_users = $con->query($sql_user);
        
    

?>
