<?php
include ('proses_connect_database.php');

$response = array('success' => false, 'message' => 'Terjadi kesalahan yang tidak diketahui');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = isset($_POST['id']) ? $_POST['id'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $nama = isset($_POST['nama']) ? $_POST['nama'] : '';
    $jabatan = isset($_POST['jabatan']) ? $_POST['jabatan'] : '';
    $no_hp = isset($_POST['no_hp']) ? $_POST['no_hp'] : '';
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';

    // Debugging: log data yang diterima
    error_log("ID: $id, Email: $email, Nama: $nama, Jabatan: $jabatan, No HP: $no_hp, Alamat: $alamat");

    if (empty($id) || empty($email) || empty($nama) || empty($jabatan) || empty($no_hp) || empty($alamat)) {
        $response['message'] = 'Semua field wajib diisi.';
    } else {
        // Check if the email already exists for another user
        $sql_check_email = "SELECT id FROM User WHERE email = ? AND id != ?";
        $stmt_check_email = $conn->prepare($sql_check_email);
        $stmt_check_email->bind_param('si', $email, $id);
        $stmt_check_email->execute();
        $result_check_email = $stmt_check_email->get_result();

        if ($result_check_email->num_rows > 0) {
            $response['message'] = 'Email sudah digunakan oleh pengguna lain.';
        } else {
            if (isset($_POST['password']) && !empty($_POST['password'])) {
                $password = $_POST['password'];
                $sql = "UPDATE User SET email='$email', password='$password', nama='$nama', jabatan='$jabatan', no_hp='$no_hp', alamat='$alamat' WHERE id='$id'";
            } else {
                $sql = "UPDATE User SET email='$email', nama='$nama', jabatan='$jabatan', no_hp='$no_hp', alamat='$alamat' WHERE id='$id'";
            }

            if ($conn->query($sql) === TRUE) {
                $response['success'] = true;
                $response['message'] = 'Data berhasil diperbarui';
            } else {
                $response['message'] = 'Error: ' . $conn->error;
                error_log("MySQL Error: " . $conn->error); // Log error MySQL
            }
        }

        $stmt_check_email->close();
    }

    $conn->close();
}

header('Content-Type: application/json');
echo json_encode($response);