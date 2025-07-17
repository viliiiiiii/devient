# NFC & QR Marketing App

This is a simple PHP web application demonstrating OTP-based login via email. Users can register and log in with a one-time password sent to their email address. Depending on their role (user, owner, admin) they can access different dashboards. Users can also create marketing items that generate QR codes for sharing URLs.

## Setup
1. Create a MySQL database named `marketing_app` and import `init_db.sql`.
2. Update `config.php` with your database credentials.
3. Configure PHP mail settings so that emails can be sent.
4. Serve the `public` directory with a PHP-capable web server.

## Features
- Registration page
- OTP login via email
- User, owner and admin dashboards
- Create and view marketing items with QR codes

This is a minimal example meant for demonstration and can be extended to support NFC or additional marketing features.
