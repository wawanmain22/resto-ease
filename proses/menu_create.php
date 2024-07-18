<?php
session_start();
include ('proses_connect_database.php');

$response = array('success' => false, 'message' => 'Terjadi kesalahan yang tidak diketahui');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $id_user = $_SESSION['user_id']; // Ambil id_user dari session

    // Check if the menu name already exists
    $sql_check = "SELECT id FROM Menu WHERE nama = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('s', $nama);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $response['message'] = 'Nama menu sudah digunakan';
    } else {
        $sql = "INSERT INTO Menu (nama, deskripsi, harga, stok, id_user) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdii', $nama, $deskripsi, $harga, $stok, $id_user);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Data berhasil ditambahkan';
        } else {
            $response['message'] = 'Error: ' . $stmt->error;
        }
    }

    $stmt_check->close();
    $stmt->close();
    $conn->close();
}

header('Content-Type: application/json');
echo json_encode($response);