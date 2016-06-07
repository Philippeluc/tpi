<?php
require 'functions/functions.php';
require 'controller.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Accueil</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php
            require 'session_menu.php';
            ?>
            <div class="row col-md-offset-0">
                <h1><?php echo date('l jS \of F Y'); ?><h4><select class="input-sm"><option value="day">Jour</option><option value="week">Semaine</option><option value="month">Mois</option></select><input class="btn btn-primary btn-sm" type="submit" name="selectDateFormat"/></h4></h1><br/>
            </div>
            <div class="row">
                <?php
                getAllEvents();
                ?>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>


