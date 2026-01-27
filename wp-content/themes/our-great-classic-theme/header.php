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

$apex_request_demo_href = home_url('/request-demo');
?>

<div class="min-h-screen flex flex-col">
    <!-- Sticky Header -->
    <header class="sticky top-0 z-50 border-b border-apex-gray-200/70 bg-white/95 backdrop-blur-md shadow-sm supports-[backdrop-filter]:bg-white/90 transition-all duration-300">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between gap-3">
                <!-- Brand -->
                <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center gap-3 group transition-transform duration-200 hover:scale-105">
                    <div class="relative overflow-hidden rounded-lg">
                        <img src="https://web.archive.org/web/20220401202046im_/https://apex-softwares.com/wp-content/uploads/2017/08/newlogo3.png" alt="Apex Softwares" class="h-10 w-auto transition-transform duration-300 group-hover:scale-110">
                        <div class="absolute inset-0 bg-gradient-to-r from-apex-orange/20 to-apex-blue/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <span class="leading-tight">
                        <span class="block text-sm font-bold text-apex-dark group-hover:text-apex-orange transition-colors duration-200">Apex Softwares</span>
                        <span class="block text-xs text-apex-gray-500 -mt-0.5">Core banking & digital finance</span>
                    </span>
                </a>

                <!-- Desktop nav -->
                <nav class="hidden lg:flex items-center gap-1 text-sm font-medium text-apex-gray-700" aria-label="Primary">
                    <?php foreach ($apex_nav as $item) : ?>
                        <?php if (empty($item['type'])) : ?>
                            <a href="<?php echo esc_url($item['href']); ?>" class="relative rounded-lg px-4 py-2 hover:bg-apex-gray-100 hover:text-apex-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-200 group">
                                <?php echo esc_html($item['label']); ?>
                                <span class="absolute bottom-0 left-1/2 w-0 h-0.5 bg-apex-orange transform -translate-x-1/2 transition-all duration-300 group-hover:w-8"></span>
                            </a>
                        <?php elseif ($item['type'] === 'dropdown') : ?>
                            <div class="relative apex-nav-item" data-nav="dropdown">
                                <button type="button" class="apex-nav-trigger rounded-lg px-4 py-2 hover:bg-apex-gray-100 hover:text-apex-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-200" aria-expanded="false">
                                    <span class="inline-flex items-center gap-1">
                                        <?php echo esc_html($item['label']); ?>
                                        <span class="text-apex-gray-400 transition-transform duration-200 group-hover:rotate-180">▾</span>
                                    </span>
                                </button>
                                <div class="apex-nav-panel invisible opacity-0 translate-y-2 pointer-events-none absolute left-0 mt-3 w-80 rounded-xl border border-apex-gray-200 bg-white shadow-2xl transition-all duration-300">
                                    <div class="p-3">
                                        <?php foreach ($item['items'] as $sub) : ?>
                                            <a class="block rounded-lg px-4 py-3 text-sm text-apex-gray-700 hover:bg-apex-orange/50 hover:text-white hover:shadow-md transition-all duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50" href="<?php echo esc_url($sub['href']); ?>">
                                                <?php echo esc_html($sub['label']); ?>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                        <?php else : /* mega */ ?>
                            <div class="relative apex-nav-item" data-nav="mega">
                                <button type="button" class="apex-nav-trigger rounded-lg px-4 py-2 hover:bg-apex-gray-100 hover:text-apex-dark focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-200" aria-expanded="false">
                                    <span class="inline-flex items-center gap-1">
                                        <?php echo esc_html($item['label']); ?>
                                        <span class="text-apex-gray-400 transition-transform duration-200 group-hover:rotate-180">▾</span>
                                    </span>
                                </button>
                                <div class="apex-nav-panel invisible opacity-0 translate-y-2 pointer-events-none absolute left-1/2 mt-3 w-[min(960px,calc(100vw-2rem))] -translate-x-1/2 rounded-2xl border border-apex-gray-200 bg-white shadow-2xl transition-all duration-300">
                                    <div class="grid gap-6 p-6 lg:grid-cols-12">
                                        <div class="lg:col-span-4">
                                            <p class="text-xs font-bold uppercase tracking-wider text-apex-orange">Solutions</p>
                                            <p class="mt-3 text-sm text-apex-gray-600 leading-relaxed">
                                                Modular capabilities built around <span class="font-bold text-apex-dark">ApexCore</span> to digitize onboarding, lending, channels, and integrations.
                                            </p>
                                            <a href="<?php echo esc_url(home_url('/solutions/overview')); ?>" class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-apex-orange hover:text-apex-orange/80 transition-colors duration-200">
                                                Explore all solutions <span aria-hidden="true" class="transition-transform duration-200 group-hover:translate-x-1">→</span>
                                            </a>
                                        </div>
                                        <div class="lg:col-span-8">
                                            <div class="grid gap-3 sm:grid-cols-2">
                                                <?php foreach ($item['items'] as $sub) : ?>
                                                    <a class="group rounded-xl border border-apex-gray-200 p-4 hover:border-apex-orange hover:bg-gradient-to-br hover:from-apex-orange/5 hover:to-apex-blue/5 hover:shadow-lg transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50" href="<?php echo esc_url($sub['href']); ?>">
                                                        <div class="text-sm font-semibold text-apex-dark group-hover:text-apex-orange transition-colors duration-200">
                                                            <?php echo esc_html($sub['label']); ?>
                                                        </div>
                                                        <div class="mt-1 text-xs text-apex-gray-500">
                                                            Learn more about this capability.
                                                        </div>
                                                    </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </nav>

                <!-- Actions -->
                <div class="flex items-center gap-3">
                    <a href="<?php echo esc_url($apex_request_demo_href); ?>" class="hidden sm:inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-5 py-2.5 text-sm font-bold text-white shadow-lg hover:shadow-xl hover:from-apex-orange/95 hover:to-apex-orange/85 transform hover:scale-105 focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/60 transition-all duration-200">
                        Request Demo
                    </a>
                    <button type="button" class="lg:hidden inline-flex items-center justify-center rounded-lg border border-apex-gray-200 bg-white px-3 py-2 text-sm font-semibold text-apex-gray-700 hover:bg-apex-gray-50 hover:border-apex-orange focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/50 transition-all duration-200" data-mobile-menu-toggle aria-expanded="false" aria-controls="apex-mobile-menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div id="apex-mobile-menu" class="lg:hidden hidden border-t border-apex-gray-200 bg-white/95 backdrop-blur-md">
            <div class="mx-auto max-w-7xl px-4 py-6">
                <div class="grid gap-3">
                    <a class="rounded-lg px-4 py-3 text-sm font-bold text-apex-dark hover:bg-apex-orange/10 hover:text-apex-orange transition-all duration-200" href="<?php echo esc_url(home_url('/')); ?>">Home</a>
                    <a class="rounded-lg px-4 py-3 text-sm font-bold text-apex-dark hover:bg-apex-orange/10 hover:text-apex-orange transition-all duration-200" href="<?php echo esc_url(home_url('/platform/apexcore')); ?>">Platform</a>

                    <div class="rounded-xl border border-apex-gray-200 overflow-hidden">
                        <button type="button" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-apex-dark hover:bg-apex-orange/10 transition-all duration-200" data-mobile-accordion aria-expanded="false">
                            Solutions <span class="text-apex-gray-400 transition-transform duration-200">▾</span>
                        </button>
                        <div class="hidden px-3 pb-3" data-mobile-panel>
                            <?php foreach ($apex_nav as $item) : ?>
                                <?php if (!empty($item['type']) && $item['label'] === 'Solutions') : ?>
                                    <?php foreach ($item['items'] as $sub) : ?>
                                        <a class="block rounded-lg px-3 py-2 text-sm text-apex-gray-700 hover:bg-apex-gray-100 hover:text-apex-orange transition-all duration-200" href="<?php echo esc_url($sub['href']); ?>"><?php echo esc_html($sub['label']); ?></a>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <?php foreach (['Industry', 'Insights', 'About Us'] as $group) : ?>
                        <div class="rounded-xl border border-apex-gray-200 overflow-hidden">
                            <button type="button" class="w-full flex items-center justify-between px-4 py-3 text-sm font-bold text-apex-dark hover:bg-apex-orange/10 transition-all duration-200" data-mobile-accordion aria-expanded="false">
                                <?php echo esc_html($group); ?> <span class="text-apex-gray-400 transition-transform duration-200">▾</span>
                            </button>
                            <div class="hidden px-3 pb-3" data-mobile-panel>
                                <?php foreach ($apex_nav as $item) : ?>
                                    <?php if (!empty($item['type']) && $item['label'] === $group) : ?>
                                        <?php foreach ($item['items'] as $sub) : ?>
                                            <a class="block rounded-lg px-3 py-2 text-sm text-apex-gray-700 hover:bg-apex-gray-100 hover:text-apex-orange transition-all duration-200" href="<?php echo esc_url($sub['href']); ?>"><?php echo esc_html($sub['label']); ?></a>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

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
