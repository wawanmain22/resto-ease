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
                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">
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
    const jumlahElements = document.querySelectorAll('.jumlah');
    const hargaElements = document.querySelectorAll('.harga');
    const stokElements = document.querySelectorAll('.stok');
    const tambahDataPesananButton = document.getElementById('tambahDataPesanan');
    const namaPemesanInput = document.getElementById('nama_pemesan');
    const nomorMejaInput = document.getElementById('nomor_meja');
    let totalBayar = 0;
    const invoiceDetail = document.getElementById('invoiceDetail');
    const invoiceTotalBayar = document.getElementById('invoiceTotalBayar');

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
            const harga = parseInt(hargaElement.textContent);
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
            const harga = parseInt(hargaElement.textContent);

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
                const harga = parseInt(hargaElements[index].textContent);
                const subtotal = jumlah * harga;
                totalBayar += subtotal;

                const row = document.createElement('tr');
                row.innerHTML =
                    `<td>${namaMenu}</td><td>${jumlah}</td><td>RP. ${harga.toLocaleString()}</td><td>RP. ${subtotal.toLocaleString()}</td>`;
                invoiceDetail.appendChild(row);
            }
        });

        invoiceTotalBayar.textContent = totalBayar.toLocaleString();
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
    });
});
</script>