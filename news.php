<?php
$pageTitle = 'Iron Viper Squadron | News';
$activePage = 'news';
$newsItems = include __DIR__ . '/data/news.php';
include __DIR__ . '/header.php';
?>

<section class="section">
  <h2>Squadron News</h2>
  <div class="grid">
    <?php foreach ($newsItems as $item): ?>
      <article class="card">
        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
        <p class="subtle"><?php echo date('F j, Y', strtotime($item['date'])); ?> · <?php echo htmlspecialchars($item['author']); ?></p>
        <p><?php echo htmlspecialchars($item['summary']); ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
