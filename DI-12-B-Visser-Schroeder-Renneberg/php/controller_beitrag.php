<?php
$id = (isset($_GET["id"]) && is_string($_GET["id"])) ? $_GET["id"] : "";
$auth = isset($_SESSION["user"]);

include_once "datenbank/DummyUserStore.php";
$database = new DummyUserStore();

if (isset($_POST["Submit"])) {
    if ($database->getAuthor($id) == $_SESSION["user"]) {
        $_SESSION["id"] = $id;
        header("Location: eintragneu.php?from=Beitrag");
    } else {
        header("Location: beitrag.php?id=".$id."&cause=".urlencode("Du bist nicht Besitzer dieses Posts!"));
    }
    exit;
}

$edit = false;

if (isset($_POST["Edit"])) {
    $comm_id = (isset($_POST["c_id"]) && is_string($_POST["c_id"])) ? $_POST["c_id"] : "";
    if ($database->getCommentAuthor($id, $comm_id) == $_SESSION["user"]) {
        $edit = true;
        $old = $database->getComment($id, $comm_id);
    } else {
        header("Location: beitrag.php?id=".$id."&cause=".urlencode("Du bist nicht Besitzer dieses Kommentars!"));
    }
}

if (isset($_POST["new"]) && isset($auth)) {
    if (!$edit) {
        $new = (isset($_POST["new"]) && is_string($_POST["new"])) ? $_POST["new"] : "";
        $database->newComment($auth, $new);
    } else {
        $new = (isset($_POST["new"]) && is_string($_POST["new"])) ? $_POST["new"] : "";
        $database->updateComment($id, $comm_id, $new);
        $edit = false;
    }
}

$titel = $database->getTitel($id);
$desc =  $database->getDesc($id);
$author = $database->getAuthor($id);
$date =  $database->getDate($id);
$img =  $database->getImage($id);
$comments = $database->getComments($id);


function createComment($id, $name, $text) {
    global $database;
?>
    <div class=commentbox>
        <p><?php echo $name ?></p>
        <p><?php echo $text ?></p>
        <form method="post">
            <?php if(isset($_SESSION["user"]) && $_SESSION["user"] == $database->getAuthor($id)): ?>
            <input type="submit" name="Edit" value="Bearbeiten" class=edit>
            <?php endif; ?>
            <input type="hidden" name="c_id" value=<?php echo $id ?>>
        </form>

    </div>
<?php
}
?>