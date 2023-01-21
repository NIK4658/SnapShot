<?php
require_once('../database/bootstrap.php');
$args = json_decode($_POST['args'], false);
$post = $dbh->get_n_posts('federico');
echo json_encode($post);
?>