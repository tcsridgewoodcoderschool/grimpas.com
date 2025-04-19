<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sign Up / Login Form</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
	<div class="container mt-5">
		<a href="../public">‹ Back to Samples</a>
		<hr/>
		<!-- Sign Up Form -->
		<div class="card mb-4">
			<div class="card-header">Sign Up</div>
			<div class="card-body">
				<form id="signupForm">
					<div class="mb-3">
						<label for="fullName" class="form-label">Full Name</label>
						<input type="text" class="form-control" id="fullName" name="fullName" required>
					</div>
					<div class="mb-3">
						<label for="username" class="form-label">Username</label>
						<input type="text" class="form-control" id="username" name="username" required>
					</div>
					<div class="mb-3">
						<label for="password" class="form-label">Password</label>
						<input type="password" class="form-control" id="password" name="password" required>
					</div>
					<button type="submit" class="btn btn-primary">Sign Up</button>
				</form>
			</div>
		</div>

		<!-- Login Form -->
		<div class="card">
			<div class="card-header">Login</div>
			<div class="card-body">
				<form id="loginForm">
					<div class="mb-3">
						<label for="loginUsername" class="form-label">Username</label>
						<input type="text" class="form-control" id="loginUsername" name="username" required>
					</div>
					<div class="mb-3">
						<label for="loginPassword" class="form-label">Password</label>
						<input type="password" class="form-control" id="loginPassword" name="password" required>
					</div>
					<button type="submit" class="btn btn-primary">Login</button>
				</form>
			</div>
		</div>
	</div>

	<script>
		// jQuery for sign up form
		$('#signupForm').on('submit', function(e) {
			e.preventDefault();
			var signupData = {
				fullName: $('#fullName').val(),
				username: $('#username').val(),
				password: $('#password').val()
			};

			$.ajax({
				type: 'POST',
				url: '../signup.php',
				data: signupData,
				success: function(response) {
					alert('Sign up successful: ' + response);
				},
				error: function(xhr, status, error) {
					alert('Sign up failed: ' + error);
				}
			});
		});

		// jQuery for login form
		$('#loginForm').on('submit', function(e) {
			e.preventDefault();
			var loginData = {
				username: $('#loginUsername').val(),
				password: $('#loginPassword').val()
			};

			$.ajax({
				type: 'POST',
				url: '..//login.php',
				data: loginData,
				success: function(response) {
					alert('Login successful: ' + response);
				},
				error: function(xhr, status, error) {
					alert('Login failed: ' + error);
				}
			});
		});
	</script>
</body>
</html>
