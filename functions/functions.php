<?php

/*******************************************************************
 * Author : Philippe Ku
 * School / Class : CFPT Informatique / I.FA-P3B
 * Date : 15.06.2016
 * Programm : Event gestion website
 * File : functions.php
 * Description : This file is the model and contains all the functions of my website
 * Version : 1.10
 * ****************************************************************/

//-------------------- DATABASE FUNCTIONS --------------------\\

require 'mysql.inc.php';

/**
 * Function that creates a database connector or returns it.
 * @staticvar type $dbc     // Static connector to the database.
 * @return \PDO             // The PDO object (PHP data object).
 */
function myDatabase() {
    static $dbc = null;

    if ($dbc == null) {
        try {
            $dbc = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::ATTR_PERSISTENT => true));
        } catch (Exception $e) {
            echo 'Erreur : ' . $e->getMessage() . '<br />';
            echo 'N° : ' . $e->getCode();
            die('Could not connect to MySQL');
        }
    }
    return $dbc;
}

/**
 * Function that inserts new events into the database.
 * @param type $datas       // The informations that we insert into the database.
 */
function insertNewEvent($datas) {
    $query1 = "INSERT INTO location (street, city, iso_country) VALUES (:street, :city, :iso_country)";
    $query2 = "SELECT id_location FROM location WHERE street = :street AND city = :city AND iso_country = :iso_country";
    $query3 = "INSERT INTO event (title, dateStart, dateEnd, description, image, id_location, id_user) VALUES (:title, :dateStart, :dateEnd, :description, :image, :id_location, :id_user)";

    $ps1 = myDatabase()->prepare($query1);
    $ps2 = myDatabase()->prepare($query2);
    $ps3 = myDatabase()->prepare($query3);

    $ps1->bindParam(':street', $datas['event_street'], PDO::PARAM_STR);
    $ps1->bindParam(':city', $datas['event_city'], PDO::PARAM_STR);
    $ps1->bindParam(':iso_country', $datas['event_country'], PDO::PARAM_STR);

    $ps2->bindParam(':street', $datas['event_street'], PDO::PARAM_STR);
    $ps2->bindParam(':city', $datas['event_city'], PDO::PARAM_STR);
    $ps2->bindParam(':iso_country', $datas['event_country'], PDO::PARAM_STR);

    $ps1->execute();
    $isok = $ps2->execute();
    $isok = $ps2->fetchAll(PDO::FETCH_NUM);

    $ps3->bindParam(':title', $datas['event_title'], PDO::PARAM_STR);
    $ps3->bindParam(':dateStart', $datas['event_datestart'], PDO::PARAM_STR);
    $ps3->bindParam(':dateEnd', $datas['event_dateend'], PDO::PARAM_STR);
    $ps3->bindParam(':description', $datas['event_desc'], PDO::PARAM_STR);
    $ps3->bindParam(':image', $datas['event_image'], PDO::PARAM_STR);
    $ps3->bindParam(':id_location', $isok[0][0]);
    $ps3->bindParam(':id_user', $datas['user_id'], PDO::PARAM_STR);

    $ps3->execute();
}

/**
 * Function that inserts a new user into the database.
 * @param type $datas       // The informations that we insert into the database.
 */
function insertNewUser($datas) {
    $query = "INSERT INTO user (email, nickname, password) VALUES (:email, :nickname, :password)";

    $ps = myDatabase()->prepare($query);

    $ps->bindParam(':email', $datas['user_email'], PDO::PARAM_STR);
    $ps->bindParam(':nickname', $datas['user_nickname'], PDO::PARAM_STR);
    $ps->bindParam(':password', $datas['user_password'], PDO::PARAM_STR);

    $ps->execute();
}

/**
 * Function that inserts a new comment into the database.
 * @param type $datas       // The informations that we insert into the database.
 */
function insertNewComment($datas) {
    $query = "INSERT INTO comment (time, text, id_user, id_event) VALUES (:time, :text, :id_user, :id_event)";

    $ps = myDatabase()->prepare($query);

    $ps->bindParam(':time', $datas['comment_time'], PDO::PARAM_STR);
    $ps->bindParam(':text', $datas['comment_text'], PDO::PARAM_STR);
    $ps->bindParam(':id_user', $datas['user_id'], PDO::PARAM_STR);
    $ps->bindParam(':id_event', $datas['event_id'], PDO::PARAM_STR);

    $ps->execute();
}

/**
 * Function that checks if the user is logged, with the correct credentials.
 * @param type $datas       // The informations that we select from the database.
 * @return boolean          // Returns TRUE if checked or FALSE if not.
 */
