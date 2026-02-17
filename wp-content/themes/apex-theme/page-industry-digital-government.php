<?php 
/**
 * Template Name: Industry Digital Government
 * Digital Government & NGOs Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_gov_hero_stats_industry-digital-government', "10+ | Programs Supported\n\$500M+ | Funds Disbursed\n1M+ | Beneficiaries\n100% | Audit Trail");
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
    'badge' => get_option('apex_gov_hero_badge_industry-digital-government', 'Digital Government & NGOs'),
    'heading' => get_option('apex_gov_hero_heading_industry-digital-government', 'Secure Financial Solutions for Public Programs'),
    'description' => get_option('apex_gov_hero_description_industry-digital-government', 'Enable efficient, transparent, and accountable financial operations for government programs and development organizations. Our platforms ensure funds reach beneficiaries quickly and securely.'),
    'stats' => $stats_array,
    'image' => get_option('apex_gov_hero_image_industry-digital-government', 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=1200')
]);
?>

<section class="apex-industry-challenges">
    <div class="apex-industry-challenges__container">
        <div class="apex-industry-challenges__header">
            <span class="apex-industry-challenges__badge"><?php echo esc_html(get_option('apex_gov_challenges_badge_industry-digital-government', 'Your Challenges')); ?></span>
            <h2 class="apex-industry-challenges__heading"><?php echo esc_html(get_option('apex_gov_challenges_heading_industry-digital-government', 'We Understand Public Sector Challenges')); ?></h2>
            <p class="apex-industry-challenges__description"><?php echo esc_html(get_option('apex_gov_challenges_description_industry-digital-government', 'Government programs and NGOs face unique challenges in financial management. Our solutions address these with purpose-built features.')); ?></p>
        </div>
        
        <div class="apex-industry-challenges__grid">
            <?php
            // Challenge icons
            $challenge_icons = [
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>'
            ];
            
            $challenges = get_option('apex_gov_challenges_items_industry-digital-government', 
                "Accountability & Transparency | Donors and stakeholders demand complete visibility into how funds are used.\n" .
                "Beneficiary Identification | Ensuring funds reach intended beneficiaries without fraud or duplication.\n" .
                "Last-Mile Delivery | Reaching beneficiaries in remote areas with limited banking infrastructure.\n" .
                "Reporting Requirements | Complex reporting requirements from multiple stakeholders and donors."
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
            <span class="apex-industry-solutions__badge"><?php echo esc_html(get_option('apex_gov_solutions_badge_industry-digital-government', 'Our Solutions')); ?></span>
            <h2 class="apex-industry-solutions__heading"><?php echo esc_html(get_option('apex_gov_solutions_heading_industry-digital-government', 'Purpose-Built for Public Programs')); ?></h2>
        </div>
        
        <div class="apex-industry-solutions__grid">
            <?php
            $solutions = get_option('apex_gov_solutions_items_industry-digital-government', 
                "01 | Beneficiary Management | Comprehensive beneficiary registration and verification system with biometric integration to prevent fraud and duplication. | Biometric registration, Deduplication checks, Eligibility verification, Beneficiary portal\n" .
                "02 | Disbursement Platform | Multi-channel disbursement supporting mobile money, bank transfers, and cash through agent networks. | Bulk disbursements, Mobile money integration, Agent cash-out, Real-time tracking\n" .
                "03 | Collection Management | Efficient collection of taxes, fees, and contributions with multiple payment channels and reconciliation. | Multi-channel collection, Automated reconciliation, Receipt generation, Arrears management\n" .
                "04 | Audit & Reporting | Complete audit trail and customizable reporting for donors, government, and internal stakeholders. | Complete audit trail, Donor reports, Real-time dashboards, Custom report builder"
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

<section class="apex-industry-use-cases">
    <div class="apex-industry-use-cases__container">
        <div class="apex-industry-use-cases__header">
            <span class="apex-industry-use-cases__badge"><?php echo esc_html(get_option('apex_gov_usecases_badge_industry-digital-government', 'Use Cases')); ?></span>
            <h2 class="apex-industry-use-cases__heading"><?php echo esc_html(get_option('apex_gov_usecases_heading_industry-digital-government', 'Programs We Support')); ?></h2>
        </div>
        
        <div class="apex-industry-use-cases__grid">
            <?php
            $use_cases = get_option('apex_gov_usecases_items_industry-digital-government', 
                "Social Protection Programs | Cash transfer programs, pension disbursements, and social safety net payments.\n" .
                "Agricultural Subsidies | Farmer registration, input subsidy distribution, and crop payment programs.\n" .
                "Education Grants | Scholarship disbursements, school fee payments, and education stipends.\n" .
                "Health Programs | Community health worker payments, patient support, and health insurance.\n" .
                "Revenue Collection | Tax collection, license fees, and utility payments for government agencies.\n" .
                "Humanitarian Aid | Emergency cash transfers, refugee assistance, and disaster relief programs."
            );
            
            $use_case_lines = explode("\n", $use_cases);
            foreach ($use_case_lines as $use_case_line) {
                $parts = explode(' | ', $use_case_line);
                if (count($parts) >= 2) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    ?>
                    <div class="apex-industry-use-cases__item">
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

<section class="apex-industry-case-study">
    <div class="apex-industry-case-study__container">
        <div class="apex-industry-case-study__content">
            <span class="apex-industry-case-study__badge"><?php echo esc_html(get_option('apex_gov_case_badge_industry-digital-government', 'Success Story')); ?></span>
            <h2 class="apex-industry-case-study__heading"><?php echo esc_html(get_option('apex_gov_case_heading_industry-digital-government', 'National Social Protection Program')); ?></h2>
            <p class="apex-industry-case-study__description"><?php echo esc_html(get_option('apex_gov_case_description_industry-digital-government', 'A national government partnered with us to digitize their social protection program, reaching over 500,000 vulnerable households with monthly cash transfers.')); ?></p>
            
            <div class="apex-industry-case-study__results">
                <?php
                $case_results = get_option('apex_gov_case_results_industry-digital-government', "500K | Households Reached\n98% | Successful Disbursement\n70% | Cost Reduction");
                
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
            
            <a href="<?php echo esc_url(home_url(get_option('apex_gov_case_link_industry-digital-government', '/insights/success-stories'))); ?>" class="apex-industry-case-study__link">Read Full Case Study →</a>
        </div>
        <div class="apex-industry-case-study__image">
            <img src="<?php echo esc_url(get_option('apex_gov_case_image_industry-digital-government', 'https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=600')); ?>" alt="<?php echo esc_attr(get_option('apex_gov_case_heading_industry-digital-government', 'Social Protection Program')); ?>" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
