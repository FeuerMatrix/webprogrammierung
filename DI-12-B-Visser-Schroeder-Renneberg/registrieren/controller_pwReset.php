<?php

    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if(isset($_GET["token"])){
        if(isset($_POST["passw"], $_POST["passw2"])){
            if (!validCSRF($_POST)) {
                header("Location: ".$hpath."index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
                exit;
            }
            
            if($_POST["passw"] != $_POST["passw2"]) {
                $errorMessage = "Passwörter stimmen nicht überein!";
            }

            if(!isset($errorMessage)) {
                
                    include_once $path."datenbank/SQLiteStore.php";
                    $database = new SQLiteStore();
                    $user = $database->getUser($_GET["token"]);

                    if($user != "") {
                        $database->updatePassword($user, $_POST["passw"]);
                        $errorMessage = "Passwort erfolgreich zurückgesetzt";
                        session_destroy(); //forces user to log out
                        header("Location: ".$hpath."anmeldung.php?cause=".urlencode($errorMessage));
                        exit;
                    } 
                    else {
                        $errorMessage = "Keinen Nutzer gefunden!";
                        header("Location: ".$hpath."pwReset.php?cause=".urlencode($errorMessage)."&token=".$token);
                        exit;
                    }     
            } 
            else {
                header("Location: ".$hpath."pwReset.php?cause=".urlencode($errorMessage)."&token=".$_GET["token"]);
                exit;
            }
        }
    } 
    else {
        $errorMessage = "Fehlerhafte URL";
        header("Location: ".$hpath."index.php?cause=".urlencode($errorMessage));
        exit;
    }

?>