<?php
session_start();
require './api/conn.php'; // Include your database connection file

// Ensure the user is logged in
if (empty($_SESSION['user'])) {
    // header("Location: /?alert=Please log in first.");
    // exit();
}

// Fetch user data from the database
$userQuery = $conn->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
$userQuery->bind_param("s", $_SESSION['user']);
$userQuery->execute();
$userResult = $userQuery->get_result();

if ($userResult->num_rows === 0) {
    // header("Location: /?alert=User not found.");
    // exit();
}

$userData = $userResult->fetch_assoc();

// Retrieve the profile picture or set a default
$profilePic = !empty($userData['profile_pic']) ? $userData['profile_pic'] : 'uploads/default-profile.png';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./favicon/favicon.ico">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
            max-width: 800px;
        }
        .fa-solid {
            color: white;
            font-size: 30px;
            margin-bottom: 20px;
            transition: color 0.3s ease;
        }
        .fa-solid:hover {
            color: #5865F2;
        }
        h1 {
            color: white;
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-pic {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #5865F2;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
        }
        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        .form-control:focus {
            background: rgba(255, 255, 255, 0.2);
            box-shadow: 0 0 8px rgba(88, 101, 242, 0.6);
        }
        .btn-primary {
            background: #5865F2;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 10px;
            width: 100%;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .btn-primary:hover {
            background: #4752C4;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .col-md-3, .col-md-9 {
            flex: 1;
            min-width: 250px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Back button -->
        <a href="index.php">
            <i class="fa-solid fa-circle-arrow-left"></i>
        </a>

        <h1>Welcome, <?php echo htmlspecialchars($userData['username']); ?></h1>

        <div class="row">
            <div class="col-md-12">
                
                
                <div class="d-flex align-items-start me-5">
                  <div class="nav flex-column nav-pills me-3" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                    <button class="nav-link active" id="v-pills-home-tab" data-bs-toggle="pill" data-bs-target="#v-pills-home" type="button" role="tab" aria-controls="v-pills-home" aria-selected="true">Profile</button>
                    <button class="nav-link" id="v-pills-profile-tab" data-bs-toggle="pill" data-bs-target="#v-pills-profile" type="button" role="tab" aria-controls="v-pills-profile" aria-selected="false">Secutity</button>
                    <button class="nav-link" id="v-pills-messages-tab" data-bs-toggle="pill" data-bs-target="#v-pills-messages" type="button" role="tab" aria-controls="v-pills-messages" aria-selected="false">Friend Code</button>
                  </div>
                  <div class="tab-content" id="v-pills-tabContent">
                    <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                        
                        <!-- Profile picture display -->
                        <h3>Your Profile</h3>
                        
                        <img src="./api/<?php echo htmlspecialchars($profilePic); ?>" class="profile-pic" alt="Profile Picture">
                        
                        <form id="profileForm">
                            <div class="form-group">
                                <label for="fullname">Full Name</label>
                                <input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo htmlspecialchars($userData['full_name']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
                            </div>
                            <div class="form-group  d-none">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="new_password">
                            </div>
                            <div class="form-group  d-none">
                                <label for="confirm_new_password">Confirm New Password</label>
                                <input type="password" name="confirm_new_password" class="form-control" id="confirm_new_password">
                            </div>
                            <div class="form-group">
                                <label>Change Profile Picture</label>
                                <input type="file" name="profile_pic" class="form-control" id="profile_pic">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Profile</button>
                        </form>
                        
                    </div>
                    <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                        
                        <form id="profileForm">
                            <div class="form-group d-none">
                                <label for="fullname">Full Name</label>
                                <input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo htmlspecialchars($userData['full_name']); ?>" required>
                            </div>
                            <div class="form-group d-none">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" id="username" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" name="new_password" class="form-control" id="new_password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_new_password">Confirm New Password</label>
                                <input type="password" name="confirm_new_password" class="form-control" id="confirm_new_password">
                            </div>
                            <div class="form-group  d-none">
                                <label>Change Profile Picture</label>
                                <input type="file" name="profile_pic" class="form-control" id="profile_pic">
                            </div>
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </form>
                        
                    </div>
                    <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                        
                        <form id="friendCodeForm">
                            <div class="form-group">
                                <label for="friend_code">Friend Code</label>
                                <input type="text" name="friend_code" class="form-control" id="friend_code" value="<?php echo htmlspecialchars($userData['friend_code']); ?>" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Friend code</button>
                        </form>
                        
                    </div>
                  </div>
                </div>
                

            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>   
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script>
        // Handle the profile form submission
        $('#profileForm').on('submit', function(e) {
            e.preventDefault();
            var formData = new FormData(this); // Create FormData object to send form data

            // Send the form data to the server
            $.ajax({
                url: './api/update_profile.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === "success") {
                        alert('Profile updated successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                cache: false,
                contentType: false,
                processData: false,
                error: function() {
                    alert('Error submitting form. Please try again.');
                }
            });
        });
        
         // Handle the profile form submission
        $('#friendCodeForm').on('submit', function(e) {
            e.preventDefault();
            var formData = {
                friend_code: $("#friend_code").val()
            }; // Create FormData object to send form data

            // Send the form data to the server
            $.ajax({
                url: './api/update_friend_code.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    var data = JSON.parse(response);
                    if (data.status === "success") {
                        alert('Friend code updated successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                },
                cache: false,
                contentType: false,
                processData: false,
                error: function() {
                    alert('Error submitting form. Please try again.');
                }
            });
        });

        // Handle profile picture preview
        document.getElementById('profile_pic').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.querySelector('.profile-pic').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>