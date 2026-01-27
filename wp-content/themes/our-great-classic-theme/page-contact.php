<?php
/**
 * Template Name: Contact Page
 * Description: Contact page with contact form
 */

get_header(); ?>

<!-- Breadcrumb Navigation -->
<nav class="bg-apex-light py-3">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-apex-gray-600">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-apex-orange transition-colors">Home</a></li>
            <li>/</li>
            <li><a href="<?php echo esc_url(home_url('/contact')); ?>" class="hover:text-apex-orange transition-colors">Contact</a></li>
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
        <h1 class="text-4xl font-bold text-apex-dark mb-4">Contact Us</h1>
        <p class="text-xl text-apex-gray-600">
            Get in touch with our team to learn more about our solutions.
        </p>
    </div>
</section>

<!-- Contact Content -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <div>
            <h2 class="text-2xl font-bold text-apex-dark mb-6">Get in Touch</h2>
            <p class="text-apex-gray-600 mb-8">
                Have questions about our solutions? Want to schedule a demo? Our team is ready to help you transform your financial institution with our cutting-edge technology.
            </p>
            
            <div class="space-y-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-apex-orange/10 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-apex-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-apex-dark">Phone</h3>
                        <p class="text-apex-gray-600">+1 (555) 123-4567</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-apex-orange/10 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-apex-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-apex-dark">Email</h3>
                        <p class="text-apex-gray-600">info@apex-softwares.com</p>
                    </div>
                </div>
                
                <div class="flex items-start">
                    <div class="flex-shrink-0 h-12 w-12 rounded-full bg-apex-orange/10 flex items-center justify-center mr-4">
                        <svg class="h-6 w-6 text-apex-orange" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-apex-dark">Office</h3>
                        <p class="text-apex-gray-600">123 Tech Avenue<br>Nairobi, Kenya</p>
                    </div>
                </div>
            </div>
            
            <div class="mt-8">
                <h3 class="text-lg font-bold text-apex-dark mb-4">Business Hours</h3>
                <ul class="space-y-2 text-apex-gray-600">
                    <li class="flex justify-between">
                        <span>Monday - Friday</span>
                        <span>8:00 AM - 6:00 PM</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Saturday</span>
                        <span>9:00 AM - 2:00 PM</span>
                    </li>
                    <li class="flex justify-between">
                        <span>Sunday</span>
                        <span>Closed</span>
                    </li>
                </ul>
            </div>
        </div>
        
        <div class="bg-white rounded-xl shadow-lg p-8 border border-apex-gray-200">
            <h2 class="text-2xl font-bold text-apex-dark mb-6">Send us a Message</h2>
            <form class="space-y-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-apex-gray-700 mb-1">Name</label>
                    <input type="text" id="name" name="name" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
                </div>
                
                <div>
                    <label for="email" class="block text-sm font-medium text-apex-gray-700 mb-1">Email</label>
                    <input type="email" id="email" name="email" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
                </div>
                
                <div>
                    <label for="phone" class="block text-sm font-medium text-apex-gray-700 mb-1">Phone</label>
                    <input type="tel" id="phone" name="phone" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
                </div>
                
                <div>
                    <label for="subject" class="block text-sm font-medium text-apex-gray-700 mb-1">Subject</label>
                    <input type="text" id="subject" name="subject" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
                </div>
                
                <div>
                    <label for="message" class="block text-sm font-medium text-apex-gray-700 mb-1">Message</label>
                    <textarea id="message" name="message" rows="4" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent"></textarea>
                </div>
                
                <div>
                    <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-6 py-4 text-base font-bold text-white shadow-md hover:shadow-lg transition-all duration-200">
                        Send Message
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-apex-orange/5 to-apex-blue/5 rounded-2xl border border-apex-gray-100 mx-4 my-16 p-8">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-apex-dark mb-4">Ready to Get Started?</h2>
        <p class="text-apex-gray-600 mb-8">
            Schedule a personalized demo to see how ApexCore can transform your financial institution.
        </p>
        <a href="<?php echo esc_url(home_url('/request-demo')); ?>" class="inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-8 py-4 text-lg font-bold text-white shadow-md hover:shadow-lg transition-all duration-200">
            Request Demo
        </a>
    </div>
</section>

<?php get_footer(); ?>