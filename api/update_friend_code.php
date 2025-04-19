<?php
include 'conn.php'; // Include database connection

// Ensure the script is accessed via POST
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
	die("Invalid request.");
}

// Validate and sanitize input
if (!isset($_POST['user_id']) || !isset($_POST['friend_code'])) {
	die("Missing parameters.");
}

$user_id = intval($_POST['user_id']);
$friend_code = trim($_POST['friend_code']);

if (empty($friend_code)) {
	die("Friend code cannot be empty.");
}

// Update friend code in the users table
$sql = "UPDATE users SET friend_code = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $friend_code, $user_id);

if ($stmt->execute()) {
	echo "Friend code updated successfully.";
} else {
	echo "Error updating friend code: " . $conn->error;
}

$stmt->close();
?>
