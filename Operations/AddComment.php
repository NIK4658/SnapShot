<?php
require_once("../database/bootstrap.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (
        isset($_POST["usernameComment"]) &&
        isset($_POST["usernamePost"]) &&
        isset($_POST["postid"]) &&
        isset($_POST["Comment"])
    ) {
        $dbh->create_comment1($_POST["usernamePost"], $_POST["postid"], $_POST["usernameComment"], $_POST["Comment"]);
        header("Location: ../Post?username=" . $_POST["usernamePost"] . "&postID=" . $_POST["postid"]);
    }else{
        header("Location: ../Post?username=" . $_POST["usernamePost"] . "&postID=" . $_POST["postid"]."&error=1");
    }
}
?>