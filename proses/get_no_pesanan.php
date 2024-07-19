<?php
include ('proses_connect_database.php');

$tgl_pesan = date("Y-m-d");
$date_part = date("dmy");
$sql = "SELECT COUNT(*) as count FROM Pemesanan WHERE DATE(tgl_pesan) = CURDATE()";
$result = $conn->query($sql);
$count = $result->fetch_assoc()['count'] + 1;
$no_pesanan = $date_part . str_pad($count, 3, '0', STR_PAD_LEFT);

echo json_encode(['no_pesanan' => $no_pesanan]);

$conn->close();