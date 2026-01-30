<?php 
/**
 * Template Name: Industry Overview
 * Industry Overview Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Industries We Serve',
    'heading' => 'Tailored Solutions for Every Financial Institution',
    'description' => 'From microfinance institutions to commercial banks, we understand the unique challenges each sector faces. Our solutions are designed to meet your specific needs.',
    'stats' => [
        ['value' => '100+', 'label' => 'Institutions Served'],
        ['value' => '5', 'label' => 'Industry Verticals'],
        ['value' => '15+', 'label' => 'Countries'],
        ['value' => '10M+', 'label' => 'End Users']
    ],
    'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=1200'
]);
?>

<section class="apex-industry-sectors">
    <div class="apex-industry-sectors__container">
        <div class="apex-industry-sectors__header">
            <span class="apex-industry-sectors__badge">Our Expertise</span>
            <h2 class="apex-industry-sectors__heading">Industries We Specialize In</h2>
            <p class="apex-industry-sectors__description">We've built deep expertise across the financial services landscape, enabling us to deliver solutions that truly understand your business.</p>
        </div>
        
        <div class="apex-industry-sectors__grid">
            <a href="<?php echo home_url('/industry/mfis'); ?>" class="apex-industry-sectors__card">
                <div class="apex-industry-sectors__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Microfinance Institutions</h3>
                <p>Empower underserved communities with digital-first microfinance solutions that reduce costs and expand reach.</p>
                <div class="apex-industry-sectors__card-stats">
                    <span><strong>50+</strong> MFI Clients</span>
                    <span><strong>5M+</strong> Borrowers Served</span>
                </div>
                <span class="apex-industry-sectors__card-link">Learn More →</span>
            </a>
            
            <a href="<?php echo home_url('/industry/credit-unions'); ?>" class="apex-industry-sectors__card">
                <div class="apex-industry-sectors__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
                </div>
                <h3>SACCOs & Credit Unions</h3>
                <p>Modern member management and savings solutions designed for cooperative financial institutions.</p>
                <div class="apex-industry-sectors__card-stats">
                    <span><strong>40+</strong> SACCOs</span>
                    <span><strong>2M+</strong> Members</span>
                </div>
                <span class="apex-industry-sectors__card-link">Learn More →</span>
            </a>
            
            <a href="<?php echo home_url('/industry/banks-microfinance'); ?>" class="apex-industry-sectors__card">
                <div class="apex-industry-sectors__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                </div>
                <h3>Commercial Banks</h3>
                <p>Enterprise-grade core banking and digital channel solutions for banks of all sizes.</p>
                <div class="apex-industry-sectors__card-stats">
                    <span><strong>15+</strong> Banks</span>
                    <span><strong>3M+</strong> Customers</span>
                </div>
                <span class="apex-industry-sectors__card-link">Learn More →</span>
            </a>
            
            <a href="<?php echo home_url('/industry/digital-government'); ?>" class="apex-industry-sectors__card">
                <div class="apex-industry-sectors__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                </div>
                <h3>Digital Government & NGOs</h3>
                <p>Secure disbursement and collection platforms for government programs and development organizations.</p>
                <div class="apex-industry-sectors__card-stats">
                    <span><strong>10+</strong> Programs</span>
                    <span><strong>$500M+</strong> Disbursed</span>
                </div>
                <span class="apex-industry-sectors__card-link">Learn More →</span>
            </a>
        </div>
    </div>
</section>

<section class="apex-industry-why">
    <div class="apex-industry-why__container">
        <div class="apex-industry-why__content">
            <span class="apex-industry-why__badge">Why Choose Us</span>
            <h2 class="apex-industry-why__heading">Built for African Financial Services</h2>
            <p class="apex-industry-why__description">We understand the unique challenges of operating in African markets—from infrastructure limitations to regulatory complexity. Our solutions are designed from the ground up to address these realities.</p>
            
            <div class="apex-industry-why__features">
                <div class="apex-industry-why__feature">
                    <div class="apex-industry-why__feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                    </div>
                    <div>
                        <h4>Modular Architecture</h4>
                        <p>Start with what you need and add capabilities as you grow. No need to pay for features you don't use.</p>
                    </div>
                </div>
                
                <div class="apex-industry-why__feature">
                    <div class="apex-industry-why__feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    </div>
                    <div>
                        <h4>Regulatory Compliance</h4>
                        <p>Built-in compliance with Central Bank regulations across multiple African jurisdictions.</p>
                    </div>
                </div>
                
                <div class="apex-industry-why__feature">
                    <div class="apex-industry-why__feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12.55a11 11 0 0 1 14.08 0M1.42 9a16 16 0 0 1 21.16 0M8.53 16.11a6 6 0 0 1 6.95 0M12 20h.01"/></svg>
                    </div>
                    <div>
                        <h4>Offline-First Design</h4>
                        <p>Our mobile solutions work seamlessly in low-connectivity environments common in rural areas.</p>
                    </div>
                </div>
                
                <div class="apex-industry-why__feature">
                    <div class="apex-industry-why__feature-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <div>
                        <h4>24/7 Local Support</h4>
                        <p>Round-the-clock support from teams based in Africa who understand your context.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="apex-industry-why__image">
            <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=600" alt="Team collaboration" loading="lazy">
        </div>
    </div>
</section>

<section class="apex-industry-stats">
    <div class="apex-industry-stats__container">
        <div class="apex-industry-stats__header">
            <h2 class="apex-industry-stats__heading">Trusted Across the Continent</h2>
            <p class="apex-industry-stats__description">Our track record speaks for itself.</p>
        </div>
        
        <div class="apex-industry-stats__grid">
            <div class="apex-industry-stats__item">
                <span class="apex-industry-stats__value">$5B+</span>
                <span class="apex-industry-stats__label">Transactions Processed Annually</span>
            </div>
            <div class="apex-industry-stats__item">
                <span class="apex-industry-stats__value">99.9%</span>
                <span class="apex-industry-stats__label">Platform Uptime</span>
            </div>
            <div class="apex-industry-stats__item">
                <span class="apex-industry-stats__value">40%</span>
                <span class="apex-industry-stats__label">Average Cost Reduction</span>
            </div>
            <div class="apex-industry-stats__item">
                <span class="apex-industry-stats__value">3x</span>
                <span class="apex-industry-stats__label">Customer Growth Rate</span>
            </div>
        </div>
    </div>
</section>

<section class="apex-industry-testimonial">
    <div class="apex-industry-testimonial__container">
        <div class="apex-industry-testimonial__quote">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
        </div>
        <blockquote class="apex-industry-testimonial__text">
            "Apex Softwares truly understands the African financial services landscape. Their solutions have helped us reach customers we never thought possible while dramatically reducing our operational costs."
        </blockquote>
        <div class="apex-industry-testimonial__author">
            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" alt="James Mwangi">
            <div>
                <strong>James Mwangi</strong>
                <span>CEO, Kenya National SACCO</span>
            </div>
        </div>
    </div>
</section>

<?php 
// CTA Section
apex_render_about_cta([
    'heading' => 'Ready to Transform Your Institution?',
    'description' => 'Let\'s discuss how our industry-specific solutions can help you achieve your goals.',
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
