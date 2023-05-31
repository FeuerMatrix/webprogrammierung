<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/beitrag.css">
</head>

<body>


    <?php include_once "php/nav.php" ?>
    <?php include_once "php/beitrag.php" ?>



    <main>
        <div class=post>
            <div class="post-text">
                <h1 class=left><?php echo $titel ?></h1>
                <div class=titlebox>
                    <h2><?php echo $author ?></h2>
                    <h2><?php echo $date ?></h2>
                </div>
                <p class=center>Ort (OpenStreetMap API)</p>
                <p class=center><?php echo $desc ?> </p>
                <form method="post">
                    <input type="submit" name="Submit" value="Bearbeiten" class="edit">
                </form>
            </div>
            <div class=post-pic>
                <img src=<?php echo $img ?> alt="Gästebuch">
            </div>
        </div>

        <h3>Kommentare</h3>
        <form method="post">
            <label for="neuerKommentar">Neues Kommentar (drücke Enter zum Bestätigen):</label> <br>
            <input type="text" id="neuerKommentar" name="new" <?php if ($edit) {
                                                                    echo 'value='.$old;
                                                                } ?> placeholder="Neues Kommentar" required>
        </form>


        <?php
        foreach ($comments as $comm) {
            createComment($comm[0], $comm[1], $comm[2]);
        }
        ?>
    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>