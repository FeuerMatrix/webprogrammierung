<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/beitrag.css" >
</head>

<body>

    <?php include_once "php/nav.php" ?>

    <?php
        $id = (isset($_GET["id"]) && is_string($_GET["id"])) ? $_GET["id"] : "";

        //TODO get from DB
        $titel = "Testtitel";
        $desc = "Testdesc";
        $author = "Ich";
        $date ="1.1.1970";
        $img = "images/guestbook.png";
        $comm_auth = array("Der","Die","Das");
        $comm_text = array("grfaghaergherreag","harhngrjrtahgrfsjhtr","htrshtgbgsfhjtrsh");
    ?>

    <main>
        
        <div class = post>
            <div class="post-text">
                <h1 class = left><?php echo $titel?></h1>
                <div class = titlebox>
                    <h2><?php echo $author ?></h2>
                    <h2><?php echo $date ?></h2>
                </div>
                <p class = center>Ort (OpenStreetMap API)</p>
                <p class = center><?php echo $desc ?> </p>
                <input type="submit" value="Bearbeiten" class = "edit center">
            </div>
            <div class = post-pic>
                <img src=<?php echo $img ?> alt="Gästebuch">
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