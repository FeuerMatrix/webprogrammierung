<?php

    $db = new SQLite3( 'beschwerdeforum.db' );

    //BEITRAGS TABELLE
    $sql = "CREATE TABLE IF NOT EXISTS beitrag (
        id_beitrag          INTEGER PRIMARY KEY,
        titel               TEXT,
        datum               TIMESTAMP,
        bild                TEXT,
        bildbeschreibung    TEXT
        )";

        if ( $db->exec( $sql ) ) {
            echo 'Tabelle Beitrag vorhanden.<br />';
        } else {
            echo 'Fehler beim Anlegen der Beitrags-Tabelle!<br />';
        }    

    $sql = "INSERT OR IGNORE INTO beitrag VALUES
        (1, 'Argumentation', '05.06.1996', 'images/beispielbilder/argumentation.png', 'Argumentation'),
        (2, 'Protest', '08.04.1976', 'images/beispielbilder/protest.png', 'Protest'),
        (3, 'Trouble Incoming', '08.05.1976', 'images/beispielbilder/trouble.jpg', 'Trouble_Schilder'),
        (4, 'Beispielbild', '08.04.1976', 'images/guestbook.png', 'Beispielbild'
        )";

        if ( $db->exec( $sql ) ) {
            echo "Erste Beitrags-Daten sind vorhanden<br />";

        } else {
            echo 'Fehler beim anlegen der ersten Beitragsdaten!';
        }

    //KOMMENTAR TABELLE
    $sql = "CREATE TABLE IF NOT EXISTS kommentar (
        id_kommenatar   INTEGER,
        id_beitrag      INTEGER,
        author          TEXT,
        kommentar       TEXT,
        PRIMARY KEY(id_beitrag, id_kommentar),
        FOREIGN KEY(id_beitrag) REFERENCES beitrag(id_beitrag)
        )";

        if ( $db->exec( $sql ) ) {
            echo 'Tabelle Kommentar vorhanden.<br />';
        } else {
            echo 'Fehler beim Anlegen der Kommentar-Tabelle!<br />';
        }

    $sql = "INSERT OR IGNORE INTO kommentar VALUES
        (1, 1, 'Tim','grfaghaergherreag'),
        (1, 2, 'Nils','harhngrjrtahgrfsjhtr'),
        (1, 3, 'Robin','htrshtgbgsfhjtrsh')";

        if ( $db->exec( $sql ) ) {
            echo "Erste Kommentar-Daten sind vorhanden<br />";

        } else {
            echo 'Fehler beim anlegen der ersten Kommentardaten!';
        }

    //NUTZER TABELLE
    $sql = "CREATE TABLE IF NOT EXISTS nutzer (
        nutzername  TEXT PRIMARY KEY,
        email       TEXT,
        passwort    TEXT
        )";

        if ( $db->exec( $sql ) ) {
            echo 'Tabelle Nutzer vorhanden.<br />';
        } else {
            echo 'Fehler beim Anlegen der Nutzer-Tabelle!<br />';
        }

    $sql = "INSERT OR IGNORE INTO nutzer VALUES (
        'tim', 'tim@test.de', 'helloworld'
        )";

        if ( $db->exec( $sql ) ) {
            echo "Erste Nutzer-Daten sind vorhanden<br />";
    
        } else {
            echo 'Fehler beim anlegen der ersten Nutzerdaten!';
        }
        
?>