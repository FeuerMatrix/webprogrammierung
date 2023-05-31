<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/beitrag.css" >
</head>

<body>

    <?php include_once "php/nav.php" ?>

    <?php
     if(isset($_POST["Submit"])){
        $_SESSION;
        header("Location: eintragneu.php?from=Beitrag");
        }
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
        
        <div class = post >
            <div class="post-text">
                <h1 class = left><?php echo $titel?></h1>
                <div class = titlebox>
                    <h2><?php echo $author ?></h2>
                    <h2><?php echo $date ?></h2>
                </div>
                <p class = center>Ort (OpenStreetMap API)</p>
                <p class = center><?php echo $desc ?> </p>
                <form method="post">
                <input type="submit" name="Submit" value="Bearbeiten" class = "edit">
                </form>
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
    <?php
        function createComment($name, $text){
            ?>
            <div class = commentbox>
            <p><?php echo $name ?></p>
            <p><?php echo $text ?></p>
            <input type="submit" name="Submit" value="Bearbeiten" class=edit>
        </div>
        <?php
        }

        for($i = 0; $i < count($comm_auth); $i++){
            createComment($comm_auth[$i],$comm_text[$i]);
        }
        ?>
    </main>

    <?php include_once "php/footer.php" ?>
</body>

</html>