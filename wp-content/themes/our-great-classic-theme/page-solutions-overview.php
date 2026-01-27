<?php
/**
 * Template Name: Solutions Overview
 * Description: Overview page for all solutions
 */

get_header(); ?>

<!-- Breadcrumb Navigation -->
<nav class="bg-apex-light py-3">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-apex-gray-600">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-apex-orange transition-colors">Home</a></li>
            <li>/</li>
            <li><a href="<?php echo esc_url(home_url('/solutions/overview')); ?>" class="hover:text-apex-orange transition-colors">Solutions</a></li>
            <li>/</li>
            <li class="text-apex-dark font-medium">Overview</li>
        </ol>
    </div>
</nav>

<!-- Back to Overview Link -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <a href="<?php echo esc_url(home_url('/solutions/overview')); ?>" class="inline-flex items-center text-apex-orange font-medium hover:underline">
        ← Back to Solutions Overview
    </a>
</div>

<!-- Hero Section with Orange Wave Background -->
<section class="relative overflow-hidden bg-gradient-to-b from-apex-orange/10 to-white py-16">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxwYXRoIGQ9Ik0wLDUwTDI1LDcwTDUwLDQwTDc1LDgwTDEwMCwzMCIgc3Ryb2tlPSJyZ2JhKDEyOCwgMTI4LCAxMjgsIDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] bg-repeat-x bg-top bg-cover opacity-20"></div>
    <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-apex-dark mb-4">Our Solutions</h1>
        <p class="text-xl text-apex-gray-600">
            Modular capabilities built around ApexCore to digitize onboarding, lending, channels, and integrations.
        </p>
    </div>
</section>

<!-- Solutions Grid -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <a href="<?php echo esc_url(home_url('/solutions/core-banking-microfinance')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Core Banking & Microfinance</h3>
            <p class="text-apex-gray-600 mb-4">Complete banking operations management with specialized microfinance capabilities.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/solutions/mobile-wallet-app')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Mobile Wallet App</h3>
            <p class="text-apex-gray-600 mb-4">Secure, user-friendly mobile applications for customer self-service and transactions.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/solutions/agency-branch-banking')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Agency & Branch Banking</h3>
            <p class="text-apex-gray-600 mb-4">Extend your reach through agents and branches with centralized control.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/solutions/internet-mobile-banking')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Internet & Mobile Banking</h3>
            <p class="text-apex-gray-600 mb-4">Omnichannel banking experiences for customers across all devices.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/solutions/loan-origination-workflows')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Loan Origination & Workflows</h3>
            <p class="text-apex-gray-600 mb-4">Streamlined loan processing with automated workflows and decision engines.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/solutions/digital-field-agent')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Digital Field Agent</h3>
            <p class="text-apex-gray-600 mb-4">Empower field agents with mobile tools for efficient customer outreach.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/solutions/enterprise-integration')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Enterprise Integration</h3>
            <p class="text-apex-gray-600 mb-4">Connect with external systems through APIs and standardized interfaces.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/solutions/payment-switch-ledger')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Payment Switch & General Ledger</h3>
            <p class="text-apex-gray-600 mb-4">Robust payment processing and accounting systems with real-time reconciliation.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
        
        <a href="<?php echo esc_url(home_url('/solutions/reporting-analytics')); ?>" class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300 block group">
            <h3 class="text-xl font-bold text-apex-dark mb-3 group-hover:text-apex-orange transition-colors">Reporting & Analytics</h3>
            <p class="text-apex-gray-600 mb-4">Advanced analytics and customizable reporting for data-driven decisions.</p>
            <span class="text-apex-orange font-medium text-sm">Learn more →</span>
        </a>
    </div>
</div>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-apex-orange/5 to-apex-blue/5 rounded-2xl border border-apex-gray-100 mx-4 my-16 p-8">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-apex-dark mb-4">Ready to Transform Your Business?</h2>
        <p class="text-apex-gray-600 mb-8">
            Discover how our solutions can help you achieve your financial institution's goals.
        </p>
        <a href="<?php echo esc_url(home_url('/request-demo')); ?>" class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-8 py-4 text-lg font-bold text-white shadow-md hover:shadow-lg transition-all duration-200">
            Schedule Your Demo
        </a>
    </div>
</section>

<?php get_footer(); ?>