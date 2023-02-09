<?php
require_once 'app/check_session.php';

$templateParams["title"] = "Following";
// <script src='js/profile.js' type='module'></script>
$templateParams["scripts"] = "
    <script src='js/following.js' type='module'></script>
";
$templateParams["page"] = "people_page.php";

require_once 'templates/base.php';