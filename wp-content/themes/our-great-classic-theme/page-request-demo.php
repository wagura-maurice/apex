<?php
/**
 * Template Name: Request Demo Page
 * Description: Page for requesting a demo
 */

get_header(); ?>

<!-- Breadcrumb Navigation -->
<nav class="bg-apex-light py-3">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        <ol class="flex items-center space-x-2 text-sm text-apex-gray-600">
            <li><a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-apex-orange transition-colors">Home</a></li>
            <li>/</li>
            <li><a href="<?php echo esc_url(home_url('/request-demo')); ?>" class="hover:text-apex-orange transition-colors">Request Demo</a></li>
        </ol>
    </div>
</nav>

<!-- Back to Overview Link -->
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-flex items-center text-apex-orange font-medium hover:underline">
        ← Back to Home
    </a>
</div>

<!-- Hero Section with Orange Wave Background -->
<section class="relative overflow-hidden bg-gradient-to-b from-apex-orange/10 to-white py-16">
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxwYXRoIGQ9Ik0wLDUwTDI1LDcwTDUwLDQwTDc1LDgwTDEwMCwzMCIgc3Ryb2tlPSJyZ2JhKDEyOCwgMTI4LCAxMjgsIDAuMDUpIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtb3BhY2l0eT0iMC4xIi8+PC9zdmc+')] bg-repeat-x bg-top bg-cover opacity-20"></div>
    <div class="relative mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
        <h1 class="text-4xl font-bold text-apex-dark mb-4">Request a Demo</h1>
        <p class="text-xl text-apex-gray-600">
            See how ApexCore can transform your financial institution with a personalized demonstration.
        </p>
    </div>
</section>

