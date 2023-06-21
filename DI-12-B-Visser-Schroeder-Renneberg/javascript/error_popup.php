<script>
  const s = new URLSearchParams(location.search).get("cause");
    if (s != null) {
        alert(s);
    }
</script>