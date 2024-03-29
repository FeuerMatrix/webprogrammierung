<?php
include_once "../../path.php";
include_once $path . "/php/csrf.php";
include_once $path . "php/beitrag/controller_beitrag.php";
include_once $path . "/php/head.php";
?>
<link rel="stylesheet" href="<?= $hpath ?>css/beitrag.css">

</head>

<body>

    <?php include_once $path . "php/nav.php" ?>
    <?php
    if ($accept_map) {
    ?>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
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
                if ($accept_map) {
                ?>
                    <div id="map"></div>
                <?php
                } else if ($lat != "'.'") {
                ?>
                    <p>Akzeptiere die Verwendung von OpenStreetMap, um unten auf der Website um die Karte zu sehen</p>
                    <a class="link" href="<?= $hpath ?>php/drittAnbieter/drittAnbieter.php"> OpenStreetMap Datenschutz</a>
                <?php
                }
                ?>
                <p class=center><?php echo $desc ?> </p>
                <?php if ($auth && $isAuthor) : ?>
                    <form method="post">
                        <input type="submit" name="Submit" value="Bearbeiten" class="edit">
                        <input class="delete" type="submit" name="delete" value="Löschen">
                        <input type="hidden" name="token" value="<?= generateCSRFToken() ?>">
                    </form>
                <?php endif; ?>
            </div>
            <div class=post-pic>
                <?php
                if ($hasImg) {
                ?>
                    <div id="img">
                        <h3>Klicke um zu vergrößern</h3>
                        <img class="im" id="myImg" src=<?php echo $img ?> alt=<?php echo $img ?>>
                    </div>
                    <div id="myModal" class="modal">
                        <span class="close">&times;</span>
                        <img class="modal-content" id="img01" alt="" src=".">
                    </div>

                <?php
                }
                ?>
            </div>
        </div>

        <h3>Kommentare</h3>
        <?php if ($auth) : ?>
            <form method="post">
                <label for="neuerKommentar">Neues Kommentar (drücke Enter zum Bestätigen):</label> <br>
                <input type="text" id="neuerKommentar" name="new" <?php if ($modifiesOld) { ?> value='<?php echo $oldComment; ?>' <?php } ?> placeholder="Neues Kommentar" required>
                <input type="hidden" name="token" value="<?= generateCSRFToken() ?>">
            </form>
        <?php endif; ?>

        <?php
        foreach ($comments as $comm) {
            createComment($comm[0], $comm[1], $comm[2]);
        }
        ?>
    </main>

    <?php include_once $path . "php/footer.php" ?>
    <script src="<?= $hpath ?>javascript/imagepopup.js"></script>
    <script>
    <?php
    if ($accept_map) {
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
</body>

</html>


