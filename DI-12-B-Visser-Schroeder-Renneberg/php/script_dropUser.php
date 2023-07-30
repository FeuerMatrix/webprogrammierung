<?php
    include_once "../path.php";
    include_once $path."php/csrf.php";
    include_once $path."/datenbank/SQLiteStore.php";
    session_start();
    if (!validCSRF($_POST)) {
        header("Location: ".$hpath."index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
        exit;
    }
    $database = new SQLiteStore();
    $database->beginTransaction();
    $database->deleteUser($_SESSION["user"]);
    session_destroy();
    header("Location: ".$hpath."index.php?cause=" . urlencode("Nutzer gelöscht!"));
    exit;
?>