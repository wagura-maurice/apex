<?php 
/**
 * Template Name: Contact Us
 * Contact Us Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Get in Touch',
    'heading' => 'Let\'s Start a Conversation',
    'description' => 'Whether you\'re ready to transform your institution or just exploring options, our team is here to help. Reach out and let\'s discuss how Apex Softwares can support your goals.',
    'stats' => [
        ['value' => '24/7', 'label' => 'Support Available'],
        ['value' => '<2hrs', 'label' => 'Response Time'],
        ['value' => '15+', 'label' => 'Countries Served'],
        ['value' => '100+', 'label' => 'Happy Clients']
    ],
    'image' => 'https://images.unsplash.com/photo-1423666639041-f56000c27a9a?w=1200'
]);
?>

<section class="apex-contact-main">
    <div class="apex-contact-main__container">
        <div class="apex-contact-main__grid">
            <!-- Contact Form -->
            <div class="apex-contact-main__form-wrapper">
                <div class="apex-contact-main__form-header">
                    <h2 class="apex-contact-main__form-title">Send Us a Message</h2>
                    <p class="apex-contact-main__form-description">Fill out the form below and we'll get back to you within 24 hours.</p>
                </div>
                
                <form class="apex-contact-main__form" action="#" method="post">
                    <div class="apex-contact-main__form-row">
                        <div class="apex-contact-main__form-group">
                            <label for="contact-first-name">First Name *</label>
                            <input type="text" id="contact-first-name" name="first_name" required placeholder="John">
                        </div>
                        <div class="apex-contact-main__form-group">
                            <label for="contact-last-name">Last Name *</label>
                            <input type="text" id="contact-last-name" name="last_name" required placeholder="Doe">
                        </div>
                    </div>
                    
                    <div class="apex-contact-main__form-row">
                        <div class="apex-contact-main__form-group">
                            <label for="contact-email">Email Address *</label>
                            <input type="email" id="contact-email" name="email" required placeholder="john@company.com">
                        </div>
                        <div class="apex-contact-main__form-group">
                            <label for="contact-phone">Phone Number</label>
                            <input type="tel" id="contact-phone" name="phone" placeholder="+254 700 000 000">
                        </div>
                    </div>
                    
                    <div class="apex-contact-main__form-group">
                        <label for="contact-company">Company / Institution</label>
                        <input type="text" id="contact-company" name="company" placeholder="Your organization name">
                    </div>
                    
                    <div class="apex-contact-main__form-group">
                        <label for="contact-type">Institution Type</label>
                        <select id="contact-type" name="institution_type">
                            <option value="">Select institution type</option>
                            <option value="sacco">SACCO / Credit Union</option>
                            <option value="mfi">Microfinance Institution</option>
                            <option value="bank">Commercial Bank</option>
                            <option value="fintech">Fintech Company</option>
                            <option value="ngo">NGO / Development Organization</option>
                            <option value="government">Government Agency</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="apex-contact-main__form-group">
                        <label for="contact-interest">I'm Interested In</label>
                        <select id="contact-interest" name="interest">
                            <option value="">Select your interest</option>
                            <option value="demo">Requesting a Demo</option>
                            <option value="pricing">Pricing Information</option>
                            <option value="partnership">Partnership Opportunities</option>
                            <option value="support">Technical Support</option>
                            <option value="careers">Career Opportunities</option>
                            <option value="general">General Inquiry</option>
                        </select>
                    </div>
                    
                    <div class="apex-contact-main__form-group">
                        <label for="contact-message">Your Message *</label>
                        <textarea id="contact-message" name="message" rows="5" required placeholder="Tell us about your needs and how we can help..."></textarea>
                    </div>
                    
                    <div class="apex-contact-main__form-consent">
                        <label>
                            <input type="checkbox" name="consent" required>
                            <span>I agree to the <a href="<?php echo home_url('/privacy-policy'); ?>">Privacy Policy</a> and consent to being contacted regarding my inquiry.</span>
                        </label>
                    </div>
                    
                    <button type="submit" class="apex-contact-main__form-submit">
                        Send Message
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                    </button>
                </form>
            </div>
            
            <!-- Contact Info Sidebar -->
            <div class="apex-contact-main__sidebar">
                <div class="apex-contact-main__info-card">
                    <div class="apex-contact-main__info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    </div>
                    <h3>Call Us</h3>
                    <p>Speak directly with our team</p>
                    <a href="tel:+254700000000">+254 700 000 000</a>
                    <span class="apex-contact-main__info-hours">Mon - Fri: 8:00 AM - 6:00 PM EAT</span>
                </div>
                
                <div class="apex-contact-main__info-card">
                    <div class="apex-contact-main__info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                    </div>
                    <h3>Email Us</h3>
                    <p>We'll respond within 24 hours</p>
                    <a href="mailto:info@apex-softwares.com">info@apex-softwares.com</a>
                    <a href="mailto:sales@apex-softwares.com">sales@apex-softwares.com</a>
                </div>
                
                <div class="apex-contact-main__info-card">
                    <div class="apex-contact-main__info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                    </div>
                    <h3>Support Hours</h3>
                    <p>24/7 for critical issues</p>
                    <span>Business Hours: Mon - Fri</span>
                    <span>8:00 AM - 6:00 PM EAT</span>
                </div>
                
                <div class="apex-contact-main__info-card apex-contact-main__info-card--social">
                    <h3>Follow Us</h3>
                    <div class="apex-contact-main__social-links">
                        <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                        </a>
                        <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="apex-contact-offices">
    <div class="apex-contact-offices__container">
        <div class="apex-contact-offices__header">
            <span class="apex-contact-offices__badge">Our Offices</span>
            <h2 class="apex-contact-offices__heading">Visit Us</h2>
            <p class="apex-contact-offices__description">We have offices across Africa to serve you better.</p>
        </div>
        
        <div class="apex-contact-offices__grid">
            <div class="apex-contact-offices__card apex-contact-offices__card--hq">
                <div class="apex-contact-offices__card-badge">Headquarters</div>
                <h3>Nairobi, Kenya</h3>
                <address>
                    Apex Softwares Ltd<br>
                    Westlands Business Park<br>
                    Waiyaki Way, 4th Floor<br>
                    P.O. Box 12345-00100<br>
                    Nairobi, Kenya
                </address>
                <div class="apex-contact-offices__card-contact">
                    <a href="tel:+254700000000">+254 700 000 000</a>
                    <a href="mailto:nairobi@apex-softwares.com">nairobi@apex-softwares.com</a>
                </div>
                <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="apex-contact-offices__card-map">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    View on Map
                </a>
            </div>
            
            <div class="apex-contact-offices__card">
                <h3>Lagos, Nigeria</h3>
                <address>
                    Apex Softwares Nigeria<br>
                    Victoria Island<br>
                    Adeola Odeku Street<br>
                    Lagos, Nigeria
                </address>
                <div class="apex-contact-offices__card-contact">
                    <a href="tel:+2341234567890">+234 123 456 7890</a>
                    <a href="mailto:lagos@apex-softwares.com">lagos@apex-softwares.com</a>
                </div>
                <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="apex-contact-offices__card-map">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    View on Map
                </a>
            </div>
            
            <div class="apex-contact-offices__card">
                <h3>Kampala, Uganda</h3>
                <address>
                    Apex Softwares Uganda<br>
                    Nakasero Hill<br>
                    Plot 45, Kampala Road<br>
                    Kampala, Uganda
                </address>
                <div class="apex-contact-offices__card-contact">
                    <a href="tel:+256700000000">+256 700 000 000</a>
                    <a href="mailto:kampala@apex-softwares.com">kampala@apex-softwares.com</a>
                </div>
                <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="apex-contact-offices__card-map">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    View on Map
                </a>
            </div>
            
            <div class="apex-contact-offices__card">
                <h3>Dar es Salaam, Tanzania</h3>
                <address>
                    Apex Softwares Tanzania<br>
                    Oyster Bay<br>
                    Haile Selassie Road<br>
                    Dar es Salaam, Tanzania
                </address>
                <div class="apex-contact-offices__card-contact">
                    <a href="tel:+255700000000">+255 700 000 000</a>
                    <a href="mailto:dar@apex-softwares.com">dar@apex-softwares.com</a>
                </div>
                <a href="https://maps.google.com" target="_blank" rel="noopener noreferrer" class="apex-contact-offices__card-map">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    View on Map
                </a>
            </div>
        </div>
    </div>
</section>

<section class="apex-contact-faq">
    <div class="apex-contact-faq__container">
        <div class="apex-contact-faq__header">
            <span class="apex-contact-faq__badge">FAQ</span>
            <h2 class="apex-contact-faq__heading">Frequently Asked Questions</h2>
            <p class="apex-contact-faq__description">Quick answers to common questions about working with us.</p>
        </div>
        
        <div class="apex-contact-faq__grid">
            <div class="apex-contact-faq__item">
                <h3>How quickly can you implement a solution?</h3>
                <p>Implementation timelines vary based on the solution and your institution's requirements. A typical core banking implementation takes 3-6 months, while mobile banking can be deployed in 4-8 weeks.</p>
            </div>
            
            <div class="apex-contact-faq__item">
                <h3>Do you offer training and support?</h3>
                <p>Yes! We provide comprehensive training for your team during implementation and ongoing 24/7 technical support. We also offer regular training sessions and documentation.</p>
            </div>
            
            <div class="apex-contact-faq__item">
                <h3>Can you integrate with our existing systems?</h3>
                <p>Absolutely. Our solutions are designed with integration in mind. We support standard APIs and can build custom integrations with your existing core banking, payment, and third-party systems.</p>
            </div>
            
            <div class="apex-contact-faq__item">
                <h3>What is your pricing model?</h3>
                <p>We offer flexible pricing models including licensing, subscription, and transaction-based options. Contact our sales team for a customized quote based on your specific needs.</p>
            </div>
            
            <div class="apex-contact-faq__item">
                <h3>Do you work with small institutions?</h3>
                <p>Yes! We serve institutions of all sizes, from small SACCOs with a few hundred members to large commercial banks. Our modular approach allows you to start small and scale as you grow.</p>
            </div>
            
            <div class="apex-contact-faq__item">
                <h3>What countries do you operate in?</h3>
                <p>We currently serve clients in 15+ African countries including Kenya, Uganda, Tanzania, Nigeria, Ghana, Rwanda, and South Africa. We're continuously expanding our presence.</p>
            </div>
        </div>
    </div>
</section>

<?php 
// CTA Section
apex_render_about_cta([
    'heading' => 'Ready to Get Started?',
    'description' => 'Schedule a demo to see how Apex Softwares can transform your institution.',
    'cta_primary' => [
        'text' => 'Schedule a Demo',
        'url' => home_url('/request-demo')
    ],
    'cta_secondary' => [
        'text' => 'View Solutions',
        'url' => home_url('/solutions/overview')
    ]
]);
?>

<?php get_footer(); ?>
