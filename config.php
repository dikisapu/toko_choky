<?php
$servername = "localhost";
$username = "u611836069_db_toko_choky";
$password = "nc+z9o$Ja";
$dbname = "u611836069_db_toko_choky";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
