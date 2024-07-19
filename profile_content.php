<?php
include('proses/proses_connect_database.php');

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM User WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Profile</h4>
            </div>
            <div class="card-body">
                <form id="profileForm" method="POST" action="proses/profile_update.php">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama"
                            value="<?= htmlspecialchars($user['nama']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email"
                            value="<?= htmlspecialchars($user['email']) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti password</small>
                    </div>
                    <div class="form-group">
                        <label for="no_hp">Nomor HP</label>
                        <input type="text" class="form-control" id="no_hp" name="no_hp"
                            value="<?= htmlspecialchars($user['no_hp']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat"
                            required><?= htmlspecialchars($user['alamat']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="jabatan"
                            value="<?= htmlspecialchars($user['jabatan']) ?>" readonly>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('profileForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const form = event.target;
        const formData = new FormData(form);

        fetch('proses/profile_update.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    toastr.success(data.message);
                    setTimeout(() => {
                        location.reload();
                    }, 1000); // Reload halaman setelah 1 detik
                } else {
                    toastr.error(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                toastr.error('Terjadi kesalahan saat memperbarui profil');
            });
    });
});
</script>