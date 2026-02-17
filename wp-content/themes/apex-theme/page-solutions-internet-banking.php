<?php 
/**
 * Template Name: Solutions Internet Banking
 * Internet & Mobile Banking Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_internet_hero_stats_solutions-internet-mobile-banking', "3M+ | Active Users\n70% | Self-Service\n40% | Cost Savings\n99.9% | Uptime");
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
    'badge' => get_option('apex_internet_hero_badge_solutions-internet-mobile-banking', 'Internet & Mobile Banking'),
    'heading' => get_option('apex_internet_hero_heading_solutions-internet-mobile-banking', 'Digital Channels for Every Customer'),
    'description' => get_option('apex_internet_hero_description_solutions-internet-mobile-banking', 'Responsive web banking and USSD channels ensure every customer can access your services, regardless of their device or connectivity.'),
    'stats' => $stats_array,
    'image' => get_option('apex_internet_hero_image_solutions-internet-mobile-banking', 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200')
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge"><?php echo esc_html(get_option('apex_internet_features_badge_solutions-internet-mobile-banking', 'Key Features')); ?></span>
            <h2 class="apex-solution-features__heading"><?php echo esc_html(get_option('apex_internet_features_heading_solutions-internet-mobile-banking', 'Complete Digital Channel Suite')); ?></h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <?php
            $features_items = get_option('apex_internet_features_items_solutions-internet-mobile-banking', 
                "Internet Banking Portal | Responsive web application for account management, transfers, and self-service operations.\n" .
                "USSD Banking | Feature phone banking via USSD codes for customers without smartphones or data.\n" .
                "Chatbot Integration | AI-powered chatbot for customer support and transaction assistance.\n" .
                "Two-Factor Authentication | SMS OTP, email verification, and authenticator app support for secure access.\n" .
                "Statement Downloads | Generate and download account statements in PDF and Excel formats.\n" .
                "Bill Payments | Integrated bill payment for utilities, airtime, and other services."
            );
            
            // Feature icons
            $feature_icons = [
                'Internet Banking Portal' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>',
                'USSD Banking' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>',
                'Chatbot Integration' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
                'Two-Factor Authentication' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                'Statement Downloads' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>',
                'Bill Payments' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M6 8h.01M2 12h20"/></svg>'
            ];
            
            foreach (explode("\n", $features_items) as $feature_line) {
                $parts = explode(' | ', $feature_line);
                if (count($parts) >= 2) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $icon = isset($feature_icons[$title]) ? $feature_icons[$title] : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>';
                    ?>
                    <div class="apex-solution-features__item">
                        <div class="apex-solution-features__icon">
                            <?php echo $icon; ?>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-solution-specs">
    <div class="apex-solution-specs__container">
        <div class="apex-solution-specs__content">
            <span class="apex-solution-specs__badge"><?php echo esc_html(get_option('apex_internet_accessibility_badge_solutions-internet-mobile-banking', 'Channel Accessibility')); ?></span>
            <h2 class="apex-solution-specs__heading"><?php echo esc_html(get_option('apex_internet_accessibility_heading_solutions-internet-mobile-banking', 'Banking for Every Customer Segment')); ?></h2>
            
            <div class="apex-solution-specs__list">
                <?php
                $accessibility_items = get_option('apex_internet_accessibility_items_solutions-internet-mobile-banking', 
                    "Smartphone Users | Full-featured responsive web app optimized for mobile browsers\n" .
                    "Feature Phone Users | USSD banking with simple menu navigation for basic phones\n" .
                    "Desktop Users | Comprehensive internet banking portal for corporate and power users\n" .
                    "Low-Bandwidth Areas | Lightweight interfaces optimized for 2G/3G connections"
                );
                
                foreach (explode("\n", $accessibility_items) as $item_line) {
                    $parts = explode(' | ', $item_line);
                    if (count($parts) >= 2) {
                        $title = trim($parts[0]);
                        $description = trim($parts[1]);
                        ?>
                        <div class="apex-solution-specs__item">
                            <h4><?php echo esc_html($title); ?></h4>
                            <p><?php echo esc_html($description); ?></p>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="apex-solution-specs__image">
            <img src="<?php echo esc_url(get_option('apex_internet_accessibility_image_solutions-internet-mobile-banking', 'https://images.unsplash.com/photo-1551650975-87deedd944c3?w=600')); ?>" alt="Multi-Channel Banking" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
