<?php

require 'mysql.inc.php';

// Function that creates a database connector.
function &myDatabase() {
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

// Function that inserts new events to the database.
function insertNewEvent($datas) {
    $query1 = "INSERT INTO endroit (rue, ville, pays) VALUES (:street, :city, :country)";
    $query2 = "SELECT id FROM endroit WHERE rue = :street AND ville = :city AND iso_pays = :country";
    $query3 = "INSERT INTO evenement (titre, dateDebut, dateFin, description, image, id_endroit, id_utilisateur) VALUES (:title, :datestart, :dateend, :desc, :image, :id_endroit, :id_utilisateur)";

    $ps1 = myDatabase()->prepare($query1);
    $ps2 = myDatabase()->prepare($query2);
    $ps3 = myDatabase()->prepare($query3);

    $ps1->bindParam(':street', $datas['event_street'], PDO::PARAM_STR);
    $ps1->bindParam(':city', $datas['event_city'], PDO::PARAM_STR);
    $ps1->bindParam(':country', $datas['event_country'], PDO::PARAM_STR);

    $ps2->bindParam(':street', $datas['event_street'], PDO::PARAM_STR);
    $ps2->bindParam(':city', $datas['event_city'], PDO::PARAM_STR);
    $ps2->bindParam(':country', $datas['event_country'], PDO::PARAM_STR);

    $ps1->execute();
    $isok = $ps2->execute();
    $isok = $ps2->fetchAll(PDO::FETCH_NUM);

    $ps3->bindParam(':title', $datas['event_title'], PDO::PARAM_STR);
    $ps3->bindParam(':datestart', $datas['event_datestart'], PDO::PARAM_STR);
    $ps3->bindParam(':dateend', $datas['event_dateend'], PDO::PARAM_STR);
    $ps3->bindParam(':desc', $datas['event_desc'], PDO::PARAM_STR);
    $ps3->bindParam(':image', $datas['event_image'], PDO::PARAM_STR);
    $ps3->bindParam(':id_endroit', $isok[0][0]);
    $ps3->bindParam(':id_utilisateur', $datas['user_id'], PDO::PARAM_STR);

    $ps3->execute();
}

// Function that sets the folder where the event images are uploaded.
function getEventImageDir() {
    return getcwd() . '/images/event_images/';
}

// Function that uploads the event image in the correct folder.
function uploadEventImage($folder, $file, $id) {
    $max_size = 10000000;       // The max size of the image.
    $size = $file['size'];       // The size of the image to upload.
    $extensions = array('.png', '.gif', '.jpg', '.jpeg', '.tiff', '.JPG', '.PNG', '.GIF', '.TIFF', '.JPEG');       // The allowed extensions.
    $extension = strrchr($file['name'], '.');

    // Start of the security check.
    if (!in_array($extension, $extensions)) { // If the extension is not in the array.
        $error = 'Yous must upload a file with the folowing extensions png, gif, tiff, jpg or jpeg';
    }
    if ($size > $max_size) {       // If the size is bigger than the max size.
        $error = 'The file you want to upload is to big!';
    }
    if (!isset($error)) { // If there's no errors upload the file.
        $file['name'] = $id . $extension;
        if (move_uploaded_file($file['tmp_name'], $folder . $file['name'])) { // If the function returns TRUE the upload is a succes.
            // Rename the image with it's event_id from the database.
            renameImageWithId($id, $extension);
            echo 'Upload done with succes!';
        } else { // Else return FALSE
            echo 'The upload has failed!';
        }
    } else {
        echo $error;
    }
}

// Function that selects an event from a name and changes it with it's event_id.
function selectIdEventFromName($name) {
    $query = "SELECT * FROM evenement WHERE titre = :titre";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':titre', $name);
    $ps->execute();
    $temp = $ps->fetch(PDO::FETCH_OBJ);
    $id = $temp->id;

    return $id;
}

// Function that renames the image with it's event_id from the database.
function renameImageWithId($id, $extension) {
    $temp = $id . $extension;
    $query = "UPDATE evenement SET image = :temp WHERE id = :id";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':temp', $temp);
    $ps->bindParam(':id', $id);
    $ps->execute();
}

