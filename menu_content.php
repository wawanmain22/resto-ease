<?php
include('proses/proses_connect_database.php');

// Ambil data menu
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
                <div class="row mb-3">
                    <div class="col-md-6">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addMenuModal">
                            Tambah Menu
                        </button>
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
                                    <button class="btn btn-icon btn-info detail-btn" data-id="<?= $menu['id'] ?>">
                                        <i class="fas fa-info-circle"></i>
                                    </button>
                                    <button class="btn btn-icon btn-primary edit-btn" data-id="<?= $menu['id'] ?>">
                                        <i class="far fa-edit"></i>
                                    </button>
                                    <button class="btn btn-icon btn-danger delete-btn" data-id="<?= $menu['id'] ?>">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center" id="pagination"></ul>
                </nav>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('menuTable');
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const itemsPerPage = 10;
    let currentPage = 1;
    let filteredRows = rows;

    // Fungsi untuk memformat harga
    function formatHarga(harga) {
        return 'Rp ' + parseInt(harga).toLocaleString('id-ID');
    }

    // Format harga di tabel
    document.querySelectorAll('.harga').forEach(function(element) {
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

    // Fungsi untuk menangani klik tombol detail
    function handleDetailClick(id) {
        console.log('Detail clicked for ID:', id);
        fetch('proses/menu_read.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.detail-nama').value = data.nama;
                    document.querySelector('.detail-deskripsi').value = data.deskripsi;
                    document.querySelector('.detail-harga').value = formatHarga(data.harga);
                    document.querySelector('.detail-stok').value = data.stok;
                    $('#detailMenuModal').modal('show');
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat memuat data', 'error');
            });
    }

    // Fungsi untuk menangani klik tombol edit
    function handleEditClick(id) {
        console.log('Edit clicked for ID:', id);
        fetch('proses/menu_read.php?id=' + id)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.querySelector('.edit-id').value = id;
                    document.querySelector('.edit-nama').value = data.nama;
                    document.querySelector('.edit-deskripsi').value = data.deskripsi;
                    document.querySelector('.edit-harga').value = data.harga;
                    document.querySelector('.edit-stok').value = data.stok;
                    $('#editMenuModal').modal('show');
                } else {
                    Swal.fire('Error', data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat memuat data', 'error');
            });
    }

    // Fungsi untuk menangani klik tombol delete
    function handleDeleteClick(id) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('proses/menu_delete.php?id=' + id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire(
                                'Terhapus!',
                                'Menu berhasil dihapus.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Terjadi kesalahan: ' + data.message,
                                'error'
                            );
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire(
                            'Error!',
                            'Terjadi kesalahan saat menghapus data',
                            'error'
                        );
                    });
            }
        });
    }

    // Attach event listeners to action buttons
    document.addEventListener('click', function(e) {
        if (e.target.closest('.detail-btn')) {
            handleDetailClick(e.target.closest('.detail-btn').dataset.id);
        } else if (e.target.closest('.edit-btn')) {
            handleEditClick(e.target.closest('.edit-btn').dataset.id);
        } else if (e.target.closest('.delete-btn')) {
            handleDeleteClick(e.target.closest('.delete-btn').dataset.id);
        }
    });

    // Form tambah menu
    const addMenuForm = document.querySelector('#addMenuForm');
    if (addMenuForm) {
        addMenuForm.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    Swal.fire('Sukses', response.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat memproses data', 'error');
            });
        });
    }

    // Form edit menu
    const editMenuForm = document.querySelector('#editMenuForm');
    if (editMenuForm) {
        editMenuForm.addEventListener('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);

            fetch(this.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(response => {
                if (response.success) {
                    Swal.fire('Sukses', response.message, 'success').then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire('Error', 'Terjadi kesalahan saat memproses data', 'error');
            });
        });
    }
});
</script>
