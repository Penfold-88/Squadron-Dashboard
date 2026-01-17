<?php
$pageTitle = 'Iron Viper Squadron | Gallery';
$activePage = 'gallery';
$galleryDir = __DIR__ . '/gallery';
$images = [];
if (is_dir($galleryDir)) {
    $images = array_values(array_filter(scandir($galleryDir), function ($file) {
        return preg_match('/\.(jpg|jpeg|png|gif)$/i', $file);
    }));
}
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
          <img src="/gallery/<?php echo rawurlencode($image); ?>" alt="Squadron sortie image" />
          <figcaption><?php echo htmlspecialchars($image); ?></figcaption>
        </figure>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>
