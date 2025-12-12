<?php
require '../config/koneksi.php';

// Pastikan form dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Mengambil data dari form
    $nama       = mysqli_real_escape_string($koneksi, $_POST['nama_pelapor']);
    $alamat     = mysqli_real_escape_string($koneksi, $_POST['alamat']);
    $nik        = mysqli_real_escape_string($koneksi, $_POST['nik']);
    $kontak     = mysqli_real_escape_string($koneksi, $_POST['kontak']);
    $lokasi     = mysqli_real_escape_string($koneksi, $_POST['lokasi']);
    $deskripsi  = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Proses upload foto
    $fotoName = "";
    if (!empty($_FILES['bukti_foto']['name'])) {

        $folder = "../assets/img/";
        $fileTmp = $_FILES['bukti_foto']['tmp_name'];
        $fileName = time() . "_" . basename($_FILES['bukti_foto']['name']);
        $uploadPath = $folder . $fileName;

        // Validasi file
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if (!in_array($fileExtension, $allowedExtensions)) {
            echo "<script>alert('Format foto tidak diizinkan (hanya JPG/PNG).'); window.location='../public/index.php';</script>";
            exit;
        }

        // Pindahkan file
        if (move_uploaded_file($fileTmp, $uploadPath)) {
            $fotoName = $fileName;
        } else {
            echo "<script>alert('Gagal mengupload foto.'); window.location='../public/index.php';</script>";
            exit;
        }
    }

    // Query simpan ke database
    $query = "INSERT INTO Aduan 
                (Nama_pelapor, Alamat, NIK, Kontak, Lokasi, Bukti_Foto, Deskripsi) 
              VALUES 
                ('$nama', '$alamat', '$nik', '$kontak', '$lokasi', '$fotoName', '$deskripsi')";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>
            alert('Aduan berhasil dikirim!');
            window.location='data_aduan.php';
            </script>";
    } else {
        echo "<script>
            alert('Gagal menyimpan aduan. Silakan coba lagi.');
            window.location='index.php';
            </script>";
    }

} else {
    echo "<script>alert('Akses tidak valid.'); window.location='index.php';</script>";
}
?>
