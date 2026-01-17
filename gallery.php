<?php
$pageTitle = 'Iron Viper Squadron | Gallery';
$activePage = 'gallery';
require_once __DIR__ . '/private/bootstrap.php';

$images = db_fetch_all('SELECT filename, caption FROM gallery_images ORDER BY uploaded_at DESC');

include __DIR__ . '/header.php';
?>

<section class="section">
  <h2>Image Gallery</h2>
  <p class="subtle">Gallery auto-updates by reading image files from the <code>/gallery</code> directory.</p>
  <?php if (!$images): ?>
    <div class="notice">No images found yet. Upload images to the gallery folder to populate this page.</div>
  <?php else: ?>
    <div class="gallery" style="margin-top:1.5rem;">
      <?php foreach ($images as $image): ?>
        <figure>
          <img src="/gallery/<?php echo rawurlencode($image['filename']); ?>" alt="Squadron sortie image" />
          <figcaption><?php echo htmlspecialchars($image['caption'] ?? $image['filename']); ?></figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>
