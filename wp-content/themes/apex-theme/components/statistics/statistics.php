<?php
/**
 * Statistics Counter Component
 * Animated statistics display section
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_Statistics_Component {
    
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
                'apex-statistics-component',
                get_template_directory_uri() . '/components/statistics/statistics.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-statistics-component',
                get_template_directory_uri() . '/components/statistics/statistics.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'heading' => 'Powering Financial Institutions Across Africa',
            'subheading' => 'Our platform processes millions of transactions daily, serving customers across the continent.',
            'stats' => [
                [
                    'value' => 100,
                    'suffix' => '+',
                    'label' => 'Financial Institutions',
                    'icon' => 'building'
                ],
                [
                    'value' => 15,
                    'suffix' => '+',
                    'label' => 'Countries Served',
                    'icon' => 'globe'
                ],
                [
                    'value' => 5,
                    'suffix' => 'M+',
                    'label' => 'Active Users',
                    'icon' => 'users'
                ],
                [
                    'value' => 99.9,
                    'suffix' => '%',
                    'label' => 'Uptime SLA',
                    'icon' => 'shield'
                ]
            ],
            'background_image' => 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=1920'
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        $icons = [
            'building' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="4" y="2" width="16" height="20" rx="2" ry="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>',
            'globe' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
            'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
            'trending' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>',
            'clock' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>'
        ];
        ?>
        <section class="apex-statistics" data-statistics-section>
            <!-- Background -->
            <div class="apex-statistics__background">
                <img src="<?php echo esc_url($args['background_image']); ?>" alt="" class="apex-statistics__bg-image" loading="lazy">
                <div class="apex-statistics__overlay"></div>
            </div>
            
            <div class="apex-statistics__container">
                <!-- Header -->
                <div class="apex-statistics__header" data-animate="fade-up">
                    <h2 class="apex-statistics__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-statistics__subheading"><?php echo esc_html($args['subheading']); ?></p>
                </div>
                
                <!-- Stats Grid -->
                <div class="apex-statistics__grid">
                    <?php foreach ($args['stats'] as $index => $stat) : ?>
                    <div class="apex-statistics__item" data-animate="fade-up" data-delay="<?php echo $index * 100; ?>">
                        <div class="apex-statistics__item-icon">
                            <?php echo $icons[$stat['icon']] ?? $icons['trending']; ?>
                        </div>
                        <div class="apex-statistics__item-value">
                            <span class="apex-statistics__number" data-count="<?php echo esc_attr($stat['value']); ?>">0</span>
                            <span class="apex-statistics__suffix"><?php echo esc_html($stat['suffix']); ?></span>
                        </div>
                        <p class="apex-statistics__item-label"><?php echo esc_html($stat['label']); ?></p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_Statistics_Component::get_instance();

// Helper function
function apex_render_statistics($args = []) {
    Apex_Statistics_Component::get_instance()->render($args);
}
