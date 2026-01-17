<?php
$pageTitle = 'Iron Viper Squadron | Downloads';
$activePage = 'downloads';
$downloads = include __DIR__ . '/data/downloads.php';
include __DIR__ . '/private/bootstrap.php';
include __DIR__ . '/header.php';
?>

<section class="section">
  <h2>Downloads</h2>
  <p class="subtle">Member-only downloads are available after login.</p>
  <div class="grid">
    <?php foreach ($downloads as $item): ?>
      <?php
        $isMemberFile = $item['type'] === 'Members Only';
        $hasAccess = !$isMemberFile || has_permission('member_downloads', $config);
      ?>
      <div class="card">
        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
        <p class="subtle"><?php echo htmlspecialchars($item['type']); ?> · <?php echo htmlspecialchars($item['size']); ?></p>
        <p><?php echo htmlspecialchars($item['notes']); ?></p>
        <?php if ($hasAccess): ?>
          <a class="btn" href="#">Download</a>
        <?php else: ?>
          <div class="notice error">Login required for this download.</div>
        <?php endif; ?>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
