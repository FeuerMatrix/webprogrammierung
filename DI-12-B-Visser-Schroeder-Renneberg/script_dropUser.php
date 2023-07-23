<?php
    include_once "path.php";
    include_once "php/csrf.php";
    include_once $path."/datenbank/SQLiteStore.php";
    session_start();
    if (!validCSRF($_POST)) {
        header("Location: index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
        exit;
    }
    $database = new SQLiteStore();
    $database->deleteUser($_SESSION["user"]);
    session_destroy();
    header("Location: index.php");
    exit;
?>