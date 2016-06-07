<?php

// Depending if a user or admin is log in, change de required menu.
switch (getUserGroup()) {
    case 0: require '/menu/defaultmenu.php';
        break;
    case 1: require '/menu/usermenu.php';
        break;
    case 2: require '/menu/adminmenu.php';
        break;
    default :require '/menu/defaultmenu.php';
        break;
}

