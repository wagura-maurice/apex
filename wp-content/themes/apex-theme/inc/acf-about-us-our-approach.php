<?php
/**
 * ACF Field Groups for Our Approach Page
 * Provides dynamic content editing for the Our Approach page
 */

if( function_exists('acf_add_local_field_group') ):

    // Hero Section for Our Approach
    acf_add_local_field_group(array(
        'key' => 'group_approach_hero',
        'title' => 'Our Approach Hero Section',
        'fields' => array(
            array(
                'key' => 'approach_hero_badge',
                'label' => 'Badge Text',
                'name' => 'approach_hero_badge',
                'type' => 'text',
                'default_value' => 'Our Approach',
            ),
            array(
                'key' => 'approach_hero_heading',
                'label' => 'Main Heading',
                'name' => 'approach_hero_heading',
                'type' => 'text',
                'default_value' => 'How We Deliver Excellence',
            ),
            array(
                'key' => 'approach_hero_description',
                'label' => 'Description',
                'name' => 'approach_hero_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Our methodology combines deep industry expertise with agile development practices to deliver solutions that transform financial institutions.',
            ),
            array(
                'key' => 'approach_hero_image',
                'label' => 'Hero Image',
                'name' => 'approach_hero_image',
                'type' => 'url',
                'default_value' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200',
            ),
            array(
                'key' => 'approach_hero_stats',
                'label' => 'Statistics',
                'name' => 'approach_hero_stats',
                'type' => 'repeater',
                'min' => 0,
                'max' => 4,
                'layout' => 'table',
                'sub_fields' => array(
                    array(
                        'key' => 'value',
                        'label' => 'Value',
                        'name' => 'value',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'label',
                        'label' => 'Label',
                        'name' => 'label',
                        'type' => 'text',
                        'required' => 1,
                    ),
                ),
                'default_value' => array(
                    array('value' => '98%', 'label' => 'Client Retention'),
                    array('value' => '45', 'label' => 'Avg Days to Deploy'),
                    array('value' => '24/7', 'label' => 'Support Coverage'),
                    array('value' => '99.9%', 'label' => 'System Uptime'),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'apex-website-settings',
                ),
            ),
        ),
    ));

    // Our Methodology Section
    acf_add_local_field_group(array(
        'key' => 'group_approach_methodology',
        'title' => 'Our Methodology Section',
        'fields' => array(
            array(
                'key' => 'methodology_badge',
                'label' => 'Section Badge',
                'name' => 'methodology_badge',
                'type' => 'text',
                'default_value' => 'Our Methodology',
            ),
            array(
                'key' => 'methodology_heading',
                'label' => 'Section Heading',
                'name' => 'methodology_heading',
                'type' => 'text',
                'default_value' => 'A Proven Framework for Success',
            ),
            array(
                'key' => 'methodology_description',
                'label' => 'Section Description',
                'name' => 'methodology_description',
                'type' => 'textarea',
                'rows' => 2,
                'default_value' => 'We follow a structured yet flexible approach that ensures every implementation delivers maximum value while minimizing risk.',
            ),
            array(
                'key' => 'methodology_phases',
                'label' => 'Methodology Phases',
                'name' => 'methodology_phases',
                'type' => 'repeater',
                'min' => 1,
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'phase_number',
                        'label' => 'Phase Number',
                        'name' => 'phase_number',
                        'type' => 'text',
                        'default_value' => '01',
                    ),
                    array(
                        'key' => 'phase_title',
                        'label' => 'Phase Title',
                        'name' => 'phase_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'phase_description',
                        'label' => 'Phase Description',
                        'name' => 'phase_description',
                        'type' => 'textarea',
                        'rows' => 3,
                        'required' => 1,
                    ),
                    array(
                        'key' => 'phase_bullets',
                        'label' => 'Bullet Points',
                        'name' => 'phase_bullets',
                        'type' => 'repeater',
                        'min' => 0,
                        'layout' => 'table',
                        'sub_fields' => array(
                            array(
                                'key' => 'bullet_text',
                                'label' => 'Bullet Text',
                                'name' => 'bullet_text',
                                'type' => 'text',
                                'required' => 1,
                            ),
                        ),
                    ),
                ),
                'default_value' => array(
                    array(
                        'phase_number' => '01',
                        'phase_title' => 'Discovery & Assessment',
                        'phase_description' => 'We begin by deeply understanding your institution\'s unique challenges, goals, and existing infrastructure. Our team conducts comprehensive assessments to identify opportunities for optimization and growth.',
                        'phase_bullets' => array(
                            array('bullet_text' => 'Stakeholder interviews and requirements gathering'),
                            array('bullet_text' => 'Current system and process analysis'),
                            array('bullet_text' => 'Gap analysis and opportunity identification'),
                            array('bullet_text' => 'Regulatory compliance review'),
                        ),
                    ),
                    array(
                        'phase_number' => '02',
                        'phase_title' => 'Solution Design',
                        'phase_description' => 'Based on our findings, we design a tailored solution architecture that addresses your specific needs while leveraging the full power of the ApexCore platform.',
                        'phase_bullets' => array(
                            array('bullet_text' => 'Custom solution architecture design'),
                            array('bullet_text' => 'Integration mapping and API planning'),
                            array('bullet_text' => 'User experience and workflow design'),
                            array('bullet_text' => 'Security and compliance framework'),
                        ),
                    ),
                    array(
                        'phase_number' => '03',
                        'phase_title' => 'Agile Implementation',
                        'phase_description' => 'Our agile development methodology ensures rapid delivery with continuous feedback loops. We work in sprints, delivering functional components that you can test and validate.',
                        'phase_bullets' => array(
                            array('bullet_text' => 'Iterative development with 2-week sprints'),
                            array('bullet_text' => 'Continuous integration and testing'),
                            array('bullet_text' => 'Regular demos and stakeholder reviews'),
                            array('bullet_text' => 'Parallel data migration and validation'),
                        ),
                    ),
                    array(
                        'phase_number' => '04',
                        'phase_title' => 'Training & Change Management',
                        'phase_description' => 'Technology is only as good as the people using it. We invest heavily in training and change management to ensure your team is confident and capable.',
                        'phase_bullets' => array(
                            array('bullet_text' => 'Role-based training programs'),
                            array('bullet_text' => 'Train-the-trainer sessions'),
                            array('bullet_text' => 'Comprehensive documentation and guides'),
                            array('bullet_text' => 'Change management support'),
                        ),
                    ),
                    array(
                        'phase_number' => '05',
                        'phase_title' => 'Go-Live & Optimization',
                        'phase_description' => 'We ensure a smooth transition to production with comprehensive support. Post-launch, we continue to optimize and enhance your solution based on real-world usage.',
                        'phase_bullets' => array(
                            array('bullet_text' => 'Phased rollout strategy'),
                            array('bullet_text' => 'Hypercare support period'),
                            array('bullet_text' => 'Performance monitoring and optimization'),
                            array('bullet_text' => 'Continuous improvement roadmap'),
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'apex-website-settings',
                ),
            ),
        ),
    ));

    // Guiding Principles Section
    acf_add_local_field_group(array(
        'key' => 'group_approach_principles',
        'title' => 'Guiding Principles Section',
        'fields' => array(
            array(
                'key' => 'principles_badge',
                'label' => 'Section Badge',
                'name' => 'principles_badge',
                'type' => 'text',
                'default_value' => 'Guiding Principles',
            ),
            array(
                'key' => 'principles_heading',
                'label' => 'Section Heading',
                'name' => 'principles_heading',
                'type' => 'text',
                'default_value' => 'What Sets Us Apart',
            ),
            array(
                'key' => 'principles_cards',
                'label' => 'Principle Cards',
                'name' => 'principles_cards',
                'type' => 'repeater',
                'min' => 1,
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'principle_icon',
                        'label' => 'Icon',
                        'name' => 'principle_icon',
                        'type' => 'text',
                        'instructions' => 'Icon name (e.g., users, shield, clock, arrow-up, wrench, message-circle)',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'principle_title',
                        'label' => 'Principle Title',
                        'name' => 'principle_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'principle_description',
                        'label' => 'Principle Description',
                        'name' => 'principle_description',
                        'type' => 'textarea',
                        'rows' => 3,
                        'required' => 1,
                    ),
                ),
                'default_value' => array(
                    array(
                        'principle_icon' => 'users',
                        'principle_title' => 'Client-Centric Focus',
                        'principle_description' => 'Every decision we make is guided by what\'s best for our clients. We measure our success by your success, not by the number of features we ship.',
                    ),
                    array(
                        'principle_icon' => 'shield',
                        'principle_title' => 'Security First',
                        'principle_description' => 'Security isn\'t an afterthought—its built into everything we do. From architecture to deployment, we follow industry best practices and regulatory requirements.',
                    ),
                    array(
                        'principle_icon' => 'clock',
                        'principle_title' => 'Speed to Value',
                        'principle_description' => 'We understand that time is money. Our proven methodology and pre-built components enable rapid deployment without sacrificing quality or customization.',
                    ),
                    array(
                        'principle_icon' => 'arrow-up',
                        'principle_title' => 'Scalable Architecture',
                        'principle_description' => 'Our solutions are designed to grow with you. Whether you\'re serving 1,000 or 1 million customers, our platform scales seamlessly to meet demand.',
                    ),
                    array(
                        'principle_icon' => 'wrench',
                        'principle_title' => 'Continuous Innovation',
                        'principle_description' => 'The financial industry never stands still, and neither do we. We continuously invest in R&D to bring you the latest technologies and capabilities.',
                    ),
                    array(
                        'principle_icon' => 'message-circle',
                        'principle_title' => 'Transparent Communication',
                        'principle_description' => 'We believe in open, honest communication. You\'ll always know where your project stands, what challenges we\'re facing, and how we\'re addressing them.',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'apex-website-settings',
                ),
            ),
        ),
    ));

    // Ongoing Partnership Section
    acf_add_local_field_group(array(
        'key' => 'group_approach_support',
        'title' => 'Ongoing Partnership Section',
        'fields' => array(
            array(
                'key' => 'support_badge',
                'label' => 'Section Badge',
                'name' => 'support_badge',
                'type' => 'text',
                'default_value' => 'Ongoing Partnership',
            ),
            array(
                'key' => 'support_heading',
                'label' => 'Section Heading',
                'name' => 'support_heading',
                'type' => 'text',
                'default_value' => 'Support That Never Sleeps',
            ),
            array(
                'key' => 'support_description',
                'label' => 'Section Description',
                'name' => 'support_description',
                'type' => 'textarea',
                'rows' => 3,
                'default_value' => 'Our relationship doesn\'t end at go-live. We provide comprehensive support and continuous improvement services to ensure your platform evolves with your business.',
            ),
            array(
                'key' => 'support_features',
                'label' => 'Support Features',
                'name' => 'support_features',
                'type' => 'repeater',
                'min' => 1,
                'layout' => 'block',
                'sub_fields' => array(
                    array(
                        'key' => 'feature_icon',
                        'label' => 'Feature Icon',
                        'name' => 'feature_icon',
                        'type' => 'text',
                        'instructions' => 'Icon name (e.g., clock, edit-3, book-open, users)',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'feature_title',
                        'label' => 'Feature Title',
                        'name' => 'feature_title',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'feature_description',
                        'label' => 'Feature Description',
                        'name' => 'feature_description',
                        'type' => 'textarea',
                        'rows' => 2,
                        'required' => 1,
                    ),
                ),
                'default_value' => array(
                    array(
                        'feature_icon' => 'clock',
                        'feature_title' => '24/7 Technical Support',
                        'feature_description' => 'Round-the-clock access to our expert support team via phone, email, and chat.',
                    ),
                    array(
                        'feature_icon' => 'edit-3',
                        'feature_title' => 'Regular Updates',
                        'feature_description' => 'Quarterly platform updates with new features, security patches, and performance improvements.',
                    ),
                    array(
                        'feature_icon' => 'book-open',
                        'feature_title' => 'Knowledge Base',
                        'feature_description' => 'Comprehensive documentation, tutorials, and best practices at your fingertips.',
                    ),
                    array(
                        'feature_icon' => 'users',
                        'feature_title' => 'Dedicated Success Manager',
                        'feature_description' => 'A single point of contact who understands your business and advocates for your needs.',
                    ),
                ),
            ),
            array(
                'key' => 'support_stats',
                'label' => 'Support Statistics',
                'name' => 'support_stats',
                'type' => 'repeater',
                'min' => 0,
                'max' => 3,
                'layout' => 'table',
                'sub_fields' => array(
                    array(
                        'key' => 'stat_value',
                        'label' => 'Statistic Value',
                        'name' => 'stat_value',
                        'type' => 'text',
                        'required' => 1,
                    ),
                    array(
                        'key' => 'stat_label',
                        'label' => 'Statistic Label',
                        'name' => 'stat_label',
                        'type' => 'text',
                        'required' => 1,
                    ),
                ),
                'default_value' => array(
                    array('stat_value' => '<15min', 'stat_label' => 'Average Response Time'),
                    array('stat_value' => '95%', 'stat_label' => 'First Call Resolution'),
                    array('stat_value' => '4.9/5', 'stat_label' => 'Customer Satisfaction'),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'options_page',
                    'operator' => '==',
                    'value' => 'apex-website-settings',
                ),
            ),
        ),
    ));

