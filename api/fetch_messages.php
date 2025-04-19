<?php
// Include the database connection
include 'conn.php';

/* Function to fetch all messages from the DB */
function fetchMessages() {
	global $conn; // Use the existing connection

	// Query to fetch all messages
	$sql = "SELECT * FROM messages ORDER BY timestamp DESC";
	$result = $conn->query($sql);

	// Initialize an empty array to store messages
	$messages = array();

	// Check if there are results
	if ($result->num_rows > 0) {
		// Fetch each message and add it to the array
		while($row = $result->fetch_assoc()) {
			$messages[] = $row;
		}
	}

	// Set the content-type header to JSON
	header('Content-Type: application/json');

	// Return the messages in JSON format
	echo json_encode($messages);
}

// Call the function to fetch and return messages
fetchMessages();
?>
