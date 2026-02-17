<?php 
/**
 * Front Page Template
 * Uses modular component system with dynamic admin-controlled content
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Dynamic Hero Section Component - Admin Controlled
$hero_slides = get_option('apex_hero_slides_home', 
    "https://images.unsplash.com/photo-1551434678-e076c223a692?w=1920 | Launch Your Digital Bank of the Future | Power your winning neobank strategy with ApexCore – the web-based, multi-tenant core banking platform built for MFIs, SACCOs, and banks. | Digital Core Banking Platform\nhttps://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1920 | Omnichannel Banking Made Simple | Deliver mobile apps, USSD, and web banking experiences that share workflows, limits, and risk rules across every touchpoint. | Omnichannel Banking Solutions\nhttps://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=1920 | Extend Your Reach with Agent Banking | Equip staff and agents with offline-ready apps for onboarding, KYC, collections, and monitoring—safely synced into your core. | Agent Banking Solutions");

$slides_array = [];
foreach (explode("\n", $hero_slides) as $slide_line) {
    $parts = explode(' | ', $slide_line);
    if (count($parts) >= 4) {
        $slides_array[] = [
            'image' => trim($parts[0]),
            'heading' => trim($parts[1]),
            'subheading' => trim($parts[2]),
            'alt' => trim($parts[3])
        ];
    }
}

apex_render_hero([
    'slides' => $slides_array,
    'tagline' => get_option('apex_hero_tagline_home', 'ApexCore Platform'),
    'cta_primary' => [
        'text' => get_option('apex_hero_cta_primary_home', 'Explore the Platform'),
        'url' => get_option('apex_hero_cta_primary_url_home', home_url('/request-demo'))
    ],
    'cta_secondary' => [
        'text' => get_option('apex_hero_cta_secondary_home', 'View Solutions'),
        'url' => get_option('apex_hero_cta_secondary_url_home', home_url('/solutions'))
    ],
    'banner_text' => get_option('apex_hero_banner_text_home', 'Apex Softwares\' technology solutions impact <strong>100+ financial institutions</strong> across Africa.'),
    'banner_link' => [
        'text' => get_option('apex_hero_banner_link_text_home', 'Learn More'),
        'url' => get_option('apex_hero_banner_link_url_home', home_url('/about-us'))
    ]
]);
?>

<?php 
// Dynamic Who We Are Section Component - Admin Controlled
$who_we_are_features = get_option('apex_who_we_are_features_home', 
    "shield | Trusted Partner | 100+ financial institutions rely on our platform\nglobe | Pan-African Reach | Operating across 15+ countries in Africa\naward | Industry Leader | Award-winning fintech solutions since 2010");

$features_array = [];
foreach (explode("\n", $who_we_are_features) as $feature_line) {
    $parts = explode(' | ', $feature_line);
    if (count($parts) >= 3) {
        $features_array[] = [
            'icon' => trim($parts[0]),
            'title' => trim($parts[1]),
            'text' => trim($parts[2])
        ];
    }
}

apex_render_who_we_are([
    'badge' => get_option('apex_who_we_are_badge_home', 'Who We Are'),
    'heading' => get_option('apex_who_we_are_heading_home', 'Pioneering Digital Financial Solutions Across Africa'),
    'description' => get_option('apex_who_we_are_description_home', 'Apex Softwares is a leading financial technology company dedicated to transforming how financial institutions operate. With over a decade of experience, we deliver innovative, scalable, and secure solutions that empower banks, MFIs, and SACCOs to thrive in the digital age.'),
    'features' => $features_array,
    'image' => get_option('apex_who_we_are_image_home', 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800'),
    'cta' => [
        'text' => get_option('apex_who_we_are_cta_text_home', 'Learn More About Us'),
        'url' => get_option('apex_who_we_are_cta_url_home', home_url('/about-us'))
    ]
]);
?>

<?php 
// Dynamic What We Do Section Component - Admin Controlled
$what_we_do_services = get_option('apex_what_we_do_services_home', 
    "database | Core Banking System | A robust, scalable core banking platform that handles deposits, loans, payments, and accounting with real-time processing. | /solutions/core-banking | blue\nsmartphone | Mobile Banking | Native mobile applications for iOS and Android with biometric authentication, instant transfers, and bill payments. | /solutions/mobile-banking | orange\nusers | Agent Banking | Extend your reach with agent networks. Enable cash-in, cash-out, account opening, and loan collections. | /solutions/agent-banking | green\ncredit-card | Payment Gateway | Secure payment processing with support for cards, mobile money, bank transfers, and QR payments. | /solutions/payments | purple\nbar-chart | Analytics & Reporting | Real-time dashboards, regulatory reports, and business intelligence tools for data-driven decisions. | /solutions/analytics | cyan\nshield | Risk & Compliance | AML/KYC compliance, fraud detection, credit scoring, and regulatory reporting automation. | /solutions/compliance | red");

$services_array = [];
foreach (explode("\n", $what_we_do_services) as $service_line) {
    $parts = explode(' | ', $service_line);
    if (count($parts) >= 5) {
        $services_array[] = [
            'icon' => trim($parts[0]),
            'title' => trim($parts[1]),
            'description' => trim($parts[2]),
            'link' => trim($parts[3]),
            'color' => trim($parts[4])
        ];
    }
}

apex_render_what_we_do([
    'badge' => get_option('apex_what_we_do_badge_home', 'What We Do'),
    'heading' => get_option('apex_what_we_do_heading_home', 'Comprehensive Financial Technology Solutions'),
    'description' => get_option('apex_what_we_do_description_home', 'We provide end-to-end digital banking solutions that transform how financial institutions serve their customers.'),
    'services' => $services_array,
    'cta' => [
        'text' => get_option('apex_what_we_do_cta_text_home', 'Explore All Solutions'),
        'url' => get_option('apex_what_we_do_cta_url_home', home_url('/solutions'))
    ]
]);
?>

<?php 
// Dynamic How We Do It Section Component - Admin Controlled
$how_we_do_it_steps = get_option('apex_how_we_do_it_steps_home', 
    "01 | Discovery & Assessment | We analyze your current systems, processes, and requirements to create a tailored implementation roadmap. | search | 2-4 Weeks\n02 | Solution Design | Our architects design a customized solution that integrates seamlessly with your existing infrastructure. | layout | 3-6 Weeks\n03 | Development & Configuration | We configure the platform to your specifications and develop any custom modules required. | code | 6-12 Weeks\n04 | Testing & Training | Rigorous testing ensures quality while comprehensive training prepares your team for success. | check-circle | 4-6 Weeks\n05 | Go-Live & Support | We ensure a smooth launch with dedicated support and continuous optimization post-deployment. | rocket | Ongoing");

$steps_array = [];
foreach (explode("\n", $how_we_do_it_steps) as $step_line) {
    $parts = explode(' | ', $step_line);
    if (count($parts) >= 5) {
        $steps_array[] = [
            'number' => trim($parts[0]),
            'title' => trim($parts[1]),
            'description' => trim($parts[2]),
            'icon' => trim($parts[3]),
            'duration' => trim($parts[4])
        ];
    }
}

apex_render_how_we_do_it([
    'badge' => get_option('apex_how_we_do_it_badge_home', 'How We Do It'),
    'heading' => get_option('apex_how_we_do_it_heading_home', 'Our Proven Implementation Approach'),
    'description' => get_option('apex_how_we_do_it_description_home', 'We follow a structured methodology that ensures successful deployments, minimal disruption, and maximum value for your institution.'),
    'steps' => $steps_array,
    'cta' => [
        'text' => get_option('apex_how_we_do_it_cta_text_home', 'Start Your Journey'),
        'url' => get_option('apex_how_we_do_it_cta_url_home', home_url('/contact'))
    ]
]);
?>

<?php 
// Dynamic Statistics Section Component - Admin Controlled
$statistics_stats = get_option('apex_statistics_stats_home', 
    "100 | + | Financial Institutions | building\n15 | + | Countries Served | globe\n5 | M+ | Active Users | users\n99.9 | % | Uptime SLA | shield");

$stats_array = [];
foreach (explode("\n", $statistics_stats) as $stat_line) {
    $parts = explode(' | ', $stat_line);
    if (count($parts) >= 4) {
        $stats_array[] = [
            'value' => is_numeric(trim($parts[0])) ? floatval(trim($parts[0])) : trim($parts[0]),
            'suffix' => trim($parts[1]),
            'label' => trim($parts[2]),
            'icon' => trim($parts[3])
        ];
    }
}

apex_render_statistics([
    'heading' => get_option('apex_statistics_heading_home', 'Powering Financial Institutions Across Africa'),
    'subheading' => get_option('apex_statistics_subheading_home', 'Our platform processes millions of transactions daily, serving customers across the continent.'),
    'stats' => $stats_array,
    'background_image' => get_option('apex_statistics_background_image_home', 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920')
]);
?>

<?php 
// Dynamic Testimonials Section Component - Admin Controlled
$testimonials_list = get_option('apex_testimonials_list_home', 
    "ApexCore has revolutionized our operations. We've seen a 40% increase in efficiency and our customers love the new mobile banking experience. | James Mwangi | CEO | Unity SACCO | https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150 | 5\nThe implementation was smooth and the support team is exceptional. We went live in just 12 weeks with zero downtime. | Sarah Ochieng | CTO | Premier MFI | https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150 | 5\nThe agent banking module has helped us reach rural communities we couldn't serve before. Our customer base has grown by 60%. | David Kimani | Operations Director | Heritage Bank | https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150 | 5\nReal-time reporting and analytics have transformed how we make decisions. We now have complete visibility into our operations. | Grace Wanjiku | Finance Manager | Faulu Microfinance | https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150 | 5");

$testimonials_array = [];
foreach (explode("\n", $testimonials_list) as $testimonial_line) {
    $parts = explode(' | ', $testimonial_line);
    if (count($parts) >= 6) {
        $testimonials_array[] = [
            'quote' => trim($parts[0]),
            'author' => trim($parts[1]),
            'position' => trim($parts[2]),
            'company' => trim($parts[3]),
            'image' => trim($parts[4]),
            'rating' => intval(trim($parts[5]))
        ];
    }
}

apex_render_testimonials([
    'badge' => get_option('apex_testimonials_badge_home', 'Client Success Stories'),
    'heading' => get_option('apex_testimonials_heading_home', 'Trusted by Leading Financial Institutions'),
    'description' => get_option('apex_testimonials_description_home', 'See what our clients say about transforming their operations with ApexCore.'),
    'testimonials' => $testimonials_array
]);
?>

<?php 
// Dynamic Partners Section Component - Admin Controlled
apex_render_partners([
    'badge' => get_option('apex_partners_badge_home', 'Our Partners'),
    'heading' => get_option('apex_partners_heading_home', 'Trusted Technology & Integration Partners'),
    'description' => get_option('apex_partners_description_home', 'We collaborate with leading technology providers to deliver comprehensive solutions.'),
    'cta' => [
        'text' => get_option('apex_partners_cta_text_home', 'Become a Partner'),
        'url' => get_option('apex_partners_cta_url_home', home_url('/partners'))
    ]
]);
?>

<?php 
// Solutions Detail Component - Technical Specifications & Comparisons
apex_render_solutions_detail();
?>

<?php 
// Dynamic ROI Calculator Component - Admin Controlled
apex_render_roi_calculator([
    'badge' => get_option('apex_roi_badge_home', 'ROI Calculator'),
    'heading' => get_option('apex_roi_heading_home', 'Calculate Your Return on Investment'),
    'description' => get_option('apex_roi_description_home', 'See how ApexCore can transform your financial institution\'s efficiency and profitability.'),
    'cta' => [
        'text' => get_option('apex_roi_cta_text_home', 'Get Detailed Analysis'),
        'url' => get_option('apex_roi_cta_url_home', home_url('/contact'))
    ]
]);
?>

<?php 
// Dynamic Case Studies Component - Admin Controlled
apex_render_case_studies([
    'badge' => get_option('apex_case_studies_badge_home', 'Case Studies'),
    'heading' => get_option('apex_case_studies_heading_home', 'Real Results from Real Clients'),
    'description' => get_option('apex_case_studies_description_home', 'Discover how financial institutions across Africa have transformed their operations with ApexCore.'),
    'cta' => [
        'text' => get_option('apex_case_studies_cta_text_home', 'View All Case Studies'),
        'url' => get_option('apex_case_studies_cta_url_home', home_url('/case-studies'))
    ]
]);
?>

<?php 
// Dynamic API Integration Component - Admin Controlled
apex_render_api_integration([
    'badge' => get_option('apex_api_badge_home', 'Developer Platform'),
    'heading' => get_option('apex_api_heading_home', 'Powerful API & Integration Capabilities'),
    'description' => get_option('apex_api_description_home', 'Build custom solutions with our comprehensive REST APIs, webhooks, and SDKs. Connect ApexCore to your existing systems seamlessly.'),
    'cta' => [
        'primary' => [
            'text' => get_option('apex_api_primary_cta_text_home', 'View API Documentation'),
            'url' => get_option('apex_api_primary_cta_url_home', home_url('/developers/api-docs'))
        ],
        'secondary' => [
            'text' => get_option('apex_api_secondary_cta_text_home', 'Get API Keys'),
            'url' => get_option('apex_api_secondary_cta_url_home', home_url('/developers/register'))
        ]
    ]
]);
?>

<?php 
// Dynamic Compliance & Security Component - Admin Controlled
apex_render_compliance([
    'badge' => get_option('apex_compliance_badge_home', 'Security & Compliance'),
    'heading' => get_option('apex_compliance_heading_home', 'Enterprise-Grade Security You Can Trust'),
    'description' => get_option('apex_compliance_description_home', 'ApexCore meets the highest standards of security, privacy, and regulatory compliance required by financial institutions worldwide.'),
    'cta' => [
        'text' => get_option('apex_compliance_cta_text_home', 'Download Security Whitepaper'),
        'url' => get_option('apex_compliance_cta_url_home', home_url('/resources/security-whitepaper'))
    ]
]);
?>

<?php 
// Dynamic What's New Section Component - Admin Controlled
apex_render_whats_new([
    'badge' => get_option('apex_whats_new_badge_home', "What's New"),
    'heading' => get_option('apex_whats_new_heading_home', 'Latest News & Insights'),
    'description' => get_option('apex_whats_new_description_home', 'Stay updated with the latest developments in financial technology and Apex Softwares.'),
    'posts_per_page' => intval(get_option('apex_whats_new_posts_per_page_home', '3')),
    'cta' => [
        'text' => get_option('apex_whats_new_cta_text_home', 'View All Articles'),
        'url' => get_option('apex_whats_new_cta_url_home', home_url('/blog'))
    ]
]);
?>

<!-- Optional: WordPress Content Area -->
<?php if (have_posts() && get_the_content()) : ?>
<main id="site-main" class="flex-1">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="site-content clearfix">
            <?php 
            while (have_posts()) : the_post();
                the_content();
            endwhile;
            ?>
        </div>
    </div>
</main>
<?php endif; ?>

<?php get_footer(); ?>