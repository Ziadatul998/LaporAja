<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin'){
    header("Location: login.php");
    exit;

}

if($_SESSION['user']['role'] != 'admin'){
    echo "Akses ditolak!";
    exit;
}

$id = $_GET['id'];

if(isset($_POST['kirim'])){

    $status = $_POST['status'];
    $isi_tanggapan = $_POST['isi_tanggapan'];
    $admin_id = $_SESSION['user']['id'];

    mysqli_query($conn,"
    UPDATE pengaduan 
    SET status='$status'
    WHERE id='$id'
    ");

    mysqli_query($conn,"
    INSERT INTO tanggapan
    (pengaduan_id, admin_id, isi_tanggapan, tanggal)
    VALUES
    ('$id','$admin_id','$isi_tanggapan',NOW())
    ");

    header("Location: verifikasi.php");
    exit;
}
?>

<h2>Tanggapan Admin</h2>

<form method="POST">

<label>Status:</label><br>
<select name="status">
    <option value="menunggu">Menunggu</option>
    <option value="proses">Proses</option>
    <option value="selesai">Selesai</option>
</select>

<br><br>

<label>Isi Tanggapan:</label><br>
<textarea name="isi_tanggapan" rows="5" cols="40" required></textarea>

<br><br>

<button type="submit" name="kirim">Simpan</button>

</form>

<br>

<a href="verifikasi.php">Kembali</a>
