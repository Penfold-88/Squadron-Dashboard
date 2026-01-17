<?php
$pageTitle = 'Iron Viper Squadron | Contact';
$activePage = 'contact';
include __DIR__ . '/header.php';
?>

<section class="section">
  <h2>Contact Command</h2>
  <div class="grid">
    <div class="card">
      <h3>Reach Out</h3>
      <p>Submit inquiries for recruitment, joint operations, or media collaboration.</p>
      <form class="form">
        <label>
          Name
          <input type="text" name="name" placeholder="Callsign" />
        </label>
        <label>
          Email
          <input type="email" name="email" placeholder="pilot@email" />
        </label>
        <label>
          Message
          <textarea name="message" rows="4" placeholder="Transmit your request"></textarea>
        </label>
        <button class="btn primary" type="submit">Send Message</button>
      </form>
    </div>
    <div class="card">
      <h3>Headquarters</h3>
      <ul>
        <li>Discord: /invite/ironviper</li>
        <li>Email: command@ironviper.example</li>
        <li>Briefing Room: 19:00 UTC</li>
      </ul>
    </div>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
