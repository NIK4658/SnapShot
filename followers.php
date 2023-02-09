<?php
require_once 'app/check_session.php';

$templateParams["title"] = "Followers";
$templateParams["scripts"] = "
    <script src='js/followers.js' type='module'></script>
";
$templateParams["page"] = "people_page.php";

require_once 'templates/base.php';
