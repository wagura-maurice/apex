<?php 
/**
 * Template Name: Help & Support
 * Help & Support Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Help & Support',
    'heading' => 'We\'re Here to Help',
    'description' => 'Get the support you need with our comprehensive help resources and dedicated support team available 24/7.',
    'stats' => [
        ['value' => '24/7', 'label' => 'Support Available'],
        ['value' => '<2hrs', 'label' => 'Response Time'],
        ['value' => '99.9%', 'label' => 'Satisfaction'],
        ['value' => '15+', 'label' => 'Countries']
    ],
    'image' => 'https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=1200'
]);
?>

<section class="apex-support-channels">
    <div class="apex-support-channels__container">
        <div class="apex-support-channels__header">
            <h2 class="apex-support-channels__heading">How Can We Help?</h2>
            <p class="apex-support-channels__description">Choose the support channel that works best for you</p>
        </div>
        
        <div class="apex-support-channels__grid">
            <a href="#knowledge-base" class="apex-support-channels__card">
                <div class="apex-support-channels__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <h3>Knowledge Base</h3>
                <p>Find answers in our comprehensive documentation and guides.</p>
                <span class="apex-support-channels__card-link">Browse Articles →</span>
            </a>
            
            <a href="#faq" class="apex-support-channels__card">
                <div class="apex-support-channels__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/></svg>
                </div>
                <h3>FAQ</h3>
                <p>Quick answers to common questions about our products and services.</p>
                <span class="apex-support-channels__card-link">View FAQ →</span>
            </a>
            
            <a href="#contact" class="apex-support-channels__card">
                <div class="apex-support-channels__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <h3>Contact Support</h3>
                <p>Get personalized help from our support team via phone, email, or chat.</p>
                <span class="apex-support-channels__card-link">Contact Us →</span>
            </a>
            
            <a href="#developers" class="apex-support-channels__card">
                <div class="apex-support-channels__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <h3>Developer Resources</h3>
                <p>API documentation, SDKs, and integration guides for developers.</p>
                <span class="apex-support-channels__card-link">Explore APIs →</span>
            </a>
        </div>
    </div>
</section>

<section class="apex-support-contact" id="contact">
    <div class="apex-support-contact__container">
        <div class="apex-support-contact__header">
            <h2 class="apex-support-contact__heading">Contact Our Support Team</h2>
            <p class="apex-support-contact__description">We're here to help you succeed</p>
        </div>
        
        <div class="apex-support-contact__grid">
            <div class="apex-support-contact__item">
                <div class="apex-support-contact__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                </div>
                <h3>Phone Support</h3>
                <p>Speak directly with our support team</p>
                <a href="tel:+254700000000" class="apex-support-contact__link">+254 700 000 000</a>
                <span class="apex-support-contact__hours">24/7 for critical issues</span>
            </div>
            
            <div class="apex-support-contact__item">
                <div class="apex-support-contact__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                </div>
                <h3>Email Support</h3>
                <p>Send us your questions and we'll respond within 2 hours</p>
                <a href="mailto:support@apex-softwares.com" class="apex-support-contact__link">support@apex-softwares.com</a>
                <span class="apex-support-contact__hours">Response time: &lt;2 hours</span>
            </div>
            
            <div class="apex-support-contact__item">
                <div class="apex-support-contact__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"/></svg>
                </div>
                <h3>Live Chat</h3>
                <p>Chat with our support team in real-time</p>
                <button class="apex-support-contact__link">Start Live Chat</button>
                <span class="apex-support-contact__hours">Available 24/7</span>
            </div>
        </div>
    </div>
</section>

<section class="apex-support-resources">
    <div class="apex-support-resources__container">
        <div class="apex-support-resources__header">
            <h2 class="apex-support-resources__heading">Popular Resources</h2>
            <p class="apex-support-resources__description">Quick access to our most helpful resources</p>
        </div>
        
        <div class="apex-support-resources__grid">
            <a href="#" class="apex-support-resources__item">
                <h3>Getting Started Guide</h3>
                <p>Learn the basics of using our platform with our step-by-step guide.</p>
                <span>Read Guide →</span>
            </a>
            <a href="#" class="apex-support-resources__item">
                <h3>Video Tutorials</h3>
                <p>Watch our video tutorials to learn how to use specific features.</p>
                <span>Watch Videos →</span>
            </a>
            <a href="#" class="apex-support-resources__item">
                <h3>System Status</h3>
                <p>Check the current status of all our services and any ongoing incidents.</p>
                <span>Check Status →</span>
            </a>
            <a href="#" class="apex-support-resources__item">
                <h3>Release Notes</h3>
                <p>Stay updated with the latest features and improvements.</p>
                <span>View Updates →</span>
            </a>
        </div>
    </div>
</section>


<?php get_footer(); ?>
