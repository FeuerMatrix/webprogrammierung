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
    }
?>