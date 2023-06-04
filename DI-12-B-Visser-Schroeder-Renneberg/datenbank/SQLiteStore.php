<?php

    include_once "UserStore.php";
    include_once "SQLiteStore_new";

    class SQLiteStore implements UserStore {
//pw hashen
//rohdaten in die db dan beim auslesen  htmlsecialchars
//Transaction (registrieren)

        function store($user, $email, $pw){

        }

        function checkLoginData($email, $pw){

        }

        function isLoggedIn($email){

        }

        function userNameExists($username){

        }

        function getUser($user){

        }

        function getBeitraege(){

        }

        function getComments($id){

        }
        function getTitel($id){

        }
        function getDesc($id){

        }
        function getAuthor($id){

        }
        function getAnonym($id){

        }
        function getDate($id){

        }
        function getImage($id){

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
