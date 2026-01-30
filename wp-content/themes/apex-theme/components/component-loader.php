<?php
/**
 * Component Loader
 * Autoloads all modular components from the components directory
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

/**
 * Load all component files
 */
function apex_load_components() {
    $components_dir = get_template_directory() . '/components';
    
    // Define components to load (order matters for dependencies)
    $components = [
        'hero/hero.php',
        'who-we-are/who-we-are.php',
        'what-we-do/what-we-do.php',
        'how-we-do-it/how-we-do-it.php',
        'statistics/statistics.php',
        'testimonials/testimonials.php',
        'partners/partners.php',
        'whats-new/whats-new.php',
        'solutions-detail/solutions-detail.php',
        'roi-calculator/roi-calculator.php',
        'case-studies/case-studies.php',
        'api-integration/api-integration.php',
        'compliance/compliance.php',
    ];
    
    foreach ($components as $component) {
        $component_path = $components_dir . '/' . $component;
        if (file_exists($component_path)) {
            require_once $component_path;
        }
    }
}

// Load components after theme setup
add_action('after_setup_theme', 'apex_load_components');

/**
 * Get component directory URI
 */
function apex_get_component_uri($component_name) {
    return get_template_directory_uri() . '/components/' . $component_name;
}

/**
 * Get component directory path
 */
function apex_get_component_path($component_name) {
    return get_template_directory() . '/components/' . $component_name;
}

/**
 * Render a component by name with optional arguments
 * 
 * @param string $component_name The component folder name
 * @param array $args Optional arguments to pass to the component
 */
function apex_component($component_name, $args = []) {
    $function_name = 'apex_render_' . str_replace('-', '_', $component_name);
    
    if (function_exists($function_name)) {
        call_user_func($function_name, $args);
    } else {
        // Fallback: try to include the component file directly
        $component_path = apex_get_component_path($component_name) . '/' . $component_name . '.php';
        if (file_exists($component_path)) {
            include $component_path;
        }
    }
}

/**
 * Check if a component exists
 * 
 * @param string $component_name The component folder name
 * @return bool
 */
function apex_component_exists($component_name) {
    $component_path = apex_get_component_path($component_name) . '/' . $component_name . '.php';
    return file_exists($component_path);
}
