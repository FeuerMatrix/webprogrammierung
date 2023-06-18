<?php
// Hier kommt der Code zum Abrufen der Suchergebnisse
if(isset($_GET["search"]) && isset($_GET["sort"])) {

    $suche = (is_string($_GET["search"])) ? $_GET["search"] : "";
    $sort = (is_string($_GET["sort"])) ? $_GET["sort"] : "date";

    include_once "C:/xampp/htdocs/webprogrammierung/DI-12-B-Visser-Schroeder-Renneberg/datenbank/SQLiteStore.php";
    $database = new SQLiteStore();
    $beitraege = $database->getBeitraege();


    // Nur Beiträge anzeigen, die den Suchbegriff im Titel enthalten
    if ($suche != "") {
        $beitraege = array_filter($beitraege, function ($beitrag) use ($suche) {
            return strpos(strtolower($beitrag['titel']), strtolower($suche)) !== false;
        });
    }

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
            usort($beitraege, "sortiereNachDatum");
            break;
        case "titel":
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