function checkUser($datas) {
    $query = "SELECT * FROM user where email = :email";

    $ps = myDatabase()->prepare($query);
    try {
        $ps->bindParam(':email', $datas['user_email'], PDO::PARAM_STR);
        $isok = $ps->execute();
        $isok = $ps->fetchAll(PDO::FETCH_NUM);
        if (count($isok)) {
            if ($isok[0][1] == $datas['user_email'] && $isok[0][3] == sha1($datas['user_password'])) {
                // Stores the user id and email in session.
                $_SESSION['user_id'] = $isok[0][0];
                $_SESSION['user_email'] = $isok[0][1];

                $isok = true;
            } else {
                $isok = false;
            }
        }
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok;
}

/**
 * Function that returns the group of the user.
 * @param type $datas       // The informations that we select from the database.
 * @return boolean          // Returns the group of the user.
 */
function getUserGroupFromDatabase($datas) {
    $query = "SELECT privilege FROM user WHERE email = :email";

    $ps = myDatabase()->prepare($query);

    try {
        $ps->bindParam(':email', $datas['user_email'], PDO::PARAM_STR);
        $isok = $ps->execute();
        $isok = $ps->fetchAll(PDO::FETCH_NUM);
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok[0][0];
}

/**
 * Function that gets the different countries (iso and name) from the database and put them into an option list.
 */
function getCountriesList() {
    $query = "SELECT iso, name FROM country ORDER BY name ASC";
    $qr = myDatabase()->query($query);
    $result = $qr->fetchAll();
    foreach ($result as $row) {
        $country_iso = $row['iso'];
        $country_name = $row['name'];
        echo '<option value="' . $country_iso . '">' . $country_name . '</option>';
    }
}

/**
 * Function that displays all the events of the current day with a status unban (status = 1) order by the the event id.
 */
function getCurrentDayEvents() {
    $date = date("Y-m-d");
    $query = "SELECT event.id_event, title, dateStart, dateEnd, image, street, city, iso_country FROM event, location WHERE event.id_location = location.id_location AND event.status = 1 AND dateStart = :day ORDER BY event.id_event";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':day', $date, PDO::PARAM_STR);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $event_id = $row['id_event'];
        $event_title = $row['title'];
        $event_datestart = $row['dateStart'];
        $event_dateend = $row['dateEnd'];
        $event_image = $row['image'];
        $event_street = $row['street'];
        $event_city = $row['city'];
        $event_country = $row['iso_country'];

        echo '<div class="col-xs-6 col-lg-4">
                    <a href="event_details.php?event_id=' . $event_id . '" class="thumbnail">
                        <img alt="Image" src="images/event_images/' . $event_image . '" style="width:500px;height:300px;padding:2rem">
                    </a>
                    <h3>' . $event_title . '</h3>
                    <p>Date de début : ' . $event_datestart . '</p><p>Date de fin : ' . $event_dateend . '</p>
                    <p>Lieu : ' . $event_street . ' ' . $event_city . ' ' . $event_country . '</p>
                    <p><a class="btn btn-primary" href="event_details.php?event_id=' . $event_id . '" role="button">Détails &raquo;</a></p>
                </div>';
    }
}

/**
 * Function that displays all the events of the week with a status unban (status = 1) order by the the event id.
 */
function getCurrentWeekEvents() {
    // Today day of week
    $n = date("N");
    // The first day of the week (Monday).
    $first = abs($n - 1);
    // The last day of the week (Sunday).
    $last = abs(7 - $n);

    // Format the dates.
    $sFirst = 'P' . $first . 'D';
    $sLast = 'P' . $last . 'D';

    // The day of today with an interval with the first day of the week.
    $today = new DateTime();
    $monday = $today->sub(new DateInterval($sFirst));
    // The day of today with an interval with the last day of the week.
    $today = new DateTime();
    $sunday = $today->add(new DateInterval($sLast));
    
    $dateMonday = $monday->format('Y-m-d');
    $dateSunday = $sunday->format('Y-m-d');
    $query = "SELECT * FROM event, location WHERE dateStart BETWEEN :dateMonday AND :dateSunday AND status = 1 AND event.id_location = location.id_location ORDER BY event.id_event ASC";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':dateMonday', $dateMonday, PDO::PARAM_STR);
    $ps->bindParam(':dateSunday', $dateSunday, PDO::PARAM_STR);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $event_id = $row['id_event'];
        $event_title = $row['title'];
        $event_datestart = $row['dateStart'];
        $event_dateend = $row['dateEnd'];
        $event_image = $row['image'];
        $event_street = $row['street'];
        $event_city = $row['city'];
        $event_country = $row['iso_country'];

        echo '<div class="col-xs-6 col-lg-4">
                    <a href="event_details.php?event_id=' . $event_id . '" class="thumbnail">
                        <img alt="Image" src="images/event_images/' . $event_image . '" style="width:500px;height:300px;padding:2rem">
                    </a>
                    <h3>' . $event_title . '</h3>
                    <p>Date de début : ' . $event_datestart . '</p><p>Date de fin : ' . $event_dateend . '</p>
                    <p>Lieu : ' . $event_street . ' ' . $event_city . ' ' . $event_country . '</p>
                    <p><a class="btn btn-primary" href="event_details.php?event_id=' . $event_id . '" role="button">Détails</a></p>
                </div>';
    }
}

