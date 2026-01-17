<?php
$pageTitle = 'Iron Viper Squadron | Server Detail';
$activePage = 'servers';
require_once __DIR__ . '/private/bootstrap.php';

$slug = $_GET['slug'] ?? '';
$server = db_fetch_one('SELECT name, slug, region, status, current_map, slots, description FROM servers WHERE slug = :slug', [
    'slug' => $slug,
]);

include __DIR__ . '/header.php';
?>

<section class="section">
  <h2>Server Detail</h2>
  <?php if (!$server): ?>
    <div class="notice error">Server not found. Return to the main server list to select an active deployment.</div>
  <?php else: ?>
    <div class="grid">
      <div class="card">
        <h3><?php echo htmlspecialchars($server['name']); ?></h3>
        <p><?php echo htmlspecialchars($server['description']); ?></p>
        <ul>
          <li><strong>Region:</strong> <?php echo htmlspecialchars($server['region']); ?></li>
          <li><strong>Map:</strong> <?php echo htmlspecialchars($server['current_map'] ?? ''); ?></li>
          <li><strong>Slots:</strong> <?php echo htmlspecialchars($server['slots']); ?></li>
        </ul>
      </div>
      <div class="card">
        <h3>Operations Notes</h3>
        <p>Replace this section with mission briefings, SRS frequencies, and live API data.</p>
        <p class="subtle">Status API placeholder: <span class="status <?php echo strtolower($server['status']) === 'offline' ? 'offline' : ''; ?>"><?php echo htmlspecialchars($server['status']); ?></span></p>
      </div>
    </div>
  <?php endif; ?>
</section>

<?php include __DIR__ . '/footer.php'; ?>
