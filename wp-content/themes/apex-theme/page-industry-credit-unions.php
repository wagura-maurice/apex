<?php 
/**
 * Template Name: Industry Credit Unions
 * SACCOs & Credit Unions Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_credit_hero_stats_industry-credit-unions', "40+ | SACCO Clients\n2M+ | Members Served\n300% | Avg. Growth\n4.8/5 | Satisfaction");
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
    'badge' => get_option('apex_credit_hero_badge_industry-credit-unions', 'SACCOs & Credit Unions'),
    'heading' => get_option('apex_credit_hero_heading_industry-credit-unions', 'Modern Solutions for Member-Owned Institutions'),
    'description' => get_option('apex_credit_hero_description_industry-credit-unions', 'Empower your members with digital services while preserving the cooperative values that make SACCOs special. Our solutions are designed for the unique needs of member-owned financial institutions.'),
    'stats' => $stats_array,
    'image' => get_option('apex_credit_hero_image_industry-credit-unions', 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=1200')
]);
?>

<section class="apex-industry-challenges">
    <div class="apex-industry-challenges__container">
        <div class="apex-industry-challenges__header">
            <span class="apex-industry-challenges__badge"><?php echo esc_html(get_option('apex_credit_challenges_badge_industry-credit-unions', 'Your Challenges')); ?></span>
            <h2 class="apex-industry-challenges__heading"><?php echo esc_html(get_option('apex_credit_challenges_heading_industry-credit-unions', 'We Understand SACCO Challenges')); ?></h2>
            <p class="apex-industry-challenges__description"><?php echo esc_html(get_option('apex_credit_challenges_description_industry-credit-unions', "SACCOs face unique challenges balancing member service with operational efficiency. We've built solutions that address each one.")); ?></p>
        </div>
        
        <div class="apex-industry-challenges__grid">
            <?php
            // Challenge icons
            $challenge_icons = [
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>'
            ];
            
            $challenges = get_option('apex_credit_challenges_items_industry-credit-unions', 
                "Member Expectations | Members expect digital services comparable to commercial banks while maintaining personal relationships.\n" .
                "Regulatory Compliance | Keeping up with evolving SASRA and Central Bank regulations requires constant system updates.\n" .
                "Dividend Management | Complex dividend calculations and distribution across different share classes is time-consuming.\n" .
                "Legacy Systems | Outdated systems limit growth and make it difficult to offer modern digital services."
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
            <span class="apex-industry-solutions__badge"><?php echo esc_html(get_option('apex_credit_solutions_badge_industry-credit-unions', 'Our Solutions')); ?></span>
            <h2 class="apex-industry-solutions__heading"><?php echo esc_html(get_option('apex_credit_solutions_heading_industry-credit-unions', 'Purpose-Built for SACCOs')); ?></h2>
        </div>
        
        <div class="apex-industry-solutions__grid">
            <?php
            $solutions = get_option('apex_credit_solutions_items_industry-credit-unions', 
                "01 | Member Management | Complete member lifecycle management from registration to exit. Track shares, savings, loans, and guarantees in one unified system. | Digital member onboarding, Share capital management, Guarantor tracking, Member portal access\n" .
                "02 | Savings Products | Flexible savings product configuration to match your SACCO's unique offerings, from regular savings to fixed deposits. | Multiple savings accounts, Interest calculation automation, Standing orders, Goal-based savings\n" .
                "03 | Loan Management | Streamline loan processing with automated eligibility checks, approval workflows, and disbursement. | Multiple loan products, Guarantor management, Automated eligibility, Check-off integration\n" .
                "04 | Mobile & USSD Banking | Give members 24/7 access to their accounts through mobile app and USSD for feature phones. | Balance inquiries, Mini statements, Loan applications, Fund transfers"
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
            <span class="apex-industry-case-study__badge"><?php echo esc_html(get_option('apex_credit_case_badge_industry-credit-unions', 'Success Story')); ?></span>
            <h2 class="apex-industry-case-study__heading"><?php echo esc_html(get_option('apex_credit_case_heading_industry-credit-unions', "Kenya National SACCO's Digital Transformation")); ?></h2>
            <p class="apex-industry-case-study__description"><?php echo esc_html(get_option('apex_credit_case_description_industry-credit-unions', 'Kenya National SACCO was losing members to commercial banks offering digital services. After implementing our platform, they became a digital leader in the SACCO sector.')); ?></p>
            
            <div class="apex-industry-case-study__results">
                <?php
                $case_results = get_option('apex_credit_case_results_industry-credit-unions', "300% | Membership Growth\n65% | Cost Reduction\n4.8/5 | Member Satisfaction");
                
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
            
            <a href="<?php echo esc_url(home_url(get_option('apex_credit_case_link_industry-credit-unions', '/insights/success-stories'))); ?>" class="apex-industry-case-study__link">Read Full Case Study →</a>
        </div>
        <div class="apex-industry-case-study__image">
            <img src="<?php echo esc_url(get_option('apex_credit_case_image_industry-credit-unions', 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=600')); ?>" alt="<?php echo esc_attr(get_option('apex_credit_case_heading_industry-credit-unions', 'Kenya National SACCO')); ?>" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
