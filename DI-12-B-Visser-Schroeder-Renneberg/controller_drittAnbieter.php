<?php
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    if (isset($_POST["acc"])) {
        if (!validCSRF($_POST)) {
            header("Location: ".$hpath."index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
            exit;
        }
        
        setcookie("accept", "set", time() + (86400 * 30), "/"); // 86400 = 1 day
        header("Location: ".$hpath."hauptseite.php");
        exit;
    }

    if (isset($_POST["notacc"])) {
        if (!validCSRF($_POST)) {
            header("Location: ".$hpath."index.php?id=" . $id . "&cause=" . urlencode("Sicherheitsproblem!"));
            exit;
        }
        
        setcookie("accept", "", time() - 3600, "/");
        unset($_COOKIE["accept"]);
        header("Location: ".$hpath."hauptseite.php");
        exit;
    }

    $set = isset($_COOKIE["accept"]);
?>