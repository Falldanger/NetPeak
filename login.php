<?php

include_once 'auth/Authorize.php';
include_once 'layouts/MainLayout.php';

use layouts\MainLayout;

session_start();

$message = '';
if (isset($_POST['authorize'])) {
    $user = new \auth\Authorize();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $message = $user->entry($email, $password);
}
$layout = new MainLayout();
echo $layout->drawNavbar();
?>

<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/login.css">

<div class="container">
    <div class="row" style="margin-top:10%">
        <div class="col-md-6 offset-3">
            <h3 class="text-center">Sign in</h3>
            <form class="form" action="" method="post">
                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="email"
                               value="<?php if (isset($_POST['email'])) {
                                   echo $_POST['email'];
                               } ?>"
                               maxlength="128"/>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="password"
                               value="<?php if (isset($_POST['password'])) {
                                   echo $_POST['password'];
                               } ?>" maxlength="64"/>
                    </div>
                </div>
                <div class="text-center col-xs-12">
                    <input type="submit" class="btn btn-default" name="authorize" value="Submit"/>
                </div>
                <span style="color: darkolivegreen">
                    <?php echo $message; ?>
                </span>
            </form>
        </div>
    </div>