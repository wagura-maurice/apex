<?php
/**
 * About Pages Component
 * Shared functionality for About Us subpages
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_AboutPages_Component {
    
    private static $instance = null;
    
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_assets']);
    }
    
    public function enqueue_assets() {
        // Check if we're on any about-us page
        $request_uri = trim($_SERVER['REQUEST_URI'], '/');
        $request_uri = strtok($request_uri, '?');
        
        if (strpos($request_uri, 'about-us') === 0) {
            wp_enqueue_style(
                'apex-about-pages-component',
                get_template_directory_uri() . '/components/about-pages/about-pages.css',
                [],
                '1.0.1'
            );
        }
    }
}

// Initialize component
Apex_AboutPages_Component::get_instance();
