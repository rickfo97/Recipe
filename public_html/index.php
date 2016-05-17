<?php
/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 15:49
 */
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
require_once '../app/init.php';
if (!isset($_GET['ajax'])) {
    require_once '../app/language/sv.php';
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title><?= $lang['Head_Title'] ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="/css/index.css">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <script src="/js/ajax.js"></script>
        <script src="/js/upload.js"></script>
        <script src="/js/recipe.js"></script>
    </head>
    <body>
    <div class="container-fluid">
        <div class="row content">
            <?php

            $app = new App;

            ?>
        </div>
    </div>
    <footer class="container-fluid">
        <p>Footer Text</p>
    </footer>
    </body>
    </html>
    <?php
}else{
    $app = new App;
}
?>