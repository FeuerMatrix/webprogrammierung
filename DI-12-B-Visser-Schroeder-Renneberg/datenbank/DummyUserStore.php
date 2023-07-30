<?php
include_once "UserStore.php";
    class DummyUserStore implements UserStore {

        // Speichert Regestrierungsdaten ein mit Status das noch bestätigt werden muss (confirm = false)
        function store($email, $pw) {}
        
        // Ändert den Status eines Nutzers zu Email Bestätigt
        function confirmUser($email) {}
        
        // Überschreibt das Passwort eines Nutzers mit dem Übergebenen
        function updatePassword($email, $pw) {}

        // überprüft Einlogdaten des Nutzer wenn Regestrierung bereits bestätigt
        function checkLoginData($email, $pw) {
            return $email == "tim@test.de" && $pw == "helloworld";
        }
        
        // überprüft ob der Nutzer exestiert
        function isLoggedIn($email) {
            return false;
        }
        
        // überprüft ob der Nutzer exestiert
        function emailExists($username) {}
        
        // gibt den Nutzer zurück der den Token besitzt
        function getUser($token) {}
        
        // gibt einen Array mit den letzten 20 erstellten Beiträgen aus
        function getBeitraege(){
            $beitraege = array(
                array('id' => "1", 'author' => '0', 'anonym' => FALSE, 'titel' => 'Argumentation', 'date' => '05.06.1996' , 'file' => 'images/beispielbilder/argumentation.png', 'pname' => 'Argumentation' ),
                array('id' => "2", 'author' => '0', 'anonym' => FALSE, 'titel' => 'Protest', 'date' => '08.04.1976' , 'file' => 'images/beispielbilder/protest.png', 'pname' => 'Protest'),
                array('id' => "3", 'author' => '0', 'anonym' => FALSE, 'titel' => 'Trouble Incoming', 'date' => '08.05.1976', 'file' => 'images/beispielbilder/trouble.jpg', 'pname' => 'Trouble_Schilder'),
                array('id' => "4", 'author' => '0', 'anonym' => FALSE, 'titel' => 'Beispielbild', 'date' => '08.04.1976' , 'file' => 'images/guestbook.png', 'pname' => 'Beispielbild')
            );
            return $beitraege;
        }
        
        // gibt einen Array mit den letzten 20 Beiträgen aus die den Suchbegriff beinhalten aus
        function sucheBeitraege($search) {}

        // gibt einen Array mit den alphabetisch ersten 20 Beiträgen aus die den Suchbegriff beinhalten
        function sucheBeitraegeAlphabetisch($search) {}
        
        // gibt alle Kommentare zu einem Beitrag in einem Array aus
        function getComments($id){
            return array(
                array(0, "Der","grfaghaergherreag"),
                array(1, "Die","harhngrjrtahgrfsjhtr"),
                array(2, "Das","htrshtgbgsfhjtrsh")
            ); 
        }
        
        // gibt des Titel eines Beitrages anhand der id zurück
        function getTitel($id) {}
        
        // gibt die Beschreibung eines Beitrages anhand der id zurück
        function getDesc($id) {}
        
        // gibt den Author eines Beitrages anhand der id zurück
        function getAuthor($id) {}
        
        // gibt zurück ob ein Beitrag als anonym verfasst wurde
        function getAnonym($id) {}
        
        // gibt das Erstellungsdatum eines Beitrages anhand der id zurück
        function getDate($id) {}
        
        // gibt den Bildpfad eines Beitrages anhand der id zurück
        function getImage($id) {}
        
        // gibt die Breite des vermerkten Ortes eines Beitrages anhand der id zurück
        function getlat($id) {}
        
        // gibt die Länge des vermerkten Ortes eines Beitrages anhand der id zurück
        function getlng($id) {}
        
        // gibt den Author eines Kommentars anhand der id's zurück
        function getCommentAuthor($id, $comm_id) {}
        
        // gibt den Text eines Kommentars anhand der id's zurück
        function getComment($id,$comm_id) {}
        
        // erstellt einen neuen Kommentar
        function newComment($auth,$new,$post_id) {}
        
        // aktuallisiert den Text eines Kommentars anhand der id's
        function updateComment($id,$comm_id, $new) {}
        
        // erstellt einen neuen Beitrag
        function newPost($auth,$title,$desc,$anony,$image,$lat,$lng) {}
        
        // aktuallisiert einen Beitrag mit den neuen Werten
        function updatePost($id,$title,$desc,$anony,$image,$lat,$lng) {}
        
        // löscht einen Beitrag anhand der id und alle Kommentare die zu dem Beitrag gehören
        function deletePost($id) {}
        
        // löscht einen Nutzer anhand der Email, sowie alle Beiträge des Nutzers und jeweils deren Kommentare
        function deleteUser($email) {}
        
        // löscht einzelne Kommentare
        function deleteComm($id,$commid) {}

        // beginnt eine Transaktion
        function beginTransaction() {}

        // beendet eine Transaktion
        function endTransaction() {}

    }
?>