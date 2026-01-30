<?php
/**
 * Solutions Pages Component
 * Handles CSS loading for Solutions pages
 * 
 * @package ApexTheme
 * @subpackage Components/SolutionsPages
 */

if (!defined('ABSPATH')) exit;

/**
 * Enqueue Solutions Pages CSS
 */
function apex_enqueue_solutions_pages_css() {
    // Only load on solutions pages
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, 'solutions') === false) {
        return;
    }
    
    $component_uri = get_template_directory_uri() . '/components/solutions-pages';
    
    wp_enqueue_style(
        'apex-solutions-pages',
        $component_uri . '/solutions-pages.css',
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'apex_enqueue_solutions_pages_css');
