<?php
session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "egallery";
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("koneksi gagal: " . $conn->connect_error);
}
?>