<?php
$pageTitle = 'Iron Viper Squadron | Landing';
$activePage = 'home';
include __DIR__ . '/header.php';
?>

<section class="hero">
  <div class="hero-card">
    <h1>Iron Viper Squadron</h1>
    <p>Combat-ready DCS pilots executing coordinated missions across dynamic theaters. Train with discipline, deploy with precision, and fly with a unified tactical doctrine.</p>
    <div class="button-row">
      <a class="btn primary" href="/private/login.php">Member Access</a>
      <a class="btn" href="/events.php">View Operations</a>
    </div>
  </div>
  <div class="hero-card">
    <h2>Mission Status</h2>
    <ul class="card" style="margin-top:1rem;">
      <li><strong>Alert Level:</strong> <span class="badge">Condition Green</span></li>
      <li><strong>Next Op:</strong> Northern Shield Phase 1</li>
      <li><strong>Briefing Window:</strong> 1900 UTC</li>
      <li><strong>Comms Net:</strong> VHF 251.00 / UHF 305.00</li>
    </ul>
  </div>
</section>

<section class="section">
  <h2>Squadron Snapshot</h2>
  <div class="grid">
    <div class="card">
      <h3>Public Operations</h3>
      <p>Weekly public missions designed to introduce new pilots to coordinated strike packages and comms discipline.</p>
    </div>
    <div class="card">
      <h3>Member Campaign</h3>
      <p>Story-driven campaigns spanning multiple maps with persistent objectives, logistics, and intel debriefs.</p>
    </div>
    <div class="card">
      <h3>Training Pipeline</h3>
      <p>Structured training cells for airframes, doctrine refreshers, and advanced TTPs for verified members.</p>
    </div>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
