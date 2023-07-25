<?php

    if(isset($_GET["token"])){

        include_once $path."datenbank/SQLiteStore.php";
        $database = new SQLiteStore();
        $user = $database->getUser($_GET["token"]);

        if($user != "") {
            $database->confirmUser($user);
            $confirmed = True;
        } 
        else {
            $confirmed = False;
        }
    }
    else
    {
        $errorMessage = "Fehlerhafte URL";
        header("Location: ".$hpath."anmeldung.php?cause=".urlencode($errorMessage));
        exit;
    }

?>