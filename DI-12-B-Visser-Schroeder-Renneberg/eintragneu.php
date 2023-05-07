<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <form>
            <div class="reg">
                <h1>Neuer Eintrag</h1>
                <label for="fname">Titel</label> <br>
                <input type="text" id="fname" name="fname" placeholder="Titel" required autofocus><br>
                <label for="text_main">Text</label> <br>
                <textarea name="textinput" id="text_main" cols="30" rows="10" placeholder="Beschreibung hier einfügen" required></textarea><br>
                <label for="files">Bilder auswählen</label><br>
                <input type="file" id="files" name="files" accept="image/png, image/jpeg"><br>
                <label for="pname">Bild Beschreibung</label> <br>
                <input type="text" id="pname" name="pname" placeholder="Bild Beschreibung"><br>
                <label for="anonym">Anonym</label>
                <input type="checkbox" id="anonym" name="anonym" value="Anonym"><br>
                <input type="submit" class="create" value="Erstellen">
                <input type="submit" class="cancel" value="Abbrechen">
            </div>
        </form>
        
    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>