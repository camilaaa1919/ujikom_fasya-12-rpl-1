<?php
session_start();
include 'koneksi.php';

if (isset($_POST['tambah'])) {
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $tanggalunggah = date('Y-m-d');
    $userid = $_SESSION['userid'];
    $foto = $_FILES['lokasifile']['name'];
    $tmp = $_FILES['lokasifile']['tmp_name'];
    $lokasi = '../assets/img/';
    $namafoto = rand() . '-' . $foto;

    move_uploaded_file($tmp, $lokasi . $namafoto);

    $sql = mysqli_query($koneksi, "INSERT INTO foto VALUES('','$judulfoto','$deskripsifoto','$tanggalunggah','$namafoto','$userid')");

    echo "<script>
    alert ('Data Berhasil Disimpan!');
    location.href='../admin/foto.php'
    </script>";
}


if (isset($_POST['edit'])) {
    $fotoid = $_POST['fotoid'];
    $judulfoto = $_POST['judulfoto'];
    $deskripsifoto = $_POST['deskripsifoto'];
    $tanggalunggah = date('Y-m-d');
    $userid = $_SESSION['userid'];
    $foto = $_FILES['lokasifile']['name'];
    $tmp = $_FILES['lokasifile']['tmp_name'];
    $lokasi = '../assets/img/';
    $namafoto = rand() . '-' . $foto;

    if ($foto == null) {
        $sql = mysqli_query($koneksi, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', tanggalunggah='$tanggalunggah' WHERE fotoid='$fotoid'");
    } else {
        $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE fotoid='$fotoid'");
        $data = mysqli_fetch_array($query);
        if (is_file('../assets/img/' . $data['lokasifile'])) {
            unlink('../assets/img/' . $data['lokasifile']);
        }
        move_uploaded_file($tmp, $lokasi . $namafoto);
        $sql = mysqli_query($koneksi, "UPDATE foto SET judulfoto='$judulfoto', deskripsifoto='$deskripsifoto', tanggalunggah='$tanggalunggah', lokasifile='$namafoto' WHERE fotoid='$fotoid'");
    }
    echo "<script>
    alert ('Data Berhasil Diperbarui!');
    location.href='../admin/foto.php'
    </script>";
}

if (isset($_POST['hapus'])) {
    $fotoid = $_POST['fotoid'];
    $query = mysqli_query($koneksi, "SELECT * FROM foto WHERE fotoid='$fotoid'");
    $data = mysqli_fetch_array($query);
    if (is_file('../assets/img/' . $data['lokasifile'])) {
        unlink('../assets/img/' . $data['lokasifile']);
    }

    $sql = mysqli_query($koneksi, "DELETE FROM foto WHERE fotoid='$fotoid'");
    echo "<script>
    alert ('Data Berhasil Dihapus!');
    location.href='../admin/foto.php'
    </script>";
}


// if (isset($_POST['edit'])) {
//     $albumid = $_POST['albumid'];
//     $namaalbum = $_POST['namaalbum'];
//     $deskripsi = $_POST['deskripsi'];
//     $tanggal = date('Y-m-d');
//     $userid = $_SESSION['userid'];

//     $sql = mysqli_query($koneksi, "UPDATE album SET namaalbum='$namaalbum', deskripsi='$deskripsi', tanggalbuat='$tanggal' WHERE albumid='$albumid'");

//     echo "<script>
//     alert ('Data Berhasil Diperbarui!');
//     location.href='../admin/foto.php'
//     </script>";
// }

// if (isset($_POST['hapus'])) {
//     $albumid = $_POST['albumid'];

//     $sql = mysqli_query($koneksi, "DELETE FROM album WHERE albumid='$albumid'");
//     echo "<script>
//     alert ('Data Berhasil Dihapus!');
//     location.href='../admin/foto.php'
//     </script>";
// }
