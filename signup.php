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
        <title>Inscription</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php 
                require 'session_menu.php';
                if(isLoggedIn())
                {
                    header('location: index.php');
                }
            ?>
            <div class="row col-md-offset-0">
                <h1>Inscription</h1>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2 pull-left">
                    <div class="panel panel-default" style="width: 800px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Inscription</h3>
                        </div>
                        <div class="panel-body" style="width: 800px;">
                            <form accept-charset="UTF-8" role="form" action="#" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Email :</label>
                                        <input class="form-control" placeholder="Email" name="email" type="email" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Pseudo :</label>
                                        <input class="form-control" placeholder="Pseudo" name="pseudo" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Mot de passe :</label>
                                        <input class="form-control" placeholder="Mot de passe" name="password" type="password" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Vérification Mot de passe :</label>
                                        <input class="form-control" placeholder="Vérification mot de passe" name="checkpassword" type="password" required="">
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" name="insert_user" value="S'inscrire">
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






