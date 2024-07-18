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
                <h4>Data Menu</h4>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addMenuModal">
                    Tambah Menu
                </button>
                <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                        <thead>
                            <tr>
                                <th class="text-center">Index</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menus as $index => $menu): ?>
                            <tr>
                                <td class="text-center"><?= $index + 1 ?></td>
                                <td><?= $menu['nama'] ?></td>
                                <td><?= $menu['deskripsi'] ?></td>
                                <td class="harga"><?= $menu['harga'] ?></td>
                                <td><?= $menu['stok'] ?></td>
                                <td>
                                    <a href="#" class="btn btn-icon btn-info" data-toggle="modal"
                                        data-target="#detailMenuModal" data-id="<?= $menu['id'] ?>"><i
                                            class="fas fa-info-circle"></i></a>
                                    <a href="#" class="btn btn-icon btn-primary" data-toggle="modal"
                                        data-target="#editMenuModal" data-id="<?= $menu['id'] ?>"><i
                                            class="far fa-edit"></i></a>
                                    <a href="proses/menu_delete.php?id=<?= $menu['id'] ?>"
                                        class="btn btn-icon btn-danger" data-id="<?= $menu['id'] ?>"><i
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
    // Fungsi untuk memformat harga tanpa desimal
    function formatHarga(harga) {
        return 'RP. ' + parseInt(harga).toLocaleString();
    }

    // Format harga di tabel
    document.querySelectorAll('.harga').forEach(function(element) {
        element.textContent = formatHarga(element.textContent);
    });

    // Implementasikan DataTables tanpa jQuery
    if (typeof DataTable === 'function') {
        new DataTable('#table-1');
    }

    // Event untuk edit modal
    document.querySelectorAll('[data-target="#editMenuModal"]').forEach(button => {
        button.addEventListener('click', function(event) {
            let id = button.getAttribute('data-id');
            console.log('Edit modal ID:', id); // Log ID untuk debugging

            fetch('proses/menu_read.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    console.log('Edit modal data:', data); // Log data untuk debugging
                    if (data.success) {
                        document.querySelector('.edit-id').value = id; // Ensure ID is set
                        document.querySelector('.edit-nama').value = data.nama;
                        document.querySelector('.edit-deskripsi').value = data.deskripsi;
                        document.querySelector('.edit-harga').value = parseInt(data
                        .harga); // Remove .00
                        document.querySelector('.edit-stok').value = data.stok;
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
    document.querySelectorAll('[data-target="#detailMenuModal"]').forEach(button => {
        button.addEventListener('click', function(event) {
            let id = button.getAttribute('data-id');
            console.log('Detail modal ID:', id); // Log ID untuk debugging

            fetch('proses/menu_read.php?id=' + id)
                .then(response => response.json())
                .then(data => {
                    console.log('Detail modal data:', data); // Log data untuk debugging
                    if (data.success) {
                        document.querySelector('.detail-nama').value = data.nama;
                        document.querySelector('.detail-deskripsi').value = data.deskripsi;
                        document.querySelector('.detail-harga').value = parseInt(data
                        .harga); // Remove .00
                        document.querySelector('.detail-stok').value = data.stok;
                    } else {
                        console.error('Error:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                });
        });
    });

    // Form tambah menu
    const addMenuForm = document.querySelector('#addMenuForm');
    if (addMenuForm) {
        addMenuForm.addEventListener('submit', function(event) {
            event.preventDefault();
            let formData = new FormData(this);

            fetch(this.getAttribute('action'), {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text()) // Change to response.text() for debugging
                .then(responseText => {
                    console.log('Response from server:',
                    responseText); // Log response text for debugging
                    let response;
                    try {
                        response = JSON.parse(responseText);
                    } catch (error) {
                        console.error('JSON parse error:', error);
                        toastr.error('Terjadi kesalahan saat memproses data');
                        return;
                    }

                    // Reset error messages
                    const namaInput = document.querySelector('#nama');
                    const namaError = document.querySelector('#namaError');
                    const errorText = document.querySelector('#namaError .error-text');
                    namaInput.classList.remove('is-invalid');
                    namaError.style.display = 'none';
                    errorText.innerText = '';

                    if (response.success) {
                        toastr.success(response.message);
                        $('#addMenuModal').modal('hide'); // Tutup modal setelah notifikasi sukses
                        setTimeout(() => location.reload(), 1000); // Tunggu 1 detik sebelum refresh
                    } else {
                        if (response.message.includes('Nama')) {
                            errorText.innerText = response.message;
                            namaError.style.display = 'block';
                            namaInput.classList.add('is-invalid');
                        } else {
                            toastr.error(response.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    toastr.error('Terjadi kesalahan saat memproses data');
                });
        });
    }

    // Form edit menu
    const editMenuForm = document.querySelector('#editMenuForm');
    if (editMenuForm) {
        editMenuForm.addEventListener('submit', function(event) {
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
                .then(response => response.text()) // Change to response.text() for debugging
                .then(responseText => {
                    console.log('Response from server:',
                    responseText); // Log response text for debugging
                    let response;
                    try {
                        response = JSON.parse(responseText);
                    } catch (error) {
                        console.error('JSON parse error:', error);
                        toastr.error('Terjadi kesalahan saat memproses data');
                        return;
                    }

                    // Reset error messages
                    const namaInput = document.querySelector('.edit-nama');
                    const namaError = document.querySelector('.edit-nama-error');
                    const errorText = document.querySelector('.edit-nama-error .error-text');
                    namaInput.classList.remove('is-invalid');
                    namaError.style.display = 'none';
                    errorText.innerText = '';

                    if (response.success) {
                        toastr.success(response.message);
                        $('#editMenuModal').modal('hide'); // Tutup modal setelah notifikasi sukses
                        setTimeout(() => location.reload(), 1000); // Tunggu 1 detik sebelum refresh
                    } else {
                        if (response.message.includes('Nama')) {
                            errorText.innerText = response.message;
                            namaError.style.display = 'block';
                            namaInput.classList.add('is-invalid');
                        } else {
                            toastr.error(response.message);
                        }
                        console.error('Error:', response.message); // Log error ke konsol
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    toastr.error('Terjadi kesalahan saat memproses data');
                });
        });
    }

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