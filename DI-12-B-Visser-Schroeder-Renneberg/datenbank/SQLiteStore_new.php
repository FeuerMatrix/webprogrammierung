<?php

    $db = new SQLite3( 'beschwerdeforum.db' );

    //NUTZER TABELLE
    $sql = "CREATE TABLE IF NOT EXISTS nutzer (
        id_nutzer   INT PRIMARY KEY,
        email       TEXT NOT NULL,
        passwort    TEXT NOT NULL
        )";

        if ( $db->exec( $sql ) ) {
            echo 'Tabelle Nutzer vorhanden.<br />';
        } else {
            echo 'Fehler beim Anlegen der Nutzer-Tabelle!<br />';
        }

    $sql = "INSERT OR IGNORE INTO nutzer VALUES (
        0 , 'tim@test.de', 'helloworld'
        )";

        if ( $db->exec( $sql ) ) {
            echo "Erste Nutzer-Daten sind vorhanden<br />";
    
        } else {
            echo 'Fehler beim anlegen der ersten Nutzerdaten!';
        }

    //BEITRAGS TABELLE
    $sql = "CREATE TABLE IF NOT EXISTS beitrag (
        id_beitrag          INTEGER PRIMARY KEY,
        author              INT,
        anonym              BOOLEAN,
        titel               TEXT NOT NULL,
        datum               TIMESTAMP,  
        bild                TEXT,
        bildbeschreibung    TEXT,
        FOREIGN KEY(author) REFERENCES nutzer(nutzername)
        )";

        if ( $db->exec( $sql ) ) {
            echo 'Tabelle Beitrag vorhanden.<br />';
        } else {
            echo 'Fehler beim Anlegen der Beitrags-Tabelle!<br />';
        }    

    $sql = "INSERT OR IGNORE INTO beitrag VALUES
        (1, 0, FALSE, 'Argumentation', '05.06.1996', 'images/beispielbilder/argumentation.png', 'Argumentation'),
        (2, 0, FALSE, 'Protest', '08.04.1976', 'images/beispielbilder/protest.png', 'Protest'),
        (3, 0, FALSE, 'Trouble Incoming', '08.05.1976', 'images/beispielbilder/trouble.jpg', 'Trouble_Schilder'),
        (4, 0, FALSE, 'Beispielbild', '08.04.1976', 'images/guestbook.png', 'Beispielbild'
        )";

        if ( $db->exec( $sql ) ) {
            echo "Erste Beitrags-Daten sind vorhanden<br />";

        } else {
            echo 'Fehler beim anlegen der ersten Beitragsdaten!';
        }

    //KOMMENTAR TABELLE
    $sql = "CREATE TABLE IF NOT EXISTS kommentar (
        id_kommentar    INTEGER,
        id_beitrag      INTEGER,
        author          INT,
        kommentar       TEXT,
        PRIMARY KEY(id_beitrag, id_kommentar),
        FOREIGN KEY(id_beitrag) REFERENCES beitrag(id_beitrag),
        FOREIGN KEY(author) REFERENCES nutzer(nutzername)
        )";

        if ( $db->exec( $sql ) ) {
            echo 'Tabelle Kommentar vorhanden.<br />';
        } else {
            echo 'Fehler beim Anlegen der Kommentar-Tabelle!<br />';
        }

    $sql = "INSERT OR IGNORE INTO kommentar VALUES
        (1, 1, 0,'grfaghaergherreag'),
        (1, 2, 0,'harhngrjrtahgrfsjhtr'),
        (1, 3, 0,'htrshtgbgsfhjtrsh')";

        if ( $db->exec( $sql ) ) {
            echo "Erste Kommentar-Daten sind vorhanden<br />";

        } else {
            echo 'Fehler beim anlegen der ersten Kommentardaten!';
        }
        
?>