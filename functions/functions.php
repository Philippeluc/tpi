<?php

require 'mysql.inc.php';

/**
 * Function that creates a database connector.
 * @staticvar type $dbc
 * @return \PDO
 */
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

/**
 * Function that inserts new events to the database.
 * @param type $datas
 */
function insertNewEvent($datas) {
    $query1 = "INSERT INTO tpi.endroit (rue, ville, iso_pays) VALUES (:street, :city, :country)";
    $query2 = "SELECT id FROM tpi.endroit WHERE rue = :street AND ville = :city AND iso_pays = :country";
    $query3 = "INSERT INTO tpi.evenement (titre, dateDebut, dateFin, description, image, id_endroit, id_utilisateur) VALUES (:title, :datestart, :dateend, :desc, :image, :id_endroit, :id_utilisateur)";

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

/**
 * Function that sets the folder where the event images are uploaded.
 * @return type
 */
function getEventImageDir() {
    return getcwd() . '/images/event_images/';
}

/**
 * Function that sets the folder where the users avatar are uploaded.
 * @return type
 */
function getUserImageDir() {
    return getcwd() . '/images/avatar_images/';
}

/**
 * Function that uploads the event image in the correct folder.
 * @param type $folder
 * @param string $file
 * @param type $id
 */
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
        $file['name'] = $id . '_event' . $extension;
        if (move_uploaded_file($file['tmp_name'], $folder . $file['name'])) { // If the function returns TRUE the upload is a succes.
            // Rename the image with it's event_id from the database.
            renameEventImageWithId($id, $extension);
            echo 'Upload done with succes!';
        } else { // Else return FALSE
            echo 'The upload has failed!';
        }
    } else {
        echo $error;
    }
}

/**
 * Function that uploads the user avatar in the correct folder.
 * @param type $folder
 * @param string $file
 * @param type $id
 */
function uploadUserImage($folder, $file, $id) {
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
        $file['name'] = $id . '_avatar' . $extension;
        if (move_uploaded_file($file['tmp_name'], $folder . $file['name'])) { // If the function returns TRUE the upload is a succes.
            // Rename the image with it's user_id from the database.
            renameUserImageWithId($id, $extension);
            echo 'Upload done with succes!';
        } else { // Else return FALSE
            echo 'The upload has failed!';
        }
    } else {
        echo $error;
    }
}

/**
 * Function that selects an event from a name and changes it with it's event_id.
 * @param type $name
 * @return type
 */
function selectIdEventFromName($name) {
    $query = "SELECT * FROM evenement WHERE titre = :titre";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':titre', $name);
    $ps->execute();
    $temp = $ps->fetch(PDO::FETCH_OBJ);
    $id = $temp->id;

    return $id;
}

/**
 * Function that selects a user from an email and changes it with it's user_id.
 * @param type $email
 * @return type
 */
function selectIdUsersFromName($email) {
    $query = "SELECT * FROM utilisateur WHERE email = :email";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':email', $email);
    $ps->execute();
    $temp = $ps->fetch(PDO::FETCH_OBJ);
    $id = $temp->id;

    return $id;
}

/**
 * Function that renames the image with it's event_id from the database.
 * @param type $id
 * @param type $extension
 */
function renameEventImageWithId($id, $extension) {
    $temp = $id . '_event' . $extension;
    $query = "UPDATE evenement SET image = :temp WHERE id = :id";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':temp', $temp);
    $ps->bindParam(':id', $id);
    $ps->execute();
}

/**
 * Function that renames the image with it's user_id from the database.
 * @param type $id
 * @param type $extension
 * @return type
 */
function renameUserImageWithId($id, $extension) {
    $temp = $id . '_avatar' . $extension;
    $query = "UPDATE utilisateur SET avatar = :temp WHERE id = :id";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':temp', $temp);
    $ps->bindParam(':id', $id);
    $isok = $ps->execute();
    return $isok;
}

/**
 * TO FINISH!!! (add the informations of the table "endroit").
 * Function that displays all the events order by the date of creation. 
 */
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
                  <p>Date de début :$event_datestart</p><p>Date de fin : $event_dateend</p>
                  <p><a class='btn btn-default' href='event_details.php?event_id=$event_id' role='button'>Détails &raquo;</a></p>
                  </div>";
    }
}

/**
 * Function that displays the details of an event.
 * @param type $event_id
 */
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
                        <div class='pull-right'><a class='btn btn-default' href='index.php' role='button'>Accueil &raquo</a></div>
                    </div>
                 </div>";
    }
}

/**
 * Function that inserts a user in the database.
 * @param type $datas
 */
