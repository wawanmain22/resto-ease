<!-- Modal for adding user -->
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formModal">Tambah Data User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" action="proses/user_create.php" method="POST">
                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <input type="email" class="form-control" id="email" placeholder="Email" name="email"
                                required>
                        </div>
                        <div class="invalid-feedback" id="emailError" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i> <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-lock"></i>
                                </div>
                            </div>
                            <input type="password" class="form-control" placeholder="Password" name="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" placeholder="Nama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <select class="form-control" name="jabatan" required>
                            <option value="" disabled selected>Pilih Jabatan</option>
                            <option value="Owner">Owner</option>
                            <option value="Koki">Koki</option>
                            <option value="Kasir">Kasir</option>
                            <option value="Pelayan">Pelayan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" class="form-control" placeholder="No HP" name="no_hp" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" placeholder="Alamat" name="alamat" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for viewing user details -->
<div class="modal fade" id="detailUserModal" tabindex="-1" role="dialog" aria-labelledby="detailUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailUserModalLabel">Detail Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="detailUserForm">
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" class="form-control" id="detailEmail" readonly>
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="detailNama" readonly>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" id="detailJabatan" readonly>
                    </div>
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" class="form-control" id="detailNoHP" readonly>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" id="detailAlamat" readonly>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for editing user -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" action="proses/user_update.php" method="POST">
                    <input type="hidden" id="editId" name="id">
                    <div class="form-group">
                        <label>Email</label>
                        <div class="input-group">
                            <input type="email" class="form-control" id="editEmail" name="email" required>
                        </div>
                        <div class="invalid-feedback" id="editEmailError" style="display: none;">
                            <i class="fas fa-exclamation-circle"></i> <span class="error-text"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" class="form-control" id="editPassword" name="password">
                    </div>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" class="form-control" id="editNama" name="nama" required>
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" class="form-control" id="editJabatan" name="jabatan" required>
                    </div>
                    <div class="form-group">
                        <label>No HP</label>
                        <input type="text" class="form-control" id="editNoHP" name="no_hp" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <input type="text" class="form-control" id="editAlamat" name="alamat" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>