endif;

/**
 * Helper functions for Our Approach page content
 */

/**
 * Get approach hero data with fallbacks
 *
 * @return array Hero data
 */
function apex_get_approach_hero_data() {
    $defaults = [
        'badge' => 'Our Approach',
        'heading' => 'How We Deliver Excellence',
        'description' => 'Our methodology combines deep industry expertise with agile development practices to deliver solutions that transform financial institutions.',
        'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200',
        'stats' => [
            ['value' => '98%', 'label' => 'Client Retention'],
            ['value' => '45', 'label' => 'Avg Days to Deploy'],
            ['value' => '24/7', 'label' => 'Support Coverage'],
            ['value' => '99.9%', 'label' => 'System Uptime']
        ]
    ];

    // Check if ACF is available
    if (function_exists('get_field')) {
        // Get ACF fields from options
        $badge = get_field('approach_hero_badge', 'option');
        $heading = get_field('approach_hero_heading', 'option');
        $description = get_field('approach_hero_description', 'option');
        $image = get_field('approach_hero_image', 'option');
        $stats = get_field('approach_hero_stats', 'option');

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

        return [
            'badge' => $badge ?: $defaults['badge'],
            'heading' => $heading ?: $defaults['heading'],
            'description' => $description ?: $defaults['description'],
            'image' => $image ?: $defaults['image'],
            'stats' => $stats_array ?: $defaults['stats']
        ];
    } else {
        // Use fallback data when ACF is not available
        $page_slug = 'about-us-our-approach';

        $badge = get_option('apex_hero_badge_' . $page_slug, $defaults['badge']);
        $heading = get_option('apex_hero_heading_' . $page_slug, $defaults['heading']);
        $description = get_option('apex_hero_description_' . $page_slug, $defaults['description']);
        $image = get_option('apex_hero_image_' . $page_slug, $defaults['image']);

        // Get stats
        $stats_text = get_option('apex_hero_stats_' . $page_slug, '');
        $stats_array = [];

        if (!empty($stats_text)) {
            $lines = explode("\n", $stats_text);
            foreach ($lines as $line) {
                $parts = explode(' ', trim($line), 2);
                if (count($parts) >= 2) {
                    $stats_array[] = [
                        'value' => trim($parts[0]),
                        'label' => trim($parts[1])
                    ];
                }
            }
        }

        return [
            'badge' => $badge,
            'heading' => $heading,
            'description' => $description,
            'image' => $image,
            'stats' => $stats_array ?: $defaults['stats']
        ];
    }
}

