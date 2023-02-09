<?php
require_once 'app/check_session.php';

$templateParams["title"] = "Post";
// $templateParams["scripts"] = "
//     <script src='js/profile.js' type='module'></script>
//     <script src='js/post.js'></script>
// ";
$templateParams["scripts"] = "
    <script src='js/single_post.js' type='module'></script>
    <script src='js/post.js'></script>
";
$templateParams["page"] = "post_page.php";

require_once 'templates/base.php';