/**
 * Function that displays all the events of the month with a status unban (status = 1) order by the the event id.
 */
function getCurrentMonthEvents() {
    $date = date("m");
    $query = "SELECT event.id_event, title, dateStart, dateEnd, image, street, city, iso_country FROM event, location WHERE event.id_location = location.id_location AND event.status = 1 AND MONTH(dateStart) = :month ORDER BY event.id_event";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':month', $date, PDO::PARAM_STR);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $event_id = $row['id_event'];
        $event_title = $row['title'];
        $event_datestart = $row['dateStart'];
        $event_dateend = $row['dateEnd'];
        $event_image = $row['image'];
        $event_street = $row['street'];
        $event_city = $row['city'];
        $event_country = $row['iso_country'];

        echo '<div class="col-xs-6 col-lg-4">
                    <a href="event_details.php?event_id=' . $event_id . '" class="thumbnail">
                        <img alt="Image" src="images/event_images/' . $event_image . '" style="width:500px;height:300px;padding:2rem">
                    </a>
                    <h3>' . $event_title . '</h3>
                    <p>Date de début : ' . $event_datestart . '</p><p>Date de fin : ' . $event_dateend . '</p>
                    <p>Lieu : ' . $event_street . ' ' . $event_city . ' ' . $event_country . '</p>
                    <p><a class="btn btn-primary" href="event_details.php?event_id=' . $event_id . '" role="button">Détails</a></p>
                </div>';
    }
}

/**
 * Function that displays the detail of an event.
 * @param type $event_id        // The id of the event.
 */
function getEventDetail($event_id) {
    $query = "SELECT event.id_event, title, dateStart, dateEnd, image, description, street, city, iso_country FROM event, location WHERE event.id_event = $event_id AND event.status = 1 AND event.id_location = location.id_location";
    $ps = myDatabase()->prepare($query);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $event_id = $row['id_event'];
        $event_title = $row['title'];
        $event_datestart = $row['dateStart'];
        $event_dateend = $row['dateEnd'];
        $event_desc = $row['description'];
        $event_image = $row['image'];
        $event_street = $row['street'];
        $event_city = $row['city'];
        $event_country = $row['iso_country'];

        echo '<div class="panel">
                    <div class="panel-heading">
                        <div class="text-center">
                            <div class="row">
                                <div class="col-sm-9">
                                    <h1 class="pull-left">' . $event_title . '</h1>
                                </div>
                                <div class="col-sm-3">
                                    <h4 class="pull-right">';
        // If the user is a member or an admin display the add comment link.
        if (isUserMember() || isUserAdmin()) {
            echo '<a href="insert_comment.php?event_id=' . $event_id . '" class="btn btn-primary">Ajouter un commentaire</a>';
        }
        echo'</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="thumbnail">
                            <img alt="Image" src="images/event_images/' . $event_image . '" style="width:600px;height:400px;padding:2rem">
                        </div>
                        <p>Description : ' . $event_desc . '</p>
                        <p>Date de début : ' . $event_datestart . '</p>
                        <p>Date de début : ' . $event_dateend . '</p>
                        <p>Lieu : ' . $event_street . ' ' . $event_city . ' ' . $event_country . '</p>
                        <div class="pull-right"><a class="btn btn-primary" href="index.php" role="button">Accueil</a></div>
                    </div>
                 </div>';
    }
}

/**
 * Function that returns the events searched in the searchbar.
 * @param type $search_query        // The information to search.
 */
function searchAnEvent($search_query) {
    $query = "SELECT event.id_event, title, dateStart, dateEnd, image, street, city, iso_country FROM event, location WHERE event.id_location = location.id_location AND event.status = 1 AND title LIKE '%$search_query%'";
    $qr = myDatabase()->query($query);
    $results = $qr->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $event_id = $row['id_event'];
        $event_title = $row['title'];
        $event_datestart = $row['dateStart'];
        $event_dateend = $row['dateEnd'];
        $event_image = $row['image'];
        $event_street = $row['street'];
        $event_city = $row['city'];
        $event_country = $row['iso_country'];

        echo '<div class="row col-md-offset-0"><h1>Résultat(s) de la recherche "' . $search_query . '"</h1><br/>
                <div class="col-xs-6 col-lg-4">
                    <a href="event_details.php?event_id=' . $event_id . '" class="thumbnail">
                        <img alt="Image" src="images/event_images/' . $event_image . '" style="width:500px;height:300px;padding:2rem">
                    </a>
                    <h3>' . $event_title . '</h3>
                    <p>Date de début : ' . $event_datestart . '</p><p>Date de fin : ' . $event_dateend . '</p>
                    <p>Lieu : ' . $event_street . ' ' . $event_city . ' ' . $event_country . '</p>
                    <p><a class="btn btn-primary" href="event_details.php?event_id=' . $event_id . '" role="button">Détails</a></p>
                </div>';
    }
}

