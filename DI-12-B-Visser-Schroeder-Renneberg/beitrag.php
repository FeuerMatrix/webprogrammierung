<?php include_once "php/controller_beitrag.php" ?>
<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/beitrag.css">

</head>

<body>

    <?php include_once "php/nav.php" ?>
    <?php
    if (isset($_SESSION["user"])) {
    ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <?php
    }
    ?>

    <main>
        <div class=post>
            <div class="post-text">
                <h1 class=left><?php echo $titel ?></h1>
                <div class=titlebox>
                    <h2><?php if (!$anony) {
                            echo $author;
                        } ?></h2>
                    <h2><?php echo $date ?></h2>
                </div>
                <?php
                if (isset($_SESSION["user"])) {
                ?>
                    <div id="map"></div>
                <?php
                } else if($lat!="'.'"){
                    ?>
                    <p>Melde dich an um die Karte zu sehen</p>
                    <?php
                }
                ?>
                <p class=center><?php echo $desc ?> </p>
                <?php if (isset($_SESSION["user"]) && $_SESSION["user"] == $database->getAuthor($id)) : ?>
                    <form method="post">
                        <input type="submit" name="Submit" value="Bearbeiten" class="edit">
                        <input class="delete" type="submit" name="delete" value="Löschen">
                    </form>
                <?php endif; ?>
            </div>
            <div class=post-pic>
                <?php
                if ($img != "") {
                ?>
                    <div id="img">
                        <h3>Clicke um zu vergrössern/ verkleinern</h3>
                        <img class="im" src=<?php echo $img ?> alt=<?php echo $img ?>>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>

        <h3>Kommentare</h3>
        <?php if (isset($_SESSION["user"])) : ?>
            <form method="post">
                <label for="neuerKommentar">Neues Kommentar (drücke Enter zum Bestätigen):</label> <br>
                <input type="text" id="neuerKommentar" name="new" <?php if (isset($_GET["old"])) {
                                                                        echo 'value=' . $_GET["old"];
                                                                    } ?> placeholder="Neues Kommentar" required>
            </form>
        <?php endif; ?>

        <?php
        foreach ($comments as $comm) {
            createComment($comm[0], $comm[1], $comm[2]);
        }
        ?>
    </main>

    <?php include_once "php/footer.php" ?>
    <script src="javascript/imagepopup.js"></script>
</body>

</html>


<script>
    <?php
    if (isset($_SESSION["user"])) {
    ?>
        var lat = <?php print($lat); ?>;
        var lng = <?php print($lng); ?>;
        if (lat != '.' && lng != '.') {
            var map = L.map('map').setView([lat, lng], 13);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);
            var marker = L.marker([lat, lng]).addTo(map);
        } else {
            document.getElementById("map").remove();
        }
    <?php
    }
    ?>
</script>