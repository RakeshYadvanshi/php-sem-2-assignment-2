<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Create new product</title>
    <?php
    require('db_conn.php');
    $product_id = null;
    if (!empty($_GET['id'])) {
        $product_id = $_GET['id'];
    } else {
        $product_id = null;
        echo  "<p> Error! product Id not found.";
        die();
    }


    $is_form_valid = true;
    $is_post_request = $_SERVER['REQUEST_METHOD'] === 'POST';
    function is_text_only($input)
    {
        return !preg_match("/[^a-zA-Z- ]/", $input);
    }

    //literals 
    $product_title = "";
    $product_title_validation_error = "";
    $product_title_validation_class = "";

    $product_description = "";
    $product_description_validation_error = "";
    $product_description_validation_class = "";

    $quantity = "";
    $quantity_validation_error = "";
    $quantity_validation_class = "";


    $price = "";
    $price_validation_error = "";
    $price_validation_class = "";

    $product_added_by = "";
    $product_added_by_validation_error = "";
    $product_added_by_validation_class = "";


    if ($product_id != null) {
        $query = "SELECT * FROM product WHERE id = $product_id;"; // replace with paramertized query using mysqli_stmt_bind_param
        $result = @mysqli_query($dbc, $query);

        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
            $product_title = $row['productTitle'];
            $product_description = $row['productDesc'];
            $quantity = $row['quantity'];
            $price = $row['price'];
            $product_added_by = $row['createdBy'];
        }
    } else {
        echo $error;
    }

    if ($is_post_request) {

        //validate first name
        if (!empty($_POST['ProductTitle'])) {
            $product_title = $_POST['ProductTitle'];
            if (!is_text_only($product_title)) {
                $is_form_valid = false;
                $product_title_validation_class = "is-invalid";
                $product_title_validation_error = "<div class='invalid-feedback'>Product Name should be text only!!</div>";
            } else {
                $product_title_validation_class = "is-valid";
            }
        } else {
            $is_form_valid = false;
            $product_title_validation_class = "is-invalid";
            $product_title_validation_error = "<div class='invalid-feedback'>Product Name is Required!!</div>";
        }

        //validate Last name
        if (!empty($_POST['ProductDescription'])) {
            $product_description = $_POST['ProductDescription'];
            $product_description_validation_class = "is-valid";
        } else {
            $is_form_valid = false;
            $product_description_validation_class = "is-invalid";
            $product_description_validation_error = "<div class='invalid-feedback'>Product Description is Required!!</div>";
        }



        //validate Quantity
        if (!empty($_POST['Quantity'])) {
            $quantity = $_POST['Quantity'];
            if (!is_numeric($quantity)) {
                $is_form_valid = false;
                $quantity_validation_class = "is-invalid";
                $quantity_validation_error = "<div class='invalid-feedback'>Quantity should be number only!!</div>";
            } else {
                $quantity_validation_class = "is-valid";
            }
        } else {
            $is_form_valid = false;
            $quantity_validation_class = "is-invalid";
            $quantity_validation_error = "<div class='invalid-feedback'>Quantity is Required!!</div>";
        }

        //validate Price
        if (!empty($_POST['Price'])) {
            $price = $_POST['Price'];
            if (!is_numeric($price)) {
                $is_form_valid = false;
                $price_validation_class = "is-invalid";
                $price_validation_error = "<div class='invalid-feedback'>Price should be number only!!</div>";
            } else {
                $price_validation_class = "is-valid";
            }
        } else {
            $is_form_valid = false;
            $price_validation_class = "is-invalid";
            $price_validation_error = "<div class='invalid-feedback'>Price is Required!!</div>";
        }


        //validate ProductAddedBy
        if (!empty($_POST['ProductAddedBy'])) {
            $product_added_by = $_POST['ProductAddedBy'];
            $product_added_by_validation_class = "is-valid";
        } else {
            $is_form_valid = false;
            $product_added_by_validation_class = "is-invalid";
            $product_added_by_validation_error = "<div class='invalid-feedback'>Product Added By is Required!!</div>";
        }

        //Verify if form is valid
        if ($is_form_valid) {

            $query = "UPDATE `product` SET `productTitle` = ?, `productDesc` = ?, `quantity` = ?, `price` = ?, `createdBy` = ? WHERE `id` = ?;";
            $preparedQuery = mysqli_prepare($dbc, $query);
            $product_title_clean =  prepare_string($dbc, $product_title);
            $product_description_clean = prepare_string($dbc, $product_description);
            $quantity_clean  = prepare_string($dbc, $quantity);
            $price_clean = prepare_string($dbc, $price);
            $product_added_by_clean =    prepare_string($dbc, $product_added_by);
            $product_id_clean =    prepare_string($dbc, $product_id);
            mysqli_stmt_bind_param(
                $preparedQuery,
                'ssssss',
                $product_title_clean,
                $product_description_clean,
                $quantity_clean,
                $price_clean,
                $product_added_by_clean,
                $product_id_clean
            );

            $result = mysqli_stmt_execute($preparedQuery);

            if ($result) {
                header("location:product-list.php");
                exit;
            } else {
                echo "</br>Some error in Saving the data";
            }
        }
    }

    ?>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center">

            <div class="col-5 top-margin">
                <h1>Update Product</h1>
                <form class="row g-3 needs-validation top-margin" method="POST">
                    <input type="hidden" id="productId" name="productId" value="<?php echo $product_id; ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <label for="ProductTitle" class="form-label">Product Title </label>

                            <input type="text" name="ProductTitle" class="form-control <?php echo $product_title_validation_class; ?>" id="ProductTitle" value="<?php echo $product_title; ?>" placeholder="Nike Shoes">

                            <?php echo $product_title_validation_error; ?>

                        </div>
                        <div class="col-md-12">
                            <label for="ProductDescription" class="form-label">Product Description</label>
                            <textarea type="text" name="ProductDescription" class="form-control <?php echo $product_description_validation_class; ?>" id="ProductDescription"><?php echo $product_description; ?></textarea>
                            <?php echo $product_description_validation_error; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="Quantity" class="form-label">Quantity Available</label>
                            <input class="form-control <?php echo $quantity_validation_class; ?>" type="number" max="50" min="1" name="Quantity" id="Quantity" value="<?php echo $quantity; ?>" />
                            <?php echo $quantity_validation_error; ?>
                        </div>
                        <div class="col-md-12">
                            <label for="Price" class="form-label">Price</label>
                            <input class="form-control <?php echo $price_validation_class; ?>" type="number" name="Price" id="Price" value="<?php echo $price; ?>" />
                            <?php echo $price_validation_error; ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <label for="ProductAddedBy" class="form-label">Product Added By</label>
                            <input type="text" class="form-control <?php echo $product_added_by_validation_class; ?>" value="<?php echo $product_added_by; ?>" name="ProductAddedBy" id="ProductAddedBy" />

                            <?php echo $product_added_by_validation_error; ?>
                        </div>
                    </div>
                    <div class=" row" style="margin-top:20px">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary" type="submit">Update Product</button>
                            <a class="btn btn-primary" href="product-list.php">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>

        </div>

    </div>
</body>

</html>