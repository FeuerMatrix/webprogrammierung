<?php
    include_once "UserStore.php";

    class SQLiteStore implements UserStore {
//pw hashen
//rohdaten in die db dan beim auslesen  htmlsecialchars
//Transaction (registrieren)
        protected $db;
        public function __construct(){
            $db = new SQLite3( 'beschwerdeforum.db' );

            //Creates Tables and fills them with dummy data.
            //TODO remove dummy data

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

            $pw = password_hash('helloworld');
            $sql = "INSERT OR IGNORE INTO nutzer VALUES (
                0 , 'tim@test.de', $pw
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
                anonym              BOOLEAN NOT NULL,
                titel               TEXT NOT NULL,
                datum               TIMESTAMP,  
                bild                TEXT,
                beschreibung    TEXT,
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
                (1, 3, 0,'htrshtgbgsfhjtrsh'
            )";

            if ( $db->exec( $sql ) ) {
                echo "Erste Kommentar-Daten sind vorhanden<br />";

            } else {
                echo 'Fehler beim anlegen der ersten Kommentardaten!';
            }
        }

        // Speichert den Nutzer ein oder Updatet ihn
        function store($user, $email, $pw){
            try {
                $sql = "INSERT OR UPDATE nutzer (id_nutzer, email, passwort) VALUES (? , ?, ?)";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("iss", $user, $email, password_hash($pw));
                $stmt->execute();
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        // überprüft Einlogdaten des Nutzer
        function checkLoginData($email, $pw){
            try {
                $sql = "SELECT (id_nutzer) FROM nutzer WHERE email = ? AND passwort = ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("ss", $email, password_hash($pw)); 
                return $stmt->execute();
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        // überprüft ob der Nutzer exestiert
        function isLoggedIn($email){
            try {
                $sql = "SELECT (id_nutzer) FROM nutzer WHERE email = ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("s", $email); 
                return $stmt->execute();
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        // überprüft ob der Nutzer exestiert
        function userNameExists($email){
            try {
                $sql = "SELECT (id_nutzer) FROM nutzer WHERE email = ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("s", $email); 
                return $stmt->execute();
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        // gibt die Email des Nutzers mit der übergebenen Nutzer-ID aus
        function getUser($nutzer_id){
            try {
                $sql = "SELECT (email) FROM nutzer WHERE id_nutzer = ?";
                $stmt = $db->prepare($sql);
                $stmt->bind_param("s", $nutzer_id); 
                return $stmt->execute();
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        function getBeitraege(){
            try {
                $sql = "SELECT * FROM beitrag";
                $ergebnis = $db->query($sql);
                $array = $ergebnis->fetchAll();
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
                return [];
            }

            $newArray = array();

            foreach ($originalArray as $item) {
                $newItem = array(
                    'id' => $item['id_beitrag'],
                    'author' => $item['author'],
                    'anonym' => $item['ananoym'],
                    'titel' => $item['titel'],
                    'date' => $item['datum'],
                    'file' => $item['bild'],
                    'pname' => $item['beschreibung']
                );
                $newArray[] = $newItem;
            }

            return $newArray;
        }

        function getComments($id){
            try {
                $sql = "SELECT * FROM kommentar";
                $ergebnis = $db->query($sql);
                return $ergebnis;
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getTitel($id){
            try {
                $sql = "SELECT titel FROM beitrag WHERE id=$id";
                $ergebnis = $db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getDesc($id){
            try {
                $sql = "SELECT beschreibung FROM beitrag WHERE id=$id";
                $ergebnis = $db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getAuthor($id){
            try {
                $sql = "SELECT author FROM beitrag WHERE id=$id";
                $ergebnis = $db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getAnonym($id){
            try {
                $sql = "SELECT anonym FROM beitrag WHERE id=$id";
                $ergebnis = $db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getDate($id){
            try {
                $sql = "SELECT datum FROM beitrag WHERE id=$id";
                $ergebnis = $db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getImage($id){
            try {
                $sql = "SELECT bild FROM beitrag WHERE id=$id";
                $ergebnis = $db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (Exception $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        function getCommentAuthor($id, $comm_id){
       
        }
        function getComment($id,$comm_id){

        }
        function newComment($auth,$new){
            //Add id
        }
        function updateComment($id,$comm_id, $new){

        }
        function newPost($auth,$title,$desc,$anony,$image){
            //add date
            //Add id
        }
        function updatePost($id,$auth,$title,$desc,$anony,$image){

        }
    }

?>
