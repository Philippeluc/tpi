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
            if (isset($_GET['search'])) 
                {
                $search_query = filter_var($_GET['user_query'], FILTER_SANITIZE_SPECIAL_CHARS);
                searchAnEvent($search_query);
            }
            ?>  
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>

