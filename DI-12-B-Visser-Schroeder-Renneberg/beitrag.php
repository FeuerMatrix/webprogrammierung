<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <main>

        <h1>Eintrag</h1>
        <h2>Titel</h2>
        <h4>Author</h4>
        <h4>Datum</h4>
        <p>ORT</p>
        <p>Beispieltext </p>
        <img src="images/guestbook.png" alt="Gästebuch">
        <input type="submit" value="Bearbeiten">


        <h3>Kommentare</h3>
        <label for="neuerKomentar">Neuer Kommentar:</label> <br>
        <form>
            <input type="text" id="neuerKommentar" placeholder="Neues Kommentar" required>
            <input type="submit" value="Erstellen">
        </form>
        <fieldset>
            <p>Name</p>
            <p>Kommentar</p>
            <input type="submit" value="Bearbeiten">
        </fieldset>
        <fieldset>
            <p>Name</p>
            <p>Kommentar</p>
            <input type="submit" value="Bearbeiten">
        </fieldset>
        <fieldset>
            <p>Name</p>
            <p>Kommentar</p>
            <input type="submit" value="Bearbeiten">
        </fieldset>
        <fieldset>
            <p>Name</p>
            <p>Kommentar</p>
            <input type="submit" value="Bearbeiten">
        </fieldset>


    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>