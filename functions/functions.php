<?php

require 'mysql.inc.php';

// Function that creates a database connector.
function myDatabase() 
{
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
function insertNewEvent($datas)
{
    $query1 = "INSERT INTO endroit (rue, ville, pays) VALUES (:street, :city, :country)";
    $query2 = "SELECT id FROM endroit WHERE rue = :street AND ville = :city AND pays = :country";
    $query3 = "INSERT INTO evenement (titre, dateDebut, dateFin, description, image, id_endroit) VALUES (:title, :datestart, :dateend, :desc, :image, :id_endroit)";
    
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
    
    
    $ps3->execute();

}

