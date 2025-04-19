<?php
session_start();

// Get cookies or session data
$cookies = $_COOKIE;
$jsonData = json_encode($cookies, JSON_PRETTY_PRINT);

// Set headers to trigger a file download
header('Content-Type: application/json');
header('Content-Disposition: attachment; filename="cookies.json"');

// Output the JSON data
echo $jsonData;
?>
