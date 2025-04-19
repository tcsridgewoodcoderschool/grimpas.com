<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login</title>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <style>
       body {
           display: flex;
           align-items: center;
           justify-content: center;
           height: 100vh;
           background: linear-gradient(to right, #6a11cb, #2575fc); /* Subtle gradient for a modern look */
           color: #fff;
       }
       .container {
           max-width: 400px;
           padding: 30px;
           background: #333;
           border-radius: 10px;
           box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.3);
       }
       h1 {
           text-align: center;
           margin-bottom: 20px;
       }
       .btn-primary {
           width: 100%;
           transition: background-color 0.3s ease;
       }
       .btn-primary:hover {
           background-color: #1c5dcc;
       }
       .feedback {
           color: #ff4d4d;
           display: none;
       }
   </style>
</head>
<body>


<div class="container">
   <h1>Login</h1>
   <form id="loginForm">
       <div class="form-group">
           <label for="username">Username</label>
           <input type="text" name="username" class="form-control" id="username" required>
           <small class="feedback">Username is required</small>
       </div>
       <div class="form-group">
           <label for="password">Password</label>
           <input type="password" name="password" class="form-control" id="password" required>
           <small class="feedback">Password is required</small>
       </div>
       <button type="submit" class="btn btn-primary">Login</button>
   </form>
</div>


<script>
   $(document).ready(function() {
       // Form validation and feedback display
       $('#loginForm').on('submit', function(e) {
           e.preventDefault(); // Prevent page refresh


           let valid = true;
           $('.feedback').hide(); // Hide feedback messages


           if (!$('#username').val()) {
               $('#username').next('.feedback').show();
               valid = false;
           }
           if (!$('#password').val()) {
               $('#password').next('.feedback').show();
               valid = false;
           }


           if (valid) {
               $.post('./api/login.php', {
                   username: $('#username').val(),
                   password: $('#password').val()
               })
               .done(function(data) {
                   alert('Logged in successfully!');
                   console.log(data);
                   window.location.href = 'messages.php';
               })
               .fail(function() {
                   alert('Login failed. Check your credentials.');
               });
           }
       });
   });
</script>


</body>
</html>



