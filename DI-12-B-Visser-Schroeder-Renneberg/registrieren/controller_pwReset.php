<?php

    if(isset($_GET["token"])){
        if(isset($_POST["passw"], $_POST["passw2"])){
            if (!validCSRF($_POST)) {
                header("Location: index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
                exit;
            }
            
            if($_POST["passw"] != $_POST["passw2"]) {
                $errorMessage = "Passwörter stimmen nicht überein!";
            }

            if(!isset($errorMessage)) {
                
                    include_once "datenbank/SQLiteStore.php";
                    $database = new SQLiteStore();
                    $user = $database->getUser($_GET["token"]);

                    if($user != "") {
                        $database->updatePassword($user, $_POST["passw"]);
                        $errorMessage = "Passwort erfolgreich zurückgesetzt";
                        header("Location: anmeldung.php?cause=".urlencode($errorMessage));
                        exit;
                    } 
                    else {
                        $errorMessage = "Keinen Nutzer gefunden!";
                        header("Location: pwReset.php?cause=".urlencode($errorMessage)."&token=".$token);
                        exit;
                    }     
            } 
            else {
                header("Location: pwReset.php?cause=".urlencode($errorMessage)."&token=".$_GET["token"]);
                exit;
            }
        }
    } 
    else {
        $errorMessage = "Fehlerhafte URL";
        header("Location: index.php?cause=".urlencode($errorMessage));
        exit;
    }

?>