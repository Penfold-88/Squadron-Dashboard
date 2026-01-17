<?php
$pageTitle = 'Iron Viper Squadron | News';
$activePage = 'news';
require_once __DIR__ . '/private/bootstrap.php';

$newsItems = db_fetch_all('SELECT title, summary, author, published_at FROM news ORDER BY published_at DESC');
if (!$newsItems) {
    $newsItems = include __DIR__ . '/data/news.php';
}

include __DIR__ . '/header.php';
?>

<section class="section">
  <h2>Squadron News</h2>
  <div class="grid">
    <?php foreach ($newsItems as $item): ?>
      <article class="card">
        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
        <p class="subtle">
          <?php
            $date = $item['published_at'] ?? $item['date'] ?? '';
            echo $date ? date('F j, Y', strtotime($date)) : 'TBD';
          ?> · <?php echo htmlspecialchars($item['author']); ?>
        </p>
        <p><?php echo htmlspecialchars($item['summary']); ?></p>
      </article>
    <?php endforeach; ?>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