/**
 * Get approach methodology data with fallbacks
 *
 * @return array Methodology data
 */
function apex_get_approach_methodology_data() {
    $defaults = [
        'badge' => 'Our Methodology',
        'heading' => 'A Proven Framework for Success',
        'description' => 'We follow a structured yet flexible approach that ensures every implementation delivers maximum value while minimizing risk.',
        'phases' => [
            [
                'number' => '01',
                'title' => 'Discovery & Assessment',
                'description' => 'We begin by deeply understanding your institution\'s unique challenges, goals, and existing infrastructure. Our team conducts comprehensive assessments to identify opportunities for optimization and growth.',
                'bullets' => [
                    'Stakeholder interviews and requirements gathering',
                    'Current system and process analysis',
                    'Gap analysis and opportunity identification',
                    'Regulatory compliance review'
                ]
            ],
            [
                'number' => '02',
                'title' => 'Solution Design',
                'description' => 'Based on our findings, we design a tailored solution architecture that addresses your specific needs while leveraging the full power of the ApexCore platform.',
                'bullets' => [
                    'Custom solution architecture design',
                    'Integration mapping and API planning',
                    'User experience and workflow design',
                    'Security and compliance framework'
                ]
            ],
            [
                'number' => '03',
                'title' => 'Agile Implementation',
                'description' => 'Our agile development methodology ensures rapid delivery with continuous feedback loops. We work in sprints, delivering functional components that you can test and validate.',
                'bullets' => [
                    'Iterative development with 2-week sprints',
                    'Continuous integration and testing',
                    'Regular demos and stakeholder reviews',
                    'Parallel data migration and validation'
                ]
            ],
            [
                'number' => '04',
                'title' => 'Training & Change Management',
                'description' => 'Technology is only as good as the people using it. We invest heavily in training and change management to ensure your team is confident and capable.',
                'bullets' => [
                    'Role-based training programs',
                    'Train-the-trainer sessions',
                    'Comprehensive documentation and guides',
                    'Change management support'
                ]
            ],
            [
                'number' => '05',
                'title' => 'Go-Live & Optimization',
                'description' => 'We ensure a smooth transition to production with comprehensive support. Post-launch, we continue to optimize and enhance your solution based on real-world usage.',
                'bullets' => [
                    'Phased rollout strategy',
                    'Hypercare support period',
                    'Performance monitoring and optimization',
                    'Continuous improvement roadmap'
                ]
            ]
        ]
    ];

    // Check if ACF is available
    if (function_exists('get_field')) {
        // Get ACF fields from options
        $badge = get_field('methodology_badge', 'option');
        $heading = get_field('methodology_heading', 'option');
        $description = get_field('methodology_description', 'option');
        $phases = get_field('methodology_phases', 'option');

        // Build phases array from repeater
        $phases_array = [];
        if ($phases && is_array($phases)) {
            foreach ($phases as $phase) {
                $bullets = [];
                if (isset($phase['phase_bullets']) && is_array($phase['phase_bullets'])) {
                    foreach ($phase['phase_bullets'] as $bullet) {
                        $bullets[] = $bullet['bullet_text'] ?? '';
                    }
                }

                $phases_array[] = [
                    'number' => $phase['phase_number'] ?? '',
                    'title' => $phase['phase_title'] ?? '',
                    'description' => $phase['phase_description'] ?? '',
                    'bullets' => $bullets
                ];
            }
        }

        return [
            'badge' => $badge ?: $defaults['badge'],
            'heading' => $heading ?: $defaults['heading'],
            'description' => $description ?: $defaults['description'],
            'phases' => $phases_array ?: $defaults['phases']
        ];
    } else {
        // Use fallback data when ACF is not available
        $page_slug = 'about-us-our-approach';

        $badge = get_option('apex_methodology_badge_' . $page_slug, $defaults['badge']);
        $heading = get_option('apex_methodology_heading_' . $page_slug, $defaults['heading']);
        $description = get_option('apex_methodology_description_' . $page_slug, $defaults['description']);

        // For now, return defaults as methodology phases are complex to handle in fallback
        return [
            'badge' => $badge,
            'heading' => $heading,
            'description' => $description,
            'phases' => $defaults['phases']
        ];
    }
}

