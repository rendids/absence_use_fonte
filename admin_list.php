<?php 
session_start();

// Ensure user is logged in and has admin privileges
if (!isset($_SESSION['id_admin']) || $_SESSION['level'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not logged in or not admin
    exit();
}

include 'koneksi.php'; // Include database connection file

// Query to get all admins
$query = "SELECT * FROM admin";
$result = $conn->query($query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin List</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>



<div class="container mt-5">
    <h3 class="mb-4">List of Admins</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($data = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo $data['id_admin']; ?></td>
                <td><?php echo $data['user']; ?></td>
                <td><?php echo $data['level']; ?></td>
                <td>
                    <!-- Edit Button -->
                    <a href="edit_admin.php?id=<?php echo $data['id_admin']; ?>" class="btn btn-warning btn-sm">Edit</a>
                    <!-- Delete Button -->
                    <a href="delete_admin.php?id=<?php echo $data['id_admin']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <a href="tambah-admin.php" class="btn btn-primary">Add New Admin</a>
</div>

<!-- Include Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
