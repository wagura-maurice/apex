<?php
/**
 * Template Name: Platform ApexCore
 * Description: Page for the ApexCore platform
 */

get_header(); ?>

<!-- Breadcrumb Navigation -->
<nav class="bg-apex-light py-3">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-apex-gray-600">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-apex-orange transition-colors">Home</a></li>
            <li>/</li>
            <li><a href="<?php echo esc_url(home_url('/platform/apexcore')); ?>" class="hover:text-apex-orange transition-colors">Platform</a></li>
            <li>/</li>
            <li class="text-apex-dark font-medium">ApexCore</li>
        </ol>
    </div>
</nav>

<!-- Back to Overview Link -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <a href="<?php echo esc_url(home_url('/platform/apexcore')); ?>" class="inline-flex items-center text-apex-orange font-medium hover:underline">
        ← Back to Platform
    </a>
</div>

<!-- Hero Section with Orange Wave Background -->
<section class="relative overflow-hidden bg-gradient-to-b from-apex-orange/10 to-white py-16">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxwYXRoIGQ9Ik0wLDUwTDI1LDcwTDUwLDQwTDc1LDgwTDEwMCwzMCIgc3Ryb2tlPSJyZ2JhKDEyOCwgMTI4LCAxMjgsIDAuMDUpIiBzdHJva2Utd2lkdGg9IiBmaWxsPSJub25lIiBmaWxsLW9wYWNpdHk9IjAuMSIvPjwvc3ZnPg==')] bg-repeat-x bg-top bg-cover opacity-20"></div>
    <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-apex-dark mb-4">ApexCore Platform</h1>
        <p class="text-xl text-apex-gray-600">
            Web-Based, Multi-Branch, Multi-Tenant Core Banking Platform
        </p>
    </div>
</section>

<!-- Platform Features -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <div>
            <h2 class="text-3xl font-bold text-apex-dark mb-6">Transform Your Financial Operations</h2>
            <p class="text-lg text-apex-gray-600 mb-6">
                ApexCore is a comprehensive, web-based core banking platform designed specifically for microfinance institutions, SACCOs, and banks. Built with modern technology and industry best practices, it enables financial institutions to scale efficiently while maintaining security and compliance.
            </p>
            <ul class="space-y-4">
                <li class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-apex-orange/10 flex items-center justify-center mr-3 mt-1">
                        <svg class="h-4 w-4 text-apex-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-apex-gray-600"><strong>Multi-Tenant Architecture:</strong> Securely serve multiple clients or branches on a single platform</span>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-apex-orange/10 flex items-center justify-center mr-3 mt-1">
                        <svg class="h-4 w-4 text-apex-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-apex-gray-600"><strong>Web-Based Interface:</strong> Accessible from anywhere with modern, responsive design</span>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-apex-orange/10 flex items-center justify-center mr-3 mt-1">
                        <svg class="h-4 w-4 text-apex-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-apex-gray-600"><strong>Modular Design:</strong> Flexible modules that can be customized to your specific needs</span>
                </li>
                <li class="flex items-start">
                    <div class="flex-shrink-0 h-6 w-6 rounded-full bg-apex-orange/10 flex items-center justify-center mr-3 mt-1">
                        <svg class="h-4 w-4 text-apex-orange" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <span class="text-apex-gray-600"><strong>Security Focused:</strong> Enterprise-grade security with role-based access controls</span>
                </li>
            </ul>
        </div>
        <div class="bg-white rounded-xl shadow-lg p-6 border border-apex-gray-200">
            <div class="aspect-w-16 aspect-h-9 bg-gradient-to-br from-apex-orange/10 to-apex-blue/10 rounded-lg flex items-center justify-center p-8">
                <div class="text-center">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-apex-orange/10 mb-4">
                        <svg class="w-8 h-8 text-apex-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-apex-dark mb-2">ApexCore Platform</h3>
                    <p class="text-apex-gray-600">Secure, scalable, and compliant core banking solution</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Platform Capabilities -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <h2 class="text-3xl font-bold text-center text-apex-dark mb-12">Platform Capabilities</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        <div class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-bold text-apex-dark mb-3">Customer Management</h3>
            <p class="text-apex-gray-600 mb-4">Comprehensive client onboarding, KYC, and relationship management.</p>
        </div>
        
        <div class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-bold text-apex-dark mb-3">Account Management</h3>
            <p class="text-apex-gray-600 mb-4">Multi-product accounts with flexible savings and deposit options.</p>
        </div>
        
        <div class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-bold text-apex-dark mb-3">Loan Processing</h3>
            <p class="text-apex-gray-600 mb-4">End-to-end loan origination, disbursement, and repayment management.</p>
        </div>
        
        <div class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-bold text-apex-dark mb-3">Payment Processing</h3>
            <p class="text-apex-gray-600 mb-4">Real-time payments, transfers, and collections across multiple channels.</p>
        </div>
        
        <div class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-bold text-apex-dark mb-3">Reporting & Analytics</h3>
            <p class="text-apex-gray-600 mb-4">Comprehensive reporting with customizable dashboards and analytics.</p>
        </div>
        
        <div class="rounded-xl border border-apex-gray-200 p-6 hover:border-apex-orange hover:shadow-lg transition-all duration-300">
            <h3 class="text-xl font-bold text-apex-dark mb-3">Compliance</h3>
            <p class="text-apex-gray-600 mb-4">Built-in regulatory compliance and audit trail capabilities.</p>
        </div>
    </div>
</div>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-apex-orange/5 to-apex-blue/5 rounded-2xl border border-apex-gray-100 mx-4 my-16 p-8">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-apex-dark mb-4">Ready to Transform Your Institution?</h2>
        <p class="text-apex-gray-600 mb-8">
            Experience the power of ApexCore for yourself with a personalized demonstration.
        </p>
        <a href="<?php echo esc_url(home_url('/request-demo')); ?>" class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-8 py-4 text-lg font-bold text-white shadow-md hover:shadow-lg transition-all duration-200">
            Request Your Demo
        </a>
    </div>
</section>

<?php get_footer(); ?>