<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : default_menu.php
* Description : This file is the menubar for the un-authentified user (visitors)
* Version : 1.10
----------------------------------------------------------------->
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li class="active"><a href="index.php"><b>Events Manager</b></a></li>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="about.php">A propos</a></li>
        </ul>
        <form class="navbar-form navbar-right inline-form" method="GET" action="results.php">
            <input type="text" name="user_query" class="input-sm form-control" placeholder="Recherche...">
            <button type="submit" name="search" style="margin-right: 10px;" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
            <a href="signup.php" style="margin-right: 10px;"><span class="glyphicon glyphicon-pencil"></span> S'inscrire </a>
            <a href="signin.php" style="margin-right: 10px;"><span class="glyphicon glyphicon-log-in"></span> Se connecter </a>
        </form>
    </div>
</nav>
