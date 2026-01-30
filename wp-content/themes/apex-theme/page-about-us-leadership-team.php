<?php 
/**
 * Template Name: Leadership Team
 * Leadership Team Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Leadership Team',
    'heading' => 'The People Behind ApexCore',
    'description' => 'Meet the experienced leaders driving innovation and excellence at Apex Softwares. Our team combines decades of expertise in financial technology, banking, and software development.',
    'stats' => [
        ['value' => '150+', 'label' => 'Team Members'],
        ['value' => '20+', 'label' => 'Years Combined Experience'],
        ['value' => '8', 'label' => 'Countries Represented'],
        ['value' => '40%', 'label' => 'Women in Leadership']
    ],
    'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200'
]);
?>

<section class="apex-leadership-executive">
    <div class="apex-leadership-executive__container">
        <div class="apex-leadership-executive__header">
            <span class="apex-leadership-executive__badge">Executive Team</span>
            <h2 class="apex-leadership-executive__heading">Executive Leadership</h2>
            <p class="apex-leadership-executive__description">Our executive team brings together visionary leaders with deep expertise in financial services, technology, and business transformation.</p>
        </div>
        
        <div class="apex-leadership-executive__grid">
            <div class="apex-leadership-executive__member">
                <div class="apex-leadership-executive__member-image">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400" alt="John Kamau" loading="lazy">
                </div>
                <div class="apex-leadership-executive__member-info">
                    <h3>John Kamau</h3>
                    <span class="apex-leadership-executive__member-role">Chief Executive Officer</span>
                    <p>John founded Apex Softwares in 2010 with a vision to democratize access to modern banking technology across Africa. With over 25 years of experience in financial services and technology, he has led the company from a small startup to a leading fintech provider serving 100+ institutions.</p>
                    <p>Prior to Apex, John held senior positions at Standard Chartered Bank and Accenture, where he led digital transformation initiatives across East Africa.</p>
                    <div class="apex-leadership-executive__member-social">
                        <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                        <a href="#" aria-label="Twitter"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                    </div>
                </div>
            </div>
            
            <div class="apex-leadership-executive__member">
                <div class="apex-leadership-executive__member-image">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400" alt="Sarah Ochieng" loading="lazy">
                </div>
                <div class="apex-leadership-executive__member-info">
                    <h3>Sarah Ochieng</h3>
                    <span class="apex-leadership-executive__member-role">Chief Technology Officer</span>
                    <p>Sarah leads our technology strategy and product innovation, overseeing a team of 80+ engineers. She is passionate about building scalable, secure systems that empower financial inclusion across Africa.</p>
                    <p>Before joining Apex, Sarah was VP of Engineering at Safaricom, where she led the development of M-Pesa's core platform. She holds a Master's in Computer Science from MIT.</p>
                    <div class="apex-leadership-executive__member-social">
                        <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                        <a href="#" aria-label="Twitter"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg></a>
                    </div>
                </div>
            </div>
            
            <div class="apex-leadership-executive__member">
                <div class="apex-leadership-executive__member-image">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400" alt="Michael Njoroge" loading="lazy">
                </div>
                <div class="apex-leadership-executive__member-info">
                    <h3>Michael Njoroge</h3>
                    <span class="apex-leadership-executive__member-role">Chief Operations Officer</span>
                    <p>Michael ensures operational excellence across all client implementations and internal processes. He has successfully overseen 100+ core banking implementations across 15 African countries.</p>
                    <p>Michael previously served as Director of Operations at Temenos for Sub-Saharan Africa, managing a portfolio of 50+ banking clients.</p>
                    <div class="apex-leadership-executive__member-social">
                        <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                    </div>
                </div>
            </div>
            
            <div class="apex-leadership-executive__member">
                <div class="apex-leadership-executive__member-image">
                    <img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400" alt="Grace Wanjiku" loading="lazy">
                </div>
                <div class="apex-leadership-executive__member-info">
                    <h3>Grace Wanjiku</h3>
                    <span class="apex-leadership-executive__member-role">Chief Financial Officer</span>
                    <p>Grace oversees financial strategy, investor relations, and sustainable growth initiatives. Under her leadership, Apex has achieved profitability while maintaining aggressive investment in R&D.</p>
                    <p>Grace is a CPA with 18 years of experience in financial management. She previously served as CFO at Cellulant and held senior finance roles at Deloitte East Africa.</p>
                    <div class="apex-leadership-executive__member-social">
                        <a href="#" aria-label="LinkedIn"><svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="apex-leadership-senior">
    <div class="apex-leadership-senior__container">
        <div class="apex-leadership-senior__header">
            <h2 class="apex-leadership-senior__heading">Senior Leadership</h2>
            <p class="apex-leadership-senior__description">Our senior leaders drive excellence across every function of the organization.</p>
        </div>
        
        <div class="apex-leadership-senior__grid">
            <div class="apex-leadership-senior__member">
                <img src="https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?w=300" alt="David Mutua" loading="lazy">
                <h4>David Mutua</h4>
                <span>VP, Product Management</span>
            </div>
            <div class="apex-leadership-senior__member">
                <img src="https://images.unsplash.com/photo-1594744803329-e58b31de8bf5?w=300" alt="Amina Hassan" loading="lazy">
                <h4>Amina Hassan</h4>
                <span>VP, Customer Success</span>
            </div>
            <div class="apex-leadership-senior__member">
                <img src="https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?w=300" alt="Peter Otieno" loading="lazy">
                <h4>Peter Otieno</h4>
                <span>VP, Engineering</span>
            </div>
            <div class="apex-leadership-senior__member">
                <img src="https://images.unsplash.com/photo-1573497019940-1c28c88b4f3e?w=300" alt="Faith Mwende" loading="lazy">
                <h4>Faith Mwende</h4>
                <span>VP, Human Resources</span>
            </div>
            <div class="apex-leadership-senior__member">
                <img src="https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=300" alt="James Kariuki" loading="lazy">
                <h4>James Kariuki</h4>
                <span>VP, Sales & Partnerships</span>
            </div>
            <div class="apex-leadership-senior__member">
                <img src="https://images.unsplash.com/photo-1598550874175-4d0ef436c909?w=300" alt="Linda Achieng" loading="lazy">
                <h4>Linda Achieng</h4>
                <span>VP, Marketing</span>
            </div>
            <div class="apex-leadership-senior__member">
                <img src="https://images.unsplash.com/photo-1507591064344-4c6ce005b128?w=300" alt="Samuel Omondi" loading="lazy">
                <h4>Samuel Omondi</h4>
                <span>Director, Security & Compliance</span>
            </div>
            <div class="apex-leadership-senior__member">
                <img src="https://images.unsplash.com/photo-1589156280159-27698a70f29e?w=300" alt="Christine Wairimu" loading="lazy">
                <h4>Christine Wairimu</h4>
                <span>Director, Professional Services</span>
            </div>
        </div>
    </div>
</section>

<section class="apex-leadership-culture">
    <div class="apex-leadership-culture__container">
        <div class="apex-leadership-culture__content">
            <span class="apex-leadership-culture__badge">Our Culture</span>
            <h2 class="apex-leadership-culture__heading">Join Our Team</h2>
            <p class="apex-leadership-culture__description">We're always looking for talented individuals who share our passion for transforming financial services in Africa. At Apex, you'll work on challenging problems, learn from industry experts, and make a real impact.</p>
            
            <div class="apex-leadership-culture__benefits">
                <div class="apex-leadership-culture__benefit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>Competitive compensation & equity</span>
                </div>
                <div class="apex-leadership-culture__benefit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>Flexible remote work options</span>
                </div>
                <div class="apex-leadership-culture__benefit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>Learning & development budget</span>
                </div>
                <div class="apex-leadership-culture__benefit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    <span>Health insurance for you & family</span>
                </div>
            </div>
            
            <a href="<?php echo home_url('/careers'); ?>" class="apex-leadership-culture__cta">
                View Open Positions
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
        
        <div class="apex-leadership-culture__image">
            <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=600" alt="Apex Team" loading="lazy">
        </div>
    </div>
</section>

<?php get_footer(); ?>
