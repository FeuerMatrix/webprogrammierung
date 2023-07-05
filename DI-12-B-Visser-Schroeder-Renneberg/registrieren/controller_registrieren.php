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
    if (!isset($_POST["accept1"])) {
        $errorMessage = "Akzeptiere die Nutzerbedingungen";
    }
    if (!isset($_POST["accept2"])) {
        $errorMessage = "Akzeptiere die Datenschutzbedingungen";
    }

    
    include_once $path."/datenbank/salt.php"; 
    include_once "datenbank/SQLiteStore.php";

    // Ersetze den Teil des Pfades bis zu htdocs mit http://localhost
    $changeOn = strpos($path, 'htdocs') + 6;
    $url = 'http://localhost'.substr($path, $changeOn);
    $url = str_replace('\\', '/', $url);

    $database = new SQLiteStore();
    $database->beginTransaction();
    $token = crypt($email, $salt);
    if($database->emailExists($email)) {
        $emailLog = fopen("email.txt", "w");
        $linkPWResset = $url."/pwReset.php?token=".$token;
        fwrite($emailLog,  "Bitte ignoriere die E-Mail, wenn du es nicht warst, \nder sich versucht hat zu registrieren. \nDu bist aber bereits registriert. \nSolltest du dein Password vergessen haben, klicke auf folgenden Link. \n$linkPWResset");
        fclose($emailLog);
        $database->endTransaction();
        header("Location: registrierenFertig.php");
    } else {
        if(!isset($errorMessage)) {
            $database->store($email, $passw);
            $emailLog = fopen("email.txt", "w");
            $linkRegestrierung = $url."/confirmEmail.php?token=".$token;
            fwrite($emailLog,  "Bitte ignoriere die E-Mail, wenn du es nicht warst, \nder sich versucht hat zu registrieren. \nAnsonsten klicke innerhalb von 24h auf den folgenden Link, um die Registrierung abzuschliessen: \n$linkRegestrierung");
            fclose($emailLog);
            $database->endTransaction();
            header("Location: registrierenFertig.php");
            exit;
        } else {
            $database->endTransaction();
            header("Location: registrieren.php?cause=".urlencode($errorMessage)."&email=".$email."&email2=".$email2);
            exit;
        }
    }
}

$email1set = isset($_GET["email"]);
if ($email1set) {
    $email1 = $_GET["email"];
}
$email2set = isset($_GET["email2"]);
if ($email2set) {
    $email2 = $_GET["email2"];
}
?>
