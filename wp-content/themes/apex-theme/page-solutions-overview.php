<?php 
/**
 * Template Name: Solutions Overview
 * Solutions Overview Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Our Solutions',
    'heading' => 'Complete Digital Banking Suite',
    'description' => 'From core banking to mobile wallets, we provide end-to-end solutions that help financial institutions digitize operations, reach more customers, and drive growth.',
    'stats' => [
        ['value' => '10+', 'label' => 'Product Modules'],
        ['value' => '100+', 'label' => 'Institutions'],
        ['value' => '99.9%', 'label' => 'Uptime'],
        ['value' => '24/7', 'label' => 'Support']
    ],
    'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=1200'
]);
?>

<section class="apex-solutions-grid">
    <div class="apex-solutions-grid__container">
        <div class="apex-solutions-grid__header">
            <span class="apex-solutions-grid__badge">Product Suite</span>
            <h2 class="apex-solutions-grid__heading">Everything You Need to Succeed</h2>
            <p class="apex-solutions-grid__description">Our modular platform lets you start with what you need and add capabilities as you grow.</p>
        </div>
        
        <div class="apex-solutions-grid__items">
            <a href="<?php echo home_url('/solutions/core-banking-microfinance'); ?>" class="apex-solutions-grid__card apex-solutions-grid__card--featured">
                <div class="apex-solutions-grid__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                </div>
                <div class="apex-solutions-grid__card-content">
                    <h3>Core Banking & Microfinance</h3>
                    <p>The foundation of your digital banking infrastructure. Manage accounts, transactions, and products with enterprise-grade reliability.</p>
                    <span class="apex-solutions-grid__card-link">Learn More →</span>
                </div>
            </a>
            
            <a href="<?php echo home_url('/solutions/mobile-wallet-app'); ?>" class="apex-solutions-grid__card">
                <div class="apex-solutions-grid__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
                </div>
                <div class="apex-solutions-grid__card-content">
                    <h3>Mobile Wallet App</h3>
                    <p>White-label mobile banking app with offline-first design for seamless customer experience.</p>
                    <span class="apex-solutions-grid__card-link">Learn More →</span>
                </div>
            </a>
            
            <a href="<?php echo home_url('/solutions/agency-branch-banking'); ?>" class="apex-solutions-grid__card">
                <div class="apex-solutions-grid__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
                </div>
                <div class="apex-solutions-grid__card-content">
                    <h3>Agency & Branch Banking</h3>
                    <p>Extend your reach through agent networks and modernize branch operations.</p>
                    <span class="apex-solutions-grid__card-link">Learn More →</span>
                </div>
            </a>
            
            <a href="<?php echo home_url('/solutions/internet-mobile-banking'); ?>" class="apex-solutions-grid__card">
                <div class="apex-solutions-grid__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
                <div class="apex-solutions-grid__card-content">
                    <h3>Internet & Mobile Banking</h3>
                    <p>Responsive web banking and USSD channels for complete customer coverage.</p>
                    <span class="apex-solutions-grid__card-link">Learn More →</span>
                </div>
            </a>
            
            <a href="<?php echo home_url('/solutions/loan-origination-workflows'); ?>" class="apex-solutions-grid__card">
                <div class="apex-solutions-grid__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                </div>
                <div class="apex-solutions-grid__card-content">
                    <h3>Loan Origination & Workflows</h3>
                    <p>Automate the entire loan lifecycle from application to disbursement and collection.</p>
                    <span class="apex-solutions-grid__card-link">Learn More →</span>
                </div>
            </a>
            
            <a href="<?php echo home_url('/solutions/digital-field-agent'); ?>" class="apex-solutions-grid__card">
                <div class="apex-solutions-grid__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="apex-solutions-grid__card-content">
                    <h3>Digital Field Agent</h3>
                    <p>Empower field officers with mobile tools for customer onboarding and collections.</p>
                    <span class="apex-solutions-grid__card-link">Learn More →</span>
                </div>
            </a>
            
            <a href="<?php echo home_url('/solutions/enterprise-integration'); ?>" class="apex-solutions-grid__card">
                <div class="apex-solutions-grid__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><path d="M3.27 6.96L12 12.01l8.73-5.05M12 22.08V12"/></svg>
                </div>
                <div class="apex-solutions-grid__card-content">
                    <h3>Enterprise Integration</h3>
                    <p>Connect with third-party systems, payment networks, and credit bureaus seamlessly.</p>
                    <span class="apex-solutions-grid__card-link">Learn More →</span>
                </div>
            </a>
            
            <a href="<?php echo home_url('/solutions/payment-switch-ledger'); ?>" class="apex-solutions-grid__card">
                <div class="apex-solutions-grid__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <div class="apex-solutions-grid__card-content">
                    <h3>Payment Switch & General Ledger</h3>
                    <p>Process payments across all channels with real-time settlement and accounting.</p>
                    <span class="apex-solutions-grid__card-link">Learn More →</span>
                </div>
            </a>
            
            <a href="<?php echo home_url('/solutions/reporting-analytics'); ?>" class="apex-solutions-grid__card">
                <div class="apex-solutions-grid__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                </div>
                <div class="apex-solutions-grid__card-content">
                    <h3>Reporting & Analytics</h3>
                    <p>Real-time dashboards, regulatory reports, and business intelligence tools.</p>
                    <span class="apex-solutions-grid__card-link">Learn More →</span>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="apex-solutions-benefits">
    <div class="apex-solutions-benefits__container">
        <div class="apex-solutions-benefits__header">
            <span class="apex-solutions-benefits__badge">Why Apex</span>
            <h2 class="apex-solutions-benefits__heading">Built for African Financial Services</h2>
        </div>
        
        <div class="apex-solutions-benefits__grid">
            <div class="apex-solutions-benefits__item">
                <div class="apex-solutions-benefits__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                </div>
                <h3>Modular Architecture</h3>
                <p>Start with what you need and add modules as you grow. No need to pay for features you don't use.</p>
            </div>
            
            <div class="apex-solutions-benefits__item">
                <div class="apex-solutions-benefits__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01"/></svg>
                </div>
                <h3>Offline-First Design</h3>
                <p>Our mobile solutions work seamlessly in low-connectivity environments common in rural areas.</p>
            </div>
            
            <div class="apex-solutions-benefits__item">
                <div class="apex-solutions-benefits__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Regulatory Compliance</h3>
                <p>Built-in compliance with Central Bank regulations across multiple African jurisdictions.</p>
            </div>
            
            <div class="apex-solutions-benefits__item">
                <div class="apex-solutions-benefits__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <h3>Rapid Deployment</h3>
                <p>Go live in weeks, not months. Our experienced team ensures smooth implementation.</p>
            </div>
            
            <div class="apex-solutions-benefits__item">
                <div class="apex-solutions-benefits__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg>
                </div>
                <h3>Proven Track Record</h3>
                <p>Trusted by 100+ financial institutions across 15+ African countries.</p>
            </div>
            
            <div class="apex-solutions-benefits__item">
                <div class="apex-solutions-benefits__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>24/7 Local Support</h3>
                <p>Round-the-clock support from teams based in Africa who understand your context.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-solutions-integration">
    <div class="apex-solutions-integration__container">
        <div class="apex-solutions-integration__content">
            <span class="apex-solutions-integration__badge">Integrations</span>
            <h2 class="apex-solutions-integration__heading">Connect With Your Ecosystem</h2>
            <p class="apex-solutions-integration__description">Our platform integrates seamlessly with the services and systems you already use.</p>
            
            <div class="apex-solutions-integration__categories">
                <div class="apex-solutions-integration__category">
                    <h4>Payment Networks</h4>
                    <p>M-Pesa, Airtel Money, MTN Mobile Money, Visa, Mastercard, RTGS, EFT</p>
                </div>
                <div class="apex-solutions-integration__category">
                    <h4>Credit Bureaus</h4>
                    <p>TransUnion, Metropol, CRB Africa, First Central</p>
                </div>
                <div class="apex-solutions-integration__category">
                    <h4>Identity Verification</h4>
                    <p>IPRS, NIRA, National ID systems, Smile Identity</p>
                </div>
                <div class="apex-solutions-integration__category">
                    <h4>Accounting Systems</h4>
                    <p>SAP, Oracle, QuickBooks, Sage, custom ERPs</p>
                </div>
            </div>
        </div>
        <div class="apex-solutions-integration__visual">
            <img src="https://images.unsplash.com/photo-1558494949-ef010cbdcc31?w=600" alt="Integration Network" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
