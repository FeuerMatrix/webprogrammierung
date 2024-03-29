
<?php
    include_once "../../path.php";
    include_once $path."php/registrieren/controller_registrieren.php";
    include_once $path."php/head.php"
    ?>

<link rel="stylesheet" href="<?=$hpath?>css/registrieren.css">
</head>

<body>

    <?php include_once $path."php/nav.php"; ?>
    <main>
        <form method="POST">
            <input type="hidden" name="token" value="<?=generateCSRFToken()?>">
            <div class="reg1">
                <h1 class="col10">Registrieren</h1>
                <div class="bottom"><p class="col20">Fülle alle Daten aus, um dich zu Registrieren</p> </div>
                <label class="col12" for="email">Email</label><br>
                <input class="col22" type="email" id="email" name="email" placeholder="Email" <?php if($email1set):?> value=<?php echo $email1; endif; ?> required <?php if(!$email1set):?>autofocus <?php endif; ?>><br>
                <label class="col13" for="email2">Email bestätigen</label><br>
                <input class="col23" type="email" id="email2" name="email2" placeholder="Email bestätigen" <?php if($email2set):?> value=<?php echo $email2; endif; ?> required><br>
                <label class="col14" for="passw">Passwort</label><br>
                <input class="col24" type="password" id="passw" name="passw" placeholder="Passwort" required <?php if($email1set):?>autofocus <?php endif; ?>><br>
                <label class="col15" for="passw2">Passwort bestätigen</label><br>
                <input class="col25" type="password" id="passw2" name="passw2" placeholder="Passwort bestätigen" required><br>
                <label class="col17" for="accept1">Ich akzeptiere die &nbsp; <a href="<?=$hpath?>php/nutzungsbedingungen.php">Nutzungsbedingungen</a></label>
                <input class="col27" type="checkbox" id="accept1" name="accept1" value="Nutzungsbedingungen" required>
                <label class="col18" for="accept2">Ich akzeptiere die &nbsp; <a href="<?=$hpath?>php/datenschutz.php">Datenschutzbedingungen</a></label>
                <input class="col28" type="checkbox" id="accept2" name="accept2" value="Datenschutzbedingungen" required>
                <input class="col16" type="submit" value="Erstellen">
                <input class="col26" type="submit" form="form" value="Abbrechen"><br>
            </div>
        </form>
    </main>
    <form action="<?=$hpath?>index.php" id="form"></form>
    <?php include_once $path."php/footer.php" ?>
</body>

</html>