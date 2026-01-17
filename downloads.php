<?php
$pageTitle = 'Iron Viper Squadron | Downloads';
$activePage = 'downloads';
require_once __DIR__ . '/private/bootstrap.php';

$downloads = db_fetch_all('SELECT title, access_level, size_label, notes, file_url FROM downloads ORDER BY created_at DESC');

include __DIR__ . '/header.php';
?>

<section class="section">
  <h2>Downloads</h2>
  <p class="subtle">Member-only downloads are available after login.</p>
  <?php if (!$downloads): ?>
    <div class="notice">No downloads available yet.</div>
  <?php else: ?>
    <div class="grid">
      <?php foreach ($downloads as $item): ?>
        <?php
          $type = $item['access_level'] ?? 'public';
          $isMemberFile = $type === 'Members Only' || $type === 'members';
          $hasAccess = !$isMemberFile || has_permission('member_downloads', $config);
        ?>
        <div class="card">
          <h3><?php echo htmlspecialchars($item['title']); ?></h3>
          <p class="subtle"><?php echo htmlspecialchars($type); ?> · <?php echo htmlspecialchars($item['size_label'] ?? ''); ?></p>
          <p><?php echo htmlspecialchars($item['notes']); ?></p>
          <?php if ($hasAccess): ?>
            <a class="btn" href="<?php echo htmlspecialchars($item['file_url'] ?? '#'); ?>">Download</a>
          <?php else: ?>
            <div class="notice error">Login required for this download.</div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>
