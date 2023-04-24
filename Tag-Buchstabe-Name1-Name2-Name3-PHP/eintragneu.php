<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <h1>Neuer Eintrag</h1>

        <form>
            <fieldset>
                <input type="titel" id="fname" name="fname" placeholder="Titel"><br>
                <textarea name="" id="" cols="30" rows="10"></textarea><br>
                <label for="file">Bilder auswählen</label>
                <input type="file" id="files" name="files" accept="image/png, image/jpeg">
            </fieldset>
            <fieldset>
                <label for="anonym">Anonym</label>
                <input type="checkbox" id="anomnym" name="anomnym" value="Anonym"><br>
                <input type="submit" value="Abbrechen">
                <input type="submit" value="Erstellen">
            </fieldset>
        </form>


    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>