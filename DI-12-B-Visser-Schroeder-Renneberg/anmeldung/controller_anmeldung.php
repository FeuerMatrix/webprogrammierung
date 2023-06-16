<?php
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while logged in
        header("Location: index.php?cause=".urlencode("Fehler: diese Seite kann nicht von eingeloggten Nutzern aufgerufen werden!"));
        exit;
    }

    if(isset($_POST["email"], $_POST["pw"])) {
        unset($errorMessage);
        $email = $_POST["email"];
        $pw = $_POST["pw"];

        include_once "datenbank/SQLiteStore.php";
        $database = new SQLiteStore();
        
        if(!($database->checkLoginData($email, $pw))) {
            $errorMessage = "Ungültige Email-Addresse oder Passwort!";
        }

        if(!isset($errorMessage)) {
            $_SESSION["user"] = $email;
            header("Location: index.php?cause=".urlencode("Erfolgreich Angemeldet!"));
            exit;
        }
    }
?>