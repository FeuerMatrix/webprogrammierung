<?php
    include_once "UserStore.php";

    class SQLiteStore implements UserStore {
//rohdaten in die db dan beim auslesen  htmlsecialchars
//Transaction (registrieren)
        protected $db;
        public function __destruct(){
            //The transmission is automatically started at connection with database and automatically commited/rolled back when this is unset or the script is ended.
            //This makes sure you never have to care about transmissions. But, if multiple transmissions in a row are wanted, the SQLiteStore needs to be unset and reinstantiated.
            try{
                $this->db->commit();
            } catch (Exception $e) {
                echo 'Fehler: ' . htmlspecialchars( $e->getMessage() );
                $this->db->rollBack();
            }
        }

        public function __construct(){
            try{
                $dsn = 'sqlite:sqlite-beschwerdeforum.db';
                $user = "root";
                $pw = null;
                $this->db = new PDO($dsn, $user, $pw);
                $this->db->beginTransaction();
                $this->db->exec("PRAGMA foreign_keys = ON");
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
                    datum               TEXT,  
                    bild                TEXT,
                    beschreibung    TEXT,
                    FOREIGN KEY(author) REFERENCES nutzer(email)
                )";

                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim Anlegen der Beitrags-Tabelle!<br />';
                }    

                $sql = "INSERT OR IGNORE INTO beitrag VALUES
                    (1, 0, FALSE, 'Argumentation', '0686156644', 'images/beispielbilder/argumentation.png', 'Argumentation'),
                    (2, 0, FALSE, 'Protest', '1606156644', 'images/beispielbilder/protest.png', 'Protest'),
                    (3, 0, FALSE, 'Trouble Incoming', '1686156044', 'images/beispielbilder/trouble.jpg', 'Trouble_Schilder'),
                    (4, 0, FALSE, 'Beispielbild', '1686106644', 'images/guestbook.png', 'Beispielbild'
                )";

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
                $this->db->beginTransaction();
             } catch (PDOException $e ) {
                echo 'Fehler: ' . htmlspecialchars( $e->getMessage() );
            }
        }

        // Speichert den Nutzer ein oder Updatet ihn
        function store($email, $pw){
            try {
                $sql = "INSERT OR REPLACE INTO nutzer (email, passwort) VALUES (?, ?)";
                $stmt = $this->db->prepare($sql);
                $hashedPw = password_hash($pw, PASSWORD_DEFAULT);
                $stmt->bindParam(1, $email, PDO::PARAM_STR);
                $stmt->bindParam(2, $hashedPw, PDO::PARAM_STR);
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
                $sql = "SELECT * FROM kommentar where id_beitrag=".$id;
                $stmt = $this->db->query($sql);
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
                $ergebnis = date("Y-m-d H:i:s",$ergebnis);
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
                $sql = "SELECT kommentar FROM kommentar WHERE id_beitrag = ".$id." AND id_kommentar = ".$comm_id;
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
                echo $ex;
            }
        }
        function updateComment($id,$comm_id, $new){
            try {
            $sql = "UPDATE kommentar SET kommentar = ? WHERE id_kommentar = ".$comm_id." AND id_beitrag = ".$id;
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(1, $new, PDO::PARAM_STR);
            $stmt->execute();

            } catch (PDOException $ex) {
                echo 'Fehler beim Ändern des Kommentars!<br />';
            }
        }

        function newPost($auth, $title, $desc, $anony, $image){
            $date = time();
            try {
                $sql = "INSERT INTO beitrag (author, anonym, titel, datum, bild, beschreibung) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(1, $auth, PDO::PARAM_STR);
                $stmt->bindParam(2, $anony, PDO::PARAM_BOOL);
                $stmt->bindParam(3, $title, PDO::PARAM_STR);
                $stmt->bindParam(4, $date, PDO::PARAM_STR);
                $stmt->bindParam(5, $image, PDO::PARAM_STR);
                $stmt->bindParam(6, $desc, PDO::PARAM_STR);
                $stmt->execute();

                return $this->db->lastInsertId();
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        function updatePost($id, $title, $desc, $anony, $image){
            try {
                $sql = "UPDATE beitrag SET anonym = ?, titel = ?, bild = ?, beschreibung = ? WHERE id_beitrag = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bindParam(1, $anony, PDO::PARAM_BOOL);
                $stmt->bindParam(2, $title, PDO::PARAM_STR);
                $stmt->bindParam(3, $image, PDO::PARAM_STR);
                $stmt->bindParam(4, $desc, PDO::PARAM_STR);
                $stmt->bindParam(5, $id, PDO::PARAM_INT);
                $stmt->execute();
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

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
        
    }

?>
