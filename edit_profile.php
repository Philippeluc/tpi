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
        <title>Editer le profil</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php 
                require 'session_menu.php';
            ?>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Modifier le profil</h3>
                        </div>
                        <div class="panel-body">
                            <form accept-charset="UTF-8" role="form" action="#" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Nom :</label>
                                        <input class="form-control" placeholder="Nom" name="name" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Prénom :</label>
                                        <input class="form-control" placeholder="Prénom" name="firstname" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Organisation :</label>
                                        <input class="form-control" placeholder="Organisation" name="organisation" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Adresse :</label>
                                        <input class="form-control" placeholder="Adresse" name="adress" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Avatar :</label>
                                        <input class="form-control" name="avatar" type="file" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Description :</label>
                                        <textarea class="form-control" placeholder="Description" name="description" cols="50" rows="10" required=""></textarea>
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Modifier">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>





