<?php 
/**
 * Template Name: Solutions Field Agent
 * Digital Field Agent Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
apex_render_about_hero([
    'badge' => 'Digital Field Agent',
    'heading' => 'Empower Your Field Teams',
    'description' => 'Mobile tools for loan officers, field agents, and collection teams. Work offline, sync when connected, and serve customers anywhere.',
    'stats' => [
        ['value' => '10K+', 'label' => 'Field Agents'],
        ['value' => '3x', 'label' => 'Productivity'],
        ['value' => '80%', 'label' => 'Offline Usage'],
        ['value' => '95%', 'label' => 'Collection Rate']
    ],
    'image' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?w=1200'
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge">Key Features</span>
            <h2 class="apex-solution-features__heading">Complete Field Operations Platform</h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Customer Onboarding</h3>
                <p>Digital KYC with photo capture, ID scanning, and biometric enrollment in the field.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <h3>GPS Tracking</h3>
                <p>Location tracking for visit verification and route optimization.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>Collection Management</h3>
                <p>Daily collection lists, receipt generation, and real-time payment posting.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01"/></svg>
                </div>
                <h3>Offline Capability</h3>
                <p>Full functionality without internet. Sync automatically when connected.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                </div>
                <h3>Loan Applications</h3>
                <p>Complete loan applications in the field with document capture.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                </div>
                <h3>Performance Dashboards</h3>
                <p>Real-time visibility into field team performance and productivity.</p>
            </div>
        </div>
    </div>
</section>

<?php 
apex_render_about_cta([
    'heading' => 'Ready to Empower Your Field Teams?',
    'description' => 'See how our field agent platform can boost productivity.',
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
