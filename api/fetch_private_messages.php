<?php
session_start();
require 'conn.php'; // Include your database connection file

if (empty($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please log in first.']);
    exit();
}

$user1 = $_SESSION['user'];
$user2 = $_GET['recipient'];

$stmt = $conn->prepare("SELECT * FROM private_messages WHERE (sender = ? AND recipient = ?) OR (sender = ? AND recipient = ?) ORDER BY created_at ASC");
$stmt->bind_param("ssss", $user1, $user2, $user2, $user1);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode(['status' => 'success', 'messages' => $messages]);

$stmt->close();
$conn->close();
?>