<?php 
/**
 * Template Name: FAQ
 * FAQ Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'FAQ',
    'heading' => 'Frequently Asked Questions',
    'description' => 'Find answers to common questions about our products, services, and company.',
    'stats' => [
        ['value' => '50+', 'label' => 'Questions Answered'],
        ['value' => '24/7', 'label' => 'Support Available'],
        ['value' => '5min', 'label' => 'Avg. Read Time'],
        ['value' => '100%', 'label' => 'Coverage']
    ],
    'image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1200'
]);
?>

<section class="apex-faq-content">
    <div class="apex-faq-content__container">
        <div class="apex-faq-content__sidebar">
            <h3>Categories</h3>
            <nav class="apex-faq-content__nav">
                <a href="#general" class="apex-faq-content__nav-link active">General</a>
                <a href="#products" class="apex-faq-content__nav-link">Products & Services</a>
                <a href="#pricing" class="apex-faq-content__nav-link">Pricing</a>
                <a href="#technical" class="apex-faq-content__nav-link">Technical Support</a>
                <a href="#security" class="apex-faq-content__nav-link">Security</a>
                <a href="#billing" class="apex-faq-content__nav-link">Billing</a>
            </nav>
        </div>
        
        <div class="apex-faq-content__main">
            <section id="general" class="apex-faq-content__section">
                <h2>General Questions</h2>
                
                <div class="apex-faq-content__item">
                    <h3>What is Apex Softwares?</h3>
                    <p>Apex Softwares is a leading African fintech company providing core banking, mobile banking, and financial technology solutions to financial institutions across 15+ African countries. We help SACCOs, MFIs, and commercial banks modernize their operations and reach more customers.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>Which countries do you operate in?</h3>
                    <p>We currently operate in Kenya, Uganda, Tanzania, Nigeria, Ghana, Rwanda, South Africa, and 8 other African countries. We're continuously expanding our presence across the continent.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>How long have you been in business?</h3>
                    <p>Apex Softwares was founded in 2010. We have over 14 years of experience serving financial institutions across Africa, with a proven track record of successful implementations and satisfied clients.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>How do I get started with Apex?</h3>
                    <p>Getting started is easy! Simply contact our sales team to schedule a demo. We'll discuss your specific needs and provide a customized proposal. Implementation typically takes 3-6 months depending on the scope of the project.</p>
                </div>
            </section>
            
            <section id="products" class="apex-faq-content__section">
                <h2>Products & Services</h2>
                
                <div class="apex-faq-content__item">
                    <h3>What products do you offer?</h3>
                    <p>We offer a comprehensive suite of financial technology solutions including: Core Banking (ApexCore), Mobile Banking, Agent Banking, Internet Banking, Payment Switch, Loan Origination, Digital Field Agent, and Enterprise Integration platforms.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>Can your solutions integrate with existing systems?</h3>
                    <p>Yes! Our solutions are designed with integration in mind. We support standard APIs and can build custom integrations with your existing core banking, payment, and third-party systems. Our enterprise integration platform handles complex integration scenarios.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>Do you offer cloud or on-premise deployment?</h3>
                    <p>We offer both cloud and on-premise deployment options. Cloud deployment offers faster implementation and lower upfront costs, while on-premise gives you complete control over your infrastructure. We'll help you choose the best option for your needs.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>What about mobile app support?</h3>
                    <p>Our mobile banking apps work on both iOS and Android. We also offer USSD banking for feature phones and offline-first design that works in low-connectivity areas common in rural Africa.</p>
                </div>
            </section>
            
            <section id="pricing" class="apex-faq-content__section">
                <h2>Pricing</h2>
                
                <div class="apex-faq-content__item">
                    <h3>How is your pricing structured?</h3>
                    <p>We offer flexible pricing models including licensing, subscription, and transaction-based options. Pricing depends on the products you need, your institution size, and deployment preference. Contact our sales team for a customized quote.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>Are there any hidden fees?</h3>
                    <p>No, we believe in transparent pricing. All fees are clearly outlined in your proposal and contract. There are no hidden charges or surprise fees.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>What's included in the pricing?</h3>
                    <p>Our pricing includes software licenses, implementation, training, ongoing support, and regular updates. We also provide access to our knowledge base, documentation, and customer portal.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>Do you offer discounts for smaller institutions?</h3>
                    <p>Yes! We have special pricing for smaller institutions and startups. Our modular approach allows you to start with what you need and add capabilities as you grow.</p>
                </div>
            </section>
            
            <section id="technical" class="apex-faq-content__section">
                <h2>Technical Support</h2>
                
                <div class="apex-faq-content__item">
                    <h3>What support options do you offer?</h3>
                    <p>We offer 24/7 support for critical issues, business hours support for non-critical issues, and dedicated account managers for enterprise clients. Support is available via phone, email, live chat, and our customer portal.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>What's your response time?</h3>
                    <p>We respond to all support inquiries within 2 hours during business hours. Critical issues are addressed immediately with 24/7 availability. Our average resolution time is under 4 hours for most issues.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>Do you provide training?</h3>
                    <p>Yes! We provide comprehensive training during implementation including hands-on sessions, documentation, and train-the-trainer programs. We also offer ongoing training sessions and webinars.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>How do you handle software updates?</h3>
                    <p>We regularly release updates with new features, improvements, and security patches. Updates are included in your subscription and can be scheduled at your convenience. We provide advance notice for major releases.</p>
                </div>
            </section>
            
            <section id="security" class="apex-faq-content__section">
                <h2>Security</h2>
                
                <div class="apex-faq-content__item">
                    <h3>How secure is your platform?</h3>
                    <p>Security is our top priority. We use industry-standard encryption, regular security audits, penetration testing, and comply with Central Bank regulations across all our operating countries. Our platform is ISO 27001 certified.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>Where is my data stored?</h3>
                    <p>Data storage location depends on your deployment preference. For cloud deployments, we offer data residency options within Africa. We comply with all local data protection regulations including GDPR where applicable.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>What happens in case of a security incident?</h3>
                    <p>We have a comprehensive incident response plan. In case of a security incident, we will notify affected parties within 24 hours, provide regular updates, and work with regulatory authorities as required. We maintain cyber insurance for additional protection.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>Do you offer disaster recovery?</h3>
                    <p>Yes, we offer comprehensive disaster recovery with automated backups, geo-redundancy, and business continuity planning. Our cloud platform offers 99.99% uptime SLA.</p>
                </div>
            </section>
            
            <section id="billing" class="apex-faq-content__section">
                <h2>Billing</h2>
                
                <div class="apex-faq-content__item">
                    <h3>What payment methods do you accept?</h3>
                    <p>We accept bank transfers, mobile money (M-Pesa, Airtel Money), and international wire transfers. For enterprise clients, we can set up net-30 payment terms.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>When are invoices sent?</h3>
                    <p>Invoices are sent monthly for subscription-based pricing and upon project milestones for implementation projects. All invoices include detailed breakdown of charges.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>Can I cancel my subscription?</h3>
                    <p>Yes, you can cancel your subscription with 30 days notice. We'll help you export your data and ensure a smooth transition. Early termination fees may apply depending on your contract terms.</p>
                </div>
                
                <div class="apex-faq-content__item">
                    <h3>What's your refund policy?</h3>
                    <p>Refunds are handled on a case-by-case basis. If you're not satisfied with our service, please contact our customer success team and we'll work to resolve any issues.</p>
                </div>
            </section>
        </div>
    </div>
</section>


<?php get_footer(); ?>
