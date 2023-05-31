<?php
    interface UserStore {
        function store($user, $email, $pw);
        function checkLoginData($email, $pw);
        function isLoggedIn($email);
    }

    class DummyUserStore implements UserStore {
        function store($user, $email, $pw){

        }
        function checkLoginData($email, $pw){

        }
        function isLoggedIn($email){
            return false;
        }
    }
?>