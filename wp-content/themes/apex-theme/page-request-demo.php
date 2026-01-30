<?php 
/**
 * Template Name: Request Demo
 * Request Demo Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Request Demo',
    'heading' => 'See Our Platform in Action',
    'description' => 'Schedule a personalized demo of our fintech solutions and discover how we can help transform your financial institution.',
    'stats' => [
        ['value' => '500+', 'label' => 'Demos Scheduled'],
        ['value' => '98%', 'label' => 'Satisfaction'],
        ['value' => '7 Days', 'label' => 'Avg. Implementation'],
        ['value' => '24/7', 'label' => 'Support']
    ],
    'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=1200'
]);
?>

<section class="apex-request-demo">
    <div class="apex-request-demo__container">
        <div class="apex-request-demo__content">
            <div class="apex-request-demo__header">
                <h2 class="apex-request-demo__heading">Request Your Personalized Demo</h2>
                <p class="apex-request-demo__description">Fill out the form below and our team will contact you within 24 hours to schedule your demo.</p>
            </div>
            
            <form class="apex-request-demo__form" action="#" method="POST">
                <div class="apex-request-demo__form-group">
                    <label for="first_name">First Name *</label>
                    <input type="text" id="first_name" name="first_name" required placeholder="John">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="last_name">Last Name *</label>
                    <input type="text" id="last_name" name="last_name" required placeholder="Doe">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="email">Work Email *</label>
                    <input type="email" id="email" name="email" required placeholder="john@company.com">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="phone">Phone Number *</label>
                    <input type="tel" id="phone" name="phone" required placeholder="+254 700 000 000">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="company">Company Name *</label>
                    <input type="text" id="company" name="company" required placeholder="Your Company">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="job_title">Job Title *</label>
                    <input type="text" id="job_title" name="job_title" required placeholder="CEO, IT Manager, etc.">
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="institution_type">Institution Type *</label>
                    <select id="institution_type" name="institution_type" required>
                        <option value="">Select your institution type</option>
                        <option value="mfi">Microfinance Institution (MFI)</option>
                        <option value="sacco">SACCO / Credit Union</option>
                        <option value="bank">Commercial Bank</option>
                        <option value="government">Government Agency</option>
                        <option value="ngo">NGO / Development Organization</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="country">Country *</label>
                    <select id="country" name="country" required>
                        <option value="">Select your country</option>
                        <option value="ke">Kenya</option>
                        <option value="ug">Uganda</option>
                        <option value="tz">Tanzania</option>
                        <option value="ng">Nigeria</option>
                        <option value="gh">Ghana</option>
                        <option value="rw">Rwanda</option>
                        <option value="za">South Africa</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="solutions">Solutions of Interest *</label>
                    <div class="apex-request-demo__checkboxes">
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="core-banking">
                            <span>Core Banking & Microfinance</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="mobile-wallet">
                            <span>Mobile Wallet App</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="agency-banking">
                            <span>Agency & Branch Banking</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="internet-banking">
                            <span>Internet & Mobile Banking</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="loan-origination">
                            <span>Loan Origination & Workflows</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="digital-field-agent">
                            <span>Digital Field Agent</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="enterprise-integration">
                            <span>Enterprise Integration</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="payment-switch">
                            <span>Payment Switch & General Ledger</span>
                        </label>
                        <label class="apex-request-demo__checkbox">
                            <input type="checkbox" name="solutions[]" value="reporting-analytics">
                            <span>Reporting & Analytics</span>
                        </label>
                    </div>
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="message">Tell us about your needs</label>
                    <textarea id="message" name="message" rows="4" placeholder="Describe your current challenges and what you're looking for..."></textarea>
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label for="attachment">Attach Relevant Documents (Optional)</label>
                    <input type="file" id="attachment" name="attachment" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx">
                    <span class="apex-request-demo__form-hint">PDF, Word, Excel, PowerPoint files up to 10MB</span>
                </div>
                
                <div class="apex-request-demo__form-group">
                    <label class="apex-request-demo__checkbox">
                        <input type="checkbox" name="privacy" required>
                        <span>I agree to the <a href="<?php echo home_url('/privacy-policy'); ?>">Privacy Policy</a> and consent to being contacted.</span>
                    </label>
                </div>
                
                <button type="submit" class="apex-request-demo__submit">
                    <span>Request Demo</span>
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </button>
            </form>
        </div>
        
        <div class="apex-request-demo__sidebar">
            <div class="apex-request-demo__info">
                <h3>What to Expect</h3>
                <ul>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 8v4l3 3m6-3a9 9 0 1 1-18 0 9 9 0 0 1 18 0z"/></svg>
                        <span>30-45 minute personalized demo</span>
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        <span>Dedicated product expert</span>
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                        <span>Customized to your needs</span>
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                        <span>Q&A and discussion</span>
                    </li>
                    <li>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        <span>Pricing and licensing information</span>
                    </li>
                </ul>
            </div>
            
            <div class="apex-request-demo__contact">
                <h3>Need Help?</h3>
                <p>Our team is ready to assist you.</p>
                <a href="tel:+254700000000" class="apex-request-demo__contact-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                    +254 700 000 000
                </a>
                <a href="mailto:sales@apex-softwares.com" class="apex-request-demo__contact-link">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                    sales@apex-softwares.com
                </a>
            </div>
            
            <div class="apex-request-demo__downloads">
                <h3>Training Materials</h3>
                <p>Download our product presentations and documentation.</p>
                <div class="apex-request-demo__downloads-list">
                    <a href="#" class="apex-request-demo__download-item">
                        <div class="apex-request-demo__download-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                        </div>
                        <div class="apex-request-demo__download-content">
                            <h4>Product Overview Presentation</h4>
                            <span>PDF • 2.5 MB</span>
                        </div>
                    </a>
                    <a href="#" class="apex-request-demo__download-item">
                        <div class="apex-request-demo__download-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect x="8" y="2" width="8" height="4" rx="1" ry="1"/></svg>
                        </div>
                        <div class="apex-request-demo__download-content">
                            <h4>Technical Documentation</h4>
                            <span>PDF • 5.1 MB</span>
                        </div>
                    </a>
                    <a href="#" class="apex-request-demo__download-item">
                        <div class="apex-request-demo__download-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                        </div>
                        <div class="apex-request-demo__download-content">
                            <h4>Implementation Guide</h4>
                            <span>PDF • 3.8 MB</span>
                        </div>
                    </a>
                    <a href="#" class="apex-request-demo__download-item">
                        <div class="apex-request-demo__download-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <div class="apex-request-demo__download-content">
                            <h4>Pricing & Licensing</h4>
                            <span>PDF • 1.2 MB</span>
                        </div>
                    </a>
                </div>
            </div>
            
            <div class="apex-request-demo__webinars">
                <h3>Upcoming Webinars</h3>
                <p>Join our live demo sessions and Q&A.</p>
                <div class="apex-request-demo__webinars-list">
                    <div class="apex-request-demo__webinar">
                        <div class="apex-request-demo__webinar-date">
                            <span class="apex-request-demo__webinar-day">15</span>
                            <span class="apex-request-demo__webinar-month">Feb</span>
                        </div>
                        <div class="apex-request-demo__webinar-content">
                            <h4>Core Banking Demo</h4>
                            <span>10:00 AM EAT</span>
                            <a href="#" class="apex-request-demo__webinar-cta">Register →</a>
                        </div>
                    </div>
                    <div class="apex-request-demo__webinar">
                        <div class="apex-request-demo__webinar-date">
                            <span class="apex-request-demo__webinar-day">22</span>
                            <span class="apex-request-demo__webinar-month">Feb</span>
                        </div>
                        <div class="apex-request-demo__webinar-content">
                            <h4>Mobile Banking Demo</h4>
                            <span>2:00 PM EAT</span>
                            <a href="#" class="apex-request-demo__webinar-cta">Register →</a>
                        </div>
                    </div>
                    <div class="apex-request-demo__webinar">
                        <div class="apex-request-demo__webinar-date">
                            <span class="apex-request-demo__webinar-day">01</span>
                            <span class="apex-request-demo__webinar-month">Mar</span>
                        </div>
                        <div class="apex-request-demo__webinar-content">
                            <h4>Agent Banking Demo</h4>
                            <span>10:00 AM EAT</span>
                            <a href="#" class="apex-request-demo__webinar-cta">Register →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
