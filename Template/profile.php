<?php
require_once("../database/bootstrap.php");
require_once("../Operations/getImage.php");

if (isset($_GET["username"])) {
    $PageParams["account"] = $dbh->get_account($_GET["username"]);
    $target_dir = "../uploads/" . $_GET["username"] . "/";
    $avatarPath = getImage($_GET["username"], "avatar");
    $personal = ($PageParams["account"][0]["username"] == $_SESSION["username"]);
    if ($personal) {
        echo "<button class=mainbutton onclick=location.href='/SnapShot/Operations/SignOut.php'>SignOut</button>";
    }

    if (!file_exists($avatarPath)) {
        $avatarPath = "../res/images/sampleAvatar.png";
    }

    echo '<img style="border-radius: 50%" src="' . $avatarPath . '"></img>';

    echo "<p> Username: " . $PageParams["account"][0]["username"] . "</p>";
    echo "<p> Bio: " . $PageParams["account"][0]["bio"] . "</p>";
    echo "<p> Password: " . $PageParams["account"][0]["password"] . "</p>";
    echo "<p> n_post: " . $PageParams["account"][0]["n_posts"] . "</p>";
    echo "<p> n_followers: " . $PageParams["account"][0]["n_followers"] . "</p>";
    echo "<p> n_following: " . $PageParams["account"][0]["n_following"] . "</p>";


    $posts = $dbh->get_last_n_posts_from($PageParams["account"][0]["username"], 10, 0);
    foreach ($posts as $post) {
        $image = getImage($PageParams["account"][0]["username"], $post["id"]);
        if ($image != "Error") {
            echo "<a href=../Post?username=" . $PageParams["account"][0]["username"] . "&postID=" . $post["id"] . "><img src=" . $image . "></img></a>";
        }
    }

} else {
    echo "Error";
}

?>