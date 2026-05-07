<?php
/**
 * Helpers and default editable content.
 */

if (!defined('ABSPATH')) {
    exit;
}

function sos_defaults(): array
{
    return [
        'sos_meta_description' => 'Council-ready OSSM and soil assessment reports for NSW and ACT. Independent site investigations, wastewater design, and DA-ready documentation for unsewered properties.',
        'sos_logo_name' => 'Soil On Site',
        'sos_logo_sub' => 'OSSM & Wastewater Reports — NSW & ACT',
        'sos_hero_eyebrow' => 'NSW & ACT · Wastewater Engineers',
        'sos_hero_title' => 'On-Site Sewer Management (OSSM) – Effluent Disposal & Soil Assessment Reports',
        'sos_hero_service' => 'Council-ready soil assessment and wastewater reports for NSW & ACT.',
        'sos_hero_subtitle' => 'Expert Wastewater Solutions for Your Development',
        'sos_hero_question' => 'Are you planning a new build or subdivision on a property without a sewer connection?',
        'sos_hero_body' => 'Soil On Site provides professional, council-ready On-Site Sewage Management (OSSM) and soil assessment reports. Our reports are designed to streamline your Development Application (DA) and ensure full compliance with AS/NZS 1547 and local government requirements across NSW and ACT.',
        'sos_hero_button' => 'Request a Quote',
        'sos_hero_proof' => "Scope|OSSM, soil assessment, wastewater reports\nUse|DA and Section 68 council support\nArea|NSW and ACT regional properties",
        'sos_when_label' => 'OSSM Reports',
        'sos_when_title' => 'When Do You Need an OSSM Report?',
        'sos_when_intro' => 'You will typically require a formal assessment when:',
        'sos_when_detail' => 'If you’ve been searching for a wastewater consultant near you, we offer site-specific assessments that translate complex soil data into clear, practical designs. Each site is carefully evaluated with consideration of climate, soil characteristics, and topography, allowing us to identify constraints and determine land capability for wastewater management.',
        'sos_when_items' => "Proposing a new dwelling or subdivision in unsewered areas.\nInstalling, replacing, or upgrading an existing septic system.\nCouncil requests a report to support a Development Application (DA).\nAdding bedrooms, a secondary dwelling, guest house, or another building that changes wastewater load.",
        'sos_system_title' => 'System types we assess',
        'sos_system_body' => 'Our reports provide specific guidance on the best system for your land, including Septic Systems, AWTS, Greywater Systems, Composting Systems, and Biological Filters.',
        'sos_system_chips' => "Septic systems\nAWTS\nGreywater systems\nComposting systems\nBiological filters",
        'sos_process_label' => 'Site Investigation Process',
        'sos_process_title' => 'Site Investigation Process',
        'sos_process_intro' => 'A standard investigation includes:',
        'sos_process_steps' => "Desktop Study|Preliminary analysis of site history and mapping.\nSite Visit & Fieldwork|On-site drilling of boreholes and soil sampling.\nLaboratory Testing|Analysis of soil samples' properties.\nComprehensive Reporting|A detailed design tailored to your site’s constraints.",
        'sos_fieldwork_title' => 'Fieldwork Detail',
        'sos_fieldwork_body' => 'During the fieldwork we drill boreholes to 1.5m/2m depth on the proposed effluent disposal area. Soil testing includes:',
        'sos_fieldwork_tests' => "Visual soil description\nSoil texture and structure\npH\nElectrical conductivity\nDispersity",
        'sos_next_label' => 'What to do next',
        'sos_next_title' => 'What to do next',
        'sos_next_steps' => "Enquiry|Send us your plans or site address.\nQuote|We review the details and provide a fixed-fee quote.\nInspection|We carry out the physical site and soil investigation.\nDelivery|You receive a report via email.",
        'sos_areas_label' => 'Coverage',
        'sos_areas_title' => 'Service Areas',
        'sos_areas_intro' => 'We proudly service the ACT and surrounding NSW Councils, including:',
        'sos_areas' => "Queanbeyan-Palerang\nSnowy Monaro\nEurobodalla\nBega Valley\nShoalhaven\nYass Valley\nGoulburn Mulwaree\nHilltops\nWagga Wagga\nACT / Canberra Region\nCowra\nWeddin\nOberon\nForbes\nOrange\nBathurst Regional\nWingecarribee Shire\nUpper Lachlan Shire\nSnowy Valleys\nTemora\nBland\nCoolamon\nGreater Hume\nLockhart\nGriffith\nNarrandera\nLeeton\nMurrumbidgee",
        'sos_areas_cta_text' => 'Not sure if we cover your property?',
        'sos_areas_cta_button' => 'Send us your address',
        'sos_faq_label' => 'FAQ Section',
        'sos_faq_title' => 'Frequently asked questions',
        'sos_faq_items' => "## The Assessment Process\nHow much does an OSSM report cost in NSW?|Costs vary depending on site conditions, location, and complexity. Contact us for a tailored quote.\nHow long does a wastewater report take?|Typical turnaround is 10–15 business days following the payment.\nWhat information do I need to provide?|Site address, plans (if available), and a brief description of your project.\nDo you service my area?|If you are located in NSW and searching for a septic or wastewater report near you, we likely service your area. Contact us with your site address to confirm.\nDo I need to be present during the site visit?|In most cases, no. As long as we have clear access to the property and any pets are secured, we can perform the borehole drilling and site assessment independently. We will coordinate with you regarding access before we arrive.\nWhat kind of equipment do you bring to the site?|We use specialized hand-augurs or small portable drilling rigs to take soil samples. Our equipment is designed to be low-impact, meaning we won’t leave large ruts or damage your landscaping during the investigation.\nWhat happens if my soil is \"poor\" or has high clay content?|Don’t worry—most sites have some constraints. If your soil has low permeability (like heavy clay), we simply design a system that compensates for it, such as a secondary treatment system (AWTS) or a raised irrigation area. Our goal is to find a compliant solution for every site.\nWhat happens if the Council asks for changes to the report?|It is common for councils to issue a \"Request for Further Information\" (RFI) during the DA process. This doesn’t mean the report is rejected; it simply means they want more detail on a specific site constraint. If this happens, we work with you (or your builder) to provide the necessary data and update the report until the council is satisfied.\nWhat if I change my design, such as adding a bedroom or moving the house location?|Wastewater designs are legally tied to the specific load and setbacks of your site plan. If you change the number of bedrooms or the footprint of the house after the report is issued, the assessment must be updated to remain compliant with AS/NZS 1547:2012. Additional fees apply for report updates.\n## Technical & Council Questions\nI’m just adding a bedroom to my existing house—do I still need a report?|Yes. Councils generally view an additional bedroom as an increase in the potential daily wastewater load. We will need to assess whether your current system can handle the extra volume or if an upgrade is required to meet modern standards.\nWhat is the difference between Primary and Secondary treatment?|Primary treatment uses basic settling to separate solids. Secondary treatment (AWTS) uses mechanical aeration to treat the water to a higher standard, often allowing it to be used for surface irrigation. Our report will recommend which is best for your land.\nHow long is an OSSM report valid for?|Most reports are considered valid for 12 to 24 months, provided no significant earthworks or site changes have occurred since the assessment.\n## Costs & Services\nDo you handle the council submission for me?|We provide the council-ready report that you or your builder will include with your DA or Section 68 application. We do not submit the DA ourselves, but we can answer technical questions from council.\nDo you install the septic systems as well?|Soil On Site is an independent consultancy. We provide assessment and design required for approval, but we do not install hardware.",
        'sos_contact_label' => 'Contact Us',
        'sos_contact_title' => 'Request a Quote',
        'sos_contact_ready' => 'Ready to get started?',
        'sos_contact_body' => 'Send the site address, plans, and building details. We will review the scope and reply with a quote.',
        'sos_contact_note' => 'You can attach one plan set or report in the form. For larger or additional files, email them directly to',
        'sos_phone' => '0416 753 516',
        'sos_email' => 'soilonsitensw@gmail.com',
        'sos_abn' => 'ABN 20 669 260 261',
        'sos_form_recipient' => 'soilonsitensw@gmail.com',
        'sos_footer_disclaimer' => 'Information on this website is general in nature and does not constitute engineering advice. Site-specific recommendations are provided in formal written reports only.',
    ];
}

