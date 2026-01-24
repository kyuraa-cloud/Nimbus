<?php
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

function auth() {
    if (!isset($_COOKIE['token'])) {
        header("Location: ../auth/login.php");
        exit;
    }

    try {
        return JWT::decode(
            $_COOKIE['token'],
            new Key(JWT_SECRET, 'HS256')
        );
    } catch (Exception $e) {
        header("Location: ../auth/login.php");
        exit;
    }
}
