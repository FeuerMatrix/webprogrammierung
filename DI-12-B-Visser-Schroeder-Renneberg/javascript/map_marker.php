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