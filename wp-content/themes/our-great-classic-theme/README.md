# APEX SOFTWARES - Modern Financial Technology Theme

A comprehensive WordPress theme for Apex Softwares with dynamic navigation system and customizable content, integrating WordPress menu functionality following the learningWordPress tutorial methodology.

## Features

- Dynamic WordPress navigation system (following learningWordPress tutorial methodology)
- Customizable homepage content via WordPress Customizer
- Responsive design with mobile-friendly navigation
- Modern B2B fintech design with orange (#FF6200) and dark gray (#1e293b) branding
- Compatible with WordPress 5.0+
- WordPress navigation menus with fallback to hardcoded navigation

## Navigation System

### Registering Navigation Menus

Navigation menus are registered in `functions.php` following the learningWordPress approach:

```php
register_nav_menus(array(
    'primary' => __('Primary Menu', 'apex-softwares'),
    'footer' => __('Footer Menu', 'apex-softwares'),
));
```

### Configuring Menus in WordPress Admin

1. Go to **Appearance > Menus** in your WordPress admin
2. Create a new menu or edit an existing one
3. Add menu items from the left panels (Pages, Posts, Custom Links, etc.)
4. Assign menu locations using the "Manage Locations" tab

### Menu Implementation

The theme uses the WordPress `wp_nav_menu()` function to render menus in both header and footer:

```php
wp_nav_menu(array(
    'theme_location' => 'primary',
    'container' => false,
    'items_wrap' => '%3$s', // Remove ul wrapper, just output the li's
    'depth' => 2,
    'fallback_cb' => 'custom_fallback_function'
));
```

## Customizer Settings

The theme includes several customizer options for homepage content:

- **Hero Heading**: Main headline for the homepage
- **Hero Subheading**: Supporting text for the hero section
- **Hero CTA Text**: Primary call-to-action button text
- **Hero Secondary CTA Text**: Secondary call-to-action button text
- **Features Heading**: Heading for the features section
- **Features Description**: Description for the features section

## Template Files

- `front-page.php`: Customizable homepage
- `header.php`: Site header with navigation
- `footer.php`: Site footer with links
- `page.php`: Default page template
- `single.php`: Default post template
- Various custom page templates for different sections

## Custom Page Templates

The theme includes several custom page templates:

- `template-solution.php`: For solution pages
- `template-industry.php`: For industry pages
- `template-insights.php`: For insights pages
- `template-about.php`: For about pages
- `template-platform.php`: For platform pages
- Other specific page templates

## Creating Custom Post Types

The theme includes a sample custom post type for pets. To register your own:

```php
function your_custom_post_type() {
    $args = array(
        'public' => true,
        'label'  => 'Your Post Type',
        'supports' => array('title', 'editor', 'thumbnail'),
        'has_archive' => true,
        'show_in_rest' => true,
    );
    register_post_type('your_post_type', $args);
}
add_action('init', 'your_custom_post_type');
```

## Styling

The theme uses Tailwind CSS via CDN for rapid development. For production, consider compiling a custom build with only the utilities you need.

Colors can be customized in the `functions.php` file in the Tailwind configuration section.

## JavaScript Functionality

The navigation functionality is handled by:
- `main.js`: Original theme JavaScript
- `navigation-script.js`: Enhanced navigation for WordPress menus

## Page Structure

The theme implements the requested 23-page structure:

1. Home
2. Platform → ApexCore
3. Solutions → Overview
4-12. 9 Individual Solution Pages
13. Industry → Overview
14-17. 4 Industry Pages
18-21. 4 Insights Pages
22-23. 2 About + Contact/Request Demo

## Global Elements

All pages include:
- Sticky header with "Request Demo" button
- Hero section with orange wave background
- Breadcrumb navigation
- "Back to Overview" links on sub-pages
- Footer with quick links and contact form

## Installation

1. Upload the theme folder to `/wp-content/themes/`
2. Activate the theme in WordPress admin
3. Configure menus under Appearance > Menus
4. Customize content via Appearance > Customize

## Development Notes

- All templates are built with accessibility in mind
- Responsive design tested on multiple screen sizes
- SEO friendly with proper heading structure
- Optimized for performance
- Navigation system follows WordPress best practices from learningWordPress tutorial