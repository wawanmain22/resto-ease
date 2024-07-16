<?php
include ('proses_connect_database.php');

$response = array('success' => false, 'message' => 'Terjadi kesalahan yang tidak diketahui');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    // Validasi email yang sudah ada
    $sql_check_email = "SELECT id FROM User WHERE email = ?";
    $stmt = $conn->prepare($sql_check_email);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $response['message'] = 'Email sudah terdaftar';
    } else {
        // Lanjutkan dengan penambahan user baru
        $sql = "INSERT INTO User (email, password, nama, jabatan, no_hp, alamat) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssss', $email, $password, $nama, $jabatan, $no_hp, $alamat);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Data berhasil ditambahkan';
        } else {
            $response['message'] = 'Error: ' . $stmt->error;
        }
    }
    $stmt->close();
}

$conn->close();
echo json_encode($response);