function sos_default(string $key): string
{
    $defaults = sos_defaults();
    return $defaults[$key] ?? '';
}

function sos_mod(string $key): string
{
    return (string) get_theme_mod($key, sos_default($key));
}

function sos_lines(string $key): array
{
    $value = sos_mod($key);
    $lines = preg_split('/\r\n|\r|\n/', $value);
    return array_values(array_filter(array_map('trim', $lines), static fn($line) => $line !== ''));
}

function sos_pipe_rows(string $key): array
{
    return array_map(static function ($line) {
        $parts = array_map('trim', explode('|', $line, 2));
        return [
            'title' => $parts[0] ?? '',
            'body' => $parts[1] ?? '',
        ];
    }, sos_lines($key));
}

function sos_faq_rows(): array
{
    $rows = [];
    foreach (sos_lines('sos_faq_items') as $line) {
        if (str_starts_with($line, '##')) {
            $rows[] = [
                'type' => 'section',
                'title' => trim(substr($line, 2)),
            ];
            continue;
        }

        $parts = array_map('trim', explode('|', $line, 2));
        if (!empty($parts[0]) && !empty($parts[1])) {
            $rows[] = [
                'type' => 'item',
                'question' => $parts[0],
                'answer' => $parts[1],
            ];
        }
    }
    return $rows;
}