<!-- Demo Request Content -->
<div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 py-12">
    <div class="bg-white rounded-xl shadow-lg p-8 border border-apex-gray-200">
        <h2 class="text-2xl font-bold text-apex-dark mb-6">Schedule Your Personalized Demo</h2>
        <p class="text-apex-gray-600 mb-8">
            Fill out the form below and our solutions team will contact you to schedule a personalized demonstration of ApexCore tailored to your specific needs.
        </p>
        
        <form class="space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="first-name" class="block text-sm font-medium text-apex-gray-700 mb-1">First Name</label>
                    <input type="text" id="first-name" name="first-name" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
                </div>
                
                <div>
                    <label for="last-name" class="block text-sm font-medium text-apex-gray-700 mb-1">Last Name</label>
                    <input type="text" id="last-name" name="last-name" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
                </div>
            </div>
            
            <div>
                <label for="company" class="block text-sm font-medium text-apex-gray-700 mb-1">Company</label>
                <input type="text" id="company" name="company" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
            </div>
            
            <div>
                <label for="title" class="block text-sm font-medium text-apex-gray-700 mb-1">Job Title</label>
                <input type="text" id="title" name="title" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-apex-gray-700 mb-1">Work Email</label>
                <input type="email" id="email" name="email" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
            </div>
            
            <div>
                <label for="phone" class="block text-sm font-medium text-apex-gray-700 mb-1">Phone</label>
                <input type="tel" id="phone" name="phone" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
            </div>
            
            <div>
                <label for="country" class="block text-sm font-medium text-apex-gray-700 mb-1">Country</label>
                <select id="country" name="country" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
                    <option value="">Select Country</option>
                    <option value="KE">Kenya</option>
                    <option value="UG">Uganda</option>
                    <option value="TZ">Tanzania</option>
                    <option value="RW">Rwanda</option>
                    <option value="ZA">South Africa</option>
                    <option value="NG">Nigeria</option>
                    <option value="GH">Ghana</option>
                    <option value="IN">India</option>
                    <option value="BD">Bangladesh</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div>
                <label for="organization-type" class="block text-sm font-medium text-apex-gray-700 mb-1">Organization Type</label>
                <select id="organization-type" name="organization-type" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
                    <option value="">Select Organization Type</option>
                    <option value="MFI">Microfinance Institution (MFI)</option>
                    <option value="SACCO">SACCO/Credit Union</option>
                    <option value="Bank">Commercial Bank</option>
                    <option value="Fintech">Fintech Company</option>
                    <option value="Government">Government Entity</option>
                    <option value="NGO">Non-Governmental Organization (NGO)</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            
            <div>
                <label for="solution-interest" class="block text-sm font-medium text-apex-gray-700 mb-1">Solution Interest</label>
                <div class="space-y-3">
                    <div class="flex items-center">
                        <input id="core-banking" name="solution-interest[]" type="checkbox" class="h-4 w-4 text-apex-orange focus:ring-apex-orange border-apex-gray-300 rounded">
                        <label for="core-banking" class="ml-3 block text-sm text-apex-gray-700">Core Banking & Microfinance</label>
                    </div>
                    <div class="flex items-center">
                        <input id="mobile-wallet" name="solution-interest[]" type="checkbox" class="h-4 w-4 text-apex-orange focus:ring-apex-orange border-apex-gray-300 rounded">
                        <label for="mobile-wallet" class="ml-3 block text-sm text-apex-gray-700">Mobile Wallet App</label>
                    </div>
                    <div class="flex items-center">
                        <input id="agency-banking" name="solution-interest[]" type="checkbox" class="h-4 w-4 text-apex-orange focus:ring-apex-orange border-apex-gray-300 rounded">
                        <label for="agency-banking" class="ml-3 block text-sm text-apex-gray-700">Agency & Branch Banking</label>
                    </div>
                    <div class="flex items-center">
                        <input id="internet-banking" name="solution-interest[]" type="checkbox" class="h-4 w-4 text-apex-orange focus:ring-apex-orange border-apex-gray-300 rounded">
                        <label for="internet-banking" class="ml-3 block text-sm text-apex-gray-700">Internet & Mobile Banking</label>
                    </div>
                    <div class="flex items-center">
                        <input id="loan-origination" name="solution-interest[]" type="checkbox" class="h-4 w-4 text-apex-orange focus:ring-apex-orange border-apex-gray-300 rounded">
                        <label for="loan-origination" class="ml-3 block text-sm text-apex-gray-700">Loan Origination & Workflows</label>
                    </div>
                    <div class="flex items-center">
                        <input id="all-solutions" name="solution-interest[]" type="checkbox" class="h-4 w-4 text-apex-orange focus:ring-apex-orange border-apex-gray-300 rounded">
                        <label for="all-solutions" class="ml-3 block text-sm text-apex-gray-700">All Solutions (ApexCore Platform)</label>
                    </div>
                </div>
            </div>
            
            <div>
                <label for="timeline" class="block text-sm font-medium text-apex-gray-700 mb-1">Implementation Timeline</label>
                <select id="timeline" name="timeline" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent">
                    <option value="">Select Timeline</option>
                    <option value="Immediate">Immediate (Within 3 months)</option>
                    <option value="Short-term">Short-term (3-6 months)</option>
                    <option value="Medium-term">Medium-term (6-12 months)</option>
                    <option value="Long-term">Long-term (12+ months)</option>
                    <option value="Research">Just researching</option>
                </select>
            </div>
            
            <div>
                <label for="message" class="block text-sm font-medium text-apex-gray-700 mb-1">Specific Requirements or Questions</label>
                <textarea id="message" name="message" rows="4" class="w-full rounded-lg border border-apex-gray-200 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-apex-orange focus:border-transparent" placeholder="Tell us about your specific requirements, challenges, or questions..."></textarea>
            </div>
            
            <div class="flex items-start">
                <div class="flex items-center h-5">
                    <input id="privacy-consent" name="privacy-consent" type="checkbox" class="h-4 w-4 text-apex-orange focus:ring-apex-orange border-apex-gray-300 rounded" required>
                </div>
                <div class="ml-3 text-sm">
                    <label for="privacy-consent" class="font-medium text-apex-gray-700">I agree to the <a href="<?php echo esc_url(home_url('/privacy-policy')); ?>" class="text-apex-orange hover:underline">Privacy Policy</a> and consent to Apex Softwares contacting me.</label>
                </div>
            </div>
            
            <div>
                <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg bg-gradient-to-r from-apex-orange to-apex-orange/90 px-6 py-4 text-base font-bold text-white shadow-md hover:shadow-lg transition-all duration-200">
                    Request Demo
                </button>
            </div>
        </form>
    </div>
</div>

<!-- CTA Section -->
<section class="bg-gradient-to-r from-apex-orange/5 to-apex-blue/5 rounded-2xl border border-apex-gray-100 mx-4 my-16 p-8">
    <div class="max-w-3xl mx-auto text-center">
        <h2 class="text-3xl font-bold text-apex-dark mb-4">Have Questions?</h2>
        <p class="text-apex-gray-600 mb-8">
            Not ready to request a demo? Contact our team to learn more about our solutions.
        </p>
        <a href="<?php echo esc_url(home_url('/contact')); ?>" class="inline-flex items-center justify-center rounded-lg border border-apex-orange bg-white px-8 py-4 text-lg font-bold text-apex-orange hover:bg-apex-orange hover:text-white transition-all duration-200">
            Contact Sales
        </a>
    </div>
</section>

<?php get_footer(); ?>