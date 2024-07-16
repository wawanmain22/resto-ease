<?php
include('proses/proses_connect_database.php');

// Fetch users
$sql = "SELECT * FROM User";
$result = $conn->query($sql);
$users = $result->fetch_all(MYSQLI_ASSOC);
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Data User</h4>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addUserModal">
                    Tambah Data
                </button>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">Index</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Jabatan</th>
                                <th>No HP</th>
                                <th>Alamat</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $index => $user): ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td><?= $user['nama'] ?></td>
                                    <td><?= $user['email'] ?></td>
                                    <td><?= $user['jabatan'] ?></td>
                                    <td><?= $user['no_hp'] ?></td>
                                    <td><?= $user['alamat'] ?></td>
                                    <td>
                                        <a href="#" class="btn btn-icon btn-info" data-toggle="modal"
                                            data-target="#detailUserModal"
                                            data-id="<?= $user['id'] ?>"><i class="fas fa-info-circle"></i></a>
                                        <a href="#" class="btn btn-icon btn-primary" data-toggle="modal"
                                            data-target="#editUserModal"
                                            data-id="<?= $user['id'] ?>"><i class="far fa-edit"></i></a>
                                        <a href="proses/user_delete.php?id=<?= $user['id'] ?>" class="btn btn-icon btn-danger"
                                            data-id="<?= $user['id'] ?>"><i class="fas fa-times"></i></a>
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
    $(document).ready(function() {
        $('#table-1').DataTable();

        $('#editUserModal').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let id = button.data('id');

            $.get('proses/user_read.php?id=' + id, function(data) {
                $('#editId').val(data.id);
                $('#editEmail').val(data.email);
                $('#editNama').val(data.nama);
                $('#editJabatan').val(data.jabatan);
                $('#editNoHP').val(data.no_hp);
                $('#editAlamat').val(data.alamat);
            });
        });

        $('#detailUserModal').on('show.bs.modal', function(event) {
            let button = $(event.relatedTarget);
            let id = button.data('id');

            $.get('proses/user_read.php?id=' + id, function(data) {
                $('#detailEmail').val(data.email);
                $('#detailNama').val(data.nama);
                $('#detailJabatan').val(data.jabatan);
                $('#detailNoHP').val(data.no_hp);
                $('#detailAlamat').val(data.alamat);
            });
        });

        $('#addUserForm').on('submit', function(event) {
            event.preventDefault();
            let formData = $(this).serialize();

            $.post($(this).attr('action'), formData, function(response) {
                if (response.success) {
                    Swal.fire({
                        title: 'Berhasil!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: response.message,
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            }, 'json');
        });
    });
</script>