// TO FINISH!!! (add the table "endroit" informations)
// Function that displays all the events order by the date of creation. 
function getAllEvents() {
    $query = "SELECT * FROM evenement ORDER BY dateDebut";
    $qr = myDatabase()->prepare($query);
    $qr->execute();
    $test = $qr->fetchAll(PDO::FETCH_ASSOC);
    foreach ($test as $row) {
        $event_id = $row['id'];
        $event_title = $row['titre'];
        $event_datestart = $row['dateDebut'];
        $event_dateend = $row['dateFin'];
        $event_desc = $row['description'];
        $event_image = $row['image'];

        echo "<div class='col-xs-6 col-lg-4'>
                  <a href='event_details.php?event_id=$event_id' class='thumbnail' >
                    <img alt='Image' src='images/event_images/$event_image' style='width:500px;height:300px;padding:2rem'>
                  </a>
                  <h3>$event_title</h3>
                  <p>$event_desc</p>
                  <p><a class='btn btn-default' href='event_details.php?event_id=$event_id' role='button'>Détails &raquo;</a></p>
                  </div>";
    }
}

// Function that displays the details of an event.
function getEventDetail($event_id) {
    $query = "SELECT * FROM evenement WHERE id='$event_id'";
    $qr = myDatabase()->prepare($query);
    $qr->execute();
    $test = $qr->fetchAll(PDO::FETCH_ASSOC);
    foreach ($test as $row) {
        $event_id = $row['id'];
        $event_title = $row['titre'];
        $event_datestart = $row['dateDebut'];
        $event_dateend = $row['dateFin'];
        $event_desc = $row['description'];
        $event_image = $row['image'];

        echo "<div class='panel'>
                    <div class='panel-heading'>
                        <div class='text-center'>
                            <div class='row'>
                                <div class='col-sm-9'>
                                    <h1 class='pull-left'>$event_title</h1>
                                </div>
                                <div class='col-sm-3'>
                                    <h4 class='pull-right'>
                                        <a href='insert_comment.php?event_id=$event_id'>Ajouter un commentaire</a>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <div class='thumbnail'>
                            <img alt='Image' src='images/event_images/$event_image' style='width:600px;height:400px;padding:2rem'>
                        </div>
                        $event_desc<br/>
                        <a class='btn btn-default' href='index.php' role='button'>Accueil &raquo</a>
                    </div>
                 </div>";
    }
}

// Function that inserts new users to the database.
function insertNewUser($datas) {
    $query = "INSERT INTO utilisateur (email, pseudo, password) VALUES (:email, :pseudo, :password)";

    $ps = myDatabase()->prepare($query);

    $ps->bindParam(':email', $datas['event_email'], PDO::PARAM_STR);
    $ps->bindParam(':pseudo', $datas['event_pseudo'], PDO::PARAM_STR);
    $ps->bindParam(':password', $datas['event_password'], PDO::PARAM_STR);

    $ps->execute();
}

