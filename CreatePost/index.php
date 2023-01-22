<?php
//Database Conection
require_once("../database/bootstrap.php");
$templateParams["Type"] = "CreatePost.php";
$templateParams["NeedLogin"] = true;
require ("../Template/base.php");
?>