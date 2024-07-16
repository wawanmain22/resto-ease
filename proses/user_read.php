<?php
include ('proses_connect_database.php');

$response = array('success' => false, 'message' => 'Terjadi kesalahan yang tidak diketahui');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT email, nama, jabatan, no_hp, alamat FROM User WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        $response['message'] = 'Prepare failed: ' . $conn->error;
    } else {
        $stmt->bind_param('i', $id);
        if ($stmt->execute()) {
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $response = $result->fetch_assoc();
                $response['success'] = true;
            } else {
                $response['message'] = 'User tidak ditemukan';
            }
        } else {
            $response['message'] = 'Execute failed: ' . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
echo json_encode($response);