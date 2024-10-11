<?php
// Koneksi database
include 'koneksi.php'; // Pastikan ini adalah koneksi database Anda

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ambil ID dari parameter URL dan pastikan itu adalah integer

    // Persiapkan dan eksekusi query delete
    $stmt = $conn->prepare("DELETE FROM siswa WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman daftar
        header("Location: list_siswa.php");
        exit(); // Pastikan script berhenti setelah pengalihan
    } else {
        // Jika gagal, tampilkan pesan error
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
} else {
    echo "ID tidak ditemukan.";
}

$conn->close();
