<?php
require_once("../database/bootstrap.php");

$accounts = $dbh->get_account1();

foreach ($accounts as $account) {
    // if($_SESSION["username"]===$account["username"]){
    //     echo "<p>".$account["username"]."</p>";
    // }else{
    //     echo "<a href=/SnapShot/Profile?username=".$account["username"].">".$account["username"]."</a><br>";
    // }

    echo "<a href=/SnapShot/Profile?username=".$account["username"].">".$account["username"]."</a><br>";
}
?>