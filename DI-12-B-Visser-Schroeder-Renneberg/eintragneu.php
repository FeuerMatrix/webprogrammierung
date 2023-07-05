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
                <h1><?php if (!isset($_GET["from"])) {
                        echo "Neuer Eintrag";
                    } else {
                        echo "Eintrag Editieren";
                    }

                    ?></h1>
                <label for="fname">Titel</label> <br>
                <input type="text" id="fname" name="fname" <?php if (isset($_GET["from"])) {
                                                                echo "value=" . $titelold;
                                                            } ?> placeholder="Titel" required autofocus><br>
                <label for="text_main">Text</label> <br>
                <textarea id="text_main" name="text_main" cols="30" rows="10" placeholder="Beschreibung hier einfügen" required> <?php if (isset($_GET["from"])) {
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
                <input type="checkbox" id="anonym" name="anonym" value="Anonym" <?php if (isset($_GET["from"]) && $anonyold) {
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

<script>
    var map = L.map('map').setView([50.987059, 10.412173], 5);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker;

    function onMapClick(e) {
        document.getElementById("lat").value=e.latlng.lat;
        document.getElementById("lng").value=e.latlng.lng;
        if (marker == null) {
            addMarker(e.latlng.lat, e.latlng.lng);
        } else {
            marker.setLatLng(e.latlng);
        }
    }

    map.on('click', onMapClick);

    function onClick() {
        map.removeLayer(marker);
        marker=null;
        document.getElementById("lat").value="";
        document.getElementById("lng").value="";
    }

    function addMarker(lat ,lng) {
        marker = L.marker([lat,lng], {
                draggable: true
            }).addTo(map).on('click',onClick).on('dragend', dragEnd);
    }

    function dragEnd(e){
        document.getElementById("lat").value=marker._latlng.lat;
        document.getElementById("lng").value=marker._latlng.lng;
    }

    var lat = <?php Print($lat); ?>;
    var lng = <?php Print($lng); ?>;


    if(lat!='.'&&lng!='.'){
        addMarker(lat,lng);
        document.getElementById("lat").value=lat;
        document.getElementById("lng").value=lng;
    }
  
</script>