/**
 * Get approach principles data with fallbacks
 *
 * @return array Principles data
 */
function apex_get_approach_principles_data() {
    $defaults = [
        'badge' => 'Guiding Principles',
        'heading' => 'What Sets Us Apart',
        'cards' => [
            [
                'icon' => 'users',
                'title' => 'Client-Centric Focus',
                'description' => 'Every decision we make is guided by what\'s best for our clients. We measure our success by your success, not by the number of features we ship.'
            ],
            [
                'icon' => 'shield',
                'title' => 'Security First',
                'description' => 'Security isn\'t an afterthought—its built into everything we do. From architecture to deployment, we follow industry best practices and regulatory requirements.'
            ],
            [
                'icon' => 'clock',
                'title' => 'Speed to Value',
                'description' => 'We understand that time is money. Our proven methodology and pre-built components enable rapid deployment without sacrificing quality or customization.'
            ],
            [
                'icon' => 'arrow-up',
                'title' => 'Scalable Architecture',
                'description' => 'Our solutions are designed to grow with you. Whether you\'re serving 1,000 or 1 million customers, our platform scales seamlessly to meet demand.'
            ],
            [
                'icon' => 'wrench',
                'title' => 'Continuous Innovation',
                'description' => 'The financial industry never stands still, and neither do we. We continuously invest in R&D to bring you the latest technologies and capabilities.'
            ],
            [
                'icon' => 'message-circle',
                'title' => 'Transparent Communication',
                'description' => 'We believe in open, honest communication. You\'ll always know where your project stands, what challenges we\'re facing, and how we\'re addressing them.'
            ]
        ]
    ];

    // Check if ACF is available
    if (function_exists('get_field')) {
        // Get ACF fields from options
        $badge = get_field('principles_badge', 'option');
        $heading = get_field('principles_heading', 'option');
        $cards = get_field('principles_cards', 'option');

        // Build cards array from repeater
        $cards_array = [];
        if ($cards && is_array($cards)) {
            foreach ($cards as $card) {
                $cards_array[] = [
                    'icon' => $card['principle_icon'] ?? '',
                    'title' => $card['principle_title'] ?? '',
                    'description' => $card['principle_description'] ?? ''
                ];
            }
        }

        return [
            'badge' => $badge ?: $defaults['badge'],
            'heading' => $heading ?: $defaults['heading'],
            'cards' => $cards_array ?: $defaults['cards']
        ];
    } else {
        // Use fallback data when ACF is not available
        $page_slug = 'about-us-our-approach';

        $badge = get_option('apex_principles_badge_' . $page_slug, $defaults['badge']);
        $heading = get_option('apex_principles_heading_' . $page_slug, $defaults['heading']);

        // For now, return defaults as principles are complex to handle in fallback
        return [
            'badge' => $badge,
            'heading' => $heading,
            'cards' => $defaults['cards']
        ];
    }
}

