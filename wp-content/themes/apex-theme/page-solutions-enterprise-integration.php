<?php 
/**
 * Template Name: Solutions Enterprise Integration
 * Enterprise Integration Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_integration_hero_stats_solutions-enterprise-integration', "50+ | Pre-Built Integrations\n99.9% | API Uptime\n<200ms | Response Time\n24/7 | Monitoring");
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
    'badge' => get_option('apex_integration_hero_badge_solutions-enterprise-integration', 'Enterprise Integration'),
    'heading' => get_option('apex_integration_hero_heading_solutions-enterprise-integration', 'Connect Your Entire Ecosystem'),
    'description' => get_option('apex_integration_hero_description_solutions-enterprise-integration', 'Seamlessly integrate with payment networks, credit bureaus, government systems, and third-party services through our comprehensive API platform.'),
    'stats' => $stats_array,
    'image' => get_option('apex_integration_hero_image_solutions-enterprise-integration', 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200')
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge"><?php echo esc_html(get_option('apex_integration_categories_badge_solutions-enterprise-integration', 'Integration Categories')); ?></span>
            <h2 class="apex-solution-features__heading"><?php echo esc_html(get_option('apex_integration_categories_heading_solutions-enterprise-integration', 'Connect With Everything You Need')); ?></h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <?php
            $categories_items = get_option('apex_integration_categories_items_solutions-enterprise-integration', 
                "Payment Networks | M-Pesa, Airtel Money, MTN Mobile Money, Visa, Mastercard, RTGS, EFT, and more.\n" .
                "Credit Bureaus | TransUnion, Metropol, CRB Africa, First Central for credit checks and reporting.\n" .
                "Identity Verification | National ID systems, IPRS, NIRA, Smile Identity for KYC verification.\n" .
                "Accounting Systems | SAP, Oracle, QuickBooks, Sage, and custom ERP integrations.\n" .
                "Communication | SMS gateways, email services, WhatsApp Business API for notifications.\n" .
                "Custom APIs | RESTful APIs with OpenAPI documentation for custom integrations."
            );
            
            // Feature icons
            $feature_icons = [
                'Payment Networks' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                'Credit Bureaus' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>',
                'Identity Verification' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>',
                'Accounting Systems' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
                'Communication' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>',
                'Custom APIs' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>'
            ];
            
            foreach (explode("\n", $categories_items) as $feature_line) {
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
            <span class="apex-solution-specs__badge"><?php echo esc_html(get_option('apex_integration_arch_badge_solutions-enterprise-integration', 'Integration Architecture')); ?></span>
            <h2 class="apex-solution-specs__heading"><?php echo esc_html(get_option('apex_integration_arch_heading_solutions-enterprise-integration', 'Enterprise-Grade Connectivity')); ?></h2>
            
            <div class="apex-solution-specs__list">
                <?php
                $arch_items = get_option('apex_integration_arch_items_solutions-enterprise-integration', 
                    "API Gateway | Centralized API management with rate limiting, authentication, and monitoring\n" .
                    "Message Queue | Asynchronous processing for high-volume transactions and event-driven workflows\n" .
                    "Data Transformation | Built-in ETL capabilities for format conversion between systems\n" .
                    "Webhook Support | Real-time event notifications to external systems\n" .
                    "Sandbox Environment | Test integrations safely before deploying to production"
                );
                
                foreach (explode("\n", $arch_items) as $item_line) {
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
            <img src="<?php echo esc_url(get_option('apex_integration_arch_image_solutions-enterprise-integration', 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600')); ?>" alt="Integration Architecture" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
