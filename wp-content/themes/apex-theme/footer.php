<?php 
    // Check if this is a full-width page (about-us, insights, contact, industry, or support pages - NOT front page)
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    $is_full_width_inner_page = strpos($request_uri, 'about-us') === 0 || 
                                 strpos($request_uri, 'insights') === 0 ||
                                 strpos($request_uri, 'contact') === 0 ||
                                 strpos($request_uri, 'industry') === 0 ||
                                 strpos($request_uri, 'careers') === 0 ||
                                 strpos($request_uri, 'help-support') === 0 ||
                                 strpos($request_uri, 'faq') === 0 ||
                                 strpos($request_uri, 'knowledge-base') === 0 ||
                                 strpos($request_uri, 'developers') === 0 ||
                                 strpos($request_uri, 'partners') === 0 ||
                                 strpos($request_uri, 'request-demo') === 0 ||
                                 strpos($request_uri, 'privacy-policy') === 0 ||
                                 strpos($request_uri, 'terms-and-conditions') === 0 ||
                                 strpos($request_uri, 'solutions') === 0;
    ?>
    <?php if (is_front_page()) : ?>
        <!-- Front page has no main wrapper to close -->
    <?php elseif ($is_full_width_inner_page) : ?>
    </main>
    <?php else : ?>
