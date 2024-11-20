<?php 
session_start();

// Ensure user is logged in and has admin privileges
if (!isset($_SESSION['id_admin']) || $_SESSION['level'] !== 'admin') {
    header("Location: login.php"); // Redirect to login if not logged in or not admin
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">Admin Dashboard</h3>
            <p>Selamat Datang, <?php echo $_SESSION['user']; ?>! <br> Anda login sebagai Admin.</p>
            
            <!-- Logout Button -->
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
