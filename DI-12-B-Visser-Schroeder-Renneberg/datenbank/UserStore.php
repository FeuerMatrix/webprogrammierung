<?php
    interface UserStore {
        function store($user, $email, $pw);
        function checkLoginData($email, $pw);
        function isLoggedIn($email);
        function userNameExists($username);
        function getUser($user);
        function getBeitraege();
        function getComments($id);
        function getTitel($id);
        function getDesc($id);
        function getAuthor($id);
        function getAnonym($id);
        function getDate($id);
        function getImage($id);
        function getCommentAuthor($id, $comm_id);
        function getComment($id,$comm_id);
        function newComment($auth,$new);
        function updateComment($id,$comm_id, $new);
        function newPost($auth,$title,$desc,$anony,$image);
        function updatePost($id,$auth,$title,$desc,$anony,$image);
        function deletePost($id);
    }
    ?>