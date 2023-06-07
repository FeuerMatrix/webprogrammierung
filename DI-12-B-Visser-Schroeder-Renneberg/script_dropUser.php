<?php
    include_once "datenbank/SQLiteStore.php";
    session_start();
    $database = new SQLiteStore();
    $database->deleteUser($_SESSION["user"]);
    session_destroy();
    header("Location: index.php");
    exit;
?>