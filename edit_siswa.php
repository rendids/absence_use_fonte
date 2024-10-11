<?php
// Koneksi database
include 'koneksi.php'; // Pastikan ini adalah koneksi database Anda

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ambil ID dari parameter URL dan pastikan itu adalah integer

    // Ambil data yang ada dari database
    $stmt = $conn->prepare("SELECT * FROM siswa WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $nama = htmlspecialchars($row['nama']);
        $nisn = htmlspecialchars($row['nisn']);
        $email = htmlspecialchars($row['email']);
        $kelas = htmlspecialchars($row['kelas']);
        $absen = htmlspecialchars($row['absen']);
        $telepon = htmlspecialchars($row['telepon']);
        $alamat = htmlspecialchars($row['alamat']);
        $rfid = htmlspecialchars($row['rfid']);
    } else {
        echo "Data tidak ditemukan.";
        exit;
    }

    $stmt->close();
} else {
    echo "ID tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px;
    }

    h1 {
        text-align: center;
        color: #333;
    }

    form {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin: 10px 0 5px;
    }

    input[type="text"],
    input[type="email"],
    input[type="number"],
    textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background-color: #5cb85c;
        color: white;
        padding: 10px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
    }

    input[type="submit"]:hover {
        background-color: #4cae4c;
    }
    </style>
</head>

<body>
    <h1>Edit Data Siswa</h1>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>">
        <label for="nama">Nama:</label>
        <input type="text" id="nama" name="nama" value="<?php echo $nama; ?>" required>
        <label for="nisn">NISN:</label>
        <input type="text" id="nisn" name="nisn" value="<?php echo $nisn; ?>" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $email; ?>" required>
        <label for="kelas">Kelas:</label>
        <input type="text" id="kelas" name="kelas" value="<?php echo $kelas; ?>" required>
        <label for="absen">Absen:</label>
        <input type="text" id="absen" name="absen" value="<?php echo $absen; ?>" required>
        <label for="telepon">Telepon:</label>
        <input type="number" id="telepon" name="telepon" value="<?php echo $telepon; ?>" required>
        <label for="alamat">Alamat:</label>
        <textarea id="alamat" name="alamat" required><?php echo $alamat; ?></textarea>
        <label for="telepon">RFID:</label>
        <input type="number" id="rfid" name="rfid" value="<?php echo $rfid; ?>" required>
        <input type="submit" value="Simpan">
    </form>
</body>

</html>



<?php
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Ambil dan sanitasi input formulir
    $id = intval($_POST['id']);
    $nama = htmlspecialchars($_POST['nama']);
    $nisn = htmlspecialchars($_POST['nisn']);
    $email = htmlspecialchars($_POST['email']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $absen = htmlspecialchars($_POST['absen']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $rfid = htmlspecialchars($_POST['rfid']);

    // Persiapkan dan bind
    $stmt = $conn->prepare("UPDATE siswa SET nama = ?, nisn = ?, email = ?, kelas = ?, absen = ?, telepon = ?, alamat = ?, rfid = ? WHERE id = ?");
    $stmt->bind_param("ssssssssi", $nama, $nisn, $email, $kelas, $absen, $telepon, $alamat, $rfid, $id);

    // Eksekusi statement
    if ($stmt->execute()) {
        echo "Data berhasil diperbarui.";
        header("Location: list_siswa.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Tutup statement
    $stmt->close();
}
?>