<?php
    include_once "../../path.php";
    include_once $path."php/csrf.php";
    include_once $path."php/beitragErstellen/controller_beitragErstellen.php";
    include_once $path."php/head.php";
?>
<link rel="stylesheet" href="<?=$hpath?>css/eintragneu.css">
<?php
if ($accept_map) {
?>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="">
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<?php
}
?>
</head>

<body>

    <?php include_once $path."php/nav.php" ?>



    <script src="<?=$hpath?>javascript/load_image.js"></script>

    <main>
        <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="token" value="<?=generateCSRFToken()?>">
            <div class="reg">
                <h1><?php if (!$redirected) {
                        echo "Neuer Eintrag";
                    } else {
                        echo "Eintrag Editieren";
                    }

                    ?></h1>
                <label for="fname">Titel</label> <br>
                <input type="text" id="fname" name="fname" <?php if ($redirected) {
                                                                echo "value=" . $titelold;
                                                            } ?> placeholder="Titel" required autofocus><br>
                <label for="text_main">Text</label> <br>
                <textarea id="text_main" name="text_main" cols="30" rows="10" placeholder="Beschreibung hier einfügen" required><?php if ($redirected) {
                                                                                                                                    echo $descold;
                                                                                                                                } ?></textarea><br>
                <?php
                if ($accept_map) {
                ?>
                    <div id="map"></div>
                <?php
                } else {
                ?>
                    <p>Akzeptiere die Verwendung von OpenStreetMap, um die Position auszuwählen</p>
                    <a class="link" href="<?=$hpath?>php/drittAnbieter/drittAnbieter.php"> OpenStreetMap Datenschutz </a>
                <?php
                }
                ?>
                <label for="Datei">Bilder auswählen</label><br>
                <div class="input-div">
                    <p>Fotos hier hineinziehen oder <strong>PC durchsuchen</strong></p>
                    <input type="file" id="Datei" name="Datei" class="file" accept="image/jpeg, image/png, image/jpg" onchange="loadFile(event)">
                </div>
                <img id="output" src="." alt="Bild">
                <label for="anonym">Anonym</label>
                <input type="checkbox" id="anonym" name="anonym" value="Anonym" <?php if ($redirected && $anonyold) {
                                                                                    echo 'checked="checked"';
                                                                                } ?>><br>
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lng" id="lng">
                <input type="submit" name="Submit" class="create" value="Erstellen">
                <input type="submit" form="form" class="cancel" value="Abbrechen">
            </div>
        </form>

        <form action=<?php echo $url ?> id="form" method="get">
            <?php if($redirected): ?><input type="hidden" name="id" id="id" value="<?=$id?>"><?php endif;?>
        </form>
    </main>
    <?php include_once $path."php/footer.php" ?>
    <?php if ($accept_map) {
    include $path."javascript/map_marker.php";
} ?>
</body>

</html>

