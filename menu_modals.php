<!-- Modal for adding menu -->
<div class="modal fade" id="addMenuModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Tambah Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addMenuForm" action="proses/menu_create.php" method="POST">
                    <div class="form-group">
                        <label>Nama</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="invalid-feedback" id="namaError" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i> <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control" id="deskripsi" name="deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" class="form-control" id="harga" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control" id="stok" name="stok" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for editing menu -->
<div class="modal fade" id="editMenuModal" tabindex="-1" role="dialog" aria-labelledby="editMenuModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editMenuModalLabel">Edit Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editMenuForm" action="proses/menu_update.php" method="POST">
                    <input type="hidden" class="edit-id" name="id">
                    <div class="form-group">
                        <label>Nama</label>
                        <div class="input-group">
                            <input type="text" class="form-control edit-nama" name="nama" required>
                        </div>
                        <div class="invalid-feedback edit-nama-error" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i> <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control edit-deskripsi" name="deskripsi" required>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control edit-harga" name="harga" required>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control edit-stok" name="stok" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- Modal for viewing menu details -->
<div class="modal fade" id="detailMenuModal" tabindex="-1" role="dialog" aria-labelledby="detailMenuModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailMenuModalLabel">Detail Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="detailMenuForm">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control detail-nama" readonly>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" class="form-control detail-deskripsi" readonly>
                    </div>
                    <div class="form-group">
                        <label>Harga</label>
                        <input type="text" class="form-control detail-harga" readonly>
                    </div>
                    <div class="form-group">
                        <label>Stok</label>
                        <input type="number" class="form-control detail-stok" readonly>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>