<?php 
/**
 * Template Name: Industry MFIs
 * Microfinance Institutions Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Microfinance Institutions',
    'heading' => 'Empowering MFIs to Reach More, Serve Better',
    'description' => 'Digital-first solutions designed specifically for microfinance institutions. Reduce operational costs, expand your reach, and deliver exceptional service to underserved communities.',
    'stats' => [
        ['value' => '50+', 'label' => 'MFI Clients'],
        ['value' => '5M+', 'label' => 'Borrowers Served'],
        ['value' => '90%', 'label' => 'Faster Processing'],
        ['value' => '45%', 'label' => 'Cost Reduction']
    ],
    'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200'
]);
?>

<section class="apex-industry-challenges">
    <div class="apex-industry-challenges__container">
        <div class="apex-industry-challenges__header">
            <span class="apex-industry-challenges__badge">Your Challenges</span>
            <h2 class="apex-industry-challenges__heading">We Understand MFI Challenges</h2>
            <p class="apex-industry-challenges__description">Microfinance institutions face unique operational challenges. Our solutions are designed to address each one.</p>
        </div>
        
        <div class="apex-industry-challenges__grid">
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </div>
                <h3>Slow Loan Processing</h3>
                <p>Manual processes delay disbursements and frustrate borrowers who need quick access to funds.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>High Operating Costs</h3>
                <p>Paper-based operations and manual data entry drive up costs and reduce profitability.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <h3>Limited Geographic Reach</h3>
                <p>Serving remote communities is expensive with traditional branch-based models.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Credit Risk Management</h3>
                <p>Assessing creditworthiness without traditional credit history is challenging.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-industry-solutions">
    <div class="apex-industry-solutions__container">
        <div class="apex-industry-solutions__header">
            <span class="apex-industry-solutions__badge">Our Solutions</span>
            <h2 class="apex-industry-solutions__heading">Purpose-Built for Microfinance</h2>
        </div>
        
        <div class="apex-industry-solutions__grid">
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">01</div>
                <h3>Digital Loan Origination</h3>
                <p>Automate the entire loan lifecycle from application to disbursement. Reduce processing time from days to minutes with digital workflows and automated credit scoring.</p>
                <ul>
                    <li>Mobile loan applications</li>
                    <li>Automated credit scoring</li>
                    <li>Digital document collection</li>
                    <li>Instant disbursement to mobile money</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">02</div>
                <h3>Agent Banking Network</h3>
                <p>Extend your reach without building branches. Our agent banking platform lets you serve customers through a network of local agents in their communities.</p>
                <ul>
                    <li>Agent onboarding and management</li>
                    <li>Real-time transaction processing</li>
                    <li>Commission management</li>
                    <li>Agent performance analytics</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">03</div>
                <h3>Mobile Banking App</h3>
                <p>Give your customers 24/7 access to their accounts. Our mobile app works even in low-connectivity areas with offline-first design.</p>
                <ul>
                    <li>Account management</li>
                    <li>Loan repayments</li>
                    <li>Mobile money integration</li>
                    <li>Push notifications</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">04</div>
                <h3>Group Lending Management</h3>
                <p>Manage group loans efficiently with tools designed for solidarity lending models popular in microfinance.</p>
                <ul>
                    <li>Group formation and management</li>
                    <li>Meeting scheduling</li>
                    <li>Group savings tracking</li>
                    <li>Peer guarantee management</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="apex-industry-case-study">
    <div class="apex-industry-case-study__container">
        <div class="apex-industry-case-study__content">
            <span class="apex-industry-case-study__badge">Success Story</span>
            <h2 class="apex-industry-case-study__heading">How Umoja MFI Scaled to 500,000 Customers</h2>
            <p class="apex-industry-case-study__description">Umoja Microfinance was struggling with manual processes that limited their growth. After implementing our digital lending platform, they transformed their operations.</p>
            
            <div class="apex-industry-case-study__results">
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">500K</span>
                    <span class="apex-industry-case-study__result-label">Active Borrowers</span>
                </div>
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">90%</span>
                    <span class="apex-industry-case-study__result-label">Faster Processing</span>
                </div>
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">60%</span>
                    <span class="apex-industry-case-study__result-label">Cost Reduction</span>
                </div>
            </div>
            
            <a href="<?php echo home_url('/insights/success-stories'); ?>" class="apex-industry-case-study__link">Read Full Case Study →</a>
        </div>
        <div class="apex-industry-case-study__image">
            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=600" alt="Umoja MFI Success" loading="lazy">
        </div>
    </div>
</section>

<?php 
// CTA Section
apex_render_about_cta([
    'heading' => 'Ready to Transform Your MFI?',
    'description' => 'See how our solutions can help you reach more borrowers and reduce costs.',
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
