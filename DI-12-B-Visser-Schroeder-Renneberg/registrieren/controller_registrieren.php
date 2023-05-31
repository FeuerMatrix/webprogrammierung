<?php
    if(isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while logged in
        header("Location: index.php?cause=loggedIn");
        exit;
    }

    if(isset($_POST["passw"], $_POST["passw2"], $_POST["user"], $_POST["email"], $_POST["email2"])) {
        unset($errorMessage);
        foreach($_POST as $postKey=>$postElement) {
            $$postKey = htmlentities($_POST[$postKey]);
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

        include_once "datenbank/DummyUserStore.php";
        $controller = new DummyUserStore;

        if($controller->userNameExists($user)) {
            $errorMessage = "Benutzername existiert bereits/Email bereits in Benutzung!";
        }

        if(!isset($errorMessage)) {
            $controller->store($user, $email, $passw);
            header("Location: anmeldung.php?from=registration");
            exit;
        }
    }
?>