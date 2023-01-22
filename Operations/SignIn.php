<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    require_once("../database/bootstrap.php");
    $error = 1;
    //Check if fields are empty
    if (isset($_POST["username"]) && isset($_POST["password"]) && $_POST["username"] != "" && $_POST["password"] != "") {
        $account = $dbh->get_account($_POST["username"]);
        //Check if the user exists
        if (count($account) != 0) {
            $password = $account[0]["password"];
            //Check if the password is correct
            if ($password == $_POST["password"]) {
                $_SESSION["username"] = $account[0]["username"];
                $error = 0;
            }
        }
    }
    if ($error == 0) {
        header("Location: /SnapShot/");
    } else {
        header("Location: ../SignIn?error=1");
    }
}
?>