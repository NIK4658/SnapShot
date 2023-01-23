<?php
//Database Conection
require_once("../database/bootstrap.php");
$templateParams["Type"] = "profile.php";
$templateParams["NeedLogin"] = true;
if (isset($_GET["username"])) {
    $PageParams["account"] = $dbh->get_account($_GET["username"]);
}else{
    echo "Error";
}
require ("../Template/base.php");
?>