<?php
/**
 * WordPress Customizer controls for client-editable content.
 */

if (!defined('ABSPATH')) {
    exit;
}

add_action('customize_register', function (WP_Customize_Manager $wp_customize): void {
    $wp_customize->add_panel('sos_content', [
        'title' => __('Soil On Site Content', 'soil-on-site'),
        'priority' => 30,
    ]);

    sos_customizer_section($wp_customize, 'sos_brand', 'Brand / SEO', [
        ['sos_logo_name', 'Site name'],
        ['sos_logo_sub', 'Small tagline'],
        ['sos_meta_description', 'Meta description', 'textarea'],
    ]);

    sos_customizer_section($wp_customize, 'sos_hero', 'Hero', [
        ['sos_hero_eyebrow', 'Eyebrow'],
        ['sos_hero_title', 'Main headline', 'textarea'],
        ['sos_hero_service', 'Service line', 'textarea'],
        ['sos_hero_subtitle', 'Subtitle'],
        ['sos_hero_question', 'Question', 'textarea'],
        ['sos_hero_body', 'Body copy', 'textarea'],
        ['sos_hero_button', 'Button text'],
        ['sos_hero_proof', 'Summary items: Label|Text per line', 'textarea'],
    ]);
    sos_customizer_image($wp_customize, 'sos_hero_image', 'sos_hero', 'Hero image override');

    sos_customizer_section($wp_customize, 'sos_when', 'When Needed / System Types', [
        ['sos_when_label', 'Section label'],
        ['sos_when_title', 'Section title'],
        ['sos_when_intro', 'Intro'],
        ['sos_when_detail', 'Detail paragraph', 'textarea'],
        ['sos_when_items', 'Checklist: one item per line', 'textarea'],
        ['sos_system_title', 'System title'],
        ['sos_system_body', 'System body', 'textarea'],
        ['sos_system_chips', 'System chips: one item per line', 'textarea'],
    ]);
    sos_customizer_image($wp_customize, 'sos_system_image_one', 'sos_when', 'System image 1 override');
    sos_customizer_image($wp_customize, 'sos_system_image_two', 'sos_when', 'System image 2 override');

    sos_customizer_section($wp_customize, 'sos_process', 'Process', [
        ['sos_process_label', 'Section label'],
        ['sos_process_title', 'Section title'],
        ['sos_process_intro', 'Intro'],
        ['sos_process_steps', 'Process steps: Title|Text per line', 'textarea'],
        ['sos_fieldwork_title', 'Fieldwork title'],
        ['sos_fieldwork_body', 'Fieldwork body', 'textarea'],
        ['sos_fieldwork_tests', 'Fieldwork tests: one item per line', 'textarea'],
    ]);
    sos_customizer_image($wp_customize, 'sos_fieldwork_image', 'sos_process', 'Fieldwork image override');

    sos_customizer_section($wp_customize, 'sos_next', 'What To Do Next', [
        ['sos_next_label', 'Section label'],
        ['sos_next_title', 'Section title'],
        ['sos_next_steps', 'Steps: Title|Text per line', 'textarea'],
    ]);

    sos_customizer_section($wp_customize, 'sos_areas', 'Service Areas', [
        ['sos_areas_label', 'Section label'],
        ['sos_areas_title', 'Section title'],
        ['sos_areas_intro', 'Intro'],
        ['sos_areas', 'Areas: one item per line', 'textarea'],
        ['sos_areas_cta_text', 'CTA text'],
        ['sos_areas_cta_button', 'CTA button'],
    ]);

    sos_customizer_section($wp_customize, 'sos_faq', 'FAQ', [
        ['sos_faq_label', 'Section label'],
        ['sos_faq_title', 'Section title'],
        ['sos_faq_items', 'FAQ: use ## Section, then Question|Answer per line', 'textarea'],
    ]);

    sos_customizer_section($wp_customize, 'sos_contact', 'Contact / Form', [
        ['sos_contact_label', 'Section label'],
        ['sos_contact_title', 'Section title'],
        ['sos_contact_ready', 'Ready text'],
        ['sos_contact_body', 'Body', 'textarea'],
        ['sos_contact_note', 'File note'],
        ['sos_phone', 'Phone'],
        ['sos_email', 'Public email'],
        ['sos_abn', 'ABN'],
        ['sos_form_recipient', 'Quote form recipient email'],
        ['sos_footer_disclaimer', 'Footer disclaimer', 'textarea'],
    ]);
});

function sos_customizer_section(WP_Customize_Manager $wp_customize, string $section, string $title, array $fields): void
{
    $wp_customize->add_section($section, [
        'title' => __($title, 'soil-on-site'),
        'panel' => 'sos_content',
    ]);

    foreach ($fields as $field) {
        [$id, $label, $type] = array_pad($field, 3, 'text');
        $wp_customize->add_setting($id, [
            'default' => sos_default($id),
            'sanitize_callback' => $type === 'textarea' ? 'sanitize_textarea_field' : 'sanitize_text_field',
            'transport' => 'refresh',
        ]);

        $wp_customize->add_control($id, [
            'section' => $section,
            'label' => __($label, 'soil-on-site'),
            'type' => $type,
        ]);
    }
}

function sos_customizer_image(WP_Customize_Manager $wp_customize, string $id, string $section, string $label): void
{
    $wp_customize->add_setting($id, [
        'default' => '',
        'sanitize_callback' => 'esc_url_raw',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, $id, [
        'section' => $section,
        'label' => __($label, 'soil-on-site'),
    ]));
}
