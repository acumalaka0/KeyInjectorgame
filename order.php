<?php
// order.php
header('Content-Type: application/json');
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'msg' => 'Metode permintaan tidak diizinkan']);
    exit;
}

// 1. Ambil & Verifikasi Turnstile Captcha Token dari Cloudflare
$turnstileResponse = $_POST['cf-turnstile-response'] ?? '';

if (empty($turnstileResponse)) {
    echo json_encode(['status' => 'error', 'msg' => 'Verifikasi Turnstile Captcha gagal atau kosong.']);
    exit;
}

$verifyUrl = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
$verifyData = http_build_query([
    'secret'   => TURNSTILE_SECRET_KEY,
    'response' => $turnstileResponse,
    'remoteip' => $_SERVER['REMOTE_ADDR'] ?? ''
]);

$options = [
    'http' => [
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => $verifyData
    ]
];

$context  = stream_context_create($options);
$verifyResult = file_get_contents($verifyUrl, false, $context);
$responseData = json_decode($verifyResult, true);

if (!$responseData || !isset($responseData['success']) || $responseData['success'] !== true) {
    echo json_encode(['status' => 'error', 'msg' => 'Verifikasi keamanan Turnstile gagal. Silakan coba lagi.']);
    exit;
}

// 2. Decode Parameter Input dari JS Frontend
$nzToken     = hex2bin($_POST['NZusjs'] ?? '');
$expiredTime = decodeHexBase64($_POST['Jks24sfd'] ?? '');
$gameType    = decodeHexBase64($_POST['KjUwg201hjsa'] ?? '');

if (empty($gameType)) {
    echo json_encode(['status' => 'error', 'msg' => 'Game tidak valid atau parameter tidak lengkap.']);
    exit;
}

// 3. Buat TransID / Key unik
$transId = "TRIS-" . strtoupper(substr(md5(uniqid(rand(), true)), 0, 10));

// Simpan transaksi/key ke database atau file JSON lokal
$orderData = [
    'transid'     => $transId,
    'game'        => $gameType,
    'duration'    => $expiredTime,
    'created_at'  => date('Y-m-d H:i:s'),
    'ip_address'  => $_SERVER['REMOTE_ADDR'] ?? ''
];

// Contoh penyimpanan sederhana ke file JSON local
$ordersFile = __DIR__ . '/orders.json';
$existingOrders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];
$existingOrders[$transId] = $orderData;
file_get_contents($ordersFile, false, stream_context_create([])); 
file_put_contents($ordersFile, json_encode($existingOrders, JSON_PRETTY_PRINT));

// Return respon sukses ke JS frontend
echo json_encode([
    'status'  => 'success',
    'transid' => $transId,
    'msg'     => 'Berhasil membuat key.'
]);
exit;
?>
