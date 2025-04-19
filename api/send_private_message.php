<?php
session_start();
require 'conn.php'; // Include your database connection file

if (empty($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please log in first.']);
    exit();
}

$sender = $_SESSION['user'];
$recipient = $_POST['recipient'];
$message = $_POST['message'];
$image = null;

if (!empty($_FILES['image']['name'])) {
    $targetDir = "uploads/";
    $fileName = basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . $fileName;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
        $image = $targetFilePath;
    }
}

$stmt = $conn->prepare("INSERT INTO private_messages (sender, recipient, message, image) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $sender, $recipient, $message, $image);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Message sent successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to send message.']);
}

$stmt->close();
$conn->close();
?>