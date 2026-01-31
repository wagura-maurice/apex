<?php 
/**
 * Template Name: Solutions Loan Origination
 * Loan Origination & Workflows Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
apex_render_about_hero([
    'badge' => 'Loan Origination & Workflows',
    'heading' => 'From Application to Disbursement in Minutes',
    'description' => 'Automate your entire loan lifecycle with digital applications, automated credit scoring, and streamlined approval workflows.',
    'stats' => [
        ['value' => '90%', 'label' => 'Faster Processing'],
        ['value' => '$2B+', 'label' => 'Loans Processed'],
        ['value' => '50%', 'label' => 'Cost Reduction'],
        ['value' => '95%', 'label' => 'Approval Rate']
    ],
    'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200'
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge">Key Features</span>
            <h2 class="apex-solution-features__heading">End-to-End Loan Management</h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
                </div>
                <h3>Digital Applications</h3>
                <p>Mobile and web loan applications with document upload and e-signature support.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="M22 4L12 14.01l-3-3"/></svg>
                </div>
                <h3>Automated Credit Scoring</h3>
                <p>AI-powered credit scoring with bureau integration and alternative data sources.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><path d="M20 8v6M23 11h-6"/></svg>
                </div>
                <h3>Approval Workflows</h3>
                <p>Configurable multi-level approval workflows with delegation and escalation rules.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>Instant Disbursement</h3>
                <p>Automated disbursement to bank accounts or mobile money upon approval.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <h3>Repayment Management</h3>
                <p>Flexible repayment schedules with automated reminders and collection workflows.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8"/></svg>
                </div>
                <h3>Document Management</h3>
                <p>Digital document collection, verification, and secure storage.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-solution-specs">
    <div class="apex-solution-specs__container">
        <div class="apex-solution-specs__content">
            <span class="apex-solution-specs__badge">Loan Product Types</span>
            <h2 class="apex-solution-specs__heading">Support for All Lending Models</h2>
            
            <div class="apex-solution-specs__list">
                <div class="apex-solution-specs__item">
                    <h4>Individual Loans</h4>
                    <p>Personal, salary, emergency, and asset financing with flexible terms</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>Group Lending</h4>
                    <p>Chama loans, group guarantees, and solidarity lending models</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>SME & Business Loans</h4>
                    <p>Working capital, trade finance, and equipment financing</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>Agricultural Loans</h4>
                    <p>Seasonal lending with harvest-based repayment schedules</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>Digital Nano-Loans</h4>
                    <p>Instant mobile loans with automated scoring and disbursement</p>
                </div>
            </div>
        </div>
        <div class="apex-solution-specs__image">
            <img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=600" alt="Loan Products" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
