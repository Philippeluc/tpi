<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Connexion</title>
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
                            <h3 class="panel-title">Connexion</h3>
                        </div>
                        <div class="panel-body">
                            <form accept-charset="UTF-8" role="form" action="#" method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <label>Email :</label>
                                        <input class="form-control" placeholder="Email" name="email" type="email" required="">
                                    </div>
                                    <div class="form-group">
                                        <label>Mot de passe :</label>
                                        <input class="form-control" placeholder="Mot de passe" name="password" type="password" required="">
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" type="submit" value="Se connecter">
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




