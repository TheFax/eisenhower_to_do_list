<?php
session_start();
include 'utilities.php';


if ($_POST["title"] != "" && $_POST["category"] != "") {

    $title = filter($_POST["title"]);
    if ($_POST["description"] != "") {
        $description = filter($_POST["description"]);
    } else {
        $description = "";
    }
    $category = filter($_POST["category"]);

    if ($title != "" && $category != "") {
        //Aggiungo i dati in database
        include 'db_class.php';
        $my_db = new sql_class;
        $my_db->addItem($title, $description, $category);
    } else {

        $_SESSION["message"] = "Inserimento non eseguito: non puoi usare caratteri speciali.";
        $_SESSION["status"] = "danger";

    }

} else {

    $_SESSION["message"] = "Inserimento non eseguito: servono titolo e categoria.";
    $_SESSION["status"] = "danger";

}

header('location: index.php');
