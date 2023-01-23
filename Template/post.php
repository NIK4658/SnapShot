<?php
require_once("../database/bootstrap.php");
require_once("../Operations/getImage.php");

$personal = ($PageParams["account"][0]["username"] == $_SESSION["username"]);
if ($personal) {
    echo "<button class=mainbutton onclick=location.href='../Operations/RemovePost.php?username=".$PageParams["account"][0]["username"]."&postID=".$PageParams["post"][0]["id"]."'>RemovePost</button>";
}

echo "<p> Username: " . $PageParams["account"][0]["username"] . "</p>";
echo "<p> Date: " . $PageParams["post"][0]["date"] . "</p>";
$image = getImage($PageParams["account"][0]["username"], $PageParams["post"][0]["id"]);
if ($image != "Error") {
    echo "<img src=" . $image . "></img>";
}else{
    echo "Image Error";
}
echo "<p> Description: " . $PageParams["post"][0]["description"] . "</p>";
echo "<p> n_loves: " . $PageParams["post"][0]["n_loves"] . "</p>";
echo "<p> n_comments: " . $PageParams["post"][0]["n_comments"] . "</p>";
echo "<p> device: " . $PageParams["post"][0]["device"] . "</p>";
echo "<p> location: " . $PageParams["post"][0]["location"] . "</p>";

?>