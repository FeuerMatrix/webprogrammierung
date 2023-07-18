<?php 
function generateCSRFToken(){
    if (!isset($_SESSION['CSRF'])) {
        $_SESSION['CSRF'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['CSRF'];
}
function validCSRF($post){
    return isset($post["token"]) && $_SESSION['CSRF'] == $post["token"];
}
?>