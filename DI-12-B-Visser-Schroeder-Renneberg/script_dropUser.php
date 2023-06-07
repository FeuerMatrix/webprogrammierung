<?php
    include_once "datenbank/SQLiteStore.php";
    session_start();
    $database = new SQLiteStore();
    $database->deleteUser("f@f.de");
    session_destroy();
    header("Location: index.php");
    exit;
?>