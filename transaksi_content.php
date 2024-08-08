<?php
include('proses/proses_connect_database.php');

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
                <div class="row mb-3">
                    <div class="col-md-6">
                        <!-- Anda bisa menambahkan tombol atau fitur lain di sini jika diperlukan -->
                    </div>
                    <div class="col-md-6">
                        <div class="input-group">
                            <input type="text" class="form-control" id="searchInput" placeholder="Cari transaksi...">
                            <div class="input-group-append">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped" id="transaksiTable">
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
                                        data-id="<?= $transaksiItem['id'] ?>">Detail</button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('transaksiTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const itemsPerPage = 10;
    let currentPage = 1;
    let filteredRows = rows;

    // Fungsi untuk memformat harga tanpa desimal
    function formatHarga(harga) {
        const numericHarga = parseFloat(harga);
        if (isNaN(numericHarga)) {
            return 'Rp 0';
        }
        return 'Rp ' + numericHarga.toLocaleString('id-ID');
    }

    // Format harga di tabel
    document.querySelectorAll('.harga').forEach(function(element) {
        element.textContent = formatHarga(element.textContent);
    });

    // Fungsi untuk menampilkan halaman tertentu
    function showPage(page) {
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        filteredRows.forEach((row, index) => {
            row.style.display = (index >= start && index < end) ? '' : 'none';
        });
    }

    // Fungsi untuk membuat pagination
    function setupPagination() {
        const pageCount = Math.ceil(filteredRows.length / itemsPerPage);
        const paginationElement = document.getElementById('pagination');
        paginationElement.innerHTML = '';

        for (let i = 1; i <= pageCount; i++) {
            const li = document.createElement('li');
            li.className = 'page-item' + (i === currentPage ? ' active' : '');
            const a = document.createElement('a');
            a.className = 'page-link';
            a.href = '#';
            a.textContent = i;
            a.addEventListener('click', (e) => {
                e.preventDefault();
                currentPage = i;
                showPage(currentPage);
                updatePaginationButtons();
            });
            li.appendChild(a);
            paginationElement.appendChild(li);
        }
    }

    // Fungsi untuk update tampilan tombol pagination
    function updatePaginationButtons() {
        const buttons = document.querySelectorAll('.pagination .page-item');
        buttons.forEach((button, index) => {
            button.classList.toggle('active', index + 1 === currentPage);
        });
    }

    // Fungsi pencarian yang diperbaiki
    function searchTable() {
        const searchInput = document.getElementById('searchInput');
        const filter = searchInput.value.toLowerCase();

        filteredRows = rows.filter(row => {
            const text = row.textContent.toLowerCase();
            return text.includes(filter);
        });

        // Sembunyikan semua baris
        rows.forEach(row => row.style.display = 'none');

        // Tampilkan hanya baris yang cocok
        filteredRows.forEach((row, index) => {
            row.style.display = '';
        });

        currentPage = 1;
        setupPagination();
        showPage(currentPage);
    }

    // Event listener untuk input pencarian
    document.getElementById('searchInput').addEventListener('input', searchTable);

    // Setup pagination awal
    setupPagination();
    showPage(currentPage);

    // Fungsi untuk menangani klik tombol detail
    function handleDetailClick(id) {
        console.log('Detail clicked for ID:', id);
        fetch('proses/transaksi_read.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const transaksi = data.transaksi;
                    const detailPesanan = data.detail_pesanan;

                    document.getElementById('detailNoPesanan').textContent = transaksi.no_pesanan;
                    document.getElementById('detailNamaPemesan').textContent = transaksi.nama_pemesan;
                    document.getElementById('detailNomorMeja').textContent = transaksi.nomor_meja;
                    document.getElementById('detailTotalBayar').textContent = formatHarga(transaksi.total_bayar);
                    document.getElementById('detailTglPesan').textContent = transaksi.tgl_pesan;

                    const detailTableBody = document.getElementById('detailTableBody');
                    detailTableBody.innerHTML = '';
                    detailPesanan.forEach(item => {
                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td>${item.nama_menu}</td>
                            <td class="harga">${formatHarga(item.harga)}</td>
                            <td>${item.jumlah}</td>
                            <td class="harga">${formatHarga(item.subtotal)}</td>
                        `;
                        detailTableBody.appendChild(row);
                    });

                    $('#detailModal').modal('show');
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat memuat data', 'error');
            });
    }

    // Attach event listeners to action buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.detail-transaksi')) {
            handleDetailClick(e.target.closest('.detail-transaksi').dataset.id);
        }
    });
});
</script>
