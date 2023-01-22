<?php
//Database Conection
require_once("../database/bootstrap.php");
require_once("../test/Variables.php");
$templateParams["Type"] = "profile.php";
$templateParams["NeedLogin"] = true;
require ("../Template/base.php");
?>