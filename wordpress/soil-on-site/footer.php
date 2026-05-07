<?php
/**
 * Theme footer.
 */

if (!defined('ABSPATH')) {
    exit;
}

$phone = sos_mod('sos_phone');
$email = sos_mod('sos_email');
?>
</main>

<footer>
  <div class="footer-inner">
    <div class="footer-top">
      <div class="footer-brand">
        <span class="footer-name"><?php echo esc_html(sos_mod('sos_logo_name')); ?></span>
        <span class="footer-tagline"><?php echo esc_html(sos_mod('sos_logo_sub')); ?></span>
      </div>
      <address class="footer-contact" style="font-style:normal;">
        <a href="<?php echo esc_url(sos_tel_href($phone)); ?>"><?php echo esc_html($phone); ?></a>
        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>
        <span class="footer-abn"><?php echo esc_html(sos_mod('sos_abn')); ?></span>
      </address>
    </div>
    <div class="footer-bottom">
      <p class="footer-copy">&copy; <span id="footer-year"><?php echo esc_html(gmdate('Y')); ?></span> <?php echo esc_html(sos_mod('sos_logo_name')); ?>. All rights reserved.</p>
      <p class="footer-disclaimer"><?php echo esc_html(sos_mod('sos_footer_disclaimer')); ?></p>
    </div>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
