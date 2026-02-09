<?php
$password = '123';

// Generate bcrypt (default cost)
$hash = password_hash($password, PASSWORD_BCRYPT);
echo "Bcrypt hash: " . $hash . PHP_EOL;

// Verifikasi
if (password_verify($password, $hash)) {
    echo "Password cocok\n";
} else {
    echo "Password salah\n";
}
