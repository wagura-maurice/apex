<?php 
/**
 * Template Name: Industry Banks
 * Commercial Banks Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_bank_hero_stats_industry-banks-microfinance', "15+ | Bank Clients\n3M+ | Customers Served\n99.99% | Uptime SLA\n10x | Faster Transactions");
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
    'badge' => get_option('apex_bank_hero_badge_industry-banks-microfinance', 'Commercial Banks'),
    'heading' => get_option('apex_bank_hero_heading_industry-banks-microfinance', 'Enterprise-Grade Banking Technology'),
    'description' => get_option('apex_bank_hero_description_industry-banks-microfinance', 'Modernize your core banking infrastructure and deliver exceptional digital experiences. Our solutions help banks compete effectively in an increasingly digital landscape.'),
    'stats' => $stats_array,
    'image' => get_option('apex_bank_hero_image_industry-banks-microfinance', 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=1200')
]);
?>

<section class="apex-industry-challenges">
    <div class="apex-industry-challenges__container">
        <div class="apex-industry-challenges__header">
            <span class="apex-industry-challenges__badge"><?php echo esc_html(get_option('apex_bank_challenges_badge_industry-banks-microfinance', 'Your Challenges')); ?></span>
            <h2 class="apex-industry-challenges__heading"><?php echo esc_html(get_option('apex_bank_challenges_heading_industry-banks-microfinance', 'We Understand Banking Challenges')); ?></h2>
            <p class="apex-industry-challenges__description"><?php echo esc_html(get_option('apex_bank_challenges_description_industry-banks-microfinance', 'Commercial banks face intense competition and rapidly evolving customer expectations. Our solutions address these challenges head-on.')); ?></p>
        </div>
        
        <div class="apex-industry-challenges__grid">
            <?php
            // Challenge icons
            $challenge_icons = [
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
            ];
            
            $challenges = get_option('apex_bank_challenges_items_industry-banks-microfinance', 
                "Legacy System Constraints | Aging core banking systems limit agility and make it difficult to launch new products quickly.\n" .
                "Fintech Competition | Agile fintechs are capturing market share with superior digital experiences.\n" .
                "Regulatory Pressure | Increasing regulatory requirements demand robust compliance and reporting capabilities.\n" .
                "Cost Optimization | Pressure to reduce cost-to-income ratios while maintaining service quality."
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
            <span class="apex-industry-solutions__badge"><?php echo esc_html(get_option('apex_bank_solutions_badge_industry-banks-microfinance', 'Our Solutions')); ?></span>
            <h2 class="apex-industry-solutions__heading"><?php echo esc_html(get_option('apex_bank_solutions_heading_industry-banks-microfinance', 'Enterprise Banking Platform')); ?></h2>
        </div>
        
        <div class="apex-industry-solutions__grid">
            <?php
            $solutions = get_option('apex_bank_solutions_items_industry-banks-microfinance', 
                "01 | Modern Core Banking | Cloud-native core banking system designed for high transaction volumes, real-time processing, and rapid product innovation. | Real-time transaction processing, Multi-currency support, Flexible product configuration, API-first architecture\n" .
                "02 | Digital Channels | Comprehensive digital banking suite including mobile app, internet banking, and USSD for complete customer coverage. | White-label mobile app, Responsive internet banking, USSD banking, Chatbot integration\n" .
                "03 | Payment Hub | Unified payment processing platform supporting all payment types and channels with real-time settlement. | RTGS/EFT integration, Card processing, Mobile money interoperability, Bill payments\n" .
                "04 | Analytics & Reporting | Real-time business intelligence and regulatory reporting to drive decisions and ensure compliance. | Real-time dashboards, Regulatory reports, Customer analytics, Risk monitoring"
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
            <span class="apex-industry-case-study__badge"><?php echo esc_html(get_option('apex_bank_case_badge_industry-banks-microfinance', 'Success Story')); ?></span>
            <h2 class="apex-industry-case-study__heading"><?php echo esc_html(get_option('apex_bank_case_heading_industry-banks-microfinance', "Unity Bank's Core Banking Transformation")); ?></h2>
            <p class="apex-industry-case-study__description"><?php echo esc_html(get_option('apex_bank_case_description_industry-banks-microfinance', 'Unity Bank Nigeria replaced their 15-year-old legacy core with ApexCore, achieving seamless migration and dramatically improved performance.')); ?></p>
            
            <div class="apex-industry-case-study__results">
                <?php
                $case_results = get_option('apex_bank_case_results_industry-banks-microfinance', "Zero | Downtime Migration\n10x | Faster Transactions\n50% | Cost Reduction");
                
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
            
            <a href="<?php echo esc_url(home_url(get_option('apex_bank_case_link_industry-banks-microfinance', '/insights/success-stories'))); ?>" class="apex-industry-case-study__link">Read Full Case Study →</a>
        </div>
        <div class="apex-industry-case-study__image">
            <img src="<?php echo esc_url(get_option('apex_bank_case_image_industry-banks-microfinance', 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=600')); ?>" alt="<?php echo esc_attr(get_option('apex_bank_case_heading_industry-banks-microfinance', 'Unity Bank')); ?>" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
