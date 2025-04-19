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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
        }
        h1 {
            margin-bottom: 20px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background: #5865F2;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        .btn:hover {
            background: #4752C4;
        }
        .btn-secondary {
            background: #333;
        }
        .btn-secondary:hover {
            background: #444;
        }
        .d-flex {
            display: flex;
            flex-direction: column;
        }
        .d-none {
            display: none;
        }
        .justify-content-end {
            justify-content: flex-end;
        }
        .mb-4 {
            margin-bottom: 1.5rem;
        }
        .mr-3 {
            margin-right: 1rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Grimpas Messaging App™</h1>
        <p><?php if(!empty($_SESSION["user"])) echo ("Hello, " .  $_SESSION["user"] . "!"); else echo ""; ?></p>
        <div class="<?php if (empty($_SESSION['user'])) echo "d-flex"; else echo "d-none"; ?> justify-content-end mb-4">
            <button class="btn btn-primary mr-3" onclick="window.location.href = 'signup.php'">Sign Up</button>
            <button class="btn btn-secondary" onclick="window.location.href = 'login.php'">Log In</button>
        </div>
        <div class="<?php if (empty($_SESSION['user'])) echo "d-none"; else echo "d-flex"; ?> justify-content-end mb-4">
            <button class="btn btn-primary mr-3" onclick="window.location.href = 'messages.php'">Go to messages ›</button>
            <button class="btn btn-secondary" onclick="window.location.href = 'settings.php'">Go to settings page ›</button>
        </div>
    </div>
</body>
</html>