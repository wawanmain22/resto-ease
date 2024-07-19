<?php
include ('proses/proses_connect_database.php');

// Fetch transactions
$sql = "SELECT * FROM Pemesanan";
$result = $conn->query($sql);
$transaksi = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Data Transaksi</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">No. Pesanan</th>
                                <th>Nama Pemesan</th>
                                <th>Nomor Meja</th>
                                <th>Total Bayar</th>
                                <th>Tanggal Pesan</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($transaksi as $index => $transaksiItem): ?>
                            <tr>
                                <td class="text-center"><?= $transaksiItem['no_pesanan'] ?></td>
                                <td><?= $transaksiItem['nama_pemesan'] ?></td>
                                <td><?= $transaksiItem['nomor_meja'] ?></td>
                                <td class="harga"><?= $transaksiItem['total_bayar'] ?></td>
                                <td><?= $transaksiItem['tgl_pesan'] ?></td>
                                <td>
                                    <button type="button" class="btn btn-icon btn-primary detail-transaksi"
                                        data-id="<?= $transaksiItem['id'] ?>" data-toggle="modal"
                                        data-target="#detailModal">Detail</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.detail-transaksi').forEach(button => {
        button.addEventListener('click', function() {
            const id = button.getAttribute('data-id');

            fetch('proses/transaksi_read.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const transaksi = data.transaksi;
                        const detailPesanan = data.detail_pesanan;

                        document.getElementById('detailNoPesanan').textContent = transaksi
                            .no_pesanan;
                        document.getElementById('detailNamaPemesan').textContent = transaksi
                            .nama_pemesan;
                        document.getElementById('detailNomorMeja').textContent = transaksi
                            .nomor_meja;
                        document.getElementById('detailTotalBayar').textContent =
                            formatHarga(transaksi.total_bayar);
                        document.getElementById('detailTglPesan').textContent = transaksi
                            .tgl_pesan;

                        const detailTableBody = document.getElementById('detailTableBody');
                        detailTableBody.innerHTML = '';
                        detailPesanan.forEach(item => {
                            const row = document.createElement('tr');
                            row.innerHTML =
                                `<td>${item.nama_menu}</td><td class="harga">${formatHarga(item.harga)}</td><td>${item.jumlah}</td><td class="harga">${formatHarga(item.subtotal)}</td>`;
                            detailTableBody.appendChild(row);
                        });
                    } else {
                        console.error(data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        });
    });

    // Format harga di tabel transaksi
    document.querySelectorAll('.harga').forEach(function(element) {
        element.textContent = formatHarga(element.textContent);
    });

    $('#table-1').DataTable();
});

// Fungsi untuk memformat harga tanpa desimal
function formatHarga(harga) {
    return 'RP. ' + parseInt(harga).toLocaleString();
}
</script>