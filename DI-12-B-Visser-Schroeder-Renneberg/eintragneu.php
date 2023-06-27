<?php include_once "php/controller_beitragErstellen.php" ?>
<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/eintragneu.css">
</head>

<body>

    <?php include_once "php/nav.php" ?>

    

    <?php include_once "javascript/load_image.php" ?>

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
                <input type="text" id="fname" name="fname" <?php if (isset($_GET["from"])) {
                                                                echo "value=" . $titelold;
                                                            } ?> placeholder="Titel" required autofocus><br>
                <label for="text_main">Text</label> <br>
                <textarea id="text_main" name="text_main" cols="30" rows="10" placeholder="Beschreibung hier einfügen" required> <?php if (isset($_GET["from"])) {
                                                                                                                                        echo $descold;
                                                                                                                                    } ?> </textarea><br>
                <label for="Datei">Bilder auswählen</label><br>
                <div class="input-div">
                    <p>Photos hier Drag und dropen oder <strong>Browse</strong></p>
                    <input type="file" id="Datei" name="Datei" class="file" accept="image/jpeg, image/png, image/jpg" onchange="loadFile(event)">
                </div>
                <img id="output"/>
                <label for="anonym">Anonym</label>
                <input type="checkbox" id="anonym" name="anonym" value="Anonym" <?php if (isset($_GET["from"]) && $anonyold) {
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