<?php
/**
 * Industry Pages Component
 * Handles CSS loading for Industry pages
 * 
 * @package ApexTheme
 * @subpackage Components/IndustryPages
 */

if (!defined('ABSPATH')) exit;

/**
 * Enqueue Industry Pages CSS
 */
function apex_enqueue_industry_pages_css() {
    // Only load on industry pages
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, 'industry') === false) {
        return;
    }
    
    $component_uri = get_template_directory_uri() . '/components/industry-pages';
    
    wp_enqueue_style(
        'apex-industry-pages',
        $component_uri . '/industry-pages.css',
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'apex_enqueue_industry_pages_css');
