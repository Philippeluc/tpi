<?php

/*******************************************************************
 * Author : Philippe Ku
 * School / Class : CFPT Informatique / I.FA-P3B
 * Date : 15.06.2016
 * Programm : Event gestion website
 * File : controller.php
 * Description : This file is the controller that checks all the datas of my website
 * Version : 1.10
 * ****************************************************************/

session_start();

// Sets the errors to null.
$signin_error = "";
$passwordcheck_error = "";
$passwordlength_error = "";
$date_error = "";
$editdate_error = "";
$comment_error = "";
$banconnect_error = "";

// Checks if the insert event button is pressed.
if (isset($_POST['insert_event'])) {
    // Getting the datas with security check from the form field.
    $datas['event_title'] = filter_var($_POST['event_title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_street'] = filter_var($_POST['event_street'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_city'] = filter_var($_POST['event_city'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_country'] = filter_var($_POST['event_country'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_datestart'] = filter_var($_POST['event_datestart'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_dateend'] = filter_var($_POST['event_dateend'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_desc'] = $_POST['event_desc'];        // The TinyMCE script handles the security check.
    $datas['user_id'] = getUserId();        // Get the user_id from the sessions.

    if ($_POST['event_datestart'] <= $_POST['event_dateend']) {
        // Upload the image in the correct folder.
        uploadEventImage();

        // Getting the datas from the image.
        $datas['event_image'] = $_SESSION['imageevent_name'];

        // Add the event into the database.
        insertNewEvent($datas);

        // Redirect to the index page.
        header('location: index.php');
    } else {
        $date_error = '<div class="alert alert-warning"><strong>ATTENTION !</strong>La date de fin doit être supérieur ou égale à celle de début !</div>';
    }
}


// Checks if the insert user button is pressed.
if (isset($_POST['insert_user'])) {
    // Getting the datas with security check from the form field.
    $datas['user_email'] = filter_var($_POST['user_email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['user_nickname'] = filter_var($_POST['user_nickname'], FILTER_SANITIZE_SPECIAL_CHARS);
    // Checks if the two passwords are matching.
    if ($_POST['user_password'] == $_POST['user_checkpassword']) {
        if (strlen($_POST['user_password']) >= 3) {
            $datas['user_password'] = sha1($_POST['user_password']);
            // Add the new user in the database.
            insertNewUser($datas);
            // Shows a succes message.
            echo '<script type="text/javascript">
                alert("Votre compte à été crée !");
                document.location.href = "index.php";
              </script>';
        } else {
            $passwordlength_error = '<div class="alert alert-warning"><strong>ATTENTION !</strong> Le mot de passe doit faire au minimum 3 caractères !</div>';
        }
    } else {
        $passwordcheck_error = '<div class="alert alert-warning"><strong>ATTENTION !</strong> Les mots de passe ne correspondent pas !</div>';
    }
}

// Checks if the connect button is pressed.
if (isset($_POST['connect_user'])) {
    // Getting the datas from the form field.
    $datas['user_email'] = (isset($_POST['user_email']) ? $_POST['user_email'] : "");
    $datas['user_password'] = (isset($_POST['user_password']) ? $_POST['user_password'] : "");

    // Connect the user with the datas he gave us. If all the datas are true then log him.
    if (checkuser($datas)) {

        $results = getUserInfo();
        if ($results[0]['status'] == 1) {
            // Sets the logged status to true.
            setLoggedIn(true);
            // Set his group.
            setUserGroup(getUserGroupFromDatabase($datas));
        }
        else
        {
            $banconnect_error = '<div class="alert alert-warning"><strong>ATTENTION !</strong> Votre compte a été banni veuillez contacter l\'administrateur !</div>';
        }
    } else {
        $signin_error = '<div class="alert alert-warning"><strong>ATTENTION !</strong> La combinaison email / mot de passe est incorrecte!</div>';
    }
    // Redirect to the index page.
    //header('Location: index.php');
}

// Checks if the comment button is pressed.
if (isset($_POST['insert_comment'])) {
    // Getting the datas from the form field.  
    $datas['comment_time'] = date('Y-m-d H:i:s');
    $datas['comment_text'] = $_POST['comment_text'];
    $datas['user_id'] = getUserId();
    $datas['event_id'] = $_REQUEST['event_id'];

    if ($_POST['comment_text'] != "") {
        // Add the new comment into the database.
        insertNewComment($datas);
        // Redirect to the event detail page.
        header('Location: event_details.php?event_id=' . $_REQUEST['event_id']);
    } else {
        $comment_error = '<div class="alert alert-warning"><strong>ATTENTION !</strong> Le texte du commentaire ne doit pas être vide !</div>';
    }
}

// Checks if the logout button is pressed.
if (isset($_REQUEST['logout'])) {
    logOutUser();
    header('Location: index.php');
}

// Change the menubar depending if it's a visitor, member or admin that signin.
switch (getUserGroup()) {
    case -1: require '/menu/default_menu.php';
        break;
    case 0: require '/menu/user_menu.php';
        break;
    case 1: require '/menu/admin_menu.php';
        break;
    default :require '/menu/default_menu.php';
        break;
}

// Checks if the edit profile button is pressed.
if (isset($_POST['edit_profile'])) {
    // Getting the datas (secured!) from the form fields.
    $datas['user_name'] = filter_var($_POST['edit_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['user_firstname'] = filter_var($_POST['edit_firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['user_organisation'] = filter_var($_POST['edit_organisation'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['user_adress'] = filter_var($_POST['edit_adress'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['user_desc'] = $_POST['edit_desc'];
    $datas['user_id'] = getUserId();

    // Getting the datas for the image.
    //$file = $_FILES['edit_avatar'];       // The name of the image.
    //$datas['user_avatar'] = filter_var($file['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    // Upload the image in the correct file.
    uploadAvatarImage();
    $datas['user_avatar'] = $_SESSION['imageavatar_name'];
    // Edit the new profile in the database.
    editUserData($datas);

    // Redirect to the index page.
    header('Location: myaccount.php');
}

// Checks if the edit event button is pressed.
if (isset($_POST['edit_event'])) {
    // Getting the datas (secured!) from the form fields.
    $datas['event_title'] = filter_var($_POST['editevent_title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_street'] = filter_var($_POST['editevent_street'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_city'] = filter_var($_POST['editevent_city'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_country'] = filter_var($_POST['editevent_country'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_datestart'] = filter_var($_POST['editevent_datestart'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_dateend'] = filter_var($_POST['editevent_dateend'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_desc'] = $_POST['editevent_desc'];
    $datas['event_id'] = $_GET['event_id'];

    if ($_POST['editevent_datestart'] <= $_POST['editevent_dateend']) {

        // Upload the image in the correct folder.
        uploadEventImage();
        // Getting the datas for the image.
        $datas['event_image'] = $_SESSION['imageevent_name'];

        // Edit the new profile in the database.
        editUserEvent($datas);

        // Redirect to the index page.
        header('Location: myaccount.php');
    } else {
        $editdate_error = '<div class="alert alert-warning"><strong>ATTENTION !</strong>La date de fin doit être supérieur ou égale à celle de début !</div>';
    }
}

// Checks if the searchbox is not empty and displays the results of the search.
if (isset($_GET['search'])) {
    $search_query = filter_var($_GET['user_query'], FILTER_SANITIZE_SPECIAL_CHARS);
    if ($search_query != "") {
        searchAnEvent($search_query);
    } else {
        echo '<div class="row col-md-offset-0"><h1>Veuillez entrer un élément de recherche...</h1><br/>';
    }
}

// Checks if the delete user event button is pressed.
if (isset($_POST['delete_userevent'])) {
    $datas['event_id'] = $_POST['hidden_idevent'];
    deleteEvent($datas);
}

// Checks if the ban admin event button is pressed.
if (isset($_POST['ban_adminevent'])) {
    $datas['event_id'] = $_POST['hidden_ideventadmin'];
    banEvent($datas);
}

// Checks if the unban event admin button is pressed.
if (isset($_POST['unban_adminevent'])) {
    $datas['event_id'] = $_POST['hidden_ideventadmin'];
    unbanEvent($datas);
}

// Checks if the delete admin event button is pressed
if (isset($_POST['delete_adminevent'])) {
    $datas['event_id'] = $_POST['hidden_ideventadmin'];
    deleteEvent($datas);
}

// Checks if the ban comment button is pressed.
if (isset($_POST['ban_comment'])) {
    $datas['comment_id'] = $_POST['hidden_idcommentadmin'];
    banComment($datas);
}

// Checks if the unban comment button is pressed.
if (isset($_POST['unban_comment'])) {
    $datas['comment_id'] = $_POST['hidden_idcommentadmin'];
    unbanComment($datas);
}

// Checks if the delete comment button is pressed.
if (isset($_POST['delete_comment'])) {
    $datas['comment_id'] = $_POST['hidden_idcommentadmin'];
    deleteComment($datas);
}

// Checks if the ban admin user button is pressed.
if (isset($_POST['ban_adminuser'])) {
    $datas['user_id'] = $_POST['hidden_iduseradmin'];
    banUser($datas);
}

// Checks if the unban admin user button is pressed.
if (isset($_POST['unban_adminuser'])) {
    $datas['user_id'] = $_POST['hidden_iduseradmin'];
    unbanUser($datas);
}

// Checks if the delete admin user button is pressed
if (isset($_POST['delete_adminuser'])) {
    $datas['user_id'] = $_POST['hidden_iduseradmin'];
    deleteUser($datas);
}
