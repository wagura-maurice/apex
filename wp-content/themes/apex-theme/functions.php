<?php

/**
 * Load modular component system
 */
require_once get_template_directory() . '/components/component-loader.php';

/**
 * Load ACF field definitions
 */
require_once get_template_directory() . '/inc/acf-about-us-overview.php';

/**
 * Theme setup.
 */
function apex_theme_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    register_nav_menus([
        'primary' => __('Primary Menu', 'apex-theme'),
        'footer' => __('Footer Menu', 'apex-theme'),
    ]);
}
add_action('after_setup_theme', 'apex_theme_setup');

/**
 * Enqueue styles and scripts.
 */
function apex_theme_assets(): void {
    // Font Awesome 6 for social media icons
    wp_enqueue_style(
        'font-awesome-6',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css',
        [],
        '6.5.1'
    );

    // Font (matches modern B2B SaaS typography).
    wp_enqueue_style(
        'apex-theme-fonts',
        'https://fonts.googleapis.com/css2?family=Josefin+Sans:wght@300;400;500;600;700&display=swap',
        [],
        null
    );

    // Tailwind CDN (fast prototype). Swap to a compiled build for production.
    wp_enqueue_script(
        'tailwind-cdn',
        'https://cdn.tailwindcss.com?plugins=forms,typography',
        [],
        null,
        false
    );

    // Configure Tailwind (brand colors, font) - run after script loads.
    wp_add_inline_script(
        'tailwind-cdn',
        "tailwind.config = {
  theme: {
    extend: {
      colors: {
        apex: {
          orange: '#FF6200',
          dark: '#1e293b',
          light: '#f8fafc',
          blue: '#0ea5e9',
          green: '#10b981',
          purple: '#8b5cf6',
          gray: {
            50: '#f8fafc',
            100: '#f1f5f9',
            200: '#e2e8f0',
            300: '#cbd5e1',
            400: '#94a3b8',
            500: '#64748b',
            600: '#475569',
            700: '#334155',
            800: '#1e293b',
            900: '#0f172a'
          }
        }
      },
      fontFamily: {
        sans: ['Josefin Sans', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'Arial', 'Noto Sans', 'sans-serif']
      },
      backgroundImage: {
        'gradient-radial': 'radial-gradient(var(--tw-gradient-stops))',
        'gradient-conic': 'conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))',
      },
      animation: {
        'fade-in': 'fadeIn 0.5s ease-in-out',
        'slide-up': 'slideUp 0.3s ease-out',
        'bounce-subtle': 'bounceSubtle 2s infinite'
      },
      keyframes: {
        fadeIn: {
          '0%': { opacity: '0' },
          '100%': { opacity: '1' }
        },
        slideUp: {
          '0%': { transform: 'translateY(10px)', opacity: '0' },
          '100%': { transform: 'translateY(0)', opacity: '1' }
        },
        bounceSubtle: {
          '0%, 100%': { transform: 'translateY(0)' },
          '50%': { transform: 'translateY(-5px)' }
        }
      }
    }
  }
};",
        'after'
    );

    // Main stylesheet (for WP requirements + small fallbacks).
    wp_enqueue_style(
        'apex-theme-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );

    // Add inline styles for comments
    $comment_styles = "
        /* Comment List Styling */
        .comment-list { list-style: none !important; padding: 0 !important; margin: 0 !important; }
        .comment-list .comment { 
            background: white; 
            border-radius: 1rem; 
            border: 1px solid #e2e8f0; 
            padding: 1.5rem; 
            margin-bottom: 1.5rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        }
        .comment-list .children { 
            margin-left: 2rem; 
            margin-top: 1rem;
            padding-left: 1rem;
            border-left: 2px solid #fed7aa;
        }
        .comment-author { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; }
        .comment-author .avatar { border-radius: 9999px; }
        .comment-author .fn { font-weight: 600; color: #1e293b; }
        .comment-author .fn a { color: #1e293b; text-decoration: none; }
        .comment-author .fn a:hover { color: #f97316; }
        .comment-author .says { display: none; }
        .comment-metadata { font-size: 0.875rem; color: #64748b; margin-bottom: 1rem; }
        .comment-metadata a { color: #64748b; text-decoration: none; }
        .comment-metadata a:hover { color: #f97316; }
        .comment-content { color: #475569; line-height: 1.6; }
        .comment-content p { margin-bottom: 0.75rem; }
        .reply { margin-top: 1rem; padding-top: 1rem; border-top: 1px solid #e2e8f0; }
        .reply a { 
            color: #f97316; 
            font-weight: 500; 
            font-size: 0.875rem; 
            text-decoration: none;
        }
        .reply a:hover { color: #ea580c; }
        
        /* Pagination styling */
        .nav-links { display: flex; justify-content: center; gap: 0.5rem; flex-wrap: wrap; }
        .nav-links a, .nav-links span { 
            padding: 0.5rem 1rem; 
            border-radius: 0.5rem; 
            text-decoration: none;
            font-weight: 500;
        }
        .nav-links a { background: white; border: 1px solid #e2e8f0; color: #475569; }
        .nav-links a:hover { border-color: #f97316; color: #f97316; }
        .nav-links .current { background: #f97316; color: white; border: 1px solid #f97316; }
        
        /* Sidebar Widget Styling */
        .widget-item { margin-bottom: 1.5rem; }
        .widget-item:last-child { margin-bottom: 0; }
        .widget-title, .widget-item h2 { 
            font-size: 1.125rem; 
            font-weight: 700; 
            color: #1e293b; 
            margin-bottom: 1rem; 
            padding-bottom: 0.75rem; 
            border-bottom: 2px solid #fed7aa;
        }
        
        /* Search Widget - WordPress Block & Classic - High Specificity */
        .side-column .wp-block-search .wp-block-search__inside-wrapper,
        aside .wp-block-search .wp-block-search__inside-wrapper,
        .widget .wp-block-search .wp-block-search__inside-wrapper,
        .wp-block-search__inside-wrapper {
            display: flex !important;
            gap: 0.5rem !important;
            flex-wrap: nowrap !important;
        }
        .side-column .wp-block-search .wp-block-search__input,
        aside .wp-block-search .wp-block-search__input,
        .widget .wp-block-search .wp-block-search__input,
        .side-column .wp-block-search input[type='search'],
        aside .wp-block-search input[type='search'],
        .wp-block-search .wp-block-search__input,
        .wp-block-search__input {
            flex: 1 !important;
            min-width: 0 !important;
            padding: 12px 16px !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 9999px !important;
            font-size: 14px !important;
            color: #1e293b !important;
            background: white !important;
            transition: all 0.2s !important;
            box-sizing: border-box !important;
            height: auto !important;
            appearance: none !important;
            -webkit-appearance: none !important;
        }
        .side-column .wp-block-search .wp-block-search__input:focus,
        aside .wp-block-search .wp-block-search__input:focus,
        .wp-block-search .wp-block-search__input:focus,
        .wp-block-search__input:focus {
            outline: none !important;
            border-color: #f97316 !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1) !important;
        }
        .side-column .wp-block-search .wp-block-search__button,
        aside .wp-block-search .wp-block-search__button,
        .widget .wp-block-search .wp-block-search__button,
        .wp-block-search .wp-block-search__button,
        .wp-block-search__button {
            padding: 12px 20px !important;
            background: linear-gradient(to right, #f97316, #ea580c) !important;
            color: white !important;
            border: none !important;
            border-radius: 9999px !important;
            font-weight: 600 !important;
            font-size: 14px !important;
            cursor: pointer !important;
            transition: all 0.2s !important;
            height: auto !important;
        }
        .side-column .wp-block-search .wp-block-search__button:hover,
        aside .wp-block-search .wp-block-search__button:hover,
        .wp-block-search .wp-block-search__button:hover,
        .wp-block-search__button:hover {
            background: linear-gradient(to right, #ea580c, #dc2626) !important;
        }
        
        /* Classic Search Widget */
        .widget_search form { 
            display: flex; 
            gap: 0.5rem; 
            flex-wrap: wrap; 
        }
        .widget_search input[type='search'],
        .widget_search input[type='text'],
        .side-column input[name='s'],
        input#s,
        input.search-field {
            flex: 1;
            min-width: 0;
            padding: 0.75rem 1rem !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 9999px !important;
            font-size: 0.875rem !important;
            color: #1e293b !important;
            background: white !important;
            transition: all 0.2s;
            box-sizing: border-box;
        }
        .widget_search input[type='search']:focus,
        .widget_search input[type='text']:focus,
        input#s:focus,
        input.search-field:focus {
            outline: none !important;
            border-color: #f97316 !important;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.1) !important;
        }
        .widget_search input[type='submit'],
        input#searchsubmit {
            padding: 0.75rem 1.25rem !important;
            background: linear-gradient(to right, #f97316, #ea580c) !important;
            color: white !important;
            border: none !important;
            border-radius: 9999px !important;
            font-weight: 600 !important;
            font-size: 0.875rem !important;
            cursor: pointer;
            transition: all 0.2s;
        }
        .widget_search input[type='submit']:hover,
        input#searchsubmit:hover {
            background: linear-gradient(to right, #ea580c, #dc2626) !important;
        }
        
        /* Recent Posts & Recent Comments Widgets */
        .widget_recent_entries ul,
        .widget_recent_comments ul,
        .wp-block-latest-posts,
        .wp-block-latest-comments {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .widget_recent_entries li,
        .widget_recent_comments li,
        .wp-block-latest-posts__post-title {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
            line-height: 1.5;
        }
        .widget_recent_entries li:last-child,
        .widget_recent_comments li:last-child {
            border-bottom: none;
        }
        .widget_recent_entries a,
        .widget_recent_comments a,
        .wp-block-latest-posts a {
            color: #475569;
            text-decoration: none;
            transition: color 0.2s;
        }
        .widget_recent_entries a:hover,
        .widget_recent_comments a:hover,
        .wp-block-latest-posts a:hover {
            color: #f97316;
        }
        .widget_recent_comments .comment-author-link {
            font-weight: 600;
            color: #1e293b;
        }
        
        /* Categories & Archives Widgets */
        .widget_categories ul,
        .widget_archive ul {
            list-style: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .widget_categories li,
        .widget_archive li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.875rem;
        }
        .widget_categories li:last-child,
        .widget_archive li:last-child {
            border-bottom: none;
        }
        .widget_categories a,
        .widget_archive a {
            color: #475569;
            text-decoration: none;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .widget_categories a:hover,
        .widget_archive a:hover {
            color: #f97316;
        }
        
        /* Tag Cloud Widget */
        .widget_tag_cloud .tagcloud a,
        .wp-block-tag-cloud a {
            display: inline-block;
            padding: 0.375rem 0.75rem;
            margin: 0.25rem;
            background: #f1f5f9;
            color: #475569;
            border-radius: 9999px;
            font-size: 0.75rem !important;
            text-decoration: none;
            transition: all 0.2s;
        }
        .widget_tag_cloud .tagcloud a:hover,
        .wp-block-tag-cloud a:hover {
            background: #f97316;
            color: white;
        }
    ";
    wp_add_inline_style('apex-theme-style', $comment_styles);
}
add_action('wp_enqueue_scripts', 'apex_theme_assets');

// Get top ancestor
function get_top_ancestor_id() {
	
	global $post;
	
	if ($post->post_parent) {
		$ancestors = array_reverse(get_post_ancestors($post->ID));
		return $ancestors[0];
		
	}
	
	return $post->ID;
	
}

// Does page have children?
function has_children() {
	
	global $post;
	
	$pages = get_pages('child_of=' . $post->ID);
	return count($pages);
	
}

// Customize excerpt word count length
function custom_excerpt_length() {
	return 25;
}

add_filter('excerpt_length', 'custom_excerpt_length');

// Add search widget styles in footer to override WordPress block styles
function apex_search_widget_styles() {
    ?>
    <style id="apex-search-override">
        /* Override WordPress Block Search Styles */
        .wp-block-search__input,
        .wp-block-search .wp-block-search__input,
        input.wp-block-search__input {
            border-radius: 9999px !important;
            padding: 12px 16px !important;
            border: 1px solid #e2e8f0 !important;
            background: white !important;
        }
        .wp-block-search__button,
        .wp-block-search .wp-block-search__button,
        button.wp-block-search__button {
            border-radius: 9999px !important;
            padding: 12px 20px !important;
            background: linear-gradient(to right, #f97316, #ea580c) !important;
            color: white !important;
            border: none !important;
            font-weight: 600 !important;
        }
        .wp-block-search__button:hover {
            background: linear-gradient(to right, #ea580c, #dc2626) !important;
        }
    </style>
    <?php
}
add_action('wp_footer', 'apex_search_widget_styles');

// Add Widget Areas
function apex_theme_widgets_init() {
	
	register_sidebar( array(
		'name' => 'Sidebar',
		'id' => 'sidebar1',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 1',
		'id' => 'footer1',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 2',
		'id' => 'footer2',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 3',
		'id' => 'footer3',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
	register_sidebar( array(
		'name' => 'Footer Area 4',
		'id' => 'footer4',
		'before_widget' => '<div class="widget-item">',
		'after_widget' => '</div>',
		'before_title' => '<h2 class="widget-title">',
		'after_title' => '</h2>',
	));
	
}

add_action('widgets_init', 'apex_theme_widgets_init');



// Add custom JavaScript for header functionality
function apex_header_scripts() {
    if (is_admin()) return;
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get current page URL for active state detection
        const currentUrl = window.location.pathname + window.location.search;
        const currentHost = window.location.hostname;
        
        // Function to check if a link is active
        function isLinkActive(href) {
            if (!href) return false;
            
            // Remove domain and protocol for comparison
            const linkPath = href.replace(/^https?:\/\/[^\/]+/, '');
            const currentPath = currentUrl;
            
            // Exact match
            if (linkPath === currentPath) return true;
            
            // Check if current path starts with link path (for parent pages)
            if (linkPath !== '/' && currentPath.startsWith(linkPath)) return true;
            
            // Special cases for home page
            if (linkPath === '/' || linkPath === '/index.php') {
                return currentPath === '/' || currentPath === '/index.php';
            }
            
            return false;
        }
        
        // Set active states for main navigation
        function setActiveStates() {
            // Main navigation links
            const mainLinks = document.querySelectorAll('.apex-nav-link, .apex-nav-trigger');
            mainLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && isLinkActive(href)) {
                    link.classList.add('apex-nav-active');
                }
            });
            
            // Dropdown links
            const dropdownLinks = document.querySelectorAll('.apex-nav-panel a');
            dropdownLinks.forEach(link => {
                const href = link.getAttribute('href');
                if (href && isLinkActive(href)) {
                    link.classList.add('apex-subnav-active');
                    
                    // Also mark parent dropdown as active
                    const parentPanel = link.closest('.apex-nav-panel');
                    if (parentPanel) {
                        const parentItem = parentPanel.closest('.apex-nav-item');
                        if (parentItem) {
                            const parentTrigger = parentItem.querySelector('.apex-nav-trigger');
                            if (parentTrigger) {
                                parentTrigger.classList.add('apex-nav-active');
                                // Add a special class to the parent item for CSS targeting
                                parentItem.classList.add('apex-nav-parent-active');
                            }
                        }
                    }
                }
            });
        }
        
        // Initialize active states
        setActiveStates();
        
        // NOTE: Desktop dropdown positioning and mobile menu toggle are handled in header.php inline script
        // to avoid duplicate event handlers causing conflicts
        
        // Header scroll effect
        let header = document.querySelector('header');
        if (header) {
            // Initial check in case page is loaded with scroll
            if (window.scrollY > 10) {
                header.classList.add('apex-header-scrolled');
                header.classList.add('bg-white/90', 'supports-[backdrop-filter]:bg-white/70', 'shadow-sm');
            }
            
            window.addEventListener('scroll', function() {
                if (window.scrollY > 10) {
                    header.classList.add('apex-header-scrolled');
                    header.classList.add('bg-white/90', 'supports-[backdrop-filter]:bg-white/70', 'shadow-sm');
                } else {
                    header.classList.remove('apex-header-scrolled');
                    header.classList.remove('bg-white/90', 'supports-[backdrop-filter]:bg-white/70', 'shadow-sm');
                }
            });
        }
    });
    </script>
    <?php
}
add_action('wp_footer', 'apex_header_scripts');

/**
 * Register custom rewrite rules for About Us pages
 */
function apex_about_us_rewrite_rules() {
    add_rewrite_rule('^about-us/?$', 'index.php?apex_about_page=overview', 'top');
    add_rewrite_rule('^about-us/overview/?$', 'index.php?apex_about_page=overview', 'top');
    add_rewrite_rule('^about-us/our-approach/?$', 'index.php?apex_about_page=our-approach', 'top');
    add_rewrite_rule('^about-us/leadership-team/?$', 'index.php?apex_about_page=leadership-team', 'top');
    add_rewrite_rule('^about-us/news/?$', 'index.php?apex_about_page=news', 'top');
}
add_action('init', 'apex_about_us_rewrite_rules');

/**
 * Register custom rewrite rules for Insights pages
 */
function apex_insights_rewrite_rules() {
    add_rewrite_rule('^insights/blog/?$', 'index.php?apex_insights_page=blog', 'top');
    add_rewrite_rule('^insights/success-stories/?$', 'index.php?apex_insights_page=success-stories', 'top');
    add_rewrite_rule('^insights/webinars/?$', 'index.php?apex_insights_page=webinars', 'top');
    add_rewrite_rule('^insights/whitepapers-reports/?$', 'index.php?apex_insights_page=whitepapers-reports', 'top');
}
add_action('init', 'apex_insights_rewrite_rules');

/**
 * Register custom rewrite rules for Contact page
 */
function apex_contact_rewrite_rules() {
    add_rewrite_rule('^contact/?$', 'index.php?apex_contact_page=contact', 'top');
}
add_action('init', 'apex_contact_rewrite_rules');

/**
 * Register custom rewrite rules for Industry pages
 */
function apex_industry_rewrite_rules() {
    add_rewrite_rule('^industry/overview/?$', 'index.php?apex_industry_page=overview', 'top');
    add_rewrite_rule('^industry/mfis/?$', 'index.php?apex_industry_page=mfis', 'top');
    add_rewrite_rule('^industry/credit-unions/?$', 'index.php?apex_industry_page=credit-unions', 'top');
    add_rewrite_rule('^industry/banks-microfinance/?$', 'index.php?apex_industry_page=banks', 'top');
    add_rewrite_rule('^industry/digital-government/?$', 'index.php?apex_industry_page=digital-government', 'top');
}
add_action('init', 'apex_industry_rewrite_rules');

/**
 * Register custom rewrite rules for Legal and Support pages
 */
function apex_support_rewrite_rules() {
    // Legal pages
    add_rewrite_rule('^privacy-policy/?$', 'index.php?apex_support_page=privacy-policy', 'top');
    add_rewrite_rule('^terms-and-conditions/?$', 'index.php?apex_support_page=terms-and-conditions', 'top');
    
    // Support pages
    add_rewrite_rule('^careers/?$', 'index.php?apex_support_page=careers', 'top');
    add_rewrite_rule('^help-support/?$', 'index.php?apex_support_page=help-support', 'top');
    add_rewrite_rule('^faq/?$', 'index.php?apex_support_page=faq', 'top');
    add_rewrite_rule('^knowledge-base/?$', 'index.php?apex_support_page=knowledge-base', 'top');
    add_rewrite_rule('^developers/?$', 'index.php?apex_support_page=developers', 'top');
    add_rewrite_rule('^partners/?$', 'index.php?apex_support_page=partners', 'top');
    add_rewrite_rule('^request-demo/?$', 'index.php?apex_support_page=request-demo', 'top');
}
add_action('init', 'apex_support_rewrite_rules');

/**
 * Register custom rewrite rules for Solutions pages
 */
function apex_solutions_rewrite_rules() {
    add_rewrite_rule('^solutions/overview/?$', 'index.php?apex_solutions_page=overview', 'top');
    add_rewrite_rule('^solutions/core-banking-microfinance/?$', 'index.php?apex_solutions_page=core-banking', 'top');
    add_rewrite_rule('^solutions/mobile-wallet-app/?$', 'index.php?apex_solutions_page=mobile-wallet', 'top');
    add_rewrite_rule('^solutions/agency-branch-banking/?$', 'index.php?apex_solutions_page=agency-banking', 'top');
    add_rewrite_rule('^solutions/internet-mobile-banking/?$', 'index.php?apex_solutions_page=internet-banking', 'top');
    add_rewrite_rule('^solutions/loan-origination-workflows/?$', 'index.php?apex_solutions_page=loan-origination', 'top');
    add_rewrite_rule('^solutions/digital-field-agent/?$', 'index.php?apex_solutions_page=field-agent', 'top');
    add_rewrite_rule('^solutions/enterprise-integration/?$', 'index.php?apex_solutions_page=enterprise-integration', 'top');
    add_rewrite_rule('^solutions/payment-switch-ledger/?$', 'index.php?apex_solutions_page=payment-switch', 'top');
    add_rewrite_rule('^solutions/reporting-analytics/?$', 'index.php?apex_solutions_page=reporting', 'top');
}
add_action('init', 'apex_solutions_rewrite_rules');

/**
 * Flush rewrite rules on theme activation
 */
function apex_flush_rewrite_rules() {
    apex_about_us_rewrite_rules();
    apex_insights_rewrite_rules();
    apex_contact_rewrite_rules();
    apex_industry_rewrite_rules();
    apex_support_rewrite_rules();
    apex_solutions_rewrite_rules();
    flush_rewrite_rules();
}
add_action('after_switch_theme', 'apex_flush_rewrite_rules');

/**
 * One-time flush for development (remove in production)
 */
function apex_maybe_flush_rules() {
    if (get_option('apex_rewrite_rules_flushed') !== '7') {
        flush_rewrite_rules();
        update_option('apex_rewrite_rules_flushed', '7');
    }
}
add_action('init', 'apex_maybe_flush_rules', 20);

/**
 * Register Website Settings Menu
 */
function apex_register_website_settings_menu() {
    // Add main menu
    add_menu_page(
        'Website Settings',
        'Website Settings',
        'edit_theme_options',
        'apex-website-settings',
        'apex_website_settings_overview',
        'dashicons-admin-settings',
        30
    );
    
    // Define hierarchical menu organization system
    $menu_hierarchy = [
        // Parent categories that can contain child items
        'parents' => [
            'about-us' => [
                'title' => 'About Us',
                'slug' => 'about-us-overview',
                'description' => 'About Us main pages and sub-pages',
                'children' => [
                    'about-us-overview',
                    'about-us-our-approach', 
                    'about-us-leadership-team',
                    'about-us-news'
                ]
            ],
            'solutions' => [
                'title' => 'Solutions',
                'slug' => 'solutions-overview',
                'description' => 'All Apex Solutions and services',
                'children' => [
                    'solutions-overview',
                    'solutions-core-banking-microfinance',
                    'solutions-mobile-wallet-app',
                    'solutions-agency-branch-banking',
                    'solutions-internet-mobile-banking',
                    'solutions-loan-origination-workflows',
                    'solutions-digital-field-agent',
                    'solutions-enterprise-integration',
                    'solutions-payment-switch-ledger',
                    'solutions-reporting-analytics'
                ]
            ],
            'industry' => [
                'title' => 'Industry',
                'slug' => 'industry-overview',
                'description' => 'Industry-specific solutions and services',
                'children' => [
                    'industry-overview',
                    'industry-mfis',
                    'industry-credit-unions',
                    'industry-banks-microfinance',
                    'industry-digital-government'
                ]
            ],
            'insights' => [
                'title' => 'Insights',
                'slug' => 'insights-blog',
                'description' => 'Blog, success stories, and resources',
                'children' => [
                    'insights-blog',
                    'insights-success-stories',
                    'insights-webinars',
                    'insights-whitepapers-reports'
                ]
            ],
            'support' => [
                'title' => 'Support',
                'slug' => 'help-support',
                'description' => 'Help, support, and additional resources',
                'children' => [
                    'careers',
                    'help-support',
                    'faq',
                    'knowledge-base',
                    'developers',
                    'partners',
                    'request-demo'
                ]
            ],
            'legal' => [
                'title' => 'Legal',
                'slug' => 'privacy-policy',
                'description' => 'Legal pages and policies',
                'children' => [
                    'privacy-policy',
                    'terms-and-conditions'
                ]
            ]
        ],
        
        // Standalone items that don't belong to any parent category
        'standalone' => [
            'home' => [
                'title' => 'Home',
                'slug' => '',
                'description' => 'Homepage content and hero section'
            ],
            'contact' => [
                'title' => 'Contact Us',
                'slug' => 'contact',
                'description' => 'Contact page and information'
            ]
        ]
    ];
    
    // Store hierarchy configuration globally for use in other functions
    global $apex_menu_hierarchy;
    $apex_menu_hierarchy = $menu_hierarchy;
    
    // Get navigation routes from header.php structure
    $navigation_routes = [
        // Main navigation items from header.php
        ['title' => 'Home', 'slug' => '', 'href' => home_url('/')],
        
        // About Us routes (parent + children)
        ['title' => 'About Apex Softwares', 'slug' => 'about-us-overview', 'href' => home_url('/about-us/overview')],
        ['title' => 'Our Approach', 'slug' => 'about-us-our-approach', 'href' => home_url('/about-us/our-approach'), 'parent' => 'About Us'],
        ['title' => 'Leadership Team', 'slug' => 'about-us-leadership-team', 'href' => home_url('/about-us/leadership-team'), 'parent' => 'About Us'],
        ['title' => 'News & Updates', 'slug' => 'about-us-news', 'href' => home_url('/about-us/news'), 'parent' => 'About Us'],
        
        // Solutions routes (parent + children)
        ['title' => 'Solutions', 'slug' => 'solutions-overview', 'href' => home_url('/solutions/overview')],
        ['title' => 'Core Banking & Microfinance', 'slug' => 'solutions-core-banking-microfinance', 'href' => home_url('/solutions/core-banking-microfinance'), 'parent' => 'Solutions'],
        ['title' => 'Mobile Wallet App', 'slug' => 'solutions-mobile-wallet-app', 'href' => home_url('/solutions/mobile-wallet-app'), 'parent' => 'Solutions'],
        ['title' => 'Agency & Branch Banking', 'slug' => 'solutions-agency-branch-banking', 'href' => home_url('/solutions/agency-branch-banking'), 'parent' => 'Solutions'],
        ['title' => 'Internet & Mobile Banking', 'slug' => 'solutions-internet-mobile-banking', 'href' => home_url('/solutions/internet-mobile-banking'), 'parent' => 'Solutions'],
        ['title' => 'Loan Origination & Workflows', 'slug' => 'solutions-loan-origination-workflows', 'href' => home_url('/solutions/loan-origination-workflows'), 'parent' => 'Solutions'],
        ['title' => 'Digital Field Agent', 'slug' => 'solutions-digital-field-agent', 'href' => home_url('/solutions/digital-field-agent'), 'parent' => 'Solutions'],
        ['title' => 'Enterprise Integration', 'slug' => 'solutions-enterprise-integration', 'href' => home_url('/solutions/enterprise-integration'), 'parent' => 'Solutions'],
        ['title' => 'Payment Switch & General Ledger', 'slug' => 'solutions-payment-switch-ledger', 'href' => home_url('/solutions/payment-switch-ledger'), 'parent' => 'Solutions'],
        ['title' => 'Reporting & Analytics', 'slug' => 'solutions-reporting-analytics', 'href' => home_url('/solutions/reporting-analytics'), 'parent' => 'Solutions'],
        
        // Industry routes (parent + children)
        ['title' => 'Industry', 'slug' => 'industry-overview', 'href' => home_url('/industry/overview')],
        ['title' => 'Microfinance Institutions (MFIs)', 'slug' => 'industry-mfis', 'href' => home_url('/industry/mfis'), 'parent' => 'Industry'],
        ['title' => 'SACCOs & Credit Unions', 'slug' => 'industry-credit-unions', 'href' => home_url('/industry/credit-unions'), 'parent' => 'Industry'],
        ['title' => 'Commercial Banks', 'slug' => 'industry-banks-microfinance', 'href' => home_url('/industry/banks-microfinance'), 'parent' => 'Industry'],
        ['title' => 'Digital Government & NGOs', 'slug' => 'industry-digital-government', 'href' => home_url('/industry/digital-government'), 'parent' => 'Industry'],
        
        // Insights routes (parent + children)
        ['title' => 'Insights', 'slug' => 'insights-blog', 'href' => home_url('/insights/blog')],
        ['title' => 'Success Stories', 'slug' => 'insights-success-stories', 'href' => home_url('/insights/success-stories'), 'parent' => 'Insights'],
        ['title' => 'Webinars & Events', 'slug' => 'insights-webinars', 'href' => home_url('/insights/webinars'), 'parent' => 'Insights'],
        ['title' => 'Whitepapers & Reports', 'slug' => 'insights-whitepapers-reports', 'href' => home_url('/insights/whitepapers-reports'), 'parent' => 'Insights'],
        
        // Standalone items
        ['title' => 'Contact Us', 'slug' => 'contact', 'href' => home_url('/contact')],
        
        // Footer routes from footer.php
        ['title' => 'Support', 'slug' => 'help-support', 'href' => home_url('/help-support')],
        ['title' => 'Careers', 'slug' => 'careers', 'href' => home_url('/careers'), 'parent' => 'Support'],
        ['title' => 'Help & Support', 'slug' => 'help-support', 'href' => home_url('/help-support'), 'parent' => 'Support'],
        ['title' => 'FAQ', 'slug' => 'faq', 'href' => home_url('/faq'), 'parent' => 'Support'],
        ['title' => 'Knowledge Base', 'slug' => 'knowledge-base', 'href' => home_url('/knowledge-base'), 'parent' => 'Support'],
        ['title' => 'Developers', 'slug' => 'developers', 'href' => home_url('/developers'), 'parent' => 'Support'],
        ['title' => 'Partners', 'slug' => 'partners', 'href' => home_url('/partners'), 'parent' => 'Support'],
        ['title' => 'Request Demo', 'slug' => 'request-demo', 'href' => home_url('/request-demo'), 'parent' => 'Support'],
        
        ['title' => 'Legal', 'slug' => 'privacy-policy', 'href' => home_url('/privacy-policy')],
        ['title' => 'Privacy Policy', 'slug' => 'privacy-policy', 'href' => home_url('/privacy-policy'), 'parent' => 'Legal'],
        ['title' => 'Terms and Conditions', 'slug' => 'terms-and-conditions', 'href' => home_url('/terms-and-conditions'), 'parent' => 'Legal'],
    ];
    
    // Add individual route pages as direct menu items (maintaining current structure)
    foreach ($navigation_routes as $route) {
        $menu_slug = 'apex-edit-' . $route['slug'];
        if (empty($route['slug'])) {
            $menu_slug = 'apex-edit-home';
        }
        
        add_submenu_page(
            'apex-website-settings',
            $route['title'],
            $route['title'],
            'edit_theme_options',
            $menu_slug,
            function() use ($route) {
                apex_render_page_editor($route['slug'], $route['title']);
            }
        );
    }
}
add_action('admin_menu', 'apex_register_website_settings_menu');

/**
 * Register ACF Options Page
 */
function apex_register_acf_options_page() {
    if (function_exists('acf_add_options_page')) {
        acf_add_options_page([
            'page_title'    => 'Website Settings',
            'menu_title'    => 'Website Settings',
            'menu_slug'     => 'apex-website-settings',
            'capability'    => 'edit_theme_options',
            'redirect'      => false,
            'parent_slug'   => '',
            'position'      => 30,
            'icon_url'      => 'dashicons-admin-settings',
            'update_button' => 'Save Changes',
            'updated_message' => 'Website settings updated successfully!'
        ]);
    }
}
add_action('acf/init', 'apex_register_acf_options_page');

/**
 * Get hierarchical menu organization
 */
function apex_get_menu_hierarchy() {
    global $apex_menu_hierarchy;
    
    if (!isset($apex_menu_hierarchy)) {
        // Default hierarchy if not set
        $apex_menu_hierarchy = [
            'parents' => [],
            'standalone' => []
        ];
    }
    
    return $apex_menu_hierarchy;
}

/**
 * Check if a menu item belongs to a parent category
 */
function apex_get_menu_item_parent($slug) {
    $hierarchy = apex_get_menu_hierarchy();
    
    foreach ($hierarchy['parents'] as $parent_key => $parent_data) {
        if (in_array($slug, $parent_data['children'])) {
            return $parent_key;
        }
    }
    
    return false;
}

/**
 * Get child items for a parent category
 */
function apex_get_parent_children($parent_key) {
    $hierarchy = apex_get_menu_hierarchy();
    
    if (isset($hierarchy['parents'][$parent_key])) {
        return $hierarchy['parents'][$parent_key]['children'];
    }
    
    return [];
}

/**
 * Get menu item display order based on hierarchy
 */
function apex_get_menu_item_order($slug) {
    $hierarchy = apex_get_menu_hierarchy();
    $order = 0;
    
    // Standalone items first
    foreach ($hierarchy['standalone'] as $key => $item) {
        $order++;
        if ($item['slug'] === $slug || (empty($item['slug']) && empty($slug))) {
            return $order;
        }
    }
    
    // Parent items and their children
    foreach ($hierarchy['parents'] as $parent_key => $parent_data) {
        $order++; // Parent item
        if ($parent_data['slug'] === $slug) {
            return $order;
        }
        
        // Child items
        foreach ($parent_data['children'] as $child_slug) {
            $order++;
            if ($child_slug === $slug) {
                return $order;
            }
        }
    }
    
    return $order;
}

/**
 * Website Settings Overview Page
 */
function apex_website_settings_overview() {
    $hierarchy = apex_get_menu_hierarchy();
    ?>
    <div class="wrap">
        <h1>Website Settings - Content Management</h1>
        <p>Click on any menu item on the left to edit that page's content dynamically. Menu items are organized hierarchically with parent categories containing child sub-items.</p>
        
        <div class="apex-menu-organization">
            <h2>Menu Organization Structure</h2>
            <p>The menu is organized in a hierarchical tree structure where parent categories can contain multiple child sub-items.</p>
            
            <div class="apex-hierarchy-display">
                <!-- Standalone Items -->
                <?php if (!empty($hierarchy['standalone'])): ?>
                <div class="apex-hierarchy-section">
                    <h3>Standalone Items</h3>
                    <div class="apex-hierarchy-items">
                        <?php foreach ($hierarchy['standalone'] as $key => $item): ?>
                            <div class="apex-hierarchy-item apex-standalone-item">
                                <div class="apex-item-content">
                                    <strong><?php echo esc_html($item['title']); ?></strong>
                                    <?php if (!empty($item['description'])): ?>
                                        <span class="apex-item-description"><?php echo esc_html($item['description']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="apex-item-actions">
                                    <a href="<?php echo admin_url('admin.php?page=apex-edit-' . ($item['slug'] ?: 'home')); ?>" class="button button-small">Edit</a>
                                    <a href="<?php echo empty($item['slug']) ? home_url('/') : home_url('/' . $item['slug']); ?>" target="_blank" class="button button-small button-secondary">View</a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Parent Categories with Children -->
                <?php if (!empty($hierarchy['parents'])): ?>
                <div class="apex-hierarchy-section">
                    <h3>Hierarchical Categories</h3>
                    <div class="apex-hierarchy-tree">
                        <?php foreach ($hierarchy['parents'] as $parent_key => $parent_data): ?>
                            <div class="apex-parent-category">
                                <div class="apex-parent-header">
                                    <div class="apex-parent-info">
                                        <strong><?php echo esc_html($parent_data['title']); ?></strong>
                                        <?php if (!empty($parent_data['description'])): ?>
                                            <span class="apex-parent-description"><?php echo esc_html($parent_data['description']); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <div class="apex-parent-actions">
                                        <a href="<?php echo admin_url('admin.php?page=apex-edit-' . $parent_data['slug']); ?>" class="button button-small">Edit Parent</a>
                                        <a href="<?php echo home_url('/' . $parent_data['slug']); ?>" target="_blank" class="button button-small button-secondary">View Parent</a>
                                    </div>
                                </div>
                                
                                <div class="apex-child-items">
                                    <?php foreach ($parent_data['children'] as $child_slug): 
                                        $child_title = apex_get_menu_item_title($child_slug);
                                        $child_url = empty($child_slug) ? home_url('/') : home_url('/' . $child_slug);
                                    ?>
                                        <div class="apex-child-item">
                                            <div class="apex-child-content">
                                                <span class="apex-child-indicator">→</span>
                                                <strong><?php echo esc_html($child_title); ?></strong>
                                            </div>
                                            <div class="apex-child-actions">
                                                <a href="<?php echo admin_url('admin.php?page=apex-edit-' . (empty($child_slug) ? 'home' : $child_slug)); ?>" class="button button-small">Edit</a>
                                                <a href="<?php echo esc_url($child_url); ?>" target="_blank" class="button button-small button-secondary">View</a>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <div class="apex-organization-info">
                <h3>How the Hierarchy Works</h3>
                <ul>
                    <li><strong>Parent Categories</strong>: Main menu items that can contain sub-items (like "Solutions", "Industry", "About Us")</li>
                    <li><strong>Child Sub-items</strong>: Individual pages organized under their parent categories</li>
                    <li><strong>Standalone Items</strong>: Top-level items that don't belong to any parent category (like "Home", "Contact Us")</li>
                    <li><strong>Navigation</strong>: Click any menu item on the left sidebar to edit that page's content</li>
                </ul>
            </div>
        </div>
    </div>
    
    <style>
        .apex-menu-organization {
            margin-top: 30px;
        }
        .apex-hierarchy-display {
            background: #f8f9fa;
            border: 1px solid #e1e1e1;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 30px;
        }
        .apex-hierarchy-section {
            margin-bottom: 30px;
        }
        .apex-hierarchy-section h3 {
            margin-bottom: 15px;
            color: #23282d;
            border-bottom: 2px solid #0073aa;
            padding-bottom: 5px;
        }
        .apex-hierarchy-items {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        .apex-hierarchy-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 15px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .apex-item-content {
            flex: 1;
        }
        .apex-item-description {
            display: block;
            color: #666;
            font-size: 13px;
            margin-top: 4px;
        }
        .apex-item-actions {
            display: flex;
            gap: 8px;
        }
        .apex-hierarchy-tree {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        .apex-parent-category {
            background: #fff;
            border: 2px solid #0073aa;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }
        .apex-parent-header {
            background: #0073aa;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .apex-parent-info strong {
            font-size: 16px;
        }
        .apex-parent-description {
            display: block;
            font-size: 13px;
            opacity: 0.9;
            margin-top: 4px;
        }
        .apex-parent-actions {
            display: flex;
            gap: 8px;
        }
        .apex-parent-actions .button {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.3);
            color: white;
        }
        .apex-parent-actions .button:hover {
            background: rgba(255,255,255,0.3);
        }
        .apex-child-items {
            padding: 15px 20px;
            background: #f8f9fa;
        }
        .apex-child-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            margin-bottom: 8px;
            background: white;
            border: 1px solid #e1e1e1;
            border-radius: 4px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.05);
        }
        .apex-child-item:last-child {
            margin-bottom: 0;
        }
        .apex-child-content {
            display: flex;
            align-items: center;
            flex: 1;
        }
        .apex-child-indicator {
            color: #0073aa;
            font-weight: bold;
            margin-right: 10px;
            font-size: 14px;
        }
        .apex-child-actions {
            display: flex;
            gap: 8px;
        }
        .apex-organization-info {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 20px;
        }
        .apex-organization-info h3 {
            margin-top: 0;
            color: #23282d;
        }
        .apex-organization-info ul {
            margin: 0;
            padding-left: 20px;
        }
        .apex-organization-info li {
            margin-bottom: 8px;
            color: #555;
        }
    </style>
    <?php
}

/**
 * Get menu item title from slug
 */
function apex_get_menu_item_title($slug) {
    $title_map = [
        '' => 'Home',
        'about-us-overview' => 'About Apex Softwares',
        'about-us-our-approach' => 'Our Approach',
        'about-us-leadership-team' => 'Leadership Team',
        'about-us-news' => 'News & Updates',
        'solutions-overview' => 'Solutions Overview',
        'solutions-core-banking-microfinance' => 'Core Banking & Microfinance',
        'solutions-mobile-wallet-app' => 'Mobile Wallet App',
        'solutions-agency-branch-banking' => 'Agency & Branch Banking',
        'solutions-internet-mobile-banking' => 'Internet & Mobile Banking',
        'solutions-loan-origination-workflows' => 'Loan Origination & Workflows',
        'solutions-digital-field-agent' => 'Digital Field Agent',
        'solutions-enterprise-integration' => 'Enterprise Integration',
        'solutions-payment-switch-ledger' => 'Payment Switch & General Ledger',
        'solutions-reporting-analytics' => 'Reporting & Analytics',
        'industry-overview' => 'Industry Overview',
        'industry-mfis' => 'Microfinance Institutions (MFIs)',
        'industry-credit-unions' => 'SACCOs & Credit Unions',
        'industry-banks-microfinance' => 'Commercial Banks',
        'industry-digital-government' => 'Digital Government & NGOs',
        'insights-blog' => 'Blog',
        'insights-success-stories' => 'Success Stories',
        'insights-webinars' => 'Webinars & Events',
        'insights-whitepapers-reports' => 'Whitepapers & Reports',
        'contact' => 'Contact Us',
    ];
    
    return isset($title_map[$slug]) ? $title_map[$slug] : ucwords(str_replace(['-', '_'], ' ', $slug));
}

/**
 * Parent Menu Page for Grouped Routes
 */
function apex_website_settings_parent_menu($routes, $parent_name) {
    ?>
    <div class="wrap">
        <h1><?php echo esc_html($parent_name); ?> - Content Management</h1>
        <p>Select a page to edit its content:</p>
        
        <div class="apex-route-list">
            <?php foreach ($routes as $route): ?>
                <div class="apex-route-item">
                    <h3><?php echo esc_html($route['title']); ?></h3>
                    <div class="apex-route-actions">
                        <a href="<?php echo admin_url('admin.php?page=apex-edit-' . $route['slug']); ?>" class="button button-primary">Edit Content</a>
                        <a href="<?php echo home_url('/' . $route['slug']); ?>" target="_blank" class="button button-secondary">View Page</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <style>
        .apex-route-list {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
        .apex-route-item {
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 20px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .apex-route-item h3 {
            margin-top: 0;
            color: #23282d;
        }
        .apex-route-actions {
            margin-top: 15px;
        }
        .apex-route-actions .button {
            margin-right: 10px;
        }
    </style>
    <?php
}

/**
 * Render ACF form for editing a specific page
 */
function apex_render_page_editor($page_slug, $page_title) {
    // Handle home page special case
    if (empty($page_slug)) {
        $page_slug = 'home';
    }
    
    // Map page slugs to ACF field group keys and page titles
    $page_config = [
        'home' => [
            'title' => 'Home Page',
            'acf_group' => 'group_home_hero'
        ],
        'about-us-overview' => [
            'title' => 'About Apex Softwares Overview',
            'acf_group' => 'group_about_us_hero'
        ],
        'about-us-our-approach' => [
            'title' => 'Our Approach',
            'acf_group' => 'group_about_us_approach'
        ],
        'about-us-leadership-team' => [
            'title' => 'Leadership Team',
            'acf_group' => 'group_about_us_leadership'
        ],
        'about-us-news' => [
            'title' => 'News & Updates',
            'acf_group' => 'group_about_us_news'
        ],
        'solutions-overview' => [
            'title' => 'Solutions Overview',
            'acf_group' => 'group_solutions_overview'
        ],
        'solutions-core-banking-microfinance' => [
            'title' => 'Core Banking & Microfinance',
            'acf_group' => 'group_solutions_core_banking'
        ],
        'solutions-mobile-wallet-app' => [
            'title' => 'Mobile Wallet App',
            'acf_group' => 'group_solutions_mobile_wallet'
        ],
        'solutions-agency-branch-banking' => [
            'title' => 'Agency & Branch Banking',
            'acf_group' => 'group_solutions_agency_banking'
        ],
        'solutions-internet-mobile-banking' => [
            'title' => 'Internet & Mobile Banking',
            'acf_group' => 'group_solutions_internet_banking'
        ],
        'solutions-loan-origination-workflows' => [
            'title' => 'Loan Origination & Workflows',
            'acf_group' => 'group_solutions_loan_origination'
        ],
        'solutions-digital-field-agent' => [
            'title' => 'Digital Field Agent',
            'acf_group' => 'group_solutions_field_agent'
        ],
        'solutions-enterprise-integration' => [
            'title' => 'Enterprise Integration',
            'acf_group' => 'group_solutions_enterprise_integration'
        ],
        'solutions-payment-switch-ledger' => [
            'title' => 'Payment Switch & General Ledger',
            'acf_group' => 'group_solutions_payment_switch'
        ],
        'solutions-reporting-analytics' => [
            'title' => 'Reporting & Analytics',
            'acf_group' => 'group_solutions_reporting'
        ],
        'industry-overview' => [
            'title' => 'Industry Overview',
            'acf_group' => 'group_industry_overview'
        ],
        'industry-mfis' => [
            'title' => 'Microfinance Institutions (MFIs)',
            'acf_group' => 'group_industry_mfis'
        ],
        'industry-credit-unions' => [
            'title' => 'SACCOs & Credit Unions',
            'acf_group' => 'group_industry_credit_unions'
        ],
        'industry-banks-microfinance' => [
            'title' => 'Commercial Banks',
            'acf_group' => 'group_industry_banks'
        ],
        'industry-digital-government' => [
            'title' => 'Digital Government & NGOs',
            'acf_group' => 'group_industry_digital_government'
        ],
        'insights-blog' => [
            'title' => 'Blog',
            'acf_group' => 'group_insights_blog'
        ],
        'insights-success-stories' => [
            'title' => 'Success Stories',
            'acf_group' => 'group_insights_success_stories'
        ],
        'insights-webinars' => [
            'title' => 'Webinars & Events',
            'acf_group' => 'group_insights_webinars'
        ],
        'insights-whitepapers-reports' => [
            'title' => 'Whitepapers & Reports',
            'acf_group' => 'group_insights_whitepapers'
        ],
        'contact' => [
            'title' => 'Contact Us',
            'acf_group' => 'group_contact'
        ],
        // Add more page configurations as needed
    ];
    
    if (!isset($page_config[$page_slug])) {
        echo '<div class="wrap"><h1>Page not found</h1><p>The requested page editor is not available.</p></div>';
        return;
    }
    
    $config = $page_config[$page_slug];
    
    ?>
    <div class="wrap">
        <h1>Edit: <?php echo esc_html($config['title']); ?></h1>
        <a href="<?php echo admin_url('admin.php?page=apex-website-settings'); ?>" class="button">← Back to Overview</a>
        <a href="<?php echo empty($page_slug) || $page_slug === 'home' ? home_url('/') : home_url('/' . $page_slug); ?>" target="_blank" class="button button-secondary" style="margin-left: 10px;">View Page</a>
        
        <div style="margin-top: 20px;">
            <?php 
            // Render ACF form for this page
            if (function_exists('acf_form')) {
                echo '<div style="background: #e7f3ff; padding: 10px; margin-bottom: 20px; border: 1px solid #3498db;">';
                echo '<strong>Attempting to render ACF form...</strong><br>';
                echo 'Post ID: options<br>';
                echo 'Field Groups: ' . esc_html($config['acf_group']) . '<br>';
                echo '</div>';
                
                acf_form([
                    'post_id' => 'options', // Use options page
                    'field_groups' => [$config['acf_group']],
                    'return' => admin_url('admin.php?page=apex-website-settings'),
                    'submit_value' => 'Save Changes',
                ]);
                
                echo '<div style="background: #d4edda; padding: 10px; margin-top: 20px; border: 1px solid #28a745;">';
                echo '<strong>ACF form rendering completed.</strong>';
                echo '</div>';
            } else {
                // Fallback form when ACF is not available
                apex_render_fallback_form($page_slug, $config);
            }
            ?>
        </div>
    </div>
    <?php
}

/**
 * Render fallback form when ACF is not available
 */
function apex_render_fallback_form($page_slug, $config) {
    ?>
    <form method="post" action="" style="background: #f8f9fa; padding: 20px; border: 1px solid #dee2e6; border-radius: 6px;">
        <?php wp_nonce_field('apex_save_fallback_content', 'apex_fallback_nonce'); ?>
        <input type="hidden" name="apex_page_slug" value="<?php echo esc_attr($page_slug); ?>">
        
        <h3>Edit Content: <?php echo esc_html($config['title']); ?></h3>
        <p class="description">Update the content for this page. Changes will appear immediately on the frontend.</p>
        
        <!-- Hero Section -->
        <div style="margin-bottom: 30px;">
            <h4>🚀 Hero Section</h4>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_hero_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_hero_badge" name="apex_hero_badge" 
                               value="<?php echo esc_attr(get_option('apex_hero_badge_' . $page_slug, 'About Apex Softwares')); ?>" 
                               class="regular-text" placeholder="e.g., About Apex Softwares">
                        <p class="description">The small badge text above the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_heading">Main Heading</label></th>
                    <td>
                        <input type="text" id="apex_hero_heading" name="apex_hero_heading" 
                               value="<?php echo esc_attr(get_option('apex_hero_heading_' . $page_slug, 'Transforming Financial Services Across Africa')); ?>" 
                               class="regular-text" placeholder="Main hero heading">
                        <p class="description">The main heading for the hero section</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_description">Description</label></th>
                    <td>
                        <textarea id="apex_hero_description" name="apex_hero_description" rows="4" class="large-text"
                                  placeholder="Hero section description"><?php echo esc_textarea(get_option('apex_hero_description_' . $page_slug, "For over a decade, we've been at the forefront of financial technology innovation, empowering institutions to deliver exceptional digital experiences.")); ?></textarea>
                        <p class="description">The description text below the heading</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_image">Hero Image URL</label></th>
                    <td>
                        <input type="url" id="apex_hero_image" name="apex_hero_image" 
                               value="<?php echo esc_attr(get_option('apex_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200')); ?>" 
                               class="large-text" placeholder="https://example.com/image.jpg">
                        <p class="description">The main hero image URL (recommended size: 1200x800px)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_hero_stats">Statistics</label></th>
                    <td>
                        <textarea id="apex_hero_stats" name="apex_hero_stats" rows="6" class="large-text"
                                  placeholder="100+ Financial Institutions&#10;15+ Countries&#10;10M+ End Users&#10;14+ Years Experience"><?php 
                            $stats = get_option('apex_hero_stats_' . $page_slug, "100+ Financial Institutions\n15+ Countries\n10M+ End Users\n14+ Years Experience");
                            echo esc_textarea($stats);
                        ?></textarea>
                        <p class="description">One statistic per line in format: "Value Label"</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Our Story Section -->
        <div style="margin-bottom: 30px;">
            <h4>📖 Our Story Section</h4>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_story_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_story_badge" name="apex_story_badge" 
                               value="<?php echo esc_attr(get_option('apex_story_badge_' . $page_slug, 'Our Story')); ?>" 
                               class="regular-text" placeholder="e.g., Our Story">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_story_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_story_heading" name="apex_story_heading" 
                               value="<?php echo esc_attr(get_option('apex_story_heading_' . $page_slug, 'From Vision to Reality')); ?>" 
                               class="regular-text" placeholder="Section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_story_content">Content Paragraphs</label></th>
                    <td>
                        <textarea id="apex_story_content" name="apex_story_content" rows="6" class="large-text"
                                  placeholder="Enter each paragraph on a new line"><?php 
                            $content = get_option('apex_story_content_' . $page_slug, "Founded in 2010, Apex Softwares began with a simple yet powerful vision: to democratize access to modern banking technology across Africa.\nOur journey has been defined by a relentless focus on innovation, customer success, and the belief that every financial institution—regardless of size—deserves access to world-class technology.\nToday, we continue to push boundaries, developing solutions that help our partners reach more customers, reduce costs, and compete effectively in an increasingly digital world.");
                            echo esc_textarea($content);
                        ?></textarea>
                        <p class="description">Each paragraph should be on a new line</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_story_milestones">Milestones</label></th>
                    <td>
                        <textarea id="apex_story_milestones" name="apex_story_milestones" rows="8" class="large-text"
                                  placeholder="2010 | Company Founded | Started with a vision to transform African banking&#10;2013 | First Major Client | Deployed ApexCore to our first SACCO partner&#10;2016 | Mobile Banking Launch | Introduced mobile and agent banking solutions"><?php 
                            $milestones = get_option('apex_story_milestones_' . $page_slug, "2010 | Company Founded | Started with a vision to transform African banking\n2013 | First Major Client | Deployed ApexCore to our first SACCO partner\n2016 | Mobile Banking Launch | Introduced mobile and agent banking solutions\n2019 | Pan-African Expansion | Extended operations to 10+ African countries\n2022 | 100+ Clients Milestone | Reached 100 financial institution partners\n2024 | Next-Gen Platform | Launched cloud-native ApexCore 3.0");
                            echo esc_textarea($milestones);
                        ?></textarea>
                        <p class="description">Format: Year | Title | Description (one per line)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Mission & Vision Section -->
        <div style="margin-bottom: 30px;">
            <h4>🎯 Mission & Vision Section</h4>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_mission_title">Mission Title</label></th>
                    <td>
                        <input type="text" id="apex_mission_title" name="apex_mission_title" 
                               value="<?php echo esc_attr(get_option('apex_mission_title_' . $page_slug, 'Our Mission')); ?>" 
                               class="regular-text" placeholder="e.g., Our Mission">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_mission_description">Mission Description</label></th>
                    <td>
                        <textarea id="apex_mission_description" name="apex_mission_description" rows="3" class="large-text"
                                  placeholder="Mission description"><?php 
                            $mission_desc = get_option('apex_mission_description_' . $page_slug, 'To empower financial institutions with innovative, accessible, and secure technology solutions that drive financial inclusion and economic growth across Africa.');
                            echo esc_textarea($mission_desc);
                        ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_vision_title">Vision Title</label></th>
                    <td>
                        <input type="text" id="apex_vision_title" name="apex_vision_title" 
                               value="<?php echo esc_attr(get_option('apex_vision_title_' . $page_slug, 'Our Vision')); ?>" 
                               class="regular-text" placeholder="e.g., Our Vision">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_vision_description">Vision Description</label></th>
                    <td>
                        <textarea id="apex_vision_description" name="apex_vision_description" rows="3" class="large-text"
                                  placeholder="Vision description"><?php 
                            $vision_desc = get_option('apex_vision_description_' . $page_slug, 'To be the leading financial technology partner in Africa, enabling every institution to deliver world-class digital banking experiences to their customers.');
                            echo esc_textarea($vision_desc);
                        ?></textarea>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Core Values Section -->
        <div style="margin-bottom: 30px;">
            <h4>💎 Core Values Section</h4>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_values">Core Values</label></th>
                    <td>
                        <textarea id="apex_values" name="apex_values" rows="10" class="large-text"
                                  placeholder="Innovation | lightbulb | We continuously push boundaries to deliver cutting-edge solutions that anticipate market needs.&#10;Partnership | handshake | We succeed when our clients succeed. Their growth is our primary measure of success."><?php 
                            $values = get_option('apex_values_' . $page_slug, "Innovation | lightbulb | We continuously push boundaries to deliver cutting-edge solutions that anticipate market needs.\nPartnership | handshake | We succeed when our clients succeed. Their growth is our primary measure of success.\nIntegrity | shield | We operate with transparency, honesty, and the highest ethical standards in everything we do.\nCustomer Focus | users | Every decision we make is guided by how it will benefit our clients and their customers.\nExcellence | rocket | We strive for excellence in our products, services, and every interaction with stakeholders.\nImpact | heart | We measure our success by the positive impact we create for communities across Africa.");
                            echo esc_textarea($values);
                        ?></textarea>
                        <p class="description">Format: Value Name | Icon | Description (one per line)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Leadership Section -->
        <div style="margin-bottom: 30px;">
            <h4>👥 Leadership Team Section</h4>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_leadership_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_leadership_badge" name="apex_leadership_badge" 
                               value="<?php echo esc_attr(get_option('apex_leadership_badge_' . $page_slug, 'Leadership')); ?>" 
                               class="regular-text" placeholder="e.g., Leadership">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_leadership_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_leadership_heading" name="apex_leadership_heading" 
                               value="<?php echo esc_attr(get_option('apex_leadership_heading_' . $page_slug, 'Meet Our Team')); ?>" 
                               class="regular-text" placeholder="Section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_leadership_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_leadership_description" name="apex_leadership_description" rows="2" class="large-text"
                                  placeholder="Section description"><?php 
                            $leadership_desc = get_option('apex_leadership_description_' . $page_slug, 'Our leadership team brings together decades of experience in financial technology, banking, and software development.');
                            echo esc_textarea($leadership_desc);
                        ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_team_members">Team Members</label></th>
                    <td>
                        <textarea id="apex_team_members" name="apex_team_members" rows="12" class="large-text"
                                  placeholder="John Kamau | Chief Executive Officer | https://example.com/john-image.jpg | With 20+ years in fintech, John leads our vision to transform African banking. | https://linkedin.com/in/johnkamau | https://twitter.com/johnkamau"><?php 
                            $team = get_option('apex_team_members_' . $page_slug, "John Kamau | Chief Executive Officer | https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=400 | With 20+ years in fintech, John leads our vision to transform African banking. | # | #\nSarah Ochieng | Chief Technology Officer | https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=400 | Sarah drives our technology strategy and product innovation initiatives. | # | #\nMichael Njoroge | Chief Operations Officer | https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=400 | Michael ensures operational excellence across all our client implementations. | # | #\nGrace Wanjiku | Chief Financial Officer | https://images.unsplash.com/photo-1580489944761-15a19d654956?w=400 | Grace oversees our financial strategy and sustainable growth initiatives. | # | #");
                            echo esc_textarea($team);
                        ?></textarea>
                        <p class="description">Format: Name | Role | Image URL | Bio | LinkedIn URL | Twitter URL (one per line)</p>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Our Reach Section -->
        <div style="margin-bottom: 30px;">
            <h4>🌍 Our Reach Section</h4>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="apex_reach_badge">Badge Text</label></th>
                    <td>
                        <input type="text" id="apex_reach_badge" name="apex_reach_badge" 
                               value="<?php echo esc_attr(get_option('apex_reach_badge_' . $page_slug, 'Our Reach')); ?>" 
                               class="regular-text" placeholder="e.g., Our Reach">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reach_heading">Section Heading</label></th>
                    <td>
                        <input type="text" id="apex_reach_heading" name="apex_reach_heading" 
                               value="<?php echo esc_attr(get_option('apex_reach_heading_' . $page_slug, 'Pan-African Presence')); ?>" 
                               class="regular-text" placeholder="Section heading">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_reach_description">Section Description</label></th>
                    <td>
                        <textarea id="apex_reach_description" name="apex_reach_description" rows="2" class="large-text"
                                  placeholder="Section description"><?php 
                            $reach_desc = get_option('apex_reach_description_' . $page_slug, 'From our headquarters in Nairobi, we serve financial institutions across the African continent.');
                            echo esc_textarea($reach_desc);
                        ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_regions">Regions</label></th>
                    <td>
                        <textarea id="apex_regions" name="apex_regions" rows="6" class="large-text"
                                  placeholder="East Africa | Kenya, Uganda, Tanzania, Rwanda, Ethiopia | 60+&#10;West Africa | Nigeria, Ghana, Senegal, Ivory Coast | 25+"><?php 
                            $regions = get_option('apex_regions_' . $page_slug, "East Africa | Kenya, Uganda, Tanzania, Rwanda, Ethiopia | 60+\nWest Africa | Nigeria, Ghana, Senegal, Ivory Coast | 25+\nSouthern Africa | South Africa, Zambia, Zimbabwe, Malawi | 15+\nCentral Africa | DRC, Cameroon | 5+");
                            echo esc_textarea($regions);
                        ?></textarea>
                        <p class="description">Format: Region Name | Countries (comma-separated) | Clients Count (one per line)</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_headquarters_city">Headquarters City</label></th>
                    <td>
                        <input type="text" id="apex_headquarters_city" name="apex_headquarters_city" 
                               value="<?php echo esc_attr(get_option('apex_headquarters_city_' . $page_slug, 'Nairobi')); ?>" 
                               class="regular-text" placeholder="e.g., Nairobi">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_headquarters_country">Headquarters Country</label></th>
                    <td>
                        <input type="text" id="apex_headquarters_country" name="apex_headquarters_country" 
                               value="<?php echo esc_attr(get_option('apex_headquarters_country_' . $page_slug, 'Kenya')); ?>" 
                               class="regular-text" placeholder="e.g., Kenya">
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="apex_headquarters_address">Headquarters Address</label></th>
                    <td>
                        <input type="text" id="apex_headquarters_address" name="apex_headquarters_address" 
                               value="<?php echo esc_attr(get_option('apex_headquarters_address_' . $page_slug, 'Westlands Business Park, 4th Floor')); ?>" 
                               class="regular-text" placeholder="Full address">
                    </td>
                </tr>
            </table>
        </div>
        
        <p class="submit">
            <input type="submit" name="apex_save_fallback" id="apex_save_fallback" class="button button-primary" value="Save Changes">
            <a href="<?php echo admin_url('admin.php?page=apex-website-settings'); ?>" class="button">← Back to Overview</a>
            <a href="<?php echo empty($page_slug) || $page_slug === 'home' ? home_url('/') : home_url('/' . $page_slug); ?>" target="_blank" class="button button-secondary" style="margin-left: 10px;">View Page</a>
        </p>
    </form>
    
    <?php
    // Handle form submission
    if (isset($_POST['apex_save_fallback']) && check_admin_referer('apex_save_fallback_content', 'apex_fallback_nonce')) {
        $page_slug = sanitize_text_field($_POST['apex_page_slug']);
        
        // Save Hero Section
        update_option('apex_hero_badge_' . $page_slug, sanitize_text_field($_POST['apex_hero_badge']));
        update_option('apex_hero_heading_' . $page_slug, sanitize_text_field($_POST['apex_hero_heading']));
        update_option('apex_hero_description_' . $page_slug, sanitize_textarea_field($_POST['apex_hero_description']));
        update_option('apex_hero_image_' . $page_slug, esc_url_raw($_POST['apex_hero_image']));
        update_option('apex_hero_stats_' . $page_slug, sanitize_textarea_field($_POST['apex_hero_stats']));
        
        // Save Story Section
        update_option('apex_story_badge_' . $page_slug, sanitize_text_field($_POST['apex_story_badge']));
        update_option('apex_story_heading_' . $page_slug, sanitize_text_field($_POST['apex_story_heading']));
        update_option('apex_story_content_' . $page_slug, sanitize_textarea_field($_POST['apex_story_content']));
        update_option('apex_story_milestones_' . $page_slug, sanitize_textarea_field($_POST['apex_story_milestones']));
        
        // Save Mission & Vision Section
        update_option('apex_mission_title_' . $page_slug, sanitize_text_field($_POST['apex_mission_title']));
        update_option('apex_mission_description_' . $page_slug, sanitize_textarea_field($_POST['apex_mission_description']));
        update_option('apex_vision_title_' . $page_slug, sanitize_text_field($_POST['apex_vision_title']));
        update_option('apex_vision_description_' . $page_slug, sanitize_textarea_field($_POST['apex_vision_description']));
        
        // Save Core Values Section
        update_option('apex_values_' . $page_slug, sanitize_textarea_field($_POST['apex_values']));
        
        // Save Leadership Section
        update_option('apex_leadership_badge_' . $page_slug, sanitize_text_field($_POST['apex_leadership_badge']));
        update_option('apex_leadership_heading_' . $page_slug, sanitize_text_field($_POST['apex_leadership_heading']));
        update_option('apex_leadership_description_' . $page_slug, sanitize_textarea_field($_POST['apex_leadership_description']));
        update_option('apex_team_members_' . $page_slug, sanitize_textarea_field($_POST['apex_team_members']));
        
        // Save Reach Section
        update_option('apex_reach_badge_' . $page_slug, sanitize_text_field($_POST['apex_reach_badge']));
        update_option('apex_reach_heading_' . $page_slug, sanitize_text_field($_POST['apex_reach_heading']));
        update_option('apex_reach_description_' . $page_slug, sanitize_textarea_field($_POST['apex_reach_description']));
        update_option('apex_regions_' . $page_slug, sanitize_textarea_field($_POST['apex_regions']));
        update_option('apex_headquarters_city_' . $page_slug, sanitize_text_field($_POST['apex_headquarters_city']));
        update_option('apex_headquarters_country_' . $page_slug, sanitize_text_field($_POST['apex_headquarters_country']));
        update_option('apex_headquarters_address_' . $page_slug, sanitize_text_field($_POST['apex_headquarters_address']));
        
        echo '<div class="notice notice-success is-dismissible"><p>All sections content saved successfully! Changes will appear on the frontend.</p></div>';
    }
}

/**
 * Get fallback content data
 */
function apex_get_fallback_content($page_slug) {
    return [
        'badge' => get_option('apex_hero_badge_' . $page_slug, 'About Apex Softwares'),
        'heading' => get_option('apex_hero_heading_' . $page_slug, 'Transforming Financial Services Across Africa'),
        'description' => get_option('apex_hero_description_' . $page_slug, "For over a decade, we've been at the forefront of financial technology innovation, empowering institutions to deliver exceptional digital experiences."),
        'image' => get_option('apex_hero_image_' . $page_slug, 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200'),
        'stats' => get_option('apex_hero_stats_' . $page_slug, "100+ Financial Institutions\n15+ Countries\n10M+ End Users\n14+ Years Experience")
    ];
}
function apex_header_footer_settings_page() {
    ?>
    <div class="wrap">
        <h1>Website Settings - Header & Footer</h1>
        <p>Manage header and footer content settings.</p>
        <!-- ACF form will be loaded here -->
    </div>
    <?php
}

/**
 * Global Settings Page
 */
function apex_global_settings_page() {
    ?>
    <div class="wrap">
        <h1>Website Settings - Global Settings</h1>
        <p>Manage global website settings.</p>
        <!-- ACF form will be loaded here -->
    </div>
    <?php
}

/**
 * Register custom query vars
 */
function apex_about_us_query_vars($vars) {
    $vars[] = 'apex_about_page';
    $vars[] = 'apex_insights_page';
    $vars[] = 'apex_contact_page';
    $vars[] = 'apex_industry_page';
    $vars[] = 'apex_support_page';
    $vars[] = 'apex_solutions_page';
    return $vars;
}
add_filter('query_vars', 'apex_about_us_query_vars');

/**
 * Handle About Us pages early in the request lifecycle
 */
function apex_about_us_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of about-us URLs to their templates
    $about_templates = [
        'about-us' => 'page-about-us-overview.php',
        'about-us/' => 'page-about-us-overview.php',
        'about-us/overview' => 'page-about-us-overview.php',
        'about-us/overview/' => 'page-about-us-overview.php',
        'about-us/our-approach' => 'page-about-us-our-approach.php',
        'about-us/our-approach/' => 'page-about-us-our-approach.php',
        'about-us/leadership-team' => 'page-about-us-leadership-team.php',
        'about-us/leadership-team/' => 'page-about-us-leadership-team.php',
        'about-us/news' => 'page-about-us-news.php',
        'about-us/news/' => 'page-about-us-news.php',
    ];
    
    if (isset($about_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $about_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_about_us_template_redirect', 1);

/**
 * Handle Insights pages early in the request lifecycle
 */
function apex_insights_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of insights URLs to their templates
    $insights_templates = [
        'insights/blog' => 'page-insights-blog.php',
        'insights/blog/' => 'page-insights-blog.php',
        'insights/success-stories' => 'page-insights-success-stories.php',
        'insights/success-stories/' => 'page-insights-success-stories.php',
        'insights/webinars' => 'page-insights-webinars.php',
        'insights/webinars/' => 'page-insights-webinars.php',
        'insights/whitepapers-reports' => 'page-insights-whitepapers-reports.php',
        'insights/whitepapers-reports/' => 'page-insights-whitepapers-reports.php',
    ];
    
    if (isset($insights_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $insights_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_insights_template_redirect', 1);

/**
 * Handle Contact page early in the request lifecycle
 */
function apex_contact_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of contact URLs to their templates
    $contact_templates = [
        'contact' => 'page-contact.php',
        'contact/' => 'page-contact.php',
    ];
    
    if (isset($contact_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $contact_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_contact_template_redirect', 1);

/**
 * Handle Industry pages early in the request lifecycle
 */
function apex_industry_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of industry URLs to their templates
    $industry_templates = [
        'industry/overview' => 'page-industry-overview.php',
        'industry/overview/' => 'page-industry-overview.php',
        'industry/mfis' => 'page-industry-mfis.php',
        'industry/mfis/' => 'page-industry-mfis.php',
        'industry/credit-unions' => 'page-industry-credit-unions.php',
        'industry/credit-unions/' => 'page-industry-credit-unions.php',
        'industry/banks-microfinance' => 'page-industry-banks.php',
        'industry/banks-microfinance/' => 'page-industry-banks.php',
        'industry/digital-government' => 'page-industry-digital-government.php',
        'industry/digital-government/' => 'page-industry-digital-government.php',
    ];
    
    if (isset($industry_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $industry_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_industry_template_redirect', 1);

/**
 * Handle Solutions pages early in the request lifecycle
 */
function apex_solutions_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of solutions URLs to their templates
    $solutions_templates = [
        'solutions/overview' => 'page-solutions-overview.php',
        'solutions/overview/' => 'page-solutions-overview.php',
        'solutions/core-banking-microfinance' => 'page-solutions-core-banking.php',
        'solutions/core-banking-microfinance/' => 'page-solutions-core-banking.php',
        'solutions/mobile-wallet-app' => 'page-solutions-mobile-wallet.php',
        'solutions/mobile-wallet-app/' => 'page-solutions-mobile-wallet.php',
        'solutions/agency-branch-banking' => 'page-solutions-agency-banking.php',
        'solutions/agency-branch-banking/' => 'page-solutions-agency-banking.php',
        'solutions/internet-mobile-banking' => 'page-solutions-internet-banking.php',
        'solutions/internet-mobile-banking/' => 'page-solutions-internet-banking.php',
        'solutions/loan-origination-workflows' => 'page-solutions-loan-origination.php',
        'solutions/loan-origination-workflows/' => 'page-solutions-loan-origination.php',
        'solutions/digital-field-agent' => 'page-solutions-field-agent.php',
        'solutions/digital-field-agent/' => 'page-solutions-field-agent.php',
        'solutions/enterprise-integration' => 'page-solutions-enterprise-integration.php',
        'solutions/enterprise-integration/' => 'page-solutions-enterprise-integration.php',
        'solutions/payment-switch-ledger' => 'page-solutions-payment-switch.php',
        'solutions/payment-switch-ledger/' => 'page-solutions-payment-switch.php',
        'solutions/reporting-analytics' => 'page-solutions-reporting.php',
        'solutions/reporting-analytics/' => 'page-solutions-reporting.php',
    ];
    
    if (isset($solutions_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $solutions_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_solutions_template_redirect', 1);

/**
 * Handle Support pages early in the request lifecycle
 */
function apex_support_template_redirect() {
    $request_uri = trim($_SERVER['REQUEST_URI'], '/');
    $request_uri = strtok($request_uri, '?');
    
    // Map of support URLs to their templates
    $support_templates = [
        'privacy-policy' => 'page-privacy-policy.php',
        'privacy-policy/' => 'page-privacy-policy.php',
        'terms-and-conditions' => 'page-terms-and-conditions.php',
        'terms-and-conditions/' => 'page-terms-and-conditions.php',
        'careers' => 'page-careers.php',
        'careers/' => 'page-careers.php',
        'help-support' => 'page-help-support.php',
        'help-support/' => 'page-help-support.php',
        'faq' => 'page-faq.php',
        'faq/' => 'page-faq.php',
        'knowledge-base' => 'page-knowledge-base.php',
        'knowledge-base/' => 'page-knowledge-base.php',
        'developers' => 'page-developers.php',
        'developers/' => 'page-developers.php',
        'partners' => 'page-partners.php',
        'partners/' => 'page-partners.php',
        'request-demo' => 'page-request-demo.php',
        'request-demo/' => 'page-request-demo.php',
    ];
    
    if (isset($support_templates[$request_uri])) {
        // Set proper headers
        status_header(200);
        
        // Load the template directly
        $template = get_template_directory() . '/' . $support_templates[$request_uri];
        if (file_exists($template)) {
            include($template);
            exit;
        }
    }
}
add_action('template_redirect', 'apex_support_template_redirect', 1);

/**
 * Custom template for About Us pages (fallback)
 */
function apex_about_us_template($template) {
    $apex_about_page = get_query_var('apex_about_page');
    if ($apex_about_page) {
        $custom_template = locate_template('page-about-us-overview.php');
        if ($custom_template) {
            return $custom_template;
        }
    }
    
    return $template;
}
add_filter('template_include', 'apex_about_us_template');

