# NFC & QR Marketing App

This project is a small demonstration of an OTP based SaaS for NFC and QR code marketing.  Users receive a one-time password via email and, once authenticated, may access pages based on their role.  Companies have their own marketing items and tags so that traffic and scans can be analysed.  Owners can manage everything, admins manage a single company, while normal users can only view analytics.

## Setup
1. Create a MySQL database named `marketing_app` and import `init_db.sql`.
2. Update `config.php` with your database credentials.
3. Configure PHP mail settings so that emails can be sent.
4. Serve the `public` directory with a PHP-capable web server.

## Features
- Registration page
- OTP login via email
- Companies with admins and users
- Owner and admin dashboards for managing tags and marketing items
- Tracking of tag interactions for basic analytics
- Output escaped with `htmlspecialchars` to limit XSS vectors

This is a minimal example meant for demonstration and can be extended to support NFC or additional marketing features.
