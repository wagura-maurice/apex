</div>
    </main>

    <?php
    $apex_request_demo_href = home_url('/contact');
    
    // Helper function to check if link is active
    function apex_footer_is_active($url) {
        $current_url = home_url($_SERVER['REQUEST_URI']);
        $current_path = parse_url($current_url, PHP_URL_PATH);
        $target_path = parse_url($url, PHP_URL_PATH);
        
        // Exact match
        if ($current_path === $target_path) {
            return true;
        }
        
        // Home page special case
        if ($target_path === '/' && $current_path === '/') {
            return true;
        }
        
        // Check if current path starts with target path (for subpages)
        if ($target_path !== '/' && strpos($current_path, $target_path) === 0) {
            return true;
        }
        
        return false;
    }
    ?>

    <footer class="border-t border-apex-gray-300 bg-gradient-to-br from-apex-gray-100 via-white to-apex-blue/10 relative overflow-hidden apex-gradient-shell">
        <!-- CTA band -->
        <div class="bg-gradient-to-r from-apex-orange via-apex-blue to-apex-purple text-white relative overflow-hidden apex-animated-gradient">
            <div class="absolute -inset-x-32 -top-40 h-64 bg-gradient-to-r from-white/20 via-transparent to-white/20 blur-3xl opacity-80 pointer-events-none"></div>
            <div class="absolute -inset-x-20 top-1/2 h-72 bg-gradient-to-r from-apex-orange/50 via-apex-blue/30 to-apex-purple/40 blur-3xl opacity-50 pointer-events-none"></div>
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex flex-col gap-8 md:flex-row md:items-center md:justify-between">
                    <div class="max-w-2xl">
                        <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-3 text-white drop-shadow-lg">Ready to accelerate your digital transformation?</h2>
                        <p class="text-white/95 text-lg leading-relaxed drop-shadow-md">
                            Talk to our team about <span class="font-bold text-white bg-apex-dark/50 px-2 py-1 rounded-full shadow-lg">ApexCore</span> and the solutions that help you launch faster, scale securely, and serve customers better.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo esc_url($apex_request_demo_href); ?>" class="inline-flex items-center justify-center rounded-full px-8 py-4 text-sm font-bold text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 transition-all duration-300 apex-rainbow-cta shadow-xl hover:shadow-2xl hover:scale-105">
                            Request Demo
                        </a>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="inline-flex items-center justify-center rounded-full px-8 py-4 text-sm font-bold text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60 transition-all duration-300 apex-rainbow-cta shadow-xl hover:shadow-2xl hover:scale-105">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Links -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 relative">
            <div class="pointer-events-none absolute -left-24 top-12 h-40 w-40 rounded-full bg-gradient-to-br from-apex-orange/30 via-apex-blue/20 to-apex-purple/25 blur-3xl opacity-80"></div>
            <div class="pointer-events-none absolute -right-24 bottom-16 h-52 w-52 rounded-full bg-gradient-to-br from-apex-purple/30 via-apex-blue/25 to-apex-orange/20 blur-3xl opacity-90"></div>

            <div class="relative grid gap-12 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <!-- Brand -->
                    <div class="flex items-center gap-4 group">
                        <div class="relative overflow-hidden rounded-2xl shadow-lg border border-apex-gray-200">
                            <img src="https://web.archive.org/web/20220401202046im_/https://apex-softwares.com/wp-content/uploads/2017/08/newlogo3.png" alt="Apex Softwares" class="h-12 w-auto transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-r from-apex-orange/30 via-apex-blue/30 to-apex-purple/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 mix-blend-multiply"></div>
                        </div>
                        <div>
                            <p class="text-lg font-black text-apex-dark group-hover:text-apex-orange transition-colors duration-200 apex-gradient-text">Apex Softwares</p>
                            <p class="text-sm text-apex-gray-600 -mt-0.5">Microfinance &amp; Banking Solutions</p>
                        </div>
                    </div>
                    <p class="mt-6 text-base text-apex-gray-700 leading-relaxed">
                        Our core business delivers comprehensive solutions for financial operations automation, covering retail banking, portfolio management, and deposit accounts. Our solutions offer multiple delivery channels, back office processes, and integrated general ledger functionality.
                    </p>
                </div>

                <div class="lg:col-span-7">
                    <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                        <!-- Static Footer Content -->
                        <div>
                            <p class="text-base font-bold text-apex-dark mb-4 apex-gradient-text">Platform</p>
                            <ul class="space-y-3">
                                <li><a class="relative text-apex-gray-700 hover:text-apex-dark transition-colors duration-200 text-sm font-medium apex-footer-link<?php echo apex_footer_is_active(home_url('/')) ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/')); ?>">Home</a></li>
                                <li><a class="relative text-apex-gray-700 hover:text-apex-dark transition-colors duration-200 text-sm font-medium apex-footer-link<?php echo apex_footer_is_active(home_url('/about')) ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/about')); ?>">About</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <p class="text-base font-bold text-apex-dark mb-4 apex-gradient-text">Solutions</p>
                            <ul class="space-y-3">
                                <li><a class="relative text-apex-gray-700 hover:text-apex-dark transition-colors duration-200 text-sm font-medium apex-footer-link<?php echo apex_footer_is_active(home_url('/services')) ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/services')); ?>">Services</a></li>
                                <li><a class="relative text-apex-gray-700 hover:text-apex-dark transition-colors duration-200 text-sm font-medium apex-footer-link<?php echo apex_footer_is_active(home_url('/products')) ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/products')); ?>">Products</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <p class="text-base font-bold text-apex-dark mb-4 apex-gradient-text">Industry</p>
                            <ul class="space-y-3">
                                <li><a class="relative text-apex-gray-700 hover:text-apex-dark transition-colors duration-200 text-sm font-medium apex-footer-link<?php echo apex_footer_is_active(home_url('/banking')) ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/banking')); ?>">Banking</a></li>
                                <li><a class="relative text-apex-gray-700 hover:text-apex-dark transition-colors duration-200 text-sm font-medium apex-footer-link<?php echo apex_footer_is_active(home_url('/finance')) ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/finance')); ?>">Finance</a></li>
                            </ul>
                        </div>
                        
                        <div>
                            <p class="text-base font-bold text-apex-dark mb-4 apex-gradient-text">Company</p>
                            <ul class="space-y-3">
                                <li><a class="relative text-apex-gray-700 hover:text-apex-dark transition-colors duration-200 text-sm font-medium apex-footer-link<?php echo apex_footer_is_active(home_url('/contact')) ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/contact')); ?>">Contact</a></li>
                                <li><a class="relative text-apex-gray-700 hover:text-apex-dark transition-colors duration-200 text-sm font-medium apex-footer-link<?php echo apex_footer_is_active(home_url('/blog')) ? ' active' : ''; ?>" href="<?php echo esc_url(home_url('/blog')); ?>">Blog</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Newsletter and Social Media Section - Full Width Below -->
            <div class="relative mt-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 w-full">
                    <!-- Newsletter Section -->
                    <div class="rounded-3xl border border-apex-gray-200 bg-white/90 backdrop-blur-xl p-6 shadow-xl h-full flex flex-col">
                        <p class="text-base font-bold text-apex-dark mb-2 apex-gradient-text">Get updates</p>
                        <p class="text-sm text-apex-gray-600">Industry insights, product updates, and events.</p>
                        <form class="mt-4 flex flex-col gap-3 sm:flex-row" action="#" method="post">
                            <label class="sr-only" for="apex-newsletter-email">Email</label>
                            <input id="apex-newsletter-email" name="email" type="email" placeholder="you@company.com" class="flex-1 rounded-2xl border border-apex-gray-300 bg-white px-3 py-2 text-sm focus:border-apex-orange focus:ring-2 focus:ring-apex-orange/30 transition-all duration-200 shadow-sm" />
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-bold text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/60 transition-all duration-200 apex-rainbow-cta shadow-lg">
                                Subscribe
                            </button>
                        </form>
                        <p class="mt-auto pt-3 text-xs text-apex-gray-500">By subscribing you agree to our <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="privacy-link text-apex-gray-500 hover:text-apex-dark <?php if (is_page('privacy-policy') || get_the_ID() == get_option('wp_page_for_privacy_policy')) echo 'font-bold text-apex-orange bg-apex-orange/10 px-2 py-1 rounded-full'; ?>">Privacy Policy</a>.</p>
                    </div>

                    <!-- Social Media Section -->
                    <div class="rounded-3xl border border-apex-gray-200 bg-white/90 backdrop-blur-xl p-6 shadow-xl h-full flex flex-col">
                        <p class="text-base font-bold text-apex-dark mb-4 apex-gradient-text">Follow us</p>
                        <p class="text-sm text-apex-gray-600">Stay connected with us on social media.</p>
                        <div class="grid grid-cols-3 gap-2 mt-auto">
                            <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" class="social-icon flex items-center justify-center py-2 px-3 rounded-lg bg-apex-gray-50 hover:bg-apex-orange text-apex-gray-600 hover:text-white transition-colors duration-200">
                                <i class="fab fa-facebook-f text-xs"></i>
                            </a>
                            <a href="https://twitter.com" target="_blank" rel="noopener noreferrer" class="social-icon flex items-center justify-center py-2 px-3 rounded-lg bg-apex-gray-50 hover:bg-apex-orange text-apex-gray-600 hover:text-white transition-colors duration-200">
                                <i class="fab fa-x-twitter text-xs"></i>
                            </a>
                            <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" class="social-icon flex items-center justify-center py-2 px-3 rounded-lg bg-apex-gray-50 hover:bg-apex-orange text-apex-gray-600 hover:text-white transition-colors duration-200">
                                <i class="fab fa-instagram text-xs"></i>
                            </a>
                            <a href="https://wa.me/" target="_blank" rel="noopener noreferrer" class="social-icon flex items-center justify-center py-2 px-3 rounded-lg bg-apex-gray-50 hover:bg-apex-orange text-apex-gray-600 hover:text-white transition-colors duration-200">
                                <i class="fab fa-whatsapp text-xs"></i>
                            </a>
                            <a href="https://linkedin.com" target="_blank" rel="noopener noreferrer" class="social-icon flex items-center justify-center py-2 px-3 rounded-lg bg-apex-gray-50 hover:bg-apex-orange text-apex-gray-600 hover:text-white transition-colors duration-200">
                                <i class="fab fa-linkedin-in text-xs"></i>
                            </a>
                            <a href="https://youtube.com" target="_blank" rel="noopener noreferrer" class="social-icon flex items-center justify-center py-2 px-3 rounded-lg bg-apex-gray-50 hover:bg-apex-orange text-apex-gray-600 hover:text-white transition-colors duration-200">
                                <i class="fab fa-youtube text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-16 flex flex-col gap-4 border-t border-apex-gray-300 pt-8 text-sm text-apex-gray-600 sm:flex-row sm:items-center sm:justify-between">
                <p class="font-medium text-apex-gray-800">&copy; <?php echo esc_html(date('Y')); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'container' => 'div',
                        'container_class' => 'flex items-center gap-6',
                        'items_wrap' => '%3$s',
                        'depth' => 1,
                        'fallback_cb' => false
                    ));
                    ?>
                </div>
                <p class="text-xs text-apex-gray-500">Built for performance, accessibility, and scale.</p>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>