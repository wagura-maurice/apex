<?php 
/**
 * Template Name: About Us Overview
 * About Us Overview Page Template
 * Uses modular component system for clean separation of concerns
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// About Hero Section Component
apex_render_about_hero([
    'badge' => 'About Apex Softwares',
    'heading' => 'Transforming Financial Services Across Africa',
    'description' => 'For over a decade, we\'ve been at the forefront of financial technology innovation, empowering institutions to deliver exceptional digital experiences.',
    'stats' => [
        ['value' => '100+', 'label' => 'Financial Institutions'],
        ['value' => '15+', 'label' => 'Countries'],
        ['value' => '10M+', 'label' => 'End Users'],
        ['value' => '14+', 'label' => 'Years Experience']
    ],
    'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200'
]);
?>

<?php 
// Company Story Component
apex_render_company_story([
    'badge' => 'Our Story',
    'heading' => 'From Vision to Reality',
    'content' => [
        'Founded in 2010, Apex Softwares began with a simple yet powerful vision: to democratize access to modern banking technology across Africa. What started as a small team of passionate developers has grown into a leading fintech company serving over 100 financial institutions.',
        'Our journey has been defined by a relentless focus on innovation, customer success, and the belief that every financial institution—regardless of size—deserves access to world-class technology.',
        'Today, we continue to push boundaries, developing solutions that help our partners reach more customers, reduce costs, and compete effectively in an increasingly digital world.'
    ],
    'milestones' => [
        ['year' => '2010', 'title' => 'Company Founded', 'description' => 'Started with a vision to transform African banking'],
        ['year' => '2013', 'title' => 'First Major Client', 'description' => 'Deployed ApexCore to our first SACCO partner'],
        ['year' => '2016', 'title' => 'Mobile Banking Launch', 'description' => 'Introduced mobile and agent banking solutions'],
        ['year' => '2019', 'title' => 'Pan-African Expansion', 'description' => 'Extended operations to 10+ African countries'],
        ['year' => '2022', 'title' => '100+ Clients Milestone', 'description' => 'Reached 100 financial institution partners'],
        ['year' => '2024', 'title' => 'Next-Gen Platform', 'description' => 'Launched cloud-native ApexCore 3.0']
    ]
]);
?>

<?php 
// Mission & Vision Component
apex_render_mission_vision([
    'mission' => [
        'title' => 'Our Mission',
        'description' => 'To empower financial institutions with innovative, accessible, and secure technology solutions that drive financial inclusion and economic growth across Africa.',
        'icon' => 'target'
    ],
    'vision' => [
        'title' => 'Our Vision',
        'description' => 'To be the leading financial technology partner in Africa, enabling every institution to deliver world-class digital banking experiences to their customers.',
        'icon' => 'eye'
    ],
    'values' => [
        [
            'icon' => 'lightbulb',
            'title' => 'Innovation',
            'description' => 'We continuously push boundaries to deliver cutting-edge solutions that anticipate market needs.'
        ],
        [
            'icon' => 'handshake',
            'title' => 'Partnership',
            'description' => 'We succeed when our clients succeed. Their growth is our primary measure of success.'
        ],
        [
            'icon' => 'shield',
            'title' => 'Integrity',
            'description' => 'We operate with transparency, honesty, and the highest ethical standards in everything we do.'
        ],
        [
            'icon' => 'users',
            'title' => 'Customer Focus',
            'description' => 'Every decision we make is guided by how it will benefit our clients and their customers.'
        ],
        [
            'icon' => 'rocket',
            'title' => 'Excellence',
            'description' => 'We strive for excellence in our products, services, and every interaction with stakeholders.'
        ],
        [
            'icon' => 'heart',
            'title' => 'Impact',
            'description' => 'We measure our success by the positive impact we create for communities across Africa.'
        ]
    ]
]);
?>

<?php 
// Leadership Team Component
apex_render_leadership_team([
    'badge' => 'Leadership',
    'heading' => 'Meet Our Team',
    'description' => 'Our leadership team brings together decades of experience in financial technology, banking, and software development.',
    'team' => [
        [
            'name' => 'John Kamau',
            'role' => 'Chief Executive Officer',
            'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400',
            'bio' => 'With 20+ years in fintech, John leads our vision to transform African banking.',
            'linkedin' => '#',
            'twitter' => '#'
        ],
        [
            'name' => 'Sarah Ochieng',
            'role' => 'Chief Technology Officer',
            'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400',
            'bio' => 'Sarah drives our technology strategy and product innovation initiatives.',
            'linkedin' => '#',
            'twitter' => '#'
        ],
        [
            'name' => 'Michael Njoroge',
            'role' => 'Chief Operations Officer',
            'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400',
            'bio' => 'Michael ensures operational excellence across all our client implementations.',
            'linkedin' => '#',
            'twitter' => '#'
        ],
        [
            'name' => 'Grace Wanjiku',
            'role' => 'Chief Financial Officer',
            'image' => 'https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400',
            'bio' => 'Grace oversees our financial strategy and sustainable growth initiatives.',
            'linkedin' => '#',
            'twitter' => '#'
        ]
    ]
]);
?>

<?php 
// Global Presence Component
apex_render_global_presence([
    'badge' => 'Our Reach',
    'heading' => 'Pan-African Presence',
    'description' => 'From our headquarters in Nairobi, we serve financial institutions across the African continent.',
    'regions' => [
        [
            'name' => 'East Africa',
            'countries' => ['Kenya', 'Uganda', 'Tanzania', 'Rwanda', 'Ethiopia'],
            'clients' => '60+'
        ],
        [
            'name' => 'West Africa',
            'countries' => ['Nigeria', 'Ghana', 'Senegal', 'Ivory Coast'],
            'clients' => '25+'
        ],
        [
            'name' => 'Southern Africa',
            'countries' => ['South Africa', 'Zambia', 'Zimbabwe', 'Malawi'],
            'clients' => '15+'
        ],
        [
            'name' => 'Central Africa',
            'countries' => ['DRC', 'Cameroon'],
            'clients' => '5+'
        ]
    ],
    'headquarters' => [
        'city' => 'Nairobi',
        'country' => 'Kenya',
        'address' => 'Westlands Business Park, 4th Floor'
    ]
]);
?>

<?php get_footer(); ?>
