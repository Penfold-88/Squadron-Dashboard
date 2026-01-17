<?php
$pageTitle = 'Iron Viper Squadron | Administration';
$activePage = 'login';
include __DIR__ . '/bootstrap.php';
require_login();

$user = current_user();
$canManage = has_permission('site_manage', $config);
$notice = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $canManage) {
    if (!verify_csrf($_POST['csrf_token'] ?? null)) {
        $notice = 'Security token expired. Please refresh and try again.';
    } else {
        $action = $_POST['action'] ?? '';
        if ($action === 'update_settings') {
            set_setting('theme_accent', trim($_POST['theme_accent'] ?? '#9aa14b'));
            set_setting('theme_accent_strong', trim($_POST['theme_accent_strong'] ?? '#c3c964'));
            set_setting('theme_panel', trim($_POST['theme_panel'] ?? '#111827'));
            set_setting('theme_panel_light', trim($_POST['theme_panel_light'] ?? '#1f2937'));
            set_setting('theme_background', trim($_POST['theme_background'] ?? '#0b0f14'));
            set_setting('site_logo', trim($_POST['site_logo'] ?? '/assets/logo.svg'));
            $notice = 'Settings updated.';
        }

        if ($action === 'add_user') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'member';

            if ($username && $password) {
                db_exec(
                    'INSERT INTO users (username, password_hash, role, created_at) VALUES (:username, :password, :role, NOW())',
                    [
                        'username' => $username,
                        'password' => password_hash($password, PASSWORD_DEFAULT),
                        'role' => $role,
                    ]
                );
                $notice = 'User account created.';
            } else {
                $notice = 'Username and password are required.';
            }
        }

        if ($action === 'update_role') {
            $userId = (int) ($_POST['user_id'] ?? 0);
            $role = $_POST['role'] ?? 'member';
            if ($userId > 0) {
                db_exec('UPDATE users SET role = :role WHERE id = :id', ['role' => $role, 'id' => $userId]);
                $notice = 'User role updated.';
            }
        }
    }
}

$settings = [
    'accent' => get_setting('theme_accent', '#9aa14b'),
    'accent_strong' => get_setting('theme_accent_strong', '#c3c964'),
    'panel' => get_setting('theme_panel', '#111827'),
    'panel_light' => get_setting('theme_panel_light', '#1f2937'),
    'background' => get_setting('theme_background', '#0b0f14'),
    'logo' => get_setting('site_logo', '/assets/logo.svg'),
];

$users = db_fetch_all('SELECT id, username, role, created_at FROM users ORDER BY created_at DESC');
if (!$users) {
    $users = array_map(function ($fallbackUser) {
        return [
            'id' => 0,
            'username' => $fallbackUser['username'],
            'role' => $fallbackUser['role'],
            'created_at' => 'Seeded',
        ];
    }, $config['users']);
}
include __DIR__ . '/../header.php';
?>

<section class="section">
  <h2>Administration Interface</h2>
  <p class="subtle">Use this control panel to manage squadron settings, permissions, and content workflows.</p>

  <?php if (!$canManage): ?>
    <div class="notice error">You need Squadron Manager permissions to modify administrative settings.</div>
  <?php elseif ($notice): ?>
    <div class="notice"><?php echo htmlspecialchars($notice); ?></div>
  <?php endif; ?>
</section>

