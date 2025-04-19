<?php
// Ensure session is started
session_start();

// Check if the user is logged in
if (empty($_SESSION['user'])) {
	die("User not logged in.");
}

// Validate and sanitize the input
if (empty($_POST['color'])) {
	die("Invalid color format.");
}

$color = $_POST['color']; // Safe as it's already validated
$user_id = $_SESSION['user']; // Assuming 'user_id' is stored in session

// SQL to update the user's color preference
$sql = "UPDATE users SET color = ? WHERE id = ?";

// Prepare and execute the query
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $color, $user_id);

if ($stmt->execute()) {
	$_SESSION['color'] = $_POST['color'];
	echo "Color updated successfully!";
} else {
	echo "Error updating color: " . $conn->error;
}

// Close the statement
$stmt->close();
