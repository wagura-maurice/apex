<?php 
/**
 * Template Name: Industry Banks
 * Commercial Banks Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Commercial Banks',
    'heading' => 'Enterprise-Grade Banking Technology',
    'description' => 'Modernize your core banking infrastructure and deliver exceptional digital experiences. Our solutions help banks compete effectively in an increasingly digital landscape.',
    'stats' => [
        ['value' => '15+', 'label' => 'Bank Clients'],
        ['value' => '3M+', 'label' => 'Customers Served'],
        ['value' => '99.99%', 'label' => 'Uptime SLA'],
        ['value' => '10x', 'label' => 'Faster Transactions']
    ],
    'image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=1200'
]);
?>

<section class="apex-industry-challenges">
    <div class="apex-industry-challenges__container">
        <div class="apex-industry-challenges__header">
            <span class="apex-industry-challenges__badge">Your Challenges</span>
            <h2 class="apex-industry-challenges__heading">We Understand Banking Challenges</h2>
            <p class="apex-industry-challenges__description">Commercial banks face intense competition and rapidly evolving customer expectations. Our solutions address these challenges head-on.</p>
        </div>
        
        <div class="apex-industry-challenges__grid">
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </div>
                <h3>Legacy System Constraints</h3>
                <p>Aging core banking systems limit agility and make it difficult to launch new products quickly.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Fintech Competition</h3>
                <p>Agile fintechs are capturing market share with superior digital experiences.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                </div>
                <h3>Regulatory Pressure</h3>
                <p>Increasing regulatory requirements demand robust compliance and reporting capabilities.</p>
            </div>
            
            <div class="apex-industry-challenges__item">
                <div class="apex-industry-challenges__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>Cost Optimization</h3>
                <p>Pressure to reduce cost-to-income ratios while maintaining service quality.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-industry-solutions">
    <div class="apex-industry-solutions__container">
        <div class="apex-industry-solutions__header">
            <span class="apex-industry-solutions__badge">Our Solutions</span>
            <h2 class="apex-industry-solutions__heading">Enterprise Banking Platform</h2>
        </div>
        
        <div class="apex-industry-solutions__grid">
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">01</div>
                <h3>Modern Core Banking</h3>
                <p>Cloud-native core banking system designed for high transaction volumes, real-time processing, and rapid product innovation.</p>
                <ul>
                    <li>Real-time transaction processing</li>
                    <li>Multi-currency support</li>
                    <li>Flexible product configuration</li>
                    <li>API-first architecture</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">02</div>
                <h3>Digital Channels</h3>
                <p>Comprehensive digital banking suite including mobile app, internet banking, and USSD for complete customer coverage.</p>
                <ul>
                    <li>White-label mobile app</li>
                    <li>Responsive internet banking</li>
                    <li>USSD banking</li>
                    <li>Chatbot integration</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">03</div>
                <h3>Payment Hub</h3>
                <p>Unified payment processing platform supporting all payment types and channels with real-time settlement.</p>
                <ul>
                    <li>RTGS/EFT integration</li>
                    <li>Card processing</li>
                    <li>Mobile money interoperability</li>
                    <li>Bill payments</li>
                </ul>
            </div>
            
            <div class="apex-industry-solutions__item">
                <div class="apex-industry-solutions__item-number">04</div>
                <h3>Analytics & Reporting</h3>
                <p>Real-time business intelligence and regulatory reporting to drive decisions and ensure compliance.</p>
                <ul>
                    <li>Real-time dashboards</li>
                    <li>Regulatory reports</li>
                    <li>Customer analytics</li>
                    <li>Risk monitoring</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="apex-industry-case-study">
    <div class="apex-industry-case-study__container">
        <div class="apex-industry-case-study__content">
            <span class="apex-industry-case-study__badge">Success Story</span>
            <h2 class="apex-industry-case-study__heading">Unity Bank's Core Banking Transformation</h2>
            <p class="apex-industry-case-study__description">Unity Bank Nigeria replaced their 15-year-old legacy core with ApexCore, achieving seamless migration and dramatically improved performance.</p>
            
            <div class="apex-industry-case-study__results">
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">Zero</span>
                    <span class="apex-industry-case-study__result-label">Downtime Migration</span>
                </div>
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">10x</span>
                    <span class="apex-industry-case-study__result-label">Faster Transactions</span>
                </div>
                <div class="apex-industry-case-study__result">
                    <span class="apex-industry-case-study__result-value">50%</span>
                    <span class="apex-industry-case-study__result-label">Cost Reduction</span>
                </div>
            </div>
            
            <a href="<?php echo home_url('/insights/success-stories'); ?>" class="apex-industry-case-study__link">Read Full Case Study →</a>
        </div>
        <div class="apex-industry-case-study__image">
            <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=600" alt="Unity Bank" loading="lazy">
        </div>
    </div>
</section>

<?php 
// CTA Section
apex_render_about_cta([
    'heading' => 'Ready to Modernize Your Bank?',
    'description' => 'See how our enterprise banking platform can transform your operations.',
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
