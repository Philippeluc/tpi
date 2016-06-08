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
        <title>Editer un événement</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php 
                require 'session_menu.php';
            ?>
            <div class="row col-md-offset-0">
                <h1>Modifier un événement</h1>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2 pull-left">
                    <div class="panel panel-default" style="width: 800px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Modifier un événement</h3>
                        </div>
                        <div class="panel-body" style="width: 800px;">
                            <form accept-charset="UTF-8" role="form" action="#" method="POST" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Titre :</label>
                                        <input class="form-control" placeholder="Titre" name="edit_title" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Rue :</label>
                                        <input class="form-control" placeholder="Rue" name="edit_street" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Ville :</label>
                                        <input class="form-control" placeholder="Ville" name="edit_city" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Pays :</label>
                                        <select class="form-control" name="edit_country" required="">
                                            <option>Séléctionnez un pays</option>
                                            <?php getCountriesList() ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Date de début :</label>
                                        <input class="form-control"  name="edit_datestart" type="date" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Date de fin :</label>
                                        <input class="form-control"  name="edit_dateend" type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Description :</label>
                                        <textarea class="form-control" placeholder="Description" name="edit_desc" cols="50" rows="10" required="" style="max-width: 100%;"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Image :</label>
                                        <input class="form-control" placeholder="Image" name="edit_image" type="file" required="">
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" name="modify_event" value="Modifier l'événement">
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




