<?php 
session_start();

// Ensure user is logged in and has admin privileges
if (!isset($_SESSION['id_admin']) || $_SESSION['level'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not logged in or not admin
    exit();
}

include 'koneksi.php'; // Include database connection file

// Check if ID is passed via GET
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Query to fetch admin data
    $query = "SELECT * FROM admin WHERE id_admin = '$id'";
    $result = $conn->query($query);
    $data = $result->fetch_assoc();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get the form data
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $level = mysqli_real_escape_string($conn, $_POST['level']); // Get level from form

        // If password is provided, hash it
        if (!empty($password)) {
            $password_hashed = password_hash($password, PASSWORD_DEFAULT);
            $update_query = "UPDATE admin SET user = '$username', password = '$password_hashed', level = '$level' WHERE id_admin = '$id'";
        } else {
            // If password is empty, do not update the password
            $update_query = "UPDATE admin SET user = '$username', level = '$level' WHERE id_admin = '$id'";
        }

        // Execute the update query
        if ($conn->query($update_query)) {
            header("Location: admin_list.php"); // Redirect to the list of admins after successful update
            exit();
        } else {
            $error = "Error updating admin.";
        }
    }
} else {
    header("Location: admin_list.php"); // If ID is not provided, redirect to list
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-5">
    <h3>Edit Admin</h3>

    <!-- Display error message if any -->
    <?php if (isset($error)) : ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <!-- Edit Form -->
    <form method="POST" action="">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" value="<?php echo $data['user']; ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">New Password (Leave empty if no change)</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>

        <div class="mb-3">
            <label for="level" class="form-label">Level</label>
            <select class="form-select" id="level" name="level" required>
                <option value="admin" <?php echo ($data['level'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                <option value="operator" <?php echo ($data['level'] === 'operator') ? 'selected' : ''; ?>>Operator</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update Admin</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
