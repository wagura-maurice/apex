<?php
/**
 * Contact Page Component
 * Handles CSS loading for Contact page
 * 
 * @package ApexTheme
 * @subpackage Components/ContactPage
 */

if (!defined('ABSPATH')) exit;

/**
 * Enqueue Contact Page CSS
 */
function apex_enqueue_contact_page_css() {
    // Only load on contact page
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, 'contact') === false) {
        return;
    }
    
    $component_uri = get_template_directory_uri() . '/components/contact-page';
    
    wp_enqueue_style(
        'apex-contact-page',
        $component_uri . '/contact-page.css',
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'apex_enqueue_contact_page_css');