function insertNewUser($datas) {
    $query = "INSERT INTO utilisateur (email, pseudo, password) VALUES (:email, :pseudo, :password)";

    $ps = myDatabase()->prepare($query);

    $ps->bindParam(':email', $datas['event_email'], PDO::PARAM_STR);
    $ps->bindParam(':pseudo', $datas['event_pseudo'], PDO::PARAM_STR);
    $ps->bindParam(':password', $datas['event_password'], PDO::PARAM_STR);

    $ps->execute();
}

/**
 * Function that checks if the user is logged, with the correct credentials.
 * @param type $datas
 * @return boolean
 */
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
                $_SESSION['useremail'] = $isok[0][1];

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
 * Function that returns the group id of the user.
 * @param type $datas
 * @return boolean
 */
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

/**
 * Function that returns the events searched in the searchbar.
 * @param type $search_query
 */
function searchAnEvent($search_query) {
    $query = "SELECT * FROM evenement WHERE titre LIKE '%$search_query%'";
    $qr = myDatabase()->query($query);
    $test = $qr->fetchAll(PDO::FETCH_ASSOC);
    foreach ($test as $row) {
        $event_id = $row['id'];
        $event_title = $row['titre'];
        $event_datestart = $row['dateDebut'];
        $event_dateend = $row['dateFin'];
        $event_desc = $row['description'];
        $event_image = $row['image'];

        echo "<div class='row col-md-offset-0'>
                <h1>Résultats de la recherche \"$search_query\"</h1><br/>
              </div>
                  <div class='col-xs-6 col-lg-4'>
                  <a href='event_details.php' class='thumbnail'>
                    <img alt='Image' src='images/event_images/$event_image' style='width:500px;height:300px;padding:2rem'>
                  </a>
                  <h3>$event_title</h3>
                  <p>Date de début :$event_datestart</p><p>Date de fin : $event_dateend</p>
                  <p><a class='btn btn-default' href='event_details.php?event_id=$event_id' role='button'>Détails &raquo;</a></p>
                  </div>";
    }
}

/**
 * Function that gets the different countries and put them into an option list.
 */
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

/**
 * Function that inserts comments to the database.
 * @param type $datas
 */
function insertNewComment($datas) {
    $query1 = "INSERT INTO commentaire (time, texte, id_utilisateur, id_evenement) VALUES (:time, :text, :id_utilisateur, :id_evenement)";

    $ps1 = myDatabase()->prepare($query1);

    $ps1->bindParam(':time', $datas['comment_time'], PDO::PARAM_STR);
    $ps1->bindParam(':text', $datas['comment_text'], PDO::PARAM_STR);
    $ps1->bindParam(':id_utilisateur', $datas['user_id'], PDO::PARAM_STR);
    $ps1->bindParam(':id_evenement', $datas['event_id'], PDO::PARAM_STR);

    $ps1->execute();
}

/**
 * Function that displays all the comments of an event.
 * @param type $event_id
 */
function displayEventComment($event_id) {
    $query = "SELECT time,texte,pseudo,avatar FROM commentaire,utilisateur,evenement WHERE evenement.id= $event_id and   commentaire.id_utilisateur = utilisateur.id and commentaire.id_evenement = evenement.id";
    $qr = myDatabase()->prepare($query);
    $qr->execute();
    $test = $qr->fetchAll(PDO::FETCH_ASSOC);
    foreach ($test as $row) {
        $comment_text = $row['texte'];
        $comment_datetime = $row['time'];
        $comment_pseudo = $row['pseudo'];
        $comment_avatar = $row['avatar'];

        echo "<div class = 'panel-body'>
                <div id='comments' class='col-lg-12'>
                    <ul class='media-list forum'>
                        <!-- Forum Post -->
                        <li class='media well'>
                            <div class='pull-left user-info col-lg-1' href='#'>
                                <img class='avatar img-circle img-thumbnail' src='images/avatar_images/$comment_avatar'
                                     width='64' alt='Generic placeholder image'>
                                <br/>
                                <strong>$comment_pseudo</strong>
                                <br>

                            </div>
                            <div class='media-body'>
                            $comment_text
                            </div>
                            <div id='postOptions' class='media-right' style='width:100px;'>$comment_datetime
                                <br/>
                                <br/>
                                <a href='#'><span class='input-group-addon' style='color:red;'><b>BAN </b><i class='glyphicon glyphicon-remove'></i></span></a>
                                <br/>
                                <a href='#'><span class='input-group-addon'style='color:green;'><b>UNBAN </b><i class='glyphicon glyphicon-ok'></i></span></a>
                                <br/>
                                <a href='#'><span class='input-group-addon'><b>DELETE </b><i class='glyphicon glyphicon-trash'></i></span></a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>";
    }
}

