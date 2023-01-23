<?php
//Database Conection
require_once("../database/bootstrap.php");
$templateParams["Type"] = "post.php";
$templateParams["NeedLogin"] = true;
if (isset($_GET["username"]) && isset($_GET["postID"])) {
    $PageParams["account"] = $dbh->get_account($_GET["username"]);
    $PageParams["post"]= $dbh->get_post($_GET["username"], $_GET["postID"] );
}else{
    echo "Error";
}
require ("../Template/base.php");
?>