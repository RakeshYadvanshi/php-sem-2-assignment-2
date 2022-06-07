<?php
require('db_conn.php');

$query = 'SELECT * FROM product;'; // replace with paramertized query using mysqli_stmt_bind_param for asynchronous work task
$results = @mysqli_query($dbc, $query); // print_r($results);
?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>
        Product List
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">

            <h1>Product List

            </h1>

            <a href="index.php">Create new Product</a>

            <?php if (!empty($_GET["isdeleted"])) { ?>

                <div class="alert alert-primary" role="alert">
                    Product Deleted Successfully
                </div>

            <?php } ?>

            <table class="table">
                <thead>
                    <tr align="left">
                        <th>ID</th>
                        <th>Product Title</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Created By</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_array($results, MYSQLI_ASSOC)) {
                        $str_to_print = "";
                        $str_to_print = "<tr> <td>{$row['id']}</td>";
                        $str_to_print .= "<td> {$row['productTitle']}</td>";
                        $str_to_print .= "<td> {$row['quantity']}</td>";
                        $str_to_print .= "<td> {$row['price']}</td>";
                        $str_to_print .= "<td> {$row['createdBy']}</td>";
                        $str_to_print .= "<td> <a href='edit-product.php?id={$row['id']}'>Edit</a> | <a href='delete-product.php?id={$row['id']}'>Delete</a> </td> </tr>";

                        echo $str_to_print;
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>