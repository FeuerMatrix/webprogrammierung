<?php 
function generateCSRFToken(){
    if (!isset($_SESSION['CSRF'])) {
        $_SESSION['CSRF'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['CSRF'];
}
function validCSRF($post){ //in order to not need to check isset for the token every time in addition to checking validity, the entire $_POST array is given to validCSRF and both checks are handled in here
    return isset($post["token"]) && $_SESSION['CSRF'] == $post["token"];
}
?>