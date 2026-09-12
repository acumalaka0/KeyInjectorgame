<?php
// config.php

// Secret Key Cloudflare Turnstile dari screenshot Anda
define('TURNSTILE_SECRET_KEY', '0x4AAAAAACzDxGxM5cDqgo3NLwIjJSIta5w');

// Token API Backend
define('API_TOKEN_RAW', 'Y25LVl9JcURteV9XQ2toU3JKZnJZcDBEZUNwVmdDSTVVeWhtQUE3aFRCdjE0c1dxZWhzcXFEZjBkS0VFV3hCVkFjd19rNVFuWk4teGY5bXE3cllscElHUjRwYU45UkdZSjFLWDNnb1dGSkU=');

// Fungsi pembantu decode data
function decodeHexBase64($data) {
    if (empty($data)) return '';
    $decodedBase64 = base64_decode($data);
    return hex2bin($decodedBase64);
}
?>
