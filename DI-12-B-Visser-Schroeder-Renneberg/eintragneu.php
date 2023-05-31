<?php include_once "php/head.php" ?>
</head>

<body>

    <?php include_once "php/nav.php" ?>
    <?php include_once "php/controller_beitragErstellen.php" ?>

    <?php

    include_once "datenbank/DummyUserStore.php";
    $database = new DummyUserStore();


    if (isset($_POST["Cancel"])) {
    }

    if (!isset($_GET["from"])) {
        $url = "hauptseite.php";
    } else {
        $url = "beitrag.php?id=" . $_GET["from"];
    }

    if (!isset($_SESSION["user"])) { //Prevents the user from accessing this page through direct links while not logged in
        header("Location: index.php?cause=" . urlencode("Fehler: diese Seite kann nur von eingeloggten Nutzern aufgerufen werden!"));
        exit;
    }
    $edit = false;

    if (isset($_SESSION["id"]) && isset($_GET["from"])) {
        if ((is_string($_SESSION["id"])) ? $_SESSION["id"] : "") {
            $id = $_SESSION["id"];
            unset($_SESSION["id"]);
            $edit = true;

            $titel = $database->getTitel($id);
            $desc =  $database->getDesc($id);
            $anony = $database->getAnonym($id);
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
                <h1><?php if (!isset($_GET["from"])) {
                        echo "Neuer Eintrag";
                    } else {
                        echo "Eintrag Editieren";
                    }


                    ?></h1>
                <label for="fname">Titel</label> <br>
                <input type="text" id="fname" name="fname" <?php if ($edit) {
                                                                echo "value=" . $titel;
                                                            } ?> placeholder="Titel" required autofocus><br>
                <label for="text_main">Text</label> <br>
                <textarea id="text_main" name="text_main" cols="30" rows="10" placeholder="Beschreibung hier einfügen" required> <?php if ($edit) {
                                                                                                                                        echo $desc;
                                                                                                                                    } ?> </textarea><br>
                <label for="Datei">Bilder auswählen</label><br>
                <input type="file" id="Datei" name="Datei" accept="image/png, image/jpeg"><br>
                <label for="anonym">Anonym</label>
                <input type="checkbox" id="anonym" name="anonym" value="Anonym" <?php if ($edit && $anony) {
                                                                                    echo 'checked="checked"';
                                                                                } ?>><br>
                <input type="submit" name="Submit" class="create" value="Erstellen">
                <input type="submit" form="form" name="Cancel" class="cancel" value="Abbrechen">
            </div>
        </form>

        <form action=<?php echo $url ?> id="form"></form>
    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>