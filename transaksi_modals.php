<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <tr>
                        <th>No. Pesanan</th>
                        <td id="detailNoPesanan"></td>
                    </tr>
                    <tr>
                        <th>Nama Pemesan</th>
                        <td id="detailNamaPemesan"></td>
                    </tr>
                    <tr>
                        <th>Nomor Meja</th>
                        <td id="detailNomorMeja"></td>
                    </tr>
                    <tr>
                        <th>Total Bayar</th>
                        <td id="detailTotalBayar"></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pesan</th>
                        <td id="detailTglPesan"></td>
                    </tr>
                </table>
                <h5>Detail Pesanan</h5>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="detailTableBody">
                        <!-- Data will be populated here via JS -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>