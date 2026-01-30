<?php 
/**
 * Template Name: Solutions Enterprise Integration
 * Enterprise Integration Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
apex_render_about_hero([
    'badge' => 'Enterprise Integration',
    'heading' => 'Connect Your Entire Ecosystem',
    'description' => 'Seamlessly integrate with payment networks, credit bureaus, government systems, and third-party services through our comprehensive API platform.',
    'stats' => [
        ['value' => '50+', 'label' => 'Pre-Built Integrations'],
        ['value' => '99.9%', 'label' => 'API Uptime'],
        ['value' => '<200ms', 'label' => 'Response Time'],
        ['value' => '24/7', 'label' => 'Monitoring']
    ],
    'image' => 'https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=1200'
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge">Integration Categories</span>
            <h2 class="apex-solution-features__heading">Connect With Everything You Need</h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>Payment Networks</h3>
                <p>M-Pesa, Airtel Money, MTN Mobile Money, Visa, Mastercard, RTGS, EFT, and more.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                </div>
                <h3>Credit Bureaus</h3>
                <p>TransUnion, Metropol, CRB Africa, First Central for credit checks and reporting.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <h3>Identity Verification</h3>
                <p>National ID systems, IPRS, NIRA, Smile Identity for KYC verification.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                </div>
                <h3>Accounting Systems</h3>
                <p>SAP, Oracle, QuickBooks, Sage, and custom ERP integrations.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3>Communication</h3>
                <p>SMS gateways, email services, WhatsApp Business API for notifications.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                </div>
                <h3>Custom APIs</h3>
                <p>RESTful APIs with OpenAPI documentation for custom integrations.</p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
