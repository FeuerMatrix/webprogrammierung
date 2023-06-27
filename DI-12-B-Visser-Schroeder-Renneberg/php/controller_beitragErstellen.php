<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

include_once "datenbank/SQLiteStore.php";
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
        $database->beginTransaction();
        $id = $_GET["from"];
        $titelold = $database->getTitel($id);
        $descold =  $database->getDesc($id);
        $anonyold = $database->getAnonym($id);
        $database->endTransaction();
}

$ok = false;
$fehlerfelder = array();
if (isset($_POST["Submit"])) {


    
    $ok = true;
    if (!isset($_POST["fname"]) || !is_string($_POST["fname"])) {
        $ok = false;
    }
    if (!isset($_POST["text_main"]) || !is_string($_POST["text_main"]) || trim($_POST["text_main"]) == "") {
        $ok = false;
    }
    if ($ok) {
        if (isset($_FILES["Datei"]["name"])&&$_FILES["Datei"]["name"]!="") {
            move_uploaded_file($_FILES["Datei"]["tmp_name"], "./images/userImages/" . hash("md5", $_FILES["Datei"]["name"]));
            $file = "./images/userImages/" . hash("md5", $_FILES["Datei"]["name"]);
        }else{
            $file = null;
        }

        if ($anony == "Anonym") {
            $anony = TRUE;
        } else {
            $anony = FALSE;
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

