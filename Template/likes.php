<?php
require_once("../database/bootstrap.php");
require_once("../Operations/getImage.php");
require_once("../Operations/getAvatar.php");

$username = $PageParams["account"][0]["username"];
$postID = $PageParams["post"][0]["id"];

$accounts = $dbh->get_love_post($username, $postID);

foreach ($accounts as $account) {
    echo '<img style="border-radius: 50%" src="' . getAvatar($account["username"]) . '"></img>';
    echo "<p> Username: " . $account["username"] . "</p>";

    if($_SESSION["username"] != $account["username"]){
        if($dbh->is_following($_SESSION["username"], $account["username"])){
            $content="UnFollow";
        } else {
            $content = "Follow";
        }
        echo "<button onclick=location.href='/SnapShot/Operations/Follows.php?user1=".$_SESSION["username"]."&user2=".$account["username"]."'>".$content."</button></br>";
    }else{
        echo "</br>";
    }
}

?>