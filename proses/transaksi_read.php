<?php
include ('proses_connect_database.php');

$response = array('success' => false, 'message' => 'Terjadi kesalahan yang tidak diketahui');

if (isset($_GET['id'])) {
    $id_pemesanan = $_GET['id'];

    // Fetch transaksi
    $sql = "SELECT * FROM Pemesanan WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id_pemesanan);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaksi = $result->fetch_assoc();

    if ($transaksi) {
        $response['transaksi'] = $transaksi;

        // Fetch detail_pesanan
        $sql = "SELECT dp.jumlah, m.nama as nama_menu, m.harga, (dp.jumlah * m.harga) as subtotal
                FROM Detail_Pesanan dp
                JOIN Menu m ON dp.id_menu = m.id
                WHERE dp.id_pemesanan = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id_pemesanan);
        $stmt->execute();
        $result = $stmt->get_result();
        $detail_pesanan = $result->fetch_all(MYSQLI_ASSOC);

        $response['detail_pesanan'] = $detail_pesanan;
        $response['success'] = true;
    } else {
        $response['message'] = 'Transaksi tidak ditemukan';
    }

    $stmt->close();
}

$conn->close();

header('Content-Type: application/json');
echo json_encode($response);