/**
 * Function that displays all the unban comments.
 * @param type $event_id        // The id of the event.
 */
function displayCommentUser($event_id) {
    $query = "SELECT comment.id_comment, time, text, nickname, avatar FROM comment, user, event WHERE event.id_event = $event_id AND comment.id_user = user.id_user AND comment.id_event = event.id_event AND comment.status = 1";
    $ps = myDatabase()->prepare($query);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $comment_id = $row['id_comment'];
        $comment_text = $row['text'];
        $comment_datetime = $row['time'];
        $comment_pseudo = $row['nickname'];
        $comment_avatar = $row['avatar'];

        echo '<div class = "panel-body">
                <div id="comments" class="col-lg-12">
                    <ul class="media-list forum">
                        <li class="media well">
                            <div class="pull-left user-info col-lg-1" href="#">
                                <img class="avatar img-circle img-thumbnail" src="images/avatar_images/' . $comment_avatar . '"
                                     width="64" alt="Generic placeholder image">
                                <br/>
                                <strong>' . $comment_pseudo . '</strong>
                                <br>
                            </div>
                            <div class="media-body">
                            ' . $comment_text . '
                            </div>
                            <div id="postOptions" class="media-right" style="width:100px;">' . $comment_datetime . '
                                <br/>
                                <br/>
                                <form method="POST" action="#">
                                <input type="hidden" name="hidden_id" value = ' . $comment_id . '> 
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>';
    }
}

/**
 * Function that displays all the comments ban and unban.
 * @param type $event_id        // The id of the event.
 */
function displayCommentAdmin($event_id) {
    $query = "SELECT comment.id_comment, time, text, nickname, avatar, comment.status FROM comment, user, event WHERE event.id_event = $event_id AND comment.id_user = user.id_user AND comment.id_event = event.id_event";
    $ps = myDatabase()->prepare($query);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $comment_id = $row['id_comment'];
        $comment_text = $row['text'];
        $comment_datetime = $row['time'];
        $comment_pseudo = $row['nickname'];
        $comment_avatar = $row['avatar'];
        $comment_status = $row['status'];

        echo '<div class = "panel-body">
                <div id="comments" class="col-lg-12">
                    <ul class="media-list forum">
                        <li class="media well">
                            <div class="pull-left user-info col-lg-1" href="#">
                                <img class="avatar img-circle img-thumbnail" src="images/avatar_images/' . $comment_avatar . '"
                                     width="64" alt="Generic placeholder image">
                                <br/>
                                <strong>' . $comment_pseudo . '</strong>
                                <br>
                            </div>
                            <div class="media-body">
                            ' . $comment_text . '
                            </div>
                            <div id="postOptions" class="media-right" style="width:100px;">' . $comment_datetime . '
                                <br/>
                                <br/>
                                <form method="POST" action="#">
                                <input type="hidden" name="hidden_idcommentadmin" value = ' . $comment_id . '>';
        if ($comment_status == 1) {
            echo '<button style="width:100px;" type="submit" name="ban_comment" class="btn btn-danger btn-sm">Bloquer <span class="glyphicon glyphicon-remove"></span></button><br/>';
        } else {
            echo '<button style="width:100px;"type="submit" name="unban_comment" class="btn btn-success btn-sm">Débloquer <span class="glyphicon glyphicon-ok"></span></button><br/>';
        }
        echo '<button onclick="return confirmDeletion()" style="width:100px;"type="submit" name="delete_comment" class="btn btn-primary btn-sm">Supprimer <span class="glyphicon glyphicon-trash"></span></button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>';
    }
}

/**
 * Function that modify the user informations from the database.
 * @param type $datas      // The informations that we insert into the database.
 */
function editUserData($datas) {
    $query = "UPDATE user SET name = :name, firstname = :firstname, organisation = :organisation, adress = :adress, avatar = :avatar, description = :description WHERE id_user = :id_user";
    $ps = myDatabase()->prepare($query);

    $ps->bindParam(':name', $datas['user_name'], PDO::PARAM_STR);
    $ps->bindParam(':firstname', $datas['user_firstname'], PDO::PARAM_STR);
    $ps->bindParam(':organisation', $datas['user_organisation'], PDO::PARAM_STR);
    $ps->bindParam(':adress', $datas['user_adress'], PDO::PARAM_STR);
    $ps->bindParam(':avatar', $datas['user_avatar'], PDO::PARAM_STR);
    $ps->bindParam(':description', $datas['user_desc'], PDO::PARAM_STR);
    $ps->bindParam(':id_user', $datas['user_id'], PDO::PARAM_STR);

    $ps->execute();
}

