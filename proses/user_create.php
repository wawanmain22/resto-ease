<?php
include ('proses_connect_database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $sql = "INSERT INTO User (email, password, nama, jabatan, no_hp, alamat) VALUES ('$email', '$password', '$nama', '$jabatan', '$no_hp', '$alamat')";
    if ($conn->query($sql) === TRUE) {
        $response = [
            'success' => true,
            'message' => 'Data berhasil ditambahkan'
        ];
    } else {
        $response = [
            'success' => false,
            'message' => 'Error: ' . $sql . '<br>' . $conn->error
        ];
    }

    echo json_encode($response);
    $conn->close();
}
?>