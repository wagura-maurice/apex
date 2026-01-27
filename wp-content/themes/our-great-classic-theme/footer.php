        </div>
    </main>

    <?php
    $apex_request_demo_href = home_url('/request-demo');
    $apex_footer_groups = [
        'Platform' => [
            ['label' => 'ApexCore Overview', 'href' => home_url('/platform/apexcore')],
            ['label' => 'Request Demo', 'href' => $apex_request_demo_href],
        ],
        'Solutions' => [
            ['label' => 'Solutions Overview', 'href' => home_url('/solutions/overview')],
            ['label' => 'Core Banking & Microfinance', 'href' => home_url('/solutions/core-banking-microfinance')],
            ['label' => 'Internet & Mobile Banking', 'href' => home_url('/solutions/internet-mobile-banking')],
            ['label' => 'Agency & Branch Banking', 'href' => home_url('/solutions/agency-branch-banking')],
            ['label' => 'Reporting & Analytics', 'href' => home_url('/solutions/reporting-analytics')],
        ],
        'Industry' => [
            ['label' => 'Industry Overview', 'href' => home_url('/industry/overview')],
            ['label' => 'MFIs', 'href' => home_url('/industry/mfis')],
            ['label' => 'SACCOs & Credit Unions', 'href' => home_url('/industry/credit-unions')],
            ['label' => 'Commercial Banks', 'href' => home_url('/industry/banks-microfinance')],
        ],
        'Company' => [
            ['label' => 'About Apex Softwares', 'href' => home_url('/about-us')],
            ['label' => 'Our Approach', 'href' => home_url('/about-us/our-approach')],
            ['label' => 'News & Updates', 'href' => home_url('/about-us/news')],
            ['label' => 'Contact', 'href' => home_url('/contact')],
        ],
    ];
    ?>

    <footer class="border-t border-apex-gray-200 bg-gradient-to-br from-apex-gray-50 via-white to-apex-blue/5 relative overflow-hidden apex-gradient-shell">
        <!-- CTA band -->
        <div class="bg-gradient-to-r from-apex-orange via-apex-blue to-apex-purple text-white relative overflow-hidden apex-animated-gradient">
            <div class="absolute -inset-x-32 -top-40 h-64 bg-gradient-to-r from-white/10 via-transparent to-white/10 blur-3xl opacity-70 pointer-events-none"></div>
            <div class="absolute -inset-x-20 top-1/2 h-72 bg-gradient-to-r from-apex-orange/40 via-apex-blue/20 to-apex-purple/30 blur-3xl opacity-40 pointer-events-none"></div>
            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
                <div class="flex flex-col gap-8 md:flex-row md:items-center md:justify-between">
                    <div class="max-w-2xl">
                        <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-3 apex-gradient-text drop-shadow-sm">Ready to accelerate your digital transformation?</h2>
                        <p class="text-white/90 text-lg leading-relaxed">
                            Talk to our team about <span class="font-bold text-white bg-apex-dark/30 px-2 py-1 rounded-full shadow-sm">ApexCore</span> and the solutions that help you launch faster, scale securely, and serve customers better.
                        </p>
                    </div>
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="<?php echo esc_url($apex_request_demo_href); ?>" class="inline-flex items-center justify-center rounded-full px-6 py-4 text-sm font-bold text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-white/40 transition-all duration-200 apex-rainbow-cta">
                            Request Demo
                        </a>
                        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="inline-flex items-center justify-center rounded-full border border-white/30 bg-white/10 backdrop-blur-md px-6 py-4 text-sm font-bold text-white hover:bg-white/20 hover:border-white/60 focus:outline-none focus-visible:ring-2 focus-visible:ring-white/40 transition-all duration-200 shadow-lg apex-ghost-cta">
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Links -->
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 relative">
            <div class="pointer-events-none absolute -left-24 top-12 h-40 w-40 rounded-full bg-gradient-to-br from-apex-orange/25 via-apex-blue/15 to-apex-purple/20 blur-3xl opacity-70"></div>
            <div class="pointer-events-none absolute -right-24 bottom-16 h-52 w-52 rounded-full bg-gradient-to-br from-apex-purple/25 via-apex-blue/20 to-apex-orange/15 blur-3xl opacity-80"></div>

            <div class="relative grid gap-12 lg:grid-cols-12">
                <div class="lg:col-span-5">
                    <div class="flex items-center gap-4 group">
                        <div class="relative overflow-hidden rounded-2xl shadow-md">
                            <img src="https://web.archive.org/web/20220401202046im_/https://apex-softwares.com/wp-content/uploads/2017/08/newlogo3.png" alt="Apex Softwares" class="h-12 w-auto transition-transform duration-500 group-hover:scale-110">
                            <div class="absolute inset-0 bg-gradient-to-r from-apex-orange/25 via-apex-blue/25 to-apex-purple/25 opacity-0 group-hover:opacity-100 transition-opacity duration-500 mix-blend-multiply"></div>
                        </div>
                        <div>
                            <p class="text-base font-bold text-apex-dark group-hover:text-apex-orange transition-colors duration-200 apex-gradient-text">Apex Softwares</p>
                            <p class="text-sm text-apex-gray-500 -mt-0.5">Modern core banking &amp; digital finance</p>
                        </div>
                    </div>
                    <p class="mt-6 text-base text-apex-gray-600 leading-relaxed">
                        ApexCore is a web-based, multi-branch, multi-tenant platform built for microfinance institutions, SACCOs, and banks.
                    </p>

                    <div class="mt-8 rounded-3xl border border-apex-gray-100/80 bg-white/80 backdrop-blur-xl p-6 shadow-[0_18px_45px_rgba(15,23,42,0.08)] apex-newsletter">
                        <p class="text-base font-bold text-apex-dark mb-2 apex-gradient-text">Get updates</p>
                        <p class="text-sm text-apex-gray-500">Industry insights, product updates, and events.</p>
                        <form class="mt-4 flex flex-col gap-3 sm:flex-row" action="#" method="post">
                            <label class="sr-only" for="apex-newsletter-email">Email</label>
                            <input id="apex-newsletter-email" name="email" type="email" placeholder="you@company.com" class="flex-1 rounded-2xl border border-apex-gray-200/80 bg-white/80 px-3 py-2 text-sm focus:border-apex-orange focus:ring-2 focus:ring-apex-orange/30 transition-all duration-200 shadow-sm" />
                            <button type="submit" class="inline-flex items-center justify-center rounded-2xl px-5 py-3 text-sm font-bold text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-apex-orange/60 transition-all duration-200 apex-rainbow-cta">
                                Subscribe
                            </button>
                        </form>
                        <p class="mt-3 text-xs text-apex-gray-400">By subscribing you agree to our Privacy Policy.</p>
                    </div>
                </div>

                <div class="lg:col-span-7">
                    <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-4">
                        <?php foreach ($apex_footer_groups as $title => $links) : ?>
                            <div>
                                <p class="text-base font-bold text-apex-dark mb-4 apex-gradient-text"><?php echo esc_html($title); ?></p>
                                <ul class="space-y-3">
                                    <?php foreach ($links as $link) : ?>
                                        <li>
                                            <a class="relative text-apex-gray-600 hover:text-apex-dark transition-colors duration-200 text-sm apex-footer-link" href="<?php echo esc_url($link['href']); ?>">
                                                <?php echo esc_html($link['label']); ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <div class="mt-16 flex flex-col gap-4 border-t border-apex-gray-200/70 pt-8 text-sm text-apex-gray-500 sm:flex-row sm:items-center sm:justify-between">
                <p class="font-medium">&copy; <?php echo esc_html(date('Y')); ?> Apex Softwares. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a class="hover:text-apex-orange transition-colors duration-200 apex-footer-link" href="<?php echo esc_url(home_url('/privacy-policy')); ?>">Privacy Policy</a>
                    <a class="hover:text-apex-orange transition-colors duration-200 apex-footer-link" href="<?php echo esc_url(home_url('/terms')); ?>">Terms of Service</a>
                </div>
                <p class="text-xs">Built for performance, accessibility, and scale.</p>
            </div>
        </div>
    </footer>
</div>
<?php wp_footer(); ?>
</body>
</html>
