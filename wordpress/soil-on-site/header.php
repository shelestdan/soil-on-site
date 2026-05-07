<?php
/**
 * Theme header.
 */

if (!defined('ABSPATH')) {
    exit;
}

$phone = sos_mod('sos_phone');
$email = sos_mod('sos_email');
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo('charset'); ?>" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="<?php echo esc_attr(sos_mod('sos_meta_description')); ?>" />
  <meta name="robots" content="index, follow" />
  <link rel="icon" type="image/svg+xml" href="<?php echo esc_url(sos_asset('assets/favicon.svg')); ?>" />
  <link rel="apple-touch-icon" href="<?php echo esc_url(sos_asset('assets/favicon.svg')); ?>" />
  <link rel="preload" as="image" type="image/webp" href="<?php echo esc_url(sos_asset('assets/photos/webp/IMG20260316090825.webp')); ?>" fetchpriority="high" />
  <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header id="site-header">
  <div class="header-inner">
    <a href="<?php echo esc_url(home_url('/')); ?>#hero" class="site-logo" aria-label="<?php echo esc_attr(sos_mod('sos_logo_name')); ?> — home">
      <span class="logo-name"><?php echo esc_html(sos_mod('sos_logo_name')); ?></span>
      <span class="logo-sub"><?php echo esc_html(sos_mod('sos_logo_sub')); ?></span>
    </a>

    <nav class="nav-links" aria-label="<?php esc_attr_e('Main navigation', 'soil-on-site'); ?>">
      <a href="#when">When Needed</a>
      <a href="#process">Process</a>
      <a href="#areas">Areas</a>
      <a href="#faq">FAQ</a>
      <a href="#contact" class="nav-cta">Request a Quote</a>
    </nav>

    <button class="hamburger" id="hamburger" aria-expanded="false" aria-controls="mobile-nav" aria-label="<?php esc_attr_e('Toggle navigation menu', 'soil-on-site'); ?>">
      <span></span><span></span><span></span>
    </button>
  </div>

  <nav class="mobile-nav" id="mobile-nav" aria-label="<?php esc_attr_e('Mobile navigation', 'soil-on-site'); ?>">
    <a href="#when">When Needed</a>
    <a href="#process">Process</a>
    <a href="#areas">Areas</a>
    <a href="#faq">FAQ</a>
    <a href="#contact" class="nav-cta">Request a Quote</a>
  </nav>
</header>

<main>
