<?php
require_once("../database/bootstrap.php");
if (isset($_GET["user1"]) && isset($_GET["user2"])) {
    $user1 = $_GET["user1"];
    $user2 = $_GET["user2"];
    if ($dbh->is_following($user1, $user2)) {
        $dbh->unfollow($user1, $user2);
    } else {
        $dbh->follow($user1, $user2);
    }
}
header("Location: /SnapShot/Follows")
?>