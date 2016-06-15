<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : event_details.php
* Description : The event details page of the website
* Version : 1.10
----------------------------------------------------------------->
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
        <title>Détails de l'événement</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            // Function that generate a message for the delete confirmation.
            function confirmDeletion() {
                return (confirm("Voulez-vous supprimer cette entrée ?"));
            }
        </script>
    </head>
    <body>
        <?php
        // Checks if there is an event id and if so displays the event details and the comments.
        if (isset($_GET['event_id'])) {
            $event_id = $_GET['event_id'];
            getEventDetail($event_id);
            if (isUserAdmin()) {
                displayCommentAdmin($event_id);
            } else {
                displayCommentUser($event_id);
            }
        }
        ?>
    </body>
</html>





