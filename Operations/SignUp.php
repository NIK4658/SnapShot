<?php
session_start();
require_once("../database/bootstrap.php");

//Check if fields are empty
if (isset($_POST["username"]) && isset($_POST["password"]) && $_POST["username"] != "" && $_POST["password"] != "") {
    $account = $dbh->get_account($_POST["username"]);
    //Check if username is already taken
    if (count($account) == 0) {
        //Check password length
        if(strlen($_POST["password"])<=16 && strlen($_POST["password"])>=8){
            $dbh->createAccount($_POST["username"], $_POST["password"]);
            $_SESSION["username"] = $_POST["username"];
            $error=0;
            if (!file_exists('../uploads/'.$_SESSION["username"].'/')) {
                mkdir('../uploads/'.$_SESSION["username"].'/', 0777, true);
            }
        }else{
            $error=1;
        }
    }else{
        $error=1;
    }
}else{
    $error=1;
}
if($error==0){
    header("Location: /SnapShot/");
}else{
    header("Location: ../SignUp?error=1");
}
?>