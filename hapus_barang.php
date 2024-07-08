<?php
include 'config.php';

$barang_id = $_GET['id'];
$sql = "DELETE FROM barang WHERE barang_id='$barang_id'";

if ($conn->query($sql) === TRUE) {
    echo "Data berhasil dihapus";
    header('Location: barang.php');
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
