<?php
$suche = (isset($_GET["suche"]) && is_string($_GET["suche"])) ? $_GET["suche"] : "";
$sort = (isset($_GET["sort"]) && is_string($_GET["sort"])) ? $_GET["sort"] : "date";

$database = new SQLiteStore();
$beitraege = $database->getBeitraege();


// Nur Beiträge anzeigen, die den Suchbegriff im Titel enthalten
if ($suche != "") {
    $beitraege = array_filter($beitraege, function ($beitrag) use ($suche) {
        return strpos(strtolower($beitrag['titel']), strtolower($suche)) !== false;
    });
}

//Sortieren der Foreneinträge
switch ($sort) {
    case "date": 
        usort($beitraege, 'sortiereNachDatum');
        break;
    case "titel":
        usort($beitraege, 'sortiereNachTitel');
        break;
    default:
        echo "Ungültige auswahl der Sortierung";
        break;
}

function sortiereNachTitel($a, $b) {                        // Vergleich nach Titel
    return strcmp($a['titel'], $b['titel']);
}


function sortiereNachDatum($a, $b) {                        // Vergleich nach Datum
    $dateA = strtotime($a['date']);                         //strtotime wandelt das Datum in einen int um
    $dateB = strtotime($b['date']);

    if ($dateA == $dateB) {
        return 0;
    }
    return ($dateA < $dateB) ? 1 : -1;                      // 1 wenn true, -1 wenn false
}
?>