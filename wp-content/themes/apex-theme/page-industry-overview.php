<?php 
/**
 * Template Name: Industry Overview
 * Industry Overview Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_industry_hero_stats_industry-overview', "100+ | Institutions Served\n5 | Industry Verticals\n15+ | Countries\n10M+ | End Users");
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
    'badge' => get_option('apex_industry_hero_badge_industry-overview', 'Industries We Serve'),
    'heading' => get_option('apex_industry_hero_heading_industry-overview', 'Tailored Solutions for Every Financial Institution'),
    'description' => get_option('apex_industry_hero_description_industry-overview', 'From microfinance institutions to commercial banks, we understand the unique challenges each sector faces. Our solutions are designed to meet your specific needs.'),
    'stats' => $stats_array,
    'image' => get_option('apex_industry_hero_image_industry-overview', 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200')
]);
?>

<section class="apex-industry-sectors">
    <div class="apex-industry-sectors__container">
        <div class="apex-industry-sectors__header">
            <span class="apex-industry-sectors__badge"><?php echo esc_html(get_option('apex_industry_sectors_badge_industry-overview', 'Our Expertise')); ?></span>
            <h2 class="apex-industry-sectors__heading"><?php echo esc_html(get_option('apex_industry_sectors_heading_industry-overview', 'Industries We Specialize In')); ?></h2>
            <p class="apex-industry-sectors__description"><?php echo esc_html(get_option('apex_industry_sectors_description_industry-overview', "We've built deep expertise across the financial services landscape, enabling us to deliver solutions that truly understand your business.")); ?></p>
        </div>
        
        <div class="apex-industry-sectors__grid">
            <?php
            // Card icons
            $card_icons = [
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>'
            ];
            
            for ($i = 1; $i <= 4; $i++) {
                $card_title = get_option('apex_industry_card' . $i . '_title_industry-overview', 
                    $i === 1 ? 'Microfinance Institutions' : 
                    ($i === 2 ? 'SACCOs & Credit Unions' : 
                    ($i === 3 ? 'Commercial Banks' : 'Digital Government & NGOs')));
                $card_desc = get_option('apex_industry_card' . $i . '_desc_industry-overview',
                    $i === 1 ? 'Empower underserved communities with digital-first microfinance solutions that reduce costs and expand reach.' :
                    ($i === 2 ? 'Modern member management and savings solutions designed for cooperative financial institutions.' :
                    ($i === 3 ? 'Enterprise-grade core banking and digital channel solutions for banks of all sizes.' :
                    'Secure disbursement and collection platforms for government programs and development organizations.')));
                $card_stats = get_option('apex_industry_card' . $i . '_stats_industry-overview',
                    $i === 1 ? '50+ | MFI Clients,5M+ | Borrowers Served' :
                    ($i === 2 ? '40+ | SACCOs,2M+ | Members' :
                    ($i === 3 ? '15+ | Banks,3M+ | Customers' :
                    '10+ | Programs,$500M+ | Disbursed')));
                $card_link = get_option('apex_industry_card' . $i . '_link_industry-overview',
                    $i === 1 ? '/industry/mfis' :
                    ($i === 2 ? '/industry/credit-unions' :
                    ($i === 3 ? '/industry/banks-microfinance' : '/industry/digital-government')));
                
                // Parse card stats
                $card_stats_array = [];
                foreach (explode(',', $card_stats) as $stat_pair) {
                    $parts = explode(' | ', $stat_pair);
                    if (count($parts) >= 2) {
                        $card_stats_array[] = [
                            'value' => trim($parts[0]),
                            'label' => trim($parts[1])
                        ];
                    }
                }
                ?>
                <a href="<?php echo esc_url(home_url($card_link)); ?>" class="apex-industry-sectors__card">
                    <div class="apex-industry-sectors__card-icon">
                        <?php echo $card_icons[$i - 1]; ?>
                    </div>
                    <h3><?php echo esc_html($card_title); ?></h3>
                    <p><?php echo esc_html($card_desc); ?></p>
                    <div class="apex-industry-sectors__card-stats">
                        <?php foreach ($card_stats_array as $stat): ?>
                            <span><strong><?php echo esc_html($stat['value']); ?></strong> <?php echo esc_html($stat['label']); ?></span>
                        <?php endforeach; ?>
                    </div>
                    <span class="apex-industry-sectors__card-link">Learn More →</span>
                </a>
                <?php
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-industry-why">
    <div class="apex-industry-why__container">
        <div class="apex-industry-why__content">
            <span class="apex-industry-why__badge"><?php echo esc_html(get_option('apex_industry_why_badge_industry-overview', 'Why Choose Us')); ?></span>
            <h2 class="apex-industry-why__heading"><?php echo esc_html(get_option('apex_industry_why_heading_industry-overview', 'Built for African Financial Services')); ?></h2>
            <p class="apex-industry-why__description"><?php echo esc_html(get_option('apex_industry_why_description_industry-overview', "We understand the unique challenges of operating in African markets—from infrastructure limitations to regulatory complexity. Our solutions are designed from the ground up to address these realities.")); ?></p>
            
            <div class="apex-industry-why__features">
                <?php
                $why_features = get_option('apex_industry_why_features_industry-overview', 
                    "Modular Architecture | Start with what you need and add capabilities as you grow. No need to pay for features you don't use.\n" .
                    "Regulatory Compliance | Built-in compliance with Central Bank regulations across multiple African jurisdictions.\n" .
                    "Offline-First Design | Our mobile solutions work seamlessly in low-connectivity environments common in rural areas.\n" .
                    "24/7 Local Support | Round-the-clock support from teams based in Africa who understand your context."
                );
                
                // Why section icons
                $why_icons = [
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01"/></svg>',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>'
                ];
                
                $feature_lines = explode("\n", $why_features);
                $icon_index = 0;
                foreach ($feature_lines as $feature_line) {
                    $parts = explode(' | ', $feature_line);
                    if (count($parts) >= 2) {
                        $title = trim($parts[0]);
                        $description = trim($parts[1]);
                        $icon = isset($why_icons[$icon_index]) ? $why_icons[$icon_index] : '';
                        ?>
                        <div class="apex-industry-why__feature">
                            <div class="apex-industry-why__feature-icon">
                                <?php echo $icon; ?>
                            </div>
                            <div>
                                <h4><?php echo esc_html($title); ?></h4>
                                <p><?php echo esc_html($description); ?></p>
                            </div>
                        </div>
                        <?php
                        $icon_index++;
                    }
                }
                ?>
            </div>
        </div>
        
        <div class="apex-industry-why__image">
            <img src="<?php echo esc_url(get_option('apex_industry_why_image_industry-overview', 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=600')); ?>" alt="Team collaboration" loading="lazy">
        </div>
    </div>
</section>

<section class="apex-industry-stats">
    <div class="apex-industry-stats__container">
        <div class="apex-industry-stats__header">
            <h2 class="apex-industry-stats__heading"><?php echo esc_html(get_option('apex_industry_stats_heading_industry-overview', 'Trusted Across the Continent')); ?></h2>
            <p class="apex-industry-stats__description"><?php echo esc_html(get_option('apex_industry_stats_description_industry-overview', 'Our track record speaks for itself.')); ?></p>
        </div>
        
        <div class="apex-industry-stats__grid">
            <?php
            $stats_items = get_option('apex_industry_stats_items_industry-overview', 
                "$5B+ | Transactions Processed Annually\n" .
                "99.9% | Platform Uptime\n" .
                "40% | Average Cost Reduction\n" .
                "3x | Customer Growth Rate"
            );
            
            foreach (explode("\n", $stats_items) as $stat_line) {
                $parts = explode(' | ', $stat_line);
                if (count($parts) >= 2) {
                    $value = trim($parts[0]);
                    $label = trim($parts[1]);
                    ?>
                    <div class="apex-industry-stats__item">
                        <span class="apex-industry-stats__value"><?php echo esc_html($value); ?></span>
                        <span class="apex-industry-stats__label"><?php echo esc_html($label); ?></span>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-industry-testimonial">
    <div class="apex-industry-testimonial__container">
        <div class="apex-industry-testimonial__quote">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
        </div>
        <blockquote class="apex-industry-testimonial__text">
            <?php echo esc_html(get_option('apex_industry_testimonial_quote_industry-overview', "Apex Softwares truly understands the African financial services landscape. Their solutions have helped us reach customers we never thought possible while dramatically reducing our operational costs.")); ?>
        </blockquote>
        <div class="apex-industry-testimonial__author">
            <img src="<?php echo esc_url(get_option('apex_industry_testimonial_image_industry-overview', 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100')); ?>" alt="<?php echo esc_attr(get_option('apex_industry_testimonial_author_industry-overview', 'James Mwangi')); ?>">
            <div>
                <strong><?php echo esc_html(get_option('apex_industry_testimonial_author_industry-overview', 'James Mwangi')); ?></strong>
                <span><?php echo esc_html(get_option('apex_industry_testimonial_title_industry-overview', 'CEO, Kenya National SACCO')); ?></span>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
