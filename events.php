<?php
$pageTitle = 'Iron Viper Squadron | Events';
$activePage = 'events';
require_once __DIR__ . '/private/bootstrap.php';

$events = db_fetch_all('SELECT title, event_date, event_time, location FROM events ORDER BY event_date ASC');
if (!$events) {
    $events = include __DIR__ . '/data/events.php';
}

include __DIR__ . '/header.php';
?>

<section class="section">
  <h2>Events Calendar</h2>
  <p class="subtle">Calendar integrations can be synced here for automated scheduling.</p>
  <div class="grid">
    <?php foreach ($events as $event): ?>
      <div class="card">
        <h3><?php echo htmlspecialchars($event['title']); ?></h3>
        <p class="subtle">
          <?php
            $date = $event['event_date'] ?? $event['date'] ?? '';
            echo $date ? date('F j, Y', strtotime($date)) : 'TBD';
          ?> · <?php echo htmlspecialchars($event['event_time'] ?? $event['time'] ?? ''); ?>
        </p>
        <p><?php echo htmlspecialchars($event['location']); ?></p>
      </div>
    <?php endforeach; ?>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
