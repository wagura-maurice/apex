<?php 
/**
 * Template Name: Industry MFIs
 * Microfinance Institutions Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_mfi_hero_stats_industry-mfis', "50+ | MFI Clients\n5M+ | Borrowers Served\n90% | Faster Processing\n45% | Cost Reduction");
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
    'badge' => get_option('apex_mfi_hero_badge_industry-mfis', 'Microfinance Institutions'),
    'heading' => get_option('apex_mfi_hero_heading_industry-mfis', 'Empowering MFIs to Reach More, Serve Better'),
    'description' => get_option('apex_mfi_hero_description_industry-mfis', 'Digital-first solutions designed specifically for microfinance institutions. Reduce operational costs, expand your reach, and deliver exceptional service to underserved communities.'),
    'stats' => $stats_array,
    'image' => get_option('apex_mfi_hero_image_industry-mfis', 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200')
]);
?>

<section class="apex-industry-challenges">
    <div class="apex-industry-challenges__container">
        <div class="apex-industry-challenges__header">
            <span class="apex-industry-challenges__badge"><?php echo esc_html(get_option('apex_mfi_challenges_badge_industry-mfis', 'Your Challenges')); ?></span>
            <h2 class="apex-industry-challenges__heading"><?php echo esc_html(get_option('apex_mfi_challenges_heading_industry-mfis', 'We Understand MFI Challenges')); ?></h2>
            <p class="apex-industry-challenges__description"><?php echo esc_html(get_option('apex_mfi_challenges_description_industry-mfis', 'Microfinance institutions face unique operational challenges. Our solutions are designed to address each one.')); ?></p>
        </div>
        
        <div class="apex-industry-challenges__grid">
            <?php
            // Challenge icons
            $challenge_icons = [
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'
            ];
            
            $challenges = get_option('apex_mfi_challenges_items_industry-mfis', 
                "Slow Loan Processing | Manual processes delay disbursements and frustrate borrowers who need quick access to funds.\n" .
                "High Operating Costs | Paper-based operations and manual data entry drive up costs and reduce profitability.\n" .
                "Limited Geographic Reach | Serving remote communities is expensive with traditional branch-based models.\n" .
                "Credit Risk Management | Assessing creditworthiness without traditional credit history is challenging."
            );
            
            $challenge_lines = explode("\n", $challenges);
            $icon_index = 0;
            foreach ($challenge_lines as $challenge_line) {
                $parts = explode(' | ', $challenge_line);
                if (count($parts) >= 2) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $icon = isset($challenge_icons[$icon_index]) ? $challenge_icons[$icon_index] : '';
                    ?>
                    <div class="apex-industry-challenges__item">
                        <div class="apex-industry-challenges__icon">
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

<section class="apex-industry-solutions">
    <div class="apex-industry-solutions__container">
        <div class="apex-industry-solutions__header">
            <span class="apex-industry-solutions__badge"><?php echo esc_html(get_option('apex_mfi_solutions_badge_industry-mfis', 'Our Solutions')); ?></span>
            <h2 class="apex-industry-solutions__heading"><?php echo esc_html(get_option('apex_mfi_solutions_heading_industry-mfis', 'Purpose-Built for Microfinance')); ?></h2>
        </div>
        
        <div class="apex-industry-solutions__grid">
            <?php
            $solutions = get_option('apex_mfi_solutions_items_industry-mfis', 
                "01 | Digital Loan Origination | Automate the entire loan lifecycle from application to disbursement. Reduce processing time from days to minutes with digital workflows and automated credit scoring. | Mobile loan applications, Automated credit scoring, Digital document collection, Instant disbursement to mobile money\n" .
                "02 | Agent Banking Network | Extend your reach without building branches. Our agent banking platform lets you serve customers through a network of local agents in their communities. | Agent onboarding and management, Real-time transaction processing, Commission management, Agent performance analytics\n" .
                "03 | Mobile Banking App | Give your customers 24/7 access to their accounts. Our mobile app works even in low-connectivity areas with offline-first design. | Account management, Loan repayments, Mobile money integration, Push notifications\n" .
                "04 | Group Lending Management | Manage group loans efficiently with tools designed for solidarity lending models popular in microfinance. | Group formation and management, Meeting scheduling, Group savings tracking, Peer guarantee management"
            );
            
            $solution_lines = explode("\n", $solutions);
            foreach ($solution_lines as $solution_line) {
                $parts = explode(' | ', $solution_line);
                if (count($parts) >= 4) {
                    $number = trim($parts[0]);
                    $title = trim($parts[1]);
                    $description = trim($parts[2]);
                    $features = explode(',', $parts[3]);
                    ?>
                    <div class="apex-industry-solutions__item">
                        <div class="apex-industry-solutions__item-number"><?php echo esc_html($number); ?></div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                        <ul>
                            <?php foreach ($features as $feature): ?>
                                <li><?php echo esc_html(trim($feature)); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-industry-case-study">
    <div class="apex-industry-case-study__container">
        <div class="apex-industry-case-study__content">
            <span class="apex-industry-case-study__badge"><?php echo esc_html(get_option('apex_mfi_case_badge_industry-mfis', 'Success Story')); ?></span>
            <h2 class="apex-industry-case-study__heading"><?php echo esc_html(get_option('apex_mfi_case_heading_industry-mfis', 'How Umoja MFI Scaled to 500,000 Customers')); ?></h2>
            <p class="apex-industry-case-study__description"><?php echo esc_html(get_option('apex_mfi_case_description_industry-mfis', 'Umoja Microfinance was struggling with manual processes that limited their growth. After implementing our digital lending platform, they transformed their operations.')); ?></p>
            
            <div class="apex-industry-case-study__results">
                <?php
                $case_results = get_option('apex_mfi_case_results_industry-mfis', "500K | Active Borrowers\n90% | Faster Processing\n60% | Cost Reduction");
                
                foreach (explode("\n", $case_results) as $result_line) {
                    $parts = explode(' | ', $result_line);
                    if (count($parts) >= 2) {
                        $value = trim($parts[0]);
                        $label = trim($parts[1]);
                        ?>
                        <div class="apex-industry-case-study__result">
                            <span class="apex-industry-case-study__result-value"><?php echo esc_html($value); ?></span>
                            <span class="apex-industry-case-study__result-label"><?php echo esc_html($label); ?></span>
                        </div>
                        <?php
                    }
                }
                ?>
            </div>
            
            <a href="<?php echo esc_url(home_url(get_option('apex_mfi_case_link_industry-mfis', '/insights/success-stories'))); ?>" class="apex-industry-case-study__link">Read Full Case Study →</a>
        </div>
        <div class="apex-industry-case-study__image">
            <img src="<?php echo esc_url(get_option('apex_mfi_case_image_industry-mfis', 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=600')); ?>" alt="<?php echo esc_attr(get_option('apex_mfi_case_heading_industry-mfis', 'Umoja MFI Success')); ?>" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
