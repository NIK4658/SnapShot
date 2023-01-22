<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    require_once("../database/bootstrap.php");
    $error = 1;
    //Check if fields are empty
    if (
        isset($_POST["description"]) &&
        isset($_POST["location"]) &&
        isset($_POST["device"]) &&
        isset($_POST["myPhoto"]) &&
        $_POST["description"] != "" &&
        $_POST["location"] != "" &&
        $_POST["device"] != ""
        // is_uploaded_file($_FILES['myPhoto']['tmp_name'][0])
    ) {
        $error = 0;
        $dbh->create_post($_SESSION["username"], $_POST["description"], $_POST["location"], $_POST["device"]);
    }
}

if ($error == 0) {
    header("Location: /SnapShot/");
} else {
    header("Location: ../CreatePost?error=1");
}
?>