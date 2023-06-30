<?php
    include_once $path."/datenbank/salt.php";

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while logged in
        header("Location: index.php?cause=".urlencode("Fehler: diese Seite kann nicht von eingeloggten Nutzern aufgerufen werden!"));
        exit;
    }

    if(isset($_POST["passw"], $_POST["passw2"], $_POST["email"], $_POST["email2"])) {
        unset($errorMessage);
        foreach($_POST as $postKey=>$postElement) {
            $$postKey = $_POST[$postKey];
        }

        if($email != $email2) {
            $errorMessage = "Email-Addressen stimmen nicht überein!";
        }

        if($passw != $passw2) {
            $errorMessage = "Passwörter stimmen nicht überein!";
        }

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage = "Fehlerhafte Email-Addresse!";
        }
        
        include_once "datenbank/SQLiteStore.php";
        $database = new SQLiteStore();
        $token = crypt($email, $salt);
        if($database->emailExists($email)) {
            $errorMessage = "Fehler!";
            $emailLog = fopen("email.txt", "w");
            $linkPWResset = "http://localhost/webprogrammierung/DI-12-B-Visser-Schroeder-Renneberg/pwReset.php?token=".$token;
            fwrite($emailLog,  "Bitte ignoriere die E-Mail, wenn du es nicht warst, \nder sich versucht hat zu registrieren. \nDu bist aber bereits registriert. \nSolltest du dein Password vergessen haben, klicke auf folgenden Link. \n$linkPWResset");
            fclose($emailLog);
        }

        if(!isset($errorMessage)) {
            $database->store($email, $passw);
            $emailLog = fopen("email.txt", "w");
            $linkRegestrierung = "http://localhost/webprogrammierung/DI-12-B-Visser-Schroeder-Renneberg/confirmEmail.php?token=".$token;
            fwrite($emailLog,  "Bitte ignoriere die E-Mail, wenn du es nicht warst, \nder sich versucht hat zu registrieren. \nAnsonsten klicke innerhalb von 24h auf den folgenden Link, um die Registrierung abzuschließen: \n$linkRegestrierung");
            fclose($emailLog);
            header("Location: anmeldung.php?from=registration");
            exit;
        } else {
            header("Location: registrieren.php?cause=".urlencode($errorMessage)."&email=".$email."&email2=".$email2);
            exit;
        }
    }
?>