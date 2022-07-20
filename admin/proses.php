<?php 
include "koneksi.php";

if ($_GET['p']=='tambah_lokasi'){
    session_start();
    $idAdmin = $_SESSION['admin']['id_admin'];

    $namalokasi = $_POST['nama'];
    $telp = $_POST['phone'];
    $kecamatan = $_POST['kecamatan'];
    $kelurahan = $_POST['kelurahan'];
    $jadwal = $_POST['jadwal'];
    $alamat = $_POST['alamat'];
    $info = $_POST['info'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $layanan = implode(', ', $_POST['layanan']);

    $sql = mysqli_query($conn, "INSERT INTO lokasi VALUES ('','$namalokasi', '$info', '$alamat', '$jadwal', '$telp', '$layanan', '$kecamatan', '$kelurahan', '$lat', '$lng', '$idAdmin')");

    $id = mysqli_query($conn, "SELECT id_lokasi FROM lokasi ORDER BY id_lokasi DESC");
    if ($id) {
        $row = mysqli_fetch_assoc($id);
        $roww = $row['id_lokasi'];
        if (!empty($_FILES["foto"]["tmp_name"])) {
            $uploads_dir = 'images/';
            foreach ($_FILES["foto"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["foto"]["tmp_name"][$key];
                    // basename() may prevent filesystem traversal attacks;
                    // further validation/sanitation of the filename may be appropriate
                    $nama = basename($_FILES["foto"]["name"][$key]);
                    $ext = pathinfo($nama, PATHINFO_EXTENSION);
                    $keyy = $key + 1;
                    $name = $namalokasi.$keyy.".".$ext;
                    move_uploaded_file($tmp_name, "$uploads_dir/$name");
                    $sql = mysqli_query($conn, "INSERT INTO foto VALUES ('', '$roww', '$name')");
                }
            }
        }
    }
    if ($sql) {
        header("Location: data-petshop.php");
    }
}

if ($_GET['p']=='ubah_lokasi') {
    session_start();
    $idAdmin = $_SESSION['admin']['id_admin'];

    $id = $_POST['id'];
    $namalokasi = $_POST['nama'];
    $telp = $_POST['phone'];
    $kecamatan = $_POST['kecamatan'];
    $kelurahan = $_POST['kelurahan'];
    $jadwal = $_POST['jadwal'];
    $alamat = $_POST['alamat'];
    $info = $_POST['info'];
    $lat = $_POST['lat'];
    $lng = $_POST['lng'];
    $layanan = implode(', ', $_POST['layanan']);

    $sql = mysqli_query($conn, "UPDATE lokasi set nama = '$namalokasi', info = '$info', alamat = '$alamat', jadwal = '$jadwal', telp = '$telp', layanan = '$layanan', id_kecamatan = '$kecamatan', id_kelurahan = '$kelurahan', lat = '$lat', lng = '$lng', id_admin = '$idAdmin' WHERE id_lokasi = '$id' ");
    
    $countFoto = mysqli_query($conn, "SELECT count(nama) as jumlah FROM foto WHERE nama = '$namalokasi'");
    if($countFoto) {
        $row = mysqli_fetch_assoc($countFoto);
        $roww = $row['jumlah'];
        if (!empty($_FILES["foto"]["tmp_name"])) {
            $uploads_dir = 'images/';
            foreach ($_FILES["foto"]["error"] as $key => $error) {
                if ($error == UPLOAD_ERR_OK) {
                    $tmp_name = $_FILES["foto"]["tmp_name"][$key];
                    // basename() may prevent filesystem traversal attacks;
                    // further validation/sanitation of the filename may be appropriate
                    $nama = basename($_FILES["foto"]["name"][$key]);
                    $ext = pathinfo($nama, PATHINFO_EXTENSION);
                    $keyy = $roww + 1;
                    $name = $namalokasi.$keyy.".".$ext;
                    move_uploaded_file($tmp_name, "$uploads_dir/$name");
                    $sql = mysqli_query($conn, "INSERT INTO foto VALUES ('', '$id', '$name')");
                }
            }
        }
    }

    if ($sql) {
        header("Location: data-petshop.php");
    }

}

if($_GET['p']=='hapus_lokasi') {
    $id = $_GET['id'];
    $sql = mysqli_query($conn, "DELETE FROM lokasi WHERE id_lokasi = '$id'");

    $select = mysqli_query($conn, "SELECT * FROM foto WHERE id_lokasi = '$id'");
    while ($row = mysqli_fetch_assoc($select))
    {
        $nama = $row['nama'];
        $file_to_delete = 'images/'.$nama;
        unlink($file_to_delete);
    }

    $sql2 = mysqli_query($conn, "DELETE FROM foto WHERE id_lokasi = '$id'");
    if ($sql) {
        header("Location: data-petshop.php");
    }
}

if($_GET['p']=='hapus_foto') {
    $id = $_GET['id'];
    $id_lokasi = $_GET['id_lokasi'];
    $select = mysqli_query($conn, "SELECT * FROM foto WHERE id_foto = '$id'");
    while ($row = mysqli_fetch_assoc($select))
    {
        $nama = $row['nama'];
        $file_to_delete = 'images/'.$nama;
        unlink($file_to_delete);
    }
    $sql = mysqli_query($conn, "DELETE FROM foto WHERE id_foto = '$id'");
    if ($sql) {
        header("Location: edit-data.php?id=$id_lokasi");
    }
}

?>