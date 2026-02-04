<?php
include 'koneksi_azam.php';

if (!isset($_GET['id'])) {
    die("ID tidak ditemukan");
}

$id = $_GET['id'];

mysqli_query($conn, "DELETE FROM nilai_azam WHERE id_nilai='$id'");

header("Location: read_azam.php");
exit;
