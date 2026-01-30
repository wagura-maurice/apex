<?php
/**
 * Who We Are Component
 * Company introduction section with mission and values
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_WhoWeAre_Component {
    
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
                'apex-who-we-are-component',
                get_template_directory_uri() . '/components/who-we-are/who-we-are.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-who-we-are-component',
                get_template_directory_uri() . '/components/who-we-are/who-we-are.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Who We Are',
            'heading' => 'Pioneering Digital Financial Solutions Across Africa',
            'description' => 'Apex Softwares is a leading financial technology company dedicated to transforming how financial institutions operate. With over a decade of experience, we deliver innovative, scalable, and secure solutions that empower banks, MFIs, and SACCOs to thrive in the digital age.',
            'features' => [
                [
                    'icon' => 'shield',
                    'title' => 'Trusted Partner',
                    'text' => '100+ financial institutions rely on our platform'
                ],
                [
                    'icon' => 'globe',
                    'title' => 'Pan-African Reach',
                    'text' => 'Operating across 15+ countries in Africa'
                ],
                [
                    'icon' => 'award',
                    'title' => 'Industry Leader',
                    'text' => 'Award-winning fintech solutions since 2010'
                ]
            ],
            'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=800',
            'cta' => [
                'text' => 'Learn More About Us',
                'url' => home_url('/about-us')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        $icons = [
            'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'globe' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>',
            'award' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="7"/><polyline points="8.21 13.89 7 23 12 20 17 23 15.79 13.88"/></svg>',
            'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'target' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
            'zap' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>'
        ];
        ?>
        <section class="apex-who-we-are" data-animate-section>
            <div class="apex-who-we-are__container">
                <div class="apex-who-we-are__grid">
                    <!-- Content Column -->
                    <div class="apex-who-we-are__content" data-animate="fade-right">
                        <span class="apex-who-we-are__badge"><?php echo esc_html($args['badge']); ?></span>
                        <h2 class="apex-who-we-are__heading"><?php echo esc_html($args['heading']); ?></h2>
                        <p class="apex-who-we-are__description"><?php echo esc_html($args['description']); ?></p>
                        
                        <div class="apex-who-we-are__features">
                            <?php foreach ($args['features'] as $feature) : ?>
                            <div class="apex-who-we-are__feature">
                                <div class="apex-who-we-are__feature-icon">
                                    <?php echo $icons[$feature['icon']] ?? $icons['shield']; ?>
                                </div>
                                <div class="apex-who-we-are__feature-content">
                                    <h4 class="apex-who-we-are__feature-title"><?php echo esc_html($feature['title']); ?></h4>
                                    <p class="apex-who-we-are__feature-text"><?php echo esc_html($feature['text']); ?></p>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <a href="<?php echo esc_url($args['cta']['url']); ?>" class="apex-who-we-are__cta">
                            <?php echo esc_html($args['cta']['text']); ?>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                    
                    <!-- Image Column -->
                    <div class="apex-who-we-are__visual" data-animate="fade-left">
                        <div class="apex-who-we-are__image-wrapper">
                            <img src="<?php echo esc_url($args['image']); ?>" alt="Apex Softwares Team" class="apex-who-we-are__image" loading="lazy">
                            <div class="apex-who-we-are__image-accent"></div>
                        </div>
                        <div class="apex-who-we-are__stats-card">
                            <div class="apex-who-we-are__stat">
                                <span class="apex-who-we-are__stat-number">14+</span>
                                <span class="apex-who-we-are__stat-label">Years of Excellence</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_WhoWeAre_Component::get_instance();

// Helper function
function apex_render_who_we_are($args = []) {
    Apex_WhoWeAre_Component::get_instance()->render($args);
}