/**
 * Function that modify the event informations from the database.
 * @param type $datas      // The informations that we insert into the database.
 */
function editUserEvent($datas) {
    $query = "UPDATE event, location SET title = :title, street = :street, city = :city, iso_country = :iso_country, dateStart = :dateStart, dateEnd = :dateEnd, description = :description, image = :image WHERE id_event = :id_event AND event.id_location = location.id_location";
    $ps = myDatabase()->prepare($query);

    $ps->bindParam(':title', $datas['event_title'], PDO::PARAM_STR);
    $ps->bindParam(':street', $datas['event_street'], PDO::PARAM_STR);
    $ps->bindParam(':city', $datas['event_city'], PDO::PARAM_STR);
    $ps->bindParam(':iso_country', $datas['event_country'], PDO::PARAM_STR);
    $ps->bindParam(':dateStart', $datas['event_datestart'], PDO::PARAM_STR);
    $ps->bindParam(':dateEnd', $datas['event_dateend'], PDO::PARAM_STR);
    $ps->bindParam(':description', $datas['event_desc'], PDO::PARAM_STR);
    $ps->bindParam(':image', $datas['event_image'], PDO::PARAM_STR);
    $ps->bindParam(':id_event', $datas['event_id'], PDO::PARAM_STR);

    $ps->execute();
}

/**
 * Function that bans a comment.
 * @param type $datas       // The informations that we update into the database.
 */
function banComment($datas) {
    $query = "UPDATE comment SET status = 0 WHERE id_comment = :id_comment";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_comment', $datas['comment_id'], PDO::PARAM_STR);
    $ps->execute();
}

/**
 * Function that unbans a comment.
 * @param type $datas       // The informations that we update into the database.
 */
function unbanComment($datas) {
    $query = "UPDATE comment SET status = 1 WHERE id_comment = :id_comment";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_comment', $datas['comment_id'], PDO::PARAM_STR);
    $ps->execute();
}

/**
 * Function that delete from the database the selected event posted by the user.
 * @param type $datas       // The informations that we delete into the database.
 */
function deleteComment($datas) {
    $query = "DELETE FROM comment WHERE id_comment = :id_comment";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_comment', $datas['comment_id'], PDO::PARAM_STR);
    $ps->execute();
}

/**
 * Function that bans an event.
 * @param type $datas       // The informations that we update into the database.
 */
function banEvent($datas) {
    $query = "UPDATE event SET status = 0 WHERE id_event = :id_event ";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_event', $datas['event_id'], PDO::PARAM_STR);
    $ps->execute();
}

/**
 * Function that unbans an event.
 * @param type $datas       // The informations that we update into the database.
 */
function unbanEvent($datas) {
    $query = "UPDATE event SET status = 1 WHERE id_event = :id_event";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_event', $datas['event_id'], PDO::PARAM_STR);
    $ps->execute();
}

/**
 * Function that deletes an event.
 * @param type $datas       // The informations that we delete into the database.
 */
function deleteEvent($datas) {
    $query = "DELETE FROM event WHERE id_event = :id_event";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_event', $datas['event_id'], PDO::PARAM_STR);
    $ps->execute();
}

/**
 * Function that bans a user.
 * @param type $datas       // The informations that we update into the database.
 */
function banUser($datas) {
    $query = "UPDATE user SET status = 0 WHERE id_user = :id_user";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_user', $datas['user_id'], PDO::PARAM_STR);
    $ps->execute();
}

/**
 * Function that unbans a user.
 * @param type $datas       // The informations that we update into the database.
 */
function unbanUser($datas) {
    $query = "UPDATE user SET status = 1 WHERE id_user = :id_user";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_user', $datas['user_id'], PDO::PARAM_STR);
    $ps->execute();
}

/**
 * Function that deletes an user.
 * @param type $datas       // The informations that we delete into the database.
 */
function deleteUser($datas) {
    $query = "DELETE FROM user WHERE id_user = :id_user";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_user', $datas['user_id'], PDO::PARAM_STR);
    $ps->execute();
}

/**
 * Function that displays all the events posted by a user.
 * @param type $datas        // The informations that we select from the database.
 */
