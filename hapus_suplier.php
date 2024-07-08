<?php
include 'config.php';

$kode_suplier = $_GET['kode_suplier'];
$sql = "DELETE FROM suplier WHERE kode_suplier='$kode_suplier'";

if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
    header('Location: suplier.php');
} else {
    echo "Error deleting record: " . $conn->error;
}

$conn->close();
