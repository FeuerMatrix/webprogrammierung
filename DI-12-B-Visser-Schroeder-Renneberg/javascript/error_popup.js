const s = new URLSearchParams(location.search).get("cause");
if (s != null) {
    document.getElementById("errorbox").innerHTML = s;
    setTimeout((() => {
      document.getElementById("errorbox").innerHTML = "";
      document.getElementById("errorpopup").className = "";
    }), 3000)
}