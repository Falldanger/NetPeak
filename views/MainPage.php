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
?>
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-1">
            <div>
                <h4 id="table">Products table</h4>
                <table id="table">
                    <?php

                    $connection = new ProductController();
                    echo $connection->generateTable($connection->getConnection()->all());

                    ?>
                </table>
            </div>
        </div>
    </div>
</div>
</body>
</html>