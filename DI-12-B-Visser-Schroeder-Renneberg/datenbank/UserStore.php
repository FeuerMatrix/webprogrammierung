<?php
    interface UserStore {
        function store($email, $pw);
        function checkLoginData($email, $pw);
        function isLoggedIn($email);
        function emailExists($username);
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
        function newComment($auth,$new,$post_id);
        function updateComment($id,$comm_id, $new);
        function newPost($auth,$title,$desc,$anony,$image);
        function updatePost($id,$title,$desc,$anony,$image);
        function deletePost($id);
        function deleteUser($email);
    }
    ?>