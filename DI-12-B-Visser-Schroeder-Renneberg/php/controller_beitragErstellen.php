<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

$accept_map =  isset($_COOKIE["accept"]);

include_once "datenbank/SQLiteStore.php";
$database = new SQLiteStore();

if (!isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while not logged in
    header("Location: index.php?cause=" . urlencode("Fehler: diese Seite kann nur von eingeloggten Nutzern aufgerufen werden!"));
    exit;
}

$redirected = isset($_GET["from"]);

$titel = (isset($_POST["fname"]) && is_string($_POST["fname"])) ? $_POST["fname"] : "";
$desc = (isset($_POST["text_main"]) && is_string($_POST["text_main"])) ? $_POST["text_main"] : "";
$anony = (isset($_POST["anonym"]) && is_string($_POST["anonym"])) ? $_POST["anonym"] : "";
$lat = (isset($_POST["lat"]) && is_string($_POST["lat"])) ? $_POST["lat"] : "";
$lng = (isset($_POST["lng"]) && is_string($_POST["lng"])) ? $_POST["lng"] : "";
if($lat==""){
    $lat="'.'";
    $lng="'.'"; 
}
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
        $lat = $database->getlat($id);
        $lng = $database->getlng($id);
        if($lat==null){
            $lat = "'.'";
            $lng = "'.'";
        }
}
$ok = false;
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
            $newname = hash_file("md5", $_FILES['Datei']['tmp_name']); //Hashes the entire file in order to generate a unique file name. The advantage over assigning ids is that with this implementation, two copies of the same image will be stored as one even if they had different upload names.
            
            move_uploaded_file($_FILES["Datei"]["tmp_name"], "./images/userImages/" . $newname);
            $file = "images/userImages/" . $newname;
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
           $lat = (isset($_POST["lat"]) && is_string($_POST["lat"])) ? $_POST["lat"] : "";
           $lng = (isset($_POST["lng"]) && is_string($_POST["lng"])) ? $_POST["lng"] : "";
           echo $lat;
           $database->updatePost($id, $titel, $desc, $anony, $file, $lat, $lng);
        } else {
            $id = $database->newPost($_SESSION["user"], $titel, $desc, $anony, $file, $lat , $lng);
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

