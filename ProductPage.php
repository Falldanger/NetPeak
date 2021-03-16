<?php

include_once './database/Connection.php';
include_once './controllers/ProductController.php';
include_once 'layouts/MainLayout.php';
include_once './controllers/CommentController.php';

use database\Connection;
use controllers\ProductController;
use layouts\MainLayout;
use repositories\ProductRepository;
use controllers\CommentController;

$productController = new ProductController();
$product = $productController->getDataById($_GET['page']);
$commentController = new CommentController();

$errors = [];

if (isset($_POST['addComment'])) {
    $_POST['product_id'] = $_GET['page'];
    $errors = $commentController->create($_POST);
    if (count($errors) == 0) {
        $message = 'Comment was successfully added';
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="/css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="#"/>
</head>
<body>
<?php
$layout = new MainLayout();
echo $layout->drawNavbar();
?>
<section class="ProductInfo">
    <?php
    if (!empty($_GET['page'])) {
        $indexController = new ProductController();
        $data = $indexController->getDataById($_GET['page']);

    } else {
        echo 'No Data to view';
    }
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-2" id="result" style="float: right">
                <?php
                if (!isset($data['image'])) {
                    echo 'Picture not found';
                } else {
                    echo '<img src=' . $data['image'] . ' alt="Picture not found" width="180" height="240">';
                }
                ?>
            </div>
            <div class="col-md-6" id="result">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php
                            $productName = '';
                            if (isset($data['product_name'])) {
                                $productName = $data['product_name'];
                            }
                            echo "Product name: " . $productName;
                            ?>
                        </div>
                        <div class="col-md-12">
                            <?php
                            $avgMark = '';
                            if (isset($data['avg_mark'])) {
                                $avgMark = $data['avg_mark'];
                            }
                            echo "Average mark: " . $avgMark;
                            ?>
                        </div>
                        <div class="col-md-12">
                            <?php
                            $avgPrice = '';
                            if (isset($data['avg_price'])) {
                                $avgPrice = $data['avg_price'];
                            }
                            echo "Average price: " . $avgPrice;
                            ?>
                        </div>
                        <div class="col-md-12">
                            <?php
                            $creationDate = '';
                            if (isset($data['created_at'])) {
                                $creationDate = $data['created_at'];
                            }
                            echo "Creation date: " . $creationDate;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="CommentsTable">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-2">
                <div>
                    <h4 id="table">Comments: </h4>
                    <table id="table">
                        <?php

                        echo $commentController->generateTable($commentController->getConnection()->getCommentsByProductId($_GET['page']));

                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="CommentsForm">
    <div class="container-fluid">
        <?php
        if (isset($message)) {
            echo '<div class="alert alert-success" role="alert">' . $message . '</div>';
        }
        ?>
        <form action="" id="addComment" method="post">
            <div class="col-md-9 offset-3">
                <span style="margin-left: -6px"><b>Leave a comment:</b></span>
            </div>
            <div class="row">
                <div class="col-md-4 offset-3">
                    <label for="commentator_name">Commentator</label>
                    <input type="text" class="form-control" id="commentator_name" name="commentator_name"
                           value="<?php if (isset($_POST['commentator_name'])) {
                               echo $_POST['commentator_name'];
                           } else {
                               echo $product['commentator_name'];
                           } ?>"
                           maxlength="64">
                    <span>
                        <?php if (isset($errors['commentator_name'])) {
                            echo $errors['commentator_name'];
                        } ?>
                    </span>
                </div>
                <div class="col-md-2">
                    <label for="mark">Mark</label>
                    <input type="number" class="form-control" id="mark" name="mark" min="0" max="10"
                           value="<?php if (isset($_POST['mark'])) {
                               echo $_POST['mark'];
                           } else {
                               echo $product['mark'];
                           } ?>">
                    <span>
                        <?php if (isset($errors['mark'])) {
                            echo $errors['mark'];
                        } ?>
                    </span>
                </div>
                <div class="col-md-6 offset-3">
                    <label for="message">Message</label>
                    <textarea class="form-control" id="message" name="message" rows="2">
                        <?php if (isset($_POST['message'])) {
                            echo $_POST['message'];
                        } else {
                            echo $product['message'];
                        } ?>
                    </textarea>
                    <span>
                        <?php if (isset($errors['message'])) {
                            echo $errors['message'];
                        } ?>
                    </span>
                </div>
                <div class="form-group">
                    <input type="hidden" class="form-control" id="id" name="id"
                           value="<?php echo $_GET['page'] ?>">
                </div>
                <div class="col-md-6 offset-3" style="margin-top: 10px">
                    <input type="submit" class="btn btn-primary" name="addComment" value="Submit">
                </div>
            </div>
        </form>
    </div>
    </div>
</section>
</body>
</html>
