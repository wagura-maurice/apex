<?php 
/**
 * Template Name: Partners
 * Partners Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Partners',
    'heading' => 'Partner with Us to Transform African Fintech',
    'description' => 'Join our growing ecosystem of partners and help drive financial inclusion across Africa. We offer flexible partnership models tailored to your business.',
    'stats' => [
        ['value' => '50+', 'label' => 'Partners'],
        ['value' => '15+', 'label' => 'Countries'],
        ['value' => '100+', 'label' => 'Joint Projects'],
        ['value' => '$1B+', 'label' => 'Transactions Processed']
    ],
    'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200'
]);
?>

<section class="apex-partners-benefits">
    <div class="apex-partners-benefits__container">
        <div class="apex-partners-benefits__header">
            <h2 class="apex-partners-benefits__heading">Why Partner with Apex?</h2>
            <p class="apex-partners-benefits__description">We're committed to mutual growth and success</p>
        </div>
        
        <div class="apex-partners-benefits__grid">
            <div class="apex-partners-benefits__item">
                <div class="apex-partners-benefits__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Market Leadership</h3>
                <p>Partner with Africa's leading fintech company serving 50+ financial institutions across 15 countries.</p>
            </div>
            
            <div class="apex-partners-benefits__item">
                <div class="apex-partners-benefits__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>Revenue Sharing</h3>
                <p>Attractive revenue models with competitive commissions and flexible terms designed for mutual benefit.</p>
            </div>
            
            <div class="apex-partners-benefits__item">
                <div class="apex-partners-benefits__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Dedicated Support</h3>
                <p>Access to our dedicated partner support team, training programs, and marketing resources.</p>
            </div>
            
            <div class="apex-partners-benefits__item">
                <div class="apex-partners-benefits__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <h3>Technical Integration</h3>
                <p>Comprehensive APIs, SDKs, and integration support to ensure seamless deployment.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-partners-types">
    <div class="apex-partners-types__container">
        <div class="apex-partners-types__header">
            <h2 class="apex-partners-types__heading">Partnership Models</h2>
            <p class="apex-partners-types__description">Choose the partnership model that fits your business</p>
        </div>
        
        <div class="apex-partners-types__grid">
            <div class="apex-partners-types__card">
                <div class="apex-partners-types__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                </div>
                <h3>Reseller Partner</h3>
                <p>Sell our solutions to your clients and earn attractive commissions. Ideal for IT consultants, system integrators, and VARs.</p>
                <ul>
                    <li>Competitive commission rates</li>
                    <li>Marketing support</li>
                    <li>Training and certification</li>
                    <li>Lead generation support</li>
                </ul>
                <a href="#" class="apex-partners-types__card-cta">Learn More →</a>
            </div>
            
            <div class="apex-partners-types__card">
                <div class="apex-partners-types__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                </div>
                <h3>Technology Partner</h3>
                <p>Integrate our solutions with your technology stack and create comprehensive offerings for your customers.</p>
                <ul>
                    <li>API access and documentation</li>
                    <li>Joint go-to-market</li>
                    <li>Co-marketing opportunities</li>
                    <li>Technical collaboration</li>
                </ul>
                <a href="#" class="apex-partners-types__card-cta">Learn More →</a>
            </div>
            
            <div class="apex-partners-types__card">
                <div class="apex-partners-types__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Referral Partner</h3>
                <p>Refer clients to us and earn referral fees. Low commitment with high rewards for qualified referrals.</p>
                <ul>
                    <li>Referral commissions</li>
                    <li>Easy onboarding</li>
                    <li>Tracking and reporting</li>
                    <li>No sales commitment</li>
                </ul>
                <a href="#" class="apex-partners-types__card-cta">Learn More →</a>
            </div>
            
            <div class="apex-partners-types__card">
                <div class="apex-partners-types__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                </div>
                <h3>Strategic Partner</h3>
                <p>Deep integration and collaboration for long-term strategic partnerships. For large enterprises and institutions.</p>
                <ul>
                    <li>Custom integration</li>
                    <li>Revenue sharing</li>
                    <li>Co-development</li>
                    <li>Priority support</li>
                </ul>
                <a href="#" class="apex-partners-types__card-cta">Learn More →</a>
            </div>
        </div>
    </div>
</section>

<section class="apex-partners-process">
    <div class="apex-partners-process__container">
        <div class="apex-partners-process__header">
            <h2 class="apex-partners-process__heading">Partner Onboarding Process</h2>
            <p class="apex-partners-process__description">Simple, transparent, and efficient</p>
        </div>
        
        <div class="apex-partners-process__steps">
            <div class="apex-partners-process__step">
                <div class="apex-partners-process__step-number">01</div>
                <h3>Apply Online</h3>
                <p>Submit your partnership application through our online portal with your business details.</p>
            </div>
            
            <div class="apex-partners-process__step">
                <div class="apex-partners-process__step-number">02</div>
                <h3>Review & Approval</h3>
                <p>Our team reviews your application and contacts you within 5 business days.</p>
            </div>
            
            <div class="apex-partners-process__step">
                <div class="apex-partners-process__step-number">03</div>
                <h3>Agreement Signing</h3>
                <p>Review and sign the partnership agreement tailored to your chosen model.</p>
            </div>
            
            <div class="apex-partners-process__step">
                <div class="apex-partners-process__step-number">04</div>
                <h3>Onboarding & Training</h3>
                <p>Complete onboarding training and access partner resources and tools.</p>
            </div>
            
            <div class="apex-partners-process__step">
                <div class="apex-partners-process__step-number">05</div>
                <h3>Start Selling</h3>
                <p>Begin selling and earning with full support from our partner team.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-partners-logos">
    <div class="apex-partners-logos__container">
        <div class="apex-partners-logos__header">
            <h2 class="apex-partners-logos__heading">Our Partners</h2>
            <p class="apex-partners-logos__description">Trusted by leading organizations across Africa</p>
        </div>
        
        <div class="apex-partners-logos__grid">
            <div class="apex-partners-logos__item">
                <img src="https://via.placeholder.com/200x80?text=Partner+1" alt="Partner Logo">
            </div>
            <div class="apex-partners-logos__item">
                <img src="https://via.placeholder.com/200x80?text=Partner+2" alt="Partner Logo">
            </div>
            <div class="apex-partners-logos__item">
                <img src="https://via.placeholder.com/200x80?text=Partner+3" alt="Partner Logo">
            </div>
            <div class="apex-partners-logos__item">
                <img src="https://via.placeholder.com/200x80?text=Partner+4" alt="Partner Logo">
            </div>
            <div class="apex-partners-logos__item">
                <img src="https://via.placeholder.com/200x80?text=Partner+5" alt="Partner Logo">
            </div>
            <div class="apex-partners-logos__item">
                <img src="https://via.placeholder.com/200x80?text=Partner+6" alt="Partner Logo">
            </div>
        </div>
    </div>
</section>

<section class="apex-partners-testimonial">
    <div class="apex-partners-testimonial__container">
        <div class="apex-partners-testimonial__content">
            <span class="apex-partners-testimonial__badge">Partner Success Story</span>
            <h2 class="apex-partners-testimonial__heading">How TechCorp Africa Grew Revenue by 300%</h2>
            <p class="apex-partners-testimonial__description">"Partnering with Apex has been transformative for our business. Their comprehensive solutions, excellent support, and attractive revenue model helped us expand our client base and triple our revenue in just two years."</p>
            
            <div class="apex-partners-testimonial__author">
                <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" alt="Partner">
                <div>
                    <strong>John Kamau</strong>
                    <span>CEO, TechCorp Africa</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php 
// CTA Section
apex_render_about_cta([
    'heading' => 'Ready to Partner with Us?',
    'description' => 'Join our growing ecosystem of partners and start earning today.',
    'cta_primary' => [
        'text' => 'Apply Now',
        'url' => home_url('/contact')
    ],
    'cta_secondary' => [
        'text' => 'Learn More',
        'url' => '#'
    ]
]);
?>

<?php get_footer(); ?>
