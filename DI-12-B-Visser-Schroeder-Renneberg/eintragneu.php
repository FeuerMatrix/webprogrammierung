<?php include_once "php/head.php" ?>
</head>

<body>

    <?php include_once "php/nav.php" ?>
    <?php include_once "php/beitragErstellen.php" ?>

    <?php
    if (!isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while not logged in
        header("Location: index.php?cause=" . urlencode("Fehler: diese Seite kann nur von eingeloggten Nutzern aufgerufen werden!"));
        exit;
    }
    $edit = false;

    if (isset($_SESSION["id"]) && isset($_GET["from"])) {
        if ($_GET["from"] == "Beitrag" && (is_string($_SESSION["id"])) ? $_SESSION["id"] : "") {
            $id = $_SESSION["id"];
            unset($_SESSION["id"]);
            $edit = true;

            //TODO get from DB
            $titel = " gegr";
            $desc =  " grfemglerfgj erfiujg";
            $anony = false;
            if (!isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while not logged in
                header("Location: index.php?cause=" . urlencode("Fehler: diese Seite kann nur von eingeloggten Nutzern aufgerufen werden!"));
                exit;
            }
        }
    }
    ?>
    <main>

        <form method="post" enctype="multipart/form-data">
            <div class="reg">
                <h1>Neuer Eintrag</h1>
                <label for="fname">Titel</label> <br>
                <input type="text" name="fname" <?php if ($edit) {
                                                    echo "value=" . $titel;
                                                } ?> placeholder="Titel" required autofocus><br>
                <label for="text_main">Text</label> <br>
                <textarea name="text_main" cols="30" rows="10" placeholder="Beschreibung hier einfügen" required> <?php if ($edit) {
                                                                                                                        echo $desc;
                                                                                                                    } ?> </textarea><br>
                <label for="Datei">Bilder auswählen</label><br>
                <input type="file" name="Datei" accept="image/png, image/jpeg"><br>
                <label for="anonym">Anonym</label>
                <input type="checkbox" name="anonym" value="Anonym" <?php if ($edit && $anony) {
                                                                        echo 'checked="checked"';
                                                                    } ?>><br>
                <input type="submit" name="Submit" class="create" value="Erstellen">
                <input type="submit" class="cancel" value="Abbrechen">
            </div>
        </form>

    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>