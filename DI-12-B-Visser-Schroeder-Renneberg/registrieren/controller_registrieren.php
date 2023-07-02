<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
if (isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while logged in
    header("Location: index.php?cause=" . urlencode("Fehler: diese Seite kann nicht von eingeloggten Nutzern aufgerufen werden!"));
    exit;
}

if (isset($_POST["passw"], $_POST["passw2"], $_POST["email"], $_POST["email2"])) {
    unset($errorMessage);
    foreach ($_POST as $postKey => $postElement) {
        $$postKey = $_POST[$postKey];
    }

    if ($email != $email2) {
        $errorMessage = "Email-Addressen stimmen nicht überein!";
    }

    if ($passw != $passw2) {
        $errorMessage = "Passwörter stimmen nicht überein!";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errorMessage = "Fehlerhafte Email-Addresse!";
    }
    if (!$_POST["accept"]) {
        $errorMessage = "Akzeptiere die Nutzerbedingungen";
    }

    include_once "datenbank/SQLiteStore.php";
    $database = new SQLiteStore();
    $database->beginTransaction();
    if ($database->emailExists($email)) {
        $errorMessage = "Fehler!";
    }

    if (!isset($errorMessage)) {
        $database->store($email, $passw);
        $database->endTransaction();
        header("Location: anmeldung.php?from=registration");
        exit;
    } else {
        $database->endTransaction();
        header("Location: registrieren.php?cause=" . urlencode($errorMessage) . "&email=" . $email . "&email2=" . $email2);
        exit;
    }
}
