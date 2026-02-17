<?php 
/**
 * Template Name: Solutions Reporting
 * Reporting & Analytics Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_reporting_hero_stats_solutions-reporting-analytics', "100+ | Report Templates\nReal-Time | Data Updates\n50+ | KPI Metrics\n1-Click | Regulatory Reports");
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
    'badge' => get_option('apex_reporting_hero_badge_solutions-reporting-analytics', 'Reporting & Analytics'),
    'heading' => get_option('apex_reporting_hero_heading_solutions-reporting-analytics', 'Data-Driven Decision Making'),
    'description' => get_option('apex_reporting_hero_description_solutions-reporting-analytics', 'Real-time dashboards, regulatory reports, and business intelligence tools to help you understand your business and make informed decisions.'),
    'stats' => $stats_array,
    'image' => get_option('apex_reporting_hero_image_solutions-reporting-analytics', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200')
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge"><?php echo esc_html(get_option('apex_reporting_features_badge_solutions-reporting-analytics', 'Key Features')); ?></span>
            <h2 class="apex-solution-features__heading"><?php echo esc_html(get_option('apex_reporting_features_heading_solutions-reporting-analytics', 'Complete Business Intelligence Suite')); ?></h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <?php
            $features_items = get_option('apex_reporting_features_items_solutions-reporting-analytics', 
                "Executive Dashboards | Real-time KPI dashboards for management with drill-down capabilities.\n" .
                "Regulatory Reports | Pre-built Central Bank reports, SASRA returns, and compliance reports.\n" .
                "Portfolio Analytics | Loan portfolio analysis, PAR tracking, and risk concentration reports.\n" .
                "Customer Insights | Customer segmentation, behavior analysis, and lifetime value tracking.\n" .
                "Custom Report Builder | Drag-and-drop report builder for creating custom reports without IT help.\n" .
                "Scheduled Reports | Automated report generation and email delivery on your schedule."
            );
            
            // Feature icons
            $feature_icons = [
                'Executive Dashboards' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>',
                'Regulatory Reports' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>',
                'Portfolio Analytics' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>',
                'Customer Insights' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>',
                'Custom Report Builder' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>',
                'Scheduled Reports' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>'
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
            <span class="apex-solution-specs__badge"><?php echo esc_html(get_option('apex_reporting_compliance_badge_solutions-reporting-analytics', 'Regulatory Compliance')); ?></span>
            <h2 class="apex-solution-specs__heading"><?php echo esc_html(get_option('apex_reporting_compliance_heading_solutions-reporting-analytics', 'Meet Every Reporting Requirement')); ?></h2>
            
            <div class="apex-solution-specs__list">
                <?php
                $compliance_items = get_option('apex_reporting_compliance_items_solutions-reporting-analytics', 
                    "Central Bank Returns | Automated CBK, BOU, BOT, and other central bank regulatory submissions\n" .
                    "SASRA Compliance | SACCO-specific reports including prudential returns and financial statements\n" .
                    "AML/CFT Reports | Suspicious transaction reports, CTRs, and compliance monitoring\n" .
                    "IFRS 9 Reporting | Expected credit loss calculations and impairment reporting\n" .
                    "Tax Compliance | Withholding tax reports, excise duty, and tax authority submissions"
                );
                
                foreach (explode("\n", $compliance_items) as $item_line) {
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
            <img src="<?php echo esc_url(get_option('apex_reporting_compliance_image_solutions-reporting-analytics', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600')); ?>" alt="Regulatory Reporting" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
