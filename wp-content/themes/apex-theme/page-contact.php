<?php 
/**
 * Template Name: Contact Us
 * Contact Us Page Template
 * 
 * @package ApexTheme
 */

// Get business hours from contact settings (with fallback to footer settings)
$apex_footer_weekday_hours = get_option('apex_offices_weekday_hours_contact', get_option('apex_footer_weekday_hours', '8am - 6pm'));
$apex_footer_saturday_hours = get_option('apex_offices_saturday_hours_contact', get_option('apex_footer_saturday_hours', '8am - 1pm'));
$apex_footer_sunday_holiday_status = get_option('apex_offices_sunday_holiday_status_contact', get_option('apex_footer_sunday_holiday_status', 'Closed'));

// Get dynamic contact information from contact settings (with fallback to footer settings)
$apex_contact_phone = get_option('apex_contact_phone_contact', get_option('apex_footer_phone', '+254 700 000 000'));
$apex_contact_email = get_option('apex_contact_email_main_contact', get_option('apex_footer_email', 'info@apex-softwares.com'));
$apex_contact_sales_email = get_option('apex_contact_email_sales_contact', 'sales@apex-softwares.com');
$apex_contact_address = get_option('apex_footer_address', "Westlands Business Park\n3rd Floor, Suite 305\nWaiyaki Way, Westlands");
$apex_contact_city = get_option('apex_footer_city', 'Nairobi, Kenya');

// Get sidebar items from Contact Information Sidebar settings
$sidebar_items = get_option('apex_contact_sidebar_items_contact', "phone | Call Us | Speak directly with our team | +254 700 000 000 | 8am - 6pm | 8am - 1pm | Closed\nemail | Email Us | We'll respond within 24 hours | info@apex-softwares.com | sales@apex-softwares.com\nhours | Support Hours | 24/7 for critical issues | 8am - 6pm | 8am - 1pm | Closed\nsocial | Follow Us | Stay updated with our latest news | https://linkedin.com | https://twitter.com | https://facebook.com | https://youtube.com");

// Parse sidebar items into array
$sidebar_cards = [];
$lines = explode("\n", $sidebar_items);
foreach ($lines as $line) {
    $line = trim($line);
    if (!empty($line)) {
        $parts = explode('|', $line);
        $parts = array_map('trim', $parts);
        $type = $parts[0] ?? '';
        if (count($parts) >= 4) {
            if ($type === 'phone') {
                // phone | Title | Description | Phone Number | Weekday Hours | Saturday Hours | Sunday & Holiday Status
                $sidebar_cards[] = [
                    'type' => 'phone',
                    'title' => $parts[1] ?? '',
                    'description' => $parts[2] ?? '',
                    'phone' => $parts[3] ?? '',
                    'weekday_hours' => $parts[4] ?? '',
                    'saturday_hours' => $parts[5] ?? '',
                    'sunday_holiday_status' => $parts[6] ?? '',
                ];
            } elseif ($type === 'email') {
                // email | Title | Description | Email 1 | Email 2
                $sidebar_cards[] = [
                    'type' => 'email',
                    'title' => $parts[1] ?? '',
                    'description' => $parts[2] ?? '',
                    'email_1' => $parts[3] ?? '',
                    'email_2' => $parts[4] ?? '',
                ];
            } elseif ($type === 'hours') {
                // hours | Title | Description | Weekday Hours | Saturday Hours | Sunday & Holiday Status
                $sidebar_cards[] = [
                    'type' => 'hours',
                    'title' => $parts[1] ?? '',
                    'description' => $parts[2] ?? '',
                    'weekday_hours' => $parts[3] ?? '',
                    'saturday_hours' => $parts[4] ?? '',
                    'sunday_holiday_status' => $parts[5] ?? '',
                ];
            } elseif ($type === 'social') {
                // social | Title | Description | URL 1 | URL 2 | URL 3 | URL 4
                $sidebar_cards[] = [
                    'type' => 'social',
                    'title' => $parts[1] ?? '',
                    'description' => $parts[2] ?? '',
                    'url_1' => $parts[3] ?? '',
                    'url_2' => $parts[4] ?? '',
                    'url_3' => $parts[5] ?? '',
                    'url_4' => $parts[6] ?? '',
                ];
            }
        }
    }
}

get_header(); 
?>