/**
 * Function that modify the user informations from the database.
 * @param type $datas
 */
function editUserData($datas) {
    $query3 = "UPDATE utilisateur SET nom = :name, prenom = :firstname, organisation = :organisation, adresse = :adress, avatar = :avatar, description = :description WHERE id = :id_utilisateur";
    $ps3 = myDatabase()->prepare($query3);

    $ps3->bindParam(':name', $datas['user_name'], PDO::PARAM_STR);
    $ps3->bindParam(':firstname', $datas['user_firstname'], PDO::PARAM_STR);
    $ps3->bindParam(':organisation', $datas['user_organisation'], PDO::PARAM_STR);
    $ps3->bindParam(':adress', $datas['user_adress'], PDO::PARAM_STR);
    $ps3->bindParam(':avatar', $datas['user_avatar'], PDO::PARAM_STR);
    $ps3->bindParam(':description', $datas['user_desc'], PDO::PARAM_STR);
    $ps3->bindParam(':id_utilisateur', $datas['user_id'], PDO::PARAM_STR);

    $ps3->execute();
}

// Function that modify the event informations from the database.
//function editEventData($datas) {
//    $query3 = "UPDATE evenement SET titre = :title, description = :description, dateDebut = :datestart, dateFin = :dateend, image = :image WHERE id = :id_evenement";
//    $ps3 = myDatabase()->prepare($query3);
//
//    $ps3->bindParam(':title', $datas['event_title'], PDO::PARAM_STR);
//    $ps3->bindParam(':description', $datas['event_desc'], PDO::PARAM_STR);
//    $ps3->bindParam(':datestart', $datas['event_datestart'], PDO::PARAM_STR);
//    $ps3->bindParam(':dateend', $datas['event_dateend'], PDO::PARAM_STR);
//    $ps3->bindParam(':image', $datas['event_image'], PDO::PARAM_STR);
//    $ps3->bindParam(':id_evenement', $datas['event_id'], PDO::PARAM_STR);
//
//    $ps3->execute();
//}

/**
 * Function that displays all the events posted by a user.
 * @param type $datas
 */
function displayEventFromUser($datas) {
    $query = "SELECT evenement.id,evenement.titre FROM evenement WHERE id_utilisateur = :id_utilisateur";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_utilisateur', $datas['user_id'], PDO::PARAM_STR);
    $ps->execute();
    $test = $ps->fetchAll(PDO::FETCH_ASSOC);
    echo '<select name="id_event" class="input-sm"><option>Séléctionner un événement</option>';
    foreach ($test as $row) {
        $id = $row['id'];
        $title = $row['titre'];

        echo "<div><option value='$id'>$title</option></div>";
    }
    echo '</select>';
}

function deleteSelectedEventFromUser($datas) {
    $query = "DELETE FROM evenement WHERE id = :id_evenement";
    $ps = myDatabase()->prepare($query);
    $ps->bindParam(':id_evenement', $datas['event_id'], PDO::PARAM_STR);
    $ps->execute();
}

//<---------- SESSIONS FUNCTIONS END ---------->

/**
 * Function that checks if the user is logged or not.
 * @return boolean True     // If logged return TRUE.
 */
function isLoggedIn() {
    return (isset($_SESSION['login'])) ? $_SESSION['login'] : false;
}

/**
 * Function that define if the user in logged or not.
 * @param {boolean} $value  // Return TRUE if logged or FALSE if not.
 */
function setLoggedIn($value) {
    $_SESSION['login'] = $value;
}

/**
 * Function that sets the group in the session.
 * @param type $value       // The name of the group.
 */
function setUserGroup($value) {
    $_SESSION['group'] = $value;
}

/**
 * Function that returns the groupe name of the user.
 * @return type
 */
function getUserGroup() {
    return (isset($_SESSION['group'])) ? $_SESSION['group'] : 0;
}

/**
 * Funtion that checks if the user is a member.
 * @return type
 */
function isUserMember() {
    return (getUserGroup() == 1);
}

/**
 * Funtion that checks if the user is an admin..
 * @return type
 */
function isUserAdmin() {
    return (getUserGroup() == 2);
}

/**
 * Function that returns the Id of the user.
 * @return type
 */
function getUserId() {
    return (isset($_SESSION['userid'])) ? $_SESSION['userid'] : -1;
}

/**
 * Function that returns the user email from the sessions.
 * @return type
 */
function getUserEmail() {
    return $_SESSION['useremail'];
}

/**
 * Function that disconnect the user and destroy the session.
 */
function logOutUser() {
    $_SESSION = array();
    session_destroy();
}

//<---------- SESSIONS FUNCTIONS END ---------->