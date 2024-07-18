<?php
session_start(); // Pastikan session dimulai
include ('proses_connect_database.php');

$response = array('success' => false, 'message' => 'Terjadi kesalahan yang tidak diketahui');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $deskripsi = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $stok = $_POST['stok'];
    $user_id = $_SESSION['user_id']; // Ambil user_id dari session

    // Check if the menu name already exists for another menu
    $sql_check = "SELECT id FROM Menu WHERE nama = ? AND id != ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param('si', $nama, $id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $response['message'] = 'Nama menu sudah digunakan oleh menu lain';
    } else {
        $sql = "UPDATE Menu SET nama=?, deskripsi=?, harga=?, stok=?, id_user=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdiis', $nama, $deskripsi, $harga, $stok, $user_id, $id);

        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = 'Data berhasil diperbarui';
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
?>