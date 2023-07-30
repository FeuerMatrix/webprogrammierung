<?php
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    $email1set = isset($_POST["email"]);
    if($email1set) {
        $email1 = $_POST["email"];
    }

    $isRedirected = isset($_GET["from"]);
    if($isRedirected) {
        $messageRedirect = ($_GET["from"] == "registration" ? "Registriert" : "Abgemeldet");
    }

    if(isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while logged in
        header("Location: ".$hpath."index.php?cause=".urlencode("Fehler: diese Seite kann nicht von eingeloggten Nutzern aufgerufen werden!"));
        exit;
    }

    $hasError = false; //needed so that the variable still gets initialized if following if check fails

    if(isset($_POST["email"], $_POST["pw"])) {
        unset($errorMessage);
        $email = $_POST["email"];
        $pw = $_POST["pw"];

        include_once $path."/datenbank/SQLiteStore.php";
        $database = new SQLiteStore();
        
        if(!($database->checkLoginData($email, $pw))) {
            $errorMessage = "Ungültige Email-Addresse oder Passwort!";
        }

        $hasError = isset($errorMessage);
        if(!$hasError) {
            $_SESSION["user"] = $email;
            header("Location: ".$hpath."index.php?cause=".urlencode("Erfolgreich Angemeldet!"));
            exit;
        }
    }
?>