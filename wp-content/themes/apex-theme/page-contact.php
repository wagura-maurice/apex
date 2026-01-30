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
                    
                    <div class="apex-contact-main__form-group">
                        <label class="apex-contact-main__checkbox">
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
                    <div class="apex-contact-main__info-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                    </div>
                    <h3>Follow Us</h3>
                    <p>Stay updated with our latest news</p>
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
            <div class="apex-contact-offices__card apex-contact-offices__card--hq apex-contact-offices__card--active" 
                 data-office="nairobi"
                 data-map-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.819708510148!2d36.80419731475395!3d-1.2641399990638045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f17366e5a8e8b%3A0x1234567890abcdef!2sWestlands%2C%20Nairobi%2C%20Kenya!5e0!3m2!1sen!2ske!4v1706659200000!5m2!1sen!2ske"
                 data-title="Nairobi, Kenya"
                 data-address="Apex Softwares Ltd<br>Westlands Business Park<br>Waiyaki Way, 4th Floor<br>P.O. Box 12345-00100<br>Nairobi, Kenya"
                 data-phone="+254 700 000 000"
                 data-phone-link="+254700000000"
                 data-email="nairobi@apex-softwares.com">
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
                <button type="button" class="apex-contact-offices__card-map">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    View on Map
                </button>
            </div>
            
            <div class="apex-contact-offices__card"
                 data-office="lagos"
                 data-map-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3964.7286407648195!2d3.4226840147632847!3d6.428055295344566!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103bf53aec4dd92d%3A0x5e34fe6b5f6e0a0a!2sVictoria%20Island%2C%20Lagos%2C%20Nigeria!5e0!3m2!1sen!2sng!4v1706659200000!5m2!1sen!2sng"
                 data-title="Lagos, Nigeria"
                 data-address="Apex Softwares Nigeria<br>Victoria Island<br>Adeola Odeku Street<br>Lagos, Nigeria"
                 data-phone="+234 123 456 7890"
                 data-phone-link="+2341234567890"
                 data-email="lagos@apex-softwares.com">
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
                <button type="button" class="apex-contact-offices__card-map">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    View on Map
                </button>
            </div>
            
            <div class="apex-contact-offices__card"
                 data-office="kampala"
                 data-map-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.7573456789012!2d32.58219731475395!3d0.3155030997654321!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x177dbc0f90c1234a%3A0xabcdef1234567890!2sNakasero%2C%20Kampala%2C%20Uganda!5e0!3m2!1sen!2sug!4v1706659200000!5m2!1sen!2sug"
                 data-title="Kampala, Uganda"
                 data-address="Apex Softwares Uganda<br>Nakasero Hill<br>Plot 45, Kampala Road<br>Kampala, Uganda"
                 data-phone="+256 700 000 000"
                 data-phone-link="+256700000000"
                 data-email="kampala@apex-softwares.com">
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
                <button type="button" class="apex-contact-offices__card-map">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    View on Map
                </button>
            </div>
            
            <div class="apex-contact-offices__card"
                 data-office="dar"
                 data-map-src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.234567890123!2d39.28219731475395!3d-6.7923456789012345!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x185c4c1234567890%3A0xfedcba0987654321!2sOyster%20Bay%2C%20Dar%20es%20Salaam%2C%20Tanzania!5e0!3m2!1sen!2stz!4v1706659200000!5m2!1sen!2stz"
                 data-title="Dar es Salaam, Tanzania"
                 data-address="Apex Softwares Tanzania<br>Oyster Bay<br>Haile Selassie Road<br>Dar es Salaam, Tanzania"
                 data-phone="+255 700 000 000"
                 data-phone-link="+255700000000"
                 data-email="dar@apex-softwares.com">
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
                <button type="button" class="apex-contact-offices__card-map">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    View on Map
                </button>
            </div>
        </div>
    </div>
</section>

<section class="apex-contact-map" id="office-map-section">
    <div class="apex-contact-map__container">
        <div class="apex-contact-map__header">
            <span class="apex-contact-map__badge">Find Us</span>
            <h2 class="apex-contact-map__heading" id="map-heading">Nairobi, Kenya</h2>
            <p class="apex-contact-map__description" id="map-description">Visit our headquarters in Nairobi, Kenya</p>
        </div>
        
        <div class="apex-contact-map__embed">
            <iframe 
                id="office-map-iframe"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3988.819708510148!2d36.80419731475395!3d-1.2641399990638045!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f17366e5a8e8b%3A0x1234567890abcdef!2sWestlands%2C%20Nairobi%2C%20Kenya!5e0!3m2!1sen!2ske!4v1706659200000!5m2!1sen!2ske"
                width="100%" 
                height="450" 
                style="border:0; border-radius: 24px;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade"
                title="Apex Softwares Office Location">
            </iframe>
        </div>
        
        <div class="apex-contact-map__info">
            <div class="apex-contact-map__address">
                <h3>Address</h3>
                <address id="map-address">
                    Apex Softwares Ltd<br>
                    Westlands Business Park<br>
                    Waiyaki Way, 4th Floor<br>
                    P.O. Box 12345-00100<br>
                    Nairobi, Kenya
                </address>
            </div>
            <div class="apex-contact-map__contact">
                <h3>Contact</h3>
                <a href="tel:+254700000000" id="map-phone">+254 700 000 000</a>
                <a href="mailto:nairobi@apex-softwares.com" id="map-email">nairobi@apex-softwares.com</a>
            </div>
            <div class="apex-contact-map__hours">
                <h3>Hours</h3>
                <p>Monday - Friday</p>
                <p>8:00 AM - 6:00 PM EAT</p>
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const officeCards = document.querySelectorAll('.apex-contact-offices__card');
    const mapIframe = document.getElementById('office-map-iframe');
    const mapHeading = document.getElementById('map-heading');
    const mapDescription = document.getElementById('map-description');
    const mapAddress = document.getElementById('map-address');
    const mapPhone = document.getElementById('map-phone');
    const mapEmail = document.getElementById('map-email');
    const mapSection = document.getElementById('office-map-section');
    
    officeCards.forEach(card => {
        const mapBtn = card.querySelector('.apex-contact-offices__card-map');
        if (mapBtn) {
            mapBtn.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Remove active class from all cards
                officeCards.forEach(c => c.classList.remove('apex-contact-offices__card--active'));
                // Add active class to clicked card
                card.classList.add('apex-contact-offices__card--active');
                
                // Get data from card
                const mapSrc = card.dataset.mapSrc;
                const title = card.dataset.title;
                const address = card.dataset.address;
                const phone = card.dataset.phone;
                const phoneLink = card.dataset.phoneLink;
                const email = card.dataset.email;
                
                // Update map iframe
                if (mapSrc && mapIframe) {
                    mapIframe.src = mapSrc;
                }
                
                // Update heading and description
                if (mapHeading) mapHeading.textContent = title;
                if (mapDescription) mapDescription.textContent = 'Visit our office in ' + title;
                
                // Update address
                if (mapAddress) mapAddress.innerHTML = address;
                
                // Update contact info
                if (mapPhone) {
                    mapPhone.textContent = phone;
                    mapPhone.href = 'tel:' + phoneLink;
                }
                if (mapEmail) {
                    mapEmail.textContent = email;
                    mapEmail.href = 'mailto:' + email;
                }
                
                // Smooth scroll to map section
                mapSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        }
    });
});
</script>

<?php get_footer(); ?>
