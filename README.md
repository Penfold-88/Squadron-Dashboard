# Squadron-Dashboard

## Overview
This project provides a military-styled DCS squadron website with public pages, a private member area, and an administration interface for managing content, users, and theme settings.

## MySQL Setup
1. Create a database and user.
2. Update `private/config.php` with your MySQL credentials.
3. Run the schema:

```sql
SOURCE private/schema.sql;
```

The schema seeds default theme settings and prepares tables for news, events, servers, downloads, gallery images, and users.

## Security Notes
- The site uses CSRF tokens on forms, a honeypot on the contact form, and login rate limiting.
- File uploads are restricted by MIME type and stored outside the private area.
- Add additional production controls (WAF, backups, HTTPS, and stricter upload validation) before going live.

## Admin Quick Start
1. Log in with the seeded `manager / command` account (from `private/config.php`) before you connect MySQL.
2. Create real user accounts in the Administration Interface once the database is configured.
3. Update the theme colors and logo path in the Administration Interface to brand the site.

## Installer
If you prefer a guided setup, visit `/install.php` to configure the database, seed the schema, and create a manager account. Remove `install.php` after setup.