/**
 * Get approach support data with fallbacks
 *
 * @return array Support data
 */
function apex_get_approach_support_data() {
    $defaults = [
        'badge' => 'Ongoing Partnership',
        'heading' => 'Support That Never Sleeps',
        'description' => 'Our relationship doesn\'t end at go-live. We provide comprehensive support and continuous improvement services to ensure your platform evolves with your business.',
        'features' => [
            [
                'icon' => 'clock',
                'title' => '24/7 Technical Support',
                'description' => 'Round-the-clock access to our expert support team via phone, email, and chat.'
            ],
            [
                'icon' => 'edit-3',
                'title' => 'Regular Updates',
                'description' => 'Quarterly platform updates with new features, security patches, and performance improvements.'
            ],
            [
                'icon' => 'book-open',
                'title' => 'Knowledge Base',
                'description' => 'Comprehensive documentation, tutorials, and best practices at your fingertips.'
            ],
            [
                'icon' => 'users',
                'title' => 'Dedicated Success Manager',
                'description' => 'A single point of contact who understands your business and advocates for your needs.'
            ]
        ],
        'stats' => [
            ['value' => '<15min', 'label' => 'Average Response Time'],
            ['value' => '95%', 'label' => 'First Call Resolution'],
            ['value' => '4.9/5', 'label' => 'Customer Satisfaction']
        ]
    ];

    // Check if ACF is available
    if (function_exists('get_field')) {
        // Get ACF fields from options
        $badge = get_field('support_badge', 'option');
        $heading = get_field('support_heading', 'option');
        $description = get_field('support_description', 'option');
        $features = get_field('support_features', 'option');
        $stats = get_field('support_stats', 'option');

        // Build features array from repeater
        $features_array = [];
        if ($features && is_array($features)) {
            foreach ($features as $feature) {
                $features_array[] = [
                    'icon' => $feature['feature_icon'] ?? '',
                    'title' => $feature['feature_title'] ?? '',
                    'description' => $feature['feature_description'] ?? ''
                ];
            }
        }

        // Build stats array from repeater
        $stats_array = [];
        if ($stats && is_array($stats)) {
            foreach ($stats as $stat) {
                $stats_array[] = [
                    'value' => $stat['stat_value'] ?? '',
                    'label' => $stat['stat_label'] ?? ''
                ];
            }
        }

        return [
            'badge' => $badge ?: $defaults['badge'],
            'heading' => $heading ?: $defaults['heading'],
            'description' => $description ?: $defaults['description'],
            'features' => $features_array ?: $defaults['features'],
            'stats' => $stats_array ?: $defaults['stats']
        ];
    } else {
        // Use fallback data when ACF is not available
        $page_slug = 'about-us-our-approach';

        $badge = get_option('apex_support_badge_' . $page_slug, $defaults['badge']);
        $heading = get_option('apex_support_heading_' . $page_slug, $defaults['heading']);
        $description = get_option('apex_support_description_' . $page_slug, $defaults['description']);

        // For now, return defaults as support features are complex to handle in fallback
        return [
            'badge' => $badge,
            'heading' => $heading,
            'description' => $description,
            'features' => $defaults['features'],
            'stats' => $defaults['stats']
        ];
    }
}
