<?php
require_once("../database/bootstrap.php");

$accounts = $dbh->get_account1();

foreach ($accounts as $account) {
    echo "<a href=/SnapShot/Profile?username=".$account["username"].">".$account["username"]."</a>";

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