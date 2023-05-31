<?php include_once "php/head.php" ?>
</head>

<body>

    <?php include_once "php/nav.php" ?>
    <?php include_once "php/controller_beitragErstellen.php" ?>

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
                <input type="submit" form="form" name="Cancel" class="cancel" value="Abbrechen" >
            </div>
        </form>

        <form action=<?php echo $url ?> id="form"></form>
    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>