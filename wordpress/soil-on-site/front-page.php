<?php
/**
 * Front page template.
 */

if (!defined('ABSPATH')) {
    exit;
}

get_header();

$quote_status = isset($_GET['quote']) ? sanitize_key(wp_unslash($_GET['quote'])) : '';
$quote_success = $quote_status === 'success';
$quote_error = $quote_status === 'error';
$phone = sos_mod('sos_phone');
$email = sos_mod('sos_email');
?>

<section id="hero" aria-labelledby="hero-heading">
  <div class="hero-inner">
    <div class="hero-content">
      <h1 class="hero-title" id="hero-heading"><?php echo wp_kses_post(nl2br(esc_html(sos_mod('sos_hero_title')))); ?></h1>
      <p class="hero-body"><?php echo esc_html(sos_mod('sos_hero_body')); ?></p>
      <div class="hero-ctas">
        <a href="#contact" class="btn-primary"><?php echo esc_html(sos_mod('sos_hero_button')); ?></a>
      </div>
    </div>

    <dl class="hero-proof" aria-label="<?php esc_attr_e('Soil On Site service summary', 'soil-on-site'); ?>">
      <?php foreach (sos_pipe_rows('sos_hero_proof') as $index => $row) : ?>
        <div>
          <?php echo sos_proof_icon($index); ?>
          <dt><?php echo esc_html($row['title']); ?></dt>
          <dd><?php echo esc_html($row['body']); ?></dd>
        </div>
      <?php endforeach; ?>
    </dl>

    <div class="hero-photo" aria-hidden="true">
      <?php if (get_theme_mod('sos_hero_image', '')) : ?>
        <img src="<?php echo esc_url(get_theme_mod('sos_hero_image', '')); ?>" alt="<?php esc_attr_e('Illustration of on-site domestic sewer management system', 'soil-on-site'); ?>" width="1536" height="1024" loading="eager" fetchpriority="high" decoding="sync" />
      <?php else : ?>
        <img src="<?php echo esc_url(sos_asset('assets/photos/hero-onsite-system.png')); ?>" alt="<?php esc_attr_e('Illustration of on-site domestic sewer management system with house, tank, and effluent disposal area', 'soil-on-site'); ?>" width="1536" height="1024" loading="eager" fetchpriority="high" decoding="sync" />
      <?php endif; ?>
    </div>
  </div>
</section>

<section id="when" aria-labelledby="when-heading">
  <div class="when-inner container">
    <div class="when-text">
      <span class="section-label"><?php echo esc_html(sos_mod('sos_when_label')); ?></span>
      <h2 class="section-title" id="when-heading"><?php echo esc_html(sos_mod('sos_when_title')); ?></h2>
      <div class="divider divider-left"></div>
      <p class="section-intro"><?php echo esc_html(sos_mod('sos_when_intro')); ?></p>
      <p class="section-intro section-intro-wide"><?php echo esc_html(sos_mod('sos_when_detail')); ?></p>
      <ul class="when-list">
        <?php foreach (sos_lines('sos_when_items') as $item) : ?>
          <li>
            <span class="when-icon" aria-hidden="true">
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
            </span>
            <span><?php echo esc_html($item); ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>

    <div class="system-types">
      <h3><?php echo esc_html(sos_mod('sos_system_title')); ?></h3>
      <p><?php echo esc_html(sos_mod('sos_system_body')); ?></p>
      <ul class="system-chips" aria-label="<?php esc_attr_e('Wastewater system types we assess', 'soil-on-site'); ?>">
        <?php foreach (sos_lines('sos_system_chips') as $chip) : ?>
          <li><?php echo esc_html($chip); ?></li>
        <?php endforeach; ?>
      </ul>
      <div class="system-photo-grid" aria-label="<?php esc_attr_e('Examples of on-site wastewater systems', 'soil-on-site'); ?>">
        <figure class="system-photo">
          <?php sos_image('sos_system_image_one', 'assets/photos/webp/IMG20250123164330.webp', 'assets/photos/opt/IMG20250123164330.jpg', 'Effluent disposal bed on a rural property', 'width="480" height="360" loading="eager" decoding="async"'); ?>
          <figcaption>Disposal area</figcaption>
        </figure>
        <figure class="system-photo">
          <?php sos_image('sos_system_image_two', 'assets/photos/webp/IMG20251027102323.webp', 'assets/photos/opt/IMG20251027102323.jpg', 'On-site wastewater treatment tank access lids', 'width="480" height="360" loading="eager" decoding="async"'); ?>
          <figcaption>Treatment system</figcaption>
        </figure>
      </div>
    </div>
  </div>
