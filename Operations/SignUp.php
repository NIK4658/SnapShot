<?php
session_start();
require_once("../database/bootstrap.php");

if (isset($_POST["username"]) && isset($_POST["password"]) && $_POST["username"] != "" && $_POST["password"] != "") {
    $account = $dbh->get_account($_POST["username"]);
    if (count($account) == 0) {
        $dbh->createAccount($_POST["username"], $_POST["password"]);
        $_SESSION["username"] = $_POST["username"];
    }else{
        $error=1;
    }
    $error=0;
}else{
    $error=1;
}
if($error==0){
    header("Location: /SnapShot/");
}else{
    header("Location: ../SignUp?error=1");
}
?>