function sos_asset(string $path): string
{
    return get_theme_file_uri(ltrim($path, '/'));
}

function sos_image(string $setting, string $webp, string $jpg, string $alt, string $attrs = ''): void
{
    $custom = get_theme_mod($setting, '');
    if ($custom) {
        printf('<img src="%s" alt="%s" %s />', esc_url($custom), esc_attr($alt), $attrs);
        return;
    }

    printf(
        '<picture><source type="image/webp" srcset="%s" /><img src="%s" alt="%s" %s /></picture>',
        esc_url(sos_asset($webp)),
        esc_url(sos_asset($jpg)),
        esc_attr($alt),
        $attrs
    );
}

function sos_tel_href(string $phone): string
{
    return 'tel:' . preg_replace('/[^\d+]/', '', $phone);
}

function sos_form_input(string $id, string $name, string $label, string $type, bool $required, string $placeholder, string $autocomplete, string $hint = '', bool $full = false): void
{
    $group_class = $full ? 'form-group full-col' : 'form-group';
    ?>
    <div class="<?php echo esc_attr($group_class); ?>" id="fg-<?php echo esc_attr(str_replace('f-', '', $id)); ?>">
      <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?><?php echo $required ? ' <span aria-hidden="true" class="req-star">*</span>' : ''; ?></label>
      <div class="input-wrap">
        <input type="<?php echo esc_attr($type); ?>" id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>" <?php echo $required ? 'required' : ''; ?> autocomplete="<?php echo esc_attr($autocomplete); ?>" placeholder="<?php echo esc_attr($placeholder); ?>" aria-describedby="<?php echo esc_attr($id); ?>-msg" aria-invalid="false" maxlength="254" />
        <span class="vi vi-ok" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg></span>
        <span class="vi vi-err" aria-hidden="true"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg></span>
      </div>
      <span class="field-msg" id="<?php echo esc_attr($id); ?>-msg" role="alert" aria-live="polite"></span>
      <?php if ($hint !== '') : ?><span class="field-hint"><?php echo esc_html($hint); ?></span><?php endif; ?>
    </div>
    <?php
}

function sos_form_select(string $id, string $name, string $label, array $options): void
{
    ?>
    <div class="form-group">
      <label for="<?php echo esc_attr($id); ?>"><?php echo esc_html($label); ?></label>
      <div class="input-wrap select-wrap">
        <select id="<?php echo esc_attr($id); ?>" name="<?php echo esc_attr($name); ?>">
          <option value="">— Select —</option>
          <?php foreach ($options as $option) : ?>
            <option><?php echo esc_html($option); ?></option>
          <?php endforeach; ?>
        </select>
        <svg class="select-arrow" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
      </div>
    </div>
    <?php
}
