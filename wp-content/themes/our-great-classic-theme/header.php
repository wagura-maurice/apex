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
    <header class="sticky top-0 z-50 bg-transparent backdrop-blur-md supports-[backdrop-filter]:bg-transparent transition-all duration-500 apex-gradient-shell">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-3">
            <div class="apex-header-surface">
                <div class="flex h-16 items-center justify-between gap-3">
                <!-- Brand -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 group transition-transform duration-300 hover:scale-105">
                    <div class="relative overflow-hidden rounded-xl shadow-md">
                        <img src="https://web.archive.org/web/20220401202046im_/https://apex-softwares.com/wp-content/uploads/2017/08/newlogo3.png" alt="Apex Softwares" class="h-10 w-auto transition-transform duration-500 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-r from-apex-orange/30 via-apex-blue/30 to-apex-purple/30 opacity-0 group-hover:opacity-100 transition-opacity duration-500 mix-blend-multiply"></div>
                    </div>
                    <span class="leading-tight">
                        <span class="block text-sm font-bold text-apex-dark group-hover:text-apex-orange transition-colors duration-200 apex-gradient-text">Apex Softwares</span>
                        <span class="block text-xs text-apex-gray-500 -mt-0.5">Core banking &amp; digital finance</span>
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
                            ['label' => 'Platform', 'href' => home_url('/platform/apexcore')],
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
                            [
                                'label' => 'About Us',
                                'type'  => 'dropdown',
                                'items' => [
                                    ['label' => 'About Apex Softwares', 'href' => home_url('/about-us')],
                                    ['label' => 'Our Approach', 'href' => home_url('/about-us/our-approach')],
                                    ['label' => 'Leadership Team', 'href' => home_url('/about-us/leadership-team')],
                                    ['label' => 'News & Updates', 'href' => home_url('/about-us/news')],
                                    ['label' => 'Contact Us', 'href' => home_url('/contact')],
                                ],
                            ],
                        ];

                        foreach ($apex_nav as $item) {
                            if (empty($item['type'])) {
                                echo '<a href="' . esc_url($item['href']) . '" class="relative rounded-lg px-4 py-2 hover:bg-apex-gray-100/70 hover:text-apex-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-200 group apex-nav-link">';
                                echo esc_html($item['label']);
                                echo '<span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-apex-orange transform -translate-x-1/2 transition-all duration-300 group-hover:w-8"></span>';
                                echo '</a>';
                            } elseif ($item['type'] === 'dropdown') {
                                echo '<div class="relative apex-nav-item" data-nav="dropdown">';
                                echo '<button type="button" class="apex-nav-trigger rounded-lg px-4 py-2 hover:bg-apex-gray-100/70 hover:text-apex-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-200 apex-nav-link" aria-expanded="false">';
                                echo '<span class="inline-flex items-center gap-1 relative z-10">';
                                echo esc_html($item['label']);
                                echo '<span class="text-apex-gray-400 transition-transform duration-200 group-hover:rotate-180">▾</span>';
                                echo '</span>';
                                echo '</button>';
                                echo '<div class="apex-nav-panel invisible opacity-0 translate-y-2 pointer-events-none absolute left-0 mt-3 w-80 rounded-xl border border-apex-gray-200 bg-white shadow-2xl transition-all duration-300">';
                                echo '<div class="p-3">';
                                foreach ($item['items'] as $sub) {
                                    echo '<a class="block rounded-lg px-4 py-3 text-sm text-apex-gray-700 hover:bg-apex-orange/50 hover:text-white hover:shadow-md transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50" href="' . esc_url($sub['href']) . '">';
                                    echo esc_html($sub['label']);
                                    echo '</a>';
                                }
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            } else { /* mega */
                                echo '<div class="relative apex-nav-item" data-nav="mega">';
                                echo '<button type="button" class="apex-nav-trigger rounded-lg px-4 py-2 hover:bg-apex-gray-100/70 hover:text-apex-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-200 apex-nav-link" aria-expanded="false">';
                                echo '<span class="inline-flex items-center gap-1 relative z-10">';
                                echo esc_html($item['label']);
                                echo '<span class="text-apex-gray-400 transition-transform duration-200 group-hover:rotate-180">▾</span>';
                                echo '</span>';
                                echo '</button>';
                                echo '<div class="apex-nav-panel invisible opacity-0 translate-y-2 pointer-events-none absolute left-1/2 mt-3 w-[min(960px,calc(100vw-2rem))] -translate-x-1/2 rounded-2xl border border-apex-gray-200 bg-white shadow-2xl transition-all duration-300">';
                                echo '<div class="grid gap-6 p-6 lg:grid-cols-12">';
                                echo '<div class="lg:col-span-4">';
                                echo '<p class="text-xs font-bold uppercase tracking-wider text-apex-orange">Solutions</p>';
                                echo '<p class="mt-3 text-sm text-apex-gray-600 leading-relaxed">';
                                echo 'Modular capabilities built around <span class="font-bold text-apex-dark">ApexCore</span> to digitize onboarding, lending, channels, and integrations.';
                                echo '</p>';
                                echo '<a href="' . esc_url(home_url('/solutions/overview')) . '" class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-apex-orange hover:text-apex-orange/80 transition-colors duration-200">';
                                echo 'Explore all solutions <span aria-hidden="true" class="transition-transform duration-200 group-hover:translate-x-1">→</span>';
                                echo '</a>';
                                echo '</div>';
                                echo '<div class="lg:col-span-8">';
                                echo '<div class="grid gap-3 sm:grid-cols-2">';
                                foreach ($item['items'] as $sub) {
                                    echo '<a class="group rounded-xl border border-apex-gray-200 p-4 hover:border-apex-orange hover:bg-gradient-to-br hover:from-apex-orange/5 hover:to-apex-blue/5 hover:shadow-lg transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50" href="' . esc_url($sub['href']) . '">';
                                    echo '<div class="text-sm font-semibold text-apex-dark group-hover:text-apex-orange transition-colors duration-200">';
                                    echo esc_html($sub['label']);
                                    echo '</div>';
                                    echo '<div class="mt-1 text-xs text-apex-gray-500">';
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
                <div class="flex items-center gap-3">
                    <a href="<?php echo esc_url($apex_request_demo_href); ?>" class="hidden sm:inline-flex items-center justify-center rounded-full px-5 py-2.5 text-sm font-bold text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/60 transition-all duration-200 apex-rainbow-cta">
                        Request Demo
                    </a>
                    <button type="button" class="lg:hidden inline-flex items-center justify-center rounded-full border border-apex-gray-200/60 bg-white/80 px-3 py-2 text-sm font-semibold text-apex-gray-700 hover:bg-apex-gray-900 hover:text-white hover:border-transparent focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-300 shadow-sm apex-mobile-toggle" data-mobile-menu-toggle aria-expanded="false" aria-controls="apex-mobile-menu">
                        <svg class="w-5 h-5 apex-mobile-toggle-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="apex-mobile-menu" class="lg:hidden hidden border-t border-apex-gray-200 bg-gradient-to-b from-white/95 via-apex-blue/5 to-apex-purple/5 backdrop-blur-md">
            <div class="mx-auto max-w-7xl px-4 py-6">
                <div class="grid gap-3">
                    <?php
                    // WordPress mobile menu implementation following learningWordPress methodology
                    $mobile_args = array(
                        'theme_location' => 'primary',
                        'container' => false,
                        'items_wrap' => '%3$s', // Remove ul wrapper, just output the li's
                        'depth' => 2,
                        'fallback_cb' => 'apex_mobile_default_nav'
                    );
                    wp_nav_menu($mobile_args);
                    
                    // Default mobile navigation fallback if no menu is set
                    function apex_mobile_default_nav() {
                        echo '<a class="rounded-lg px-4 py-3 text-sm font-bold text-apex-dark hover:bg-apex-orange/10 hover:text-apex-orange transition-all duration-200" href="' . esc_url(home_url('/')) . '">Home</a>';
                        echo '<a class="rounded-lg px-4 py-3 text-sm font-bold text-apex-dark hover:bg-apex-orange/10 hover:text-apex-orange transition-all duration-200" href="' . esc_url(home_url('/platform/apexcore')) . '">Platform</a>';

                        echo '<div class="rounded-xl border border-apex-gray-200 overflow-hidden">';
                        echo '<button type="button" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-apex-dark hover:bg-apex-orange/10 transition-all duration-200" data-mobile-accordion aria-expanded="false">';
                        echo 'Solutions <span class="text-apex-gray-400 transition-transform duration-200">▾</span>';
                        echo '</button>';
                        echo '<div class="hidden px-3 pb-3" data-mobile-panel>';
                        $apex_nav = [
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
                            ]
                        ];
                        foreach ($apex_nav as $item) {
                            if (!empty($item['type']) && $item['label'] === 'Solutions') {
                                foreach ($item['items'] as $sub) {
                                    echo '<a class="block rounded-lg px-3 py-2 text-sm text-apex-gray-700 hover:bg-apex-gray-100 hover:text-apex-orange transition-all duration-200" href="' . esc_url($sub['href']) . '">' . esc_html($sub['label']) . '</a>';
                                }
                            }
                        }
                        echo '</div>';
                        echo '</div>';

                        foreach (['Industry', 'Insights', 'About Us'] as $group) {
                            echo '<div class="rounded-xl border border-apex-gray-200 overflow-hidden">';
                            echo '<button type="button" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-apex-dark hover:bg-apex-orange/10 transition-all duration-200" data-mobile-accordion aria-expanded="false">';
                            echo esc_html($group) . ' <span class="text-apex-gray-400 transition-transform duration-200">▾</span>';
                            echo '</button>';
                            echo '<div class="hidden px-3 pb-3" data-mobile-panel>';
                            $apex_nav = [
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
                                [
                                    'label' => 'About Us',
                                    'type'  => 'dropdown',
                                    'items' => [
                                        ['label' => 'About Apex Softwares', 'href' => home_url('/about-us')],
                                        ['label' => 'Our Approach', 'href' => home_url('/about-us/our-approach')],
                                        ['label' => 'Leadership Team', 'href' => home_url('/about-us/leadership-team')],
                                        ['label' => 'News & Updates', 'href' => home_url('/about-us/news')],
                                        ['label' => 'Contact Us', 'href' => home_url('/contact')],
                                    ],
                                ]
                            ];
                            foreach ($apex_nav as $item) {
                                if (!empty($item['type']) && $item['label'] === $group) {
                                    foreach ($item['items'] as $sub) {
                                        echo '<a class="block rounded-lg px-3 py-2 text-sm text-apex-gray-700 hover:bg-apex-gray-100 hover:text-apex-orange transition-all duration-200" href="' . esc_url($sub['href']) . '">' . esc_html($sub['label']) . '</a>';
                                    }
                                }
                            }
                            echo '</div>';
                            echo '</div>';
                        }
                    }
                    ?>

                    <a href="<?php echo esc_url($apex_request_demo_href); ?>" class="mt-4 inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-5 py-3 text-sm font-bold text-white shadow-lg hover:shadow-xl transition-all duration-200">
                        Request Demo
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- Main -->
    <main id="site-main" class="flex-1">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
