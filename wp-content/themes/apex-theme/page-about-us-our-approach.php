<?php 
/**
 * Template Name: Our Approach
 * Our Approach Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Our Approach',
    'heading' => 'How We Deliver Excellence',
    'description' => 'Our methodology combines deep industry expertise with agile development practices to deliver solutions that transform financial institutions.',
    'stats' => [
        ['value' => '98%', 'label' => 'Client Retention'],
        ['value' => '45', 'label' => 'Avg Days to Deploy'],
        ['value' => '24/7', 'label' => 'Support Coverage'],
        ['value' => '99.9%', 'label' => 'System Uptime']
    ],
    'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200'
]);
?>

<section class="apex-approach-methodology" data-approach-section>
    <div class="apex-approach-methodology__container">
        <div class="apex-approach-methodology__header">
            <span class="apex-approach-methodology__badge">Our Methodology</span>
            <h2 class="apex-approach-methodology__heading">A Proven Framework for Success</h2>
            <p class="apex-approach-methodology__description">We follow a structured yet flexible approach that ensures every implementation delivers maximum value while minimizing risk.</p>
        </div>
        
        <div class="apex-approach-methodology__phases">
            <div class="apex-approach-methodology__phase">
                <div class="apex-approach-methodology__phase-number">01</div>
                <div class="apex-approach-methodology__phase-content">
                    <h3>Discovery & Assessment</h3>
                    <p>We begin by deeply understanding your institution's unique challenges, goals, and existing infrastructure. Our team conducts comprehensive assessments to identify opportunities for optimization and growth.</p>
                    <ul>
                        <li>Stakeholder interviews and requirements gathering</li>
                        <li>Current system and process analysis</li>
                        <li>Gap analysis and opportunity identification</li>
                        <li>Regulatory compliance review</li>
                    </ul>
                </div>
            </div>
            
            <div class="apex-approach-methodology__phase">
                <div class="apex-approach-methodology__phase-number">02</div>
                <div class="apex-approach-methodology__phase-content">
                    <h3>Solution Design</h3>
                    <p>Based on our findings, we design a tailored solution architecture that addresses your specific needs while leveraging the full power of the ApexCore platform.</p>
                    <ul>
                        <li>Custom solution architecture design</li>
                        <li>Integration mapping and API planning</li>
                        <li>User experience and workflow design</li>
                        <li>Security and compliance framework</li>
                    </ul>
                </div>
            </div>
            
            <div class="apex-approach-methodology__phase">
                <div class="apex-approach-methodology__phase-number">03</div>
                <div class="apex-approach-methodology__phase-content">
                    <h3>Agile Implementation</h3>
                    <p>Our agile development methodology ensures rapid delivery with continuous feedback loops. We work in sprints, delivering functional components that you can test and validate.</p>
                    <ul>
                        <li>Iterative development with 2-week sprints</li>
                        <li>Continuous integration and testing</li>
                        <li>Regular demos and stakeholder reviews</li>
                        <li>Parallel data migration and validation</li>
                    </ul>
                </div>
            </div>
            
            <div class="apex-approach-methodology__phase">
                <div class="apex-approach-methodology__phase-number">04</div>
                <div class="apex-approach-methodology__phase-content">
                    <h3>Training & Change Management</h3>
                    <p>Technology is only as good as the people using it. We invest heavily in training and change management to ensure your team is confident and capable.</p>
                    <ul>
                        <li>Role-based training programs</li>
                        <li>Train-the-trainer sessions</li>
                        <li>Comprehensive documentation and guides</li>
                        <li>Change management support</li>
                    </ul>
                </div>
            </div>
            
            <div class="apex-approach-methodology__phase">
                <div class="apex-approach-methodology__phase-number">05</div>
                <div class="apex-approach-methodology__phase-content">
                    <h3>Go-Live & Optimization</h3>
                    <p>We ensure a smooth transition to production with comprehensive support. Post-launch, we continue to optimize and enhance your solution based on real-world usage.</p>
                    <ul>
                        <li>Phased rollout strategy</li>
                        <li>Hypercare support period</li>
                        <li>Performance monitoring and optimization</li>
                        <li>Continuous improvement roadmap</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="apex-approach-principles">
    <div class="apex-approach-principles__container">
        <div class="apex-approach-principles__header">
            <span class="apex-approach-principles__badge">Guiding Principles</span>
            <h2 class="apex-approach-principles__heading">What Sets Us Apart</h2>
        </div>
        
        <div class="apex-approach-principles__grid">
            <div class="apex-approach-principles__card">
                <div class="apex-approach-principles__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Client-Centric Focus</h3>
                <p>Every decision we make is guided by what's best for our clients. We measure our success by your success, not by the number of features we ship.</p>
            </div>
            
            <div class="apex-approach-principles__card">
                <div class="apex-approach-principles__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Security First</h3>
                <p>Security isn't an afterthought—it's built into everything we do. From architecture to deployment, we follow industry best practices and regulatory requirements.</p>
            </div>
            
            <div class="apex-approach-principles__card">
                <div class="apex-approach-principles__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3>Speed to Value</h3>
                <p>We understand that time is money. Our proven methodology and pre-built components enable rapid deployment without sacrificing quality or customization.</p>
            </div>
            
            <div class="apex-approach-principles__card">
                <div class="apex-approach-principles__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/></svg>
                </div>
                <h3>Scalable Architecture</h3>
                <p>Our solutions are designed to grow with you. Whether you're serving 1,000 or 1 million customers, our platform scales seamlessly to meet demand.</p>
            </div>
            
            <div class="apex-approach-principles__card">
                <div class="apex-approach-principles__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                </div>
                <h3>Continuous Innovation</h3>
                <p>The financial industry never stands still, and neither do we. We continuously invest in R&D to bring you the latest technologies and capabilities.</p>
            </div>
            
            <div class="apex-approach-principles__card">
                <div class="apex-approach-principles__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </div>
                <h3>Transparent Communication</h3>
                <p>We believe in open, honest communication. You'll always know where your project stands, what challenges we're facing, and how we're addressing them.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-approach-support">
    <div class="apex-approach-support__container">
        <div class="apex-approach-support__content">
            <span class="apex-approach-support__badge">Ongoing Partnership</span>
            <h2 class="apex-approach-support__heading">Support That Never Sleeps</h2>
            <p class="apex-approach-support__description">Our relationship doesn't end at go-live. We provide comprehensive support and continuous improvement services to ensure your platform evolves with your business.</p>
            
            <div class="apex-approach-support__features">
                <div class="apex-approach-support__feature">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <div>
                        <h4>24/7 Technical Support</h4>
                        <p>Round-the-clock access to our expert support team via phone, email, and chat.</p>
                    </div>
                </div>
                
                <div class="apex-approach-support__feature">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
                    <div>
                        <h4>Regular Updates</h4>
                        <p>Quarterly platform updates with new features, security patches, and performance improvements.</p>
                    </div>
                </div>
                
                <div class="apex-approach-support__feature">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    <div>
                        <h4>Knowledge Base</h4>
                        <p>Comprehensive documentation, tutorials, and best practices at your fingertips.</p>
                    </div>
                </div>
                
                <div class="apex-approach-support__feature">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <div>
                        <h4>Dedicated Success Manager</h4>
                        <p>A single point of contact who understands your business and advocates for your needs.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="apex-approach-support__stats">
            <div class="apex-approach-support__stat-card">
                <span class="apex-approach-support__stat-value">&lt;15min</span>
                <span class="apex-approach-support__stat-label">Average Response Time</span>
            </div>
            <div class="apex-approach-support__stat-card">
                <span class="apex-approach-support__stat-value">95%</span>
                <span class="apex-approach-support__stat-label">First Call Resolution</span>
            </div>
            <div class="apex-approach-support__stat-card">
                <span class="apex-approach-support__stat-value">4.9/5</span>
                <span class="apex-approach-support__stat-label">Customer Satisfaction</span>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
