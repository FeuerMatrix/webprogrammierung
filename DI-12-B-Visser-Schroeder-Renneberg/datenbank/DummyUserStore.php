<?php
include_once "UserStore.php";
    class DummyUserStore implements UserStore {
        function store($email, $pw){

        }
        function checkLoginData($email, $pw){
            return $email == "tim@test.de" && $pw == "helloworld";
        }
        function isLoggedIn($email){
            return false;
        }

        function emailExists($username){
            return $username == "blockedName";
        }


        // Beispieldaten für Foreneinträge
        function getBeitraege(){
            $beitraege = array(
                array('id' => "1", 'author' => '0', 'anonym' => FALSE, 'titel' => 'Argumentation', 'date' => '05.06.1996' , 'file' => 'images/beispielbilder/argumentation.png', 'pname' => 'Argumentation' ),
                array('id' => "2", 'author' => '0', 'anonym' => FALSE, 'titel' => 'Protest', 'date' => '08.04.1976' , 'file' => 'images/beispielbilder/protest.png', 'pname' => 'Protest'),
                array('id' => "3", 'author' => '0', 'anonym' => FALSE, 'titel' => 'Trouble Incoming', 'date' => '08.05.1976', 'file' => 'images/beispielbilder/trouble.jpg', 'pname' => 'Trouble_Schilder'),
                array('id' => "4", 'author' => '0', 'anonym' => FALSE, 'titel' => 'Beispielbild', 'date' => '08.04.1976' , 'file' => 'images/guestbook.png', 'pname' => 'Beispielbild')
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

        function newComment($auth,$new,$post_id){
            //Add id

        }

        function updateComment($id,$comm_id, $new){

        }

        function newPost($auth,$title,$desc,$anony,$image,$date){
            //add date
        }

        function updatePost($id,$title,$desc,$anony,$image){
            
        }

        function deletePost($id){
            
        }

 

    }
?>