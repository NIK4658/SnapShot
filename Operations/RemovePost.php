<?php
require_once("../database/bootstrap.php");
require_once("getImage.php");
if (isset($_GET["username"]) && isset($_GET["postID"])) {
    $dbh->delete_post($_GET["username"], $_GET["postID"]);
    $target_file = getImage($_GET["username"], $_GET["postID"]);
    unlink($target_file);
}
header("Location: /SnapShot/Profile?username=" . $_GET["username"]);
?>