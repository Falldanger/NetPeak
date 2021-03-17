<?php

namespace views;
include_once 'layouts/MainLayout.php';

use controllers\ProductController;
use layouts\MainLayout;
use repositories\ProductRepository;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link href="../css/style.css" rel="stylesheet" type="text/css"/>
    <link rel="shortcut icon" href="#"/>
</head>
<body>
<?php
$layout = new MainLayout();
echo $layout->drawNavbar();

$productTableColumns = ProductRepository::PRODUCT_TABLE_COLUMNS;
?>
<section class="sortingProductTable">
    <form action="" id="sortProducts" method="post">
        <div class="container">
            <div class="row">
                <div class="col-md-8 offset-1">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="sortByColumn">Column</label>
                                <select class="form-control" id="sortByColumn" name="sortByColumn" form="sortProducts">
                                    <?php
                                    foreach ($productTableColumns as $key => $value) {
                                        echo '<option value=' . $value . ">$value</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="sortRule">Rule</label>
                                <select class="form-control" id="sortRule" name="sortRule" form="sortProducts">
                                    <option value="desc">Desc</option>
                                    <option value="asc">Asc</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" style="margin-top: 30px" class="btn btn-success"
                                       name="sortProducts" id="sortProducts"
                                       value="Sort">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
<section class="productTable">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-1">
                <div>
                    <h4 id="table">Products table</h4>
                    <table id="table">
                        <?php

                        $connection = new ProductController();
                        if (isset($_POST['sortProducts'])) {
                            echo $connection->generateTable($connection->sortByColumn($_POST['sortByColumn'], $_POST['sortRule']));
                        } else {
                            echo $connection->generateTable($connection->getConnection()->all());
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</html>