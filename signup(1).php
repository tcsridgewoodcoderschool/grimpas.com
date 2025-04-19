<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="shortcut icon" href="./favicon/favicon.ico">
   <title>Sign Up</title>
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <style>
       body {
           display: flex;
           align-items: center;
           justify-content: center;
           min-height: 100vh;
           margin: 0;
           background: linear-gradient(to right, #36d1dc, #5b86e5);
           color: #fff;
           font-family: Arial, sans-serif;
       }
       .container {
           max-width: 400px;
           padding: 30px;
           background: #333;
           border-radius: 10px;
           box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.3);
       }
       h1 {
           text-align: center;
           margin-bottom: 20px;
           color: #ffffff;
       }
       .btn-primary {
           width: 100%;
           transition: background-color 0.3s ease;
       }
       .btn-primary:hover {
           background-color: #2a7abf;
       }
       .feedback {
           color: #ffffff;
           display: none;
       }
   </style>
</head>
<body>
   <div class="container">
       <h1>Sign Up</h1>
       <form id="signupForm" novalidate>
           <div class="form-group">
               <label for="fullname">Full Name</label>
               <input type="text" name="fullname" class="form-control" id="fullname" placeholder="Please enter full name" required>
               <small class="feedback">Full name is required.</small>
           </div>
           <div class="form-group">
               <label for="username">Username</label>
               <input type="text" name="username" class="form-control" id="username" placeholder="Enter a unique username" required>
               <small class="feedback">Username is required.</small>
           </div>
           <div class="form-group">
               <label for="password">Password</label>
               <input type="password" name="password" class="form-control" id="password" placeholder="Create a secure password" required>
               <small class="feedback">Password is required.</small>
           </div>
           <button type="submit" class="btn btn-primary">Sign Up</button>
       </form>
   </div>
   <script>
       $(document).ready(function () {
           const validateForm = () => {
               let valid = true;
               $('.feedback').hide();
               $('#signupForm input[required]').each(function () {
                   if (!$(this).val()) {
                       $(this).next('.feedback').show();
                       valid = false;
                   }
               });
               return valid;
           };
           const hashPassword = (password) => {
               return CryptoJS.SHA256(password).toString();
           };
           $('#signupForm').on('submit', function (e) {
               e.preventDefault();
               if (validateForm()) {
                   const formData = new FormData();
                   formData.append('full_name', $('#fullname').val());
                   formData.append('username', $('#username').val());
                   formData.append('password', $('#password').val());
                   $.ajax({
                       url: './api/signup.php',
                       type: 'POST',
                       data: formData,
                       contentType: false,
                       processData: false,
                       success: function () {
                           alert('Account created successfully!');
                        //   window.location.href = 'index.php';
                       },
                       error: function () {
                           alert('Error creating account. Please try again.');
                       }
                   });
               }
           });
       });
   </script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
</body>
</html>





