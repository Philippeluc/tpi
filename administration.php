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
        <title>Administration</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php
            require 'session_menu.php';
            ?>
            <div class="row col-md-offset-0">
                <h1>Administration</h1>
                <div class="row col-md-offset-1">
                    <h2>Gestion des utilisateurs</h2>
                    <form method="POST" action="#">
                        <?php displayUsers($datas) ?>
                        <button style='width:100px;' type="submit" name="ban_user" class="btn btn-danger btn-sm">Bloquer <span class="glyphicon glyphicon-remove"></span></button>
                        <button style='width:100px;' type="submit" name="unban_user" class="btn btn-success btn-sm">Débloquer <span class="glyphicon glyphicon-ok"></span></button>
                        <button style='width:100px;' type="submit" name="delete_user" class="btn btn-primary btn-sm">Supprimer <span class="glyphicon glyphicon-trash"></span></button>
                    </form>
                    <h2>Gestion des événements</h2>
                    <form method="POST" action="#">
                        <?php displayAllEvents($datas); ?>
                        <button style="width:100px;" type="submit" name="ban_event" class="btn btn-danger btn-sm">Bloquer <span class="glyphicon glyphicon-remove"></span></button>
                        <button style="width:100px;" type="submit" name="unban_event" class="btn btn-success btn-sm">Débloquer <span class="glyphicon glyphicon-ok"></span></button>
                        <button style="width:100px;" type="submit" name="delete_event" class="btn btn-primary btn-sm">Supprimer <span class="glyphicon glyphicon-trash"></span></button>
                    </form>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>
