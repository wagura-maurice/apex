<?php 
/**
 * Front Page Template
 * Uses modular component system for clean separation of concerns
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Hero Section Component
apex_render_hero([
    'slides' => [
        [
            'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=1920',
            'heading' => 'Launch Your Digital Bank of the Future',
            'subheading' => 'Power your winning neobank strategy with ApexCore – the web-based, multi-tenant core banking platform built for MFIs, SACCOs, and banks.',
            'alt' => 'Digital Core Banking Platform'
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1920',
            'heading' => 'Omnichannel Banking Made Simple',
            'subheading' => 'Deliver mobile apps, USSD, and web banking experiences that share workflows, limits, and risk rules across every touchpoint.',
            'alt' => 'Omnichannel Banking Solutions'
        ],
        [
            'image' => 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=1920',
            'heading' => 'Extend Your Reach with Agent Banking',
            'subheading' => 'Equip staff and agents with offline-ready apps for onboarding, KYC, collections, and monitoring—safely synced into your core.',
            'alt' => 'Agent Banking Solutions'
        ]
    ],
    'tagline' => 'ApexCore Platform',
    'cta_primary' => [
        'text' => 'Explore the Platform',
        'url' => home_url('/request-demo')
    ],
    'cta_secondary' => [
        'text' => 'View Solutions',
        'url' => home_url('/solutions')
    ],
    'banner_text' => 'Apex Softwares\' technology solutions impact <strong>100+ financial institutions</strong> across Africa.',
    'banner_link' => [
        'text' => 'Learn More',
        'url' => home_url('/about-us')
    ]
]);
?>

<?php 
// Who We Are Section Component
apex_render_who_we_are([
    'badge' => 'Who We Are',
    'heading' => 'Pioneering Digital Financial Solutions Across Africa',
    'description' => 'Apex Softwares is a leading financial technology company dedicated to transforming how financial institutions operate. With over a decade of experience, we deliver innovative, scalable, and secure solutions that empower banks, MFIs, and SACCOs to thrive in the digital age.',
    'features' => [
        [
            'icon' => 'shield',
            'title' => 'Trusted Partner',
            'text' => '100+ financial institutions rely on our platform'
        ],
        [
            'icon' => 'globe',
            'title' => 'Pan-African Reach',
            'text' => 'Operating across 15+ countries in Africa'
        ],
        [
            'icon' => 'award',
            'title' => 'Industry Leader',
            'text' => 'Award-winning fintech solutions since 2010'
        ]
    ],
    'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800',
    'cta' => [
        'text' => 'Learn More About Us',
        'url' => home_url('/about-us')
    ]
]);
?>

<?php 
// What We Do Section Component
apex_render_what_we_do([
    'badge' => 'What We Do',
    'heading' => 'Comprehensive Financial Technology Solutions',
    'description' => 'We provide end-to-end digital banking solutions that transform how financial institutions serve their customers.',
    'services' => [
        [
            'icon' => 'database',
            'title' => 'Core Banking System',
            'description' => 'A robust, scalable core banking platform that handles deposits, loans, payments, and accounting with real-time processing.',
            'link' => '/solutions/core-banking',
            'color' => 'blue'
        ],
        [
            'icon' => 'smartphone',
            'title' => 'Mobile Banking',
            'description' => 'Native mobile applications for iOS and Android with biometric authentication, instant transfers, and bill payments.',
            'link' => '/solutions/mobile-banking',
            'color' => 'orange'
        ],
        [
            'icon' => 'users',
            'title' => 'Agent Banking',
            'description' => 'Extend your reach with agent networks. Enable cash-in, cash-out, account opening, and loan collections.',
            'link' => '/solutions/agent-banking',
            'color' => 'green'
        ],
        [
            'icon' => 'credit-card',
            'title' => 'Payment Gateway',
            'description' => 'Secure payment processing with support for cards, mobile money, bank transfers, and QR payments.',
            'link' => '/solutions/payments',
            'color' => 'purple'
        ],
        [
            'icon' => 'bar-chart',
            'title' => 'Analytics & Reporting',
            'description' => 'Real-time dashboards, regulatory reports, and business intelligence tools for data-driven decisions.',
            'link' => '/solutions/analytics',
            'color' => 'cyan'
        ],
        [
            'icon' => 'shield',
            'title' => 'Risk & Compliance',
            'description' => 'AML/KYC compliance, fraud detection, credit scoring, and regulatory reporting automation.',
            'link' => '/solutions/compliance',
            'color' => 'red'
        ]
    ],
    'cta' => [
        'text' => 'Explore All Solutions',
        'url' => home_url('/solutions')
    ]
]);
?>

<?php 
// How We Do It Section Component
apex_render_how_we_do_it([
    'badge' => 'How We Do It',
    'heading' => 'Our Proven Implementation Approach',
    'description' => 'We follow a structured methodology that ensures successful deployments, minimal disruption, and maximum value for your institution.',
    'steps' => [
        [
            'number' => '01',
            'title' => 'Discovery & Assessment',
            'description' => 'We analyze your current systems, processes, and requirements to create a tailored implementation roadmap.',
            'icon' => 'search',
            'duration' => '2-4 Weeks'
        ],
        [
            'number' => '02',
            'title' => 'Solution Design',
            'description' => 'Our architects design a customized solution that integrates seamlessly with your existing infrastructure.',
            'icon' => 'layout',
            'duration' => '3-6 Weeks'
        ],
        [
            'number' => '03',
            'title' => 'Development & Configuration',
            'description' => 'We configure the platform to your specifications and develop any custom modules required.',
            'icon' => 'code',
            'duration' => '6-12 Weeks'
        ],
        [
            'number' => '04',
            'title' => 'Testing & Training',
            'description' => 'Rigorous testing ensures quality while comprehensive training prepares your team for success.',
            'icon' => 'check-circle',
            'duration' => '4-6 Weeks'
        ],
        [
            'number' => '05',
            'title' => 'Go-Live & Support',
            'description' => 'We ensure a smooth launch with dedicated support and continuous optimization post-deployment.',
            'icon' => 'rocket',
            'duration' => 'Ongoing'
        ]
    ],
    'cta' => [
        'text' => 'Start Your Journey',
        'url' => home_url('/contact')
    ]
]);
?>

<?php 
// Statistics Counter Section Component
apex_render_statistics([
    'heading' => 'Powering Financial Institutions Across Africa',
    'subheading' => 'Our platform processes millions of transactions daily, serving customers across the continent.',
    'stats' => [
        [
            'value' => 100,
            'suffix' => '+',
            'label' => 'Financial Institutions',
            'icon' => 'building'
        ],
        [
            'value' => 15,
            'suffix' => '+',
            'label' => 'Countries Served',
            'icon' => 'globe'
        ],
        [
            'value' => 5,
            'suffix' => 'M+',
            'label' => 'Active Users',
            'icon' => 'users'
        ],
        [
            'value' => 99.9,
            'suffix' => '%',
            'label' => 'Uptime SLA',
            'icon' => 'shield'
        ]
    ],
    'background_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920'
]);
?>

<?php 
// Testimonials Section Component
apex_render_testimonials([
    'badge' => 'Client Success Stories',
    'heading' => 'Trusted by Leading Financial Institutions',
    'description' => 'See what our clients say about transforming their operations with ApexCore.',
    'testimonials' => [
        [
            'quote' => 'ApexCore has revolutionized our operations. We\'ve seen a 40% increase in efficiency and our customers love the new mobile banking experience.',
            'author' => 'James Mwangi',
            'position' => 'CEO',
            'company' => 'Unity SACCO',
            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=150',
            'rating' => 5
        ],
        [
            'quote' => 'The implementation was smooth and the support team is exceptional. We went live in just 12 weeks with zero downtime.',
            'author' => 'Sarah Ochieng',
            'position' => 'CTO',
            'company' => 'Premier MFI',
            'image' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=150',
            'rating' => 5
        ],
        [
            'quote' => 'The agent banking module has helped us reach rural communities we couldn\'t serve before. Our customer base has grown by 60%.',
            'author' => 'David Kimani',
            'position' => 'Operations Director',
            'company' => 'Heritage Bank',
            'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=150',
            'rating' => 5
        ],
        [
            'quote' => 'Real-time reporting and analytics have transformed how we make decisions. We now have complete visibility into our operations.',
            'author' => 'Grace Wanjiku',
            'position' => 'Finance Manager',
            'company' => 'Faulu Microfinance',
            'image' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=150',
            'rating' => 5
        ]
    ]
]);
?>

<?php 
// Partners Section Component
apex_render_partners([
    'badge' => 'Our Partners',
    'heading' => 'Trusted Technology & Integration Partners',
    'description' => 'We collaborate with leading technology providers to deliver comprehensive solutions.',
    'cta' => [
        'text' => 'Become a Partner',
        'url' => home_url('/partners')
    ]
]);
?>

<?php 
// Solutions Detail Component - Technical Specifications & Comparisons
apex_render_solutions_detail();
?>

<?php 
// ROI Calculator Component - Interactive Investment Calculator
apex_render_roi_calculator([
    'badge' => 'ROI Calculator',
    'heading' => 'Calculate Your Return on Investment',
    'description' => 'See how ApexCore can transform your financial institution\'s efficiency and profitability.',
    'cta' => [
        'text' => 'Get Detailed Analysis',
        'url' => home_url('/contact')
    ]
]);
?>

<?php 
// Case Studies Component - Client Success Stories
apex_render_case_studies([
    'badge' => 'Case Studies',
    'heading' => 'Real Results from Real Clients',
    'description' => 'Discover how financial institutions across Africa have transformed their operations with ApexCore.',
    'cta' => [
        'text' => 'View All Case Studies',
        'url' => home_url('/case-studies')
    ]
]);
?>

<?php 
// API Integration Component - Developer Platform
apex_render_api_integration([
    'badge' => 'Developer Platform',
    'heading' => 'Powerful API & Integration Capabilities',
    'description' => 'Build custom solutions with our comprehensive REST APIs, webhooks, and SDKs. Connect ApexCore to your existing systems seamlessly.',
    'cta' => [
        'primary' => [
            'text' => 'View API Documentation',
            'url' => home_url('/developers/api-docs')
        ],
        'secondary' => [
            'text' => 'Get API Keys',
            'url' => home_url('/developers/register')
        ]
    ]
]);
?>

<?php 
// Compliance & Security Component
apex_render_compliance([
    'badge' => 'Security & Compliance',
    'heading' => 'Enterprise-Grade Security You Can Trust',
    'description' => 'ApexCore meets the highest standards of security, privacy, and regulatory compliance required by financial institutions worldwide.',
    'cta' => [
        'text' => 'Download Security Whitepaper',
        'url' => home_url('/resources/security-whitepaper')
    ]
]);
?>

<?php 
// What's New Section Component
apex_render_whats_new([
    'badge' => "What's New",
    'heading' => 'Latest News & Insights',
    'description' => 'Stay updated with the latest developments in financial technology and Apex Softwares.',
    'posts_per_page' => 3,
    'cta' => [
        'text' => 'View All Articles',
        'url' => home_url('/blog')
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