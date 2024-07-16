<?php
include ('proses/proses_connect_database.php');

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
                                <td class="text-center">
                                    <?= $index + 1 ?>
                                </td>
                                <td>
                                    <?= $user['nama'] ?>
                                </td>
                                <td>
                                    <?= $user['email'] ?>
                                </td>
                                <td>
                                    <?= $user['jabatan'] ?>
                                </td>
                                <td><?= $user['no_hp'] ?></td>
                                <td><?= $user['alamat'] ?></td>
                                <td>
                                    <a href="#" class="btn btn-icon btn-info" data-toggle="modal"
                                        data-target="#detailUserModal" data-id="<?= $user['id'] ?>"><i
                                            class="fas fa-info-circle"></i></a>
                                    <a href="#" class="btn btn-icon btn-primary" data-toggle="modal"
                                        data-target="#editUserModal" data-id="<?= $user['id'] ?>"><i
                                            class="far fa-edit"></i></a>
                                    <a href="proses/user_delete.php?id=<?= $user['id'] ?>"
                                        class=" btn btn-icon btn-danger" data-id="<?= $user['id'] ?>"><i
                                            class="fas fa-times"></i></a>
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
    // Implementasikan DataTables tanpa jQuery
    if (typeof DataTable === 'function') {
        new DataTable('#table-1');
    }

    // Event untuk edit modal
    document.querySelectorAll('[data-target="#editUserModal"]').forEach(button => {
        button.addEventListener('click', function(event) {
            let id = button.getAttribute('data-id');
            console.log('Edit modal ID:', id); // Log ID untuk debugging

            fetch('proses/user_read.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    console.log('Edit modal data:', data); // Log data untuk debugging
                    if (data.success) {
                        document.querySelector('#editId').value = id; // Ensure ID is set
                        document.querySelector('#editEmail').value = data.email;
                        document.querySelector('#editNama').value = data.nama;
                        document.querySelector('#editJabatan').value = data.jabatan;
                        document.querySelector('#editNoHP').value = data.no_hp;
                        document.querySelector('#editAlamat').value = data.alamat;
                        // Clear the password field
                        document.querySelector('#editPassword').value = '';
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        });
    });

    // Event untuk detail modal
    document.querySelectorAll('[data-target="#detailUserModal"]').forEach(button => {
        button.addEventListener('click', function(event) {
            let id = button.getAttribute('data-id');
            console.log('Detail modal ID:', id); // Log ID untuk debugging

            fetch('proses/user_read.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    console.log('Detail modal data:', data); // Log data untuk debugging
                    if (data.success) {
                        document.querySelector('#detailEmail').value = data.email;
                        document.querySelector('#detailNama').value = data.nama;
                        document.querySelector('#detailJabatan').value = data.jabatan;
                        document.querySelector('#detailNoHP').value = data.no_hp;
                        document.querySelector('#detailAlamat').value = data.alamat;
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        });
    });

    document.querySelector('#addUserForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);

        fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(response => {
                // Reset error messages
                const emailInput = document.querySelector('#email');
                const emailError = document.querySelector('#emailError');
                const errorText = document.querySelector('#emailError .error-text');
                emailInput.classList.remove('is-invalid');
                emailError.style.display = 'none';
                errorText.innerText = '';

                if (response.success) {
                    toastr.success(response.message);
                    $('#addUserModal').modal('hide'); // Tutup modal setelah notifikasi sukses
                    setTimeout(() => location.reload(), 1000); // Tunggu 1 detik sebelum refresh
                } else {
                    if (response.message.includes('Email')) {
                        errorText.innerText = response.message;
                        emailError.style.display = 'block';
                        emailInput.classList.add('is-invalid');
                    } else {
                        toastr.error(response.message);
                    }
                }
            })
            .catch(error => {
                toastr.error('Terjadi kesalahan saat memproses data');
                console.error('Fetch error:', error);
            });
    });

    document.querySelector('#editUserForm').addEventListener('submit', function(event) {
        event.preventDefault();
        let formData = new FormData(this);

        // Debugging: log data yang akan dikirim
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(response => {
                // Reset error messages
                const emailInput = document.querySelector('#editEmail');
                const emailError = document.querySelector('#editEmailError');
                const errorText = document.querySelector('#editEmailError .error-text');
                emailInput.classList.remove('is-invalid');
                emailError.style.display = 'none';
                errorText.innerText = '';

                if (response.success) {
                    toastr.success(response.message);
                    $('#editUserModal').modal('hide'); // Tutup modal setelah notifikasi sukses
                    setTimeout(() => location.reload(), 1000); // Tunggu 1 detik sebelum refresh
                } else {
                    if (response.message.includes('Email')) {
                        errorText.innerText = response.message;
                        emailError.style.display = 'block';
                        emailInput.classList.add('is-invalid');
                    } else {
                        toastr.error(response.message);
                    }
                    console.error('Error:', response.message); // Log error ke konsol
                }
            })
            .catch(error => {
                toastr.error('Terjadi kesalahan saat memproses data');
                console.error('Fetch error:', error); // Log fetch error ke konsol
            });
    });

    // Event untuk delete
    document.querySelectorAll('.btn-danger').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            let id = button.getAttribute('data-id');
            let url = button.getAttribute('href');

            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(url, {
                            method: 'GET'
                        })
                        .then(response => response.json())
                        .then(response => {
                            if (response.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'Data telah dihapus.',
                                    'success'
                                );
                                setTimeout(() => location.reload(),
                                1000); // Tunggu 1 detik sebelum refresh
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'Terjadi kesalahan saat menghapus data.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan saat memproses data.',
                                'error'
                            );
                            console.error('Fetch error:',
                            error); // Log fetch error ke konsol
                        });
                }
            });
        });
    });
});
</script>