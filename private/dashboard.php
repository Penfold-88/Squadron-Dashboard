<?php
$pageTitle = 'Iron Viper Squadron | Member Dashboard';
$activePage = 'login';
include __DIR__ . '/bootstrap.php';
require_login();

$user = current_user();
$flash = $_SESSION['flash_notice'] ?? '';
unset($_SESSION['flash_notice']);
include __DIR__ . '/../header.php';
?>

<section class="section">
  <h2>Member Dashboard</h2>
  <?php if ($flash): ?>
    <div class="notice"><?php echo htmlspecialchars($flash); ?></div>
  <?php endif; ?>
  <p class="subtle">Welcome, <?php echo htmlspecialchars($user['username']); ?> · Role: <?php echo htmlspecialchars($config['roles'][$user['role']] ?? $user['role']); ?></p>
  <div class="button-row" style="margin-top:1rem;">
    <a class="btn" href="/downloads.php">Member Downloads</a>
    <a class="btn" href="/private/admin.php">Administration</a>
    <a class="btn" href="/private/logout.php">Logout</a>
  </div>
</section>

<section class="section">
  <h2>Squadron Tools</h2>
  <div class="grid">
    <div class="card">
      <h3>Gallery Upload</h3>
      <p>Verified members can upload images to the public gallery.</p>
      <?php if (has_permission('gallery_upload', $config)): ?>
        <form class="form" method="post" action="/private/actions.php" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>" />
          <input type="hidden" name="action" value="gallery_upload" />
          <label>
            Select image
            <input type="file" name="gallery_image" accept="image/*" />
          </label>
          <button class="btn primary" type="submit">Upload to Gallery</button>
        </form>
      <?php else: ?>
        <div class="notice error">You do not have gallery upload permissions.</div>
      <?php endif; ?>
    </div>

    <div class="card">
      <h3>News Management</h3>
      <p>Squadron editors can post mission reports and announcements.</p>
      <?php if (has_permission('news_manage', $config)): ?>
        <form class="form" method="post" action="/private/actions.php">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>" />
          <input type="hidden" name="action" value="news_add" />
          <label>
            Headline
            <input type="text" name="headline" placeholder="Operation update" />
          </label>
          <label>
            Summary
            <textarea name="summary" rows="3"></textarea>
          </label>
          <button class="btn primary" type="submit">Publish News</button>
        </form>
      <?php else: ?>
        <div class="notice error">You do not have news editor permissions.</div>
      <?php endif; ?>
    </div>

    <div class="card">
      <h3>Downloads Management</h3>
      <p>Squadron editors can upload mission files and documentation.</p>
      <?php if (has_permission('downloads_manage', $config)): ?>
        <form class="form" method="post" action="/private/actions.php" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>" />
          <input type="hidden" name="action" value="download_add" />
          <label>
            File
            <input type="file" name="download_file" />
          </label>
          <label>
            Access Level
            <select name="access_level">
              <option value="public">Public</option>
              <option value="members">Members Only</option>
            </select>
          </label>
          <button class="btn primary" type="submit">Add Download</button>
        </form>
      <?php else: ?>
        <div class="notice error">You do not have downloads editor permissions.</div>
      <?php endif; ?>
    </div>

    <div class="card">
      <h3>Server Map Uploads</h3>
      <p>Admins can upload new mission maps to server storage.</p>
      <?php if (has_permission('server_upload', $config)): ?>
        <form class="form" method="post" action="/private/actions.php" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars(csrf_token()); ?>" />
          <input type="hidden" name="action" value="server_upload" />
          <label>
            Mission Package
            <input type="file" name="mission_package" />
          </label>
          <button class="btn primary" type="submit">Upload Map</button>
        </form>
      <?php else: ?>
        <div class="notice error">You do not have server upload permissions.</div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include __DIR__ . '/../footer.php'; ?>
