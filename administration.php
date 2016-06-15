<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : administration.php
* Description : The administration page of the website (reserved to administrators)
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
        <title>Administration</title>
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
        // If the user is not an admin.
        if (!isUserAdmin()) {
            // Redirect to the index page.
            header('location: index.php');
        }
        ?>
        <div class="container col-lg-12">
            <div class="row col-md">
                <h1>Mon profil</h1><br/>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Email</th>
                            <th>Pseudo</th>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Organisation</th>
                            <th>Adresse</th>
                            <th>avatar</th>
                            <th>Description</th>
                            <th>Gestion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Display all the users from the database.
                        displayAllUsers();
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="row col-md">
                <h1>Gérer les événements</h1><br/>
            </div>
            <div class="row">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Rue</th>
                            <th>Ville</th>
                            <th>Pays</th>
                            <th>Date de début</th>
                            <th>Date de fin</th>
                            <th>Description</th>
                            <th>Image</th>
                            <th>Gestion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Displays all the events from the database.
                        displayAllAdminEvents();
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>