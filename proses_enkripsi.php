<?php
session_start();
include 'includes/db.php';

if (!isset($_FILES['file'])) {
    die("File tidak ditemukan!");
}

$filename = $_FILES['file']['name'];
$tmpname = $_FILES['file']['tmp_name'];
$filesize = $_FILES['file']['size'] / 1024;

$enc_filename = time() . "-enc.txt";
$enc_path = "uploads/" . $enc_filename;

$data = file_get_contents($tmpname);

// ✅ Buat key dan IV
$key = openssl_random_pseudo_bytes(32); // 256-bit key
$iv = openssl_random_pseudo_bytes(16);  // 128-bit IV (AES block size)
$cipher = "aes-256-cbc";

// ✅ Enkripsi data
$encrypted = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
file_put_contents($enc_path, base64_encode($iv . $encrypted));

// ✅ Simpan ke database
$filename_safe = $conn->real_escape_string($filename);
$enc_filename_safe = $conn->real_escape_string($enc_filename);
$enc_path_safe = $conn->real_escape_string($enc_path);
$aes_key_encoded = base64_encode($key); // 🟢 encode key sebelum simpan
$user_id = (int) $_SESSION['user']['id'];

$conn->query("INSERT INTO files (user_id, original_name, encrypted_name, file_path, file_size, aes_key, status, created_at) VALUES (
    $user_id,
    '$filename_safe',
    '$enc_filename_safe',
    '$enc_path_safe',
    $filesize,
    '$aes_key_encoded',
    'TERENKRIPSI',
    NOW()
)");

header("Location: dashboard.php");
