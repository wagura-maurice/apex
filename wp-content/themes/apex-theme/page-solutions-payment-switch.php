<?php 
/**
 * Template Name: Solutions Payment Switch
 * Payment Switch & General Ledger Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
apex_render_about_hero([
    'badge' => 'Payment Switch & General Ledger',
    'heading' => 'Process Payments, Balance Books',
    'description' => 'A unified payment processing platform with integrated general ledger for real-time settlement and accurate financial reporting.',
    'stats' => [
        ['value' => '$5B+', 'label' => 'Annual Volume'],
        ['value' => '10M+', 'label' => 'Transactions/Month'],
        ['value' => '<1s', 'label' => 'Settlement Time'],
        ['value' => '100%', 'label' => 'Reconciliation']
    ],
    'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200'
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge">Key Features</span>
            <h2 class="apex-solution-features__heading">Complete Payment & Accounting Solution</h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>Multi-Channel Payments</h3>
                <p>Process payments from mobile, web, POS, ATM, and agent channels through a single switch.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <h3>Real-Time Settlement</h3>
                <p>Instant settlement with automatic posting to the general ledger.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/></svg>
                </div>
                <h3>Chart of Accounts</h3>
                <p>Flexible chart of accounts supporting multiple currencies and reporting hierarchies.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg>
                </div>
                <h3>Auto-Reconciliation</h3>
                <p>Automated reconciliation with external systems and exception handling workflows.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                </div>
                <h3>Financial Reports</h3>
                <p>Balance sheets, income statements, trial balance, and custom financial reports.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Fraud Detection</h3>
                <p>Real-time transaction monitoring with rule-based and ML-powered fraud detection.</p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
