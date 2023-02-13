<?php
require_once 'app/check_session.php';

$templateParams["title"] = "Location_Device";
$templateParams["scripts"] = "
    <script src='js/location_device.js' type='module'></script>
    <script src='js/post.js'></script>
";
$templateParams["page"] = "location_device_page.php";

require_once 'templates/base.php';
