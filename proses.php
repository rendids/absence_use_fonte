<?php
include 'koneksi.php';
include('gateway.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Capture and sanitize form inputs
    $nama = htmlspecialchars($_POST['nama']);
    $nisn = htmlspecialchars($_POST['nisn']);
    $email = htmlspecialchars($_POST['email']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $absen = htmlspecialchars($_POST['absen']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $rfid = htmlspecialchars($_POST['rfid']);

    // Check database connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO siswa (nama, nisn, email, kelas, absen, tlpn, alamat, rfid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die('MySQL prepare failed: ' . $conn->error);
    }

    $stmt->bind_param("ssssssss", $nama, $nisn, $email, $kelas, $absen, $telepon, $alamat, $rfid);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully";

        // Send notification
        $message = "🎉 Selamat, $nama! 🎉 Anda telah berhasil mendaftar sebagai siswa baru di sekolah kami! 📚 \n\n✨ NISN: $nisn \n🏫 Kelas: $kelas \n🔢 Nomor Absen: $absen \n📧 Email: $email \n🏡 Alamat: $alamat \n🔑 RFID: $rfid \n\n🌟 Selamat bergabung di keluarga besar sekolah kami! Bersiaplah untuk petualangan belajar yang seru! 🌟";

        if (kirim_notifikasi_wa($telepon, $message)) {
            echo "Notification sent successfully.";
        } else {
            echo "Failed to send notification.";
        }

        // Redirect
        header("Location: list_siswa.php");
        exit;
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}
?>
