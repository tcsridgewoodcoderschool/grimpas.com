<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Debug Messages Table</title>

	<!-- Include Bootstrap 5 CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
	<a href="../tables">‹ Back to DB tables</a>

	<hr/>

	<h2>Debug: Raw Messages from the Database</h2>

	<hr/>

	<?php
	// Include the database connection
	include '../conn.php';

	/* Function to fetch all raw messages from the DB */
	function fetchAllMessages() {
		global $conn; // Use the existing connection

		// Query to fetch all messages
		$sql = "SELECT * FROM messages ORDER BY timestamp DESC";
		$result = $conn->query($sql);

		// Check if there are results
		if ($result->num_rows > 0) {
			// Start the table with Bootstrap classes
			echo '<table class="table table-striped">';
			echo '<thead><tr><th>ID</th><th>Sender</th><th>Recipient</th><th>Message</th><th>Timestamp</th></tr></thead>';
			echo '<tbody>';

			// Output each row of the table
			while($row = $result->fetch_assoc()) {
				echo '<tr>';
				echo '<td>' . $row["id"] . '</td>';
				echo '<td>' . $row["sender"] . '</td>';
				echo '<td>' . $row["recipient"] . '</td>';
				echo '<td>' . $row["message"] . '</td>';
				echo '<td>' . $row["timestamp"] . '</td>';
				echo '</tr>';
			}

			echo '</tbody></table>';
		} else {
			echo '<div class="alert alert-warning" role="alert">No messages found.</div>';
		}
	}

	// Call the function to fetch and display all messages
	fetchAllMessages();
	?>

</div>

</body>
</html>