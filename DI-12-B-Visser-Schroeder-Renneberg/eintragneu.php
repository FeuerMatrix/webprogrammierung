<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <style>

    </style>

    <main>

        <h1 class="center">Neuer Eintrag</h1>

        <form>
            <div class="reg">
                <label for="fname">Titel</label> <br>
                <input type="text" id="fname" name="fname" placeholder="Titel" required autofocus><br>
                <label for="text_main">Text</label> <br>
                <textarea name="textinput" id="text_main" cols="30" rows="10" placeholder="Beschreibung hier einfügen" required></textarea><br>
                <label for="files">Bilder auswählen</label>
                <input type="file" id="files" name="files" accept="image/png, image/jpeg">
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