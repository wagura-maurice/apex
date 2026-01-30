<?php 
/**
 * Template Name: Solutions Mobile Wallet
 * Mobile Wallet App Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
apex_render_about_hero([
    'badge' => 'Mobile Wallet App',
    'heading' => 'Banking in Every Pocket',
    'description' => 'A white-label mobile banking app designed for African markets. Offline-first architecture ensures your customers can bank anywhere, anytime.',
    'stats' => [
        ['value' => '5M+', 'label' => 'App Users'],
        ['value' => '4.7★', 'label' => 'App Rating'],
        ['value' => '60%', 'label' => 'Offline Usage'],
        ['value' => '<3s', 'label' => 'Load Time']
    ],
    'image' => 'https://images.unsplash.com/photo-1512941937669-90a1b58e7e9c?w=1200'
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge">Key Features</span>
            <h2 class="apex-solution-features__heading">Complete Mobile Banking Experience</h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01"/></svg>
                </div>
                <h3>Offline-First Design</h3>
                <p>Queue transactions when offline and sync automatically when connectivity returns. Perfect for rural areas.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Biometric Security</h3>
                <p>Fingerprint and face recognition for secure, convenient authentication.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>Money Transfers</h3>
                <p>Send money to bank accounts, mobile money, and other app users instantly.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M6 8h.01M2 12h20"/></svg>
                </div>
                <h3>Bill Payments</h3>
                <p>Pay utilities, airtime, and other bills directly from the app.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                </div>
                <h3>Loan Applications</h3>
                <p>Apply for loans, track status, and manage repayments from your phone.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                </div>
                <h3>Push Notifications</h3>
                <p>Real-time alerts for transactions, payments due, and promotional offers.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-solution-specs">
    <div class="apex-solution-specs__container">
        <div class="apex-solution-specs__content">
            <span class="apex-solution-specs__badge">White-Label Solution</span>
            <h2 class="apex-solution-specs__heading">Your Brand, Our Technology</h2>
            
            <div class="apex-solution-specs__list">
                <div class="apex-solution-specs__item">
                    <h4>Custom Branding</h4>
                    <p>Your logo, colors, and brand identity throughout the app</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>Platform Support</h4>
                    <p>Native iOS and Android apps with shared codebase</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>App Store Publishing</h4>
                    <p>We handle submission to Apple App Store and Google Play</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>OTA Updates</h4>
                    <p>Push updates without requiring app store approval</p>
                </div>
            </div>
        </div>
        <div class="apex-solution-specs__image">
            <img src="https://images.unsplash.com/photo-1556656793-08538906a9f8?w=600" alt="Mobile App" loading="lazy">
        </div>
    </div>
</section>

<?php 
apex_render_about_cta([
    'heading' => 'Ready to Launch Your Mobile App?',
    'description' => 'Get your branded mobile banking app live in weeks.',
    'cta_primary' => [
        'text' => 'Request a Demo',
        'url' => home_url('/request-demo')
    ],
    'cta_secondary' => [
        'text' => 'Contact Sales',
        'url' => home_url('/contact')
    ]
]);
?>

<?php get_footer(); ?>
