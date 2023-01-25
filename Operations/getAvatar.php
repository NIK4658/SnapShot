<?php
function getAvatar($username) {
    $path = '../uploads/'.$username.'/avatar';
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
    return "../res/images/sampleAvatar.png";
}
?>