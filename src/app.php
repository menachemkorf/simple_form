<?php


$db = new App\DB();
$connection = $db->connection;

$submission = new App\Submission($connection, UPLOAD_DIR);
$response = [];
if(!empty($_POST)) {
    $response = $submission->submitForm();
}

include(VIEW_DIR . '/header.php');
include(VIEW_DIR . '/content.php');
include(VIEW_DIR . '/footer.php');
