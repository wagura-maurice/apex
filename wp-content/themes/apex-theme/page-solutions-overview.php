<?php 
/**
 * Template Name: Solutions Overview
 * Solutions Overview Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_solutions_hero_stats_solutions-overview', "10+ | Product Modules\n100+ | Institutions\n99.9% | Uptime\n24/7 | Support");
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
    'badge' => get_option('apex_solutions_hero_badge_solutions-overview', 'Our Solutions'),
    'heading' => get_option('apex_solutions_hero_heading_solutions-overview', 'Complete Digital Banking Suite'),
    'description' => get_option('apex_solutions_hero_description_solutions-overview', 'From core banking to mobile wallets, we provide end-to-end solutions that help financial institutions digitize operations, reach more customers, and drive growth.'),
    'stats' => $stats_array,
    'image' => get_option('apex_solutions_hero_image_solutions-overview', 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=1200')
]);
?>

<section class="apex-solutions-grid">
    <div class="apex-solutions-grid__container">
        <div class="apex-solutions-grid__header">
            <span class="apex-solutions-grid__badge"><?php echo esc_html(get_option('apex_solutions_grid_badge_solutions-overview', 'Product Suite')); ?></span>
            <h2 class="apex-solutions-grid__heading"><?php echo esc_html(get_option('apex_solutions_grid_heading_solutions-overview', 'Everything You Need to Succeed')); ?></h2>
            <p class="apex-solutions-grid__description"><?php echo esc_html(get_option('apex_solutions_grid_description_solutions-overview', 'Our modular platform lets you start with what you need and add capabilities as you grow.')); ?></p>
        </div>
        
        <div class="apex-solutions-grid__items">
            <?php
            $solutions_items = get_option('apex_solutions_grid_items_solutions-overview', 
                "Core Banking & Microfinance | The foundation of your digital banking infrastructure. Manage accounts, transactions, and products with enterprise-grade reliability. | /solutions/core-banking-microfinance | featured\n" .
                "Mobile Wallet App | White-label mobile banking app with offline-first design for seamless customer experience. | /solutions/mobile-wallet-app |\n" .
                "Agency & Branch Banking | Extend your reach through agent networks and modernize branch operations. | /solutions/agency-branch-banking |\n" .
                "Internet & Mobile Banking | Responsive web banking and USSD channels for complete customer coverage. | /solutions/internet-mobile-banking |\n" .
                "Loan Origination & Workflows | Automate the entire loan lifecycle from application to disbursement and collection. | /solutions/loan-origination-workflows |\n" .
                "Digital Field Agent | Empower field officers with mobile tools for customer onboarding and collections. | /solutions/digital-field-agent |\n" .
                "Enterprise Integration | Connect with third-party systems, payment networks, and credit bureaus seamlessly. | /solutions/enterprise-integration |\n" .
                "Payment Switch & General Ledger | Process payments across all channels with real-time settlement and accounting. | /solutions/payment-switch-ledger |\n" .
                "Reporting & Analytics | Real-time dashboards, regulatory reports, and business intelligence tools. | /solutions/reporting-analytics |"
            );
            
            // SVG icon mappings
            $svg_icons = [
                'Core Banking & Microfinance' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
                'Mobile Wallet App' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>',
                'Agency & Branch Banking' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>',
                'Internet & Mobile Banking' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
                'Loan Origination & Workflows' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>',
                'Digital Field Agent' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                'Enterprise Integration' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="M3.27 6.96L12 12.01l8.73-5.05M12 22.08V12"/></svg>',
                'Payment Switch & General Ledger' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                'Reporting & Analytics' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>'
            ];
            
            foreach (explode("\n", $solutions_items) as $item_line) {
                $parts = explode(' | ', $item_line);
                if (count($parts) >= 3) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $link = trim($parts[2]);
                    $featured = isset($parts[3]) && trim($parts[3]) === 'featured' ? 'apex-solutions-grid__card--featured' : '';
                    $icon = isset($svg_icons[$title]) ? $svg_icons[$title] : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>';
                    ?>
                    <a href="<?php echo esc_url(home_url($link)); ?>" class="apex-solutions-grid__card <?php echo esc_attr($featured); ?>">
                        <div class="apex-solutions-grid__card-icon">
                            <?php echo $icon; ?>
                        </div>
                        <div class="apex-solutions-grid__card-content">
                            <h3><?php echo esc_html($title); ?></h3>
                            <p><?php echo esc_html($description); ?></p>
                            <span class="apex-solutions-grid__card-link">Learn More →</span>
                        </div>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-solutions-benefits">
    <div class="apex-solutions-benefits__container">
        <div class="apex-solutions-benefits__header">
            <span class="apex-solutions-benefits__badge"><?php echo esc_html(get_option('apex_solutions_benefits_badge_solutions-overview', 'Why Apex')); ?></span>
            <h2 class="apex-solutions-benefits__heading"><?php echo esc_html(get_option('apex_solutions_benefits_heading_solutions-overview', 'Built for African Financial Services')); ?></h2>
        </div>
        
        <div class="apex-solutions-benefits__grid">
            <?php
            $benefits_items = get_option('apex_solutions_benefits_items_solutions-overview', 
                "Modular Architecture | Start with what you need and add modules as you grow. No need to pay for features you don't use.\n" .
                "Offline-First Design | Our mobile solutions work seamlessly in low-connectivity environments common in rural areas.\n" .
                "Regulatory Compliance | Built-in compliance with Central Bank regulations across multiple African jurisdictions.\n" .
                "Rapid Deployment | Go live in weeks, not months. Our experienced team ensures smooth implementation.\n" .
                "Proven Track Record | Trusted by 100+ financial institutions across 15+ African countries.\n" .
                "24/7 Local Support | Round-the-clock support from teams based in Africa who understand your context."
            );
            
            // Benefit icons
            $benefit_icons = [
                'Modular Architecture' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>',
                'Offline-First Design' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01"/></svg>',
                'Regulatory Compliance' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                'Rapid Deployment' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
                'Proven Track Record' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg>',
                '24/7 Local Support' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>'
            ];
            
            foreach (explode("\n", $benefits_items) as $benefit_line) {
                $parts = explode(' | ', $benefit_line);
                if (count($parts) >= 2) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $icon = isset($benefit_icons[$title]) ? $benefit_icons[$title] : '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/></svg>';
                    ?>
                    <div class="apex-solutions-benefits__item">
                        <div class="apex-solutions-benefits__icon">
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

<section class="apex-solutions-integration">
    <div class="apex-solutions-integration__container">
        <div class="apex-solutions-integration__content">
            <span class="apex-solutions-integration__badge"><?php echo esc_html(get_option('apex_solutions_integration_badge_solutions-overview', 'Integrations')); ?></span>
            <h2 class="apex-solutions-integration__heading"><?php echo esc_html(get_option('apex_solutions_integration_heading_solutions-overview', 'Connect With Your Ecosystem')); ?></h2>
            <p class="apex-solutions-integration__description"><?php echo esc_html(get_option('apex_solutions_integration_description_solutions-overview', 'Our platform integrates seamlessly with the services and systems you already use.')); ?></p>
            
            <div class="apex-solutions-integration__categories">
                <?php
                $integration_categories = get_option('apex_solutions_integration_categories_solutions-overview', 
                    "Payment Networks | M-Pesa, Airtel Money, MTN Mobile Money, Visa, Mastercard, RTGS, EFT\n" .
                    "Credit Bureaus | TransUnion, Metropol, CRB Africa, First Central\n" .
                    "Identity Verification | IPRS, NIRA, National ID systems, Smile Identity\n" .
                    "Accounting Systems | SAP, Oracle, QuickBooks, Sage, custom ERPs"
                );
                
                foreach (explode("\n", $integration_categories) as $category_line) {
                    $parts = explode(' | ', $category_line);
                    if (count($parts) >= 2) {
                        $category_name = trim($parts[0]);
                        $items = trim($parts[1]);
                        ?>
                        <div class="apex-solutions-integration__category">
                            <h4><?php echo esc_html($category_name); ?></h4>
                            <p><?php echo esc_html($items); ?></p>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="apex-solutions-integration__visual">
            <img src="<?php echo esc_url(get_option('apex_solutions_integration_image_solutions-overview', 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600')); ?>" alt="Integration Network" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
