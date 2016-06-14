<!----------------------------------------------------------------
* Author : Philippe Ku
* School / Class : CFPT Informatique / I.FA-P3B
* Date : 15.06.2016
* Programm : Event gestion website
* File : index.php
* Description : The index page of the website
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
        <title>Accueil</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="row col-md" style="padding-left: 20px;">
            <form method="POST" action="">
                <select class="input-sm" name="event_filter">
                    <option value="default">Séléctionner un filtre</option>
                    <option value="day">Jour</option>
                    <option value="week">Semaine</option>
                    <option value="month">Mois</option>
                </select>
                <input class="btn btn-primary btn-sm" type="submit" name="filter"/>
            </form>
        </div>
        <?php
        // Changes the date to a french format.
        setlocale(LC_TIME, 'fr', 'fr_FR', 'fr_FR.ISO8859-1');
        $date = strftime("%A %d %B %Y.");
        $month = strftime("%B %Y.");

        // Displays the events depending on the filter (day, week, month).
        if (isset($_POST['filter'])) {
            if ($_POST['event_filter'] == "day") {
                echo '<div class="row col-md-offset-0"><h1>Les événements du jour : ' . $date . '</h1><br/>';
                getCurrentDayEvents();
            }
            if ($_POST['event_filter'] == "week") {
                echo '<div class="row col-md-offset-0"><h1>Les événements de la semaine</h1><br/>';
                getCurrentWeekEvents();
            }
            if ($_POST['event_filter'] == "month") {
                echo '<div class="row col-md-offset-0"><h1>Les événements du mois : ' . $month . '</h1><br/>';
                getCurrentMonthEvents();
            }
        } else {
            echo '<div class="row col-md-offset-0"><h1>Les événements du jour : ' . $date . '</h1><br/>';
            getCurrentDayEvents();
        }
        ?>
    </body>
</html>




