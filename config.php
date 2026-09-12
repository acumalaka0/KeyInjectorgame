<?php
// config.php

// Token backend / API Key
define('API_TOKEN_RAW', 'Y25LVl9JcURteV9XQ2toU3JKZnJZcDBEZUNwVmdDSTVVeWhtQUE3aFRCdjE0c1dxZWhzcXFEZjBkS0VFV3hCVkFjd19rNVFuWk4teGY5bXE3cllscElHUjRwYU45UkdZSjFLWDNnb1dGSkU=');

// Ganti dengan Secret Key Cloudflare Turnstile Anda dari dashboard Cloudflare
define('TURNSTILE_SECRET_KEY', '0x4AAAAAACzDxOSs8R4DwJlY_YOUR_SECRET_KEY');

// Fungsi pembantu untuk decode data hex/base64 dari frontend
function decodeHexBase64($data) {
    if (empty($data)) return '';
    $decodedBase64 = base64_decode($data);
    return hex2bin($decodedBase64);
}
?>
