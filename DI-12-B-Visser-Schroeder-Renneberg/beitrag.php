<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/beitrag.css" >
</head>

<body>

    <?php include_once "php/nav.php" ?>

    <main>
        
        <div class = post>
            <div class="post-text">
                <h1 class = left>Eintrag</h1>
                <div class = titlebox>
                    <h2>Titel</h2>
                    <h2>Author</h2>
                    <h2>Datum</h2>
                </div>
                <p class = center>Ort (OpenStreetMap API)</p>
                <p class = center>Beispieltext </p>
                <input type="submit" value="Bearbeiten" class = "edit center">
            </div>
            <div class = post-pic>
                <img src="images/guestbook.png" alt="Gästebuch">
            </div>
        </div>

        <h3>Kommentare</h3>
        <form>
            <label for="neuerKommentar">Neues Kommentar (drücke Enter zum Bestätigen):</label> <br>
            <input type="text" id="neuerKommentar" placeholder="Neues Kommentar" required>
        </form>
        <div class = commentbox>
            <p>Name</p>
            <p>Kommentar</p>
            <input type="submit" value="Bearbeiten" class=edit>
        </div>
        <div class = commentbox>
            <p>Name</p>
            <p>Kommentar</p>
            <input type="submit" value="Bearbeiten" class=edit>
        </div>
        <div class = commentbox>
            <p>Name</p>
            <p>Kommentar</p>
            <input type="submit" value="Bearbeiten" class=edit>
        </div>
        <div class = commentbox>
            <p>Name</p>
            <p>Kommentar</p>
            <input type="submit" value="Bearbeiten" class=edit>
        </div>

    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>