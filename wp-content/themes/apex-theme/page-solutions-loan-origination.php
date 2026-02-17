<?php 
/**
 * Template Name: Solutions Loan Origination
 * Loan Origination & Workflows Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_loan_hero_stats_solutions-loan-origination-workflows', "90% | Faster Processing\n\$2B+ | Loans Processed\n50% | Cost Reduction\n95% | Approval Rate");
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
    'badge' => get_option('apex_loan_hero_badge_solutions-loan-origination-workflows', 'Loan Origination & Workflows'),
    'heading' => get_option('apex_loan_hero_heading_solutions-loan-origination-workflows', 'From Application to Disbursement in Minutes'),
    'description' => get_option('apex_loan_hero_description_solutions-loan-origination-workflows', 'Automate your entire loan lifecycle with digital applications, automated credit scoring, and streamlined approval workflows.'),
    'stats' => $stats_array,
    'image' => get_option('apex_loan_hero_image_solutions-loan-origination-workflows', 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200')
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge"><?php echo esc_html(get_option('apex_loan_features_badge_solutions-loan-origination-workflows', 'Key Features')); ?></span>
            <h2 class="apex-solution-features__heading"><?php echo esc_html(get_option('apex_loan_features_heading_solutions-loan-origination-workflows', 'End-to-End Loan Management')); ?></h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <?php
            $features_items = get_option('apex_loan_features_items_solutions-loan-origination-workflows', 
                "Digital Applications | Mobile and web loan applications with document upload and e-signature support.\n" .
                "Automated Credit Scoring | AI-powered credit scoring with bureau integration and alternative data sources.\n" .
                "Approval Workflows | Configurable multi-level approval workflows with delegation and escalation rules.\n" .
                "Instant Disbursement | Automated disbursement to bank accounts or mobile money upon approval.\n" .
                "Repayment Management | Flexible repayment schedules with automated reminders and collection workflows.\n" .
                "Document Management | Digital document collection, verification, and secure storage."
            );
            
            // Feature icons
            $feature_icons = [
                'Digital Applications' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>',
                'Automated Credit Scoring' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg>',
                'Approval Workflows' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg>',
                'Instant Disbursement' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                'Repayment Management' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
                'Document Management' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8"/></svg>'
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
            <span class="apex-solution-specs__badge"><?php echo esc_html(get_option('apex_loan_products_badge_solutions-loan-origination-workflows', 'Loan Product Types')); ?></span>
            <h2 class="apex-solution-specs__heading"><?php echo esc_html(get_option('apex_loan_products_heading_solutions-loan-origination-workflows', 'Support for All Lending Models')); ?></h2>
            
            <div class="apex-solution-specs__list">
                <?php
                $products_items = get_option('apex_loan_products_items_solutions-loan-origination-workflows', 
                    "Individual Loans | Personal, salary, emergency, and asset financing with flexible terms\n" .
                    "Group Lending | Chama loans, group guarantees, and solidarity lending models\n" .
                    "SME & Business Loans | Working capital, trade finance, and equipment financing\n" .
                    "Agricultural Loans | Seasonal lending with harvest-based repayment schedules\n" .
                    "Digital Nano-Loans | Instant mobile loans with automated scoring and disbursement"
                );
                
                foreach (explode("\n", $products_items) as $item_line) {
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
            <img src="<?php echo esc_url(get_option('apex_loan_products_image_solutions-loan-origination-workflows', 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=600')); ?>" alt="Loan Products" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
