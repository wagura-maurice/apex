<?php 
/**
 * Template Name: Industry Digital Government
 * Digital Government & NGOs Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Digital Government & NGOs',
    'heading' => 'Secure Financial Solutions for Public Programs',
    'description' => 'Enable efficient, transparent, and accountable financial operations for government programs and development organizations. Our platforms ensure funds reach beneficiaries quickly and securely.',
    'stats' => [
        ['value' => '10+', 'label' => 'Programs Supported'],
        ['value' => '$500M+', 'label' => 'Funds Disbursed'],
        ['value' => '1M+', 'label' => 'Beneficiaries'],
        ['value' => '100%', 'label' => 'Audit Trail']
    ],
    'image' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=1200'
]);
?>

<section class="apex-industry-challenges">
    <div class="apex-industry-challenges__container">
        <div class="apex-industry-challenges__header">
            <span class="apex-industry-challenges__badge">Your Challenges</span>
            <h2 class="apex-industry-challenges__heading">We Understand Public Sector Challenges</h2>
            <p class="apex-industry-challenges__description">Government programs and NGOs face unique challenges in financial management. Our solutions address these with purpose-built features.</p>
        </div>
        
        <div class="apex-industry-challenges__grid">
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                </div>
                <h3>Accountability & Transparency</h3>
                <p>Donors and stakeholders demand complete visibility into how funds are used.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Beneficiary Identification</h3>
                <p>Ensuring funds reach intended beneficiaries without fraud or duplication.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                </div>
                <h3>Last-Mile Delivery</h3>
                <p>Reaching beneficiaries in remote areas with limited banking infrastructure.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                </div>
                <h3>Reporting Requirements</h3>
                <p>Complex reporting requirements from multiple stakeholders and donors.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-industry-solutions">
    <div class="apex-industry-solutions__container">
        <div class="apex-industry-solutions__header">
            <span class="apex-industry-solutions__badge">Our Solutions</span>
            <h2 class="apex-industry-solutions__heading">Purpose-Built for Public Programs</h2>
        </div>
        
        <div class="apex-industry-solutions__grid">
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">01</div>
                <h3>Beneficiary Management</h3>
                <p>Comprehensive beneficiary registration and verification system with biometric integration to prevent fraud and duplication.</p>
                <ul>
                    <li>Biometric registration</li>
                    <li>Deduplication checks</li>
                    <li>Eligibility verification</li>
                    <li>Beneficiary portal</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">02</div>
                <h3>Disbursement Platform</h3>
                <p>Multi-channel disbursement supporting mobile money, bank transfers, and cash through agent networks.</p>
                <ul>
                    <li>Bulk disbursements</li>
                    <li>Mobile money integration</li>
                    <li>Agent cash-out</li>
                    <li>Real-time tracking</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">03</div>
                <h3>Collection Management</h3>
                <p>Efficient collection of taxes, fees, and contributions with multiple payment channels and reconciliation.</p>
                <ul>
                    <li>Multi-channel collection</li>
                    <li>Automated reconciliation</li>
                    <li>Receipt generation</li>
                    <li>Arrears management</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">04</div>
                <h3>Audit & Reporting</h3>
                <p>Complete audit trail and customizable reporting for donors, government, and internal stakeholders.</p>
                <ul>
                    <li>Complete audit trail</li>
                    <li>Donor reports</li>
                    <li>Real-time dashboards</li>
                    <li>Custom report builder</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="apex-industry-use-cases">
    <div class="apex-industry-use-cases__container">
        <div class="apex-industry-use-cases__header">
            <span class="apex-industry-use-cases__badge">Use Cases</span>
            <h2 class="apex-industry-use-cases__heading">Programs We Support</h2>
        </div>
        
        <div class="apex-industry-use-cases__grid">
            <div class="apex-industry-use-cases__item">
                <h3>Social Protection Programs</h3>
                <p>Cash transfer programs, pension disbursements, and social safety net payments.</p>
            </div>
            <div class="apex-industry-use-cases__item">
                <h3>Agricultural Subsidies</h3>
                <p>Farmer registration, input subsidy distribution, and crop payment programs.</p>
            </div>
            <div class="apex-industry-use-cases__item">
                <h3>Education Grants</h3>
                <p>Scholarship disbursements, school fee payments, and education stipends.</p>
            </div>
            <div class="apex-industry-use-cases__item">
                <h3>Health Programs</h3>
                <p>Community health worker payments, patient support, and health insurance.</p>
            </div>
            <div class="apex-industry-use-cases__item">
                <h3>Revenue Collection</h3>
                <p>Tax collection, license fees, and utility payments for government agencies.</p>
            </div>
            <div class="apex-industry-use-cases__item">
                <h3>Humanitarian Aid</h3>
                <p>Emergency cash transfers, refugee assistance, and disaster relief programs.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-industry-case-study">
    <div class="apex-industry-case-study__container">
        <div class="apex-industry-case-study__content">
            <span class="apex-industry-case-study__badge">Success Story</span>
            <h2 class="apex-industry-case-study__heading">National Social Protection Program</h2>
            <p class="apex-industry-case-study__description">A national government partnered with us to digitize their social protection program, reaching over 500,000 vulnerable households with monthly cash transfers.</p>
            
            <div class="apex-industry-case-study__results">
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">500K</span>
                    <span class="apex-industry-case-study__result-label">Households Reached</span>
                </div>
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">98%</span>
                    <span class="apex-industry-case-study__result-label">Successful Disbursement</span>
                </div>
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">70%</span>
                    <span class="apex-industry-case-study__result-label">Cost Reduction</span>
                </div>
            </div>
            
            <a href="<?php echo home_url('/insights/success-stories'); ?>" class="apex-industry-case-study__link">Read Full Case Study →</a>
        </div>
        <div class="apex-industry-case-study__image">
            <img src="https://images.unsplash.com/photo-1531206715517-5c0ba140b2b8?w=600" alt="Social Protection Program" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
