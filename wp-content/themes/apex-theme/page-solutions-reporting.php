<?php 
/**
 * Template Name: Solutions Reporting
 * Reporting & Analytics Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
apex_render_about_hero([
    'badge' => 'Reporting & Analytics',
    'heading' => 'Data-Driven Decision Making',
    'description' => 'Real-time dashboards, regulatory reports, and business intelligence tools to help you understand your business and make informed decisions.',
    'stats' => [
        ['value' => '100+', 'label' => 'Report Templates'],
        ['value' => 'Real-Time', 'label' => 'Data Updates'],
        ['value' => '50+', 'label' => 'KPI Metrics'],
        ['value' => '1-Click', 'label' => 'Regulatory Reports']
    ],
    'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=1200'
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge">Key Features</span>
            <h2 class="apex-solution-features__heading">Complete Business Intelligence Suite</h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                </div>
                <h3>Executive Dashboards</h3>
                <p>Real-time KPI dashboards for management with drill-down capabilities.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                </div>
                <h3>Regulatory Reports</h3>
                <p>Pre-built Central Bank reports, SASRA returns, and compliance reports.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>
                </div>
                <h3>Portfolio Analytics</h3>
                <p>Loan portfolio analysis, PAR tracking, and risk concentration reports.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <h3>Customer Insights</h3>
                <p>Customer segmentation, behavior analysis, and lifetime value tracking.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                </div>
                <h3>Custom Report Builder</h3>
                <p>Drag-and-drop report builder for creating custom reports without IT help.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <h3>Scheduled Reports</h3>
                <p>Automated report generation and email delivery on your schedule.</p>
            </div>
        </div>
    </div>
</section>

<?php 
apex_render_about_cta([
    'heading' => 'Ready for Better Insights?',
    'description' => 'See how our analytics platform can transform your decision-making.',
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
