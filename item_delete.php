<?php
session_start();
include 'utilities.php';

if ($_GET["id"] != "") {
    $id = filter($_GET["id"]);

    include 'db_class.php';
    $my_db = new sql_class;
    $my_db->deleteItem($id);

} else {

    $_SESSION["message"] = "Nota non eliminata: non è stato specificato l'ID.";
    $_SESSION["status"] = "danger";

}

header('location: index.php');