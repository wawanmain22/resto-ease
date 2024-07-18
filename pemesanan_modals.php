<!-- Modal for Invoice -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="invoiceModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceModalLabel">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Nama Pemesan: <span id="invoiceNamaPemesan"></span></p>
                <p>Nomor Meja: <span id="invoiceNomorMeja"></span></p>
                <p>Tanggal Pesan: <span id="invoiceTglPesan"></span></p>
                <p>Total Bayar: RP. <span id="invoiceTotalBayar">0</span></p>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Nama Menu</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody id="invoiceDetail">
                            <!-- Invoice detail will be populated here -->
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-primary" form="pemesananForm">Simpan Pemesanan</button>
            </div>
        </div>
    </div>
</div>