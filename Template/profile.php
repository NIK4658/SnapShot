<?php
require_once("../database/bootstrap.php");
require_once("../Operations/getImage.php");

if(isset($_GET["username"])){
    $templateParams["account"] = $dbh->get_account($_GET["username"]);
    $personal = ($templateParams["account"][0]["username"] == $_SESSION["username"]);
    if($personal){
        echo "<button class=mainbutton onclick=location.href='/SnapShot/Operations/SignOut.php'>SignOut</button>";
    }

    echo "<p> Username: " . $templateParams["account"][0]["username"]."</p>";
    echo "<p> Bio: " . $templateParams["account"][0]["bio"]."</p>";
    echo "<p> Password: " . $templateParams["account"][0]["password"]."</p>";
    echo "<p> n_post: " . $templateParams["account"][0]["n_posts"]."</p>";
    echo "<p> n_followers: " . $templateParams["account"][0]["n_followers"]."</p>";
    echo "<p> n_following: " . $templateParams["account"][0]["n_following"]."</p>";


    $posts = $dbh->get_last_n_posts_from($templateParams["account"][0]["username"], 10, 0);

    foreach ($posts as $post){
        $image=getImage($templateParams["account"][0]["username"], $post["id"]);
        if($image!="Error"){
            echo "<img src=".$image."></img>";
        }
    }


}else{
    echo "Error";
}

?>