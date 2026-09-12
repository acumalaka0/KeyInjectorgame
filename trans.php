<?php
// trans.php
$transid = $_GET['transid'] ?? '';
$ordersFile = __DIR__ . '/orders.json';
$orders = file_exists($ordersFile) ? json_decode(file_get_contents($ordersFile), true) : [];

$order = $orders[$transid] ?? null;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Key - ONLYTRIS PANEL</title>
    <link rel="icon" type="image/x-icon" href="https://panel.onlytris.io.vn/assets/images/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background: #0d0f14;
            color: #fafafa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .card {
            background: rgba(26, 29, 38, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 30px;
            max-width: 480px;
            width: 100%;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            text-align: center;
        }
        .icon-success {
            font-size: 50px;
            color: #10b981;
            margin-bottom: 15px;
        }
        .key-box {
            background: rgba(0,0,0,0.4);
            border: 1px dashed #3b82f6;
            padding: 15px;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            color: #60a5fa;
            margin: 20px 0;
            word-break: break-all;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .btn-copy {
            background: #2563eb;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
        }
        .btn-home {
            display: inline-block;
            margin-top: 15px;
            color: #a1a1aa;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-home:hover { color: white; }
    </style>
</head>
<body>
    <div class="card">
        <?php if ($order): ?>
            <i class="fas fa-check-circle icon-success"></i>
            <h2>Key Berhasil Diambil!</h2>
            <p style="color: #a1a1aa; margin-top: 5px;">Gunakan key di bawah ini pada aplikasi panel Anda:</p>
            
            <div class="key-box">
                <span id="keyValue"><?= htmlspecialchars($order['transid']) ?></span>
                <button class="btn-copy" onclick="copyKey()"><i class="fas fa-copy"></i> Salin</button>
            </div>

            <p style="font-size: 13px; color: #71717a;">Game: <?= htmlspecialchars($order['game']) ?></p>
        <?php else: ?>
            <i class="fas fa-times-circle" style="font-size: 50px; color: #ef4444; margin-bottom: 15px;"></i>
            <h2>Transaksi Tidak Ditemukan</h2>
            <p style="color: #a1a1aa; margin-top: 5px;">ID Transaksi tidak valid atau telah kadaluarsa.</p>
        <?php endif; ?>

        <a href="index.html" class="btn-home"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
    </div>

    <script>
        function copyKey() {
            var keyText = document.getElementById('keyValue').innerText;
            navigator.clipboard.writeText(keyText).then(() => {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Key berhasil disalin!',
                    showConfirmButton: false,
                    timer: 2000
                });
            });
        }
    </script>
</body>
</html>
