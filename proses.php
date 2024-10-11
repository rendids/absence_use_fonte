<?php
include 'koneksi.php';
include('gateway.php');

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Capture and sanitize form inputs
    $nama = htmlspecialchars($_POST['nama']);
    $password = htmlspecialchars($_POST['password']);
    $nisn = htmlspecialchars($_POST['nisn']);
    $email = htmlspecialchars($_POST['email']);
    $kelas = htmlspecialchars($_POST['kelas']);
    $absen = htmlspecialchars($_POST['absen']);
    $telepon = htmlspecialchars($_POST['telepon']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $rfid = htmlspecialchars($_POST['rfid']);

    // $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO siswa (nama, nisn, email, kelas, absen, telepon, alamat, rfid) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nama, $nisn, $email, $kelas, $absen, $telepon, $alamat, $rfid);



    $stmt->execute();

    // Check for errors
    if ($stmt->error) {
        echo "Error: " . $stmt->error;
    } else {
        echo "New record created successfully";

        $message = "🎉 Selamat, $nama! 🎉 Anda telah berhasil mendaftar sebagai siswa baru di sekolah kami! 📚 \n\n✨ NISN: $nisn \n🏫 Kelas: $kelas \n🔢 Nomor Absen: $absen \n📧 Email: $email \n🏡 Alamat: $alamat \n🔑 RFID: $rfid \n\n🌟 Selamat bergabung di keluarga besar sekolah kami! Bersiaplah untuk petualangan belajar yang seru! 🌟";

        // Send WhatsApp notification
        if (kirim_notifikasi_wa($telepon, $message)) {
            echo "Notification sent successfully.";
        } else {
            echo "Failed to send notification.";
        }
        header("Location: list_siswa.php");
    }

    // Close the statement
    $stmt->close();
}
