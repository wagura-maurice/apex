<?php
/**
 * Legal Pages Component
 * Handles CSS loading for Legal pages
 * 
 * @package ApexTheme
 * @subpackage Components/LegalPages
 */

if (!defined('ABSPATH')) exit;

/**
 * Enqueue Legal Pages CSS
 */
function apex_enqueue_legal_pages_css() {
    // Only load on legal pages
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, 'privacy-policy') === false && 
        strpos($request_uri, 'terms-conditions') === false) {
        return;
    }
    
    $component_uri = get_template_directory_uri() . '/components/legal-pages';
    
    wp_enqueue_style(
        'apex-legal-pages',
        $component_uri . '/legal-pages.css',
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'apex_enqueue_legal_pages_css');
