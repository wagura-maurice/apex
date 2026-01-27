<?php get_header(); ?>

<!-- Hero Section with Dynamic ApexCore Carousel -->
<section class="relative overflow-hidden min-h-screen flex items-center py-16 md:py-20" data-hero-bg>
    <div class="absolute inset-0 bg-gradient-to-br from-apex-orange/5 via-white to-apex-blue/5"></div>
    <div class="absolute inset-x-0 bottom-0 h-40 bg-gradient-to-t from-white via-white/60 to-transparent"></div>

    <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-12 items-center">
            <!-- Hero copy -->
            <div class="lg:col-span-6 space-y-6">
                <p class="text-sm font-semibold tracking-[0.2em] text-apex-orange uppercase">
                    ApexCore Platform
                </p>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-apex-dark leading-tight">
                    <?php echo get_theme_mod('apex_hero_heading', 'Transform Your Financial Services with ApexCore'); ?>
                </h1>
                <p class="text-lg md:text-xl text-apex-gray-600 max-w-xl">
                    <?php echo get_theme_mod('apex_hero_subheading', 'Web-based, multi-branch, multi-tenant core banking platform built for MFIs, SACCOs, and banks that need secure scale, faster launches, and omnichannel digital experiences.'); ?>
                </p>

                <div class="flex flex-col sm:flex-row gap-4 pt-2">
                    <a href="<?php echo esc_url(home_url('/request-demo')); ?>" class="inline-flex items-center justify-center rounded-full px-8 py-4 text-sm md:text-base font-bold text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/60 transition-all duration-200 apex-rainbow-cta">
                        <?php echo get_theme_mod('apex_hero_cta_text', 'Request Demo'); ?>
                    </a>
                    <a href="<?php echo esc_url(home_url('/platform/apexcore')); ?>" class="inline-flex items-center justify-center rounded-full border border-apex-gray-200 bg-white px-8 py-4 text-sm md:text-base font-semibold text-apex-dark hover:border-apex-orange hover:text-apex-orange hover:shadow-md transition-all duration-200">
                        <?php echo get_theme_mod('apex_hero_secondary_cta_text', 'Explore ApexCore'); ?>
                    </a>
                </div>

                <div class="flex flex-wrap items-center gap-4 pt-4 text-xs md:text-sm text-apex-gray-500">
                    <span class="inline-flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-apex-orange"></span>
                        Multi-tenant, cloud-ready architecture
                    </span>
                    <span class="inline-flex items-center gap-2">
                        <span class="h-2 w-2 rounded-full bg-apex-gray-400"></span>
                        Built for regulated financial institutions
                    </span>
                </div>
            </div>

            <!-- Hero carousel -->
            <div class="lg:col-span-6">
                <div class="relative h-[260px] sm:h-[300px] md:h-[340px]">
                    <div
                        class="relative h-full w-full rounded-3xl bg-white/90 shadow-[0_24px_80px_rgba(15,23,42,0.16)] border border-apex-gray-100 overflow-hidden backdrop-blur-sm"
                        data-hero-carousel
                        aria-label="ApexCore capabilities"
                    >
                        <!-- Slide 1 -->
                        <article
                            class="absolute inset-0 flex flex-col justify-between p-6 sm:p-8 opacity-100 translate-y-0 transition-all duration-700 ease-out z-20"
                            data-hero-slide
                            data-hero-slide-active="true"
                        >
                            <header class="space-y-4">
                                <p class="text-xs font-semibold tracking-[0.2em] text-apex-gray-500 uppercase mb-2">
                                    Core Banking & Microfinance
                                </p>
                                <h2 class="text-2xl md:text-3xl font-bold text-apex-dark mb-3">
                                    Modernize your core without disrupting your branch network
                                </h2>
                                <p class="text-sm md:text-base text-apex-gray-600">
                                    Unify deposits, lending, savings, and GL on one configurable platform with real-time reporting across all branches and channels.
                                </p>
                                <div class="relative mt-2 h-28 sm:h-32 md:h-40 rounded-2xl overflow-hidden border border-apex-gray-100">
                                    <img
                                        src="https://www.rediansoftware.com/wp-content/uploads/2025/12/digital-core-banking-sacco-platform-dashboard-east-west-africa-2048x1152.jpg"
                                        alt="ApexCore digital core banking dashboard"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    />
                                </div>
                            </header>
                            <footer class="flex items-center justify-between pt-4 text-xs text-apex-gray-500">
                                <span>Live in months, not years.</span>
                                <a href="<?php echo esc_url(home_url('/solutions/core-banking-microfinance')); ?>" class="font-semibold text-apex-orange hover:text-apex-dark transition-colors">
                                    View Core Banking →
                                </a>
                            </footer>
                        </article>

                        <!-- Slide 2 -->
                        <article
                            class="absolute inset-0 flex flex-col justify-between p-6 sm:p-8 opacity-0 translate-y-4 transition-all duration-700 ease-out z-10"
                            data-hero-slide
                        >
                            <header class="space-y-4">
                                <p class="text-xs font-semibold tracking-[0.2em] text-apex-gray-500 uppercase mb-2">
                                    Digital Channels
                                </p>
                                <h2 class="text-2xl md:text-3xl font-bold text-apex-dark mb-3">
                                    Launch mobile wallets and internet banking on one stack
                                </h2>
                                <p class="text-sm md:text-base text-apex-gray-600">
                                    Deliver mobile apps, USSD, and web banking experiences that share workflows, limits, and risk rules across every touchpoint.
                                </p>
                                <div class="relative mt-2 h-28 sm:h-32 md:h-40 rounded-2xl overflow-hidden border border-apex-gray-100">
                                    <img
                                        src="https://i0.wp.com/fintech.rediansoftware.com/wp-content/uploads/2023/06/standard-quality-control-concept-m.jpg"
                                        alt="Quality-controlled omnichannel digital banking experience"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    />
                                </div>
                            </header>
                            <footer class="flex items-center justify-between pt-4 text-xs text-apex-gray-500">
                                <span>Omnichannel by design.</span>
                                <a href="<?php echo esc_url(home_url('/solutions/internet-mobile-banking')); ?>" class="font-semibold text-apex-orange hover:text-apex-dark transition-colors">
                                    Explore Channels →
                                </a>
                            </footer>
                        </article>

                        <!-- Slide 3 -->
                        <article
                            class="absolute inset-0 flex flex-col justify-between p-6 sm:p-8 opacity-0 translate-y-4 transition-all duration-700 ease-out z-10"
                            data-hero-slide
                        >
                            <header class="space-y-4">
                                <p class="text-xs font-semibold tracking-[0.2em] text-apex-gray-500 uppercase mb-2">
                                    Field & Agent Banking
                                </p>
                                <h2 class="text-2xl md:text-3xl font-bold text-apex-dark mb-3">
                                    Take ApexCore into the field with agents and DFAs
                                </h2>
                                <p class="text-sm md:text-base text-apex-gray-600">
                                    Equip staff and agents with offline-ready apps for onboarding, KYC, collections, and monitoring—safely synced into your core.
                                </p>
                                <div class="relative mt-2 h-28 sm:h-32 md:h-40 rounded-2xl overflow-hidden border border-apex-gray-100">
                                    <img
                                        src="https://i0.wp.com/fintech.rediansoftware.com/wp-content/uploads/2023/05/businessman-touch-cloud-computin-1.webp"
                                        alt="Field agents securely connected to cloud banking"
                                        class="h-full w-full object-cover"
                                        loading="lazy"
                                    />
                                </div>
                            </header>
                            <footer class="flex items-center justify-between pt-4 text-xs text-apex-gray-500">
                                <span>Built for financial inclusion.</span>
                                <a href="<?php echo esc_url(home_url('/solutions/digital-field-agent')); ?>" class="font-semibold text-apex-orange hover:text-apex-dark transition-colors">
                                    See Field Agent →
                                </a>
                            </footer>
                        </article>
                    </div>

                    <!-- Carousel indicators -->
                    <div class="mt-4 flex items-center justify-end gap-2 pr-1">
                        <button
                            type="button"
                            class="h-1.5 w-6 rounded-full bg-apex-orange transition-all duration-300"
                            data-hero-dot
                            aria-label="Core Banking slide"
                        ></button>
                        <button
                            type="button"
                            class="h-1.5 w-3 rounded-full bg-apex-gray-200 hover:bg-apex-gray-400 transition-all duration-300"
                            data-hero-dot
                            aria-label="Digital Channels slide"
                        ></button>
                        <button
                            type="button"
                            class="h-1.5 w-3 rounded-full bg-apex-gray-200 hover:bg-apex-gray-400 transition-all duration-300"
                            data-hero-dot
                            aria-label="Field & Agent slide"
                        ></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb Navigation -->
