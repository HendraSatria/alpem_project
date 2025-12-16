<?php
require '../config.php';

$result = mysqli_query($koneksi, "SELECT * FROM aduan");

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

echo json_encode($data);
