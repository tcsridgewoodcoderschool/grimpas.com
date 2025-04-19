<?php
// Include the database connection file
include 'conn.php';

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// Get the posted data
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);

    // Fetch the user by username
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
    	if (password_verify($password, $row['password'])) {
    		$_SESSION['user'] = $username;
    		echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    	} else {
    		echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
    	}
    } else {
    	echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} else {
	echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close the connection
$conn->close();
?>