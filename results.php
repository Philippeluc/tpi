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
        <title>Résultats</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">    
    </head>
    <body>
        <div class="container">
            <?php
            require 'session_menu.php';
            ?>
            <div class="row">
                <h1>Résultats de la recherche</h1>
            </div>
            <?php
            if (isset($_GET['search'])) 
                {
                $search_query = $_GET['user_query'];
                searchAnEvent($search_query);
            }
            ?>  
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>

