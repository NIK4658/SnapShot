<?php
function getImage($username, $imageID) {
    $path = '../uploads/'.$username.'/'.$imageID;
    if(file_exists($path.'.png'))
    {
        return $path . '.png';
    }

    if(file_exists($path.'.jpg'))
    {
        return $path . '.jpg';
    }

    if(file_exists($path.'.jpeg'))
    {
        return $path . '.jpeg';
    }
    return "Error";
}
?>