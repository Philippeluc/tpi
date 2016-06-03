<?php
require 'functions/functions.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Insérer un événement</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="styles/navbarstyle.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <!-- Les navbar seront générées avec PHP selon l'utilisateur. -->
            <?php include_once 'menu/defaultmenu.php'; ?>
            <div class="row">
                <div class="col-md-4 col-md-offset-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ajouter un événement</h3>
                        </div>
                        <div class="panel-body">
                            <form accept-charset="UTF-8" role="form" action="#" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Titre :</label>
                                        <input class="form-control" placeholder="Titre" name="event_title" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Rue :</label>
                                        <input class="form-control" placeholder="Lieu" name="event_street" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Ville :</label>
                                        <input class="form-control" placeholder="Lieu" name="event_city" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Pays :</label>
                                        <input class="form-control" placeholder="Lieu" name="event_country" type="text" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Date de début :</label>
                                        <input class="form-control"  name="event_datestart" type="date" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Date de fin :</label>
                                        <input class="form-control"  name="event_dateend" type="date" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Description :</label>
                                        <textarea class="form-control" placeholder="Description" name="event_desc" cols="50" rows="10" required=""></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Image :</label>
                                        <input class="form-control" placeholder="Image" name="event_image" type="file" required="">
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" name="insert_event" value="Ajouter l'événement">
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

<?php

if(isset($_POST['insert_event']))
{
    // Getting the datas from the form fields.
    $datas['event_title'] = $_POST['event_title'];
    $datas['event_street'] = $_POST['event_street'];
    $datas['event_city'] = $_POST['event_city'];
    $datas['event_country'] = $_POST['event_country'];
    $datas['event_datestart'] = $_POST['event_datestart'];
    $datas['event_dateend'] = $_POST['event_dateend'];
    $datas['event_desc'] = $_POST['event_desc'];
    $datas['event_image'] = $_POST['event_image'];
    
    insertNewEvent($datas);
}

?>




