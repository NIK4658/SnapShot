<?php
//Database Conection
require_once("../database/bootstrap.php");
require_once("../test/Variables.php");
$templateParams["Type"] = "home.php";
$templateParams["Script"] = "home.js";
require ("../Template/base.php");
?>