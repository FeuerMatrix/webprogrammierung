<?php
if (isset($_GET["id"]) && is_string($_GET["id"]) && $_GET["id"] != Null) {
    $id = (isset($_GET["id"]) && is_string($_GET["id"])) ? $_GET["id"] : "";
    $auth = isset($_SESSION["user"]);

    $database = new SQLiteStore();

    if (isset($_POST["Submit"])) {
        if ($database->getAuthor($id) == $_SESSION["user"]) {
            header("Location: eintragneu.php?from=" . $id);
        } else {
            header("Location: beitrag.php?id=" . $id . "&cause=" . urlencode("Du bist nicht Besitzer dieses Posts!"));
        }
        exit;
    }

    if (isset($_POST["delete"])) {
        if ($database->getAuthor($id) == $_SESSION["user"]) {
            $database->deletePost($id);
            header("Location: hauptseite.php?from=" . $id);
        } else {
            header("Location: beitrag.php?id=" . $id . "&cause=" . urlencode("Du bist nicht Besitzer dieses Posts!"));
        }
        exit;
    }


    if (isset($_POST["deleteComm"])) {
        $comm_id = (isset($_POST["c_id"]) && is_string($_POST["c_id"])) ? $_POST["c_id"] : "";
        if ($database->getCommentAuthor($id, $comm_id) == $_SESSION["user"]) {
            $database->deleteComm($id, $comm_id);
        } else {
            header("Location: beitrag.php?id=" . $id . "&cause=" . urlencode("Du bist nicht Besitzer dieses Kommentars!"));
        }
    }


    if (isset($_POST["Edit"])) {
        $comm_id = (isset($_POST["c_id"]) && is_string($_POST["c_id"])) ? $_POST["c_id"] : "";
        if ($database->getCommentAuthor($id, $comm_id) == $_SESSION["user"]) {
            header("Location: beitrag.php?id=" . $id . "&c_id=" . $comm_id . "&old=" . urlencode($database->getComment($id, $comm_id)));
        } else {
            header("Location: beitrag.php?id=" . $id . "&cause=" . urlencode("Du bist nicht Besitzer dieses Kommentars!"));
        }
    }

    if (isset($_POST["new"]) && isset($_SESSION["user"])) {
        $new = (isset($_POST["new"]) && is_string($_POST["new"])) ? $_POST["new"] : "";
        if (!isset($_GET["old"])) {
            $database->newComment($_SESSION["user"], $new, $id);
        } else {
            $comm_id = $_GET["c_id"];
            if ($database->getCommentAuthor($id, $comm_id) == $_SESSION["user"]) {
                $database->updateComment($id, $comm_id, $new);
                header("Location: beitrag.php?id=" . $id);
            }
        }
    }

    $titel = $database->getTitel($id);
    $desc =  $database->getDesc($id);
    $author = $database->getAuthor($id);
    $date =  $database->getDate($id);
    $img =  $database->getImage($id);
    $comments = $database->getComments($id);
    $anony = $database->getAnonym($id);


    function createComment($comm_id, $name, $text)
    {
        global $id;
        global $database;
?>
        <div class=commentbox>
            <p><?php echo $name ?></p>
            <p><?php echo $text ?></p>
            <form method="post">
                <?php if (isset($_SESSION["user"]) && $_SESSION["user"] == $database->getCommentAuthor($id, $comm_id)) : ?>
                    <input type="submit" name="Edit" value="Bearbeiten" class=edit>
                    <input type="submit" name="deleteComm" value="Löschen" class="delete">
                <?php endif; ?>
                <input type="hidden" name="c_id" value=<?php echo $comm_id ?>>
            </form>

        </div>
<?php
    }
} else {
    header("Location: hauptseite.php");
}
?>