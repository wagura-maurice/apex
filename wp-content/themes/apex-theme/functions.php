<?php

/**
 * Load modular component system
 */
require_once get_template_directory() . '/components/component-loader.php';

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
    add_rewrite_rule('^terms-conditions/?$', 'index.php?apex_support_page=terms-conditions', 'top');
    
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
        'terms-conditions' => 'page-terms-conditions.php',
        'terms-conditions/' => 'page-terms-conditions.php',
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

