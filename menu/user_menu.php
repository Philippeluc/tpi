<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : user_menu.php
* Description : This file is the menubar for the authentified user (members)
* Version : 1.10
----------------------------------------------------------------->
<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <ul class="nav navbar-nav">
            <li class="active"><a href="index.php"><b>Events Manager</b></a></li>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="insert_event.php">Ajouter un événement</a></li>
            <li><a href="about.php">A propos</a></li>
        </ul>
        <form class="navbar-form navbar-right inline-form" method="GET" action="results.php">
            <input type="text" name="user_query" class="input-sm form-control" placeholder="Recherche...">
            <button type="submit" name="search" style="margin-right: 10px;" class="btn btn-primary"><span class="glyphicon glyphicon-search"></span></button>
            <a href="myaccount.php" style="margin-right: 10px;"><span class="glyphicon glyphicon-user"></span> Mon compte </a>
            <a href="index.php?logout=true" style="margin-right: 10px;"><span class="glyphicon glyphicon-off"></span> Se déconnecter </a>
        </form>
    </div>
</nav>
