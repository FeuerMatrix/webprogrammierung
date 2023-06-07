<?php

$database = new SQLiteStore();

if (!isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while not logged in
    header("Location: index.php?cause=" . urlencode("Fehler: diese Seite kann nur von eingeloggten Nutzern aufgerufen werden!"));
    exit;
}


$titel = (isset($_POST["fname"]) && is_string($_POST["fname"])) ? $_POST["fname"] : "";
$desc = (isset($_POST["text_main"]) && is_string($_POST["text_main"])) ? $_POST["text_main"] : "";
$anony = (isset($_POST["anonym"]) && is_string($_POST["anonym"])) ? $_POST["anonym"] : "";
$titel = $titel;
$anony = $anony;
$desc = $desc;


if (isset($_GET["from"])&&is_string($_GET["from"])) {
        $id = $_GET["from"];
        $titelold = $database->getTitel($id);
        $descold =  $database->getDesc($id);
        $anonyold = $database->getAnonym($id);
}

$ok = false;
$fehlerfelder = array();
if (isset($_POST["Submit"])) {


    
    $ok = true;
    if (!isset($_POST["fname"]) || !is_string($_POST["fname"])) {
        $ok = false;
        $fehlerfelder[] = "Titel";
    }
    if (!isset($_POST["text_main"]) || !is_string($_POST["text_main"]) || trim($_POST["text_main"]) == "") {
        $ok = false;
        $fehlerfelder[] = "Beschreibung";
    }
    if ($ok) {
        if (isset($_FILES["Datei"])) {
            move_uploaded_file($_FILES["Datei"]["tmp_name"], "./images/userImages/" . $_FILES["Datei"]["name"]);
        }

        if ($anony == "Anonym") {
            $anony = TRUE;
        } else {
            $anony = FALSE;
        }
        if(isset ($_FILES["Datei"]["name"])){
            $file = "./images/userImages/" . $_FILES["Datei"]["name"];
        }else{
            $file = null;
        }
        
        if (isset($_GET["from"])&&is_string($_GET["from"])) {
           $id = $_GET["from"];
           $database->updatePost($id, $titel, $desc, $anony, $file);
        } else {
            $id = $database->newPost($_SESSION["user"], $titel, $desc, $anony, $file);
        }
        header("Location: Beitrag.php?id=". urlencode($id));
        exit;
    } else {
        ?>
        <p><b>Formular unvollst&auml;ndig</b></p>
        <ul><li>
        </li><li> <?php echo $fehlerfelder ?>
        </li></ul>
        <?php
    }
}

if(!isset($_GET["from"])){
    $url = "hauptseite.php";
    }else{
        $url = "beitrag.php?id=".$_GET["from"];
    }

if (!isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while not logged in
    header("Location: index.php?cause=" . urlencode("Fehler: diese Seite kann nur von eingeloggten Nutzern aufgerufen werden!"));
    exit;
}

