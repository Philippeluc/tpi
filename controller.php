<?php
session_start();

$event_folder = getEventImageDir();     // The folder where the event image is uploaded.
$user_folder = getUserImageDir();     // The folder where the avatar image is uploaded.

// Checks if the insert event button is pressed.
if (isset($_POST['insert_event'])) {
    // Getting the datas (secured!) from the form fields.
    $datas['event_title'] = filter_var($_POST['event_title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_street'] = filter_var($_POST['event_street'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_city'] = filter_var($_POST['event_city'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $datas['event_country'] = filter_var($_POST['event_country'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_datestart'] = filter_var($_POST['event_datestart'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $datas['event_dateend'] = filter_var($_POST['event_dateend'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_desc'] = filter_var($_POST['event_desc'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['user_id'] = getUserId();

    // Getting the datas for the image.
    $file = $_FILES['event_image'];       // The name of the image.
    $datas['event_image'] = filter_var($file['name'], FILTER_SANITIZE_SPECIAL_CHARS);

    // Add the new event in the database.
    insertNewEvent($datas);
    // Select the id from the event for the image.
    $function = selectIdEventFromName($datas['event_title']);
    // Upload the image.
    uploadEventImage($event_folder, $file, $function);
    // Redirect to the index page.
    header('Location: index.php');   
}

// Checks if the insert user button is pressed.
if (isset($_POST['insert_user'])) {
    // Getting the datas from the form fields.
    $datas['event_email'] = filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_pseudo'] = filter_var($_POST['pseudo'], FILTER_SANITIZE_SPECIAL_CHARS);
    // Check if the tow passwords are matching.
    if ($_POST['password'] == $_POST['checkpassword']) {
        $datas['event_password'] = sha1($_POST['password']);
    } else {
        echo 'Les mots de passe que vous avez renseignés ne correspondent pas !';
    }
    // Add the new user in the database.
    insertNewUser($datas);
    // Redirect to the index page.
    header('Location: index.php');   
}

// Checks if the user tries to connect.
if (isset($_REQUEST['connect'])) {
    //If the user is not log in, display an error alert
    if (isLoggedIn()) {
        echo '<script> alert("Vous n\'avez pas la permission d\'acceder à la page");</script>';
    } else {
        $datas['email'] = (isset($_REQUEST['email']) ? $_REQUEST['email'] : "");
        $datas['password'] = (isset($_REQUEST['password']) ? $_REQUEST['password'] : "");
        // Connect the user with the data he give us. If all the datas are true then log him.
        if (checkuser($datas)) {
            setLoggedIn(true);
            // Set his group
            setUserGroup(getGroup($datas));
            }
            header('Location: index.php');
        }
}

// If the user tries to logout.
if (isset($_REQUEST['logout'])) {
    logOutUser();
    header('Location: index.php'); 
    //header('Refresh; url=index.php');
    exit;
}

// Checks if the comment event button is pressed.
if (isset($_POST['insert_comment'])) {
    // Getting the datas (secured!) from the form fields.    
    $datas['comment_time'] = date('Y-m-d H:i:s');
    $datas['comment_text'] = filter_var($_POST['comment'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['event_id'] = $_REQUEST['event_id'];
    $datas['user_id'] = getUserId();

    // Add the new comment in the database.
    insertNewComment($datas);
    // Redirect to the event detail page.
    header('Location: event_details.php?event_id='.$_REQUEST['event_id']);   
}

// Checks if the edit profile button is pressed.
if (isset($_POST['edit_profile'])) {
    // Getting the datas (secured!) from the form fields.
    $datas['user_email'] = getUserEmail();
    $datas['user_name'] = filter_var($_POST['modify_name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['user_firstname'] = filter_var($_POST['modify_firstname'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['user_organisation'] = filter_var($_POST['modify_organisation'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $datas['user_adress'] = filter_var($_POST['modify_adress'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['user_desc'] = filter_var($_POST['modify_desc'], FILTER_SANITIZE_SPECIAL_CHARS);
    $datas['user_id'] = getUserId();

    // Getting the datas for the image.
    $file = $_FILES['modify_avatar'];       // The name of the image.
    $datas['user_avatar'] = filter_var($file['name'], FILTER_SANITIZE_SPECIAL_CHARS);

    // Edit the new profile in the database.
    editUserData($datas);
    
    // Select the id from the user for the image.
    $function = selectIdusersFromName($datas['user_email']);
    // Upload the image.
    uploadUserImage($user_folder, $file, $function);
    // Redirect to the index page.
    header('Location: index.php');   
}



