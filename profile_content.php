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
                <form id="profileUpdateForm" method="POST" action="proses/profile_update.php">
                    <div class="form-group">
                        <label for="profile_nama">Nama</label>
                        <input type="text" class="form-control" id="profile_nama" name="nama"
                            value="<?= htmlspecialchars($user['nama']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="profile_email">Email</label>
                        <input type="email" class="form-control" id="profile_email"
                            value="<?= htmlspecialchars($user['email']) ?>" readonly>
                    </div>
                    <div class="form-group">
                        <label for="profile_password">Password</label>
                        <input type="password" class="form-control" id="profile_password" name="password">
                        <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti password</small>
                    </div>
                    <div class="form-group">
                        <label for="profile_no_hp">Nomor HP</label>
                        <input type="text" class="form-control" id="profile_no_hp" name="no_hp"
                            value="<?= htmlspecialchars($user['no_hp']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="profile_alamat">Alamat</label>
                        <textarea class="form-control" id="profile_alamat" name="alamat"
                            required><?= htmlspecialchars($user['alamat']) ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="profile_jabatan">Jabatan</label>
                        <input type="text" class="form-control" id="profile_jabatan"
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
    document.getElementById('profileUpdateForm').addEventListener('submit', function(event) {
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

                    // Update navbar username
                    const navbarUserName = document.getElementById('navbarUserName');
                    if (navbarUserName) {
                        navbarUserName.textContent = 'Hello ' + data.new_name;
                    }

                    // Update localStorage
                    localStorage.setItem('user_name', data.new_name);

                    // Update the form field
                    document.getElementById('profile_nama').value = data.new_name;
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
