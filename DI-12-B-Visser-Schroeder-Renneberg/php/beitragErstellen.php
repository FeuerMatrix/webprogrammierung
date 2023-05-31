<?php
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

        //TODO save to DB
        //Datum ueber DB
        header("Location: Beitrag.php?from=neuerBeitrag");
        exit;
    } else {
        echo "<p><b>Formular unvollst&auml;ndig</b></p>";
        echo "<ul><li>";
        echo implode("</li><li>", $fehlerfelder);
        echo "</li></ul>";
    }
}
