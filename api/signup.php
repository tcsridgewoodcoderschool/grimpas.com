<?php

// Function to generate random string for friend code
function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[random_int(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Function to validate password strength
function isPasswordStrong($password) {
    // Minimum length of 8 characters
    $minLength = 8;
    if (strlen($password) < $minLength) {
        return false;
    }

    // Check for at least one uppercase letter
    if (!preg_match('/[A-Z]/', $password)) {
        return false;
    }

    // Check for at least one lowercase letter
    if (!preg_match('/[a-z]/', $password)) {
        return false;
    }

    // Check for at least one digit
    if (!preg_match('/\d/', $password)) {
        return false;
    }

    // Check for at least one special character
    if (!preg_match('/[\W_]/', $password)) {
        return false;
    }

    return true;
}

// Include the database connection file
include 'conn.php';

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the posted data
    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $rand = generateRandomString(5);

    // Check if username already exists
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Username already exists
        echo json_encode(['status' => 'error', 'message' => 'Username already exists']);
    } else {
        // Validate password strength
        if (!isPasswordStrong($password)) {
            // Password doesn't meet strength requirements
            echo json_encode(['status' => 'error', 'message' => 'Password must be at least 8 characters long, contain one uppercase letter, one lowercase letter, one number, and one special character']);
            exit;
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert the new user into the database
        $sql = "INSERT INTO users (full_name, username, password, friend_code) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        // Bind the parameters to the prepared statement
        $stmt->bind_param("ssss", $full_name, $username, $hashed_password, $rand);

        // Execute the prepared statement
        if ($stmt->execute()) {
            // Success
            echo json_encode(['status' => 'success', 'message' => 'User created successfully']);
            header("Location: /login.php");
            exit; // Don't forget to stop the script after redirection
        } else {
            // Database error
            echo json_encode(['status' => 'error', 'message' => 'Error: ' . $stmt->error]);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

// Close the connection
$conn->close();
?>
