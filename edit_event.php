<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : edit_event.php
* Description : The edit event page of the website
* Version : 1.10
----------------------------------------------------------------->
<?php
require 'functions/functions.php';
require 'controller.php';
// Get the id from the url.
$datas['event_id'] = $_GET['event_id'];
// Get the informations of the event from the dsatabase.
$results = getEventInfo($datas);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Modifier un événement</title>
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
                <h1>Modifier un événement</h1><br/>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-2 pull-left">
                    <div class="panel panel-default" style="width: 800px;">
                        <div class="panel-heading">
                            <h3 class="panel-title">Modifier un événement</h3>
                        </div>
                        <div class="panel-body" style="width: 800px;">
                            <form method="POST" action="#" enctype="multipart/form-data">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Titre :</label>
                                        <input class="form-control" placeholder="Titre..." name="editevent_title" type="text" value="<?php echo $results[0]['title']; ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Rue :</label>
                                        <input class="form-control" placeholder="Rue..." name="editevent_street" type="text" value="<?php echo $results[0]['street']; ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Ville :</label>
                                        <input class="form-control" placeholder="Ville..." name="editevent_city" type="text" value="<?php echo $results[0]['city']; ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Pays :</label>
                                        <select class="form-control" name="editevent_country" required="">
                                            <option>Séléctionnez un pays</option>
                                            <?php getCountriesList(); ?>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Date de début :</label>
                                        <input class="form-control"  name="editevent_datestart" type="date" value="<?php echo $results[0]['dateStart']; ?>" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Date de fin :</label>
                                        <input class="form-control"  name="editevent_dateend" value="<?php echo $results[0]['dateEnd']; ?>" type="date">
                                    </div>
                                    <div class="form-group">
                                        <label>Description :</label>
                                        <textarea class="form-control" name="editevent_desc" cols="50" rows="10" style="max-width: 100%;"><?php echo $results[0]['description']; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label>Image :</label>
                                        <input class="form-control" name="<?php echo INPUT; ?>" type="file" required="">
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" name="edit_event" value="Modifier l'événement">
                                </fieldset>
                            </form>
                            <?php
                            // Displays the error messages.
                            echo $editdate_error;
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>