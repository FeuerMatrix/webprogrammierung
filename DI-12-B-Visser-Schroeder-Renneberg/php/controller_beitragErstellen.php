<?php

include_once "datenbank/DummyUserStore.php";
$database = new DummyUserStore();

if (!isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while not logged in
    header("Location: index.php?cause=" . urlencode("Fehler: diese Seite kann nur von eingeloggten Nutzern aufgerufen werden!"));
    exit;
}


$titel = (isset($_POST["fname"]) && is_string($_POST["fname"])) ? $_POST["fname"] : "";
$desc = (isset($_POST["text_main"]) && is_string($_POST["text_main"])) ? $_POST["text_main"] : "";
$anony = (isset($_POST["anonym"]) && is_string($_POST["anonym"])) ? $_POST["anonym"] : "";
$titel = htmlspecialchars($titel);
$anony = htmlspecialchars($anony);
$desc = nl2br(htmlspecialchars($desc));


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
        $database->newPost($_SESSION["user"], $titel, $desc, $anony, "img");
        if ($edit) {
            $database->updatePost($id, $_SESSION["user"], $titel, $desc, $anony, "img");
        }
        header("Location: Beitrag.php?from=neuerBeitrag");
        exit;
    } else {
        echo "<p><b>Formular unvollst&auml;ndig</b></p>";
        echo "<ul><li>";
        echo implode("</li><li>", $fehlerfelder);
        echo "</li></ul>";
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
$edit = false;

if (isset($_SESSION["id"]) && isset($_GET["from"])) {
    if (is_string($_SESSION["id"])) {
        $id = $_SESSION["id"];
        unset($_SESSION["id"]);
        $edit = true;

        $titel = $database->getTitel($id);
        $desc =  $database->getDesc($id);
        $anony = $database->getAnonym($id);
        if (!isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while not logged in
            header("Location: index.php?cause=" . urlencode("Fehler: diese Seite kann nur von eingeloggten Nutzern aufgerufen werden!"));
            exit;
        }
    }
}