</div>
    </main>
    <?php endif; ?>

    <?php
    // Get dynamic footer settings
    $apex_footer_cta1_title = get_option('apex_footer_cta1_title', 'Ready to Transform Your Institution?');
    $apex_footer_cta1_description = get_option('apex_footer_cta1_description', 'Get in touch to discuss a tailored banking or fintech strategy for your business.');
    $apex_footer_cta1_button_text = get_option('apex_footer_cta1_button_text', 'Request a Demo');
    $apex_footer_cta1_button_url = get_option('apex_footer_cta1_button_url', '/contact');
    $apex_footer_cta2_title = get_option('apex_footer_cta2_title', 'Need Support?');
    $apex_footer_cta2_description = get_option('apex_footer_cta2_description', 'For existing customers, access our knowledge base and expert support team.');
    $apex_footer_cta2_button_text = get_option('apex_footer_cta2_button_text', 'Get Support');
    $apex_footer_cta2_button_url = get_option('apex_footer_cta2_button_url', '/contact');
    
    $apex_footer_logo_url = get_option('apex_footer_logo_url', 'https://web.archive.org/web/20220401202046im_/https://apex-softwares.com/wp-content/uploads/2017/08/newlogo3.png');
    $apex_footer_company_name = get_option('apex_footer_company_name', 'Apex Softwares');
    $apex_footer_tagline = get_option('apex_footer_tagline', 'Microfinance & Banking Solutions');
    $apex_footer_description = get_option('apex_footer_description', 'Comprehensive solutions for financial operations automation, covering retail banking, portfolio management, and deposit accounts across Africa.');
    
    $apex_footer_email = get_option('apex_footer_email', 'info@apex-softwares.com');
    $apex_footer_phone = get_option('apex_footer_phone', '+254 700 000 000');
    $apex_footer_city = get_option('apex_footer_city', 'Nairobi, Kenya');
    $apex_footer_address = get_option('apex_footer_address', "Westlands Business Park\n3rd Floor, Suite 305\nWaiyaki Way, Westlands");
    
    // Business Hours
    $apex_footer_weekday_hours = get_option('apex_footer_weekday_hours', '8am - 6pm');
    $apex_footer_saturday_hours = get_option('apex_footer_saturday_hours', '8am - 1pm');
    $apex_footer_sunday_holiday_status = get_option('apex_footer_sunday_holiday_status', 'Closed');
    
    $apex_footer_hours = get_option('apex_footer_hours', 'Mon - Fri: 8:00 AM - 6:00 PM');
    
    $apex_footer_linkedin = get_option('apex_footer_linkedin', 'https://linkedin.com');
    $apex_footer_twitter = get_option('apex_footer_twitter', 'https://twitter.com');
    $apex_footer_facebook = get_option('apex_footer_facebook', 'https://facebook.com');
    $apex_footer_instagram = get_option('apex_footer_instagram', 'https://instagram.com');
    $apex_footer_youtube = get_option('apex_footer_youtube', 'https://youtube.com');
    $apex_footer_whatsapp = get_option('apex_footer_whatsapp', 'https://wa.me/');
    $apex_footer_github = get_option('apex_footer_github', 'https://github.com');
    
    $apex_footer_google_play = get_option('apex_footer_google_play', 'https://play.google.com');
    $apex_footer_app_store = get_option('apex_footer_app_store', 'https://apps.apple.com');
    
    $apex_footer_copyright_text = get_option('apex_footer_copyright_text', 'All rights reserved.');
    $apex_footer_certification_image = get_option('apex_footer_certification_image', 'https://www.continualengine.com/wp-content/uploads/2025/01/information-security-management-system-iso-27001_1-transformed.png');
    $apex_footer_certification_alt = get_option('apex_footer_certification_alt', 'ISO 27001 Certified');
    $apex_footer_credit_text = get_option('apex_footer_credit_text', 'Built for performance, accessibility, and scale with');
    $apex_footer_credit_link_text = get_option('apex_footer_credit_link_text', 'Wagura Maurice');
    $apex_footer_credit_link_url = get_option('apex_footer_credit_link_url', 'https://waguramaurice.com');
    
    // Convert relative URLs to absolute
    if (strpos($apex_footer_cta1_button_url, '/') === 0) {
        $apex_footer_cta1_button_url = home_url($apex_footer_cta1_button_url);
    }
    if (strpos($apex_footer_cta2_button_url, '/') === 0) {
        $apex_footer_cta2_button_url = home_url($apex_footer_cta2_button_url);
    }
    
    $apex_request_demo_href = home_url('/contact');
    
    // Helper function to check if a link is active
    function apex_is_footer_link_active($link_path) {
        $current_uri = trim($_SERVER['REQUEST_URI'], '/');
        $current_uri = strtok($current_uri, '?');
        $link_path = trim($link_path, '/');
        return $current_uri === $link_path ? 'active' : '';
    }
    ?>

    <footer class="apex-footer">
        <!-- Pre-Footer CTA Section -->
        <section class="apex-footer-cta">
            <div class="apex-footer-cta__container">
                <div class="apex-footer-cta__grid">
                    <!-- Card 1 - Request Demo -->
                    <div class="apex-footer-cta__card apex-footer-cta__card--primary">
                        <div class="apex-footer-cta__card-content">
                            <h3 class="apex-footer-cta__title"><?php echo esc_html($apex_footer_cta1_title); ?></h3>
                            <p class="apex-footer-cta__description"><?php echo esc_html($apex_footer_cta1_description); ?></p>
                            <a href="<?php echo esc_url($apex_footer_cta1_button_url); ?>" class="apex-footer-cta__btn apex-footer-cta__btn--white">
                                <?php echo esc_html($apex_footer_cta1_button_text); ?>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                        <div class="apex-footer-cta__card-decoration"></div>
                    </div>
                    
                    <!-- Card 2 - Support -->
                    <div class="apex-footer-cta__card apex-footer-cta__card--secondary">
                        <div class="apex-footer-cta__card-content">
                            <h3 class="apex-footer-cta__title"><?php echo esc_html($apex_footer_cta2_title); ?></h3>
                            <p class="apex-footer-cta__description"><?php echo esc_html($apex_footer_cta2_description); ?></p>
                            <a href="<?php echo esc_url($apex_footer_cta2_button_url); ?>" class="apex-footer-cta__btn apex-footer-cta__btn--outline">
                                <?php echo esc_html($apex_footer_cta2_button_text); ?>
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                        <div class="apex-footer-cta__card-decoration"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main Footer -->
        <div class="apex-footer-main">
            <div class="apex-footer-main__container">
                <div class="apex-footer-main__grid">
                    <!-- Brand Column -->
                    <div class="apex-footer-main__brand">
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="apex-footer-main__logo group">
                            <div class="apex-footer-main__logo-img-wrapper">
                                <img src="<?php echo esc_url($apex_footer_logo_url); ?>" alt="<?php echo esc_attr($apex_footer_company_name); ?>">
                                <div class="apex-footer-main__logo-overlay"></div>
                            </div>
                            <div class="apex-footer-main__logo-text">
                                <span class="apex-footer-main__logo-name"><?php echo esc_html($apex_footer_company_name); ?></span>
                                <span class="apex-footer-main__logo-tagline"><?php echo esc_html($apex_footer_tagline); ?></span>
                            </div>
                        </a>
                        
                        <p class="apex-footer-main__description">
                            <?php echo esc_html($apex_footer_description); ?>
                        </p>
                        
                        <!-- Newsletter -->
                        <div class="apex-footer-main__newsletter">
                            <h4>Stay Updated</h4>
                            <p>Get the latest insights and product updates.</p>
                            
                            <!-- Notification Area -->
                            <div id="newsletter-notification" class="apex-footer-main__newsletter-notification" style="display: none;">
                                <div class="notification-content">
                                    <span class="notification-icon"></span>
                                    <span class="notification-message"></span>
                                    <button type="button" class="notification-close" onclick="hideNewsletterNotification()">×</button>
                                </div>
                            </div>
                            
                            <form class="apex-footer-main__newsletter-form" action="#" method="post" id="newsletter-form">
                                <?php wp_nonce_field('apex_newsletter_form', 'apex_newsletter_nonce'); ?>
                                <input type="email" name="email" placeholder="Enter your email" required id="newsletter-email">
                                <button type="submit" id="newsletter-submit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Social Links -->
                        <div class="apex-footer-main__social">
                            <a href="<?php echo esc_url($apex_footer_linkedin); ?>" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                            </a>
                            <a href="<?php echo esc_url($apex_footer_twitter); ?>" target="_blank" rel="noopener noreferrer" aria-label="Twitter">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                            </a>
                            <a href="<?php echo esc_url($apex_footer_facebook); ?>" target="_blank" rel="noopener noreferrer" aria-label="Facebook">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                            <a href="<?php echo esc_url($apex_footer_instagram); ?>" target="_blank" rel="noopener noreferrer" aria-label="Instagram">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/></svg>
                            </a>
                            <a href="<?php echo esc_url($apex_footer_youtube); ?>" target="_blank" rel="noopener noreferrer" aria-label="YouTube">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                            </a>
                            <a href="<?php echo esc_url($apex_footer_whatsapp); ?>" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                            <a href="<?php echo esc_url($apex_footer_github); ?>" target="_blank" rel="noopener noreferrer" aria-label="GitHub">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.745.083-.729.083-.729 1.205.084 1.839 1.237 1.839 1.237 1.07 1.834 2.807 1.304 3.492.997.107-.775.418-1.305.762-1.604-2.665-.305-5.467-1.334-5.467-5.931 0-1.311.469-2.381 1.236-3.221-.124-.303-.535-1.524.117-3.176 0 0 1.008-.322 3.301 1.23.957-.266 1.983-.399 3.003-.404 1.02.005 2.047.138 3.006.404 2.291-1.552 3.297-1.23 3.297-1.23.653 1.653.242 2.874.118 3.176.77.84 1.235 1.911 1.235 3.221 0 4.609-2.807 5.624-5.479 5.921.43.372.823 1.102.823 2.222v3.293c0 .319.192.694.801.576 4.765-1.589 8.199-6.086 8.199-11.386 0-6.627-5.373-12-12-12z"/></svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Links Columns -->
                    <div class="apex-footer-main__links">
                        <!-- Solutions -->
                        <div class="apex-footer-main__links-column">
                            <h4>Solutions</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/solutions/overview')); ?>" class="<?php echo apex_is_footer_link_active('/solutions/overview'); ?>">Overview</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/core-banking-microfinance')); ?>" class="<?php echo apex_is_footer_link_active('/solutions/core-banking-microfinance'); ?>">Core Banking & Microfinance</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/mobile-wallet-app')); ?>" class="<?php echo apex_is_footer_link_active('/solutions/mobile-wallet-app'); ?>">Mobile Wallet App</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/agency-branch-banking')); ?>" class="<?php echo apex_is_footer_link_active('/solutions/agency-branch-banking'); ?>">Agency & Branch Banking</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/internet-mobile-banking')); ?>" class="<?php echo apex_is_footer_link_active('/solutions/internet-mobile-banking'); ?>">Internet & Mobile Banking</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/loan-origination-workflows')); ?>" class="<?php echo apex_is_footer_link_active('/solutions/loan-origination-workflows'); ?>">Loan Origination & Workflows</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/digital-field-agent')); ?>" class="<?php echo apex_is_footer_link_active('/solutions/digital-field-agent'); ?>">Digital Field Agent</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/enterprise-integration')); ?>" class="<?php echo apex_is_footer_link_active('/solutions/enterprise-integration'); ?>">Enterprise Integration</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/payment-switch-ledger')); ?>" class="<?php echo apex_is_footer_link_active('/solutions/payment-switch-ledger'); ?>">Payment Switch & General Ledger</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/reporting-analytics')); ?>" class="<?php echo apex_is_footer_link_active('/solutions/reporting-analytics'); ?>">Reporting & Analytics</a></li>
                            </ul>
                        </div>
                        
                        <!-- Industry -->
                        <div class="apex-footer-main__links-column">
                            <h4>Industry</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/industry/overview')); ?>" class="<?php echo apex_is_footer_link_active('/industry/overview'); ?>">Overview</a></li>
                                <li><a href="<?php echo esc_url(home_url('/industry/mfis')); ?>" class="<?php echo apex_is_footer_link_active('/industry/mfis'); ?>">Microfinance (MFIs)</a></li>
                                <li><a href="<?php echo esc_url(home_url('/industry/credit-unions')); ?>" class="<?php echo apex_is_footer_link_active('/industry/credit-unions'); ?>">SACCOs & Credit Unions</a></li>
                                <li><a href="<?php echo esc_url(home_url('/industry/banks-microfinance')); ?>" class="<?php echo apex_is_footer_link_active('/industry/banks-microfinance'); ?>">Commercial Banks</a></li>
                                <li><a href="<?php echo esc_url(home_url('/industry/digital-government')); ?>" class="<?php echo apex_is_footer_link_active('/industry/digital-government'); ?>">Digital Government</a></li>
                            </ul>
                            
                            <h4 class="apex-footer-main__links-subtitle">Support</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/careers')); ?>" class="<?php echo apex_is_footer_link_active('/careers'); ?>">Careers</a></li>
                                <li><a href="<?php echo esc_url(home_url('/help-support')); ?>" class="<?php echo apex_is_footer_link_active('/help-support'); ?>">Help & Support</a></li>
                                <li><a href="<?php echo esc_url(home_url('/faq')); ?>" class="<?php echo apex_is_footer_link_active('/faq'); ?>">FAQ</a></li>
                                <li><a href="<?php echo esc_url(home_url('/knowledge-base')); ?>" class="<?php echo apex_is_footer_link_active('/knowledge-base'); ?>">Knowledge Base</a></li>
                                <li><a href="<?php echo esc_url(home_url('/developers')); ?>" class="<?php echo apex_is_footer_link_active('/developers'); ?>">Developers</a></li>
                                <li><a href="<?php echo esc_url(home_url('/partners')); ?>" class="<?php echo apex_is_footer_link_active('/partners'); ?>">Partners</a></li>
                            </ul>
                        </div>
                        
                        <!-- Company -->
                        <div class="apex-footer-main__links-column">
                            <h4>Company</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/about-us/overview')); ?>" class="<?php echo apex_is_footer_link_active('/about-us/overview'); ?>">About Us</a></li>
                                <li><a href="<?php echo esc_url(home_url('/about-us/our-approach')); ?>" class="<?php echo apex_is_footer_link_active('/about-us/our-approach'); ?>">Our Approach</a></li>
                                <li><a href="<?php echo esc_url(home_url('/about-us/leadership-team')); ?>" class="<?php echo apex_is_footer_link_active('/about-us/leadership-team'); ?>">Leadership</a></li>
                                <li><a href="<?php echo esc_url(home_url('/about-us/news')); ?>" class="<?php echo apex_is_footer_link_active('/about-us/news'); ?>">News & Updates</a></li>
                                <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="<?php echo apex_is_footer_link_active('/contact'); ?>">Contact Us</a></li>
                            </ul>
                            
                            <h4 class="apex-footer-main__links-subtitle">Insights</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/insights/blog')); ?>" class="<?php echo apex_is_footer_link_active('/insights/blog'); ?>">Blog</a></li>
                                <li><a href="<?php echo esc_url(home_url('/insights/success-stories')); ?>" class="<?php echo apex_is_footer_link_active('/insights/success-stories'); ?>">Success Stories</a></li>
                                <li><a href="<?php echo esc_url(home_url('/insights/webinars')); ?>" class="<?php echo apex_is_footer_link_active('/insights/webinars'); ?>">Webinars & Events</a></li>
                                <li><a href="<?php echo esc_url(home_url('/insights/whitepapers-reports')); ?>" class="<?php echo apex_is_footer_link_active('/insights/whitepapers-reports'); ?>">Whitepapers</a></li>
                            </ul>
                            
                            <h4 class="apex-footer-main__links-subtitle">Legal</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="<?php echo apex_is_footer_link_active('/privacy-policy'); ?>">Privacy Policy</a></li>
                                <li><a href="<?php echo esc_url(home_url('/terms-and-conditions')); ?>" class="<?php echo apex_is_footer_link_active('/terms-and-conditions'); ?>">Terms of Service</a></li>
                            </ul>
                        </div>
                        
                        <!-- Contact & Apps -->
                        <div class="apex-footer-main__links-column">
                            <h4>Contact</h4>
                            <div class="apex-footer-main__contact">
                                <div class="apex-footer-main__contact-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                                    <a href="mailto:<?php echo esc_attr($apex_footer_email); ?>"><?php echo esc_html($apex_footer_email); ?></a>
                                </div>
                                <div class="apex-footer-main__contact-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <a href="tel:<?php echo esc_attr(str_replace(' ', '', $apex_footer_phone)); ?>"><?php echo esc_html($apex_footer_phone); ?></a>
                                </div>
                                <div class="apex-footer-main__contact-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span><?php echo esc_html($apex_footer_city); ?></span>
                                </div>
                                <div class="apex-footer-main__contact-item apex-footer-main__contact-address">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                    <span><?php echo nl2br(esc_html($apex_footer_address)); ?></span>
                                </div>
                                <div class="apex-footer-main__contact-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                    <span>Weekdays: Mon - Fri <?php echo esc_html($apex_footer_weekday_hours); ?><br>Weekends: Sat <?php echo esc_html($apex_footer_saturday_hours); ?><br>Sunday & Holidays: <?php echo esc_html($apex_footer_sunday_holiday_status); ?></span>
                                </div>
                            </div>
                            
                            <h4 class="apex-footer-main__links-subtitle">Get Our App</h4>
                            <div class="apex-footer-main__apps">
                                <a href="<?php echo esc_url($apex_footer_google_play); ?>" target="_blank" rel="noopener noreferrer">
                                    <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Get it on Google Play">
                                </a>
                                <a href="<?php echo esc_url($apex_footer_app_store); ?>" target="_blank" rel="noopener noreferrer">
                                    <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="Download on App Store">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="apex-footer-bottom">
            <div class="apex-footer-bottom__container">
                <p class="apex-footer-bottom__copyright">
                    Copyright &copy; <?php echo esc_html(date('Y')); ?> <span class="apex-footer-bottom__company-name"><?php bloginfo('name'); ?></span>. <?php echo esc_html($apex_footer_copyright_text); ?>
                </p>
                <div class="apex-footer-bottom__certifications">
                    <img src="<?php echo esc_url($apex_footer_certification_image); ?>" alt="<?php echo esc_attr($apex_footer_certification_alt); ?>" title="<?php echo esc_attr($apex_footer_certification_alt); ?>">
                </div>
                <p class="apex-footer-bottom__credit">
                    <?php echo esc_html($apex_footer_credit_text); ?> <i class="fab fa-wordpress"></i> by <a href="<?php echo esc_url($apex_footer_credit_link_url); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html($apex_footer_credit_link_text); ?></a>
                </p>
            </div>
        </div>
    </footer>
