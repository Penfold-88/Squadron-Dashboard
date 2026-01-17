<?php
session_start();

$notice = '';
$errors = [];

if (empty($_SESSION['install_csrf'])) {
    $_SESSION['install_csrf'] = bin2hex(random_bytes(32));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['csrf_token'] ?? '';
    if (!hash_equals($_SESSION['install_csrf'], $token)) {
        $errors[] = 'Security token expired. Please refresh and try again.';
    } else {
        $dbHost = trim($_POST['db_host'] ?? '');
        $dbName = trim($_POST['db_name'] ?? '');
        $dbUser = trim($_POST['db_user'] ?? '');
        $dbPass = $_POST['db_pass'] ?? '';
        $adminUser = trim($_POST['admin_user'] ?? '');
        $adminPass = $_POST['admin_pass'] ?? '';

        if ($dbHost === '' || $dbName === '' || $dbUser === '') {
            $errors[] = 'Database host, name, and user are required.';
        }
        if ($adminUser === '' || $adminPass === '') {
            $errors[] = 'Admin username and password are required.';
        }

        if (!$errors) {
            $dsn = sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4', $dbHost, $dbName);
            try {
                $pdo = new PDO($dsn, $dbUser, $dbPass, [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]);

                $schemaPath = __DIR__ . '/private/schema.sql';
                $schema = file_get_contents($schemaPath);
                if ($schema === false) {
                    $errors[] = 'Schema file not found.';
                } else {
                    $statements = array_filter(array_map('trim', explode(';', $schema)));
                    foreach ($statements as $statement) {
                        $pdo->exec($statement);
                    }

                    $insertUser = $pdo->prepare(
                        'INSERT INTO users (username, password_hash, role, created_at) VALUES (:username, :password, :role, NOW())'
                    );
                    $insertUser->execute([
                        'username' => $adminUser,
                        'password' => password_hash($adminPass, PASSWORD_DEFAULT),
                        'role' => 'manager',
                    ]);

                    $configLocal = "<?php\nreturn [\n    'db' => [\n        'host' => '" . addslashes($dbHost) . "',\n        'name' => '" . addslashes($dbName) . "',\n        'user' => '" . addslashes($dbUser) . "',\n        'password' => '" . addslashes($dbPass) . "',\n    ],\n];\n";
                    file_put_contents(__DIR__ . '/private/config.local.php', $configLocal);

                    $notice = 'Installation complete. Remove install.php and log in with your new manager account.';
                }
            } catch (PDOException $exception) {
                $errors[] = 'Database connection failed: ' . $exception->getMessage();
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Squadron Installer</title>
  <link rel="stylesheet" href="/style.css" />
</head>
<body>
<section class="section">
  <h2>Squadron Installer</h2>
  <p class="subtle">Connect your MySQL database, seed the schema, and create a manager account.</p>

  <?php if ($notice): ?>
    <div class="notice"><?php echo htmlspecialchars($notice); ?></div>
  <?php endif; ?>

  <?php foreach ($errors as $error): ?>
    <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
  <?php endforeach; ?>

  <div class="grid">
    <div class="card">
      <form class="form" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['install_csrf']); ?>" />
        <label>
          Database Host
          <input type="text" name="db_host" placeholder="localhost" value="<?php echo htmlspecialchars($_POST['db_host'] ?? ''); ?>" />
        </label>
        <label>
          Database Name
          <input type="text" name="db_name" placeholder="squadron_dashboard" value="<?php echo htmlspecialchars($_POST['db_name'] ?? ''); ?>" />
        </label>
        <label>
          Database User
          <input type="text" name="db_user" placeholder="squadron_user" value="<?php echo htmlspecialchars($_POST['db_user'] ?? ''); ?>" />
        </label>
        <label>
          Database Password
          <input type="password" name="db_pass" />
        </label>
        <label>
          Manager Username
          <input type="text" name="admin_user" placeholder="manager" value="<?php echo htmlspecialchars($_POST['admin_user'] ?? ''); ?>" />
        </label>
        <label>
          Manager Password
          <input type="password" name="admin_pass" />
        </label>
        <button class="btn primary" type="submit">Run Installer</button>
      </form>
    </div>
    <div class="card">
      <h3>Next Steps</h3>
      <ul>
        <li>Delete <code>install.php</code> after setup.</li>
        <li>Log in and update theme colors and logo path.</li>
        <li>Create additional users in the Administration Interface.</li>
      </ul>
    </div>
  </div>
</section>
</body>
</html>
