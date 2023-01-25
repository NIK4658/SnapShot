<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $target_dir = "../uploads/" . $_SESSION["username"] . "/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    $target_file = $target_dir . "avatar.".$imageFileType;

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

    // Check file size
    if ($_FILES["fileToUpload"]["size"] > 200000) {
        $uploadOk = 0;
    }

    // Allow certain file formats
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $uploadOk = 0;
    }

    // Move the image to the server
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        chmod($target_file, 0777);
    } else {
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if($uploadOk == 1){
        header("Location: /SnapShot/");
    } else {
        header("Location: ../UploadImage?error=1");
    }

} else {
    exit();
}
?>