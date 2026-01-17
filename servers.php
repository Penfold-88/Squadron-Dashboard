<?php
$pageTitle = 'Iron Viper Squadron | Server Info';
$activePage = 'servers';
$servers = include __DIR__ . '/data/servers.php';
include __DIR__ . '/header.php';
?>

<section class="section">
  <h2>Server Command</h2>
  <p class="subtle">API hooks for live player counts and current map rotations will be wired in here.</p>
  <table class="table" style="margin-top:1.5rem;">
    <thead>
      <tr>
        <th>Server</th>
        <th>Region</th>
        <th>Status</th>
        <th>Map</th>
        <th>Slots</th>
        <th>Details</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($servers as $server): ?>
        <tr>
          <td><?php echo htmlspecialchars($server['name']); ?></td>
          <td><?php echo htmlspecialchars($server['region']); ?></td>
          <td>
            <span class="status <?php echo strtolower($server['status']) === 'offline' ? 'offline' : ''; ?>">
              <?php echo htmlspecialchars($server['status']); ?>
            </span>
          </td>
          <td><?php echo htmlspecialchars($server['map']); ?></td>
          <td><?php echo htmlspecialchars($server['slots']); ?></td>
          <td><a class="btn" href="/server.php?slug=<?php echo urlencode($server['slug']); ?>">View</a></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</section>

<section class="section">
  <h2>Expandable Server Pages</h2>
  <div class="card">
    <p>Each server entry can have its own mission notes, briefing links, and maintenance windows. Add entries in <code>data/servers.php</code> to spin up more pages.</p>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
