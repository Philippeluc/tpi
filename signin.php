<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : signin.php
* Description : The sign in page of the website
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
        <title>Connexion</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <?php
            // If the user is already logged.
            if (isLoggedIn()) {
                // Redirect to the index.
                header('location: index.php');
            }
            ?>
            <div class="row col-md-offset-0">
                <h1>Connexion</h1>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2 pull-left">
                    <div class="panel panel-default" style="width: 800px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Connexion</h3>
                        </div>
                        <div class="panel-body" style="width: 800px;">
                            <form method="POST" action="#">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Email :</label>
                                        <input class="form-control" placeholder="Email..." name="user_email" type="email" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Mot de passe :</label>
                                        <input class="form-control" placeholder="Mot de passe..." name="user_password" type="password" required="">
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" name="connect_user" value="Se connecter">
                                </fieldset>
                            </form>
                            <?php
                            // Displays the error messages.
                            echo $signin_error;
                            echo $banconnect_error;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>






