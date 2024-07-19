<?php
include ('proses_connect_database.php');
session_start();

$response = array('success' => false, 'message' => 'Terjadi kesalahan yang tidak diketahui');

try {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nama_pemesan = $_POST['nama_pemesan'];
        $nomor_meja = $_POST['nomor_meja'];
        $total_bayar = $_POST['total_bayar'];
        $menu_pesanan = json_decode($_POST['menu_pesanan'], true);
        $id_user = $_SESSION['user_id'];
        $no_pesanan = $_POST['no_pesanan'];

        // Insert into Pemesanan table
        $tgl_pesan = date("Y-m-d H:i:s");
        $sql = "INSERT INTO Pemesanan (no_pesanan, total_bayar, tgl_pesan, nama_pemesan, nomor_meja, id_user) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Error preparing statement: " . $conn->error);
        }
        $stmt->bind_param('sdssii', $no_pesanan, $total_bayar, $tgl_pesan, $nama_pemesan, $nomor_meja, $id_user);

        if ($stmt->execute()) {
            $id_pemesanan = $stmt->insert_id;

            // Insert into detail_pesanan table
            foreach ($menu_pesanan as $menu) {
                $id_menu = $menu['id_menu'];
                $jumlah = $menu['jumlah'];

                $sql = "INSERT INTO detail_pesanan (id_menu, id_pemesanan, jumlah) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param('iii', $id_menu, $id_pemesanan, $jumlah);
                if (!$stmt->execute()) {
                    throw new Exception("Error executing statement: " . $stmt->error);
                }

                // Update stok menu
                $sql = "UPDATE Menu SET stok = stok - ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                if (!$stmt) {
                    throw new Exception("Error preparing statement: " . $conn->error);
                }
                $stmt->bind_param('ii', $jumlah, $id_menu);
                if (!$stmt->execute()) {
                    throw new Exception("Error executing statement: " . $stmt->error);
                }
            }

            $response['success'] = true;
            $response['message'] = 'Pemesanan berhasil dibuat';
        } else {
            throw new Exception("Error executing statement: " . $stmt->error);
        }

        $stmt->close();
    }
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);