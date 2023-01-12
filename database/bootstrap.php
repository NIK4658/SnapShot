<?php
session_start();
require_once("credentials.php");
require_once("database.php");
//Database Conection with own credentials
$dbh = new DatabaseHelper($Credentials['Address'], $Credentials['Username'], $Credentials['Password'], $Credentials['Database']);
?>