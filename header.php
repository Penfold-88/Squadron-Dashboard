<?php
$activePage = $activePage ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title><?php echo htmlspecialchars($pageTitle ?? 'Squadron Command'); ?></title>
  <link rel="stylesheet" href="/style.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;600;700&display=swap" rel="stylesheet" />
</head>
<body>
<header>
  <div class="nav-wrap">
    <div class="brand">
      <span class="brand-badge">DCS</span>
      <span>Iron Viper Squadron</span>
    </div>
    <nav class="nav-links">
      <a class="<?php echo $activePage === 'home' ? 'active' : ''; ?>" href="/index.php">Landing</a>
      <a class="<?php echo $activePage === 'news' ? 'active' : ''; ?>" href="/news.php">News</a>
      <a class="<?php echo $activePage === 'links' ? 'active' : ''; ?>" href="/links.php">External Links</a>
      <a class="<?php echo $activePage === 'servers' ? 'active' : ''; ?>" href="/servers.php">Server Info</a>
      <a class="<?php echo $activePage === 'gallery' ? 'active' : ''; ?>" href="/gallery.php">Gallery</a>
      <a class="<?php echo $activePage === 'downloads' ? 'active' : ''; ?>" href="/downloads.php">Downloads</a>
      <a class="<?php echo $activePage === 'events' ? 'active' : ''; ?>" href="/events.php">Events</a>
      <a class="<?php echo $activePage === 'stats' ? 'active' : ''; ?>" href="/stats.php">Statistics</a>
      <a class="<?php echo $activePage === 'contact' ? 'active' : ''; ?>" href="/contact.php">Contact</a>
      <a class="<?php echo $activePage === 'login' ? 'active' : ''; ?>" href="/private/login.php">Login</a>
    </nav>
  </div>
</header>
