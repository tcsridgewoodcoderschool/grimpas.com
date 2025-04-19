<?php

$under_construction = false;

if ($under_construction) {
    header("Location: construction.php");
    exit();
}

session_start();

?>


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Grimpas Messaging App</title>
   <link rel="shortcut icon" href="./favicon/favicon.ico">

   <!-- Bootstrap CSS -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <!-- jQuery -->
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

   <!-- Custom Styles -->
   <style>
       body {
           background-color: #444444; /* Soft black */
           font-family: 'Arial', sans-serif;
           justify-content: center;
           align-items: center;
           min-height: 100vh;
           margin: 30px;
           color: #ffd700; /* Bright gold text */
       }

       .container {
           max-width: 999px;
           background-color: #888888; /* Slightly lighter black */
           padding: 30px;
           border: 2px solid #ffd700; /* Bright gold border */
           border-radius: 12px;
           box-shadow: 0px 10px 30px rgba(255, 215, 0, 0.5), 0px 5px 15px rgba(0, 0, 0, 0.7);
       }

       h1, h2 {
           text-align: center;
           color: #A2CFFE; /* Bright gold text */
           font-weight: 700;
       }

       h1 {
           font-size: 2.5rem;
       }

       h2 {
           font-size: 1.8rem;
           margin-top: 20px;
       }

       .form-group label {
           font-weight: 600;
           color: #A2CFFE; /* Bright gold for labels */
       }
       
       #msgs {
           
       }
       
       #msgs-wrapper {
           margin-top: 20px;
           padding: 15px;
           background-color: #333333; /* Slightly lighter black for message area */
           border: 2px solid #ffd700; /* Bright gold border */
           border-radius: 8px;
           max-height: 70vh;
           overflow-y: auto;
           box-shadow: inset 0px 4px 8px rgba(0, 0, 0, 0.5);
       }

       .message {
           padding: 12px;
           margin-bottom: 12px;
           border-radius: 8px;
           /*background-color: #444444; /* Lighter black for messages */
           /* border: 1px solid #ffd700;  Bright gold border for individual messages */
           color: #ffd700; /* Gold text */
           box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.4);
       }

       .btn-primary, .btn-secondary, .btn-success {
           width: 100%;
           margin-top: 12px;
           font-weight: bold;
           background-color: #1c1c1c; /* Soft black for buttons */
           border: 2px solid #ffd700; /* Bright gold border for buttons */
           color: #ffd700; /* Gold text */
           box-shadow: 0px 4px 10px rgba(255, 215, 0, 0.4), 0px 2px 6px rgba(0, 0, 0, 0.5);
           transition: all 0.3s ease;
       }

       .btn-primary:hover, .btn-secondary:hover, .btn-success:hover {
           background-color: #333333; /* Slightly lighter black on hover */
           transform: scale(1.05);
           box-shadow: 0px 6px 12px rgba(255, 215, 0, 0.6);
       }

       .img-preview {
           max-width: 100%;
           height: auto;
           margin-top: 10px;
           border-radius: 8px;
           box-shadow: 0px 4px 8px rgba(255, 215, 0, 0.4);
       }

       .form-control {
           background-color: #1c1c1c; /* Black for input boxes */
           border: 2px solid #ffd700; /* Bright gold border */
           color: #ffd700; /* Gold text */
           border-radius: 6px;
           box-shadow: inset 0px 2px 6px rgba(0, 0, 0, 0.5);
       }

       .form-control::placeholder {
           color: rgba(255, 215, 0, 0.7); /* Light gold for placeholder */
       }

       .form-control:focus {
           background-color: #333333; /* Slightly lighter black on focus */
           box-shadow: 0 0 8px rgba(255, 215, 0, 0.6);
       }
       .autocomplete-items {
      position: absolute;
      border: 1px solid #d4d4d4;
      border-bottom: none;
      border-top: none;
      z-index: 99;
      top: 38%;
      left: 0;
      right: 0;
    }
    .autocomplete-item {
      padding: 10px;
      cursor: pointer;
      background-color: #fff;
      border-bottom: 1px solid #d4d4d4;
    }
    .autocomplete-item:hover {
      background-color: #e9e9e9;
    }
    
    form {
        position : fixed;
        bottom: 10px
    }
   </style>
</head>

<body>
   <!--<div class="container">-->
       <div class="row">
          <div class="col-4">
    <p class="text-center">Hello, <?php echo $_SESSION["user"]; ?></p>
    <h3 class="text-center text-warning">Who would you like to DM?</h3>
    
    <div id="user-list" class="list-group">
        <!-- Fetched users will be displayed here -->
    </div>
</div>


<div class="col-4">
    
    <h2>Message White</h2>
    
