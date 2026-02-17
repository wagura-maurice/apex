<?php 
/**
 * Template Name: Solutions Payment Switch
 * Payment Switch & General Ledger Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_payment_hero_stats_solutions-payment-switch-ledger', "\$5B+ | Annual Volume\n10M+ | Transactions/Month\n<1s | Settlement Time\n100% | Reconciliation");
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
    'badge' => get_option('apex_payment_hero_badge_solutions-payment-switch-ledger', 'Payment Switch & General Ledger'),
    'heading' => get_option('apex_payment_hero_heading_solutions-payment-switch-ledger', 'Process Payments, Balance Books'),
    'description' => get_option('apex_payment_hero_description_solutions-payment-switch-ledger', 'A unified payment processing platform with integrated general ledger for real-time settlement and accurate financial reporting.'),
    'stats' => $stats_array,
    'image' => get_option('apex_payment_hero_image_solutions-payment-switch-ledger', 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200')
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge"><?php echo esc_html(get_option('apex_payment_features_badge_solutions-payment-switch-ledger', 'Key Features')); ?></span>
            <h2 class="apex-solution-features__heading"><?php echo esc_html(get_option('apex_payment_features_heading_solutions-payment-switch-ledger', 'Complete Payment & Accounting Solution')); ?></h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <?php
            $features_items = get_option('apex_payment_features_items_solutions-payment-switch-ledger', 
                "Multi-Channel Payments | Process payments from mobile, web, POS, ATM, and agent channels through a single switch.\n" .
                "Real-Time Settlement | Instant settlement with automatic posting to the general ledger.\n" .
                "Chart of Accounts | Flexible chart of accounts supporting multiple currencies and reporting hierarchies.\n" .
                "Auto-Reconciliation | Automated reconciliation with external systems and exception handling workflows.\n" .
                "Financial Reports | Balance sheets, income statements, trial balance, and custom financial reports.\n" .
                "Fraud Detection | Real-time transaction monitoring with rule-based and ML-powered fraud detection."
            );
            
            // Feature icons
            $feature_icons = [
                'Multi-Channel Payments' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>',
                'Real-Time Settlement' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>',
                'Chart of Accounts' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>',
                'Auto-Reconciliation' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg>',
                'Financial Reports' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>',
                'Fraud Detection' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>'
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
            <span class="apex-solution-specs__badge"><?php echo esc_html(get_option('apex_payment_rails_badge_solutions-payment-switch-ledger', 'Supported Payment Rails')); ?></span>
            <h2 class="apex-solution-specs__heading"><?php echo esc_html(get_option('apex_payment_rails_heading_solutions-payment-switch-ledger', 'Connect to Every Payment Network')); ?></h2>
            
            <div class="apex-solution-specs__list">
                <?php
                $rails_items = get_option('apex_payment_rails_items_solutions-payment-switch-ledger', 
                    "Mobile Money | M-Pesa, Airtel Money, MTN MoMo, Orange Money, and regional wallets\n" .
                    "Card Networks | Visa, Mastercard, UnionPay, and local card schemes\n" .
                    "Bank Transfers | RTGS, EFT, SWIFT, and domestic clearing systems\n" .
                    "QR Payments | Static and dynamic QR codes for merchant payments\n" .
                    "Bill Aggregators | Utility payments, government services, and merchant collections"
                );
                
                foreach (explode("\n", $rails_items) as $item_line) {
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
            <img src="<?php echo esc_url(get_option('apex_payment_rails_image_solutions-payment-switch-ledger', 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?w=600')); ?>" alt="Payment Networks" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
