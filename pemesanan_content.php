<?php
include('proses/proses_connect_database.php');

// Fetch menus
$sql = "SELECT * FROM Menu";
$result = $conn->query($sql);
$menus = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Data Pemesanan</h4>
            </div>
            <div class="card-body">
                <form id="pemesananForm" method="POST" action="proses/pemesanan_create.php">
                    <div class="form-group">
                        <label for="nama_pemesan">Nama Pemesan</label>
                        <input type="text" class="form-control" id="nama_pemesan" name="nama_pemesan" required>
                    </div>
                    <div class="form-group">
                        <label for="nomor_meja">Nomor Meja</label>
                        <input type="number" class="form-control" id="nomor_meja" name="nomor_meja" required>
                    </div>
                    <button type="button" class="btn btn-primary mb-3" id="tambahDataPesanan" data-toggle="modal"
                        data-target="#invoiceModal" disabled>
                        Tambah Data Pemesanan
                    </button>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <!-- Anda bisa menambahkan tombol atau fitur lain di sini jika diperlukan -->
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="searchInput" placeholder="Cari menu...">
                                <div class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped" id="menuTable">
                            <thead>
                                <tr>
                                    <th class="text-center">Index</th>
                                    <th>Nama Menu</th>
                                    <th>Harga</th>
                                    <th>Stok</th>
                                    <th>Jumlah</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($menus as $index => $menu): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= $menu['nama'] ?></td>
                                    <td class="harga"><?= $menu['harga'] ?></td>
                                    <td class="stok"><?= $menu['stok'] ?></td>
                                    <td class="jumlah">0</td>
                                    <td>
                                        <button type="button" class="btn btn-icon btn-primary tambah-jumlah"
                                            data-id="<?= $menu['id'] ?>">+</button>
                                        <button type="button" class="btn btn-icon btn-danger kurangi-jumlah"
                                            data-id="<?= $menu['id'] ?>">-</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center" id="pagination"></ul>
                    </nav>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.btn:disabled {
    background-color: #d6d6d6;
    cursor: not-allowed;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const menus = <?= json_encode($menus) ?>;
    const table = document.getElementById('menuTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const itemsPerPage = 10;
    let currentPage = 1;
    let filteredRows = rows;

    const jumlahElements = document.querySelectorAll('.jumlah');
    const hargaElements = document.querySelectorAll('.harga');
    const stokElements = document.querySelectorAll('.stok');
    const tambahDataPesananButton = document.getElementById('tambahDataPesanan');
    const namaPemesanInput = document.getElementById('nama_pemesan');
    const nomorMejaInput = document.getElementById('nomor_meja');
    let totalBayar = 0;
    const invoiceDetail = document.getElementById('invoiceDetail');
    const invoiceTotalBayar = document.getElementById('invoiceTotalBayar');
    const invoiceNoPesanan = document.getElementById('invoiceNoPesanan');

    // Fungsi untuk memformat harga tanpa desimal
    function formatHarga(harga) {
        return 'Rp ' + parseInt(harga).toLocaleString('id-ID');
    }

    // Format harga di tabel
    hargaElements.forEach(function(element) {
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

        // Tampilkan dan perbarui indeks hanya untuk baris yang cocok
        filteredRows.forEach((row, index) => {
            row.style.display = '';
            row.cells[0].textContent = index + 1;
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

    namaPemesanInput.addEventListener('input', toggleTambahDataPesananButton);
    nomorMejaInput.addEventListener('input', toggleTambahDataPesananButton);

    document.querySelectorAll('.tambah-jumlah').forEach(button => {
        button.addEventListener('click', function() {
            const id = button.getAttribute('data-id');
            const row = button.closest('tr');
            const jumlahElement = row.querySelector('.jumlah');
            const hargaElement = row.querySelector('.harga');
            const stokElement = row.querySelector('.stok');
            let jumlah = parseInt(jumlahElement.textContent);
            const harga = parseInt(hargaElement.textContent.replace(/[^0-9]/g, ''));
            const stok = parseInt(stokElement.textContent);

            if (jumlah < stok) {
                jumlah++;
                jumlahElement.textContent = jumlah;
            }

            updateInvoice();
            toggleTambahDataPesananButton();
        });
    });

    document.querySelectorAll('.kurangi-jumlah').forEach(button => {
        button.addEventListener('click', function() {
            const id = button.getAttribute('data-id');
            const row = button.closest('tr');
            const jumlahElement = row.querySelector('.jumlah');
            const hargaElement = row.querySelector('.harga');
            let jumlah = parseInt(jumlahElement.textContent);
            const harga = parseInt(hargaElement.textContent.replace(/[^0-9]/g, ''));

            if (jumlah > 0) {
                jumlah--;
                jumlahElement.textContent = jumlah;
            }

            updateInvoice();
            toggleTambahDataPesananButton();
        });
    });

    function updateInvoice() {
        totalBayar = 0;
        invoiceDetail.innerHTML = '';

        jumlahElements.forEach((jumlahElement, index) => {
            const jumlah = parseInt(jumlahElement.textContent);
            if (jumlah > 0) {
                const namaMenu = menus[index]['nama'];
                const harga = parseInt(hargaElements[index].textContent.replace(/[^0-9]/g, ''));
                const subtotal = jumlah * harga;
                totalBayar += subtotal;

                const row = document.createElement('tr');
                row.innerHTML =
                    `<td>${namaMenu}</td><td>${jumlah}</td><td>${formatHarga(harga)}</td><td>${formatHarga(subtotal)}</td>`;
                invoiceDetail.appendChild(row);
            }
        });

        invoiceTotalBayar.textContent = formatHarga(totalBayar);
    }

    function toggleTambahDataPesananButton() {
        const namaPemesan = namaPemesanInput.value.trim();
        const nomorMeja = nomorMejaInput.value.trim();
        let adaPesanan = false;

        jumlahElements.forEach(jumlahElement => {
            if (parseInt(jumlahElement.textContent) > 0) {
                adaPesanan = true;
            }
        });

        if (namaPemesan && nomorMeja && adaPesanan) {
            tambahDataPesananButton.disabled = false;
        } else {
            tambahDataPesananButton.disabled = true;
        }
    }

    // Set invoice data when modal is shown
    $('#invoiceModal').on('show.bs.modal', function() {
        const namaPemesan = document.getElementById('nama_pemesan').value;
        const nomorMeja = document.getElementById('nomor_meja').value;
        const tglPesan = new Date().toLocaleString();

        document.getElementById('invoiceNamaPemesan').textContent = namaPemesan;
        document.getElementById('invoiceNomorMeja').textContent = nomorMeja;
        document.getElementById('invoiceTglPesan').textContent = tglPesan;

        // Fetch no_pesanan from the server
        fetch('proses/get_no_pesanan.php')
            .then(response => response.json())
            .then(data => {
                invoiceNoPesanan.textContent = data.no_pesanan;
            })
            .catch(error => console.error('Fetch error:', error));
    });

    // Print Invoice
    document.getElementById('printInvoice').addEventListener('click', function() {
        const printContents = document.querySelector('#invoiceModal .modal-body').innerHTML;
        const originalContents = document.body.innerHTML;

        const printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write(`
            <html>
            <head>
                <title>Print Invoice</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        margin: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    table, th, td {
                        border: 1px solid black;
                    }
                    th, td {
                        padding: 8px;
                        text-align: left;
                    }
                    .text-right {
                        text-align: right;
                    }
                </style>
            </head>
            <body>
                <h2>Invoice</h2>
                ${printContents}
            </body>
            </html>
        `);
        printWindow.document.close();
        printWindow.print();
    });

    document.getElementById('orderButton').addEventListener('click', function() {
        const namaPemesan = document.getElementById('nama_pemesan').value;
        const nomorMeja = document.getElementById('nomor_meja').value;
        const noPesanan = invoiceNoPesanan.textContent;
        const menuPesanan = [];

        document.querySelectorAll('#invoiceDetail tr').forEach(row => {
            const namaMenu = row.children[0].textContent;
            const jumlah = parseInt(row.children[1].textContent);
            const idMenu = menus.find(menu => menu.nama === namaMenu).id;
            menuPesanan.push({
                id_menu: idMenu,
                jumlah: jumlah
            });
        });

        const data = {
            nama_pemesan: namaPemesan,
            nomor_meja: nomorMeja,
            total_bayar: totalBayar,
            no_pesanan: noPesanan,
            menu_pesanan: JSON.stringify(menuPesanan)
        };

        console.log(data); // Add this line to log the data being sent

        fetch('proses/pemesanan_create.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams(data)
    })
    .then(response => response.json())
    .then(response => {
        if (response.success) {
            toastr.success(response.message);
            $('#invoiceModal').modal('hide');
            setTimeout(() => {
                location.reload();
            }, 1500);
        } else {
            toastr.error(response.message);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        toastr.error('Terjadi kesalahan saat memproses data');
    });
});

// Inisialisasi toastr
toastr.options = {
    "closeButton": true,
    "debug": false,
    "newestOnTop": false,
    "progressBar": true,
    "positionClass": "toast-top-right",
    "preventDuplicates": false,
    "onclick": null,
    "showDuration": "300",
    "hideDuration": "1000",
    "timeOut": "5000",
    "extendedTimeOut": "1000",
    "showEasing": "swing",
    "hideEasing": "linear",
    "showMethod": "fadeIn",
    "hideMethod": "fadeOut"
};
});
</script>
