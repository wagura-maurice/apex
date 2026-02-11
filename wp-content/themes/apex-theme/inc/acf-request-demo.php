<?php
/**
 * ACF Field Group for Request Demo Page
 * 
 * This file defines the custom fields for the Request Demo page
 * including hero section, form settings, sidebar content, and webinar information
 * 
 * @package ApexTheme
 * @subpackage ACF
 */

if (!defined('ABSPATH')) exit;

/**
 * Register ACF Field Group for Request Demo Page
 */
function acf_register_request_demo_fields() {
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group([
            'key' => 'group_request_demo',
            'title' => 'Request Demo Page',
            'fields' => [
                // Hero Section
                [
                    'key' => 'field_request_demo_hero_badge',
                    'label' => 'Hero Badge',
                    'name' => 'hero_badge',
                    'type' => 'text',
                    'instructions' => 'Small text displayed above the main heading',
                    'default_value' => 'Request Demo',
                    'required' => 0,
                ],
                [
                    'key' => 'field_request_demo_hero_heading',
                    'label' => 'Hero Heading',
                    'name' => 'hero_heading',
                    'type' => 'text',
                    'instructions' => 'Main heading for the hero section',
                    'default_value' => 'See Our Platform in Action',
                    'required' => 1,
                ],
                [
                    'key' => 'field_request_demo_hero_description',
                    'label' => 'Hero Description',
                    'name' => 'hero_description',
                    'type' => 'textarea',
                    'instructions' => 'Description text below the heading',
                    'default_value' => 'Schedule a personalized demo of our fintech solutions and discover how we can help transform your financial institution.',
                    'required' => 1,
                    'rows' => 3,
                ],
                [
                    'key' => 'field_request_demo_hero_image',
                    'label' => 'Hero Background Image',
                    'name' => 'hero_image',
                    'type' => 'image',
                    'instructions' => 'Background image for the hero section',
                    'required' => 0,
                    'return_format' => 'url',
                    'preview_size' => 'medium',
                ],
                [
                    'key' => 'field_request_demo_hero_stats',
                    'label' => 'Hero Statistics',
                    'name' => 'hero_stats',
                    'type' => 'repeater',
                    'instructions' => 'Statistics displayed in the hero section',
                    'required' => 0,
                    'layout' => 'table',
                    'button_label' => 'Add Statistic',
                    'sub_fields' => [
                        [
                            'key' => 'field_request_demo_stat_value',
                            'label' => 'Value',
                            'name' => 'value',
                            'type' => 'text',
                            'required' => 1,
                        ],
                        [
                            'key' => 'field_request_demo_stat_label',
                            'label' => 'Label',
                            'name' => 'label',
                            'type' => 'text',
                            'required' => 1,
                        ],
                    ],
                ],
                
                // Form Section
                [
                    'key' => 'field_request_demo_form_heading',
                    'label' => 'Form Heading',
                    'name' => 'form_heading',
                    'type' => 'text',
                    'instructions' => 'Heading above the request demo form',
                    'default_value' => 'Request Your Personalized Demo',
                    'required' => 1,
                ],
                [
                    'key' => 'field_request_demo_form_description',
                    'label' => 'Form Description',
                    'name' => 'form_description',
                    'type' => 'textarea',
                    'instructions' => 'Description text below the form heading',
                    'default_value' => 'Fill out the form below and our team will contact you within 24 hours to schedule your demo.',
                    'required' => 1,
                    'rows' => 2,
                ],
                
                // Sidebar - What to Expect Section
                [
                    'key' => 'field_request_demo_what_to_expect_title',
                    'label' => 'What to Expect Title',
                    'name' => 'what_to_expect_title',
                    'type' => 'text',
                    'default_value' => 'What to Expect',
                    'required' => 1,
                ],
                [
                    'key' => 'field_request_demo_what_to_expect_items',
                    'label' => 'What to Expect Items',
                    'name' => 'what_to_expect_items',
                    'type' => 'repeater',
                    'instructions' => 'List of what users can expect from the demo',
                    'required' => 0,
                    'layout' => 'table',
                    'button_label' => 'Add Item',
                    'sub_fields' => [
                        [
                            'key' => 'field_request_demo_expect_item_text',
                            'label' => 'Item Text',
                            'name' => 'text',
                            'type' => 'text',
                            'required' => 1,
                        ],
                    ],
                ],
                
                // Sidebar - Need Help Section
                [
                    'key' => 'field_request_demo_need_help_title',
                    'label' => 'Need Help Title',
                    'name' => 'need_help_title',
                    'type' => 'text',
                    'default_value' => 'Need Help?',
                    'required' => 1,
                ],
                [
                    'key' => 'field_request_demo_need_help_description',
                    'label' => 'Need Help Description',
                    'name' => 'need_help_description',
                    'type' => 'text',
                    'default_value' => 'Our team is ready to assist you.',
                    'required' => 1,
                ],
                [
                    'key' => 'field_request_demo_phone_number',
                    'label' => 'Phone Number',
                    'name' => 'phone_number',
                    'type' => 'text',
                    'instructions' => 'Contact phone number',
                    'default_value' => '+254 700 000 000',
                    'required' => 1,
                ],
                [
                    'key' => 'field_request_demo_email_address',
                    'label' => 'Email Address',
                    'name' => 'email_address',
                    'type' => 'email',
                    'instructions' => 'Contact email address',
                    'default_value' => 'sales@apex-softwares.com',
                    'required' => 1,
                ],
                
                // Training Materials Section
                [
                    'key' => 'field_request_demo_training_title',
                    'label' => 'Training Materials Title',
                    'name' => 'training_title',
                    'type' => 'text',
                    'default_value' => 'Training Materials',
                    'required' => 1,
                ],
                [
                    'key' => 'field_request_demo_training_description',
                    'label' => 'Training Materials Description',
                    'name' => 'training_description',
                    'type' => 'text',
                    'default_value' => 'Download our product presentations and documentation.',
                    'required' => 1,
                ],
                [
                    'key' => 'field_request_demo_training_materials',
                    'label' => 'Training Materials',
                    'name' => 'training_materials',
                    'type' => 'repeater',
                    'instructions' => 'List of downloadable training materials',
                    'required' => 0,
                    'layout' => 'table',
                    'button_label' => 'Add Material',
                    'sub_fields' => [
                        [
                            'key' => 'field_request_demo_material_title',
                            'label' => 'Material Title',
                            'name' => 'title',
                            'type' => 'text',
                            'required' => 1,
                        ],
                        [
                            'key' => 'field_request_demo_material_file',
                            'label' => 'Material File',
                            'name' => 'file',
                            'type' => 'file',
                            'required' => 1,
                            'return_format' => 'url',
                        ],
                        [
                            'key' => 'field_request_demo_material_size',
                            'label' => 'File Size',
                            'name' => 'size',
                            'type' => 'text',
                            'instructions' => 'Display file size (e.g., "PDF • 2.5 MB")',
                            'required' => 1,
                        ],
                    ],
                ],
                
                // Webinars Section
                [
                    'key' => 'field_request_demo_webinars_title',
                    'label' => 'Webinars Title',
                    'name' => 'webinars_title',
                    'type' => 'text',
                    'default_value' => 'Upcoming Webinars',
                    'required' => 1,
                ],
                [
                    'key' => 'field_request_demo_webinars_description',
                    'label' => 'Webinars Description',
                    'name' => 'webinars_description',
                    'type' => 'text',
                    'default_value' => 'Join our live demo sessions and Q&A.',
                    'required' => 1,
                ],
                [
                    'key' => 'field_request_demo_webinar_sessions',
                    'label' => 'Webinar Sessions',
                    'name' => 'webinar_sessions',
                    'type' => 'repeater',
                    'instructions' => 'List of upcoming webinar sessions',
                    'required' => 0,
                    'layout' => 'table',
                    'button_label' => 'Add Session',
                    'sub_fields' => [
                        [
                            'key' => 'field_request_demo_webinar_day',
                            'label' => 'Day',
                            'name' => 'day',
                            'type' => 'number',
                            'required' => 1,
                            'min' => 1,
                            'max' => 31,
                        ],
                        [
                            'key' => 'field_request_demo_webinar_month',
                            'label' => 'Month',
                            'name' => 'month',
                            'type' => 'text',
                            'required' => 1,
                        ],
                        [
                            'key' => 'field_request_demo_webinar_title',
                            'label' => 'Webinar Title',
                            'name' => 'title',
                            'type' => 'text',
                            'required' => 1,
                        ],
                        [
                            'key' => 'field_request_demo_webinar_time',
                            'label' => 'Time',
                            'name' => 'time',
                            'type' => 'text',
                            'required' => 1,
                        ],
                        [
                            'key' => 'field_request_demo_webinar_link',
                            'label' => 'Registration Link',
                            'name' => 'link',
                            'type' => 'url',
                            'required' => 1,
                        ],
                    ],
                ],
            ],
            'location' => [
                [
                    [
                        'param' => 'options_page',
                        'operator' => '==',
                        'value' => 'apex-website-settings',
                    ],
                ],
            ],
            'menu_order' => 20,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => 'Custom fields for the Request Demo page content',
        ]);
    }
}
add_action('acf/init', 'acf_register_request_demo_fields');
