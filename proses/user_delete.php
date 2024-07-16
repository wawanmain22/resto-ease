<?php
include ('proses_connect_database.php');

$response = array('success' => false, 'message' => 'Terjadi kesalahan yang tidak diketahui');

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM User WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        $response['success'] = true;
        $response['message'] = 'Data berhasil dihapus';
    } else {
        $response['message'] = 'Error: ' . $stmt->error;
        error_log("MySQL Error: " . $stmt->error); // Log error MySQL
    }

    $stmt->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);