</div>

<!-- Newsletter Notification Styles -->
<style>
.apex-footer-main__newsletter-notification {
    margin-bottom: 15px;
    border-radius: 8px;
    overflow: hidden;
    animation: slideDown 0.3s ease-out;
}

.apex-footer-main__newsletter-notification.success {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
}

.apex-footer-main__newsletter-notification.error {
    background: linear-gradient(135deg, #dc3545 0%, #e74c3c 100%);
    color: white;
}

.apex-footer-main__newsletter-notification .notification-content {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    gap: 10px;
}

.apex-footer-main__newsletter-notification .notification-icon {
    font-size: 18px;
    flex-shrink: 0;
}

.apex-footer-main__newsletter-notification.success .notification-icon::before {
    content: "✓";
    font-weight: bold;
}

.apex-footer-main__newsletter-notification.error .notification-icon::before {
    content: "✕";
    font-weight: bold;
}

.apex-footer-main__newsletter-notification .notification-message {
    flex: 1;
    font-size: 14px;
    font-weight: 500;
}

.apex-footer-main__newsletter-notification .notification-close {
    background: rgba(255, 255, 255, 0.2);
    border: none;
    color: white;
    width: 24px;
    height: 24px;
    border-radius: 50%;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background-color 0.2s;
    flex-shrink: 0;
}

.apex-footer-main__newsletter-notification .notification-close:hover {
    background: rgba(255, 255, 255, 0.3);
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
        max-height: 0;
    }
    to {
        opacity: 1;
        transform: translateY(0);
        max-height: 100px;
    }
}

