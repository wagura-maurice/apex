# About Us Overview Page - Dynamic Hero Section

## Overview

The hero section of the About Us Overview page (`/about-us/overview`) is now dynamic and can be managed through WordPress admin.

## How It Works

### 1. ACF Fields (Advanced Custom Fields)

The hero content is controlled by ACF fields that appear when editing the About Us Overview page in WordPress admin.

**Available Fields:**
- **Badge Text** - Small label above the heading (e.g., "About Apex Softwares")
- **Heading** - Main hero headline
- **Description** - Text below the heading
- **Hero Image** - Main hero image (recommended: 1200x800px)
- **Statistics** - Repeater field for stats (up to 6 items)
  - Value (e.g., "100+")
  - Label (e.g., "Financial Institutions")

### 2. Default Values

If ACF is not installed or fields are empty, the system uses these defaults:
- Badge: "About Apex Softwares"
- Heading: "Transforming Financial Services Across Africa"
- Description: "For over a decade, we've been at the forefront of financial technology innovation..."
- Stats: 100+ Institutions, 15+ Countries, 10M+ End Users, 14+ Years Experience
- Image: Default Unsplash team photo

### 3. File Structure

```
wp-content/themes/apex-theme/
├── inc/
│   └── acf-about-us-overview.php    # ACF field definitions & helper function
├── components/
│   └── about-hero/
│       └── about-hero.php           # Hero component renderer
└── page-about-us-overview.php         # Page template using dynamic data
```

## Setup Instructions

### Option 1: Using ACF Pro Plugin (Recommended)

1. Install and activate **Advanced Custom Fields Pro** plugin
2. Navigate to **Pages > About Us Overview** in WordPress admin
3. You'll see the "Hero Section" meta box with all editable fields
4. Edit content and save

### Option 2: Without ACF (Fallback)

If ACF is not installed, the page will display with the default hardcoded values. To customize without ACF:

1. Edit `/wp-content/themes/apex-theme/inc/acf-about-us-overview.php`
2. Modify the `$defaults` array in the `apex_get_about_hero_data()` function

## Code Reference

### Helper Function

```php
// Get hero data with ACF + fallback defaults
$hero_data = apex_get_about_hero_data();

// Returns array:
// [
//     'badge' => string,
//     'heading' => string,
//     'description' => string,
//     'stats' => [
//         ['value' => '100+', 'label' => 'Financial Institutions'],
//         ...
//     ],
//     'image' => string (URL)
// ]
```

### Rendering the Hero

```php
// In page template:
$hero_data = apex_get_about_hero_data();
apex_render_about_hero($hero_data);
```

## Next Steps for Full Dynamic Content

To make other sections dynamic (Company Story, Mission & Vision, Leadership, Global Presence), follow the same pattern:

1. Create ACF field groups in `acf-about-us-overview.php`
2. Create helper functions like `apex_get_company_story_data()`
3. Update `page-about-us-overview.php` to use the helper functions
4. Keep the existing component structure (`apex_render_*` functions)
