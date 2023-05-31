<?php
    if(isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while logged in
        header("Location: index.php?cause=loggedIn");
        exit;
    }

    if(isset($_POST["email"], $_POST["pw"])) {
        unset($errorMessage);
        $email = htmlentities($_POST["email"]);
        $pw = htmlentities($_POST["pw"]);
        include_once "datenbank/UserStore.php";
        $database = new DummyUserStore();

        if(!($database->checkLoginData($email, $pw))) {
            $errorMessage = "Ungültiges Passwort und/oder Email";
        }

        if(!isset($errorMessage)) {
            $_SESSION["user"] = "DummyValue"; //TODO get the actual user from the server
            header("Location: index.php");
            exit;
        }
    }
?>