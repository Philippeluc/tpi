<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Accueil</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="styles/navbarstyle.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <!-- Les navbar seront générées avec PHP selon l'utilisateur. -->
            <?php include_once 'menu/defaultmenu.php'; ?>
            <?php include_once 'menu/usermenu.php'; ?>
            <?php include_once 'menu/adminmenu.php'; ?>
            <div class="row">
                <h1>Date (gestion avec PHP)</h1>
            </div>
            <!-- Les div des événements seront générées avec PHP. -->
            <div class="row">
                <div class="col-xs-6 col-lg-4">
                    <h2>Evénement 1</h2>
                    <a href="#" class="thumbnail">
                        <img alt="Image" src="images/exempleconcert.jpg">
                    </a>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">Détails &raquo;</a></p>
                </div>
                <div class="col-xs-6 col-lg-4">
                    <h2>Evénement 2</h2>
                    <a href="#" class="thumbnail">
                        <img alt="Image" src="images/exempleconcert.jpg">
                    </a>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">Détails &raquo;</a></p>
                </div>
                <div class="col-xs-6 col-lg-4">
                    <h2>Evénement 3</h2>
                    <a href="#" class="thumbnail">
                        <img alt="Image" src="images/exempleconcert.jpg">
                    </a>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">Détails &raquo;</a></p>
                </div>
                <div class="col-xs-6 col-lg-4">
                    <h2>Evénement 4</h2>
                    <a href="#" class="thumbnail">
                        <img alt="Image" src="images/exempleconcert.jpg">
                    </a>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">Détails &raquo;</a></p>
                </div>
                <div class="col-xs-6 col-lg-4">
                    <h2>Evénement 5</h2>
                    <a href="#" class="thumbnail">
                        <img alt="Image" src="images/exempleconcert.jpg">
                    </a>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">Détails &raquo;</a></p>
                </div>
                <div class="col-xs-6 col-lg-4">
                    <h2>Evénement 6</h2>
                    <a href="#" class="thumbnail">
                        <img alt="Image" src="images/exempleconcert.jpg">
                    </a>
                    <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
                    <p><a class="btn btn-default" href="#" role="button">Détails &raquo;</a></p>
                </div>
            </div>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <script src="bootstrap/js/bootstrap.min.js"></script>
    </body>
</html>


