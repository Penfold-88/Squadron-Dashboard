CREATE TABLE IF NOT EXISTS settings (
  setting_key VARCHAR(100) PRIMARY KEY,
  setting_value TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(80) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  role VARCHAR(40) NOT NULL DEFAULT 'member',
  created_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS news (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  summary TEXT NOT NULL,
  author VARCHAR(120) NOT NULL,
  published_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS events (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  event_date DATE NOT NULL,
  event_time VARCHAR(40) NOT NULL,
  location VARCHAR(120) NOT NULL
);

CREATE TABLE IF NOT EXISTS servers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(120) NOT NULL UNIQUE,
  region VARCHAR(80) NOT NULL,
  status VARCHAR(40) NOT NULL,
  current_map VARCHAR(120) NOT NULL,
  slots VARCHAR(40) NOT NULL,
  description TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS downloads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200) NOT NULL,
  access_level VARCHAR(40) NOT NULL,
  size_label VARCHAR(40) NOT NULL,
  notes TEXT NOT NULL,
  file_url VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL
);

CREATE TABLE IF NOT EXISTS gallery_images (
  id INT AUTO_INCREMENT PRIMARY KEY,
  filename VARCHAR(255) NOT NULL,
  caption VARCHAR(200) NOT NULL,
  uploaded_by VARCHAR(80) NOT NULL,
  uploaded_at DATETIME NOT NULL
);

INSERT INTO settings (setting_key, setting_value) VALUES
  ('theme_accent', '#9aa14b'),
  ('theme_accent_strong', '#c3c964'),
  ('theme_panel', '#111827'),
  ('theme_panel_light', '#1f2937'),
  ('theme_background', '#0b0f14'),
  ('site_logo', '/assets/logo.svg')
ON DUPLICATE KEY UPDATE setting_value = VALUES(setting_value);
