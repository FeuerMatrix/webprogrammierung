if (document.getElementById('img') != null) {
    document.getElementById('img').onclick = function() {
        var element = document.getElementById("img");
        element.classList.toggle("image");
    }
}