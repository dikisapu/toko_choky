<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_toko_choky";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
