<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
include 'includes/db.php';
$user = $_SESSION['user'];

// Jika ada permintaan hapus
if (isset($_GET['delete'])) {
    $file_id = (int)$_GET['delete'];
    $query = $conn->query("SELECT * FROM files WHERE id = $file_id AND user_id = " . $user['id']);
    if ($query && $query->num_rows > 0) {
        $file = $query->fetch_assoc();
        // Hapus file fisik jika ada
        if (!empty($file['file_path']) && file_exists($file['file_path'])) {
            unlink($file['file_path']);
        }
        $conn->query("DELETE FROM files WHERE id = $file_id");
    }
    header("Location: dashboard.php");
    exit;
}

$result = $conn->query("SELECT * FROM files WHERE user_id = " . $user['id']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body {
      background-color: #e0f0ff;
    }
    .card-box {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    .status-badge {
      font-size: 0.9rem;
      padding: 5px 10px;
      border-radius: 12px;
    }
    .profile-img {
      width: 80px;
      height: 80px;
      object-fit: cover;
      border-radius: 50%;
      border: 3px solid #fff;
      box-shadow: 0 0 10px rgba(0,0,0,0.2);
    }
    .table thead {
      background-color: #007bff;
      color: white;
    }
    .sidebar {
      width: 240px;
      height: 100vh;
      position: fixed;
      background-color: #2c3e50;
      color: white;
      padding-top: 30px;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 10px 20px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background-color: #34495e;
    }
    .sidebar i {
      margin-right: 10px;
    }
    .main-content {
      margin-left: 260px;
      padding: 20px;
    }
  </style>
</head>
<body>

<div class="sidebar">
  <div class="text-center mb-4">
    <img src="assets/profil.jpg" alt="Profil" class="profile-img mb-2">
    <h5 class="mt-2"><?= $user['fullname'] ?></h5>
    <small><?= $user['username'] ?></small>
  </div>
  <a href="dashboard.php"><i class="bi bi-speedometer2"></i> Dashboard</a>
  <a href="enkripsi.php"><i class="bi bi-lock-fill"></i> Enkripsi</a>
  <a href="dekripsi.php"><i class="bi bi-unlock-fill"></i> Dekripsi</a>
  <a href="logout.php" class="text-danger"><i class="bi bi-box-arrow-right"></i> Log Out</a>
</div>

<div class="main-content">
  <h3 class="mb-4">Dashboard Kriptografi - AES</h3>

  <div class="row">
    <div class="col-md-4">
      <div class="card-box text-center">
        <h5>User</h5>
        <h2>1</h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-box text-center">
        <h5>Enkripsi</h5>
        <h2><?= $conn->query("SELECT COUNT(*) as total FROM files WHERE user_id = " . $user['id'])->fetch_assoc()['total'] ?></h2>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-box text-center">
        <h5>Dekripsi</h5>
        <h2><?= $conn->query("SELECT COUNT(*) as total FROM files WHERE user_id = " . $user['id'] . " AND status='SUDAH DIDEKRIPSI'")->fetch_assoc()['total'] ?></h2>
      </div>
    </div>
  </div>

  <div class="mt-4">
    <h4>Riwayat File</h4>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Username</th>
            <th>Nama File</th>
            <th>Nama File Enkripsi</th>
            <th>Ukuran File</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($row['original_name']) ?></td>
            <td><?= htmlspecialchars($row['encrypted_name']) ?></td>
            <td><?= number_format($row['file_size'], 6) ?> KB</td>
            <td><?= htmlspecialchars($row['created_at']) ?></td>
            <td>
              <span class="status-badge bg-<?= $row['status'] === 'SUDAH DIDEKRIPSI' ? 'success' : 'danger' ?>">
                <?= htmlspecialchars($row['status']) ?>
              </span>
            </td>
            <td>
              <a href="dashboard.php?delete=<?= $row['id'] ?>" 
                 onclick="return confirm('Yakin ingin menghapus file ini?')" 
                 class="btn btn-danger btn-sm">
                 Hapus
              </a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

</body>
</html>
