<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin'){
    header("Location: login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT pengaduan.*, users.nama FROM pengaduan JOIN users ON pengaduan.user_id = users.id ORDER BY pengaduan.id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Verifikasi Laporan</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f0f2f5; padding: 20px; }
        .admin-card { background: white; padding: 25px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { border-left: 5px solid #2ecc71; padding-left: 15px; color: #2c3e50; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; background: white; }
        th { background: #2c3e50; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #ddd; vertical-align: middle; }
        .img-preview { width: 80px; height: 60px; object-fit: cover; border-radius: 5px; border: 1px solid #ddd; cursor: pointer; }
        .btn-aksi { background: #2ecc71; color: white; padding: 6px 12px; text-decoration: none; border-radius: 4px; font-size: 13px; }
        .btn-aksi:hover { background: #27ae60; }
        .btn-logout { float: right; color: #e74c3c; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="admin-card">
        <a href="logout.php" class="btn-logout">Logout</a>
        <h2>Manajemen Pengaduan</h2>
        
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pelapor</th>
                    <th>Judul</th>
                    <th>Bukti</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; while($d = mysqli_fetch_assoc($data)): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><strong><?= $d['nama'] ?></strong></td>
                    <td><?= $d['judul'] ?></td>
                    <td>
                        <?php if(!empty($d['bukti'])): ?>
                            <a href="upload/<?= $d['bukti'] ?>" target="_blank">
                                <img src="upload/<?= $d['bukti'] ?>" class="img-preview">
                            </a>
                        <?php else: ?>
                            <small style="color:#999">Tanpa Foto</small>
                        <?php endif; ?>
                    </td>
                    <td><?= strtoupper($d['status']) ?></td>
                    <td>
                        <a href="tanggapan.php?id=<?= $d['id'] ?>" class="btn-aksi">Proses / Tanggapi</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
