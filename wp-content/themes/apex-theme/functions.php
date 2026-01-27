<?php

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
        'after'
    );

    // Main stylesheet (for WP requirements + small fallbacks).
    wp_enqueue_style(
        'apex-theme-style',
        get_stylesheet_uri(),
        [],
        wp_get_theme()->get('Version')
    );
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
        
        // Desktop dropdown and mega menu functionality
        const navItems = document.querySelectorAll('.apex-nav-item');
        
        navItems.forEach(item => {
            const trigger = item.querySelector('.apex-nav-trigger');
            const panel = item.querySelector('.apex-nav-panel');
            
            if (trigger && panel) {
                // Check if it's a mega menu
                const isMegaMenu = panel.classList.contains('mega') ||
                                  panel.getAttribute('data-type') === 'mega' ||
                                  item.getAttribute('data-nav') === 'mega';
                
                const showPanel = () => {
                    // Hide all other panels first
                    document.querySelectorAll('.apex-nav-panel').forEach(otherPanel => {
                        if (otherPanel !== panel) {
                            otherPanel.classList.remove('visible', 'opacity-100', 'translate-y-0');
                            otherPanel.classList.add('invisible', 'opacity-0', 'translate-y-2');
                            const otherTrigger = otherPanel.previousElementSibling || otherPanel.parentElement?.querySelector('.apex-nav-trigger');
                            if (otherTrigger) {
                                otherTrigger.setAttribute('aria-expanded', 'false');
                            }
                        }
                    });
                    
                    // Handle all dropdowns with smart positioning on desktop
                    if (window.innerWidth >= 1024) {
                        if (isMegaMenu) {
                            positionMegaMenu(item, trigger, panel);
                        } else {
                            positionRegularDropdown(item, trigger, panel);
                        }
                        
                        // Force positioning to override CSS
                        setTimeout(() => {
                            if (isMegaMenu) {
                                positionMegaMenu(item, trigger, panel);
                            } else {
                                positionRegularDropdown(item, trigger, panel);
                            }
                        }, 0);
                    }
                    
                    panel.classList.remove('invisible', 'opacity-0', 'translate-y-2', 'pointer-events-none');
                    panel.classList.add('visible', 'opacity-100', 'translate-y-0');
                    trigger.setAttribute('aria-expanded', 'true');
                };
                
                const hidePanel = () => {
                    panel.classList.remove('visible', 'opacity-100', 'translate-y-0');
                    panel.classList.add('invisible', 'opacity-0', 'translate-y-2', 'pointer-events-none');
                    trigger.setAttribute('aria-expanded', 'false');
                    
                    // Reset positioning styles for all dropdowns
                    panel.style.position = '';
                    panel.style.left = '';
                    panel.style.top = '';
                    panel.style.width = '';
                    panel.style.right = '';
                    panel.style.maxWidth = '';
                };
                
                // Mouse events for desktop
                item.addEventListener('mouseenter', showPanel);
                item.addEventListener('mouseleave', () => {
                    // Add a small delay before hiding to allow clicking
                    setTimeout(() => {
                        if (!item.matches(':hover')) {
                            hidePanel();
                        }
                    }, 200);
                });
                
                // Allow clicks on dropdown links
                const dropdownLinks = panel.querySelectorAll('a');
                dropdownLinks.forEach(link => {
                    link.addEventListener('click', (e) => {
                        // Allow the link to work normally
                        e.stopPropagation();
                        console.log('Link clicked:', link.href, link.textContent);
                        // Force navigation
                        window.location.href = link.href;
                    });
                    
                    // Also test mousedown to ensure it's not blocked
                    link.addEventListener('mousedown', (e) => {
                        console.log('Link mousedown:', link.href);
                    });
                    
                    // Prevent dropdown from closing when hovering over links
                    link.addEventListener('mouseenter', () => {
                        panel.classList.remove('invisible', 'opacity-0', 'translate-y-2', 'pointer-events-none');
                        panel.classList.add('visible', 'opacity-100', 'translate-y-0');
                    });
                });
                
                // Click event for mobile/touch
                trigger.addEventListener('click', (e) => {
                    e.preventDefault();
                    const isExpanded = trigger.getAttribute('aria-expanded') === 'true';
                    
                    if (window.innerWidth < 1024) {
                        if (isExpanded) {
                            hidePanel();
                        } else {
                            // On mobile, just toggle visibility
                            // First hide all other panels
                            document.querySelectorAll('.apex-nav-panel').forEach(otherPanel => {
                                otherPanel.classList.add('invisible');
                                otherPanel.classList.add('opacity-0');
                                otherPanel.classList.add('translate-y-2');
                                otherPanel.classList.remove('visible');
                                otherPanel.classList.remove('opacity-100');
                                otherPanel.classList.remove('translate-y-0');
                                
                                const otherTrigger = otherPanel.previousElementSibling || otherPanel.parentElement?.querySelector('.apex-nav-trigger');
                                if (otherTrigger) {
                                    otherTrigger.setAttribute('aria-expanded', 'false');
                                }
                            });
                            
                            panel.classList.remove('invisible');
                            panel.classList.remove('opacity-0');
                            panel.classList.remove('translate-y-2');
                            panel.classList.add('visible');
                            panel.classList.add('opacity-100');
                            panel.classList.add('translate-y-0');
                            trigger.setAttribute('aria-expanded', true);
                        }
                    }
                });
            }
        });
        
        // Helper function to position regular dropdowns
        function positionRegularDropdown(item, trigger, panel) {
            const triggerRect = trigger.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            const panelWidth = Math.min(320, viewportWidth - 32);
            
            // Calculate position relative to viewport
            let panelLeft = triggerRect.left;
            
            // Adjust if panel would go off-screen
            if (panelLeft + panelWidth > viewportWidth - 16) {
                panelLeft = viewportWidth - panelWidth - 16;
            }
            
            if (panelLeft < 16) {
                panelLeft = 16;
            }
            
            // Set position
            panel.style.position = 'fixed';
            panel.style.left = `${panelLeft}px`;
            panel.style.top = `${triggerRect.bottom + 8}px`;
            panel.style.width = `${panelWidth}px`;
            panel.style.maxWidth = '100vw';
            panel.style.right = 'auto';
        }
        
        // Helper function to position mega menu
        function positionMegaMenu(item, trigger, panel) {
            const triggerRect = trigger.getBoundingClientRect();
            const viewportWidth = window.innerWidth;
            const viewportHeight = window.innerHeight;
            
            // Calculate optimal width (max 800px, but leave padding on sides)
            const maxPanelWidth = Math.min(800, viewportWidth - 32);
            
            // Center the mega menu relative to trigger
            const triggerCenter = triggerRect.left + (triggerRect.width / 2);
            let panelLeft = triggerCenter - (maxPanelWidth / 2);
            
            // Ensure panel stays within viewport bounds horizontally
            if (panelLeft < 16) {
                panelLeft = 16;
            } else if (panelLeft + maxPanelWidth > viewportWidth - 16) {
                panelLeft = viewportWidth - maxPanelWidth - 16;
            }
            
            // Get actual panel height after making it visible
            panel.style.visibility = 'hidden';
            panel.style.display = 'block';
            const actualPanelHeight = panel.offsetHeight;
            panel.style.visibility = '';
            panel.style.display = '';
            
            let panelTop = triggerRect.bottom + 8;
            
            // Check if panel would go beyond viewport bottom
            if (panelTop + actualPanelHeight > viewportHeight - 16) {
                // Position above the trigger instead
                panelTop = triggerRect.top - actualPanelHeight - 8;
            }
            
            // Apply positioning
            panel.style.position = 'fixed';
            panel.style.left = `${panelLeft}px`;
            panel.style.top = `${panelTop}px`;
            panel.style.width = `${maxPanelWidth}px`;
            panel.style.maxWidth = `calc(100vw - 32px)`;
            panel.style.zIndex = '9999';
        }
        
        // Reposition dropdowns on window resize
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                navItems.forEach(item => {
                    const trigger = item.querySelector('.apex-nav-trigger');
                    const panel = item.querySelector('.apex-nav-panel');
                    
                    if (trigger && panel && trigger.getAttribute('aria-expanded') === 'true') {
                        const isMegaMenu = panel.classList.contains('mega') ||
                                          panel.getAttribute('data-type') === 'mega' ||
                                          item.getAttribute('data-nav') === 'mega';
                        
                        if (window.innerWidth >= 1024) {
                            if (isMegaMenu) {
                                positionMegaMenu(item, trigger, panel);
                            } else {
                                positionRegularDropdown(item, trigger, panel);
                            }
                        }
                    }
                });
            }, 250);
        });
        
        // Close dropdowns when clicking outside
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.apex-nav-item')) {
                document.querySelectorAll('.apex-nav-panel').forEach(panel => {
                    if (panel.classList.contains('visible')) {
                        panel.classList.remove('visible', 'opacity-100', 'translate-y-0');
                        panel.classList.add('invisible', 'opacity-0', 'translate-y-2');
                        
                        const trigger = panel.previousElementSibling || panel.parentElement?.querySelector('.apex-nav-trigger');
                        if (trigger) {
                            trigger.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            }
        });
        
        // Close dropdowns when pressing Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                document.querySelectorAll('.apex-nav-panel').forEach(panel => {
                    if (panel.classList.contains('visible')) {
                        panel.classList.remove('visible', 'opacity-100', 'translate-y-0');
                        panel.classList.add('invisible', 'opacity-0', 'translate-y-2');
                        
                        const trigger = panel.previousElementSibling || panel.parentElement?.querySelector('.apex-nav-trigger');
                        if (trigger) {
                            trigger.setAttribute('aria-expanded', 'false');
                        }
                    }
                });
            }
        });
        
        // Mobile menu toggle functionality
        const mobileToggle = document.querySelector('[data-mobile-menu-toggle]');
        const mobileMenu = document.getElementById('apex-mobile-menu');
        
        if (mobileToggle && mobileMenu) {
            mobileToggle.addEventListener('click', function() {
                const isExpanded = mobileToggle.getAttribute('aria-expanded') === 'true';
                mobileMenu.classList.toggle('hidden');
                mobileToggle.setAttribute('aria-expanded', !isExpanded);
                
                // Change the icon based on state
                const iconElement = mobileToggle.querySelector('.apex-mobile-toggle-icon');
                if (iconElement) {
                    if (isExpanded) {
                        // Show hamburger icon
                        iconElement.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>';
                    } else {
                        // Show close icon
                        iconElement.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                    }
                }
            });
        }
        
        // Mobile accordion functionality
        const mobileAccordions = document.querySelectorAll('[data-mobile-accordion]');
        
        mobileAccordions.forEach(accordion => {
            accordion.addEventListener('click', function() {
                const isExpanded = this.getAttribute('aria-expanded') === 'true';
                
                // Close all other panels
                mobileAccordions.forEach(otherAccordion => {
                    if (otherAccordion !== this) {
                        const otherPanel = otherAccordion.nextElementSibling ||
                                          otherAccordion.parentElement?.querySelector('[data-mobile-panel]');
                        if (otherPanel) {
                            otherPanel.classList.add('hidden');
                        }
                        otherAccordion.setAttribute('aria-expanded', 'false');
                        const otherIcon = otherAccordion.querySelector('span:last-child');
                        if (otherIcon) otherIcon.style.transform = '';
                    }
                });
                
                // Toggle current panel
                const panel = this.nextElementSibling ||
                             this.parentElement?.querySelector('[data-mobile-panel]');
                if (panel) {
                    panel.classList.toggle('hidden');
                }
                this.setAttribute('aria-expanded', !isExpanded);
                const icon = this.querySelector('span:last-child');
                if (icon) {
                    icon.style.transform = isExpanded ? '' : 'rotate(180deg)';
                }
            });
        });
        
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