</div>


    <div class="col-4">

       <!-- Title -->

       <!-- Input Fields -->
       <form style="width:71%;">
           <div class="form-group d-none">
               <label for="sender">Sender</label>
               <input type="text" id="sender" class="form-control" name="sender" value="Enter username">
           </div>
           <div class="form-group d-none">
               <label for="recipient">Recipient</label>
               <input type="text" id="recipient" class="form-control" name="recipient" placeholder="Enter recipient" value="blue">
               <div id="autocomplete-list" class="autocomplete-items container"></div>
               <small class="text-warning" id="recipientError" style="display: none;">Recipient is required.</small>
           </div>
           
           <div class="form-group d-none">
               <label for="image">Upload Image</label>
               <input type="file" id="image" class="form-control" name="image" accept="image/*" onchange="previewImage(event)">
               <img id="imagePreview" class="img-preview" style="display: none;" alt="Image Preview">
           </div>
           
           <div class="row">
               <div class="col-4">
                   <div class="form-group">
                       <label for="message">Message</label>
                       
                       <small class="text-warning" id="messageError" style="display: none;">Message cannot be empty.</small>
                   </div>
                </div>
                <div class="col-2">
                    <label>&nbsp;</label>
                    <button type="button" class="btn btn-success" onclick="sendMessage()">Send</button>
                </div>
            </div>
           
       </form>

       <!-- Messages Section -->
       <h2>Public Messages</h2>
       <div id="msgs-wrapper">
          <div id="msgs">Loading messages...</div>
          <textarea id="message" class="form-control" name="message" rows="1px" placeholder="Type your message"></textarea>
       </div>
   </div>
      <!-- JavaScript Functions -->
   <script>
       $(document).ready(function () {
           fetchMessages(); // Fetch messages on page load
           setInterval(fetchMessages, 5000); // Refresh messages every 5 seconds
       });

       function sendMessage() {
           const sender = $("#sender").val();
           const recipient = $("#recipient").val();
           const message = $("#message").val();
           const image = $("#image")[0].files[0]; // Get the image file
           let valid = true;

           // Clear previous errors
           $("#recipientError, #messageError").hide();

           // Validate input fields
           if (!recipient) {
               $("#recipientError").show();
               valid = false;
           }
           if (!message && !image) {
               $("#messageError").show();
               valid = false;
           }

           if (!valid) return;

           // Prepare the FormData object
           const formData = new FormData();
           formData.append("sender", sender);
           formData.append("recipient", recipient);
           formData.append("message", message);
           //if (image) formData.append("image", image);

           $.ajax({
               url: "./api/insert_message.php",
               type: "POST",
               data: formData,
               processData: false,
               contentType: false,
           })
           .done(function() {
               $("#recipient").val("");
               $("#message").val("");
               $("#image").val(""); 
               $("#imagePreview").hide();
               fetchMessages(); 
           })
           .fail(function() {
               alert("Failed to send the message. Please try again.");
           });
       }

       function fetchMessages() {
           $.get("./api/fetch_messages.php", function(data) {
               $("#msgs").empty();
               if (data && data.length) {
                   data.forEach(message => {
                       $("#msgs").append(`
                           <div class="message">
                               <!--  <strong>Sender:</strong> ${message.sender}<br> -->
                               <strong>Recipient:</strong> ${message.recipient}<br>
                               <strong>Message:</strong> ${message.message}<br>
                               ${message.image ? `<img src="${message.image}" alt="Image" class="img-preview">` : ''}
                           </div>
                       `);
                   });
               } else {
                   $("#msgs").text("No messages to display.");
               }
           })
           .fail(function() {
               $("#msgs").text("Unable to fetch messages.");
           });
       }

       function previewImage(event) {
           const file = event.target.files[0];
           const reader = new FileReader();
           reader.onload = function() {
               const imagePreview = document.getElementById('imagePreview');
               imagePreview.src = reader.result;
               imagePreview.style.display = 'block';
           }
           if (file) {
               reader.readAsDataURL(file); 
           }
       }
       
       document.getElementById("recipient").addEventListener("input", function() {
    const input = this.value;
    const autocompleteList = document.getElementById("autocomplete-list");
    autocompleteList.innerHTML = ""; // Clear previous suggestions

    if (!input) return; // Exit if input is empty

    fetch(`api/fetch_users.php?q=${encodeURIComponent(input)}`)
      .then(response => response.json())
      .then(data => {
        data.forEach(user => {
          if (user.full_name.toLowerCase().includes(input.toLowerCase()) || 
              user.username.toLowerCase().includes(input.toLowerCase())) {
            const item = document.createElement("div");
            item.className = "autocomplete-item";
            item.textContent = `${user.full_name} (${user.username})`;
            item.addEventListener("click", () => {
              document.getElementById("recipient").value = `${user.full_name} (${user.username})`;
              autocompleteList.innerHTML = ""; // Clear suggestions
            });
            autocompleteList.appendChild(item);
            document.getElementById("autocomplete-list").style.display = "block";
          }
        });
      })
      .catch(error => console.error("Error fetching data:", error));
  });
  
   // Event listener at the end to clear suggestions when clicking outside
  document.addEventListener("click", (event) => {
    if (!event.target.closest("#autocomplete-list") && event.target.id !== "recipient") {
      document.getElementById("autocomplete-list").innerHTML = "";
      document.getElementById("autocomplete-list").style.display = "none";
    } else {
      document.getElementById("autocomplete-list").style.display = "block";
    }
  });
  
  document.addEventListener("DOMContentLoaded", function () {
    fetchUsers(); // Fetch users on page load
});

function fetchUsers() {
    // Call the API to fetch users
    fetch("api/fetch_users.php?q")
    .then(response => response.json())
    .then(data => {
        const userList = document.getElementById("user-list");
        userList.innerHTML = ""; // Clear the previous user list
        
        // If there are users, display them in the list
        if (data && data.length > 0) {
            data.forEach(user => {
                const userItem = document.createElement("a");
                userItem.href = "#"; // You can replace this with a clickable link to initiate a chat
                userItem.className = "list-group-item list-group-item-action text-warning";
                userItem.textContent = `${user.full_name} (${user.username})`;

                // Optionally, you can add a click event to set the recipient automatically
                userItem.addEventListener("click", function() {
                    document.getElementById("recipient").value = `${user.full_name} (${user.username})`;
                });

                userList.appendChild(userItem);
            });
        } else {
            userList.innerHTML = "<li class='list-group-item text-warning'>No users available.</li>";
        }
    })
    .catch(error => {
        console.error("Error fetching users:", error);
        document.getElementById("user-list").innerHTML = "<li class='list-group-item text-warning'>Error loading users.</li>";
    });
}

   </script>
   </div>
   <!--</div>-->
</body>
</html>
