<?php
    include_once "path.php";
    include_once $path."/anmeldung/controller_anmeldung.php";
    include_once "php/head.php";
?>
</head>

<body>
    <?php include_once $path."/php/nav.php"; ?>
    <main>

    <form method="post">
        <div class="reg">
        <h1>Anmelden</h1>
            <label for="email">Email</label> <br>
            <input type="email" id="email" name="email" placeholder="Email" <?php if(isset($_POST["email"])):?> value=<?php echo $_POST["email"]; endif; ?> required <?php if(!isset($_POST["email"])):?>autofocus <?php endif; ?>> <br>
            <label for="pw">Passwort</label> <br>
            <input type="password" id="pw" name=pw placeholder="Passwort" required <?php if(isset($_POST["email"])):?>autofocus <?php endif; ?>>
            <input type="submit" class="create" value="Anmelden">
            <input type="submit" form="form" class="cancel" value="Abbrechen">

            <?php if(isset($errorMessage)): ?> <!--Displays Messages for errors as well as successful registration, where the former has higher priority-->
                <a><?=$errorMessage?></a>
            <?php elseif(isset($_GET["from"])): ?> <!-- uses $_GET since get params can be directly put in with header()-->
                <a>Erfolgreich <?=($_GET["from"] == "registration" ? "Registriert" : "Abgemeldet")?>!</a>
            <?php endif; ?>
        </div>
        </form>
        <form action="index.php" id="form"></form>
    </main>

    <?php include_once $path."/php/footer.php" ?>
</body>

</html>