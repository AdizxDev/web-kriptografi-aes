<?php
session_start();
include 'includes/db.php';

if (!isset($_SESSION['user']) || !isset($_POST['file_id'])) {
    die("Akses ditolak.");
}

$user_id = $_SESSION['user']['id'];
$file_id = intval($_POST['file_id']);

// Ambil data file berdasarkan ID dan user_id
$stmt = $conn->prepare("SELECT * FROM files WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $file_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("File tidak ditemukan di database.");
}

$file = $result->fetch_assoc();
$encrypted_path = $file['file_path'];

// Cek apakah file enkripsi tersedia di folder
if (!file_exists($encrypted_path)) {
    die("File enkripsi tidak ditemukan di server.");
}

// Ambil konten file terenkripsi dan decode
$enc_data = base64_decode(file_get_contents($encrypted_path));
$iv = substr($enc_data, 0, 16);
$encrypted = substr($enc_data, 16);

// Ambil kunci enkripsi dari database
if (empty($file['aes_key'])) {
    die("Kunci AES tidak ditemukan. File tidak dapat didekripsi.");
}
$key = base64_decode($file['aes_key']);

// Dekripsi file
$cipher = "aes-256-cbc";
$decrypted = openssl_decrypt($encrypted, $cipher, $key, OPENSSL_RAW_DATA, $iv);

if ($decrypted === false) {
    die("Gagal mendekripsi file. Mungkin kunci salah atau file rusak.");
}

// Simpan file hasil dekripsi
$decrypted_name = "uploads/decrypted-" . time() . "-" . basename($file['original_name']);
file_put_contents($decrypted_name, $decrypted);

// Update database: status + nama file dekripsi
$update = $conn->prepare("UPDATE files SET status = 'SUDAH DIDEKRIPSI', decrypted_name = ? WHERE id = ?");
$update->bind_param("si", $decrypted_name, $file['id']);
$update->execute();

// Kirim file ke browser untuk diunduh
header("Content-Disposition: attachment; filename=" . basename($decrypted_name));
header("Content-Type: application/octet-stream");
readfile($decrypted_name);
exit;
