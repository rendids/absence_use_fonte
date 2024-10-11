<?php
include 'koneksi.php';

// Query SQL
$sql = "SELECT a.*, s.nama FROM absensi a INNER JOIN siswa s ON a.id_siswa = s.id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
    body {
        font-family: 'Roboto', sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 20px;
    }

    h1 {
        color: #333;
        text-align: center;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }

    th {
        background-color: #4CAF50;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    tr:hover {
        background-color: #ddd;
    }

    .action-buttons {
        display: flex;
        justify-content: space-around;
    }

    .edit-button,
    .delete-button {
        text-decoration: none;
        padding: 5px 10px;
        border-radius: 4px;
        color: white;
    }

    .edit-button {
        background-color: #007BFF;
    }

    .delete-button {
        background-color: #FF5733;
    }

    a {
        display: block;
        text-align: center;
        margin: 20px auto;
        padding: 10px 15px;
        background-color: #28a745;
        color: white;
        text-decoration: none;
        border-radius: 5px;
        width: 150px;
    }

    a:hover {
        background-color: #218838;
    }
    </style>
</head>

<body>
    <h1>Daftar Absensi</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>NAMA SISWA</th>
                <th>TANGGAL</th>
                <th>WAKTU MASUK</th>
                <th>STATUS MASUK</th>
                <th>WAKTU PULANG</th>
                <th>STATUS PULANG</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $id = 1;
                // Menampilkan data dari query
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $id . "</td>";
                    echo "<td>" . $row['nama'] . "</td>";
                    echo "<td>" . $row['tanggal'] . "</td>";
                    echo "<td>" . $row['waktu_masuk'] . "</td>";
                    echo "<td>" . $row['status_masuk'] . "</td>";
                    echo "<td>" . $row['waktu_pulang'] . "</td>";
                    echo "<td>" . $row['status_pulang'] . "</td>";
                    echo "</tr>";
                    $id++; // Increment id for the next row
                }
            } else {
                echo "<tr><td colspan='11'>Tidak ada data</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</body>

</html>