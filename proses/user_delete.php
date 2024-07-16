<?php
include ('proses_connect_database.php');

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM User WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../user.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>