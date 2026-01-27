<?php
/**
 * Template Name: Insights Overview
 * Description: Overview page for all insights sections
 */

get_header(); ?>

<!-- Breadcrumb Navigation -->
<nav class="bg-apex-light py-3">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-apex-gray-600">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-apex-orange transition-colors">Home</a></li>
            <li>/</li>
            <li><a href="<?php echo esc_url(home_url('/insights/blog')); ?>" class="hover:text-apex-orange transition-colors">Insights</a></li>
            <li>/</li>
            <li class="text-apex-dark font-medium">Overview</li>
        </ol>
    </div>
</nav>

<!-- Back to Overview Link -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <a href="<?php echo esc_url(home_url('/insights/blog')); ?>" class="inline-flex items-center text-apex-orange font-medium hover:underline">
        ← Back to Insights
    </a>
</div>

<!-- Hero Section with Orange Wave Background -->
<section class="relative overflow-hidden bg-gradient-to-b from-apex-orange/10 to-white py-16">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxwYXRoIGQ9Ik0wLDUwTDI1LDcwTDUwLDQwTDc1LDgwTDEwMCwzMCIgc3Ryb2tlPSJyZ2JhKDEyOCwgMTI4LCAxMjgsIDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] bg-repeat-x bg-top bg-cover opacity-20"></div>
    <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-apex-dark mb-4">Insights & Resources</h1>
        <p class="text-xl text-apex-gray-600">
            Expert perspectives on financial technology trends, innovations, and best practices.
        </p>
    </div>
</section>

<!-- Insights Grid -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <a href="<?php echo esc_url(home_url('/insights/blog')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Blog</h3>
            <p class="text-apex-gray-600 mb-4">Latest news, industry updates, and expert opinions on financial technology.</p>
            <span class="text-apex-orange font-medium text-sm">View articles →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/insights/success-stories')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Success Stories</h3>
            <p class="text-apex-gray-600 mb-4">Real-world examples of how our clients transformed their operations.</p>
            <span class="text-apex-orange font-medium text-sm">Read stories →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/insights/webinars')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Webinars & Events</h3>
            <p class="text-apex-gray-600 mb-4">Join our upcoming events and learn from industry experts.</p>
            <span class="text-apex-orange font-medium text-sm">Explore events →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/insights/whitepapers-reports')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Whitepapers & Reports</h3>
            <p class="text-apex-gray-600 mb-4">In-depth research and analysis on financial technology trends.</p>
            <span class="text-apex-orange font-medium text-sm">Download resources →</span>
        </a>
    </div>
</div>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-apex-orange/5 to-apex-blue/5 rounded-2xl border border-apex-gray-100 mx-4 my-16 p-8">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-apex-dark mb-4">Stay Informed</h2>
        <p class="text-apex-gray-600 mb-8">
            Subscribe to our newsletter to receive the latest insights and updates.
        </p>
        <div class="flex flex-col sm:flex-row gap-4 max-w-xl mx-auto">
            <input type="email" placeholder="Your email address" class="flex-1 rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
            <button class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-6 py-3 text-base font-bold text-white shadow-md hover:shadow-lg transition-all duration-200">
                Subscribe
            </button>
        </div>
    </div>
</section>

<?php get_footer(); ?>