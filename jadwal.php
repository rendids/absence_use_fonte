<?php
include 'koneksi.php'; // Pastikan sudah terkoneksi dengan database

// Ambil data jadwal dari database
$query = "SELECT * FROM batas_waktu WHERE id = 1"; // Ganti sesuai kebutuhan, misalnya mengambil data dengan id tertentu
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $jam_masuk = $row['jam_masuk'];
    $batas_jam_masuk = $row['batas_jam_masuk'];
    $jam_pulang = $row['jam_pulang'];
    $batas_jam_pulang = $row['batas_jam_pulang'];
} else {
    // Jika tidak ada data jadwal, set default value
    $jam_masuk = "07:00:00";
    $batas_jam_masuk = "08:30:00";
    $jam_pulang = "15:00:00";
    $batas_jam_pulang = "16:00:00";
}

// Proses Update Jadwal
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jam_masuk = $_POST['jam_masuk'];
    $batas_jam_masuk = $_POST['batas_jam_masuk'];
    $jam_pulang = $_POST['jam_pulang'];
    $batas_jam_pulang = $_POST['batas_jam_pulang'];

    // Update ke database
    $update_query = "UPDATE batas_waktu SET 
                     jam_masuk = '$jam_masuk', 
                     batas_jam_masuk = '$batas_jam_masuk', 
                     jam_pulang = '$jam_pulang', 
                     batas_jam_pulang = '$batas_jam_pulang' 
                     WHERE id = 1"; // Update berdasarkan id jadwal

    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Jadwal berhasil diperbarui');</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan Jadwal</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2>Pengaturan Jadwal Masuk & Pulang</h2>
    <form method="POST" action="jadwal.php">
        <div class="mb-3">
            <label for="jam_masuk" class="form-label">Jam Masuk</label>
            <input type="time" class="form-control" id="jam_masuk" name="jam_masuk" value="<?php echo $jam_masuk; ?>" required>
        </div>
        <div class="mb-3">
            <label for="batas_jam_masuk" class="form-label">Batas Jam Masuk</label>
            <input type="time" class="form-control" id="batas_jam_masuk" name="batas_jam_masuk" value="<?php echo $batas_jam_masuk; ?>" required>
        </div>
        <div class="mb-3">
            <label for="jam_pulang" class="form-label">Jam Pulang</label>
            <input type="time" class="form-control" id="jam_pulang" name="jam_pulang" value="<?php echo $jam_pulang; ?>" required>
        </div>
        <div class="mb-3">
            <label for="batas_jam_pulang" class="form-label">Batas Jam Pulang</label>
            <input type="time" class="form-control" id="batas_jam_pulang" name="batas_jam_pulang" value="<?php echo $batas_jam_pulang; ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
