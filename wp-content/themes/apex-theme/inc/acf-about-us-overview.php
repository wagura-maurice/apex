<?php
/**
 * ACF Field Groups for About Us Overview Page
 * 
 * Registers ACF fields for the About Us Overview page hero section
 * Requires Advanced Custom Fields Pro plugin
 * 
 * @package ApexTheme
 */

if (!defined('ABSPATH')) exit;

/**
 * Register ACF Field Groups for About Us Overview Page
 */
function apex_register_about_us_overview_acf_fields() {
    
    // Check if ACF is active
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    
    // Hero Section Field Group
    acf_add_local_field_group([
        'key' => 'group_about_us_hero',
        'title' => 'Hero Section',
        'fields' => [
            // Hero Badge
            [
                'key' => 'field_about_hero_badge',
                'label' => 'Badge Text',
                'name' => 'about_hero_badge',
                'type' => 'text',
                'default_value' => 'About Apex Softwares',
                'placeholder' => 'e.g., About Apex Softwares',
                'instructions' => 'The small badge text above the heading',
            ],
            // Hero Heading
            [
                'key' => 'field_about_hero_heading',
                'label' => 'Heading',
                'name' => 'about_hero_heading',
                'type' => 'text',
                'default_value' => 'Transforming Financial Services Across Africa',
                'placeholder' => 'Main hero heading',
                'instructions' => 'The main heading for the hero section',
            ],
            // Hero Description
            [
                'key' => 'field_about_hero_description',
                'label' => 'Description',
                'name' => 'about_hero_description',
                'type' => 'textarea',
                'rows' => 4,
                'default_value' => "For over a decade, we've been at the forefront of financial technology innovation, empowering institutions to deliver exceptional digital experiences.",
                'placeholder' => 'Hero section description',
                'instructions' => 'The description text below the heading',
            ],
            // Hero Image
            [
                'key' => 'field_about_hero_image',
                'label' => 'Hero Image',
                'name' => 'about_hero_image',
                'type' => 'image',
                'return_format' => 'url',
                'preview_size' => 'medium',
                'instructions' => 'The main hero image (recommended size: 1200x800px)',
            ],
            // Stats Repeater
            [
                'key' => 'field_about_hero_stats',
                'label' => 'Statistics',
                'name' => 'about_hero_stats',
                'type' => 'repeater',
                'instructions' => 'Add statistics to display in the hero section (e.g., 100+ Financial Institutions)',
                'min' => 0,
                'max' => 6,
                'layout' => 'table',
                'button_label' => 'Add Statistic',
                'sub_fields' => [
                    [
                        'key' => 'field_about_hero_stat_value',
                        'label' => 'Value',
                        'name' => 'value',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., 100+',
                        'instructions' => 'The numeric value with suffix',
                    ],
                    [
                        'key' => 'field_about_hero_stat_label',
                        'label' => 'Label',
                        'name' => 'label',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., Financial Institutions',
                        'instructions' => 'The label describing the value',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-about-us-overview.php',
                ],
            ],
        ],
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => 'Hero section content for the About Us Overview page',
    ]);
}
add_action('acf/init', 'apex_register_about_us_overview_acf_fields');

/**
 * Register ACF Field Groups for About Us Overview Page - Additional Sections
 */
function apex_register_about_us_additional_acf_fields() {
    
    // Check if ACF is active
    if (!function_exists('acf_add_local_field_group')) {
        return;
    }
    
    // Company Story Field Group
    acf_add_local_field_group([
        'key' => 'group_company_story',
        'title' => 'Company Story Section',
        'fields' => [
            [
                'key' => 'field_company_story_badge',
                'label' => 'Badge Text',
                'name' => 'company_story_badge',
                'type' => 'text',
                'default_value' => 'Our Story',
                'placeholder' => 'e.g., Our Story',
            ],
            [
                'key' => 'field_company_story_heading',
                'label' => 'Heading',
                'name' => 'company_story_heading',
                'type' => 'text',
                'default_value' => 'From Vision to Reality',
                'placeholder' => 'Section heading',
            ],
            [
                'key' => 'field_company_story_content',
                'label' => 'Content Paragraphs',
                'name' => 'company_story_content',
                'type' => 'repeater',
                'min' => 1,
                'max' => 5,
                'layout' => 'row',
                'button_label' => 'Add Paragraph',
                'sub_fields' => [
                    [
                        'key' => 'field_company_story_paragraph',
                        'label' => 'Paragraph',
                        'name' => 'paragraph',
                        'type' => 'textarea',
                        'rows' => 3,
                        'required' => true,
                    ],
                ],
            ],
            [
                'key' => 'field_company_story_milestones',
                'label' => 'Milestones',
                'name' => 'company_story_milestones',
                'type' => 'repeater',
                'min' => 0,
                'max' => 10,
                'layout' => 'table',
                'button_label' => 'Add Milestone',
                'sub_fields' => [
                    [
                        'key' => 'field_milestone_year',
                        'label' => 'Year',
                        'name' => 'year',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., 2010',
                    ],
                    [
                        'key' => 'field_milestone_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., Company Founded',
                    ],
                    [
                        'key' => 'field_milestone_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'Brief description of the milestone',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-about-us-overview.php',
                ],
            ],
        ],
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'active' => true,
        'description' => 'Company story section with timeline milestones',
    ]);
    
    // Mission & Vision Field Group
    acf_add_local_field_group([
        'key' => 'group_mission_vision',
        'title' => 'Mission & Vision Section',
        'fields' => [
            [
                'key' => 'field_mission_title',
                'label' => 'Mission Title',
                'name' => 'mission_title',
                'type' => 'text',
                'default_value' => 'Our Mission',
                'placeholder' => 'e.g., Our Mission',
            ],
            [
                'key' => 'field_mission_description',
                'label' => 'Mission Description',
                'name' => 'mission_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'To empower financial institutions with innovative, accessible, and secure technology solutions that drive financial inclusion and economic growth across Africa.',
            ],
            [
                'key' => 'field_mission_icon',
                'label' => 'Mission Icon',
                'name' => 'mission_icon',
                'type' => 'text',
                'default_value' => 'target',
                'instructions' => 'Icon class (e.g., target, eye, lightbulb)',
            ],
            [
                'key' => 'field_vision_title',
                'label' => 'Vision Title',
                'name' => 'vision_title',
                'type' => 'text',
                'default_value' => 'Our Vision',
                'placeholder' => 'e.g., Our Vision',
            ],
            [
                'key' => 'field_vision_description',
                'label' => 'Vision Description',
                'name' => 'vision_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'To be the leading financial technology partner in Africa, enabling every institution to deliver world-class digital banking experiences to their customers.',
            ],
            [
                'key' => 'field_vision_icon',
                'label' => 'Vision Icon',
                'name' => 'vision_icon',
                'type' => 'text',
                'default_value' => 'eye',
                'instructions' => 'Icon class (e.g., target, eye, lightbulb)',
            ],
            [
                'key' => 'field_company_values',
                'label' => 'Company Values',
                'name' => 'company_values',
                'type' => 'repeater',
                'min' => 0,
                'max' => 8,
                'layout' => 'table',
                'button_label' => 'Add Value',
                'sub_fields' => [
                    [
                        'key' => 'field_value_icon',
                        'label' => 'Icon',
                        'name' => 'icon',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., lightbulb',
                        'instructions' => 'Icon identifier',
                    ],
                    [
                        'key' => 'field_value_title',
                        'label' => 'Title',
                        'name' => 'title',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., Innovation',
                    ],
                    [
                        'key' => 'field_value_description',
                        'label' => 'Description',
                        'name' => 'description',
                        'type' => 'textarea',
                        'rows' => 2,
                        'required' => true,
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-about-us-overview.php',
                ],
            ],
        ],
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'active' => true,
        'description' => 'Mission, vision and company values section',
    ]);
    
    // Leadership Team Field Group
    acf_add_local_field_group([
        'key' => 'group_leadership_team',
        'title' => 'Leadership Team Section',
        'fields' => [
            [
                'key' => 'field_leadership_badge',
                'label' => 'Badge Text',
                'name' => 'leadership_badge',
                'type' => 'text',
                'default_value' => 'Leadership',
                'placeholder' => 'e.g., Leadership',
            ],
            [
                'key' => 'field_leadership_heading',
                'label' => 'Heading',
                'name' => 'leadership_heading',
                'type' => 'text',
                'default_value' => 'Meet Our Team',
                'placeholder' => 'Section heading',
            ],
            [
                'key' => 'field_leadership_description',
                'label' => 'Description',
                'name' => 'leadership_description',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'Our leadership team brings together decades of experience in financial technology, banking, and software development.',
            ],
            [
                'key' => 'field_leadership_team',
                'label' => 'Team Members',
                'name' => 'leadership_team',
                'type' => 'repeater',
                'min' => 0,
                'max' => 12,
                'layout' => 'row',
                'button_label' => 'Add Team Member',
                'sub_fields' => [
                    [
                        'key' => 'field_team_member_name',
                        'label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., John Kamau',
                    ],
                    [
                        'key' => 'field_team_member_role',
                        'label' => 'Role/Title',
                        'name' => 'role',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., Chief Executive Officer',
                    ],
                    [
                        'key' => 'field_team_member_image',
                        'label' => 'Photo',
                        'name' => 'image',
                        'type' => 'image',
                        'return_format' => 'url',
                        'preview_size' => 'thumbnail',
                        'instructions' => 'Team member photo (recommended: 400x400px)',
                    ],
                    [
                        'key' => 'field_team_member_bio',
                        'label' => 'Short Bio',
                        'name' => 'bio',
                        'type' => 'textarea',
                        'rows' => 2,
                        'placeholder' => 'Brief biography',
                    ],
                    [
                        'key' => 'field_team_member_linkedin',
                        'label' => 'LinkedIn URL',
                        'name' => 'linkedin',
                        'type' => 'url',
                        'placeholder' => 'https://linkedin.com/in/...',
                    ],
                    [
                        'key' => 'field_team_member_twitter',
                        'label' => 'Twitter/X URL',
                        'name' => 'twitter',
                        'type' => 'url',
                        'placeholder' => 'https://twitter.com/...',
                    ],
                ],
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-about-us-overview.php',
                ],
            ],
        ],
        'menu_order' => 3,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'active' => true,
        'description' => 'Leadership team members section',
    ]);
    
    // Global Presence Field Group
    acf_add_local_field_group([
        'key' => 'group_global_presence',
        'title' => 'Global Presence Section',
        'fields' => [
            [
                'key' => 'field_global_badge',
                'label' => 'Badge Text',
                'name' => 'global_badge',
                'type' => 'text',
                'default_value' => 'Our Reach',
                'placeholder' => 'e.g., Our Reach',
            ],
            [
                'key' => 'field_global_heading',
                'label' => 'Heading',
                'name' => 'global_heading',
                'type' => 'text',
                'default_value' => 'Pan-African Presence',
                'placeholder' => 'Section heading',
            ],
            [
                'key' => 'field_global_description',
                'label' => 'Description',
                'name' => 'global_description',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'From our headquarters in Nairobi, we serve financial institutions across the African continent.',
            ],
            [
                'key' => 'field_global_regions',
                'label' => 'Regions',
                'name' => 'global_regions',
                'type' => 'repeater',
                'min' => 0,
                'max' => 8,
                'layout' => 'row',
                'button_label' => 'Add Region',
                'sub_fields' => [
                    [
                        'key' => 'field_region_name',
                        'label' => 'Region Name',
                        'name' => 'name',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., East Africa',
                    ],
                    [
                        'key' => 'field_region_countries',
                        'label' => 'Countries',
                        'name' => 'countries',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., Kenya, Uganda, Tanzania',
                        'instructions' => 'Comma-separated list of countries',
                    ],
                    [
                        'key' => 'field_region_clients',
                        'label' => 'Clients Count',
                        'name' => 'clients',
                        'type' => 'text',
                        'required' => true,
                        'placeholder' => 'e.g., 60+',
                    ],
                ],
            ],
            [
                'key' => 'field_global_headquarters_city',
                'label' => 'Headquarters City',
                'name' => 'global_headquarters_city',
                'type' => 'text',
                'default_value' => 'Nairobi',
                'placeholder' => 'e.g., Nairobi',
            ],
            [
                'key' => 'field_global_headquarters_country',
                'label' => 'Headquarters Country',
                'name' => 'global_headquarters_country',
                'type' => 'text',
                'default_value' => 'Kenya',
                'placeholder' => 'e.g., Kenya',
            ],
            [
                'key' => 'field_global_headquarters_address',
                'label' => 'Headquarters Address',
                'name' => 'global_headquarters_address',
                'type' => 'text',
                'default_value' => 'Westlands Business Park, 4th Floor',
                'placeholder' => 'Full address',
            ],
        ],
        'location' => [
            [
                [
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-about-us-overview.php',
                ],
            ],
        ],
        'menu_order' => 4,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'active' => true,
        'description' => 'Global presence and regional offices section',
    ]);
}
add_action('acf/init', 'apex_register_about_us_additional_acf_fields');

/**
 * Helper function to get hero data with fallbacks
 * 
 * @return array Hero data with all fields
 */
function apex_get_about_hero_data() {
    $defaults = [
        'badge' => 'About Apex Softwares',
        'heading' => 'Transforming Financial Services Across Africa',
        'description' => "For over a decade, we've been at the forefront of financial technology innovation, empowering institutions to deliver exceptional digital experiences.",
        'stats' => [
            ['value' => '100+', 'label' => 'Financial Institutions'],
            ['value' => '15+', 'label' => 'Countries'],
            ['value' => '10M+', 'label' => 'End Users'],
            ['value' => '14+', 'label' => 'Years Experience']
        ],
        'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200'
    ];
    
    // Check if ACF is available
    if (!function_exists('get_field')) {
        return $defaults;
    }
    
    // Get ACF fields
    $badge = get_field('about_hero_badge');
    $heading = get_field('about_hero_heading');
    $description = get_field('about_hero_description');
    $image = get_field('about_hero_image');
    $stats = get_field('about_hero_stats');
    
    // Build stats array from repeater
    $stats_array = [];
    if ($stats && is_array($stats)) {
        foreach ($stats as $stat) {
            $stats_array[] = [
                'value' => $stat['value'] ?? '',
                'label' => $stat['label'] ?? ''
            ];
        }
    }
    
    // If no stats from ACF, use defaults
    if (empty($stats_array)) {
        $stats_array = $defaults['stats'];
    }
    
    return [
        'badge' => $badge ?: $defaults['badge'],
        'heading' => $heading ?: $defaults['heading'],
        'description' => $description ?: $defaults['description'],
        'stats' => $stats_array,
        'image' => $image ?: $defaults['image']
    ];
}

/**
 * Helper function to get company story data with fallbacks
 * 
 * @return array Company story data with all fields
 */
function apex_get_company_story_data() {
    $defaults = [
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
    ];
    
    // Check if ACF is available
    if (!function_exists('get_field')) {
        return $defaults;
    }
    
    // Get ACF fields
    $badge = get_field('company_story_badge');
    $heading = get_field('company_story_heading');
    $content = get_field('company_story_content');
    $milestones = get_field('company_story_milestones');
    
    // Build content array from repeater
    $content_array = [];
    if ($content && is_array($content)) {
        foreach ($content as $item) {
            if (!empty($item['paragraph'])) {
                $content_array[] = $item['paragraph'];
            }
        }
    }
    
    // Build milestones array from repeater
    $milestones_array = [];
    if ($milestones && is_array($milestones)) {
        foreach ($milestones as $milestone) {
            $milestones_array[] = [
                'year' => $milestone['year'] ?? '',
                'title' => $milestone['title'] ?? '',
                'description' => $milestone['description'] ?? ''
            ];
        }
    }
    
    // If no content from ACF, use defaults
    if (empty($content_array)) {
        $content_array = $defaults['content'];
    }
    
    // If no milestones from ACF, use defaults
    if (empty($milestones_array)) {
        $milestones_array = $defaults['milestones'];
    }
    
    return [
        'badge' => $badge ?: $defaults['badge'],
        'heading' => $heading ?: $defaults['heading'],
        'content' => $content_array,
        'milestones' => $milestones_array
    ];
}

/**
 * Helper function to get mission and vision data with fallbacks
 * 
 * @return array Mission, vision and values data
 */
function apex_get_mission_vision_data() {
    $defaults = [
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
            ['icon' => 'lightbulb', 'title' => 'Innovation', 'description' => 'We continuously push boundaries to deliver cutting-edge solutions that anticipate market needs.'],
            ['icon' => 'handshake', 'title' => 'Partnership', 'description' => 'We succeed when our clients succeed. Their growth is our primary measure of success.'],
            ['icon' => 'shield', 'title' => 'Integrity', 'description' => 'We operate with transparency, honesty, and the highest ethical standards in everything we do.'],
            ['icon' => 'users', 'title' => 'Customer Focus', 'description' => 'Every decision we make is guided by how it will benefit our clients and their customers.'],
            ['icon' => 'rocket', 'title' => 'Excellence', 'description' => 'We strive for excellence in our products, services, and every interaction with stakeholders.'],
            ['icon' => 'heart', 'title' => 'Impact', 'description' => 'We measure our success by the positive impact we create for communities across Africa.']
        ]
    ];
    
    // Check if ACF is available
    if (!function_exists('get_field')) {
        return $defaults;
    }
    
    // Get ACF fields
    $mission_title = get_field('mission_title');
    $mission_description = get_field('mission_description');
    $mission_icon = get_field('mission_icon');
    $vision_title = get_field('vision_title');
    $vision_description = get_field('vision_description');
    $vision_icon = get_field('vision_icon');
    $company_values = get_field('company_values');
    
    // Build values array from repeater
    $values_array = [];
    if ($company_values && is_array($company_values)) {
        foreach ($company_values as $value) {
            $values_array[] = [
                'icon' => $value['icon'] ?? '',
                'title' => $value['title'] ?? '',
                'description' => $value['description'] ?? ''
            ];
        }
    }
    
    // If no values from ACF, use defaults
    if (empty($values_array)) {
        $values_array = $defaults['values'];
    }
    
    return [
        'mission' => [
            'title' => $mission_title ?: $defaults['mission']['title'],
            'description' => $mission_description ?: $defaults['mission']['description'],
            'icon' => $mission_icon ?: $defaults['mission']['icon']
        ],
        'vision' => [
            'title' => $vision_title ?: $defaults['vision']['title'],
            'description' => $vision_description ?: $defaults['vision']['description'],
            'icon' => $vision_icon ?: $defaults['vision']['icon']
        ],
        'values' => $values_array
    ];
}

/**
 * Helper function to get leadership team data with fallbacks
 * 
 * @return array Leadership team data
 */
function apex_get_leadership_team_data() {
    $defaults = [
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
    ];
    
    // Check if ACF is available
    if (!function_exists('get_field')) {
        return $defaults;
    }
    
    // Get ACF fields
    $badge = get_field('leadership_badge');
    $heading = get_field('leadership_heading');
    $description = get_field('leadership_description');
    $team = get_field('leadership_team');
    
    // Build team array from repeater
    $team_array = [];
    if ($team && is_array($team)) {
        foreach ($team as $member) {
            $team_array[] = [
                'name' => $member['name'] ?? '',
                'role' => $member['role'] ?? '',
                'image' => $member['image'] ?? '',
                'bio' => $member['bio'] ?? '',
                'linkedin' => $member['linkedin'] ?: '#',
                'twitter' => $member['twitter'] ?: '#'
            ];
        }
    }
    
    // If no team from ACF, use defaults
    if (empty($team_array)) {
        $team_array = $defaults['team'];
    }
    
    return [
        'badge' => $badge ?: $defaults['badge'],
        'heading' => $heading ?: $defaults['heading'],
        'description' => $description ?: $defaults['description'],
        'team' => $team_array
    ];
}

/**
 * Helper function to get global presence data with fallbacks
 * 
 * @return array Global presence data
 */
function apex_get_global_presence_data() {
    $defaults = [
        'badge' => 'Our Reach',
        'heading' => 'Pan-African Presence',
        'description' => 'From our headquarters in Nairobi, we serve financial institutions across the African continent.',
        'regions' => [
            ['name' => 'East Africa', 'countries' => ['Kenya', 'Uganda', 'Tanzania', 'Rwanda', 'Ethiopia'], 'clients' => '60+'],
            ['name' => 'West Africa', 'countries' => ['Nigeria', 'Ghana', 'Senegal', 'Ivory Coast'], 'clients' => '25+'],
            ['name' => 'Southern Africa', 'countries' => ['South Africa', 'Zambia', 'Zimbabwe', 'Malawi'], 'clients' => '15+'],
            ['name' => 'Central Africa', 'countries' => ['DRC', 'Cameroon'], 'clients' => '5+']
        ],
        'headquarters' => [
            'city' => 'Nairobi',
            'country' => 'Kenya',
            'address' => 'Westlands Business Park, 4th Floor'
        ]
    ];
    
    // Check if ACF is available
    if (!function_exists('get_field')) {
        return $defaults;
    }
    
    // Get ACF fields
    $badge = get_field('global_badge');
    $heading = get_field('global_heading');
    $description = get_field('global_description');
    $regions = get_field('global_regions');
    $hq_city = get_field('global_headquarters_city');
    $hq_country = get_field('global_headquarters_country');
    $hq_address = get_field('global_headquarters_address');
    
    // Build regions array from repeater
    $regions_array = [];
    if ($regions && is_array($regions)) {
        foreach ($regions as $region) {
            $countries_string = $region['countries'] ?? '';
            $countries_array = array_map('trim', explode(',', $countries_string));
            $regions_array[] = [
                'name' => $region['name'] ?? '',
                'countries' => $countries_array,
                'clients' => $region['clients'] ?? ''
            ];
        }
    }
    
    // If no regions from ACF, use defaults
    if (empty($regions_array)) {
        $regions_array = $defaults['regions'];
    }
    
    return [
        'badge' => $badge ?: $defaults['badge'],
        'heading' => $heading ?: $defaults['heading'],
        'description' => $description ?: $defaults['description'],
        'regions' => $regions_array,
        'headquarters' => [
            'city' => $hq_city ?: $defaults['headquarters']['city'],
            'country' => $hq_country ?: $defaults['headquarters']['country'],
            'address' => $hq_address ?: $defaults['headquarters']['address']
        ]
    ];
}