// Function that checks if the user is logged, with the correct credentials.
function checkUser($datas) {
    $sql = "SELECT * FROM utilisateur where email = :email ";

    $ps = myDatabase()->prepare($sql);
    try {
        $ps->bindParam(':email', $datas['email'], PDO::PARAM_STR);
        $isok = $ps->execute();
        $isok = $ps->fetchAll(PDO::FETCH_NUM);
        if (count($isok)) {
            if ($isok[0][1] == $datas['email'] && $isok[0][3] == sha1($datas['password'])) {
                // Store the user ID in session.
                $_SESSION['userid'] = $isok[0][0];

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

// Function that returns the group id of the user.
function getGroup($datas) {
    $sql = "SELECT privilege FROM utilisateur WHERE email = :email";

    $ps = myDatabase()->prepare($sql);
    try {
        $ps->bindParam(':email', $datas['email'], PDO::PARAM_STR);

        $isok = $ps->execute();
        $isok = $ps->fetchAll(PDO::FETCH_NUM);
    } catch (PDOException $e) {
        $isok = false;
    }
    return $isok[0][0];
}

// Function that returns the events searched in the searchbar.
function searchAnEvent($search_query) {
    $query = "SELECT * FROM evenement WHERE description LIKE '%$search_query%' OR titre LIKE '%$search_query%'";
    $qr = myDatabase()->query($query);
    $test = $qr->fetchAll(PDO::FETCH_ASSOC);
    foreach ($test as $row) {
        $event_id = $row['id'];
        $event_title = $row['titre'];
        $event_datestart = $row['dateDebut'];
        $event_dateend = $row['dateFin'];
        $event_desc = $row['description'];
        $event_image = $row['image'];

        echo "<div class='col-xs-6 col-lg-4'>
                  <a href='event_details.php' class='thumbnail'>
                    <img alt='Image' src='images/event_images/$event_image' style='width:500px;height:300px;padding:2rem'>
                  </a>
                  <h3>$event_title</h3>
                  <p>$event_desc</p>
                  <p><a class='btn btn-default' href='event_details.php?event_id=$event_id' role='button'>Détails &raquo;</a></p>
                  </div>";
    }
}

/**
 * L'utilisateur est-il loggé ?
 * @return boolean True si loggé
 */
function isLoggedIn() {
    return (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
}

/**
 * Défini si l'utilisateur est loggué ou non
 * @param {boolean} $value  True pour loggué, autrement false
 */
function setLoggedIn($value) {
    $_SESSION['login'] = $value;
}

/**
 * Défini le groupe dans la session
 * @param type $value Le nom du groupe
 */
function setUserGroup($value) {
    $_SESSION['group'] = $value;
}

/**
 * Récupère le nom du groupe de l'utilisateur
 * @return type
 */
function getUserGroup() {
    return (isset($_SESSION['group'])) ? $_SESSION['group'] : 0;
}

/**
 * Est-ce que l'utilisateur connecté est Membre
 * @return type
 */
function isUserMember() {
    return (getUserGroup() == 1);
}

/**
 * Est-ce que l'utilisateur connecté est Administrateur
 * @return type
 */
function isUserAdmin() {
    return (getUserGroup() == 2);
}

function getUserId() {
    return (isset($_SESSION['userid'])) ? $_SESSION['userid'] : -1;
}

/**
 * Déconnecte l'utilisateur
 */
function logOutUser() {
    $_SESSION = array();
    session_destroy();
}

// Function that gets the different countries and put them in an option list
function getCountriesList() {
    $query = "SELECT * FROM pays";
    $qr = myDatabase()->query($query);
    $result = $qr->fetchAll();

    foreach ($result as $row) {
        $country_iso = $row['iso'];
        $country_title = $row['name'];
        echo "<option value='$country_iso'>$country_title</option>";
    }
}

// Function that inserts comments to the database.
function insertNewComment($datas) {
    $query1 = "INSERT INTO commentaire (time, texte, id_utilisateur, id_evenement) VALUES (:time, :text, :id_utilisateur, :id_evenement)";

    $ps1 = myDatabase()->prepare($query1);

    $ps1->bindParam(':time', $datas['comment_time'], PDO::PARAM_STR);
    $ps1->bindParam(':text', $datas['comment_text'], PDO::PARAM_STR);
    $ps1->bindParam(':id_utilisateur', $datas['user_id'], PDO::PARAM_STR);
    $ps1->bindParam(':id_evenement', $datas['event_id'], PDO::PARAM_STR);

    $ps1->execute();
}

// TO DO (NOT ALL THE USERS CAN DISPLAY THEIR COMMENTS)
// Function that displays all the comments of an event.
function displayEventComment($event_id) {
    $query = "SELECT time,texte,pseudo FROM commentaire,utilisateur,evenement WHERE evenement.id='$event_id' and utilisateur.id = evenement.id_utilisateur and  commentaire.id_utilisateur = utilisateur.id and commentaire.id_evenement = evenement.id";
    $qr = myDatabase()->prepare($query);
    $qr->execute();
    $test = $qr->fetchAll(PDO::FETCH_ASSOC);
    foreach ($test as $row) {
        $comment_text = $row['texte'];
        $comment_datetime = $row['time'];
        $comment_pseudo = $row['pseudo'];

        echo "<div class = 'panel-body'>
                <div id='comments' class='col-lg-12'>
                    <ul class='media-list forum'>
                        <!-- Forum Post -->
                        <li class='media well'>
                            <div class='pull-left user-info col-lg-1' href='#'>
                                <img class='avatar img-circle img-thumbnail' src='http://snipplicious.com/images/guest.png'
                                     width='64' alt='Generic placeholder image'>
                                <br/>
                                <strong>$comment_pseudo</strong>
                                <br>

                            </div>
                            <div class='media-body'>
                            $comment_text
                            </div>
                            <div id='postOptions' class='media-right'>$comment_datetime
                                <br/>
                                <a href='#'><span class='input-group-addon'><i class='glyphicon glyphicon-exclamation-sign'></i></span></a>
                                <br/>
                                <a href='#'><span class='input-group-addon'><i class='glyphicon glyphicon-remove-sign'></i></span></a>
                            </div>
                        </li>
                        <!-- Forum Post END -->
                    </ul>
                </div>
            </div>";
    }
}
