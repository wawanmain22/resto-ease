<?php
session_start();
include ('proses_connect_database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Gunakan prepared statements untuk keamanan
    $sql = "SELECT id, nama, jabatan FROM User WHERE email = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['nama'];
        $_SESSION['user_jabatan'] = $row['jabatan'];
        header("Location: ../dashboard.php");
    } else {
        echo "Email atau Password salah";
    }

    $stmt->close();
    $conn->close();
}