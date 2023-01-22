<!-- SNAPSHOT -->
<!-- Jan 2023 -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="theme-color" content="#FFF" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>SnapShot</title>
</head>

<body>
    <main>
        <?php
        if(isset($templateParams["NeedLogin"]) && $templateParams["NeedLogin"] == true){
            if(!isset($_SESSION["username"])){
                header("Location: /SnapShot/SignIn");
            }
        }

        if(isset($templateParams["Type"])){
            require $templateParams["Type"];
        }

        if(isset($_SESSION["username"])){
            echo "Ciao ".$_SESSION["username"]."!";
        }else{
            echo "Non sei loggato!";
        }

        ?>
        <div class="buttons">
            <button class="mainbutton" onclick="location.href='/SnapShot/Home'">Home</a></button>
            <button class="mainbutton" onclick="location.href='#'">Search</button>
            <button class="mainbutton" onclick="location.href='/SnapShot/UploadImage'">Upload</button>
            <button class="mainbutton" onclick="location.href='#'">Notifications</button>
            <button class="mainbutton" onclick="location.href='/SnapShot/Profile'">Profile</button>
            <button class="mainbutton" onclick="location.href='/SnapShot/SignUp'">SignUp</button>
            <button class="mainbutton" onclick="location.href='/SnapShot/SignIn'">SignIn</button>
            <button class="mainbutton" onclick="location.href='/SnapShot/Operations/SignOut.php'">SignOut</button>
            <button class="mainbutton" onclick="location.href='/SnapShot/CreatePost'">Create Post</button>
        </div>
    </main>
</body>
<?php
if(isset($templateParams["Script"])){
    echo "<script src='/SnapShot/javascript/".$templateParams["Script"]."' type='module'></script>";
}
?>
</html>