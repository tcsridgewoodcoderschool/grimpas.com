<?php
// Include the database connection file
include 'conn.php';

header("Content-Type: application/json; charset=utf-8");

// Ensure 'q' is set in the GET request
if (isset($_GET['q'])) {
	// Sanitize and get the input query
	$q = $_GET['q'];

	// Add wildcards for partial matching
	$search = '%' . $q . '%';

	// Prepare the SQL statement with a wildcard search
	$stmt = $conn->prepare("SELECT full_name, username FROM users WHERE username LIKE ?");
	if ($stmt) {
		// Bind the parameter to the query
		$stmt->bind_param("s", $search);

		// Execute the query
		$stmt->execute();

		// Get the result
		$result = $stmt->get_result();

		// Fetch all matching rows
		$users = $result->fetch_all(MYSQLI_ASSOC);

		// Return the results as JSON
		echo json_encode($users);

		// Free result and close the statement
		$result->free();
		$stmt->close();
	} else {
		// Error preparing the statement
		echo json_encode(['error' => 'Failed to prepare the query.']);
	}
} else {
	// 'q' is not set in the request
	echo json_encode(['error' => 'Query parameter "q" is missing.']);
}

// Close the database connection
$conn->close();
?>

