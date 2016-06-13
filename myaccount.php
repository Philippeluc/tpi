<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : myaccount.php
* Description : The personal account page of the website
* Version : 1.10
----------------------------------------------------------------->
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
        <?php if (!isUserAdmin() && !isUserMember()) {
            header('location: index.php');
        } ?>
        <div class="container col-lg-11" style="padding-left: 150px;">
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
                            <th>Avatar</th>
                            <th>Description</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        displayUserProfile($datas);
                        ?>
                    </tbody>
                </table>
<?php echo '<a href="edit_profile.php" class="btn btn-primary pull-right">Modifier mon profil</a><br/>'; ?>
            </div>
            <div class="row col-md">
                <h1>Mes événements</h1><br/>
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
                        displayAllUserEvents($datas);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </body>
</html>