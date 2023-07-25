<?php
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();

    //Anfangsbeiträge der Seite raussuchen
    include_once $path."datenbank/SQLiteStore.php";
    $database = new SQLiteStore();
    $beitraege = $database->getBeitraege();

    usort($beitraege, 'sortiereNachDatum');

    function sortiereNachDatum($a, $b) {                        // Vergleich nach Datum
        $dateA = ($a['date']);                                  //strtotime wandelt das Datum in einen int um
        $dateB = ($b['date']);

        if ($dateA == $dateB) {
            return 0;
        }
        return ($dateA < $dateB) ? 1 : -1;                      // -1 wenn true, 1 wenn false
    }
?>
