<?php 
/**
 * Template Name: Solutions Internet Banking
 * Internet & Mobile Banking Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
apex_render_about_hero([
    'badge' => 'Internet & Mobile Banking',
    'heading' => 'Digital Channels for Every Customer',
    'description' => 'Responsive web banking and USSD channels ensure every customer can access your services, regardless of their device or connectivity.',
    'stats' => [
        ['value' => '3M+', 'label' => 'Active Users'],
        ['value' => '70%', 'label' => 'Self-Service'],
        ['value' => '40%', 'label' => 'Cost Savings'],
        ['value' => '99.9%', 'label' => 'Uptime']
    ],
    'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1200'
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge">Key Features</span>
            <h2 class="apex-solution-features__heading">Complete Digital Channel Suite</h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </div>
                <h3>Internet Banking Portal</h3>
                <p>Responsive web application for account management, transfers, and self-service operations.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
                </div>
                <h3>USSD Banking</h3>
                <p>Feature phone banking via USSD codes for customers without smartphones or data.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3>Chatbot Integration</h3>
                <p>AI-powered chatbot for customer support and transaction assistance.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Two-Factor Authentication</h3>
                <p>SMS OTP, email verification, and authenticator app support for secure access.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                </div>
                <h3>Statement Downloads</h3>
                <p>Generate and download account statements in PDF and Excel formats.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="M6 8h.01M2 12h20"/></svg>
                </div>
                <h3>Bill Payments</h3>
                <p>Integrated bill payment for utilities, airtime, and other services.</p>
            </div>
        </div>
    </div>
</section>

<?php 
apex_render_about_cta([
    'heading' => 'Ready to Go Digital?',
    'description' => 'Launch your digital banking channels with our proven platform.',
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
