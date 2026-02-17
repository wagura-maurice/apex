<?php 
/**
 * Template Name: Solutions Field Agent
 * Digital Field Agent Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_field_hero_stats_solutions-digital-field-agent', "10K+ | Field Agents\n3x | Productivity\n80% | Offline Usage\n95% | Collection Rate");
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
    'badge' => get_option('apex_field_hero_badge_solutions-digital-field-agent', 'Digital Field Agent'),
    'heading' => get_option('apex_field_hero_heading_solutions-digital-field-agent', 'Empower Your Field Teams'),
    'description' => get_option('apex_field_hero_description_solutions-digital-field-agent', 'Mobile tools for loan officers, field agents, and collection teams. Work offline, sync when connected, and serve customers anywhere.'),
    'stats' => $stats_array,
    'image' => get_option('apex_field_hero_image_solutions-digital-field-agent', 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1200')
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge"><?php echo esc_html(get_option('apex_field_features_badge_solutions-digital-field-agent', 'Key Features')); ?></span>
            <h2 class="apex-solution-features__heading"><?php echo esc_html(get_option('apex_field_features_heading_solutions-digital-field-agent', 'Complete Field Operations Platform')); ?></h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <?php
            $features_items = get_option('apex_field_features_items_solutions-digital-field-agent', 
                "Customer Onboarding | Digital KYC with photo capture, ID scanning, and biometric enrollment in the field.\n" .
                "GPS Tracking | Location tracking for visit verification and route optimization.\n" .
                "Collection Management | Daily collection lists, receipt generation, and real-time payment posting.\n" .
                "Offline Capability | Full functionality without internet. Sync automatically when connected.\n" .
                "Loan Applications | Complete loan applications in the field with document capture.\n" .
                "Performance Dashboards | Real-time visibility into field team performance and productivity."
            );
            
            // Feature icons
            $feature_icons = [
                'Customer Onboarding' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                'GPS Tracking' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
                'Collection Management' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                'Offline Capability' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01"/></svg>',
                'Loan Applications' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>',
                'Performance Dashboards' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>'
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
            <span class="apex-solution-specs__badge"><?php echo esc_html(get_option('apex_field_usecases_badge_solutions-digital-field-agent', 'Field Operations Use Cases')); ?></span>
            <h2 class="apex-solution-specs__heading"><?php echo esc_html(get_option('apex_field_usecases_heading_solutions-digital-field-agent', 'Tools for Every Field Role')); ?></h2>
            
            <div class="apex-solution-specs__list">
                <?php
                $usecases_items = get_option('apex_field_usecases_items_solutions-digital-field-agent', 
                    "Loan Officers | Client visits, loan applications, credit assessments, and document collection\n" .
                    "Collection Agents | Daily collection routes, payment receipts, and arrears management\n" .
                    "Customer Acquisition | New member registration, KYC verification, and account opening\n" .
                    "Group Coordinators | Chama meetings, group savings collection, and member management\n" .
                    "Supervisors | Team monitoring, performance tracking, and field visit verification"
                );
                
                foreach (explode("\n", $usecases_items) as $item_line) {
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
            <img src="<?php echo esc_url(get_option('apex_field_usecases_image_solutions-digital-field-agent', 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=600')); ?>" alt="Field Agent Operations" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
