<link rel="stylesheet" href="css/footer.css" >

<footer>
  <ul>
    <li> <a href="impressum.php">Impressum</a>
    <li> <a href="datenschutz.php">Datenschutz</a>
    <li> <a href="nutzungsbedingungen.php">Nutzungsbedingungen</a>
    <li>
      <?php
      if (!isset($_SESSION["accept"])) :
      ?>
    <li>
      <form method="post">
        <input type="submit" name="accept"  class="navdelete" value="Cookie">
      </form>
    <?php
      endif;
    ?>

    <?php
    if (isset($_SESSION["accept"])) :
    ?>
    <li>
      <form method="post">
        <input type="submit" name="accept" class="navdelete" value="Cookies Löschen">
      </form>
    <?php
    endif;
    ?>
  </ul>
</footer>

<?php
if (isset($_POST["accept"])) {

  if (!isset($_SESSION["accept"])) {
    $_SESSION["accept"] = "set";
  } else {
    unset($_SESSION["accept"]);
  }
}
?>