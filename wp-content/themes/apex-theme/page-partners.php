<?php 
/**
 * Template Name: Partners
 * Partners Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_partners_hero_stats_partners', "50+ | Partners\n15+ | Countries\n100+ | Joint Projects\n$1B+ | Transactions Processed");
$stats_array = [];
foreach (explode("\n", $hero_stats) as $stat_line) {
    $parts = explode(' | ', $stat_line);
    if (count($parts) >= 2) {
        $stats_array[] = [
            'value' => trim($parts[0]),
            'label' => trim($parts[1])
        ];
    }
}

apex_render_about_hero([
    'badge' => get_option('apex_partners_hero_badge_partners', 'Partners'),
    'heading' => get_option('apex_partners_hero_heading_partners', 'Partner with Us to Transform African Fintech'),
    'description' => get_option('apex_partners_hero_description_partners', 'Join our growing ecosystem of partners and help drive financial inclusion across Africa. We offer flexible partnership models tailored to your business.'),
    'stats' => $stats_array,
    'image' => get_option('apex_partners_hero_image_partners', 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200')
]);
?>

<section class="apex-partners-benefits">
    <div class="apex-partners-benefits__container">
        <div class="apex-partners-benefits__header">
            <h2 class="apex-partners-benefits__heading"><?php echo esc_html(get_option('apex_partners_benefits_heading_partners', 'Why Partner with Apex?')); ?></h2>
            <p class="apex-partners-benefits__description"><?php echo esc_html(get_option('apex_partners_benefits_description_partners', "We're committed to mutual growth and success")); ?></p>
        </div>
        
        <div class="apex-partners-benefits__grid">
            <?php
            $benefit_icons = [
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>'
            ];
            
            $benefits = get_option('apex_partners_benefits_items_partners', 
                "Market Leadership | Partner with Africa's leading fintech company serving 50+ financial institutions across 15 countries.\n" .
                "Revenue Sharing | Attractive revenue models with competitive commissions and flexible terms designed for mutual benefit.\n" .
                "Dedicated Support | Access to our dedicated partner support team, training programs, and marketing resources.\n" .
                "Technical Integration | Comprehensive APIs, SDKs, and integration support to ensure seamless deployment."
            );
            
            $benefit_lines = explode("\n", $benefits);
            $icon_index = 0;
            foreach ($benefit_lines as $benefit_line) {
                $parts = explode(' | ', $benefit_line);
                if (count($parts) >= 2) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $icon = isset($benefit_icons[$icon_index]) ? $benefit_icons[$icon_index] : '';
                    ?>
                    <div class="apex-partners-benefits__item">
                        <div class="apex-partners-benefits__item-icon">
                            <?php echo $icon; ?>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                    <?php
                    $icon_index++;
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-partners-types">
    <div class="apex-partners-types__container">
        <div class="apex-partners-types__header">
            <h2 class="apex-partners-types__heading"><?php echo esc_html(get_option('apex_partners_models_heading_partners', 'Partnership Models')); ?></h2>
            <p class="apex-partners-types__description"><?php echo esc_html(get_option('apex_partners_models_description_partners', 'Choose the partnership model that fits your business')); ?></p>
        </div>
        
        <div class="apex-partners-types__grid">
            <?php
            $model_icons = [
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>'
            ];
            
            $models = get_option('apex_partners_models_items_partners', 
                "Reseller Partner | Sell our solutions to your clients and earn attractive commissions. Ideal for IT consultants, system integrators, and VARs. | Competitive commission rates | Marketing support | Training and certification | Lead generation support\n" .
                "Technology Partner | Integrate our solutions with your technology stack and create comprehensive offerings for your customers. | API access and documentation | Joint go-to-market | Co-marketing opportunities | Technical collaboration\n" .
                "Referral Partner | Refer clients to us and earn referral fees. Low commitment with high rewards for qualified referrals. | Referral commissions | Easy onboarding | Tracking and reporting | No sales commitment\n" .
                "Strategic Partner | Deep integration and collaboration for long-term strategic partnerships. For large enterprises and institutions. | Custom integration | Revenue sharing | Co-development | Priority support"
            );
            
            $model_lines = explode("\n", $models);
            $icon_index = 0;
            foreach ($model_lines as $model_line) {
                $parts = explode(' | ', $model_line);
                if (count($parts) >= 6) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $features = [
                        trim($parts[2]),
                        trim($parts[3]),
                        trim($parts[4]),
                        trim($parts[5])
                    ];
                    $icon = isset($model_icons[$icon_index]) ? $model_icons[$icon_index] : '';
                    ?>
                    <div class="apex-partners-types__card">
                        <div class="apex-partners-types__card-icon">
                            <?php echo $icon; ?>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                        <ul>
                            <?php foreach ($features as $feature) : ?>
                                <li><?php echo esc_html($feature); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <a href="#" class="apex-partners-types__card-cta">Learn More →</a>
                    </div>
                    <?php
                    $icon_index++;
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-partners-process">
    <div class="apex-partners-process__container">
        <div class="apex-partners-process__header">
            <h2 class="apex-partners-process__heading"><?php echo esc_html(get_option('apex_partners_process_heading_partners', 'Partner Onboarding Process')); ?></h2>
            <p class="apex-partners-process__description"><?php echo esc_html(get_option('apex_partners_process_description_partners', 'Simple, transparent, and efficient')); ?></p>
        </div>
        
        <div class="apex-partners-process__steps">
            <?php
            $steps = get_option('apex_partners_process_steps_partners', 
                "Apply Online | Submit your partnership application through our online portal with your business details.\n" .
                "Review & Approval | Our team reviews your application and contacts you within 5 business days.\n" .
                "Agreement Signing | Review and sign the partnership agreement tailored to your chosen model.\n" .
                "Onboarding & Training | Complete onboarding training and access partner resources and tools.\n" .
                "Start Selling | Begin selling and earning with full support from our partner team."
            );
            
            $step_lines = explode("\n", $steps);
            $step_number = 1;
            foreach ($step_lines as $step_line) {
                $parts = explode(' | ', $step_line);
                if (count($parts) >= 2) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    ?>
                    <div class="apex-partners-process__step">
                        <div class="apex-partners-process__step-number"><?php echo sprintf('%02d', $step_number); ?></div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                    <?php
                    $step_number++;
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-partners-logos">
    <div class="apex-partners-logos__container">
        <div class="apex-partners-logos__header">
            <h2 class="apex-partners-logos__heading"><?php echo esc_html(get_option('apex_partners_logos_heading_partners', 'Our Partners')); ?></h2>
            <p class="apex-partners-logos__description"><?php echo esc_html(get_option('apex_partners_logos_description_partners', 'Trusted by leading organizations across Africa')); ?></p>
        </div>
        
        <div class="apex-partners-logos__grid">
            <?php
            $logos = get_option('apex_partners_logos_items_partners', 
                "https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Microsoft_Azure.svg/150px-Microsoft_Azure.svg.png | Microsoft Azure\n" .
                "https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Amazon_Web_Services_Logo.svg/150px-Amazon_Web_Services_Logo.svg.png | Amazon Web Services\n" .
                "https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/150px-Visa_Inc._logo.svg.png | Visa\n" .
                "https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/150px-Mastercard-logo.svg.png | Mastercard\n" .
                "https://upload.wikimedia.org/wikipedia/commons/1/15/M-PESA_LOGO-01.svg | M-Pesa (Safaricom)\n" .
                "https://upload.wikimedia.org/wikipedia/commons/thumb/5/50/Oracle_logo.svg/150px-Oracle_logo.svg.png | Oracle\n" .
                "https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/IBM_logo.svg/150px-IBM_logo.svg.png | IBM\n" .
                "https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Google_Cloud_logo.svg/150px-Google_Cloud_logo.svg.png | Google Cloud"
            );
            
            $logo_lines = explode("\n", $logos);
            foreach ($logo_lines as $logo_line) {
                $parts = explode(' | ', $logo_line);
                if (count($parts) >= 2) {
                    $url = trim($parts[0]);
                    $name = trim($parts[1]);
                    ?>
                    <div class="apex-partners-logos__item">
                        <img src="<?php echo esc_url($url); ?>" alt="<?php echo esc_attr($name); ?>">
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-partners-testimonial">
    <div class="apex-partners-testimonial__container">
        <div class="apex-partners-testimonial__content">
            <span class="apex-partners-testimonial__badge"><?php echo esc_html(get_option('apex_partners_testimonial_badge_partners', 'Partner Success Story')); ?></span>
            <h2 class="apex-partners-testimonial__heading"><?php echo esc_html(get_option('apex_partners_testimonial_heading_partners', 'How TechCorp Africa Grew Revenue by 300%')); ?></h2>
            <p class="apex-partners-testimonial__description"><?php echo esc_html(get_option('apex_partners_testimonial_quote_partners', '"Partnering with Apex has been transformative for our business. Their comprehensive solutions, excellent support, and attractive revenue model helped us expand our client base and triple our revenue in just two years."')); ?></p>
            
            <div class="apex-partners-testimonial__author">
                <img src="<?php echo esc_url(get_option('apex_partners_testimonial_author_image_partners', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100')); ?>" alt="<?php echo esc_attr(get_option('apex_partners_testimonial_author_name_partners', 'John Kamau')); ?>">
                <div>
                    <strong><?php echo esc_html(get_option('apex_partners_testimonial_author_name_partners', 'John Kamau')); ?></strong>
                    <span><?php echo esc_html(get_option('apex_partners_testimonial_author_title_partners', 'CEO, TechCorp Africa')); ?></span>
                </div>
            </div>
        </div>
    </div>
</section>


<?php get_footer(); ?>
