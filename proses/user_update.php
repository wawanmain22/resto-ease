<?php
include ('proses_connect_database.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    if (!empty($password)) {
        $sql = "UPDATE User SET email='$email', password='$password', nama='$nama', jabatan='$jabatan', no_hp='$no_hp', alamat='$alamat' WHERE id='$id'";
    } else {
        $sql = "UPDATE User SET email='$email', nama='$nama', jabatan='$jabatan', no_hp='$no_hp', alamat='$alamat' WHERE id='$id'";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: ../user.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>