<?php

    if(isset($_GET["token"])){
        if(isset($_POST["passw"], $_POST["passw2"])){
            
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
                        header("Location: index.php?cause=".urlencode($errorMessage));
                    } 
                    else {
                        $errorMessage = "Keinen Nutzer gefunden!";
                        header("Location: pwReset.php?cause=".urlencode($errorMessage)."&token=".$token);
                    }     
            } 
            else {
                header("Location: pwReset.php?cause=".urlencode($errorMessage)."&token=".$_GET["token"]);
            }
        }
    } 
    else {
        $errorMessage = "Fehlerhafte URL";
        header("Location: index.php?cause=".urlencode($errorMessage));
    }

?>