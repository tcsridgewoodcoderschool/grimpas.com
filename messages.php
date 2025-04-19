<?php
session_start();
require './api/conn.php'; // Include your database connection file

if (empty($_SESSION['user'])) {
    header("Location: /?alert=Please log in first.");
    exit();
}

// Fetch all users for the recipient dropdown
$userQuery = $conn->query("SELECT username FROM users WHERE username != '{$_SESSION['user']}'");
$users = $userQuery->fetch_all(MYSQLI_ASSOC);

$recipient = $_GET['recipient'] ?? ''; // Get the recipient from the URL for private messaging
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./favicon/favicon.ico">
    <title>Grimpas Messaging App</title>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 1200px;
        }
        #msgs-wrapper {
            background: rgba(255, 255, 255, 0.1);
            padding: 15px;
            border-radius: 10px;
            max-height: 60vh;
            overflow-y: auto;
            margin-bottom: 20px;
        }
        .message {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 8px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
        }
        .btn {
            background: #5865F2;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            margin-top: 10px;
        }
        .btn:hover {
            background: #4752C4;
        }
        .select-recipient {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .select-recipient select {
            flex: 1;
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
        }
    </style>
</head>
<body>
 <a href="settings.php" style="position:fixed; color:white;top:20px; right:20px;">  <i class="fa-solid fa-gear"></i> </a>
    <div class="container">
        <h1>Grimpas Messaging App</h1>

        <!-- Recipient Selection -->
        <div class="select-recipient">
            <select id="recipientSelect">
                <option value="">Select a user to message privately</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?php echo htmlspecialchars($user['username']); ?>"><?php echo htmlspecialchars($user['username']); ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn" onclick="startPrivateChat()">Start Private Chat</button>
        </div>

        <!-- Messages Section -->
        <?php if (!empty($recipient)): ?>
            <p>Chat with: <strong><?php echo htmlspecialchars($recipient); ?></strong></p>
        <?php else: ?>
            <p>Public Messages</p>
        <?php endif; ?>
        <div id="msgs-wrapper">
            <div id="msgs">Loading messages...</div>
        </div>

        <!-- Message Input -->
        <form id="messageForm">
            <?php if (!empty($recipient)): ?>
                <input type="hidden" id="recipient" value="<?php echo htmlspecialchars($recipient); ?>">
            <?php endif; ?>
            <textarea id="message" class="form-control" placeholder="Type your message"></textarea>
            <input type="file" id="image" class="form-control" accept="image/*">
            <button type="button" class="btn" onclick="sendMessage()">Send</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        const recipient = document.getElementById('recipient')?.value;

        // Start a private chat
        function startPrivateChat() {
            const recipientSelect = document.getElementById('recipientSelect');
            const selectedRecipient = recipientSelect.value;
            if (selectedRecipient) {
                window.location.href = `messages.php?recipient=${selectedRecipient}`;
            } else {
                alert('Please select a user to start a private chat.');
            }
        }

        // Fetch messages (public or private)
        function fetchMessages() {
            const url = recipient ? `./api/fetch_private_messages.php?recipient=${recipient}` : './api/fetch_messages.php';
            $.get(url, function(data) {
                const messages = JSON.parse(data).messages;
                let html = '';
                messages.forEach(msg => {
                    html += `
                        <div class="message">
                            <strong>${msg.sender}:</strong> ${msg.message}<br>
                            ${msg.image ? `<img src="./api/${msg.image}" alt="Image" style="max-width: 500px; border-radius: 8px;">` : ''}
                        </div>
                    `;
                });
                document.getElementById('msgs').innerHTML = html;
            });
        }

        // Send message (public or private)
        function sendMessage() {
            const message = document.getElementById('message').value;
            const image = document.getElementById('image').files[0];
            const formData = new FormData();
            if (recipient) formData.append('recipient', recipient);
            formData.append('message', message);
            if (image) formData.append('image', image);

            const url = recipient ? './api/send_private_message.php' : './api/insert_message.php';
            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    const data = JSON.parse(response);
                    if (data.status === 'success') {
                        document.getElementById('message').value = '';
                        document.getElementById('image').value = '';
                        fetchMessages();
                    } else {
                        alert(data.message);
                    }
                },
                error: function() {
                    alert('Error sending message. Please try again.');
                }
            });
        }

        // Fetch messages every 5 seconds
        setInterval(fetchMessages, 5000);
        fetchMessages(); // Initial fetch
    </script>
</body>
</html>