.apex-footer-main__newsletter-form.loading button {
    opacity: 0.7;
    pointer-events: none;
}

.apex-footer-main__newsletter-form.loading button svg {
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

<!-- Newsletter Notification JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const newsletterForm = document.getElementById('newsletter-form');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const email = document.getElementById('newsletter-email').value;
            const submitBtn = document.getElementById('newsletter-submit');
            
            // Show loading state
            newsletterForm.classList.add('loading');
            
            // Create form data
            const formData = new FormData();
            formData.append('email', email);
            formData.append('action', 'apex_newsletter_submit');
            
            // Get nonce from the form
            const nonceField = newsletterForm.querySelector('input[name="apex_newsletter_nonce"]');
            if (nonceField) {
                formData.append('apex_newsletter_nonce', nonceField.value);
            }
            
            // Send AJAX request
            fetch('<?php echo admin_url('admin-ajax.php'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                newsletterForm.classList.remove('loading');
                
                if (data.success) {
                    showNewsletterNotification('success', data.data.message);
                    newsletterForm.reset();
                } else {
                    showNewsletterNotification('error', data.data.message || 'An error occurred. Please try again.');
                }
            })
            .catch(error => {
                newsletterForm.classList.remove('loading');
                showNewsletterNotification('error', 'An error occurred. Please try again.');
                console.error('Newsletter submission error:', error);
            });
        });
    }
    
    // Check for URL parameters and show notifications
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('newsletter_success') === '1') {
        showNewsletterNotification('success', 'Thank you for subscribing! Check your email for confirmation.');
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
    } else if (urlParams.get('newsletter_error')) {
        const errorType = urlParams.get('newsletter_error');
        let errorMessage = 'An error occurred. Please try again.';
        
        switch(errorType) {
            case 'missing_email':
                errorMessage = 'Please enter your email address.';
                break;
            case 'invalid_email':
                errorMessage = 'Please enter a valid email address.';
                break;
            case 'send_failed':
                errorMessage = 'Failed to subscribe. Please try again later.';
                break;
        }
        
        showNewsletterNotification('error', errorMessage);
        // Clean URL
        window.history.replaceState({}, document.title, window.location.pathname);
    }
});

function showNewsletterNotification(type, message) {
    const notification = document.getElementById('newsletter-notification');
    const icon = notification.querySelector('.notification-icon');
    const messageElement = notification.querySelector('.notification-message');
    
    // Remove existing classes
    notification.classList.remove('success', 'error');
    
    // Add new class and set message
    notification.classList.add(type);
    messageElement.textContent = message;
    
    // Show notification
    notification.style.display = 'block';
    
    // Auto-hide after 5 seconds for success messages
    if (type === 'success') {
        setTimeout(hideNewsletterNotification, 5000);
    }
}

function hideNewsletterNotification() {
    const notification = document.getElementById('newsletter-notification');
    notification.style.display = 'none';
}
</script>

<?php wp_footer(); ?>
</body>
</html>