<?php
session_start();
include ('proses_connect_database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM User WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['nama'];
        $_SESSION['user_jabatan'] = $row['jabatan'];
        header("Location: ../dashboard.php");
    } else {
        echo "Email atau Password salah";
    }
}