function displayAllUserEvents($datas) {
    $query = "SELECT event.id_event, title, dateStart, dateEnd, image, description, street, city, iso_country FROM event, location WHERE id_user = :id_user AND event.id_location = location.id_location";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_user', $datas['user_id'], PDO::PARAM_STR);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $event_id = $row['id_event'];
        $event_title = $row['title'];
        $event_street = $row['street'];
        $event_city = $row['city'];
        $event_country = $row['iso_country'];
        $event_datestart = $row['dateStart'];
        $event_dateend = $row['dateEnd'];
        $event_desc = $row['description'];
        $event_image = $row['image'];
        echo '<tr>
                    <td>' . $event_title . '</td>
                    <td>' . $event_street . '</td>
                    <td>' . $event_city . '</td>
                    <td>' . $event_country . '</td>
                    <td>' . $event_datestart . '</td>
                    <td>' . $event_dateend . '</td>
                    <td>' . $event_desc . '</td>
                    <td><img class="avatar img-circle img-thumbnail" src="images/event_images/' . $event_image . '"width="64" alt="Generic placeholder image">' . $event_image . '</td>
                    <td>
                    <form method="POST" action="#">
                    <input type="hidden" name="hidden_idevent" value = ' . $event_id . '>
                    <a href="edit_event.php?event_id=' . $event_id . '" class="btn btn-primary btn-sm">Modifier <span class="glyphicon glyphicon-pencil"></span></a>
                    <button onclick="return confirmDeletion()" style="width:100px;" type="submit" name="delete_userevent" class="btn btn-danger btn-sm">Supprimer <span class="glyphicon glyphicon-trash"></span></button></td>
                    </form>
                    </tr>';
    }
}

/**
 * Function that displays all the events posted by all the users.
 */
function displayAllAdminEvents() {
    $query = "SELECT * FROM event, location WHERE event.id_location = location.id_location";
    $ps = myDatabase()->prepare($query);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $event_status = $row['status'];
        $event_id = $row['id_event'];
        $event_title = $row['title'];
        $event_street = $row['street'];
        $event_city = $row['city'];
        $event_country = $row['iso_country'];
        $event_datestart = $row['dateStart'];
        $event_dateend = $row['dateEnd'];
        $event_desc = $row['description'];
        $event_image = $row['image'];
        echo '<tr>
                    <td>' . $event_title . '</td>
                    <td>' . $event_street . '</td>
                    <td>' . $event_city . '</td>
                    <td>' . $event_country . '</td>
                    <td>' . $event_datestart . '</td>
                    <td>' . $event_dateend . '</td>
                    <td>' . $event_desc . '</td>
                    <td><img class="avatar img-circle img-thumbnail" src="images/event_images/' . $event_image . '"width="64" alt="Generic placeholder image">' . $event_image . '</td>
                    <td>
                    <form method="POST" action="#">
                    <input type="hidden" name="hidden_ideventadmin" value = ' . $event_id . '>';
        if ($event_status == 1) {
            echo '<button style="width:100px ;" type="submit" name="ban_adminevent" class="btn btn-danger btn-sm">Bloquer <span class="glyphicon glyphicon-remove"></span></button>';
        } else {
            echo '<button style="width:100px;" type="submit" name="unban_adminevent" class="btn btn-success btn-sm">Débloquer <span class="glyphicon glyphicon-ok"></span></button>';
        }
        echo '<button onclick="return confirmDeletion()" style="width:100px; margin-left:5px;" type="submit" name="delete_adminevent" class="btn btn-primary btn-sm" > Supprimer <span class="glyphicon glyphicon-trash"></span></button></td>
                    </form>
                    </tr>';
    }
}

/**
 * Function that display all the users of the database.
 */
function displayAllUsers() {
    $query = "SELECT * FROM user WHERE privilege = 0";
    $ps = myDatabase()->prepare($query);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $user_id = $row['id_user'];
        $user_status = $row['status'];
        $user_email = $row['email'];
        $user_nickname = $row['nickname'];
        $user_name = $row['name'];
        $user_firstname = $row['firstname'];
        $user_organisation = $row['organisation'];
        $user_adress = $row['adress'];
        $user_avatar = $row['avatar'];
        $user_desc = $row['description'];
        echo '<tr>
                    <td>' . $user_email . '</td>
                    <td>' . $user_nickname . '</td>
                    <td>' . $user_name . '</td>
                    <td>' . $user_firstname . '</td>
                    <td>' . $user_organisation . '</td>
                    <td>' . $user_adress . '</td>
                    <td><img class="avatar img-circle img-thumbnail" src="images/avatar_images/' . $user_avatar . '"width="64" alt="Generic placeholder image">' . $user_avatar . '</td>
                    <td>' . $user_desc . '</td>
                        <td>
                    <form method="POST" action="#">
                    <input type="hidden" name="hidden_iduseradmin" value = ' . $user_id . '>';
        if ($user_status == 1) {
            echo '<button style="width:100px ;" type="submit" name="ban_adminuser" class="btn btn-danger btn-sm">Bloquer <span class="glyphicon glyphicon-remove"></span></button>';
        } else {
            echo '<button style="width:100px;" type="submit" name="unban_adminuser" class="btn btn-success btn-sm">Débloquer <span class="glyphicon glyphicon-ok"></span></button>';
        }
        echo '<button onclick="return confirmDeletion()" style="width:100px; margin-left:5px;" type="submit" name="delete_adminuser" class="btn btn-primary btn-sm">Supprimer <span class="glyphicon glyphicon-trash"></span></button></td>
                    </form>
            </tr>';
    }
}

