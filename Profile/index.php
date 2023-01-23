<?php
//Database Conection
require_once("../database/bootstrap.php");
require_once("../test/Variables.php");
$templateParams["Type"] = "profile.php";
$templateParams["NeedLogin"] = true;
if (isset($_GET["username"])) {
    $templateParams["account"] = $dbh->get_account($_GET["username"]);
}else{
    echo "Error";
}
require ("../Template/base.php");
?>