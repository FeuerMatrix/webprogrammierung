<?php
    include_once "UserStore.php";
    include_once "salt.php";

    class SQLiteStore implements UserStore {
        protected $db;

        public function __destruct(){
            //The transmission is automatically commited/rolled back when this is unset or the script is ended.
            if($this->db->inTransaction()){
                try{
                    $this->db->commit();
                } catch (Exception $e) {
                    echo 'Commit Fehlgeschlagen';
                    $this->db->rollBack();
                }
            }
        }

        public function __construct(){
            $path = __DIR__;
            
            try{
                $dsn = 'sqlite:'. $path .'\sqlite-beschwerdeforum.db';
                $user = "root";
                $pw = null;
                $this->db = new PDO($dsn, $user, $pw);
                $this->db->beginTransaction();
                $this->db->exec("PRAGMA foreign_keys = ON");


                //NUTZER TABELLE
                $sql = "CREATE TABLE IF NOT EXISTS nutzer (
                    email       TEXT PRIMARY KEY,
                    passwort    TEXT NOT NULL,
                    token       TEXT NOT NULL,
                    confirmed   BOOLEAN,
                    created     TIMESTAMP DEFAULT (DATETIME('now', 'localtime'))
                )";

                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim Anlegen der Nutzer-Tabelle!<br />';
                }

                $pw = password_hash('helloworld',PASSWORD_DEFAULT);
                $sql = "INSERT OR IGNORE INTO nutzer VALUES (
                    'tim@test.de', '$pw', 'DiTROSrT0dXkk', 1, CURRENT_TIMESTAMP 
                )";

                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim anlegen der ersten Nutzerdaten!<br />';
                }

                //BEITRAGS TABELLE
                $sql = "CREATE TABLE IF NOT EXISTS beitrag (
                    id_beitrag          INTEGER PRIMARY KEY,
                    author              TEXT,
                    anonym              BOOLEAN NOT NULL,
                    titel               TEXT NOT NULL,
                    datum               TEXT,  
                    bild                TEXT,
                    beschreibung        TEXT,
                    lat                 TEXT,
                    lng                 TEXT,
                    FOREIGN KEY(author) REFERENCES nutzer(email)
                )";

                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim Anlegen der Beitrags-Tabelle!<br />';
                }    

                $sql = "INSERT OR IGNORE INTO beitrag VALUES
                    (1, 0, FALSE, 'Argumentation', '0686156644', 'images/beispielbilder/argumentation.png', 'Argumentation',null,null),
                    (2, 0, FALSE, 'Protest', '1606156644', 'images/beispielbilder/protest.png', 'Protest',null,null),
                    (3, 0, FALSE, 'Trouble Incoming', '1686156044', 'images/beispielbilder/trouble.jpg', 'Trouble_Schilder',null,null),
                    (4, 0, FALSE, 'Beispielbild', '1686106644', 'images/guestbook.png', 'Beispielbild',null,null)";

                if ( $this->db->exec( $sql ) !== false ) {

                } else {
                    echo 'Fehler beim anlegen der ersten Beitragsdaten!<br />';
                }

                //KOMMENTAR TABELLE
                $sql = "CREATE TABLE IF NOT EXISTS kommentar (
                    id_kommentar    INTEGER,
                    id_beitrag      INTEGER REFERENCES beitrag(id_beitrag) ON DELETE CASCADE,
                    author          INT REFERENCES nutzer(email) ON DELETE CASCADE,
                    kommentar       TEXT,
                    PRIMARY KEY(id_kommentar, id_beitrag)
                )";

                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim Anlegen der Kommentar-Tabelle!<br />';
                }

                $sql = "INSERT OR IGNORE INTO kommentar VALUES
                    (1, 1, 0,'grfaghaergherreag'),
                    (1, 2, 0,'harhngrjrtahgrfsjhtr'),
                    (1, 3, 0,'htrshtgbgsfhjtrsh'
                )";

                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim anlegen der ersten Kommentardaten!<br />';
                }
                
                $this->db->commit();

                //lösche Nutzer die nicht innerhalb von 24h ihre Email bestätigen
                $sql = "DELETE FROM nutzer WHERE created < datetime('now', '-24 hours') AND confirmed = 0";
                
                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim löschen von nicht bestätigten Nutzern!<br />';
                }

             } catch (PDOException $e ) {
                echo 'Fehler beim erstllen der Dummy Daten';
            }
        }

        // Speichert Regestrierungsdaten ein mit Status das noch bestätigt werden muss (confirm = false)
        function store($email, $pw){
            try {
                global $salt;
                $sql = "INSERT OR REPLACE INTO nutzer (email, passwort, token, confirmed ) VALUES (?, ?, ?, 0)";
                $stmt = $this->db->prepare($sql);
                $hashedPw = password_hash($pw, PASSWORD_DEFAULT);
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
                $stmt->bindParam(2, $hashedPw, PDO::PARAM_STR);
                $stmt->bindParam(3, crypt($email, $salt), PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $ex) {
                echo 'Fehler beim speichern des Nutzers!<br />';
            }
        }

        // Ändert den Status eines Nutzers zu Email Bestätigt
        function confirmUser($email){
            try {
                $sql = "UPDATE nutzer SET confirmed = 1 WHERE email = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $ex) {
                echo 'Fehler beim ändern der Bestätigung der Email!<br />';
            }
        }

        // Überschreibt das Passwort eines Nutzers mit dem Übergebenen
        function updatePassword($email, $pw) {
            try{
            $sql = "UPDATE nutzer SET passwort = ? WHERE email = ?";
            $stmt = $this->db->prepare($sql);
            $hashedPw = password_hash($pw, PASSWORD_DEFAULT);
            $stmt->bindParam(1, $hashedPw, PDO::PARAM_STR);
            $stmt->bindParam(2, $email, PDO::PARAM_STR);
            $stmt->execute();

            } catch (PDOException $ex) {
                echo 'Fehler beim Ändern des Passwortes!<br />';
                echo $ex;
            }
        }

        // überprüft Einlogdaten des Nutzer wenn Regestrierung bereits bestätigt
        function checkLoginData($email, $pw){
            try {
                $sql = "SELECT passwort FROM nutzer WHERE email = ? AND confirmed = 1";
                $stmt = $this->db->prepare($sql); 
                $stmt->execute([$email]);
                $storedPassword = $stmt->fetchColumn();
                return password_verify($pw, $storedPassword);
            } catch (PDOException $ex) {
                echo 'Fehler beim uberpruefen der Login daten!<br />';
            }
        }

        // überprüft ob der Nutzer exestiert
        function isLoggedIn($email){
            try {
                $sql = "SELECT email FROM nutzer WHERE email = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(1, $email, PDO::PARAM_STR); 
                return $stmt->execute();
            } catch (PDOException $ex) {
                echo 'Fehler beim pruefen ob Nutzer eingeloggt ist!<br />';
            }
        }

        // überprüft ob der Nutzer exestiert
        function emailExists($email){
            try {
                $sql = "SELECT email FROM nutzer WHERE email = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return !empty($result);
            } catch (PDOException $ex) {
                echo 'Fehler beim pruefen ob Email existiert!<br />';
            }
        }

        // gibt den Nutzer zurück der den Token besitzt
        function getUser($token){
            try {
                $sql = "SELECT email FROM nutzer WHERE token=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(1, $token, PDO::PARAM_STR);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim finden des Nutzers!<br />';
            }
        }

        // gibt einen Array mit den letzten 20 erstellten Beiträgen aus
        function getBeitraege(){
            try {
                $sql = "SELECT * FROM beitrag ORDER BY datum DESC LIMIT 20";
                $stmt = $this->db->query($sql);
                $originalArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                echo 'Fehler laden der Beitraege!<br />';
                return [];
            }

            $newArray = array();

            foreach ($originalArray as $item) {
                $newItem = array(
                    'id' => htmlspecialchars($item['id_beitrag']),
                    'author' => htmlspecialchars($item['author']),
                    'anonym' => htmlspecialchars($item['anonym']),
                    'titel' => htmlspecialchars($item['titel']),
                    'date' => htmlspecialchars($item['datum']),
                    'file' => htmlspecialchars($item['bild']),
                    'pname' => htmlspecialchars($item['beschreibung'])
                );
                $newArray[] = $newItem;
            }

            return $newArray;
        }


        // gibt einen Array mit den letzten 20 Beiträgen aus die den Suchbegriff beinhalten aus
        function sucheBeitraege($search){
            $search = strtolower($search);
            try {
                $sql = "SELECT * FROM beitrag WHERE LOWER(titel) LIKE ? ORDER BY datum DESC LIMIT 20";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, '%'.$search.'%', PDO::PARAM_STR);
                $stmt->execute();
                $originalArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                echo 'Fehler laden der Beitraege!<br />';
                return [];
            }

            $newArray = array();

            foreach ($originalArray as $item) {
                $newItem = array(
                    'id' => htmlspecialchars($item['id_beitrag']),
                    'author' => htmlspecialchars($item['author']),
                    'anonym' => htmlspecialchars($item['anonym']),
                    'titel' => htmlspecialchars($item['titel']),
                    'date' => htmlspecialchars($item['datum']),
                    'file' => htmlspecialchars($item['bild']),
                    'pname' => htmlspecialchars($item['beschreibung'])
                );
                $newArray[] = $newItem;
            }

            return $newArray;
        }

        // gibt einen Array mit den alphabetisch ersten 20 Beiträgen aus die den Suchbegriff beinhalten
        function sucheBeitraegeAlphabetisch($search){
            $search = strtolower($search);
            try {
                $sql = "SELECT * FROM beitrag WHERE LOWER(titel) LIKE ? ORDER BY titel ASC LIMIT 20";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, '%'.$search.'%', PDO::PARAM_STR);
                $stmt->execute();
                $originalArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                echo 'Fehler laden der Beitraege!<br />';
                return [];
            }

            $newArray = array();

            foreach ($originalArray as $item) {
                $newItem = array(
                    'id' => htmlspecialchars($item['id_beitrag']),
                    'author' => htmlspecialchars($item['author']),
                    'anonym' => htmlspecialchars($item['anonym']),
                    'titel' => htmlspecialchars($item['titel']),
                    'date' => htmlspecialchars($item['datum']),
                    'file' => htmlspecialchars($item['bild']),
                    'pname' => htmlspecialchars($item['beschreibung'])
                );
                $newArray[] = $newItem;
            }

            return $newArray;
        }

        // gibt alle Kommentare zu einem Beitrag in einem Array aus
        function getComments($id){
            try {
                $sql = "SELECT * FROM kommentar where id_beitrag=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $originalArray = $stmt->fetchAll(PDO::FETCH_ASSOC);

                $newArray = array();

                foreach ($originalArray as $item) {
                    $newItem = array(
                        '0' => htmlspecialchars($item['id_kommentar']),
                        '1' => htmlspecialchars($item['author']),
                        '2' => htmlspecialchars($item['kommentar']),
                    );
                    $newArray[] = $newItem;
                }

                return $newArray;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden der Kommentare!<br />';
            }
        }

        // gibt des Titel eines Beitrages anhand der id zurück
        function getTitel($id){
            try {
                $sql = "SELECT titel FROM beitrag WHERE id_beitrag=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden des Titels!<br />';
            }
        }

        // gibt die Beschreibung eines Beitrages anhand der id zurück
        function getDesc($id){
            try {
                $sql = "SELECT beschreibung FROM beitrag WHERE id_beitrag=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden der Beschreibung!<br />';
            }
        }

        // gibt den Author eines Beitrages anhand der id zurück
        function getAuthor($id){
            try {
                $sql = "SELECT author FROM beitrag WHERE id_beitrag=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden des Post Authors!<br />';
            }
        }

        // gibt zurück ob ein Beitrag als anonym verfasst wurde
        function getAnonym($id){
            try {
                $sql = "SELECT anonym FROM beitrag WHERE id_beitrag=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden ob der Beitrag anonym ist!<br />';
            }
        }

        // gibt das Erstellungsdatum eines Beitrages anhand der id zurück
        function getDate($id){
            try {
                $sql = "SELECT datum FROM beitrag WHERE id_beitrag=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                $ergebnis = date("Y-m-d H:i:s",$ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden des Datums!<br />';
            }
        }

        // gibt den Bildpfad eines Beitrages anhand der id zurück
        function getImage($id){
            try {
                $sql = "SELECT bild FROM beitrag WHERE id_beitrag=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden des Bildes!<br />';
            }
        }

        // gibt die Breite des vermerkten Ortes eines Beitrages anhand der id zurück
        function getlat($id){
            try {
                $sql = "SELECT lat FROM beitrag WHERE id_beitrag=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = floatval($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden der Koordinate!<br />';
            }
        }

        // gibt die Länge des vermerkten Ortes eines Beitrages anhand der id zurück
        function getlng($id){
            try {
                $sql = "SELECT lng FROM beitrag WHERE id_beitrag=?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = floatval($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden der Koordinate!<br />';
            }
        }

        // gibt den Author eines Kommentars anhand der id's zurück
        function getCommentAuthor($id, $comm_id){
            try {
                $sql = "SELECT author FROM kommentar WHERE id_beitrag = ? AND id_kommentar = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->bindValue(2, $comm_id, PDO::PARAM_INT);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden des Kommentar Authors!<br />';
            }
        }

        // gibt den Text eines Kommentars anhand der id's zurück
        function getComment($id,$comm_id){
            try {
                $sql = "SELECT kommentar FROM kommentar WHERE id_beitrag = ? AND id_kommentar = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(1, $id, PDO::PARAM_INT);
                $stmt->bindValue(2, $comm_id, PDO::PARAM_INT);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo 'Fehler beim laden der Kommentare!<br />';
            }
        }

        // erstellt einen neuen Kommentar
        function newComment($auth,$new,$post_id){
            try {
            $sql = "SELECT MAX(id_kommentar) AS max FROM kommentar WHERE id_beitrag = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
            $stmt->execute();
    
            $sql = "INSERT OR IGNORE INTO kommentar (id_kommentar,id_beitrag,author,kommentar ) VALUES(".($stmt->fetch(PDO::FETCH_ASSOC)['max']+1).", ?, ?, ?)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $post_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $auth, PDO::PARAM_STR);
            $stmt->bindParam(3, $new, PDO::PARAM_STR);
            $stmt->execute();

            } catch (PDOException $ex) {
                echo 'Fehler beim erstellen des Kommentars!<br />';
            }
        }

        // aktuallisiert den Text eines Kommentars anhand der id's
        function updateComment($id,$comm_id, $new){
            try {
            $sql = "UPDATE kommentar SET kommentar = ? WHERE id_kommentar = ? AND id_beitrag = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $new, PDO::PARAM_STR);
            $stmt->bindParam(2, $comm_id, PDO::PARAM_INT);
            $stmt->bindParam(3, $id, PDO::PARAM_INT);
            $stmt->execute();

            } catch (PDOException $ex) {
                echo 'Fehler beim Ändern des Kommentars!<br />';
            }
        }

        // erstellt einen neuen Beitrag
        function newPost($auth, $title, $desc, $anony, $image, $lat, $lng){
            $date = time();
            try {
                $sql = "INSERT INTO beitrag (author, anonym, titel, datum, bild, beschreibung, lat, lng) VALUES (?, ?, ?, ?, ?, ?, ? ,?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(1, $auth, PDO::PARAM_STR);
                $stmt->bindParam(2, $anony, PDO::PARAM_BOOL);
                $stmt->bindParam(3, $title, PDO::PARAM_STR);
                $stmt->bindParam(4, $date, PDO::PARAM_STR);
                $stmt->bindParam(5, $image, PDO::PARAM_STR);
                $stmt->bindParam(6, $desc, PDO::PARAM_STR);
                $stmt->bindParam(7, $lat, PDO::PARAM_STR);
                $stmt->bindParam(8, $lng, PDO::PARAM_STR);
                $stmt->execute();

                return $this->db->lastInsertId();
            } catch (PDOException $ex) {
                echo 'Fehler beim erstellen des Beitrags!<br />';
            }
        }

        // aktuallisiert einen Beitrag mit den neuen Werten
        function updatePost($id, $title, $desc, $anony, $image,$lat,$lng){
            try {
                $sql = "UPDATE beitrag SET anonym = ?, titel = ?, bild = ?, beschreibung = ?, lat = ?, lng = ?  WHERE id_beitrag = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(1, $anony, PDO::PARAM_BOOL);
                $stmt->bindParam(2, $title, PDO::PARAM_STR);
                $stmt->bindParam(3, $image, PDO::PARAM_STR);
                $stmt->bindParam(4, $desc, PDO::PARAM_STR);
                $stmt->bindParam(5, $lat, PDO::PARAM_STR);
                $stmt->bindParam(6, $lng, PDO::PARAM_STR);
                $stmt->bindParam(7, $id, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $ex) {
                echo 'Fehler beim bearbeiten des Post!<br />';
            }
        }

        // löscht einen Beitrag anhand der id und alle Kommentare die zu dem Beitrag gehören
        function deletePost($id) {
            $sql = "DELETE FROM kommentar WHERE id_beitrag = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
            if ($stmt->execute()) {
            } else {
                echo 'Fehler beim Löschen des Beitrags!<br />';
            }
            
            $sql = "DELETE FROM beitrag WHERE id_beitrag = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_INT);
        
            if ($stmt->execute()) {
            } else {
                echo 'Fehler beim Löschen des Beitrags!<br />';
            }
        }

        // löscht einen Nutzer anhand der Email, sowie alle Beiträge des Nutzers und jeweils deren Kommentare
        function deleteUser($email) {
            $sql = "DELETE FROM kommentar WHERE author = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            if ($stmt->execute()) {
            } else {
                echo 'Fehler beim Löschen des Nutzers!<br />';
            }

            $sql = "DELETE FROM beitrag WHERE author = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            if ($stmt->execute()) {
            } else {
                echo 'Fehler beim Löschen des Nutzers!<br />';
            }

            $sql = "DELETE FROM nutzer WHERE email = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
        
            if ($stmt->execute()) {
            } else {
                echo 'Fehler beim Löschen des Nutzers!<br />';
            }
        }

        // löscht einzelne Kommentare
        function deleteComm($id,$commid){
            $sql = "DELETE FROM kommentar WHERE id_beitrag = ? AND id_kommentar = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $id, PDO::PARAM_STR);
            $stmt->bindParam(2, $commid, PDO::PARAM_STR);
            if ($stmt->execute()) {
            } else {
                echo 'Fehler beim Löschen des Kommentars!<br />';
            }
        }
        
        // beginnt eine Transaktion
        function beginTransaction(){
            $this->db->beginTransaction();
        } 

        // beendet eine Transaktion
        function endTransaction(){
            try{
                $this->db->commit();
            } catch (Exception $e) {
                echo 'Commit Fehlgeschlagen';
                $this->db->rollBack();
            }
        }
    }