/**
 * Function that displays the profile of a user.
 * @param type $datas        // The informations that we update into the database.
 */
function displayUserProfile($datas) {
    $query = "SELECT * FROM user WHERE id_user = :id_user";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_user', $datas['user_id'], PDO::PARAM_STR);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $row) {
        $user_email = $row['email'];
        $user_nickname = $row['nickname'];
        $user_name = $row['name'];
        $user_firstname = $row['firstname'];
        $user_organisation = $row['organisation'];
        $user_adress = $row['adress'];
        $user_avatar = $row['avatar'];
        $user_desc = $row['description'];
        echo '<tr>
                    <td>' . $user_email . '</td>
                    <td>' . $user_nickname . '</td>
                    <td>' . $user_name . '</td>
                    <td>' . $user_firstname . '</td>
                    <td>' . $user_organisation . '</td>
                    <td>' . $user_adress . '</td>
                    <td><img class="avatar img-circle img-thumbnail" src="images/avatar_images/' . $user_avatar . '"width="64" alt="Generic placeholder image">' . $user_avatar . '</td>
                    <td>' . $user_desc . '</td>
            </tr>';
    }
}

/**
 * Function that select all the informations of the event and put them in an array.
 * @param type $datas       // The informations that we select into the database.
 * @return type     // The array with the selected info from the database.
 */
function getEventInfo($datas) {
    $query = "SELECT * FROM event, location WHERE id_event = :id_event AND event.id_location = location.id_location";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_event', $datas['event_id'], PDO::PARAM_STR);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

/**
 * Function that select all the informations of the user and put them in an array.
 * @return type     // The array with the selected info from the database.
 */
function getUserInfo() {
    $user_id = getUserId();
    $query = "SELECT * FROM user WHERE id_user = :id_user";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_user', $user_id, PDO::PARAM_STR);
    $ps->execute();
    $results = $ps->fetchAll(PDO::FETCH_ASSOC);
    return $results;
}

//-------------------- GENERAL FUNCTIONS --------------------\\

// Upload constants.
define('INPUT', 'event_image'); // The name of the input file.
define('TARGET', './images/event_images/');    // The target directory for the event image.
define('TARGET2', './images/avatar_images/');    // The target directory for the avatar image.
define('MAX_SIZE', 10000000);    // Maximum size in octets for the file.
define('WIDTH_MAX', 2000);    // Maximum width in pixels for the file.
define('HEIGHT_MAX', 2000);    // Maximum height in pixels for the file.

/**
 * Fonction that uploads the event image in the correct folder.
 * @return type     // The error messages.
 */
function uploadEventImage() {

    $tabExt = array('jpg', 'JPG', 'PNG', 'JPEG', 'GIF', 'TIFF', 'BMP', 'gif', 'png', 'jpeg', 'bmp', 'tiff');    // Allowed extensions.
    $infosImg = array();

    // Variables.
    $extension = '';
    $message = '';
    $nomImage = '';

    $status = false;

    // Create the repository if it doesn't exists.
    if (!is_dir(TARGET)) {
        if (!mkdir(TARGET, 0755)) {
            exit('Erreur : le répertoire cible ne peut être créé ! Vérifiez que vous disposiez des droits suffisants pour le faire ou créez le manuellement !');
        }
    }
    // Check if the field is filled.
    if (!empty($_FILES[INPUT]['name'])) {
        // Get the file extension.
        $extension = pathinfo($_FILES[INPUT]['name'], PATHINFO_EXTENSION);
        // Check the file extension.
        if (in_array(strtolower($extension), $tabExt)) {
            // Get the size of the file.
            if (!$_FILES[INPUT]['tmp_name'] == "") {
                $infosImg = getimagesize($_FILES[INPUT]['tmp_name']);
                // Check the type of file and the header (if it's not an image file).
                if ($infosImg[2] >= 1 && $infosImg[2] <= 14) {
                    // Check the size and dimension of the file.
                    if (($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES[INPUT]['tmp_name']) <= MAX_SIZE)) {
                        // Run through the errors array
                        if (isset($_FILES[INPUT]['error']) && UPLOAD_ERR_OK === $_FILES[INPUT]['error']) {
                            // Rename the file with a uniq id.
                            $nomImage = uniqid() . '.' . $extension;
                            // Store the value in session.
                            $_SESSION['imageevent_name'] = $nomImage;

                            // If it's ok then test the upload.
                            if (move_uploaded_file($_FILES[INPUT]['tmp_name'], TARGET . $nomImage)) {
                                $message = 'Upload réussi !';
                                $status = true;
                            } else {
                                // Else, display a system error.
                                $message = 'Problème lors de l\'upload !';
                            }
                        } else {
                            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
                        }
                    } else {
                        // Else, display a size image error.
                        $message = 'Erreur dans les dimensions de l\'image !';
                    }
                }
            } else {
                // Else, display a type of image error.
                $message = 'Le fichier envoyé n\'est pas une image, ou le fichier est trop grand,merci de consulter l\'aide en ligne!';
            }
        } else {
            // Else, display an extension error.
            $message = 'L\'extension du fichier est incorrecte !';
        }
    } else {
        // Else, display an empty file error.
        $message = 'Veuillez remplir le formulaire svp !';
    }
    return array($message, $status);
}

