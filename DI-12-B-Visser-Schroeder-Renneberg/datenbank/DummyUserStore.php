<?php
    interface UserStore {
        function store($user, $email, $pw);
        function checkLoginData($email, $pw);
        function isLoggedIn($email);
        function userNameExists($username);
        function getUser($user);
    }

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
            return "DummyValue";
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