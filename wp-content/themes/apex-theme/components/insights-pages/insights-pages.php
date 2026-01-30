<?php
/**
 * Insights Pages Component
 * Handles CSS loading for Insights pages
 * 
 * @package ApexTheme
 * @subpackage Components/InsightsPages
 */

if (!defined('ABSPATH')) exit;

/**
 * Enqueue Insights Pages CSS
 */
function apex_enqueue_insights_pages_css() {
    // Only load on insights pages
    $request_uri = $_SERVER['REQUEST_URI'];
    if (strpos($request_uri, 'insights') === false) {
        return;
    }
    
    $component_uri = get_template_directory_uri() . '/components/insights-pages';
    
    wp_enqueue_style(
        'apex-insights-pages',
        $component_uri . '/insights-pages.css',
        [],
        wp_get_theme()->get('Version')
    );
    
    wp_enqueue_style(
        'apex-insights-pages-2',
        $component_uri . '/insights-pages-2.css',
        ['apex-insights-pages'],
        wp_get_theme()->get('Version')
    );
    
    wp_enqueue_style(
        'apex-insights-pages-3',
        $component_uri . '/insights-pages-3.css',
        ['apex-insights-pages-2'],
        wp_get_theme()->get('Version')
    );
    
    wp_enqueue_style(
        'apex-insights-pages-4',
        $component_uri . '/insights-pages-4.css',
        ['apex-insights-pages-3'],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'apex_enqueue_insights_pages_css');
