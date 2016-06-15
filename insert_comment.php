<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : insert_comment.php
* Description : The insert comment page of the website
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
        <title>Ajouter un commentaire</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Script that adds TinyMCE, a JavaScript text editor for the textarea. -->
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>tinymce.init({selector: 'textarea'});</script>
    </head>
    <body>
        <?php
        // If the user is not a member or an admin.
        if (!isUserAdmin() && !isUserMember()) {
            // Redirect to the index.
            header('location: index.php');
        }
        ?>
        <div class="container">
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
                            <form method="POST" action="#" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Texte :</label>
                                        <textarea class="form-control" name="comment_text" cols="50" rows="10" style="max-width: 100%;"></textarea>
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" name="insert_comment" value="Ajouter le commentaire">
                                </fieldset>
                            </form>
                            <?php
                            // Displays the error messages.
                            echo $comment_error;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

