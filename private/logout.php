<?php
include __DIR__ . '/bootstrap.php';
$_SESSION = [];
session_destroy();
header('Location: /index.php');
exit;
