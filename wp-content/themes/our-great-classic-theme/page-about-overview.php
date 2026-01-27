<?php
/**
 * Template Name: About Us Overview
 * Description: Overview page for about us sections
 */

get_header(); ?>

<!-- Breadcrumb Navigation -->
<nav class="bg-apex-light py-3">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-apex-gray-600">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-apex-orange transition-colors">Home</a></li>
            <li>/</li>
            <li><a href="<?php echo esc_url(home_url('/about-us')); ?>" class="hover:text-apex-orange transition-colors">About Us</a></li>
            <li>/</li>
            <li class="text-apex-dark font-medium">Overview</li>
        </ol>
    </div>
</nav>

<!-- Back to Overview Link -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <a href="<?php echo esc_url(home_url('/about-us')); ?>" class="inline-flex items-center text-apex-orange font-medium hover:underline">
        ← Back to About Us
    </a>
</div>

<!-- Hero Section with Orange Wave Background -->
<section class="relative overflow-hidden bg-gradient-to-b from-apex-orange/10 to-white py-16">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxwYXRoIGQ9Ik0wLDUwTDI1LDcwTDUwLDQwTDc1LDgwTDEwMCwzMCIgc3Ryb2tlPSJyZ2JhKDEyOCwgMTI4LCAxMjgsIDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] bg-repeat-x bg-top bg-cover opacity-20"></div>
    <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-apex-dark mb-4">About Apex Softwares</h1>
        <p class="text-xl text-apex-gray-600">
            We're committed to transforming financial services through innovative technology solutions.
        </p>
    </div>
</section>

<!-- About Sections Grid -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <a href="<?php echo esc_url(home_url('/about-us')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">About Apex Softwares</h3>
            <p class="text-apex-gray-600 mb-4">Learn about our company history, mission, and commitment to excellence.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/about-us/our-approach')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Our Approach</h3>
            <p class="text-apex-gray-600 mb-4">Discover how we Listen, Co-Create, and Support our clients.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/about-us/leadership-team')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Leadership Team</h3>
            <p class="text-apex-gray-600 mb-4">Meet our experienced leadership team driving innovation.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/about-us/news')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">News & Updates</h3>
            <p class="text-apex-gray-600 mb-4">Stay up-to-date with our latest announcements and achievements.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
    </div>
</div>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-apex-orange/5 to-apex-blue/5 rounded-2xl border border-apex-gray-100 mx-4 my-16 p-8">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-apex-dark mb-4">Join Our Team</h2>
        <p class="text-apex-gray-600 mb-8">
            Interested in being part of our mission to transform financial services?
        </p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-8 py-4 text-lg font-bold text-white shadow-md hover:shadow-lg transition-all duration-200">
            Contact Us
        </a>
    </div>
</section>

<?php get_footer(); ?>