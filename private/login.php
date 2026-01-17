<?php
$pageTitle = 'Iron Viper Squadron | Login';
$activePage = 'login';
include __DIR__ . '/bootstrap.php';

$error = '';
$dbStatus = $db instanceof PDO;
if (!$dbStatus) {
    $error = 'Database not connected. Run the installer at /install.php and refresh.';
}
if ($dbStatus) {
    $userCount = db_fetch_one('SELECT COUNT(*) AS total FROM users');
    if ($userCount && (int) $userCount['total'] === 0) {
        $error = 'No user accounts found. Run /install.php to create a manager account.';
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$dbStatus) {
        $error = 'Database not connected. Run the installer at /install.php and refresh.';
    } elseif (isset($userCount['total']) && (int) $userCount['total'] === 0) {
        $error = 'No user accounts found. Run /install.php to create a manager account.';
    } elseif (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $error = 'Security token expired. Please try again.';
    } else {
        $attemptWindow = 600;
        $maxAttempts = 5;
        $attempts = $_SESSION['login_attempts'] ?? ['count' => 0, 'time' => time()];
        if (time() - $attempts['time'] > $attemptWindow) {
            $attempts = ['count' => 0, 'time' => time()];
        }

        if ($attempts['count'] >= $maxAttempts) {
            $error = 'Too many attempts. Please wait a few minutes and try again.';
        } else {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $user = authenticate($username, $password, $config);

            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['login_attempts'] = ['count' => 0, 'time' => time()];
                header('Location: /private/dashboard.php');
                exit;
            }

            $attempts['count']++;
            $_SESSION['login_attempts'] = $attempts;
            $error = 'Invalid credentials. Please try again or contact an admin.';
        }
    }
}

include __DIR__ . '/../header.php';
?>

<section class="section">
  <h2>Member Login</h2>
  <div class="grid">
    <div class="card">
      <?php if ($error): ?>
        <div class="notice error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <form class="form" method="post">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>" />
        <label>
          Username
          <input type="text" name="username" required />
        </label>
        <label>
          Password
          <input type="password" name="password" required />
        </label>
        <button class="btn primary" type="submit">Enter Command Deck</button>
      </form>
    </div>
    <div class="card">
      <h3>Access Notes</h3>
      <ul>
        <li>Use the manager account created during install.</li>
        <li>Additional accounts can be created in the admin panel.</li>
      </ul>
      <p class="subtle">If you have not run the installer, visit <code>/install.php</code> to create your first admin.</p>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../footer.php'; ?>