/**
 * Fonction that uploads the avatar image in the correct folder.
 * @return type     // The error messages.
 */
function uploadAvatarImage() {

    $tabExt = array('jpg', 'JPG', 'PNG', 'JPEG', 'GIF', 'TIFF', 'BMP', 'gif', 'png', 'jpeg', 'bmp', 'tiff');    // Allowed extensions.
    $infosImg = array();

    // Variables.
    $extension = '';
    $message = '';
    $nomImage = '';

    $status = false;

    // Create the repository if it doesn't exists.
    if (!is_dir(TARGET2)) {
        if (!mkdir(TARGET2, 0755)) {
            exit('Erreur : le répertoire cible ne peut être créé ! Vérifiez que vous disposiez des droits suffisants pour le faire ou créez le manuellement !');
        }
    }
    // Check if the field is filled.
    if (!empty($_FILES[INPUT]['name'])) {
        // Get the file extension.
        $extension = pathinfo($_FILES[INPUT]['name'], PATHINFO_EXTENSION);
        // Check the file extension.
        if (in_array(strtolower($extension), $tabExt)) {
            // Get the size of the file.
            if (!$_FILES[INPUT]['tmp_name'] == "") {
                $infosImg = getimagesize($_FILES[INPUT]['tmp_name']);
                // Check the type of file and the header (if it's not an image file).
                if ($infosImg[2] >= 1 && $infosImg[2] <= 14) {
                    // Check the size and dimension of the file.
                    if (($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES[INPUT]['tmp_name']) <= MAX_SIZE)) {
                        // Run through the errors array
                        if (isset($_FILES[INPUT]['error']) && UPLOAD_ERR_OK === $_FILES[INPUT]['error']) {
                            // Rename the file with a uniq id.
                            $nomImage = uniqid() . '.' . $extension;
                            // Store the value in session.
                            $_SESSION['imageavatar_name'] = $nomImage;

                            // If it's ok then test the upload.
                            if (move_uploaded_file($_FILES[INPUT]['tmp_name'], TARGET2 . $nomImage)) {
                                $message = 'Upload réussi !';
                                $status = true;
                            } else {
                                // Else, display a system error.
                                $message = 'Problème lors de l\'upload !';
                            }
                        } else {
                            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
                        }
                    } else {
                        // Else, display a size image error.
                        $message = 'Erreur dans les dimensions de l\'image !';
                    }
                }
            } else {
                // Else, display a type of image error.
                $message = 'Le fichier envoyé n\'est pas une image, ou le fichier est trop grand,merci de consulter l\'aide en ligne!';
            }
        } else {
            // Else, display an extension error.
            $message = 'L\'extension du fichier est incorrecte !';
        }
    } else {
        // Else, display an empty file error.
        $message = 'Veuillez remplir le formulaire svp !';
    }
    return array($message, $status);
}

//-------------------- SESSION FUNCTIONS --------------------\\

/**
 * Function that checks if the user is logged or not.
 * @return boolean True     // If logged return TRUE.
 */
function isLoggedIn() {
    return (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
}

/**
 * Function that returns the id of the user from the sessions.
 * @return type     // The id of the user from the sessions.
 */
function getUserId() {
    return (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : -1;
}

/**
 * Function that define if the user is logged or not.
 * @param type $value       // TRUE if logged or FALSE if not.
 */
function setLoggedIn($value) {
    $_SESSION['login'] = $value;
}

/**
 * Function that sets the group in the session.
 * @param type $value       // The group you want to put in session.
 */
function setUserGroup($value) {
    $_SESSION['group'] = $value;
}

/**
 * Function that returns the group of the user from the session.
 * @return type     // Return the group of the user.
 */
function getUserGroup() {
    return (isset($_SESSION['group'])) ? $_SESSION['group'] : -1;
}

/**
 * Function that disconnect the user and destroy the session.
 */
function logOutUser() {
    $_SESSION = array();
    session_destroy();
}

/**
 * Function that sets the privilege to member.
 * @return type     // The privilege 0 (member).
 */
function isUserMember() {
    return (getUserGroup() == 0);
}

/**
 * Function that sets the privilege to admin.
 * @return type     // The privilege 1 (admin).
 */
function isUserAdmin() {
    return (getUserGroup() == 1);
}
