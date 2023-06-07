<?php
    include_once "UserStore.php";

    class SQLiteStore implements UserStore {
//rohdaten in die db dan beim auslesen  htmlsecialchars
//Transaction (registrieren)
        protected $db;
        public function __construct(){
            try{
                $dsn = 'sqlite:sqlite-beschwerdeforum.db';
                $this->db = new PDO($dsn);

                //Creates Tables and fills them with dummy data.
                //TODO remove dummy data

                //NUTZER TABELLE
                $sql = "CREATE TABLE IF NOT EXISTS nutzer (
                    email       TEXT PRIMARY KEY,
                    passwort    TEXT NOT NULL
                )";

                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim Anlegen der Nutzer-Tabelle!<br />';
                }

                $pw = password_hash('helloworld',PASSWORD_DEFAULT);
                $sql = "INSERT OR IGNORE INTO nutzer VALUES (
                    'tim@test.de', '$pw'
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
                    datum               TIMESTAMP,  
                    bild                TEXT,
                    beschreibung    TEXT,
                    FOREIGN KEY(author) REFERENCES nutzer(email)
                )";

                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim Anlegen der Beitrags-Tabelle!<br />';
                }    

                $sql = "INSERT OR IGNORE INTO beitrag VALUES
                    (1, 0, FALSE, 'Argumentation', '05.06.1996', 'images/beispielbilder/argumentation.png', 'Argumentation'),
                    (2, 0, FALSE, 'Protest', '08.04.1976', 'images/beispielbilder/protest.png', 'Protest'),
                    (3, 0, FALSE, 'Trouble Incoming', '08.05.1976', 'images/beispielbilder/trouble.jpg', 'Trouble_Schilder'),
                    (4, 0, FALSE, 'Beispielbild', '08.04.1976', 'images/guestbook.png', 'Beispielbild'
                )";

                if ( $this->db->exec( $sql ) !== false ) {

                } else {
                    echo 'Fehler beim anlegen der ersten Beitragsdaten!<br />';
                }

                //KOMMENTAR TABELLE
                $sql = "CREATE TABLE IF NOT EXISTS kommentar (
                    id_kommentar    INTEGER,
                    id_beitrag      INTEGER,
                    author          INT,
                    kommentar       TEXT,
                    PRIMARY KEY(id_beitrag, id_kommentar),
                    FOREIGN KEY(id_beitrag) REFERENCES beitrag(id_beitrag),
                    FOREIGN KEY(author) REFERENCES nutzer(email)
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
             } catch (PDOException $e ) {
                echo 'Fehler: ' . htmlspecialchars( $e->getMessage() );
                exit();
            }
        }

        // Speichert den Nutzer ein oder Updatet ihn
        function store($email, $pw){
            try {
                $sql = "INSERT INTO nutzer (email, passwort) VALUES (?, ?) ON DUPLICATE KEY UPDATE passwort = ?";
                $stmt = $this->db->prepare($sql);
                $hashedPw = password_hash($pw, PASSWORD_DEFAULT);
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
                $stmt->bindParam(2, $hashedPW, PDO::PARAM_STR);
                $stmt->bindParam(3, $hashedPW, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        // überprüft Einlogdaten des Nutzer
        function checkLoginData($email, $pw){
            try {
                $sql = "SELECT passwort FROM nutzer WHERE email = ?";
                $stmt = $this->db->prepare($sql); 
                $stmt->execute([$email]);
                $storedPassword = $stmt->fetchColumn();
                return password_verify($pw, $storedPassword);
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
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
                echo "Fehler: " . $ex->getMessage();
            }
        }

        // überprüft ob der Nutzer exestiert
        function emailExists($email){
            try {
                $sql = "SELECT email FROM nutzer WHERE email = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(1, $email, PDO::PARAM_STR); 
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return !empty($result);
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        function newBeitrag($id, $author, $anonym, $title, $date, $file, $pname){
            try {
                $sql = "INSERT INTO beitraege (id_beitrag, author, anonym, titel, datum, bild, beschreibung) VALUES (?, ?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE author = VALUES(author), anonym = VALUES(anonym), titel = VALUES(titel), datum = VALUES(datum), bild = VALUES(bild), beschreibung = VALUES(beschreibung)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(1, $id, PDO::PARAM_INT);
                $stmt->bindParam(2, $author, PDO::PARAM_STR);
                $stmt->bindParam(3, $anonym, PDO::PARAM_BOOL);
                $stmt->bindParam(4, $title, PDO::PARAM_STR);
                $stmt->bindParam(5, $date, PDO::PARAM_STR);
                $stmt->bindParam(6, $file, PDO::PARAM_STR);
                $stmt->bindParam(7, $pname, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        

        function getBeitraege(){
            try {
                $sql = "SELECT * FROM beitrag";
                $stmt = $this->db->query($sql);
                $originalArray = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
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

        function getComments($id){
            try {
                $sql = "SELECT * FROM kommentar";
                $ergebnis = $this->db->query($sql);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getTitel($id){
            try {
                $sql = "SELECT titel FROM beitrag WHERE id_beitrag=".$id;
                $stmt = $this->db->query($sql);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getDesc($id){
            try {
                $sql = "SELECT beschreibung FROM beitrag WHERE id_beitrag=".$id;
                $stmt = $this->db->query($sql);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getAuthor($id){
            try {
                $sql = "SELECT author FROM beitrag WHERE id_beitrag=".$id;
                $stmt = $this->db->query($sql);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getAnonym($id){
            try {
                $sql = "SELECT anonym FROM beitrag WHERE id_beitrag=".$id;
                $stmt = $this->db->query($sql);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getDate($id){
            try {
                $sql = "SELECT datum FROM beitrag WHERE id_beitrag=".$id;
                $stmt = $this->db->query($sql);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getImage($id){
            try {
                $sql = "SELECT bild FROM beitrag WHERE id_beitrag=".$id;
                $stmt = $this->db->query($sql);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        function getCommentAuthor($id, $comm_id){
            try {
                $sql = "SELECT author FROM kommentar WHERE id_beitrag = ".$id." AND id_kommentar = ".$comm_id;
                $stmt = $this->db->query($sql);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
            
        }
        function getComment($id,$comm_id){
            try {
                $sql = "SELECT * FROM kommentar WHERE id_beitrag = ".$id." AND id_kommentar = ".$comm_id;
                $stmt = $this->db->query($sql);
                $stmt->execute();
                $ergebnis = $stmt->fetchColumn();
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function newComment($auth,$new,$post_id){
            //Add id
            $sql = "INSERT OR IGNORE INTO kommentar VALUES
                (1, post_id, $auth,$new)
            ";


            if ( $this->db->exec( $sql ) !== false ) {

            } else {
                echo 'Fehler beim Erstellen des Kommentars!<br />';
            }
        }
        function updateComment($id,$comm_id, $new){
            $sql = "UPDATE kommentar SET kommentar = $new WHERE id_kommentar = $comm_id AND id_beitrag = $id";

            if ( $this->db->exec( $sql ) !== false ) {

            } else {
                echo 'Fehler beim Ändern des Kommentars!<br />';
            }
        }
        function newPost($auth,$title,$desc,$anony,$image,$date){
            //Add id
            $sql = "INSERT OR IGNORE INTO beitrag VALUES
                (1, $auth, $anony, $title, $date, $image, $desc)
            ";

                if ( $this->db->exec( $sql ) !== false ) {

                } else {
                    echo 'Fehler beim Erstellen des Beitrags!<br />';
                }
        }
        function updatePost($id,$title,$desc,$anony,$image){
            $sql = "UPDATE beitrag SET anonym = $anony, titel = $title, bild = $image, beschreibung = $desc WHERE id_beitrag = $id";

            if ( $this->db->exec( $sql ) !== false ) {

            } else {
                echo 'Fehler beim Ändern des Kommentars!<br />';
            }
        }
        function deletePost($id){
            $sql = "DELETE FROM beitrag WHERE id_beitrag = $id";

            if ( $this->db->exec( $sql ) !== false ) {

            } else {
                echo 'Fehler beim Löschen des Beitrags!<br />';
            }
        }
    }

?>
