<?php
date_default_timezone_set('Asia/Jakarta');

$server = "localhost";
$usname = "root";
$pass = "";
$database = "register";

$conn = new mysqli($server, $usname, $pass, $database);

if ($conn->error) {
    die("koneksi gagal: " . $conn->connect_error);
}
