<?php
require_once("../database/bootstrap.php");
require_once("../Operations/getImage.php");

$personal = ($PageParams["account"][0]["username"] == $_SESSION["username"]);
if ($personal) {
    echo "<button class=mainbutton onclick=location.href='../Operations/RemovePost.php?username=" . $PageParams["account"][0]["username"] . "&postID=" . $PageParams["post"][0]["id"] . "'>RemovePost</button>";
}

echo "<p> Username: " . $PageParams["account"][0]["username"] . "</p>";
echo "<p> Date: " . $PageParams["post"][0]["date"] . "</p>";
$image = getImage($PageParams["account"][0]["username"], $PageParams["post"][0]["id"]);
if ($image != "Error") {
    echo "<img src=" . $image . "></img>";
} else {
    echo "Image Error";
}
echo "<p> Description: " . $PageParams["post"][0]["description"] . "</p>";
echo "<a href=../Likes?username=" . $PageParams["account"][0]["username"] . "&postID=" . $PageParams["post"][0]["id"] . "> n_loves: " . $PageParams["post"][0]["n_loves"] . "</a>";
echo "<p> n_comments: " . $PageParams["post"][0]["n_comments"] . "</p>";
echo "<p> device: " . $PageParams["post"][0]["device"] . "</p>";
echo "<p> location: " . $PageParams["post"][0]["location"] . "</p>";

$comments = $dbh->get_last_n_comments1_from($PageParams["account"][0]["username"], $PageParams["post"][0]["id"], 10, 0);

foreach ( $comments as $comment){
    echo $comment["username"].": ".$comment["comment"];
}

?>

<form action="../Operations/AddComment.php" method="post">
    <input type='hidden' name='usernameComment' value='<?=$_SESSION["username"]?>'/>
    <input type='hidden' name='usernamePost' value='<?=$PageParams["account"][0]["username"]?>'/>
    <input type='hidden' name='postid' value='<?=$PageParams["post"][0]["id"]?>' />
    <input type="text" id="Comment" name="Comment"><br><br>
    <input type="submit" value="Commenta" name="submit">
</form>