<?php 
/**
 * Template Name: Solutions Agency Banking
 * Agency & Branch Banking Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_agency_hero_stats_solutions-agency-branch-banking', "50K+ | Active Agents\n85% | Cost Reduction\n10x | Reach Expansion\n24/7 | Service Availability");
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
    'badge' => get_option('apex_agency_hero_badge_solutions-agency-branch-banking', 'Agency & Branch Banking'),
    'heading' => get_option('apex_agency_hero_heading_solutions-agency-branch-banking', 'Extend Your Reach Without Building Branches'),
    'description' => get_option('apex_agency_hero_description_solutions-agency-branch-banking', 'Transform local shops into banking points and modernize your branch operations. Serve customers where they are with our comprehensive agent and branch banking platform.'),
    'stats' => $stats_array,
    'image' => get_option('apex_agency_hero_image_solutions-agency-branch-banking', 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200')
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge"><?php echo esc_html(get_option('apex_agency_features_badge_solutions-agency-branch-banking', 'Key Features')); ?></span>
            <h2 class="apex-solution-features__heading"><?php echo esc_html(get_option('apex_agency_features_heading_solutions-agency-branch-banking', 'Complete Agent & Branch Solution')); ?></h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <?php
            $features_items = get_option('apex_agency_features_items_solutions-agency-branch-banking', 
                "Agent Onboarding | Digital agent recruitment with KYC verification, training modules, and automated activation.\n" .
                "Float Management | Real-time float monitoring, automated rebalancing alerts, and super-agent hierarchy support.\n" .
                "POS Integration | Support for Android POS devices, mPOS, and traditional terminals with offline capability.\n" .
                "Commission Management | Flexible commission structures with real-time calculation and automated payouts.\n" .
                "Performance Analytics | Agent performance dashboards, territory analytics, and productivity tracking.\n" .
                "Branch Teller System | Modern teller interface with queue management and customer service tools."
            );
            
            // Feature icons
            $feature_icons = [
                'Agent Onboarding' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                'Float Management' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                'POS Integration' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>',
                'Commission Management' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                'Performance Analytics' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>',
                'Branch Teller System' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11"/></svg>'
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
            <span class="apex-solution-specs__badge"><?php echo esc_html(get_option('apex_agency_models_badge_solutions-agency-branch-banking', 'Agent Network Models')); ?></span>
            <h2 class="apex-solution-specs__heading"><?php echo esc_html(get_option('apex_agency_models_heading_solutions-agency-branch-banking', 'Flexible Deployment Options')); ?></h2>
            
            <div class="apex-solution-specs__list">
                <?php
                $models_items = get_option('apex_agency_models_items_solutions-agency-branch-banking', 
                    "Retail Agent Model | Partner with existing shops, pharmacies, and retail outlets to offer banking services\n" .
                    "Super-Agent Hierarchy | Multi-tier agent structure with master agents managing sub-agent networks\n" .
                    "Bank-Led Model | Direct agent recruitment and management by your institution\n" .
                    "Hybrid Approach | Combine branch, agent, and digital channels for maximum coverage"
                );
                
                foreach (explode("\n", $models_items) as $item_line) {
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
            <img src="<?php echo esc_url(get_option('apex_agency_models_image_solutions-agency-branch-banking', 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600')); ?>" alt="Agent Banking Network" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
