<?php

$under_construction = false;

if ($under_construction) {
    header("Location: construction.php");
    exit();
}

session_start();
echo $_SESSION["user"];

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
           margin-top: 20px;
           padding: 15px;
           background-color: #333333; /* Slightly lighter black for message area */
           border: 2px solid #ffd700; /* Bright gold border */
           border-radius: 8px;
           max-height: 5000px;
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
   
    <h1>Grimpas Messaging App™</h1>
    <p>Whoop whoop!</p>
    <div class="<?php if (empty($_SESSION['user'])) echo "d-flex"; else echo "d-none"; ?> justify-content-end mb-4">
           <button class="btn btn-primary mr-3" onclick="window.location.href = 'signup.php'">Sign Up</button>
           <button class="btn btn-secondary" onclick="window.location.href = 'login.php'">Log In</button>
       </div>
       <div class="<?php if (empty($_SESSION['user'])) echo "d-none"; else echo "d-flex"; ?> justify-content-end mb-4">
           <button class="btn btn-primary mr-3" onclick="window.location.href = 'messages.php'">Go to messages ›</button>
           <button class="btn btn-secondary" onclick="window.location.href = 'profile.php'">Go to profile page ›</button>
       </div>
</body>
</html>
