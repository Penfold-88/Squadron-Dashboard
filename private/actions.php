<?php
require_once __DIR__ . '/bootstrap.php';
require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !verify_csrf($_POST['csrf_token'] ?? null)) {
    header('Location: /private/dashboard.php');
    exit;
}

$action = $_POST['action'] ?? '';

function redirect_with_notice(string $message): void
{
    $_SESSION['flash_notice'] = $message;
    header('Location: /private/dashboard.php');
    exit;
}

if ($action === 'gallery_upload') {
    if (!has_permission('gallery_upload', $config)) {
        redirect_with_notice('Gallery upload denied.');
    }

    if (!isset($_FILES['gallery_image']) || $_FILES['gallery_image']['error'] !== UPLOAD_ERR_OK) {
        redirect_with_notice('No image uploaded.');
    }

    $file = $_FILES['gallery_image'];
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($file['type'], $allowedTypes, true) || $file['size'] > 5 * 1024 * 1024) {
        redirect_with_notice('Unsupported image format.');
    }

    $galleryDir = dirname(__DIR__) . '/gallery';
    if (!is_dir($galleryDir)) {
        mkdir($galleryDir, 0755, true);
    }

    $filename = uniqid('gallery_', true) . '_' . basename($file['name']);
    $destination = $galleryDir . '/' . $filename;
    move_uploaded_file($file['tmp_name'], $destination);

    db_exec(
        'INSERT INTO gallery_images (filename, caption, uploaded_by, uploaded_at) VALUES (:filename, :caption, :uploaded_by, NOW())',
        [
            'filename' => $filename,
            'caption' => pathinfo($file['name'], PATHINFO_FILENAME),
            'uploaded_by' => current_user()['username'] ?? 'member',
        ]
    );

    redirect_with_notice('Image uploaded to gallery.');
}

if ($action === 'news_add') {
    if (!has_permission('news_manage', $config)) {
        redirect_with_notice('News publishing denied.');
    }

    $headline = trim($_POST['headline'] ?? '');
    $summary = trim($_POST['summary'] ?? '');
    if ($headline === '' || $summary === '') {
        redirect_with_notice('Headline and summary are required.');
    }

    db_exec(
        'INSERT INTO news (title, summary, author, published_at) VALUES (:title, :summary, :author, NOW())',
        [
            'title' => $headline,
            'summary' => $summary,
            'author' => current_user()['username'] ?? 'Editor',
        ]
    );

    redirect_with_notice('News article queued.');
}

if ($action === 'download_add') {
    if (!has_permission('downloads_manage', $config)) {
        redirect_with_notice('Download upload denied.');
    }

    if (!isset($_FILES['download_file']) || $_FILES['download_file']['error'] !== UPLOAD_ERR_OK) {
        redirect_with_notice('No download file uploaded.');
    }

    $file = $_FILES['download_file'];
    if ($file['size'] > 50 * 1024 * 1024) {
        redirect_with_notice('Download file too large.');
    }
    $downloadsDir = dirname(__DIR__) . '/downloads';
    if (!is_dir($downloadsDir)) {
        mkdir($downloadsDir, 0755, true);
    }

    $filename = uniqid('download_', true) . '_' . basename($file['name']);
    $destination = $downloadsDir . '/' . $filename;
    move_uploaded_file($file['tmp_name'], $destination);

    $access = $_POST['access_level'] ?? 'public';
    $accessLabel = $access === 'members' ? 'Members Only' : 'Public';

    db_exec(
        'INSERT INTO downloads (title, access_level, size_label, notes, file_url, created_at) VALUES (:title, :access, :size, :notes, :url, NOW())',
        [
            'title' => pathinfo($file['name'], PATHINFO_FILENAME),
            'access' => $access,
            'size' => round($file['size'] / 1024 / 1024, 1) . ' MB',
            'notes' => 'Uploaded by ' . (current_user()['username'] ?? 'Editor'),
            'url' => '/downloads/' . $filename,
        ]
    );

    redirect_with_notice('Download added.');
}

if ($action === 'server_upload') {
    if (!has_permission('server_upload', $config)) {
        redirect_with_notice('Server upload denied.');
    }

    if (!isset($_FILES['mission_package']) || $_FILES['mission_package']['error'] !== UPLOAD_ERR_OK) {
        redirect_with_notice('No mission package uploaded.');
    }

    $file = $_FILES['mission_package'];
    if ($file['size'] > 200 * 1024 * 1024) {
        redirect_with_notice('Mission package too large.');
    }
    $uploadsDir = dirname(__DIR__) . '/uploads/maps';
    if (!is_dir($uploadsDir)) {
        mkdir($uploadsDir, 0755, true);
    }

    $filename = uniqid('mission_', true) . '_' . basename($file['name']);
    $destination = $uploadsDir . '/' . $filename;
    move_uploaded_file($file['tmp_name'], $destination);

    redirect_with_notice('Mission package uploaded to server storage.');
}

redirect_with_notice('Action completed.');
