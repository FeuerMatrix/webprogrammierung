<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/hauptseite.css" >
</head>

<?php include_once "php/controller_hauptseite.php" ?>

<body>
    <?php include_once "php/nav.php" ?>

    <main>
        <div class="top">
            <h1>Beiträge</h1>
            <form> 
                <label for="suche">Suche</label> <br>
                <input type="search" name="suche" placeholder="Hier Suchbegriff eingeben" id="suche"> <br>
                <label for="sort">Sortieren nach:</label> <br>
                <select id="sort" name="sort">
                    <option value="date">Datum</option>
                    <option value="titel">Alphabetisch</option>
                </select> <br>
                <input type="submit" value="Auswahl bestätigen">
            </form>
        </div>

        <div class="flex-container">
                <?php foreach ($beitraege as $beitrag): ?>         
                       <div class="beitrag">
                            <a class="link" href=<?php echo "\"beitrag.php?id=".urlencode($beitrag["id"])."\"" ?> > <?php echo $beitrag['titel'] ?></a>
                            <span> <?php echo $beitrag['date'] ?></span>
                            <img src=<?php echo $beitrag['file'] ?>  alt= <?php echo $beitrag['pname'] ?> >
                        </div>
                <?php endforeach ?>
        </div>

    </main>
    
    <?php include_once "php/footer.php" ?>
</body>

</html>