<?php
      if (!isset($_SESSION["accept"])) :
      ?>
      <form method="post">
        <input type="submit" name="accept"  class="navdelete" value="Map Datenschutz zustimmen">
      </form>
    <?php
      endif;
    ?>

    <?php
    if (isset($_SESSION["accept"])) :
    ?>
      <form method="post">
        <input type="submit" name="accept" class="navdelete" value="Map Datenschutz nicht zustimmen">
      </form>
    <?php
    endif;
    ?>

<?php
if (isset($_POST["accept"])) {

  if (!isset($_SESSION["accept"])) {
    $_SESSION["accept"] = "set";
  } else {
    unset($_SESSION["accept"]);
  }
}
?>