<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : edit_profile.php
* Description : The edit profile page of the website
* Version : 1.10
----------------------------------------------------------------->
<?php
require 'functions/functions.php';
require 'controller.php';
// Gets the user infos from the database.
$results = getUserInfo();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Modifier mon profil</title>
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
                <h1>Modifier mon profil</h1><br/>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2 pull-left">
                    <div class="panel panel-default" style="width: 800px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Modifier mon profil</h3>
                        </div>
                        <div class="panel-body" style="width: 800px;">
                            <form method="POST" action="#" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Nom :</label>
                                        <input class="form-control" placeholder="Nom..." name="edit_name" type="text" value="<?php echo $results[0]['name']; ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Prénom :</label>
                                        <input class="form-control" placeholder="Prénom..." name="edit_firstname" type="text" value="<?php echo $results[0]['firstname']; ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Organisation :</label>
                                        <input class="form-control" placeholder="Organisation..." name="edit_organisation" type="text" value="<?php echo $results[0]['organisation']; ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Adresse :</label>
                                        <input class="form-control" placeholder="Adresse..." name="edit_adress" type="text" value="<?php echo $results[0]['adress']; ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Avatar :</label>
                                        <input class="form-control" name="<?php echo INPUT; ?>" type="file" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Description :</label>
                                        <textarea class="form-control" name="edit_desc" cols="50" rows="10" style="max-width: 100%;"><?php echo $results[0]['description']; ?></textarea>
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" name="edit_profile" value="Modifier mon profil">
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

