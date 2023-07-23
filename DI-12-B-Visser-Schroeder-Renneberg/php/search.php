<?php
// Hier kommt der Code zum Abrufen der Suchergebnisse
if(isset($_GET["search"]) && isset($_GET["sort"])) {

    $suche = (is_string($_GET["search"])) ? $_GET["search"] : "";
    $sort = (is_string($_GET["sort"])) ? $_GET["sort"] : "date";

    include_once("../path.php");
    include_once($path . "/datenbank/SQLiteStore.php");

    $database = new SQLiteStore();

    function sortiereNachTitel($a, $b) {                        // Vergleich nach Titel
        return strnatcasecmp($a['titel'], $b['titel']);
    }

    function sortiereNachDatum($a, $b) {                        // Vergleich nach Datum
        $dateA = ($a['date']);                                  //strtotime wandelt das Datum in einen int um
        $dateB = ($b['date']);

        if ($dateA == $dateB) {
            return 0;
        }
        return ($dateA < $dateB) ? 1 : -1;                      // -1 wenn true, 1 wenn false
    }

    //Sortieren der Foreneinträge
    switch ($sort) {
        case "date": 
            $beitraege = $database->sucheBeitraege($suche);
            usort($beitraege, "sortiereNachDatum");
            break;
        case "titel":
            $beitraege = $database->sucheBeitraegeAlphabetisch($suche);
            usort($beitraege, "sortiereNachTitel");
            break;
        default:
            echo "Ungültige auswahl der Sortierung";
            break;
    }

 
    

    // Gib die Ergebnisse als JSON zurück
    header('Content-Type: application/json');
    echo json_encode($beitraege);
}
?>
