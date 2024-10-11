<?php
include 'koneksi.php';
include 'gateway.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfid = $_POST['rfid'];
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s");

    $query = "SELECT * FROM siswa where rfid = '$rfid'";
    $result_siswa = mysqli_query($conn, $query);

    if (mysqli_num_rows($result_siswa) > 0) {
        $siswa = mysqli_fetch_assoc($result_siswa);
        $id_siswa = $siswa['id'];
        $telepon = $siswa['telepon'];
        $nama = $siswa['nama'];
        $formatTanggal = date('d-m-Y', strtotime($tanggal));
        $query_absen = "SELECT * FROM absensi WHERE id_siswa = '$id_siswa' AND tanggal = '$tanggal'";
        $result_absen = mysqli_query($conn, $query_absen);

        if (mysqli_num_rows($result_absen) == 0) {
            $insert_query = "INSERT INTO absensi (id_siswa, tanggal, waktu_masuk, status_masuk) VALUE('$id_siswa', '$tanggal', '$waktu', 'Hadir')";
            if (mysqli_query($conn, $insert_query)) {
                echo "Absensi Masuk Berhasil tercatat!";
                $message = "🚨 Pemberitahuan Kehadiran! 🚨 \n\n👤 Siswa: *$nama* telah *HADIR* pada tanggal *$formatTanggal*, pukul *$waktu*. \n\n🌟 Terima kasih telah datang! Mari kita buat hari ini menyenangkan! 🎉";

                // Send WhatsApp notification
                kirim_notifikasi_wa($telepon, $message);
            } else {
                echo "Error:" . mysqli_error($conn);
            }
        } else {
            $update_query = "UPDATE absensi SET waktu_pulang = '$waktu', status_pulang = 'Pulang' WHERE id_siswa = '$id_siswa' AND tanggal = '$tanggal'";
            if (mysqli_query($conn, $update_query)) {
                echo " Absensi Pulang Berhasil Tercatat";
                $message = "🚨 Pemberitahuan Pulang! 🚨 \n\n👤 Siswa: *$nama* telah *PULANG* pada tanggal *$formatTanggal*, pukul *$waktu*. \n\n🔔 Semoga perjalanan pulang lancar dan sampai jumpa besok! 🌟";

                // Send WhatsApp notification
                kirim_notifikasi_wa($telepon, $message);
            } else {
                echo "Error:" . mysqli_error($conn);
            }
        }
    } else {
        echo " RFID Tidak Ditemukan";
    }
}