<?php 
// Debug: Check if we're on contact page
if (isset($_GET['debug'])) {
    echo '<div style="background: yellow; padding: 10px; margin: 10px;">';
    echo 'DEBUG: Contact page loaded<br>';
    echo 'REQUEST_METHOD: ' . $_SERVER['REQUEST_METHOD'] . '<br>';
    echo 'POST data: ' . (isset($_POST['first_name']) ? 'Form submitted' : 'No form data') . '<br>';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        echo 'POST keys: ' . implode(', ', array_keys($_POST)) . '<br>';
    }
    echo '</div>';
}

// Test email functionality
if (isset($_GET['test_email'])) {
    echo '<div style="background: lightblue; padding: 10px; margin: 10px;">';
    echo '<h3>Testing Email Functionality</h3>';
    
    $to = 'info@apex-softwares.com';
    $subject = 'Test Email from Apex Contact Page';
    $message = '<h1>Test Email</h1><p>This is a test email sent from the contact page.</p><p>Time: ' . date('Y-m-d H:i:s') . '</p>';
    $headers = ['Content-Type: text/html; charset=UTF-8'];
    
    $result = wp_mail($to, $subject, $message, $headers);
    
    if ($result) {
        echo '<p style="color: green;">✓ Email sent successfully!</p>';
        echo '<p>Check your Mailtrap inbox for the test email.</p>';
    } else {
        echo '<p style="color: red;">✗ Email sending failed!</p>';
        echo '<p>Please check your Mailtrap configuration and PHP error logs.</p>';
    }
    
    echo '<p><a href="' . home_url('/contact') . '">Back to Contact Form</a></p>';
    echo '</div>';
    get_footer();
    exit;
}
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
                <?php foreach ($sidebar_cards as $card): ?>
                    <?php if ($card['type'] === 'phone'): ?>
                        <div class="apex-contact-main__info-card">
                            <div class="apex-contact-main__info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            </div>
                            <h3><?php echo esc_html($card['title']); ?></h3>
                            <p><?php echo esc_html($card['description']); ?></p>
                            <?php if (!empty($card['phone'])): ?>
                                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $card['phone'])); ?>"><?php echo esc_html($card['phone']); ?></a>
                            <?php endif; ?>
                            <?php if (!empty($card['weekday_hours'])): ?>
                                <div class="apex-contact-main__info-hours-detailed">
                                    <div class="hours-row">
                                        <span class="hours-label">Weekdays:</span>
                                        <span class="hours-time">Mon - Fri <?php echo esc_html($card['weekday_hours']); ?></span>
                                    </div>
                                    <?php if (!empty($card['saturday_hours'])): ?>
                                    <div class="hours-row">
                                        <span class="hours-label">Saturday:</span>
                                        <span class="hours-time"><?php echo esc_html($card['saturday_hours']); ?></span>
                                    </div>
                                    <?php endif; ?>
                                    <?php if (!empty($card['sunday_holiday_status'])): ?>
                                    <div class="hours-row">
                                        <span class="hours-label">Sunday & Holidays:</span>
                                        <span class="hours-time"><?php echo esc_html($card['sunday_holiday_status']); ?></span>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    
                    <?php elseif ($card['type'] === 'email'): ?>
                        <div class="apex-contact-main__info-card">
                            <div class="apex-contact-main__info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                            </div>
                            <h3><?php echo esc_html($card['title']); ?></h3>
                            <p><?php echo esc_html($card['description']); ?></p>
                            <?php if (!empty($card['email_1'])): ?>
                                <a href="mailto:<?php echo esc_attr($card['email_1']); ?>"><?php echo esc_html($card['email_1']); ?></a>
                            <?php endif; ?>
                            <?php if (!empty($card['email_2'])): ?>
                                <a href="mailto:<?php echo esc_attr($card['email_2']); ?>"><?php echo esc_html($card['email_2']); ?></a>
                            <?php endif; ?>
                        </div>
                    
                    <?php elseif ($card['type'] === 'hours'): ?>
                        <div class="apex-contact-main__info-card">
                            <div class="apex-contact-main__info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            </div>
                            <h3><?php echo esc_html($card['title']); ?></h3>
                            <p><?php echo esc_html($card['description']); ?></p>
                            <div class="apex-contact-main__info-hours-detailed">
                                <?php if (!empty($card['weekday_hours'])): ?>
                                <div class="hours-row">
                                    <span class="hours-label">Weekdays:</span>
                                    <span class="hours-time">Mon - Fri <?php echo esc_html($card['weekday_hours']); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($card['saturday_hours'])): ?>
                                <div class="hours-row">
                                    <span class="hours-label">Saturday:</span>
                                    <span class="hours-time"><?php echo esc_html($card['saturday_hours']); ?></span>
                                </div>
                                <?php endif; ?>
                                <?php if (!empty($card['sunday_holiday_status'])): ?>
                                <div class="hours-row">
                                    <span class="hours-label">Sunday & Holidays:</span>
                                    <span class="hours-time"><?php echo esc_html($card['sunday_holiday_status']); ?></span>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    
                    <?php elseif ($card['type'] === 'social'): ?>
                        <?php
                        // Pull social media URLs directly from footer settings
                        $social_linkedin = get_option('apex_footer_linkedin', 'https://linkedin.com');
                        $social_twitter = get_option('apex_footer_twitter', 'https://twitter.com');
                        $social_facebook = get_option('apex_footer_facebook', 'https://facebook.com');
                        $social_instagram = get_option('apex_footer_instagram', 'https://instagram.com');
                        $social_youtube = get_option('apex_footer_youtube', 'https://youtube.com');
                        $social_whatsapp = get_option('apex_footer_whatsapp', 'https://wa.me/');
                        $social_github = get_option('apex_footer_github', 'https://github.com');
                        ?>
                        <div class="apex-contact-main__info-card apex-contact-main__info-card--social">
                            <div class="apex-contact-main__info-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
                            </div>
                            <h3><?php echo esc_html($card['title']); ?></h3>
                            <p><?php echo esc_html($card['description']); ?></p>
                            <div class="apex-contact-main__social-links">
                                <?php if (!empty($social_linkedin)): ?>
                                    <a href="<?php echo esc_url($social_linkedin); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($social_twitter)): ?>
                                    <a href="<?php echo esc_url($social_twitter); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($social_facebook)): ?>
                                    <a href="<?php echo esc_url($social_facebook); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($social_instagram)): ?>
                                    <a href="<?php echo esc_url($social_instagram); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/></svg>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($social_youtube)): ?>
                                    <a href="<?php echo esc_url($social_youtube); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($social_whatsapp)): ?>
                                    <a href="<?php echo esc_url($social_whatsapp); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    </a>
                                <?php endif; ?>
                                <?php if (!empty($social_github)): ?>
                                    <a href="<?php echo esc_url($social_github); ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
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
                 data-address="<?php echo esc_attr(nl2br($apex_contact_address)); ?>"
                 data-phone="<?php echo esc_html($apex_contact_phone); ?>"
                 data-phone-link="<?php echo esc_attr(str_replace(' ', '', $apex_contact_phone)); ?>"
                 data-email="<?php echo esc_html($apex_contact_email); ?>">
                <div class="apex-contact-offices__card-badge">Headquarters</div>
                <h3>Nairobi, Kenya</h3>
                <address>
                    <?php echo nl2br(esc_html($apex_contact_address)); ?>
                </address>
                <div class="apex-contact-offices__card-contact">
                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $apex_contact_phone)); ?>"><?php echo esc_html($apex_contact_phone); ?></a>
                    <a href="mailto:<?php echo esc_attr($apex_contact_email); ?>"><?php echo esc_html($apex_contact_email); ?></a>
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
                    <?php echo nl2br(esc_html($apex_contact_address)); ?>
                </address>
            </div>
            <div class="apex-contact-map__contact">
                <h3>Contact</h3>
                <a href="tel:<?php echo esc_attr(str_replace(' ', '', $apex_contact_phone)); ?>" id="map-phone"><?php echo esc_html($apex_contact_phone); ?></a>
                <a href="mailto:<?php echo esc_attr($apex_contact_email); ?>" id="map-email"><?php echo esc_html($apex_contact_email); ?></a>
            </div>
            <div class="apex-contact-map__hours">
                <h3>Hours</h3>
                <p>Weekdays: Mon - Fri <?php echo esc_html($apex_footer_weekday_hours); ?></p>
                <p>Saturday: <?php echo esc_html($apex_footer_saturday_hours); ?></p>
                <p>Sunday & Holidays: <?php echo esc_html($apex_footer_sunday_holiday_status); ?></p>
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

<style>
.apex-contact-main__info-hours-detailed {
    margin-top: 12px;
    padding-top: 12px;
    border-top: 1px solid rgba(0, 0, 0, 0.1);
}

.hours-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 6px;
    font-size: 14px;
}

.hours-row:last-child {
    margin-bottom: 0;
}

.hours-label {
    font-weight: 600;
    color: #333;
    min-width: 120px;
}

.hours-time {
    color: #666;
    text-align: right;
    flex: 1;
}

@media (max-width: 768px) {
    .hours-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 2px;
    }
    
    .hours-label {
        min-width: auto;
    }
    
    .hours-time {
        text-align: left;
    }
}
</style>

<?php get_footer(); ?>
