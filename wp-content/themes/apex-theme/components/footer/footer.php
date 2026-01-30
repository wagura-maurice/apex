<?php
/**
 * Footer Component
 * Handles CSS loading for Footer
 * 
 * @package ApexTheme
 * @subpackage Components/Footer
 */

if (!defined('ABSPATH')) exit;

/**
 * Enqueue Footer CSS
 */
function apex_enqueue_footer_css() {
    $component_uri = get_template_directory_uri() . '/components/footer';
    
    wp_enqueue_style(
        'apex-footer',
        $component_uri . '/footer.css',
        [],
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'apex_enqueue_footer_css');
