<?php get_header(); ?>

<!-- Breadcrumb Navigation -->
<nav class="bg-apex-light py-3">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-apex-gray-600">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-apex-orange transition-colors">Home</a></li>
            <li>/</li>
            <li class="text-apex-dark font-medium">Page Not Found</li>
        </ol>
    </div>
</nav>

<!-- Error Content -->
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-16">
    <div class="text-center">
        <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-apex-orange/10 mb-6">
            <span class="text-5xl font-bold text-apex-orange">404</span>
        </div>
        <h1 class="text-4xl font-bold text-apex-dark mb-4">Page Not Found</h1>
        <p class="text-xl text-apex-gray-600 mb-8">
            Sorry, we couldn't find the page you're looking for.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-6 py-3 text-base font-bold text-white shadow-md hover:shadow-lg transition-all duration-200">
                Go to Homepage
            </a>
            <a href="<?php echo esc_url(home_url('/contact')); ?>" class="inline-flex items-center justify-center rounded-lg border border-apex-orange bg-white px-6 py-3 text-base font-bold text-apex-orange hover:bg-apex-orange hover:text-white transition-all duration-200">
                Contact Support
            </a>
        </div>
    </div>
</div>

<!-- Popular Pages Section -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-2xl font-bold text-center text-apex-dark mb-8">Popular Pages</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <a href="<?php echo esc_url(home_url('/platform/apexcore')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
            <h3 class="text-lg font-bold text-apex-dark mb-2">ApexCore Platform</h3>
            <p class="text-apex-gray-600 text-sm">Web-based core banking solution</p>
        </a>
        <a href="<?php echo esc_url(home_url('/solutions/overview')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
            <h3 class="text-lg font-bold text-apex-dark mb-2">Solutions</h3>
            <p class="text-apex-gray-600 text-sm">Comprehensive financial solutions</p>
        </a>
        <a href="<?php echo esc_url(home_url('/industry/overview')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
            <h3 class="text-lg font-bold text-apex-dark mb-2">Industries</h3>
            <p class="text-apex-gray-600 text-sm">Solutions by industry</p>
        </a>
        <a href="<?php echo esc_url(home_url('/request-demo')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block">
            <h3 class="text-lg font-bold text-apex-dark mb-2">Request Demo</h3>
            <p class="text-apex-gray-600 text-sm">Schedule a personalized demo</p>
        </a>
    </div>
</div>

<?php get_footer(); ?>