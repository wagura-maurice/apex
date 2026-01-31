<?php 
/**
 * Template Name: Solutions Agency Banking
 * Agency & Branch Banking Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
apex_render_about_hero([
    'badge' => 'Agency & Branch Banking',
    'heading' => 'Extend Your Reach Without Building Branches',
    'description' => 'Transform local shops into banking points and modernize your branch operations. Serve customers where they are with our comprehensive agent and branch banking platform.',
    'stats' => [
        ['value' => '50K+', 'label' => 'Active Agents'],
        ['value' => '85%', 'label' => 'Cost Reduction'],
        ['value' => '10x', 'label' => 'Reach Expansion'],
        ['value' => '24/7', 'label' => 'Service Availability']
    ],
    'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200'
]);
?>

<section class="apex-solution-features">
    <div class="apex-solution-features__container">
        <div class="apex-solution-features__header">
            <span class="apex-solution-features__badge">Key Features</span>
            <h2 class="apex-solution-features__heading">Complete Agent & Branch Solution</h2>
        </div>
        
        <div class="apex-solution-features__grid">
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Agent Onboarding</h3>
                <p>Digital agent recruitment with KYC verification, training modules, and automated activation.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>Float Management</h3>
                <p>Real-time float monitoring, automated rebalancing alerts, and super-agent hierarchy support.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </div>
                <h3>POS Integration</h3>
                <p>Support for Android POS devices, mPOS, and traditional terminals with offline capability.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Commission Management</h3>
                <p>Flexible commission structures with real-time calculation and automated payouts.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                </div>
                <h3>Performance Analytics</h3>
                <p>Agent performance dashboards, territory analytics, and productivity tracking.</p>
            </div>
            
            <div class="apex-solution-features__item">
                <div class="apex-solution-features__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11"/></svg>
                </div>
                <h3>Branch Teller System</h3>
                <p>Modern teller interface with queue management and customer service tools.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-solution-specs">
    <div class="apex-solution-specs__container">
        <div class="apex-solution-specs__content">
            <span class="apex-solution-specs__badge">Agent Network Models</span>
            <h2 class="apex-solution-specs__heading">Flexible Deployment Options</h2>
            
            <div class="apex-solution-specs__list">
                <div class="apex-solution-specs__item">
                    <h4>Retail Agent Model</h4>
                    <p>Partner with existing shops, pharmacies, and retail outlets to offer banking services</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>Super-Agent Hierarchy</h4>
                    <p>Multi-tier agent structure with master agents managing sub-agent networks</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>Bank-Led Model</h4>
                    <p>Direct agent recruitment and management by your institution</p>
                </div>
                <div class="apex-solution-specs__item">
                    <h4>Hybrid Approach</h4>
                    <p>Combine branch, agent, and digital channels for maximum coverage</p>
                </div>
            </div>
        </div>
        <div class="apex-solution-specs__image">
            <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=600" alt="Agent Banking Network" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
