<?php
require('db_conn.php');

$product_id = null;
if (!empty($_GET['id'])) {
    $product_id = $_GET['id'];
} else {
    $product_id = null;
    $error = "<p> Error! Product Id not found!</p>";
}

if ($product_id != null) {

    $query = "DELETE FROM product WHERE id = '$product_id' ;";

    $result = mysqli_query($dbc, $query);

    if ($result) {
        header("Location: product-list.php?isdeleted=true");
        exit;
    } else {
        echo "</br><p>Some error in Deleting the record</p>";
    }
} else {
    echo "Somethinng went wrong. The error is : $error";
}
