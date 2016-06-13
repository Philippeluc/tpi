<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : insert_event.php
* Description : The insert event page of the website
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
        <title>Ajouter un événement</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- Script that adds TinyMCE, a JavaScript text editor for the textarea. -->
        <script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
        <script>tinymce.init({selector: 'textarea'});</script>
    </head>
    <body>
        <?php if (!isUserAdmin() && !isUserMember()) { header('location: index.php'); } ?>
        <div class="container">
            <div class="row col-md-offset-0">
                <h1>Ajouter un événement</h1><br/>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2 pull-left">
                    <div class="panel panel-default" style="width: 800px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ajouter un événement</h3>
                        </div>
                        <div class="panel-body" style="width: 800px;">
                            <form method="POST" action="#" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Titre :</label>
                                        <input class="form-control" placeholder="Titre..." name="event_title" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Rue :</label>
                                        <input class="form-control" placeholder="Rue..." name="event_street" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Ville :</label>
                                        <input class="form-control" placeholder="Ville..." name="event_city" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Pays :</label>
                                        <select class="form-control" name="event_country" required="">
                                            <option>Séléctionnez un pays</option>
                                            <?php getCountriesList(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Date de début :</label>
                                        <input class="form-control"  name="event_datestart" type="date" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Date de fin :</label>
                                        <input class="form-control"  name="event_dateend" type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Description :</label>
                                        <textarea class="form-control" name="event_desc" cols="50" rows="10" style="max-width: 100%;"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Image :</label>
                                        <input class="form-control" name="<?php echo INPUT; ?>" type="file" required="">
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" name="insert_event" value="Ajouter l'événement">
                                </fieldset>
                            </form>
                            <?php echo $date_error; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>