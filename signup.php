<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./favicon/favicon.ico">
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <title>Register</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to right, #0f0c29, #302b63, #24243e);
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px;
            border-radius: 10px;
            width: 350px;
        }
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            background:#333;
            color:#fff;
        }
        input, button {
            width: 95%;
            padding: 10px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
        }
        input {
            background: #333;
            color: white;
        }
        input::placeholder {
          color: #ccc;
        }
        button {
            background: #5865F2;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background: #4752C4;
        }
        a {
            color: #5865F2;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create an Account</h2>
        <form method="post"
        action="./api/signup.php">
            <input type="email" placeholder="Email" required>
            <input type="text" placeholder="Display Name" name="full_name">
            <input type="text" placeholder="Username" name="username" required>
            <input type="password" placeholder="Password" name="password" required>
            
            <select required>
                <option value="" disabled selected>Month</option>
                <option>January</option>
                <option>February</option>
                <option>March</option>
                <option>April</option>
                <option>May</option>
                <option>June</option>
                <option>July</option>
                <option>August</option>
                <option>September</option>
                <option>October</option>
                <option>November</option>
                <option>December</option>
            </select>

            <select required>
                <option value="" disabled selected>Day</option>
                <!-- Generate days dynamically -->
                <script>
                    for (let i = 1; i <= 31; i++) {
                        document.write(`<option>${i}</option>`);
                    }
                </script>
            </select>

            <select required>
                <option value="" disabled selected>Year</option>
                <!-- Generate years dynamically -->
                <script>
                    for (let i = 2025; i >= 1920; i--) {
                        document.write(`<option>${i}</option>`);
                    }
                </script>
            </select>

            <button type="submit">Continue</button>
        </form>
        <p>Already have an account? <a href="login.php">Log in</a></p>
    </div>
</body>
</html>
