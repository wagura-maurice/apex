<?php 
/**
 * Template Name: Industry Credit Unions
 * SACCOs & Credit Unions Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'SACCOs & Credit Unions',
    'heading' => 'Modern Solutions for Member-Owned Institutions',
    'description' => 'Empower your members with digital services while preserving the cooperative values that make SACCOs special. Our solutions are designed for the unique needs of member-owned financial institutions.',
    'stats' => [
        ['value' => '40+', 'label' => 'SACCO Clients'],
        ['value' => '2M+', 'label' => 'Members Served'],
        ['value' => '300%', 'label' => 'Avg. Growth'],
        ['value' => '4.8/5', 'label' => 'Satisfaction']
    ],
    'image' => 'https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=1200'
]);
?>

<section class="apex-industry-challenges">
    <div class="apex-industry-challenges__container">
        <div class="apex-industry-challenges__header">
            <span class="apex-industry-challenges__badge">Your Challenges</span>
            <h2 class="apex-industry-challenges__heading">We Understand SACCO Challenges</h2>
            <p class="apex-industry-challenges__description">SACCOs face unique challenges balancing member service with operational efficiency. We've built solutions that address each one.</p>
        </div>
        
        <div class="apex-industry-challenges__grid">
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Member Expectations</h3>
                <p>Members expect digital services comparable to commercial banks while maintaining personal relationships.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                </div>
                <h3>Regulatory Compliance</h3>
                <p>Keeping up with evolving SASRA and Central Bank regulations requires constant system updates.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>
                </div>
                <h3>Dividend Management</h3>
                <p>Complex dividend calculations and distribution across different share classes is time-consuming.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </div>
                <h3>Legacy Systems</h3>
                <p>Outdated systems limit growth and make it difficult to offer modern digital services.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-industry-solutions">
    <div class="apex-industry-solutions__container">
        <div class="apex-industry-solutions__header">
            <span class="apex-industry-solutions__badge">Our Solutions</span>
            <h2 class="apex-industry-solutions__heading">Purpose-Built for SACCOs</h2>
        </div>
        
        <div class="apex-industry-solutions__grid">
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">01</div>
                <h3>Member Management</h3>
                <p>Complete member lifecycle management from registration to exit. Track shares, savings, loans, and guarantees in one unified system.</p>
                <ul>
                    <li>Digital member onboarding</li>
                    <li>Share capital management</li>
                    <li>Guarantor tracking</li>
                    <li>Member portal access</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">02</div>
                <h3>Savings Products</h3>
                <p>Flexible savings product configuration to match your SACCO's unique offerings, from regular savings to fixed deposits.</p>
                <ul>
                    <li>Multiple savings accounts</li>
                    <li>Interest calculation automation</li>
                    <li>Standing orders</li>
                    <li>Goal-based savings</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">03</div>
                <h3>Loan Management</h3>
                <p>Streamline loan processing with automated eligibility checks, approval workflows, and disbursement.</p>
                <ul>
                    <li>Multiple loan products</li>
                    <li>Guarantor management</li>
                    <li>Automated eligibility</li>
                    <li>Check-off integration</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">04</div>
                <h3>Mobile & USSD Banking</h3>
                <p>Give members 24/7 access to their accounts through mobile app and USSD for feature phones.</p>
                <ul>
                    <li>Balance inquiries</li>
                    <li>Mini statements</li>
                    <li>Loan applications</li>
                    <li>Fund transfers</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="apex-industry-case-study">
    <div class="apex-industry-case-study__container">
        <div class="apex-industry-case-study__content">
            <span class="apex-industry-case-study__badge">Success Story</span>
            <h2 class="apex-industry-case-study__heading">Kenya National SACCO's Digital Transformation</h2>
            <p class="apex-industry-case-study__description">Kenya National SACCO was losing members to commercial banks offering digital services. After implementing our platform, they became a digital leader in the SACCO sector.</p>
            
            <div class="apex-industry-case-study__results">
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">300%</span>
                    <span class="apex-industry-case-study__result-label">Membership Growth</span>
                </div>
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">65%</span>
                    <span class="apex-industry-case-study__result-label">Cost Reduction</span>
                </div>
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">4.8/5</span>
                    <span class="apex-industry-case-study__result-label">Member Satisfaction</span>
                </div>
            </div>
            
            <a href="<?php echo home_url('/insights/success-stories'); ?>" class="apex-industry-case-study__link">Read Full Case Study →</a>
        </div>
        <div class="apex-industry-case-study__image">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=600" alt="Kenya National SACCO" loading="lazy">
        </div>
    </div>
</section>

<?php 
// CTA Section
apex_render_about_cta([
    'heading' => 'Ready to Modernize Your SACCO?',
    'description' => 'See how our solutions can help you serve members better and grow sustainably.',
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
