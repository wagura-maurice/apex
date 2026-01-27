<?php

/**
 * Theme setup.
 */
function our_theme_setup(): void {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    register_nav_menus([
        'primary' => __('Primary Menu', 'our-wonderful-theme'),
    ]);
}
add_action('after_setup_theme', 'our_theme_setup');

/**
 * Enqueue styles and scripts.
 */
function our_theme_assets(): void {
    // Font (matches modern B2B SaaS typography).
    wp_enqueue_style(
        'our-theme-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
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

    // Configure Tailwind (brand colors, font).
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
        sans: ['Inter', 'ui-sans-serif', 'system-ui', '-apple-system', 'Segoe UI', 'Roboto', 'Arial', 'Noto Sans', 'sans-serif']
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
        'before'
    );

    // Main stylesheet (for WP requirements + small fallbacks).
    wp_enqueue_style(
        'our-theme-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );

    // Theme JS.
    wp_enqueue_script(
        'our-theme-main-js',
        get_template_directory_uri() . '/main.js',
        [],
        wp_get_theme()->get('Version'),
        true
    );
}
add_action('wp_enqueue_scripts', 'our_theme_assets');

/**
 * Register custom post type "pet" (matches tutorial example).
 */
function our_theme_register_pet_cpt(): void {
    $labels = [
        'name' => __('Pets', 'our-wonderful-theme'),
        'singular_name' => __('Pet', 'our-wonderful-theme'),
    ];

    $args = [
        'labels' => $labels,
        'public' => true,
        'has_archive' => true,
        'show_in_rest' => true,
        'supports' => ['title', 'editor', 'thumbnail'],
        'rewrite' => ['slug' => 'pets'],
        'menu_icon' => 'dashicons-pets',
    ];

    register_post_type('pet', $args);
}
add_action('init', 'our_theme_register_pet_cpt');
