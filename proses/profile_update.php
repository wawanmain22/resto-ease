<?php
include ('proses_connect_database.php');

$response = array('success' => false, 'message' => 'Terjadi kesalahan yang tidak diketahui');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $user_id = $_SESSION['user_id'];
    $nama = $_POST['nama'];
    $password = $_POST['password'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    if (empty($password)) {
        $sql = "UPDATE User SET nama = ?, no_hp = ?, alamat = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sssi', $nama, $no_hp, $alamat, $user_id);
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $sql = "UPDATE User SET nama = ?, password = ?, no_hp = ?, alamat = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssi', $nama, $hashed_password, $no_hp, $alamat, $user_id);
    }

    if ($stmt->execute()) {
        $_SESSION['user_name'] = $nama; // Update session with new name
        $response['success'] = true;
        $response['message'] = 'Profil berhasil diperbarui';
        $response['new_name'] = $nama; // Send new name back to client
    } else {
        $response['message'] = 'Gagal memperbarui profil: ' . $stmt->error;
    }

    $stmt->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>
