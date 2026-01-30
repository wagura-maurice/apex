<?php
/**
 * What We Do Component
 * Services and solutions showcase section
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_WhatWeDo_Component {
    
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
        if (is_front_page()) {
            wp_enqueue_style(
                'apex-what-we-do-component',
                get_template_directory_uri() . '/components/what-we-do/what-we-do.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-what-we-do-component',
                get_template_directory_uri() . '/components/what-we-do/what-we-do.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'What We Do',
            'heading' => 'Comprehensive Financial Technology Solutions',
            'description' => 'We provide end-to-end digital banking solutions that transform how financial institutions serve their customers.',
            'services' => [
                [
                    'icon' => 'database',
                    'title' => 'Core Banking System',
                    'description' => 'A robust, scalable core banking platform that handles deposits, loans, payments, and accounting with real-time processing.',
                    'link' => '/solutions/core-banking',
                    'color' => 'blue'
                ],
                [
                    'icon' => 'smartphone',
                    'title' => 'Mobile Banking',
                    'description' => 'Native mobile applications for iOS and Android with biometric authentication, instant transfers, and bill payments.',
                    'link' => '/solutions/mobile-banking',
                    'color' => 'orange'
                ],
                [
                    'icon' => 'users',
                    'title' => 'Agent Banking',
                    'description' => 'Extend your reach with agent networks. Enable cash-in, cash-out, account opening, and loan collections.',
                    'link' => '/solutions/agent-banking',
                    'color' => 'green'
                ],
                [
                    'icon' => 'credit-card',
                    'title' => 'Payment Gateway',
                    'description' => 'Secure payment processing with support for cards, mobile money, bank transfers, and QR payments.',
                    'link' => '/solutions/payments',
                    'color' => 'purple'
                ],
                [
                    'icon' => 'bar-chart',
                    'title' => 'Analytics & Reporting',
                    'description' => 'Real-time dashboards, regulatory reports, and business intelligence tools for data-driven decisions.',
                    'link' => '/solutions/analytics',
                    'color' => 'cyan'
                ],
                [
                    'icon' => 'shield',
                    'title' => 'Risk & Compliance',
                    'description' => 'AML/KYC compliance, fraud detection, credit scoring, and regulatory reporting automation.',
                    'link' => '/solutions/compliance',
                    'color' => 'red'
                ]
            ],
            'cta' => [
                'text' => 'Explore All Solutions',
                'url' => home_url('/solutions')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        $icons = [
            'database' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"/><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/></svg>',
            'smartphone' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2" ry="2"/><line x1="12" y1="18" x2="12.01" y2="18"/></svg>',
            'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'credit-card' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>',
            'bar-chart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="20" x2="12" y2="10"/><line x1="18" y1="20" x2="18" y2="4"/><line x1="6" y1="20" x2="6" y2="16"/></svg>',
            'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'cloud' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 10h-1.26A8 8 0 1 0 9 20h9a5 5 0 0 0 0-10z"/></svg>',
            'lock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>'
        ];
        
        $colors = [
            'blue' => ['bg' => 'rgba(59, 130, 246, 0.1)', 'text' => '#3b82f6', 'gradient' => 'linear-gradient(135deg, #3b82f6, #1d4ed8)'],
            'orange' => ['bg' => 'rgba(249, 115, 22, 0.1)', 'text' => '#f97316', 'gradient' => 'linear-gradient(135deg, #f97316, #ea580c)'],
            'green' => ['bg' => 'rgba(34, 197, 94, 0.1)', 'text' => '#22c55e', 'gradient' => 'linear-gradient(135deg, #22c55e, #16a34a)'],
            'purple' => ['bg' => 'rgba(139, 92, 246, 0.1)', 'text' => '#8b5cf6', 'gradient' => 'linear-gradient(135deg, #8b5cf6, #7c3aed)'],
            'cyan' => ['bg' => 'rgba(6, 182, 212, 0.1)', 'text' => '#06b6d4', 'gradient' => 'linear-gradient(135deg, #06b6d4, #0891b2)'],
            'red' => ['bg' => 'rgba(239, 68, 68, 0.1)', 'text' => '#ef4444', 'gradient' => 'linear-gradient(135deg, #ef4444, #dc2626)']
        ];
        ?>
        <section class="apex-what-we-do" data-animate-section>
            <div class="apex-what-we-do__container">
                <!-- Section Header -->
                <div class="apex-what-we-do__header" data-animate="fade-up">
                    <span class="apex-what-we-do__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-what-we-do__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-what-we-do__description"><?php echo esc_html($args['description']); ?></p>
                </div>
                
                <!-- Services Grid -->
                <div class="apex-what-we-do__grid">
                    <?php foreach ($args['services'] as $index => $service) : 
                        $color = $colors[$service['color']] ?? $colors['blue'];
                    ?>
                    <div class="apex-what-we-do__card" data-animate="fade-up" data-delay="<?php echo $index * 100; ?>">
                        <div class="apex-what-we-do__card-icon" style="background: <?php echo $color['bg']; ?>; color: <?php echo $color['text']; ?>;">
                            <?php echo $icons[$service['icon']] ?? $icons['database']; ?>
                        </div>
                        <h3 class="apex-what-we-do__card-title"><?php echo esc_html($service['title']); ?></h3>
                        <p class="apex-what-we-do__card-description"><?php echo esc_html($service['description']); ?></p>
                        <a href="<?php echo esc_url(home_url($service['link'])); ?>" class="apex-what-we-do__card-link" style="color: <?php echo $color['text']; ?>;">
                            Learn More
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <div class="apex-what-we-do__card-accent" style="background: <?php echo $color['gradient']; ?>;"></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- CTA -->
                <div class="apex-what-we-do__cta-wrapper" data-animate="fade-up">
                    <a href="<?php echo esc_url($args['cta']['url']); ?>" class="apex-what-we-do__cta">
                        <?php echo esc_html($args['cta']['text']); ?>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_WhatWeDo_Component::get_instance();

// Helper function
function apex_render_what_we_do($args = []) {
    Apex_WhatWeDo_Component::get_instance()->render($args);
}
