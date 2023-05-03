<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <h1>Neuer Eintrag</h1>

        <form>
            <fieldset>
                <label for="fname">Titel</label> <br>
                <input type="text" id="fname" name="fname" placeholder="Titel" required autofocus><br>
                <label for="text_main">Text</label> <br>
                <textarea name="textinput" id="text_main" cols="30" rows="10" required></textarea><br>
                <label for="files">Bilder auswählen</label>
                <input type="file" id="files" name="files" accept="image/png, image/jpeg">
            </fieldset>
            <fieldset>
                <label for="anonym">Anonym</label>
                <input type="checkbox" id="anonym" name="anonym" value="Anonym"><br>
                <input type="submit" value="Abbrechen">
                <input type="submit" value="Erstellen">
            </fieldset>
        </form>


    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>