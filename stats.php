<?php
$pageTitle = 'Iron Viper Squadron | Statistics';
$activePage = 'stats';
include __DIR__ . '/header.php';
?>

<section class="section">
  <h2>Squadron Statistics</h2>
  <div class="grid">
    <div class="card">
      <h3>Operational Metrics</h3>
      <ul>
        <li>Sorties Completed: <strong>142</strong></li>
        <li>Mission Success Rate: <strong>91%</strong></li>
        <li>Training Hours Logged: <strong>860</strong></li>
      </ul>
    </div>
    <div class="card">
      <h3>API Roadmap</h3>
      <p>Connect to live telemetry for real-time server stats, squadron activity, and pilot progression.</p>
      <p class="subtle">API endpoint placeholder: <code>/api/v1/stats</code></p>
    </div>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
