<?php
require 'functions/functions.php';
require 'controller.php';
$datas['user_id'] = getUserId();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Mon compte</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php
            require 'session_menu.php';
            ?>
            <div class="row col-md-offset-0">
                <h1>Mon compte</h1>
                <form method="POST" action="#">
                    <?php displayEventFromUser($datas); ?>
                    <button type="submit" name="delete_event" id="navbarbutton" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-trash"></span></button>
                </form>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>