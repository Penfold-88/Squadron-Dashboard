<?php
$pageTitle = 'Iron Viper Squadron | Login';
$activePage = 'login';
include __DIR__ . '/bootstrap.php';

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $user = authenticate($username, $password, $config);

    if ($user) {
        $_SESSION['user'] = $user;
        header('Location: /private/dashboard.php');
        exit;
    }

    $error = 'Invalid credentials. Try one of the demo accounts listed below.';
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
      <h3>Demo Access</h3>
      <ul>
        <li>pilot / flightdeck (Verified Member)</li>
        <li>editor / briefing (Squadron Editor)</li>
        <li>admin / serverops (Squadron Admin)</li>
        <li>manager / command (Squadron Manager)</li>
      </ul>
      <p class="subtle">Replace these accounts with your real authentication system when integrating a database.</p>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../footer.php'; ?>
