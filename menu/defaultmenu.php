<!-- Menu pour les utilisateurs non authentifiés du site (visiteurs). -->
<link href="styles/navbarstyle.css" rel="stylesheet">
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li class="active"><a href="index.php"><b>Events Manager</b></a></li>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="about.php">A propos</a></li>
        </ul>
        <form class="navbar-form navbar-right inline-form" method="GET" action="results.php">
            <div class="form-group">
                <input type="text" name="user_query" class="input-sm form-control" placeholder="Recherche...">
                <button type="submit" name="search" id="navbarbutton" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-search"></span></button>
                <a href="signup.php" id="navbarlink"><span class="glyphicon glyphicon-pencil"></span> S'inscrire </a>
                <a href="signin.php" id="navbarlink"><span class="glyphicon glyphicon-log-in"></span> Se connecter </a>
            </div>
        </form>
    </div>
</nav>