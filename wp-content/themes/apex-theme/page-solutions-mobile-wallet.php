<?php 
/**
 * Template Name: Solutions Mobile Wallet
 * Mobile Wallet App Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_wallet_hero_stats_solutions-mobile-wallet-app', "5M+ | App Users\n4.7★ | App Rating\n60% | Offline Usage\n<3s | Load Time");
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
    'badge' => get_option('apex_wallet_hero_badge_solutions-mobile-wallet-app', 'Mobile Wallet App'),
    'heading' => get_option('apex_wallet_hero_heading_solutions-mobile-wallet-app', 'Banking in Every Pocket'),
    'description' => get_option('apex_wallet_hero_description_solutions-mobile-wallet-app', 'A white-label mobile banking app designed for African markets. Offline-first architecture ensures your customers can bank anywhere, anytime.'),
    'stats' => $stats_array,
    'image' => get_option('apex_wallet_hero_image_solutions-mobile-wallet-app', 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=1200')
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge"><?php echo esc_html(get_option('apex_wallet_features_badge_solutions-mobile-wallet-app', 'Key Features')); ?></span>
            <h2 class="apex-solution-features__heading"><?php echo esc_html(get_option('apex_wallet_features_heading_solutions-mobile-wallet-app', 'Complete Mobile Banking Experience')); ?></h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <?php
            $features_items = get_option('apex_wallet_features_items_solutions-mobile-wallet-app', 
                "Offline-First Design | Queue transactions when offline and sync automatically when connectivity returns. Perfect for rural areas.\n" .
                "Biometric Security | Fingerprint and face recognition for secure, convenient authentication.\n" .
                "Money Transfers | Send money to bank accounts, mobile money, and other app users instantly.\n" .
                "Bill Payments | Pay utilities, airtime, and other bills directly from the app.\n" .
                "Loan Applications | Apply for loans, track status, and manage repayments from your phone.\n" .
                "Push Notifications | Real-time alerts for transactions, payments due, and promotional offers."
            );
            
            // Feature icons
            $feature_icons = [
                'Offline-First Design' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01"/></svg>',
                'Biometric Security' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                'Money Transfers' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                'Bill Payments' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M6 8h.01M2 12h20"/></svg>',
                'Loan Applications' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>',
                'Push Notifications' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/></svg>'
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
            <span class="apex-solution-specs__badge"><?php echo esc_html(get_option('apex_wallet_whitelabel_badge_solutions-mobile-wallet-app', 'White-Label Solution')); ?></span>
            <h2 class="apex-solution-specs__heading"><?php echo esc_html(get_option('apex_wallet_whitelabel_heading_solutions-mobile-wallet-app', 'Your Brand, Our Technology')); ?></h2>
            
            <div class="apex-solution-specs__list">
                <?php
                $whitelabel_items = get_option('apex_wallet_whitelabel_items_solutions-mobile-wallet-app', 
                    "Custom Branding | Your logo, colors, and brand identity throughout the app\n" .
                    "Platform Support | Native iOS and Android apps with shared codebase\n" .
                    "App Store Publishing | We handle submission to Apple App Store and Google Play\n" .
                    "OTA Updates | Push updates without requiring app store approval"
                );
                
                foreach (explode("\n", $whitelabel_items) as $item_line) {
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
            <img src="<?php echo esc_url(get_option('apex_wallet_whitelabel_image_solutions-mobile-wallet-app', 'https://images.unsplash.com/photo-1556656793-08538906a9f8?w=600')); ?>" alt="Mobile App" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