<nav class="bg-apex-light py-3">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-apex-gray-600">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-apex-orange transition-colors">Home</a></li>
            <li>/</li>
            <li class="text-apex-dark font-medium">APEX SOFTWARES</li>
        </ol>
    </div>
</nav>

<!-- Main Content -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center text-apex-dark mb-4"><?php echo get_theme_mod('apex_features_heading', 'Our Comprehensive Platform'); ?></h2>
        <p class="text-center text-apex-gray-600 max-w-2xl mx-auto mb-12">
            <?php echo get_theme_mod('apex_features_description', 'ApexCore is engineered to meet the unique needs of financial institutions with modular solutions that scale with your business.'); ?>
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300">
                <h3 class="text-xl font-bold text-apex-dark mb-3">Core Banking</h3>
                <p class="text-apex-gray-600 mb-4">Complete banking operations management with multi-tenant architecture.</p>
                <a href="<?php echo esc_url(home_url('/solutions/core-banking-microfinance')); ?>" class="text-apex-orange font-medium hover:underline">Learn more →</a>
            </div>
            
            <div class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300">
                <h3 class="text-xl font-bold text-apex-dark mb-3">Mobile Solutions</h3>
                <p class="text-apex-gray-600 mb-4">Mobile wallet apps and internet banking for seamless customer experience.</p>
                <a href="<?php echo esc_url(home_url('/solutions/mobile-wallet-app')); ?>" class="text-apex-orange font-medium hover:underline">Learn more →</a>
            </div>
            
            <div class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300">
                <h3 class="text-xl font-bold text-apex-dark mb-3">Loan Management</h3>
                <p class="text-apex-gray-600 mb-4">End-to-end loan origination and workflow automation.</p>
                <a href="<?php echo esc_url(home_url('/solutions/loan-origination-workflows')); ?>" class="text-apex-orange font-medium hover:underline">Learn more →</a>
            </div>
        </div>
    </section>
    
    <section class="mb-16">
        <h2 class="text-3xl font-bold text-center text-apex-dark mb-4">Industries We Serve</h2>
        <p class="text-center text-apex-gray-600 max-w-2xl mx-auto mb-12">
            Tailored solutions for various financial service providers and organizations.
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="<?php echo esc_url(home_url('/industry/mfis')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
                <h3 class="text-xl font-bold text-apex-dark mb-2">Microfinance Institutions</h3>
                <p class="text-apex-gray-600">Specialized tools for micro-lending and community financial services.</p>
            </a>
            
            <a href="<?php echo esc_url(home_url('/industry/credit-unions')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
                <h3 class="text-xl font-bold text-apex-dark mb-2">SACCOs & Credit Unions</h3>
                <p class="text-apex-gray-600">Member-focused banking solutions with cooperative principles.</p>
            </a>
            
            <a href="<?php echo esc_url(home_url('/industry/banks-microfinance')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
                <h3 class="text-xl font-bold text-apex-dark mb-2">Commercial Banks</h3>
                <p class="text-apex-gray-600">Scalable core banking infrastructure for traditional financial institutions.</p>
            </a>
            
            <a href="<?php echo esc_url(home_url('/industry/digital-government')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
                <h3 class="text-xl font-bold text-apex-dark mb-2">Digital Government & NGOs</h3>
                <p class="text-apex-gray-600">Financial inclusion solutions for public sector and development programs.</p>
            </a>
        </div>
    </section>
    
    <section class="py-12 bg-gradient-to-r from-apex-orange/5 to-apex-blue/5 rounded-2xl border border-apex-gray-100">
        <div class="text-center max-w-3xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-apex-dark mb-4">Ready to Transform Your Institution?</h2>
            <p class="text-apex-gray-600 mb-8">
                Join hundreds of financial institutions leveraging ApexCore to drive growth, efficiency, and customer satisfaction.
            </p>
            <a href="<?php echo esc_url(home_url('/request-demo')); ?>" class="inline-flex items-center justify-center rounded-full bg-gradient-to-r from-apex-orange to-apex-orange/90 px-8 py-4 text-lg font-bold text-white shadow-lg hover:shadow-xl transition-all duration-200">
                Schedule Your Demo Today
            </a>
        </div>
    </section>
</div>

<?php get_footer(); ?>
