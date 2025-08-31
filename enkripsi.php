<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
  <title>Enkripsi File</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #e0f0ff;
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .enkripsi-box {
      background-color: white;
      padding: 50px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 700px;
    }
    .enkripsi-box h2 {
      font-size: 2rem;
      font-weight: 600;
      margin-bottom: 30px;
      text-align: center;
    }
    .form-label {
      font-size: 1.1rem;
    }
    .form-control {
      font-size: 1.1rem;
      padding: 10px;
    }
    .btn {
      font-size: 1.1rem;
      padding: 12px;
    }
  </style>
</head>
<body>

<div class="enkripsi-box">
  <h2>🔐 Enkripsi File dengan AES</h2>

  <form action="proses_enkripsi.php" method="post" enctype="multipart/form-data">
    <div class="mb-4">
      <label for="file" class="form-label">Pilih file untuk dienkripsi</label>
      <input type="file" name="file" id="file" class="form-control" required>
    </div>
    <div class="d-grid gap-3">
      <button type="submit" class="btn btn-success">🚀 Mulai Enkripsi</button>
      <a href="dashboard.php" class="btn btn-secondary">← Kembali ke Dashboard</a>
    </div>
  </form>
</div>

</body>
</html>
