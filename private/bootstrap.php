<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$config = include __DIR__ . '/config.php';
if (file_exists(__DIR__ . '/config.local.php')) {
    $localConfig = include __DIR__ . '/config.local.php';
    if (is_array($localConfig)) {
        $config = array_replace_recursive($config, $localConfig);
    }
}
require_once __DIR__ . '/db.php';

$db = db($config);

if (!headers_sent()) {
    header('X-Frame-Options: DENY');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header("Permissions-Policy: geolocation=(), microphone=(), camera=()");
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_logged_in(): bool
{
    return isset($_SESSION['user']);
}

function user_role(): string
{
    return $_SESSION['user']['role'] ?? 'guest';
}

function has_permission(string $permission, array $config): bool
{
    $role = user_role();
    $allowed = $config['permissions'][$permission] ?? [];
    return in_array($role, $allowed, true);
}

function require_login(): void
{
    if (!is_logged_in()) {
        header('Location: /private/login.php');
        exit;
    }
}

function authenticate(string $username, string $password, array $config): ?array
{
    $user = db_fetch_one('SELECT id, username, password_hash, role FROM users WHERE username = :username', [
        'username' => $username,
    ]);
    if ($user && password_verify($password, $user['password_hash'])) {
        return $user;
    }

    return null;
}

function csrf_token(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    return $_SESSION['csrf_token'];
}

function verify_csrf(?string $token): bool
{
    return isset($_SESSION['csrf_token']) && $token && hash_equals($_SESSION['csrf_token'], $token);
}

function get_setting(string $key, string $default = ''): string
{
    $row = db_fetch_one('SELECT setting_value FROM settings WHERE setting_key = :key', ['key' => $key]);
    if ($row && isset($row['setting_value'])) {
        return (string) $row['setting_value'];
    }

    return $default;
}

function set_setting(string $key, string $value): void
{
    db_exec(
        'INSERT INTO settings (setting_key, setting_value) VALUES (:key, :value)\n        ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value)',
        ['key' => $key, 'value' => $value]
    );
}
