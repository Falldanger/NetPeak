<?php

include_once 'layouts/MainLayout.php';
include_once 'database/Connection.php';
include_once 'controllers/ProductController.php';

use database\Connection;
use controllers\ProductController;
use layouts\MainLayout;
use repositories\ProductRepository;

$errors = [];

if (isset($_POST['addProduct'])) {
    $productController = new ProductController();
    $errors = $productController->create($_POST);
    if (count($errors) == 0) {
        $message = 'Product was successfully added';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href="css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="#"/>
</head>
<body>
<?php
$layout = new MainLayout();
echo $layout->drawNavbar();
?>

<div class="container">
    <h1>Form for add products</h1>
    <div class="row">
        <div class="col-md-4">
            <?php
            if (isset($message)){
                echo '<div class="alert alert-success" role="alert">'.$message.'</div>';
            }
            ?>
            <form action="" id="addReview" method="post">
                <div class="form-group">
                    <label for="product_name">Product name</label>
                    <input type="text" class="form-control" id="product_name" name="product_name"
                           value="<?php if (isset($_POST['product_name'])) {
                               echo $_POST['product_name'];
                           } ?>"
                           maxlength="128">
                    <span>
                        <?php if (isset($errors['product_name'])) {
                            echo $errors['product_name'];
                        } ?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="image">Image</label>
                    <input type="text" class="form-control" id="image" name="image"
                           value="<?php if (isset($_POST['image'])) {
                               echo $_POST['image'];
                           } ?>" maxlength="255">
                    <span>
                        <?php if (isset($errors['image'])) {
                            echo $errors['image'];
                        } ?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="creator_name">Creator Name</label>
                    <input type="text" class="form-control" id="creator_name" name="creator_name"
                           value="<?php if (isset($_POST['creator_name'])) {
                               echo $_POST['creator_name'];
                           } ?>" maxlength="64">
                    <span>
                        <?php if (isset($errors['creator_name'])) {
                            echo $errors['creator_name'];
                        } ?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="avg_price">Average price</label>
                    <input type="number" class="form-control" id="avg_price" name="avg_price" step="any"
                           value="<?php if (isset($_POST['avg_price'])) {
                               echo $_POST['avg_price'];
                           } ?>">
                    <span>
                        <?php if (isset($errors['avg_price'])) {
                            echo $errors['avg_price'];
                        } ?>
                    </span>
                </div>

                <input type="submit" class="btn btn-primary" name="addProduct" value="Confirm">
            </form>
        </div>
    </div>
</div>
</body>
</html>

