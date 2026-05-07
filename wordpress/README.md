# Soil On Site WordPress Theme

This package converts the static Soil On Site landing page into a custom WordPress theme while keeping the current design and content structure.

## Install

1. In WordPress admin, open `Appearance -> Themes -> Add New -> Upload Theme`.
2. Upload `soil-on-site-theme.zip`.
3. Activate `Soil On Site`.
4. Open `Appearance -> Customize -> Soil On Site Content`.
5. Edit text, service areas, FAQ, contact details, form recipient email, and hero/system/process images.

## Editable Client Blocks

- Brand / SEO
- Hero
- When Needed / System Types
- Process
- What To Do Next
- Service Areas
- FAQ
- Contact / Form

## Form

The quote form posts to WordPress `admin-post.php` and sends email through `wp_mail()`.

Default recipient: `soilonsitensw@gmail.com`.

Change recipient in `Appearance -> Customize -> Soil On Site Content -> Contact / Form -> Quote form recipient email`.

The form uses:

- WordPress nonce
- hidden honeypot spam field
- server-side required-field validation
- WordPress upload handling for one attachment

Important: email delivery depends on WordPress hosting mail configuration. If emails do not arrive, install SMTP on the WordPress site and configure the sender domain.

## Assets

Client photos are bundled inside the theme:

- `assets/photos/opt`
- `assets/photos/webp`

Default images can be replaced from the Customizer without editing code.
