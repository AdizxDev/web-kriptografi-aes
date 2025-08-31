<?php 
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
include 'includes/db.php';
$user = $_SESSION['user'];

// Ambil semua file milik user
$result = $conn->query("SELECT * FROM files WHERE user_id = " . $user['id']);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Halaman Dekripsi</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e0f0ff;
      padding: 20px;
    }
    .card-box {
      background: white;
      border-radius: 10px;
      padding: 20px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      margin-bottom: 20px;
    }
    .btn-action {
      width: 140px;
    }
    .status-badge {
      font-size: 0.9rem;
      padding: 6px 12px;
      border-radius: 12px;
    }
    .table thead {
      background-color: #007bff;
      color: white;
    }
  </style>
</head>
<body>

<div class="container">
  <h3 class="mb-4">🔓 Halaman Dekripsi File</h3>

  <div class="card-box table-responsive">
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>No</th>
          <th>Nama File Sumber</th>
          <th>Nama File Enkripsi</th>
          <th>Path File</th>
          <th>Status File</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no = 1;
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
          <td><?= $no++ ?></td>
          <td><?= htmlspecialchars($row['original_name']) ?></td>
          <td><?= htmlspecialchars($row['encrypted_name']) ?></td>
          <td>
            <a href="<?= htmlspecialchars($row['file_path']) ?>" target="_blank">
              <?= htmlspecialchars($row['file_path']) ?>
            </a>
          </td>
          <td>
            <span class="status-badge bg-<?= $row['status'] === 'SUDAH DIDEKRIPSI' ? 'success' : 'warning' ?>">
              <?= $row['status'] ?>
            </span>
          </td>
          <td>
            <?php if ($row['status'] === 'SUDAH DIDEKRIPSI'): ?>
              <?php if (!empty($row['decrypted_name']) && file_exists($row['decrypted_name'])): ?>
                <a href="<?= htmlspecialchars($row['decrypted_name']) ?>" class="btn btn-success btn-sm btn-action" download>
                  Download File
                </a>
              <?php else: ?>
                <span class="text-success">✔ Didekripsi</span>
              <?php endif; ?>
            <?php else: ?>
              <form action="proses_dekripsi.php" method="post" style="display:inline;">
                <input type="hidden" name="file_id" value="<?= $row['id'] ?>">
                <button class="btn btn-warning text-white btn-sm btn-action">Dekripsi File</button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <a href="dashboard.php" class="btn btn-secondary">← Kembali ke Dashboard</a>
</div>

</body>
</html>
