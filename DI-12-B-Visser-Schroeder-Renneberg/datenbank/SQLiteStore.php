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
                    id_nutzer   INT PRIMARY KEY,
                    email       TEXT NOT NULL,
                    passwort    TEXT NOT NULL
                )";

                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim Anlegen der Nutzer-Tabelle!<br />';
                }

                $pw = password_hash('helloworld',PASSWORD_DEFAULT);
                $sql = "INSERT OR IGNORE INTO nutzer VALUES (
                    0 , 'tim@test.de', '$pw'
                )";

                if ( $this->db->exec( $sql ) !== false ) {
                } else {
                    echo 'Fehler beim anlegen der ersten Nutzerdaten!<br />';
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
                    FOREIGN KEY(author) REFERENCES nutzer(nutzername)
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
        function store($user, $email, $pw){
            try {
                $sql = "INSERT OR REPLACE nutzer (id_nutzer, email, passwort) VALUES (? , ?, ?)";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("iss", $user, $email,password_hash($pw,PASSWORD_DEFAULT));
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
                $sql = "SELECT (id_nutzer) FROM nutzer WHERE email = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("s", $email); 
                return $stmt->execute();
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        // überprüft ob der Nutzer exestiert
        function userNameExists($email){
            try {
                $sql = "SELECT (id_nutzer) FROM nutzer WHERE email = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->bind_param("s", $email); 
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return !empty($result);
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }

        // gibt die Email des Nutzers mit der übergebenen Nutzer-ID aus
        function getUser($nutzer_id){
            try {
                $sql = "SELECT email FROM nutzer WHERE id_nutzer = ?";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([$nutzer_id]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result['email'];
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
                    'id' => $item['id_beitrag'],
                    'author' => $item['author'],
                    'anonym' => $item['anonym'],
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
                $ergebnis = $this->db->query($sql);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getTitel($id){
            try {
                $sql = "SELECT titel FROM beitrag WHERE id_beitrag=$id";
                $ergebnis = $this->db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getDesc($id){
            try {
                $sql = "SELECT beschreibung FROM beitrag WHERE id_beitrag=$id";
                $ergebnis = $this->db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getAuthor($id){
            try {
                $sql = "SELECT author FROM beitrag WHERE id_beitrag=$id";
                $ergebnis = $this->db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getAnonym($id){
            try {
                $sql = "SELECT anonym FROM beitrag WHERE id_beitrag=$id";
                $ergebnis = $this->db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getDate($id){
            try {
                $sql = "SELECT datum FROM beitrag WHERE id_beitrag=$id";
                $ergebnis = $this->db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
                echo "Fehler: " . $ex->getMessage();
            }
        }
        function getImage($id){
            try {
                $sql = "SELECT bild FROM beitrag WHERE id_beitrag=$id";
                $ergebnis = $this->db->query($sql);
                $ergebnis = htmlspecialchars($ergebnis);
                return $ergebnis;
            } catch (PDOException $ex) {
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
        function deletePost($id){

        }
    }

?>
