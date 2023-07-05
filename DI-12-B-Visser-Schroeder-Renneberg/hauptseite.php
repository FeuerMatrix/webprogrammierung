<?php include_once "php/controller_hauptseite.php" ?>
<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/hauptseite.css">

</head>

<body>
    <?php include_once "php/nav.php" ?>

    <main>
        <div class="top">
            <h1>Beiträge</h1>
            <form>
                <label for="suche">Suche</label> <br>
                <input id="suche" type="search" name="suche" placeholder="Hier Suchbegriff eingeben"> <br>
                <label for="sort">Sortieren nach:</label> <br>
                <select id="sort" name="sort">
                    <option value="date">Datum</option>
                    <option value="titel">Alphabetisch</option>
                </select> <br>
            </form>
        </div>

        <div class="flex-container">
            <?php foreach ($beitraege as $beitrag) : ?>
                <div class="beitrag">
                    <a class="link" href="beitrag.php?id=<?php echo urlencode($beitrag["id"]) ?>"> <?php echo $beitrag['titel'] ?></a>
                    <span> <?php echo date("Y-m-d H:i:s", $beitrag['date']); ?></span>
                    <?php
                    if ($beitrag['file'] != "") {
                    ?>
                        <img src=<?php echo $beitrag['file'] ?> alt=<?php echo $beitrag['pname'] ?>>
                    <?php
                    }
                    ?>
                </div>
            <?php endforeach ?>
        </div>

    </main>

    <?php include_once "php/footer.php" ?>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
    <script src="javascript/fetch_beitraege.js"></script>
</body>

</html>



