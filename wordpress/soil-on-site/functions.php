<?php
/**
 * Soil On Site theme functions.
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/customizer.php';

add_action('after_setup_theme', function () {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');

    register_nav_menus([
        'primary' => __('Primary navigation', 'soil-on-site'),
    ]);
});

add_action('wp_enqueue_scripts', function () {
    wp_enqueue_style(
        'soil-on-site-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700&display=swap',
        [],
        null
    );

    wp_enqueue_style(
        'soil-on-site-site',
        get_theme_file_uri('assets/css/site.css'),
        ['soil-on-site-fonts'],
        '20260512-responsive-pass'
    );

    wp_enqueue_script(
        'soil-on-site-site',
        get_theme_file_uri('assets/js/site.js'),
        [],
        '20260508-file-limit',
        true
    );
});

add_action('admin_post_nopriv_sos_quote', 'sos_handle_quote');
add_action('admin_post_sos_quote', 'sos_handle_quote');

function sos_handle_quote(): void
{
    $redirect = home_url('/');

    if (!isset($_POST['sos_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['sos_nonce'])), 'sos_quote')) {
        wp_safe_redirect(add_query_arg('quote', 'error', $redirect) . '#contact');
        exit;
    }

    if (!empty($_POST['_honey'])) {
        wp_safe_redirect(add_query_arg('quote', 'success', $redirect) . '#contact');
        exit;
    }

    $name    = sanitize_text_field(wp_unslash($_POST['name'] ?? ''));
    $phone   = sanitize_text_field(wp_unslash($_POST['phone'] ?? ''));
    $email   = sanitize_email(wp_unslash($_POST['email'] ?? ''));
    $address = sanitize_text_field(wp_unslash($_POST['address'] ?? ''));

    if ($name === '' || $phone === '' || $email === '' || $address === '' || !is_email($email)) {
        wp_safe_redirect(add_query_arg('quote', 'error', $redirect) . '#contact');
        exit;
    }

    $fields = [
        'Name' => $name,
        'Phone' => $phone,
        'Email' => $email,
        'Site address / lot' => $address,
        'Project type' => sanitize_text_field(wp_unslash($_POST['project_type'] ?? '')),
        'Bedrooms in main residence' => sanitize_text_field(wp_unslash($_POST['bedrooms_main'] ?? '')),
        'Bedrooms in secondary building' => sanitize_text_field(wp_unslash($_POST['bedrooms_secondary'] ?? '')),
        'Dwellings/buildings connected' => sanitize_text_field(wp_unslash($_POST['dwellings'] ?? '')),
        'Additional details' => sanitize_textarea_field(wp_unslash($_POST['message'] ?? '')),
    ];

    $message = "New Soil On Site quote request\n\n";
    foreach ($fields as $label => $value) {
        $message .= $label . ': ' . ($value !== '' ? $value : '-') . "\n";
    }

    $attachments = [];
    if (!empty($_FILES['attachment']['name'])) {
        if (!empty($_FILES['attachment']['size']) && (int) $_FILES['attachment']['size'] > 16 * 1024 * 1024) {
            wp_safe_redirect(add_query_arg('quote', 'error', $redirect) . '#contact');
            exit;
        }

        require_once ABSPATH . 'wp-admin/includes/file.php';

        $upload = wp_handle_upload($_FILES['attachment'], [
            'test_form' => false,
            'mimes' => [
                'pdf'  => 'application/pdf',
                'jpg'  => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png'  => 'image/png',
                'dwg'  => 'application/acad',
                'doc'  => 'application/msword',
                'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
        ]);

        if (!isset($upload['error']) && !empty($upload['file'])) {
            $attachments[] = $upload['file'];
        }
    }

    $to = sanitize_email(get_theme_mod('sos_form_recipient', get_option('admin_email')));
    $headers = [
        'Reply-To: ' . $name . ' <' . $email . '>',
    ];

    $sent = wp_mail($to, 'New Soil On Site quote request', $message, $headers, $attachments);
    wp_safe_redirect(add_query_arg('quote', $sent ? 'success' : 'error', $redirect) . '#contact');
    exit;
}
