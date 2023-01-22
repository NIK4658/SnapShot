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
        is_uploaded_file($_FILES['fileToUpload']['tmp_name'])
    ) {
        $error = 0;
        // $mainDir = "../uploads/";
        $target_dir = "../uploads/" . $_SESSION["username"] . "/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a actual image or fake image
        if (isset($_POST["submit"])) {
            if (!getimagesize($_FILES["fileToUpload"]["tmp_name"])) {
                $uploadOk = 0;
            }
        }

        // Check if file already exists
        if (file_exists($target_file)) {
            $uploadOk = 0;
        }

        // Check if target dir exists
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Check file size
        if ($_FILES["fileToUpload"]["size"] > 200000) {
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            $uploadOk = 0;
        }

        $postid = $dbh->create_post($_SESSION["username"], $_POST["description"], $_POST["location"], $_POST["device"]);
        if ($postid != -1) {
            $target_file = $target_dir . $postid . "." . $imageFileType;
            // Move the image to the server
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                chmod($target_file, 0777);
                // unlink($target_file);
                // rmdir($target_dir);
            } else {
                $uploadOk = 0;
                // $dbh->delete_post($_SESSION["username"], $postid);
            }
        } else {
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
            header("Location: /SnapShot/");
        } else {
            header("Location: ../UploadImage?error=1");
        }
    }
}
//Da migliorare
if ($error == 0 && $uploadOk == 1) {
    header("Location: /SnapShot/");
} else {
    header("Location: ../CreatePost?error=1");
}
?>