<?php
$id = (isset($_GET["id"]) && is_string($_GET["id"])) ? $_GET["id"] : "";
$auth = isset($_SESSION["user"]);

$database = new SQLiteStore();

if (isset($_POST["Submit"])) {
    if ($database->getAuthor($id) == $_SESSION["user"]) {
        $_SESSION["id"] = $id;
        header("Location: eintragneu.php?from=".$id);
    } else {
        header("Location: beitrag.php?id=".$id."&cause=".urlencode("Du bist nicht Besitzer dieses Posts!"));
    }
    exit;
}

if (isset($_POST["delete"])) {
    if ($database->getAuthor($id) == $_SESSION["user"]) {
        $_SESSION["id"] = $id;
        $database->deletePost($id);
        header("Location: hauptseite.php?from=".$id);
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


function createComment($comm_id, $name, $text) {
    global $id;
    global $database;
?>
    <div class=commentbox>
        <p><?php echo $name ?></p>
        <p><?php echo $text ?></p>
        <form method="post">
            <?php if(isset($_SESSION["user"]) && $_SESSION["user"] == $database->getCommentAuthor($id, $comm_id)): ?>
            <input type="submit" name="Edit" value="Bearbeiten" class=edit>
            <?php endif; ?>
            <input type="hidden" name="c_id" value=<?php echo $comm_id ?> >
        </form>

    </div>
<?php
}
?>