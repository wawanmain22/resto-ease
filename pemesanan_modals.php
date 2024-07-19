<!-- Modal Invoice -->
<div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Invoice</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>No Pesanan:</strong> <span id="invoiceNoPesanan"></span></p>
                <p><strong>Nama Pemesan:</strong> <span id="invoiceNamaPemesan"></span></p>
                <p><strong>Nomor Meja:</strong> <span id="invoiceNomorMeja"></span></p>
                <p><strong>Tanggal Pesan:</strong> <span id="invoiceTglPesan"></span></p>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama Menu</th>
                            <th>Jumlah</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="invoiceDetail"></tbody>
                    <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Total Bayar</th>
                            <th id="invoiceTotalBayar"></th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="orderButton">Order</button>
                <button type="button" class="btn btn-success" id="printInvoice">Print</button>
            </div>
        </div>
    </div>
</div>