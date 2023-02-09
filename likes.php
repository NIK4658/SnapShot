<?php
require_once 'app/check_session.php';
$templateParams["title"] = "Likes";
$templateParams["scripts"] = "
    <script src='js/likes.js' type='module'></script>
";
$templateParams["page"] = "people_page.php";
require_once 'templates/base.php';