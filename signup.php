<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : signup.php
* Description : The sign up page of the website
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
        <title>Inscription</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <?php if (isLoggedIn()) {
                header('location: index.php');
            } ?>
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
                            <form method="POST" action="#">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Email :</label>
                                        <input class="form-control" placeholder="Email..." name="user_email" type="email" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Pseudo :</label>
                                        <input class="form-control" placeholder="Pseudo..." name="user_nickname" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Mot de passe :</label>
                                        <input class="form-control" placeholder="Mot de passe..." name="user_password" type="password" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Vérification Mot de passe :</label>
                                        <input class="form-control" placeholder="Vérification du mot de passe..." name="user_checkpassword" type="password" required="">
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" name="insert_user" value="S'inscrire">
                                </fieldset>
                            </form>
                            <?php echo $passwordlength_error; ?>
                            <?php echo $passwordcheck_error; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>






