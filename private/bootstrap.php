<?php
session_start();

$config = include __DIR__ . '/config.php';

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
    foreach ($config['users'] as $user) {
        if ($user['username'] === $username && password_verify($password, $user['password'])) {
            return $user;
        }
    }

    return null;
}
