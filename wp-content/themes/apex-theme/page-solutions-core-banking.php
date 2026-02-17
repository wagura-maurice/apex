<?php 
/**
 * Template Name: Solutions Core Banking
 * Core Banking & Microfinance Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_corebank_hero_stats_solutions-core-banking-microfinance', "100+ | Institutions\n10M+ | Accounts\n99.99% | Uptime\n<100ms | Response Time");
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
    'badge' => get_option('apex_corebank_hero_badge_solutions-core-banking-microfinance', 'Core Banking & Microfinance'),
    'heading' => get_option('apex_corebank_hero_heading_solutions-core-banking-microfinance', 'The Foundation of Your Digital Banking'),
    'description' => get_option('apex_corebank_hero_description_solutions-core-banking-microfinance', 'A modern, cloud-native core banking system designed for African financial institutions. Handle millions of transactions with enterprise-grade reliability and flexibility.'),
    'stats' => $stats_array,
    'image' => get_option('apex_corebank_hero_image_solutions-core-banking-microfinance', 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=1200')
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge"><?php echo esc_html(get_option('apex_corebank_features_badge_solutions-core-banking-microfinance', 'Key Features')); ?></span>
            <h2 class="apex-solution-features__heading"><?php echo esc_html(get_option('apex_corebank_features_heading_solutions-core-banking-microfinance', 'Everything You Need in a Core Banking System')); ?></h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <?php
            $features_items = get_option('apex_corebank_features_items_solutions-core-banking-microfinance', 
                "Account Management | Flexible account structures supporting savings, current, fixed deposits, and custom account types with configurable interest calculations.\n" .
                "Transaction Processing | Real-time transaction processing with support for deposits, withdrawals, transfers, and complex multi-leg transactions.\n" .
                "Loan Management | Complete loan lifecycle management from origination to settlement with support for multiple loan products and repayment schedules.\n" .
                "End-of-Day Processing | Automated EOD processing for interest accrual, fee charges, and account maintenance with detailed audit trails.\n" .
                "Customer Management | 360-degree customer view with KYC management, document storage, and relationship tracking.\n" .
                "Security & Compliance | Role-based access control, maker-checker workflows, and comprehensive audit logging for regulatory compliance."
            );
            
            // Feature icons
            $feature_icons = [
                'Account Management' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
                'Transaction Processing' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                'Loan Management' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>',
                'End-of-Day Processing' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
                'Customer Management' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                'Security & Compliance' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'
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
            <span class="apex-solution-specs__badge"><?php echo esc_html(get_option('apex_corebank_specs_badge_solutions-core-banking-microfinance', 'Technical Specifications')); ?></span>
            <h2 class="apex-solution-specs__heading"><?php echo esc_html(get_option('apex_corebank_specs_heading_solutions-core-banking-microfinance', 'Built for Scale and Performance')); ?></h2>
            
            <div class="apex-solution-specs__list">
                <?php
                $specs_items = get_option('apex_corebank_specs_items_solutions-core-banking-microfinance', 
                    "Architecture | Cloud-native microservices architecture with horizontal scaling capabilities\n" .
                    "Database | PostgreSQL with read replicas for high availability and performance\n" .
                    "API | RESTful APIs with OpenAPI documentation for easy integration\n" .
                    "Security | TLS 1.3, AES-256 encryption, OAuth 2.0, and PCI-DSS compliance\n" .
                    "Deployment | On-premise, private cloud, or fully managed SaaS options available"
                );
                
                foreach (explode("\n", $specs_items) as $spec_line) {
                    $parts = explode(' | ', $spec_line);
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
            <img src="<?php echo esc_url(get_option('apex_corebank_specs_image_solutions-core-banking-microfinance', 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600')); ?>" alt="Server Infrastructure" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
