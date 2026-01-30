<?php
/**
 * Support Pages Component
 * Handles CSS loading for Support pages (Careers, Help & Support, FAQ, Knowledge Base, Developers)
 * 
 * @package ApexTheme
 * @subpackage Components/SupportPages
 */

if (!defined('ABSPATH')) exit;

/**
 * Enqueue Support Pages CSS
 */
function apex_enqueue_support_pages_css() {
    // Only load on support pages
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, 'careers') === false && 
        strpos($request_uri, 'help-support') === false && 
        strpos($request_uri, 'faq') === false && 
        strpos($request_uri, 'knowledge-base') === false && 
        strpos($request_uri, 'developers') === false && 
        strpos($request_uri, 'partners') === false && 
        strpos($request_uri, 'request-demo') === false) {
        return;
    }
    
    $component_uri = get_template_directory_uri() . '/components/support-pages';
    
    wp_enqueue_style(
        'apex-support-pages',
        $component_uri . '/support-pages.css',
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'apex_enqueue_support_pages_css');
