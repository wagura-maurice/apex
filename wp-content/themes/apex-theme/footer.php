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
                                 strpos($request_uri, 'terms-conditions') === 0 ||
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
    $apex_request_demo_href = home_url('/contact');
    ?>

    <footer class="apex-footer">
        <!-- Pre-Footer CTA Section -->
        <section class="apex-footer-cta">
            <div class="apex-footer-cta__container">
                <div class="apex-footer-cta__grid">
                    <!-- Card 1 - Request Demo -->
                    <div class="apex-footer-cta__card apex-footer-cta__card--primary">
                        <div class="apex-footer-cta__card-content">
                            <h3 class="apex-footer-cta__title">Ready to Transform Your Institution?</h3>
                            <p class="apex-footer-cta__description">Get in touch to discuss a tailored banking or fintech strategy for your business.</p>
                            <a href="<?php echo esc_url($apex_request_demo_href); ?>" class="apex-footer-cta__btn apex-footer-cta__btn--white">
                                Request a Demo
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </a>
                        </div>
                        <div class="apex-footer-cta__card-decoration"></div>
                    </div>
                    
                    <!-- Card 2 - Support -->
                    <div class="apex-footer-cta__card apex-footer-cta__card--secondary">
                        <div class="apex-footer-cta__card-content">
                            <h3 class="apex-footer-cta__title">Need Support?</h3>
                            <p class="apex-footer-cta__description">For existing customers, access our knowledge base and expert support team.</p>
                            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="apex-footer-cta__btn apex-footer-cta__btn--outline">
                                Get Support
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
                                <img src="https://web.archive.org/web/20220401202046im_/https://apex-softwares.com/wp-content/uploads/2017/08/newlogo3.png" alt="Apex Softwares">
                                <div class="apex-footer-main__logo-overlay"></div>
                            </div>
                            <div class="apex-footer-main__logo-text">
                                <span class="apex-footer-main__logo-name">Apex Softwares</span>
                                <span class="apex-footer-main__logo-tagline">Microfinance &amp; Banking Solutions</span>
                            </div>
                        </a>
                        
                        <p class="apex-footer-main__description">
                            Comprehensive solutions for financial operations automation, covering retail banking, portfolio management, and deposit accounts across Africa.
                        </p>
                        
                        <!-- Newsletter -->
                        <div class="apex-footer-main__newsletter">
                            <h4>Stay Updated</h4>
                            <p>Get the latest insights and product updates.</p>
                            <form class="apex-footer-main__newsletter-form" action="#" method="post">
                                <input type="email" name="email" placeholder="Enter your email" required>
                                <button type="submit">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Social Links -->
                        <div class="apex-footer-main__social">
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
                            <a href="https://wa.me/" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Links Columns -->
                    <div class="apex-footer-main__links">
                        <!-- Solutions -->
                        <div class="apex-footer-main__links-column">
                            <h4>Solutions</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/solutions/overview')); ?>">Overview</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/core-banking-microfinance')); ?>">Core Banking & Microfinance</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/mobile-wallet-app')); ?>">Mobile Wallet App</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/agency-branch-banking')); ?>">Agency & Branch Banking</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/internet-mobile-banking')); ?>">Internet & Mobile Banking</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/loan-origination-workflows')); ?>">Loan Origination & Workflows</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/digital-field-agent')); ?>">Digital Field Agent</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/enterprise-integration')); ?>">Enterprise Integration</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/payment-switch-ledger')); ?>">Payment Switch & General Ledger</a></li>
                                <li><a href="<?php echo esc_url(home_url('/solutions/reporting-analytics')); ?>">Reporting & Analytics</a></li>
                            </ul>
                        </div>
                        
                        <!-- Industry -->
                        <div class="apex-footer-main__links-column">
                            <h4>Industry</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/industry/overview')); ?>">Overview</a></li>
                                <li><a href="<?php echo esc_url(home_url('/industry/mfis')); ?>">Microfinance (MFIs)</a></li>
                                <li><a href="<?php echo esc_url(home_url('/industry/credit-unions')); ?>">SACCOs & Credit Unions</a></li>
                                <li><a href="<?php echo esc_url(home_url('/industry/banks-microfinance')); ?>">Commercial Banks</a></li>
                                <li><a href="<?php echo esc_url(home_url('/industry/digital-government')); ?>">Digital Government</a></li>
                            </ul>
                            
                            <h4 class="apex-footer-main__links-subtitle">Insights</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/insights/blog')); ?>">Blog</a></li>
                                <li><a href="<?php echo esc_url(home_url('/insights/success-stories')); ?>">Success Stories</a></li>
                                <li><a href="<?php echo esc_url(home_url('/insights/webinars')); ?>">Webinars & Events</a></li>
                                <li><a href="<?php echo esc_url(home_url('/insights/whitepapers-reports')); ?>">Whitepapers</a></li>
                            </ul>
                        </div>
                        
                        <!-- Company -->
                        <div class="apex-footer-main__links-column">
                            <h4>Company</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/about-us/overview')); ?>">About Us</a></li>
                                <li><a href="<?php echo esc_url(home_url('/about-us/our-approach')); ?>">Our Approach</a></li>
                                <li><a href="<?php echo esc_url(home_url('/about-us/leadership-team')); ?>">Leadership</a></li>
                                <li><a href="<?php echo esc_url(home_url('/about-us/news')); ?>">News & Updates</a></li>
                                <li><a href="<?php echo esc_url(home_url('/contact')); ?>">Contact Us</a></li>
                            </ul>
                            
                            <h4 class="apex-footer-main__links-subtitle">Legal</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a></li>
                                <li><a href="<?php echo esc_url(home_url('/terms-conditions')); ?>">Terms of Service</a></li>
                            </ul>
                            
                            <h4 class="apex-footer-main__links-subtitle">Support</h4>
                            <ul>
                                <li><a href="<?php echo esc_url(home_url('/careers')); ?>">Careers</a></li>
                                <li><a href="<?php echo esc_url(home_url('/help-support')); ?>">Help & Support</a></li>
                                <li><a href="<?php echo esc_url(home_url('/faq')); ?>">FAQ</a></li>
                                <li><a href="<?php echo esc_url(home_url('/knowledge-base')); ?>">Knowledge Base</a></li>
                                <li><a href="<?php echo esc_url(home_url('/developers')); ?>">Developers</a></li>
                                <li><a href="<?php echo esc_url(home_url('/partners')); ?>">Partners</a></li>
                            </ul>
                        </div>
                        
                        <!-- Contact & Apps -->
                        <div class="apex-footer-main__links-column">
                            <h4>Contact</h4>
                            <div class="apex-footer-main__contact">
                                <div class="apex-footer-main__contact-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><path d="M22 6l-10 7L2 6"/></svg>
                                    <a href="mailto:info@apex-softwares.com">info@apex-softwares.com</a>
                                </div>
                                <div class="apex-footer-main__contact-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    <a href="tel:+254700000000">+254 700 000 000</a>
                                </div>
                                <div class="apex-footer-main__contact-item">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    <span>Nairobi, Kenya</span>
                                </div>
                            </div>
                            
                            <h4 class="apex-footer-main__links-subtitle">Get Our App</h4>
                            <div class="apex-footer-main__apps">
                                <a href="https://play.google.com" target="_blank" rel="noopener noreferrer">
                                    <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" alt="Get it on Google Play">
                                </a>
                                <a href="https://apps.apple.com" target="_blank" rel="noopener noreferrer">
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
                    Copyright &copy; <?php echo esc_html(date('Y')); ?> <span class="apex-footer-bottom__company-name"><?php bloginfo('name'); ?></span>. All rights reserved.
                </p>
                <div class="apex-footer-bottom__certifications">
                    <img src="https://www.continualengine.com/wp-content/uploads/2025/01/information-security-management-system-iso-27001_1-transformed.png" alt="ISO 27001 Certified" title="ISO 27001 Certified">
                </div>
                <p class="apex-footer-bottom__credit">
                    Built for performance, accessibility, and scale with <i class="fab fa-wordpress"></i> by <a href="https://waguramaurice.com" target="_blank" rel="noopener noreferrer">Wagura Maurice</a>
                </p>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>