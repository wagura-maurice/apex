<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class('bg-white text-apex-dark font-sans antialiased'); ?>>
<?php wp_body_open(); ?>

<?php
$apex_request_demo_href = home_url('/request-demo');
?>

<div class="min-h-screen flex flex-col">
    <!-- Sticky Header -->
    <header id="apex-main-header" class="sticky top-0 z-50 transition-all duration-500 py-2 px-4 bg-gradient-to-r from-[#0f172a] via-[#1e3a5f] to-[#0f172a]">
        <div class="apex-header-inner mx-auto max-w-7xl px-2 sm:px-6 lg:px-8 py-2 bg-white rounded-2xl transition-all duration-500 shadow-xl border border-white/20">
            <div class="apex-header-surface">
                <div class="flex h-16 items-center justify-between gap-2">
                <!-- Brand -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-2 group transition-transform duration-300 hover:scale-105 flex-shrink min-w-0 overflow-hidden">
                    <div class="relative overflow-hidden rounded-xl shadow-md flex-shrink-0">
                        <img src="https://web.archive.org/web/20220401202046im_/https://apex-softwares.com/wp-content/uploads/2017/08/newlogo3.png" alt="Apex Softwares" class="h-10 w-auto transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-r from-apex-orange/30 via-apex-blue/30 to-apex-purple/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 mix-blend-multiply"></div>
                    </div>
                    <span class="leading-tight min-w-0 overflow-hidden">
                        <span class="block text-sm sm:text-lg font-black text-apex-dark group-hover:text-apex-orange transition-colors duration-200 truncate">Apex Softwares</span>
                        <span class="block text-xs sm:text-sm text-apex-gray-500 -mt-0.5 truncate">Microfinance &amp; Banking Solutions</span>
                    </span>
                </a>

                <!-- Desktop nav -->
                <nav class="hidden lg:flex items-center gap-1 text-sm font-medium text-apex-gray-700" aria-label="Primary">
                    <?php
                    // WordPress menu implementation following learningWordPress methodology
                    $args = array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'items_wrap' => '%3$s', // Remove ul wrapper, just output the li's
                        'depth' => 2,
                        'fallback_cb' => 'apex_default_nav'
                    );
                    wp_nav_menu($args);
                    
                    // Default navigation fallback if no menu is set
                    function apex_default_nav() {
                        $apex_nav = [
                            ['label' => 'Home', 'href' => home_url('/')],
                            [
                                'label' => 'About Us',
                                'type'  => 'dropdown',
                                'items' => [
                                    ['label' => 'About Apex Softwares', 'href' => home_url('/about-us/overview')],
                                    ['label' => 'Our Approach', 'href' => home_url('/about-us/our-approach')],
                                    ['label' => 'Leadership Team', 'href' => home_url('/about-us/leadership-team')],
                                    ['label' => 'News & Updates', 'href' => home_url('/about-us/news')],
                                ],
                            ],
                            [
                                'label' => 'Solutions',
                                'type'  => 'mega',
                                'items' => [
                                    ['label' => 'Overview', 'href' => home_url('/solutions/overview')],
                                    ['label' => 'Core Banking & Microfinance', 'href' => home_url('/solutions/core-banking-microfinance')],
                                    ['label' => 'Mobile Wallet App', 'href' => home_url('/solutions/mobile-wallet-app')],
                                    ['label' => 'Agency & Branch Banking', 'href' => home_url('/solutions/agency-branch-banking')],
                                    ['label' => 'Internet & Mobile Banking', 'href' => home_url('/solutions/internet-mobile-banking')],
                                    ['label' => 'Loan Origination & Workflows', 'href' => home_url('/solutions/loan-origination-workflows')],
                                    ['label' => 'Digital Field Agent', 'href' => home_url('/solutions/digital-field-agent')],
                                    ['label' => 'Enterprise Integration', 'href' => home_url('/solutions/enterprise-integration')],
                                    ['label' => 'Payment Switch & General Ledger', 'href' => home_url('/solutions/payment-switch-ledger')],
                                    ['label' => 'Reporting & Analytics', 'href' => home_url('/solutions/reporting-analytics')],
                                ],
                            ],
                            [
                                'label' => 'Industry',
                                'type'  => 'dropdown',
                                'items' => [
                                    ['label' => 'Overview', 'href' => home_url('/industry/overview')],
                                    ['label' => 'Microfinance Institutions (MFIs)', 'href' => home_url('/industry/mfis')],
                                    ['label' => 'SACCOs & Credit Unions', 'href' => home_url('/industry/credit-unions')],
                                    ['label' => 'Commercial Banks', 'href' => home_url('/industry/banks-microfinance')],
                                    ['label' => 'Digital Government & NGOs', 'href' => home_url('/industry/digital-government')],
                                ],
                            ],
                            [
                                'label' => 'Insights',
                                'type'  => 'dropdown',
                                'items' => [
                                    ['label' => 'Blog', 'href' => home_url('/insights/blog')],
                                    ['label' => 'Success Stories', 'href' => home_url('/insights/success-stories')],
                                    ['label' => 'Webinars & Events', 'href' => home_url('/insights/webinars')],
                                    ['label' => 'Whitepapers & Reports', 'href' => home_url('/insights/whitepapers-reports')],
                                ],
                            ],
                            ['label' => 'Contact Us', 'href' => home_url('/contact')],
                        ];

                        foreach ($apex_nav as $item) {
                            if (empty($item['type'])) {
                                echo '<a href="' . esc_url($item['href']) . '" class="relative rounded-lg px-4 py-2 hover:bg-apex-gray-100/70 hover:text-apex-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-200 group apex-nav-link">';
                                echo esc_html($item['label']);
                                echo '<span class="apex-nav-underline absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-apex-orange to-sky-500 transform -translate-x-1/2 transition-all duration-300"></span>';
                                echo '</a>';
                            } elseif ($item['type'] === 'dropdown') {
                                echo '<div class="relative apex-nav-item" data-nav="dropdown">';
                                echo '<button type="button" class="apex-nav-trigger rounded-lg px-4 py-2 hover:bg-apex-gray-100/70 hover:text-apex-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-200 apex-nav-link relative" aria-expanded="false">';
                                echo '<span class="inline-flex items-center gap-1 relative z-10">';
                                echo esc_html($item['label']);
                                echo '<span class="text-apex-gray-400 transition-transform duration-200 group-hover:rotate-180">▾</span>';
                                echo '</span>';
                                echo '<span class="apex-nav-underline absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-apex-orange to-sky-500 transform -translate-x-1/2 transition-all duration-300"></span>';
                                echo '</button>';
                                echo '<div class="apex-nav-panel invisible opacity-0 translate-y-2 pointer-events-none absolute left-0 mt-3 w-80 rounded-xl border border-apex-gray-200 bg-white shadow-2xl transition-all duration-300">';
                                echo '<div class="p-3">';
                                foreach ($item['items'] as $sub) {
                                    echo '<a class="block rounded-lg px-4 py-3 text-sm text-apex-gray-600 hover:bg-orange-50 hover:text-orange-600 transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-400/40" href="' . esc_url($sub['href']) . '">';
                                    echo esc_html($sub['label']);
                                    echo '</a>';
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            } else { /* mega */
                                echo '<div class="relative apex-nav-item" data-nav="mega">';
                                echo '<button type="button" class="apex-nav-trigger rounded-lg px-4 py-2 hover:bg-apex-gray-100/70 hover:text-apex-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-200 apex-nav-link relative" aria-expanded="false">';
                                echo '<span class="inline-flex items-center gap-1 relative z-10">';
                                echo esc_html($item['label']);
                                echo '<span class="text-apex-gray-400 transition-transform duration-200 group-hover:rotate-180">▾</span>';
                                echo '</span>';
                                echo '<span class="apex-nav-underline absolute bottom-0 left-1/2 w-0 h-0.5 bg-gradient-to-r from-apex-orange to-sky-500 transform -translate-x-1/2 transition-all duration-300"></span>';
                                echo '</button>';
                                echo '<div class="apex-nav-panel invisible opacity-0 pointer-events-none rounded-2xl border border-apex-gray-200 bg-white shadow-2xl transition-opacity duration-300" data-type="mega">';
                                echo '<div class="grid gap-6 p-6 lg:grid-cols-12">';
                                echo '<div class="lg:col-span-4">';
                                echo '<p class="text-xs font-bold uppercase tracking-wider text-orange-500">Solutions</p>';
                                echo '<p class="mt-3 text-sm text-apex-gray-600 leading-relaxed">';
                                echo 'Modular capabilities built around <span class="font-bold text-apex-dark">ApexCore</span> to digitize onboarding, lending, channels, and integrations.';
                                echo '</p>';
                                echo '<a href="' . esc_url(home_url('/solutions/overview')) . '" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-orange-500 hover:text-orange-600 transition-colors duration-200">';
                                echo 'Explore all solutions <span aria-hidden="true" class="transition-transform duration-200 group-hover:translate-x-1">→</span>';
                                echo '</a>';
                                echo '</div>';
                                echo '<div class="lg:col-span-8">';
                                echo '<div class="grid gap-3 sm:grid-cols-2">';
                                foreach ($item['items'] as $sub) {
                                    echo '<a class="group rounded-xl border border-slate-100 p-5 hover:border-orange-300 hover:bg-gradient-to-br hover:from-orange-50/50 hover:to-sky-50/30 hover:shadow-md transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-orange-400/40 min-h-[100px]" href="' . esc_url($sub['href']) . '">';
                                    echo '<div class="text-sm font-semibold text-slate-700 group-hover:text-orange-500 transition-colors duration-200">';
                                    echo esc_html($sub['label']);
                                    echo '</div>';
                                    echo '<div class="mt-2 text-xs text-apex-gray-500 leading-relaxed">';
                                    echo 'Learn more about this capability.';
                                    echo '</div>';
                                    echo '</a>';
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    }
                    ?>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-3 flex-shrink-0">
                    <a href="<?php echo esc_url($apex_request_demo_href); ?>" class="hidden sm:inline-flex items-center justify-center rounded-full px-6 py-3 text-base font-bold text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/60 transition-all duration-200 apex-rainbow-cta shadow-md hover:shadow-lg transform hover:scale-105">
                        Request Demo
                    </a>
                    <button type="button" id="mobile-menu-btn" class="lg:hidden inline-flex items-center justify-center rounded-full border border-apex-gray-200/60 bg-white/80 px-3 py-2 text-sm font-semibold text-apex-gray-700 hover:bg-apex-gray-900 hover:text-white hover:border-transparent focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-300 shadow-sm apex-mobile-toggle" data-mobile-menu-toggle aria-expanded="false" aria-controls="apex-mobile-menu">
                        <!-- Hamburger icon -->
                        <svg id="hamburger-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <!-- Close X icon (hidden by default) -->
                        <svg id="close-icon" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Mobile menu - OUTSIDE header to avoid clipping -->
    <?php
    // Get current URL path for active state detection
    $current_url = $_SERVER['REQUEST_URI'];
    $current_path = trim(parse_url($current_url, PHP_URL_PATH) ?: '', '/');
    
    // Debug disabled
    // echo "<div style='position:fixed;bottom:0;left:0;background:red;color:white;padding:5px;z-index:99999;font-size:12px;'>PATH: $current_path</div>";
    
    // Active classes
    $active_link = 'bg-orange-100 text-orange-600 font-semibold border-l-4 border-orange-500';
    $inactive_link = 'text-slate-600 hover:bg-orange-50 hover:text-orange-500';
    
    // Check which sections are active (for parent highlighting)
    $is_home_active = is_front_page() || empty($current_path);
    $is_about_active = strpos($current_path, 'about') !== false;
    $is_solutions_active = strpos($current_path, 'solutions') !== false;
    $is_industry_active = strpos($current_path, 'industry') !== false;
    $is_contact_active = strpos($current_path, 'contact') !== false;
    ?>
    <div id="apex-mobile-menu" class="lg:hidden hidden fixed top-24 left-4 right-4 z-[9999] rounded-2xl shadow-2xl border border-gray-200 bg-white max-h-[75vh] overflow-y-auto" style="display: none;">
        <div class="px-4 py-6">
            <div class="grid gap-3">
                <!-- Home -->
                <a class="rounded-lg px-4 py-3 text-sm font-bold transition-all duration-200 <?php echo $is_home_active ? 'bg-orange-50 text-orange-500 border-l-4 border-orange-500' : 'text-slate-700 hover:bg-orange-50 hover:text-orange-500'; ?>" href="<?php echo esc_url(home_url('/')); ?>">Home</a>

                <!-- About Us -->
                <div class="rounded-xl border <?php echo $is_about_active ? 'border-orange-200' : 'border-gray-200'; ?> overflow-hidden">
                    <button type="button" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold transition-all duration-200 <?php echo $is_about_active ? 'text-orange-500' : 'text-slate-700 hover:bg-orange-50'; ?>" data-mobile-accordion aria-expanded="<?php echo $is_about_active ? 'true' : 'false'; ?>">
                        About Us <span class="text-slate-400 transition-transform duration-200">▾</span>
                    </button>
                    <div class="<?php echo $is_about_active ? '' : 'hidden'; ?> px-3 pb-3" data-mobile-panel>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'about-us') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/about-us')); ?>">About Apex Softwares</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'about-us/our-approach') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/about-us/our-approach')); ?>">Our Approach</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'about-us/leadership-team') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/about-us/leadership-team')); ?>">Leadership Team</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'about-us/news') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/about-us/news')); ?>">News & Updates</a>
                    </div>
                </div>

                <!-- Solutions -->
                <div class="rounded-xl border <?php echo $is_solutions_active ? 'border-orange-200' : 'border-gray-200'; ?> overflow-hidden">
                    <button type="button" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold transition-all duration-200 <?php echo $is_solutions_active ? 'text-orange-500' : 'text-slate-700 hover:bg-orange-50'; ?>" data-mobile-accordion aria-expanded="<?php echo $is_solutions_active ? 'true' : 'false'; ?>">
                        Solutions <span class="text-slate-400 transition-transform duration-200">▾</span>
                    </button>
                    <div class="<?php echo $is_solutions_active ? '' : 'hidden'; ?> px-3 pb-3" data-mobile-panel>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'solutions/overview') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/solutions/overview')); ?>">Overview</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'solutions/core-banking-microfinance') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/solutions/core-banking-microfinance')); ?>">Core Banking & Microfinance</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'solutions/mobile-wallet-app') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/solutions/mobile-wallet-app')); ?>">Mobile Wallet App</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'solutions/agency-branch-banking') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/solutions/agency-branch-banking')); ?>">Agency & Branch Banking</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'solutions/internet-mobile-banking') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/solutions/internet-mobile-banking')); ?>">Internet & Mobile Banking</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'solutions/loan-origination-workflows') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/solutions/loan-origination-workflows')); ?>">Loan Origination & Workflows</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'solutions/digital-field-agent') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/solutions/digital-field-agent')); ?>">Digital Field Agent</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'solutions/enterprise-integration') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/solutions/enterprise-integration')); ?>">Enterprise Integration</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'solutions/payment-switch-ledger') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/solutions/payment-switch-ledger')); ?>">Payment Switch & General Ledger</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'solutions/reporting-analytics') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/solutions/reporting-analytics')); ?>">Reporting & Analytics</a>
                    </div>
                </div>

                <!-- Industry -->
                <div class="rounded-xl border <?php echo $is_industry_active ? 'border-orange-200' : 'border-gray-200'; ?> overflow-hidden">
                    <button type="button" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold transition-all duration-200 <?php echo $is_industry_active ? 'text-orange-500' : 'text-slate-700 hover:bg-orange-50'; ?>" data-mobile-accordion aria-expanded="<?php echo $is_industry_active ? 'true' : 'false'; ?>">
                        Industry <span class="text-slate-400 transition-transform duration-200">▾</span>
                    </button>
                    <div class="<?php echo $is_industry_active ? '' : 'hidden'; ?> px-3 pb-3" data-mobile-panel>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'industry/overview') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/industry/overview')); ?>">Overview</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'industry/mfis') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/industry/mfis')); ?>">Microfinance Institutions</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'industry/credit-unions') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/industry/credit-unions')); ?>">SACCOs & Credit Unions</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'industry/banks-microfinance') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/industry/banks-microfinance')); ?>">Commercial Banks</a>
                    </div>
                </div>

                <!-- Insights -->
                <?php $is_insights_active = strpos($current_path, 'insights') !== false; ?>
                <div class="rounded-xl border <?php echo $is_insights_active ? 'border-orange-200' : 'border-gray-200'; ?> overflow-hidden">
                    <button type="button" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold transition-all duration-200 <?php echo $is_insights_active ? 'text-orange-500' : 'text-slate-700 hover:bg-orange-50'; ?>" data-mobile-accordion aria-expanded="<?php echo $is_insights_active ? 'true' : 'false'; ?>">
                        Insights <span class="text-slate-400 transition-transform duration-200">▾</span>
                    </button>
                    <div class="<?php echo $is_insights_active ? '' : 'hidden'; ?> px-3 pb-3" data-mobile-panel>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'insights/blog') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/insights/blog')); ?>">Blog</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'insights/success-stories') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/insights/success-stories')); ?>">Success Stories</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'insights/webinars') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/insights/webinars')); ?>">Webinars & Events</a>
                        <a class="block rounded-lg px-3 py-2 text-sm transition-all duration-200 <?php echo ($current_path === 'insights/whitepapers-reports') ? $active_link : $inactive_link; ?>" href="<?php echo esc_url(home_url('/insights/whitepapers-reports')); ?>">Whitepapers & Reports</a>
                    </div>
                </div>

                <!-- Contact Us -->
                <a class="rounded-lg px-4 py-3 text-sm font-bold transition-all duration-200 <?php echo $is_contact_active ? 'bg-orange-50 text-orange-500 border-l-4 border-orange-500' : 'text-slate-700 hover:bg-orange-50 hover:text-orange-500'; ?>" href="<?php echo esc_url(home_url('/contact')); ?>">Contact Us</a>

                <!-- Request Demo CTA -->
                <a href="<?php echo esc_url($apex_request_demo_href); ?>" class="mt-4 inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-orange-500 to-orange-400 px-5 py-3 text-sm font-semibold text-white shadow-md hover:shadow-lg transition-all duration-200">
                    Request Demo
                </a>
            </div>
        </div>
    </div>

    <script>
    (function() {
        'use strict';
        
        // ===========================================
        // Mobile Menu Toggle - Initialize FIRST
        // ===========================================
        const mobileToggle = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('apex-mobile-menu');
        const hamburgerIcon = document.getElementById('hamburger-icon');
        const closeIcon = document.getElementById('close-icon');
        
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const isHidden = mobileMenu.style.display === 'none' || mobileMenu.classList.contains('hidden');
                
                // Toggle menu visibility
                mobileMenu.style.display = isHidden ? 'block' : 'none';
                mobileMenu.classList.toggle('hidden', !isHidden);
                this.setAttribute('aria-expanded', isHidden ? 'true' : 'false');
                
                // Toggle icons
                if (hamburgerIcon && closeIcon) {
                    hamburgerIcon.classList.toggle('hidden', isHidden);
                    closeIcon.classList.toggle('hidden', !isHidden);
                }
            });
        }
        
        // Mobile Accordion Menus
        document.querySelectorAll('[data-mobile-accordion]').forEach(function(accordion) {
            accordion.addEventListener('click', function(e) {
                e.preventDefault();
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                const panel = this.nextElementSibling;
                
                // Close other accordions
                document.querySelectorAll('[data-mobile-accordion]').forEach(function(other) {
                    if (other !== accordion) {
                        other.setAttribute('aria-expanded', 'false');
                        const otherPanel = other.nextElementSibling;
                        if (otherPanel) otherPanel.classList.add('hidden');
                    }
                });
                
                // Toggle current
                this.setAttribute('aria-expanded', !isExpanded);
                if (panel) panel.classList.toggle('hidden');
                
                // Rotate arrow
                const arrow = this.querySelector('span:last-child');
                if (arrow) arrow.style.transform = isExpanded ? 'rotate(0deg)' : 'rotate(180deg)';
            });
        });
        
        // ===========================================
        // Header Scroll Effect
        // ===========================================
        const header = document.getElementById('apex-main-header');
        if (header) {
            function handleScroll() {
                header.classList.toggle('scrolled', window.scrollY > 50);
            }
            window.addEventListener('scroll', handleScroll, { passive: true });
            handleScroll();
        }
        
        // ===========================================
        // Desktop Dropdown Navigation
        // ===========================================
        const navItems = document.querySelectorAll('.apex-nav-item');
        const navTriggers = document.querySelectorAll('.apex-nav-trigger');
        let activeDropdown = null;
        let hoverTimeout = null;
        
        // Show dropdown - CSS handles all positioning, no JavaScript positioning needed
        function showDropdown(item) {
            const panel = item.querySelector('.apex-nav-panel');
            const trigger = item.querySelector('.apex-nav-trigger');
            if (!panel) return;
            
            // Hide any other open dropdown
            if (activeDropdown && activeDropdown !== item) {
                hideDropdown(activeDropdown);
            }
            
            // Simply toggle visibility - CSS handles positioning
            panel.classList.add('visible');
            panel.classList.remove('invisible', 'opacity-0', 'pointer-events-none');
            trigger?.setAttribute('aria-expanded', 'true');
            activeDropdown = item;
        }
        
        // Hide dropdown
        function hideDropdown(item) {
            const panel = item.querySelector('.apex-nav-panel');
            const trigger = item.querySelector('.apex-nav-trigger');
            if (!panel) return;
            
            panel.classList.remove('visible');
            panel.classList.add('invisible', 'opacity-0', 'pointer-events-none');
            trigger?.setAttribute('aria-expanded', 'false');
            if (activeDropdown === item) activeDropdown = null;
        }
        
        // Event listeners for desktop dropdowns
        navItems.forEach(item => {
            const trigger = item.querySelector('.apex-nav-trigger');
            const panel = item.querySelector('.apex-nav-panel');
            if (!trigger || !panel) return;
            
            // Mouse events with delay for better UX
            item.addEventListener('mouseenter', () => {
                clearTimeout(hoverTimeout);
                showDropdown(item);
            });
            
            item.addEventListener('mouseleave', () => {
                hoverTimeout = setTimeout(() => hideDropdown(item), 150);
            });
            
            // Click toggle for touch devices
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                if (panel.classList.contains('visible')) {
                    hideDropdown(item);
                } else {
                    showDropdown(item);
                }
            });
            
            // Keyboard navigation
            trigger.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    if (panel.classList.contains('visible')) {
                        hideDropdown(item);
                    } else {
                        showDropdown(item);
                        // Focus first link in dropdown
                        const firstLink = panel.querySelector('a');
                        if (firstLink) firstLink.focus();
                    }
                } else if (e.key === 'Escape') {
                    hideDropdown(item);
                    trigger.focus();
                } else if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    if (!panel.classList.contains('visible')) {
                        showDropdown(item);
                    }
                    const firstLink = panel.querySelector('a');
                    if (firstLink) firstLink.focus();
                }
            });
            
            // Arrow key navigation within dropdown
            panel.addEventListener('keydown', (e) => {
                const links = Array.from(panel.querySelectorAll('a'));
                const currentIndex = links.indexOf(document.activeElement);
                
                if (e.key === 'ArrowDown') {
                    e.preventDefault();
                    const nextIndex = (currentIndex + 1) % links.length;
                    links[nextIndex]?.focus();
                } else if (e.key === 'ArrowUp') {
                    e.preventDefault();
                    const prevIndex = currentIndex <= 0 ? links.length - 1 : currentIndex - 1;
                    links[prevIndex]?.focus();
                } else if (e.key === 'Escape') {
                    hideDropdown(item);
                    trigger.focus();
                } else if (e.key === 'Tab' && !e.shiftKey && currentIndex === links.length - 1) {
                    hideDropdown(item);
                }
            });
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', (e) => {
            if (activeDropdown && !activeDropdown.contains(e.target)) {
                hideDropdown(activeDropdown);
            }
        });
        
        // CSS handles responsive positioning, no JS resize handler needed
        
    })();
    </script>

    <!-- Main -->
    <?php if (!is_front_page()) : ?>
    <main id="site-main" class="flex-1">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
    <?php endif; ?>