</section>

<section id="process" aria-labelledby="process-heading">
  <div class="process-inner container">
    <div class="process-head">
      <span class="section-label"><?php echo esc_html(sos_mod('sos_process_label')); ?></span>
      <h2 class="section-title" id="process-heading"><?php echo esc_html(sos_mod('sos_process_title')); ?></h2>
      <div class="divider"></div>
      <p class="section-intro"><?php echo esc_html(sos_mod('sos_process_intro')); ?></p>
    </div>

    <ol class="process-steps" aria-label="<?php esc_attr_e('Investigation process steps', 'soil-on-site'); ?>">
      <?php foreach (sos_pipe_rows('sos_process_steps') as $index => $row) : ?>
        <li class="process-step">
          <span class="step-num" aria-hidden="true"><?php echo esc_html((string) ($index + 1)); ?></span>
          <div class="step-body">
            <h3><?php echo esc_html($row['title']); ?></h3>
            <p><?php echo esc_html($row['body']); ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>

    <div class="process-fieldwork">
      <div class="fieldwork-photo" aria-hidden="true">
        <?php sos_image('sos_fieldwork_image', 'assets/photos/webp/IMG20251028152407_01.webp', 'assets/photos/opt/IMG20251028152407_01.jpg', 'Undeveloped rural site assessed for on-site wastewater suitability', 'width="480" height="380" loading="eager" decoding="async"'); ?>
      </div>
      <div class="fieldwork-text">
        <h3><?php echo esc_html(sos_mod('sos_fieldwork_title')); ?></h3>
        <p><?php echo esc_html(sos_mod('sos_fieldwork_body')); ?></p>
        <ul class="field-test-list">
          <?php foreach (sos_lines('sos_fieldwork_tests') as $test) : ?>
            <li><?php echo esc_html($test); ?></li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<section id="next" aria-labelledby="next-heading">
  <div class="next-inner container">
    <div class="next-head">
      <span class="section-label"><?php echo esc_html(sos_mod('sos_next_label')); ?></span>
      <h2 class="section-title" id="next-heading"><?php echo esc_html(sos_mod('sos_next_title')); ?></h2>
      <div class="divider"></div>
    </div>
    <ol class="next-steps" aria-label="<?php esc_attr_e('Client process steps', 'soil-on-site'); ?>">
      <?php foreach (sos_pipe_rows('sos_next_steps') as $index => $row) : ?>
        <li class="next-step">
          <span class="next-num" aria-hidden="true"><?php echo esc_html((string) ($index + 1)); ?></span>
          <div>
            <h3><?php echo esc_html($row['title']); ?></h3>
            <p><?php echo esc_html($row['body']); ?></p>
          </div>
        </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>

<section id="areas" aria-labelledby="areas-heading">
  <div class="areas-inner container">
    <div class="areas-head">
      <span class="section-label"><?php echo esc_html(sos_mod('sos_areas_label')); ?></span>
      <h2 class="section-title" id="areas-heading"><?php echo esc_html(sos_mod('sos_areas_title')); ?></h2>
      <div class="divider"></div>
      <p class="section-intro"><?php echo esc_html(sos_mod('sos_areas_intro')); ?></p>
    </div>

    <ul class="areas-grid" aria-label="<?php esc_attr_e('Council areas we service', 'soil-on-site'); ?>">
      <?php foreach (sos_lines('sos_areas') as $area) : ?>
        <li class="area-chip"><?php echo esc_html($area); ?></li>
      <?php endforeach; ?>
    </ul>

    <div class="areas-cta">
      <p><?php echo esc_html(sos_mod('sos_areas_cta_text')); ?></p>
      <a href="#contact" class="btn-outline"><?php echo esc_html(sos_mod('sos_areas_cta_button')); ?></a>
    </div>
  </div>
