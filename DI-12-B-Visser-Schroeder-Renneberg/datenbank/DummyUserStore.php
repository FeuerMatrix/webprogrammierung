<?php
include_once "UserStore.php";
    class DummyUserStore implements UserStore {
        function store($user, $email, $pw){

        }
        function checkLoginData($email, $pw){
            return $email == "tim@test.de" && $pw == "helloworld";
        }
        function isLoggedIn($email){
            return false;
        }

        function userNameExists($username){
            return $username == "blockedName";
        }
        function getUser($user) {
            return "Ich";
        }


        // Beispieldaten für Foreneinträge
        function getBeitraege(){
            $beitraege = array(
                array('id' => "1", 'titel' => 'Argumentation', 'date' => '05.06.1996' , 'file' => 'images/beispielbilder/argumentation.png', 'pname' => 'Argumentation' ),
                array('id' => "2", 'titel' => 'Protest', 'date' => '08.04.1976' , 'file' => 'images/beispielbilder/protest.png', 'pname' => 'Protest'),
                array('id' => "3", 'titel' => 'Trouble Incoming', 'date' => '08.05.1976', 'file' => 'images/beispielbilder/trouble.jpg', 'pname' => 'Trouble_Schilder'),
                array('id' => "4", 'titel' => 'Beispielbild', 'date' => '08.04.1976' , 'file' => 'images/guestbook.png', 'pname' => 'Beispielbild')
            );
            return $beitraege;
        }


        //comment array from post with id
        function getComments($id){
            return array(
                array(0, "Der","grfaghaergherreag"),
                array(1, "Die","harhngrjrtahgrfsjhtr"),
                array(2, "Das","htrshtgbgsfhjtrsh")
            ); 
        }

        function getTitel($id){
            return "Testtitel";
        }

        function getDesc($id){
            return "Testdesc";
        }

        function getAuthor($id){
            return "Ich";
        }

        function getAnonym($id){
            return true;
        }

        function getDate($id){
            return "1.1.1970";
        }

        function getImage($id){
            return "images/guestbook.png";
        }

        function getCommentAuthor($id, $comm_id){
            return "Dummy";
        }

        function getComment($id,$comm_id){
            return "Oldcomment";
        }

        function newComment($auth,$new){
            //Add id

        }

        function updateComment($id,$comm_id, $new){

        }

        function newPost($auth,$title,$desc,$anony,$image){
            //add date
        }

        function updatePost($id,$auth,$title,$desc,$anony,$image){
            
        }

 








    }
?>