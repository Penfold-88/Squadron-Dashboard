<?php

function db(array $config): ?PDO
{
    static $pdo = null;

    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $dbConfig = $config['db'] ?? [];
    if (empty($dbConfig['host']) || empty($dbConfig['name']) || empty($dbConfig['user'])) {
        return null;
    }

    $dsn = sprintf(
        'mysql:host=%s;dbname=%s;charset=utf8mb4',
        $dbConfig['host'],
        $dbConfig['name']
    );

    try {
        $pdo = new PDO($dsn, $dbConfig['user'], $dbConfig['password'] ?? '', [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } catch (PDOException $exception) {
        return null;
    }

    return $pdo;
}

function db_fetch_all(string $sql, array $params = []): array
{
    $pdo = $GLOBALS['db'] ?? null;
    if (!$pdo instanceof PDO) {
        return [];
    }

    $statement = $pdo->prepare($sql);
    $statement->execute($params);

    return $statement->fetchAll();
}

function db_fetch_one(string $sql, array $params = []): ?array
{
    $pdo = $GLOBALS['db'] ?? null;
    if (!$pdo instanceof PDO) {
        return null;
    }

    $statement = $pdo->prepare($sql);
    $statement->execute($params);
    $result = $statement->fetch();

    return $result ?: null;
}

function db_exec(string $sql, array $params = []): bool
{
    $pdo = $GLOBALS['db'] ?? null;
    if (!$pdo instanceof PDO) {
        return false;
    }

    $statement = $pdo->prepare($sql);

    return $statement->execute($params);
}
