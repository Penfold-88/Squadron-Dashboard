<?php
$pageTitle = 'Iron Viper Squadron | Administration';
$activePage = 'login';
include __DIR__ . '/bootstrap.php';
require_login();

$user = current_user();
$canManage = has_permission('site_manage', $config);
include __DIR__ . '/../header.php';
?>

<section class="section">
  <h2>Administration Interface</h2>
  <p class="subtle">Use this control panel to manage squadron settings, permissions, and content workflows.</p>

  <?php if (!$canManage): ?>
    <div class="notice error">You need Squadron Manager permissions to modify administrative settings.</div>
  <?php endif; ?>
</section>

<section class="section">
  <h2>Configuration Settings</h2>
  <div class="grid">
    <div class="card">
      <h3>Squadron Identity</h3>
      <form class="form" method="post" action="#">
        <label>
          Unit Name
          <input type="text" name="unit_name" value="Iron Viper Squadron" <?php echo $canManage ? '' : 'disabled'; ?> />
        </label>
        <label>
          Primary Comms
          <input type="text" name="primary_comms" value="VHF 251.00 / UHF 305.00" <?php echo $canManage ? '' : 'disabled'; ?> />
        </label>
        <label>
          Theme Accent
          <input type="text" name="accent_color" value="#9aa14b" <?php echo $canManage ? '' : 'disabled'; ?> />
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