</section>

<section id="faq" aria-labelledby="faq-heading">
  <div class="faq-inner container">
    <div class="faq-head">
      <span class="section-label"><?php echo esc_html(sos_mod('sos_faq_label')); ?></span>
      <h2 class="section-title" id="faq-heading"><?php echo esc_html(sos_mod('sos_faq_title')); ?></h2>
      <div class="divider"></div>
    </div>

    <div class="faq-list">
      <?php $faq_index = 0; ?>
      <?php foreach (sos_faq_rows() as $row) : ?>
        <?php if ($row['type'] === 'section') : ?>
          <h3 class="faq-section-title"><?php echo esc_html($row['title']); ?></h3>
        <?php else : ?>
          <?php $faq_index++; ?>
          <div class="faq-item">
            <button class="faq-question" aria-expanded="false" aria-controls="faq-<?php echo esc_attr((string) $faq_index); ?>">
              <?php echo esc_html($row['question']); ?>
              <svg class="faq-chevron" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
            </button>
            <div class="faq-answer" id="faq-<?php echo esc_attr((string) $faq_index); ?>" role="region">
              <?php echo wp_kses_post(wpautop($row['answer'])); ?>
            </div>
          </div>
        <?php endif; ?>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="contact" aria-labelledby="contact-heading">
  <div class="contact-inner container">
    <div class="contact-info">
      <span class="section-label"><?php echo esc_html(sos_mod('sos_contact_label')); ?></span>
      <h2 id="contact-heading"><?php echo esc_html(sos_mod('sos_contact_title')); ?></h2>
      <p class="contact-ready"><?php echo esc_html(sos_mod('sos_contact_ready')); ?></p>
      <p><?php echo esc_html(sos_mod('sos_contact_body')); ?></p>
      <p class="contact-files-note">
        <?php echo esc_html(sos_mod('sos_contact_note')); ?>
        <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>.
      </p>

      <div class="contact-links">
        <a href="<?php echo esc_url(sos_tel_href($phone)); ?>" class="contact-link" aria-label="<?php echo esc_attr('Call Soil On Site on ' . $phone); ?>">
          <span class="contact-link-icon" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 12 19.79 19.79 0 0 1 1.65 3.27 2 2 0 0 1 3.62 1h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 8.56a16 16 0 0 0 5.99 6l1.28-1.88a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 14.92z"/></svg>
          </span>
          Phone: <?php echo esc_html($phone); ?>
        </a>
        <a href="mailto:<?php echo esc_attr($email); ?>" class="contact-link" aria-label="<?php echo esc_attr('Email ' . $email); ?>">
          <span class="contact-link-icon" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
          </span>
          Email: <?php echo esc_html($email); ?>
        </a>
        <span class="contact-link">
          <span class="contact-link-icon" aria-hidden="true">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2"/><path d="M7 8h10"/><path d="M7 12h10"/><path d="M7 16h6"/></svg>
          </span>
          <?php echo esc_html(sos_mod('sos_abn')); ?>
        </span>
      </div>
    </div>

    <div class="contact-form-box">
      <div class="form-card-head">
        <span>Project intake</span>
        <p>Attach plans where available. Fields marked * are required.</p>
      </div>

      <form id="quote-form" name="quote" method="POST" enctype="multipart/form-data" action="<?php echo esc_url(admin_url('admin-post.php')); ?>" novalidate aria-label="<?php esc_attr_e('Request a quote form', 'soil-on-site'); ?>">
        <input type="hidden" name="action" value="sos_quote" />
        <?php wp_nonce_field('sos_quote', 'sos_nonce'); ?>

        <div class="hp-field" aria-hidden="true">
          <label for="f-website">Leave this blank</label>
          <input type="text" id="f-website" name="_honey" tabindex="-1" autocomplete="off" />
        </div>

        <div class="contact-form-grid" <?php echo $quote_success ? 'style="display:none;"' : ''; ?>>
          <div class="form-section-label full-col">
            <span>01</span>
            <div>
              <h3>Contact details</h3>
              <p>Who we should reply to with the quote.</p>
            </div>
          </div>

          <?php sos_form_input('f-name', 'name', 'Your name', 'text', true, 'Jane Smith', 'name'); ?>
          <?php sos_form_input('f-phone', 'phone', 'Phone', 'tel', true, '0412 345 678', 'tel', 'Australian mobile (04xx) or landline'); ?>
          <?php sos_form_input('f-email', 'email', 'Email address', 'email', true, 'you@email.com', 'email', '', true); ?>
          <?php sos_form_input('f-address', 'address', 'Site address or lot description', 'text', true, 'e.g. 123 Example Rd, Braidwood NSW 2622', 'street-address', '', true); ?>

          <div class="form-section-label full-col">
            <span>02</span>
            <div>
              <h3>Site and project</h3>
              <p>Project type and wastewater load details.</p>
            </div>
          </div>

          <?php sos_form_select('f-project', 'project_type', 'Project type', ['New dwelling / subdivision', 'Existing septic upgrade / replacement', 'Adding bedrooms to existing dwelling', 'Development Application (DA) support', 'Other / not sure']); ?>
          <?php sos_form_select('f-bedrooms-main', 'bedrooms_main', 'Number of bedrooms in main residence', ['1', '2', '3', '4', '5', 'More than 5', 'Not sure / to be confirmed']); ?>
          <?php sos_form_select('f-bedrooms-secondary', 'bedrooms_secondary', 'Number of bedrooms secondary building, if any proposed', ['N/A', '1', '2', '3', '4', '5', 'More than 5', 'Not sure / to be confirmed']); ?>
          <?php sos_form_select('f-dwellings', 'dwellings', 'Number of dwellings/building to be connected to the treatment system', ['1', '2', '3', '4', '5', 'More than 5', 'Not sure / to be confirmed']); ?>

          <div class="form-section-label full-col">
            <span>03</span>
            <div>
              <h3>Plans and notes</h3>
              <p>Upload one plan set, then add constraints or questions.</p>
            </div>
          </div>

          <div class="form-group full-col">
            <label for="f-files">Plans, surveys, or existing reports</label>
            <label class="file-label" id="file-label-el" for="f-files">
              <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
              <span id="file-label-text">Attach one plan set, survey, or existing report (PDF, DWG, JPG - max 16 MB)</span>
            </label>
            <input type="file" id="f-files" name="attachment" accept=".pdf,.jpg,.jpeg,.png,.dwg,.doc,.docx" aria-describedby="f-files-msg" style="position:absolute;width:1px;height:1px;opacity:0;overflow:hidden;" />
            <span class="field-msg" id="f-files-msg" role="alert" aria-live="polite"></span>
          </div>

          <div class="form-group full-col">
            <label for="f-message">Additional details or questions</label>
            <textarea id="f-message" name="message" rows="4" placeholder="Describe your project, any known site constraints, or questions you have." maxlength="2000"></textarea>
            <span class="char-count" id="f-message-count" aria-live="polite"></span>
          </div>
        </div>

        <div class="form-footer" <?php echo $quote_success ? 'style="display:none;"' : ''; ?>>
          <button type="submit" id="form-submit-btn" class="btn-primary btn-submit">
            <span class="btn-label">Request a Quote</span>
            <span class="btn-spinner" aria-hidden="true"></span>
          </button>
          <p class="form-required-note"><span class="req-star">*</span> Required fields</p>
          <p class="form-security-note">Security check may open after sending.</p>
        </div>

        <div id="form-success" class="form-success<?php echo $quote_success ? ' visible' : ''; ?>" role="status" tabindex="-1" aria-live="polite">
          <div class="success-icon" aria-hidden="true">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
          </div>
          <h3>Enquiry received</h3>
          <p>Thank you — we'll review your details and get back to you. If you have plans to send, email them to <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>.</p>
        </div>

        <div id="form-error" class="form-error<?php echo $quote_error ? ' visible' : ''; ?>" role="alert" aria-live="polite">
          The form could not be sent. Please try again, or email your details to <a href="mailto:<?php echo esc_attr($email); ?>"><?php echo esc_html($email); ?></a>.
        </div>
      </form>
    </div>
  </div>
</section>

<?php
get_footer();
