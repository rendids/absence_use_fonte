<?php
include 'koneksi.php';
include 'gateway.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rfid = $_POST['rfid'];
    $tanggal = date("Y-m-d");
    $waktu = date("H:i:s");

    // Query untuk mendapatkan informasi jam masuk dan jam pulang
    $query_jam = "SELECT * FROM batas_waktu WHERE id = 1"; // Misalnya mengambil jadwal tertentu
    $result = mysqli_query($conn, $query_jam);


    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $jam_masuk = $row['jam_masuk'];
        $batas_jam_masuk = $row['batas_jam_masuk'];
        $jam_pulang = $row['jam_pulang'];
        $batas_jam_pulang = $row['batas_jam_pulang'];
    } else {
        echo "Error: Jadwal tidak ditemukan.";
        exit;
    }

    // Query untuk mendapatkan data siswa berdasarkan RFID
    $query_siswa = "SELECT * FROM siswa WHERE rfid = '$rfid'";
    $result_siswa = mysqli_query($conn, $query_siswa);

    if (mysqli_num_rows($result_siswa) > 0) {
        $siswa = mysqli_fetch_assoc($result_siswa);
        $id_siswa = $siswa['id'];
        $telepon = $siswa['tlpn'];
        $nama = $siswa['nama'];
        $formatTanggal = date('d-m-Y', strtotime($tanggal));

        // Cek apakah siswa sudah absen pada hari ini
        $query_absen = "SELECT * FROM absensi WHERE id_siswa = '$id_siswa' AND tanggal = '$tanggal'";
        $result_absen = mysqli_query($conn, $query_absen);

        if (mysqli_num_rows($result_absen) == 0) {
            // Absensi Masuk: Cek apakah waktu masuk valid
            if ($waktu >= $jam_masuk && $waktu <= $batas_jam_masuk) {
                // Jika waktu masuk berada di antara jam_masuk dan batas_jam_masuk
                $insert_query = "INSERT INTO absensi (id_siswa, tanggal, waktu_masuk, status_masuk) 
                                 VALUES('$id_siswa', '$tanggal', '$waktu', 'Hadir')";
                if (mysqli_query($conn, $insert_query)) {
                    echo "Absensi Masuk Berhasil tercatat!";
            
                    // Kirim notifikasi WA
                    $message = "🚨 Pemberitahuan Kehadiran! 🚨 \n\n👤 Siswa: *$nama* telah *HADIR* pada tanggal *$formatTanggal*, pukul *$waktu*. \n\n🌟 Terima kasih telah datang! Mari kita buat hari ini menyenangkan! 🎉";
                    kirim_notifikasi_wa($telepon, $message);
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } elseif ($waktu > $batas_jam_masuk) {
                // Jika waktu absen melebihi batas jam_masuk, status menjadi 'Terlambat'
                $insert_query = "INSERT INTO absensi (id_siswa, tanggal, waktu_masuk, status_masuk) 
                                 VALUES('$id_siswa', '$tanggal', '$waktu', 'Terlambat')";
                if (mysqli_query($conn, $insert_query)) {
                    echo "Absensi Masuk berhasil, tetapi terlambat!";
            
                    // Kirim notifikasi WA untuk status terlambat
                    $message = "🚨 Pemberitahuan Kehadiran! 🚨 \n\n👤 Siswa: *$nama* telah *TERLAMBAT* pada tanggal *$formatTanggal*, pukul *$waktu*. \n\n⏰ Waktu masuk sudah lewat batas, harap segera menyesuaikan diri! 💪";
                    kirim_notifikasi_wa($telepon, $message);
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Absensi Masuk Ditutup! Waktu absen harus antara $jam_masuk dan $batas_jam_masuk.";
            }
            
        } else {
            // Absensi Pulang: Cek apakah waktu pulang valid
            if ($waktu >= $jam_pulang && $waktu <= $batas_jam_pulang) {
                // Jika waktu pulang berada di antara jam_pulang dan batas_jam_pulang
                $update_query = "UPDATE absensi SET waktu_pulang = '$waktu', status_pulang = 'Pulang' 
                                 WHERE id_siswa = '$id_siswa' AND tanggal = '$tanggal'";
                if (mysqli_query($conn, $update_query)) {
                    echo "Absensi Pulang Berhasil Tercatat";

                    // Kirim notifikasi WA
                    $message = "🚨 Pemberitahuan Pulang! 🚨 \n\n👤 Siswa: *$nama* telah *PULANG* pada tanggal *$formatTanggal*, pukul *$waktu*. \n\n🔔 Semoga perjalanan pulang lancar dan sampai jumpa besok! 🌟";
                    kirim_notifikasi_wa($telepon, $message);
                } else {
                    echo "Error: " . mysqli_error($conn);
                }
            } else {
                echo "Absensi Pulang Ditutup! Waktu pulang harus antara $jam_pulang dan $batas_jam_pulang.";
            }
        }
    } else {
        echo "RFID Tidak Ditemukan";
    }
}
?>
