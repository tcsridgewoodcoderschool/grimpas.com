<?php
// Include the database connection
include 'conn.php';

/* Function to insert a new message into the DB */
function insertMessage($sender, $recipient, $message, $imagePath = null) {
    global $conn; // Use the existing connection

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO messages (sender, recipient, message, image_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $sender, $recipient, $message, $imagePath);

    // Execute and check for success
    if ($stmt->execute()) {
        echo "Message sent successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Function to handle file upload
function uploadImage() {
    $targetDir = "uploads/";
    $fileName = basename($_FILES["image"]["name"]);
    $targetFilePath = $targetDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow certain file formats
    $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
    if (in_array($fileType, $allowTypes)) {
        // Upload file to server
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
            return $targetFilePath;
        } else {
            echo "Sorry, there was an error uploading your file.";
            return null;
        }
    } else {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.";
        return null;
    }
}

// Example usage
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sender = $_POST['sender'];
    $recipient = $_POST['recipient'];
    $message = $_POST['message'];
    $imagePath = null;

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imagePath = uploadImage();
    }

    insertMessage($sender, $recipient, $message, $imagePath);
}
?>