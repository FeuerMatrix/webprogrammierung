<?php include_once "php/head.php" ?>

<body>

    <?php include_once "php/nav.php" ?>

    <style>
        .post {
            display: flex;
            align-items: center;
            flex-direction: row;
            width: 100%;
            background-color: rgb(255, 255, 255);
            border-radius: 25px;
        }
        .commentbox {
            border-radius: 25px;
            background-color: rgb(235, 235, 235);
            margin: 10px;
            width: 95%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .post .post-text {
            display: flex;
            flex-direction: column;
            width: 70%;
        }
        .post .post-text .left {
            align-items: flex-start;
        }
        .post .post-text .center {
            align-items: flex-start;
        }
        .post .post-pic {
            width: 30%;
        }
        .titlebox {
            display: flex;
            flex-direction: row;
        }
        .titlebox h2 {
            width: 33%;
        }
        .edit {
            border-radius: 10px;
            width: auto;
            background-color: rgb(235, 235, 235);
        }
    </style>

    <main>
        <div class = post>
            <div class="post-text">
                <h1 class = left>Eintrag</h1>
                <div class = titlebox>
                    <h2>Titel</h2>
                    <h2>Author</h4>
                    <h2>Datum</h4>
                </div>
                <p class = center>ORT</p>
                <p class = center>Beispieltext </p>
                <input type="submit" value="Bearbeiten" class = edit>
            </div class = post-pic>
            <div>
                <img src="images/guestbook.png" alt="Gästebuch">
            </div>
        </div>

        <h3>Kommentare</h3>
        <label for="neuerKomentar">Neuer Kommentar:</label> <br>
        <form>
            <input type="text" id="neuerKommentar" placeholder="Neues Kommentar" required>
            <input type="submit" value="Erstellen">
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
            <input type="submit" value="Bearbeiten"class=edit>
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