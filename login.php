<?php
session_start(); // Start the session as early as possible
include 'koneksi.php'; // Include database connection file

// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs to avoid SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Query to check the user credentials
    $query = "SELECT * FROM admin WHERE user = '$username'";
    $result = $conn->query($query);

    // Check if the user exists
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $data['password'])) {
            // Start a session for the logged-in user
            $_SESSION['id_admin'] = $data['id_admin'];
            $_SESSION['user'] = $data['user'];
            $_SESSION['level'] = $data['level'];

            // Redirect based on user level (Admin or Operator)
            if ($data['level'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit(); // Make sure to call exit to stop script execution
            } elseif ($data['level'] === 'operator') {
                header("Location: operator_dashboard.php");
                exit();
            }
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* Custom styles for centering the login form */
        .login-container {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <div class="card" style="width: 100%; max-width: 400px;">
            <div class="card-body">
                <h5 class="card-title text-center">Login</h5>

                <!-- Login Form -->
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <?php 
                // Display error messages
                if (isset($error)) {
                    echo "<div class='alert alert-danger mt-3'>$error</div>";
                }
                ?>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
