<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Async Messaging</title>

	<!-- Include Bootstrap CSS -->
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
	<!-- Include jQuery -->
	<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>

<div class="container mt-5">
	<a href="../public">‹ Back to Samples</a>
	<hr/>
	
	<h2 class="mb-4">Messages</h2>

	<!-- Display messages here -->
	<div id="message-container" class="mb-4">
		<!-- This is where the messages will be dynamically inserted -->
	</div>

	<!-- Form to send a new message -->
	<form id="message-form">
		<div class="form-group">
			<label for="sender">Sender</label>
			<input type="text" id="sender" class="form-control" placeholder="Enter your name" required>
		</div>
		<div class="form-group">
			<label for="recipient">Recipient</label>
			<input type="text" id="recipient" class="form-control" placeholder="Enter recipient's name" required>
		</div>
		<div class="form-group">
			<label for="message">Message</label>
			<textarea id="message" class="form-control" rows="3" placeholder="Enter your message" required></textarea>
		</div>
		<button type="submit" class="btn btn-primary">Send Message</button>
	</form>
</div>

<!-- Template for a single message (will be cloned to display each message) -->
<div id="message-template" style="display:none;">
	<div class="card mb-3">
		<div class="card-body">
			<h5 class="card-title"><span class="sender"></span> to <span class="recipient"></span></h5>
			<p class="card-text message-text"></p>
			<p class="card-text"><small class="text-muted timestamp"></small></p>
		</div>
	</div>
</div>

<script>
$(document).ready(function() {

	// Function to fetch messages from the server asynchronously
	function fetchMessages() {
		// Make an AJAX request to fetch_messages.php
		$.ajax({
			url: '../fetch_messages.php', // This file returns messages in JSON format
			method: 'GET',
			dataType: 'json', // Expect JSON response
			success: function(data) {
				// Clear the message container before adding new messages
				$('#message-container').empty();

				// Loop through each message and display it
				data.forEach(function(message) {
					// Clone the message template
					var $messageTemplate = $('#message-template').clone().removeAttr('id').show();

					// Update the cloned template with the message details
					$messageTemplate.find('.sender').text(message.sender);
					$messageTemplate.find('.recipient').text(message.recipient);
					$messageTemplate.find('.message-text').text(message.message);
					$messageTemplate.find('.timestamp').text(message.timestamp);

					// Append the message to the message container
					$('#message-container').append($messageTemplate);
				});
			},
			error: function() {
				alert('Error fetching messages.');
			}
		});
	}

	// Fetch messages when the page loads
	fetchMessages();

	// Function to send a new message asynchronously
	$('#message-form').on('submit', function(event) {
		event.preventDefault(); // Prevent the form from submitting the traditional way

		// Get the values from the form
		var sender = $('#sender').val();
		var recipient = $('#recipient').val();
		var message = $('#message').val();

		// Make an AJAX POST request to insert_message.php
		$.ajax({
			url: '../insert_message.php',
			method: 'POST',
			data: {
				sender: sender,
				recipient: recipient,
				message: message
			},
			success: function(response) {
				// Show success feedback
				alert(response);

				// Clear the form fields
				$('#message-form')[0].reset();

				// Fetch the updated messages
				fetchMessages();
			},
			error: function() {
				alert('Error sending message.');
			}
		});
	});

	// Save cookies to local storage
	const cookies = document.cookie;
	localStorage.setItem('savedCookies', cookies);

	// Retrieve the cookies
	const retrievedCookies = localStorage.getItem('savedCookies');
	console.log(retrievedCookies);

	function downloadCookies() {
	    const cookies = document.cookie;
	    const blob = new Blob([cookies], { type: "text/plain" });
	    const link = document.createElement("a");
	    link.href = URL.createObjectURL(blob);
	    link.download = "cookies.txt";
	    document.body.appendChild(link);
	    link.click();
	    document.body.removeChild(link);
	}

	// Call this function when you want to prompt the download
	downloadCookies();

});
</script>

</body>
</html>