<section class="section">
  <h2>Configuration Settings</h2>
  <div class="grid">
    <div class="card">
      <h3>Squadron Identity</h3>
      <form class="form" method="post" action="/private/admin.php">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>" />
        <input type="hidden" name="action" value="update_settings" />
        <label>
          Accent Color
          <input type="text" name="theme_accent" value="<?php echo htmlspecialchars($settings['accent']); ?>" <?php echo $canManage ? '' : 'disabled'; ?> />
        </label>
        <label>
          Accent Highlight
          <input type="text" name="theme_accent_strong" value="<?php echo htmlspecialchars($settings['accent_strong']); ?>" <?php echo $canManage ? '' : 'disabled'; ?> />
        </label>
        <label>
          Panel Background
          <input type="text" name="theme_panel" value="<?php echo htmlspecialchars($settings['panel']); ?>" <?php echo $canManage ? '' : 'disabled'; ?> />
        </label>
        <label>
          Panel Highlight
          <input type="text" name="theme_panel_light" value="<?php echo htmlspecialchars($settings['panel_light']); ?>" <?php echo $canManage ? '' : 'disabled'; ?> />
        </label>
        <label>
          Page Background
          <input type="text" name="theme_background" value="<?php echo htmlspecialchars($settings['background']); ?>" <?php echo $canManage ? '' : 'disabled'; ?> />
        </label>
        <label>
          Logo Path
          <input type="text" name="site_logo" value="<?php echo htmlspecialchars($settings['logo']); ?>" <?php echo $canManage ? '' : 'disabled'; ?> />
        </label>
        <button class="btn primary" type="submit" <?php echo $canManage ? '' : 'disabled'; ?>>Save Settings</button>
      </form>
    </div>
    <div class="card">
      <h3>Role Matrix</h3>
      <table class="table">
        <thead>
          <tr>
            <th>Permission</th>
            <th>Roles</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($config['permissions'] as $permission => $roles): ?>
            <tr>
              <td><?php echo htmlspecialchars($permission); ?></td>
              <td><?php echo htmlspecialchars(implode(', ', $roles)); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="section">
  <h2>User Access Management</h2>
  <div class="grid">
    <div class="card">
      <h3>Add User</h3>
      <form class="form" method="post" action="/private/admin.php">
        <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>" />
        <input type="hidden" name="action" value="add_user" />
        <label>
          Username
          <input type="text" name="username" <?php echo $canManage ? '' : 'disabled'; ?> />
        </label>
        <label>
          Password
          <input type="password" name="password" <?php echo $canManage ? '' : 'disabled'; ?> />
        </label>
        <label>
          Role
          <select name="role" <?php echo $canManage ? '' : 'disabled'; ?>>
            <?php foreach ($config['roles'] as $roleKey => $roleLabel): ?>
              <option value="<?php echo htmlspecialchars($roleKey); ?>"><?php echo htmlspecialchars($roleLabel); ?></option>
            <?php endforeach; ?>
          </select>
        </label>
        <button class="btn primary" type="submit" <?php echo $canManage ? '' : 'disabled'; ?>>Create User</button>
      </form>
    </div>
    <div class="card">
      <h3>Existing Users</h3>
      <table class="table">
        <thead>
          <tr>
            <th>User</th>
            <th>Role</th>
            <th>Created</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($users as $member): ?>
            <tr>
              <td><?php echo htmlspecialchars($member['username']); ?></td>
              <td>
                <form method="post" action="/private/admin.php" class="form">
                  <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>" />
                  <input type="hidden" name="action" value="update_role" />
                  <input type="hidden" name="user_id" value="<?php echo (int) $member['id']; ?>" />
                  <select name="role" <?php echo $canManage && $member['id'] ? '' : 'disabled'; ?>>
                    <?php foreach ($config['roles'] as $roleKey => $roleLabel): ?>
                      <option value="<?php echo htmlspecialchars($roleKey); ?>" <?php echo $member['role'] === $roleKey ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($roleLabel); ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                  <button class="btn" type="submit" <?php echo $canManage && $member['id'] ? '' : 'disabled'; ?>>Save</button>
                </form>
              </td>
              <td><?php echo htmlspecialchars($member['created_at']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<section class="section">
  <h2>Admin Checklist</h2>
  <div class="grid">
    <div class="card">
      <h3>Content Modules</h3>
      <ul>
        <li>News feed with editor approvals.</li>
        <li>Download library with public/member tiers.</li>
        <li>Gallery uploads with moderation queue.</li>
      </ul>
    </div>
    <div class="card">
      <h3>Server Integrations</h3>
      <ul>
        <li>Live server status API.</li>
        <li>Player roster & awards sync.</li>
        <li>Map rotation scheduler.</li>
      </ul>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../footer.php'; ?>
