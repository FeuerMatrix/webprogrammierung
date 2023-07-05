<?php include_once "php/controller_beitragErstellen.php" ?>
<?php include_once "php/head.php" ?>
<link rel="stylesheet" href="css/eintragneu.css">
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
</head>

<body>

    <?php include_once "php/nav.php" ?>



    <script src="javascript/load_image.js"></script>

    <main>
        <form method="post" enctype="multipart/form-data">
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
                <textarea id="text_main" name="text_main" cols="30" rows="10" placeholder="Beschreibung hier einfügen" required> <?php if ($redirected) {
                                                                                                                                        echo $descold;
                                                                                                                                    } ?> </textarea><br>
                <div id="map"></div>
                <label for="Datei">Bilder auswählen</label><br>
                <div class="input-div">
                    <p>Photos hier Drag und dropen oder <strong>Browse</strong></p>
                    <input type="file" id="Datei" name="Datei" class="file" accept="image/jpeg, image/png, image/jpg" onchange="loadFile(event)">
                </div>
                <img id="output"/>
                <label for="anonym">Anonym</label>
                <input type="checkbox" id="anonym" name="anonym" value="Anonym" <?php if ($redirected && $anonyold) {
                                                                                    echo 'checked="checked"';
                                                                                } ?>><br>
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lng" id="lng">
                <input type="submit" name="Submit" class="create" value="Erstellen">
                <input type="submit" form="form" name="Cancel" class="cancel" value="Abbrechen">
            </div>
        </form>

        <form action=<?php echo $url ?> id="form"></form>
    </main>
    <?php include_once "php/footer.php" ?>
</body>

</html>

<?php include "javascript/map_marker.php"?>