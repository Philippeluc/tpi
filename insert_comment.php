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
        <title>Commenter</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php
            require 'session_menu.php';
            ?>
            <div class="row col-md-offset-0">
                <h1>Ajouter un commentaire</h1><br/>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2 pull-left">
                    <div class="panel panel-default" style="width: 800px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ajouter un commentaire</h3>
                        </div>
                        <div class="panel-body" style="width: 800px;">
                            <form accept-charset="UTF-8" role="form" action="#" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Commentaire :</label>
                                        <textarea class="form-control" placeholder="Commentaire" name="comment" cols="50" rows="10" style="max-width: 100%;" required=""></textarea>
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" name="insert_comment" value="Commenter">
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





