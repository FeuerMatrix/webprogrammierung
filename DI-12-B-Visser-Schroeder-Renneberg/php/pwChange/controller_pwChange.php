<?php

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(!isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while not logged in
        header("Location: ".$hpath."index.php?cause=".urlencode("Fehler: diese Seite kann nur von eingeloggten Nutzern aufgerufen werden!"));
        exit;
    } else {
        $email = $_SESSION["user"];
    } 

    if(isset($_POST["passw"], $_POST["passw2"], $_POST["email"], $_POST["oldPw"])) {
        if (!validCSRF($_POST)) {
            header("Location: ".$hpath."index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
            exit;
        }
        
        unset($errorMessage);
        foreach($_POST as $postKey=>$postElement) {
            $$postKey = $_POST[$postKey];
        }

        include_once $path."datenbank/SQLiteStore.php";
        $database = new SQLiteStore();

        if($passw != $passw2) {
            $errorMessage = "neue Passwörter stimmen nicht überein!";
        }

        if($passw == $oldPw) {
            $errorMessage = "neues Passwort muss anderes sein als das Alte!";
        }

        if(!$database->checkLoginData($email, $oldPw)) {
            $errorMessage = "Altes Passwort ist falsch!";
        }

        if(!$database->emailExists($email)) {
            $errorMessage = "Email-Addressen existiert nicht!";
        }

        if(!isset($errorMessage)) {
            $database->updatePassword($email, $passw);
            session_destroy(); //forces user to log out
            header("Location: ".$hpath."php/anmeldung/anmeldung.php?cause=".urlencode("Erfolgreich Passwort geändert!"));
            exit;
        } else {
            header("Location: ".$hpath."php/pwChange/pwChange.php?cause=".urlencode($errorMessage)."&email=".$email);
            exit;
        }
    }
?>