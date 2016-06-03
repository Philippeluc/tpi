<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Détails de l'événement</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="styles/navbarstyle.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <!-- Les navbar seront générées avec PHP selon l'utilisateur. -->
            <?php include_once 'menu/defaultmenu.php'; ?>
            <!-- Les div des événements seront générées avec PHP. -->
            <div class="panel">
                <div class="panel-heading">
                    <div class="text-center">
                        <div class="row">
                            <div class="col-sm-9">
                                <h1 class="pull-left">Event 1</h1>
                            </div>
                            <div class="col-sm-3">
                                <h4 class="pull-right">
                                    <a href="#">Ajouter un commentaire</a>
                                </h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <a href="#" class="thumbnail">
                        <img alt="Image" src="images/exempleconcert.jpg">
                    </a>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
                    tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                    quis nostrud exercitation<a class="btn btn-default" href="#" role="button">Accueil &raquo;</a>
                </div>
            </div>
            <div class="pull-left user-info col-lg-1" href="#">
                <img class="avatar img-circle img-thumbnail" src="images/exempleconcert.jpg"
                     width="64" alt="Generic placeholder image">
                <br/>
                <p>Sarah Croche</p>
                <br>
            </div>
            <div class="media-body">
                Hello World !
            </div>
            <div id='postOptions' class="media-right">
                DateTime
                <br/>
                <a href="#"><span class="input-group-addon"><i class="glyphicon glyphicon-exclamation-sign"></i></span></a>
                <br/>
                <a href="#"><span class="input-group-addon"><i class="glyphicon glyphicon-remove-sign"></i></span></a>
            </div>
        </div>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>



