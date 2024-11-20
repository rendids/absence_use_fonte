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

    // Query to delete the admin
    $delete_query = "DELETE FROM admin WHERE id_admin = '$id'";

    if ($conn->query($delete_query)) {
        header("Location: admin_list.php"); // Redirect to the admin list after deletion
        exit();
    } else {
        echo "Error deleting admin.";
    }
} else {
    header("Location: admin_list.php"); // If ID is not provided, redirect to list
    exit();
}
?>
