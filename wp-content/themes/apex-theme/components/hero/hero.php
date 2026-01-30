<?php
/**
 * Hero Component
 * Full-screen hero section with carousel functionality
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_Hero_Component {
    
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
                'apex-hero-component',
                get_template_directory_uri() . '/components/hero/hero.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-hero-component',
                get_template_directory_uri() . '/components/hero/hero.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'slides' => [
                [
                    'image' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=1920',
                    'heading' => 'Launch Your Digital Bank of the Future',
                    'subheading' => 'Power your winning neobank strategy with ApexCore – the web-based, multi-tenant core banking platform built for MFIs, SACCOs, and banks.',
                    'alt' => 'Digital Core Banking Platform'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=1920',
                    'heading' => 'Omnichannel Banking Made Simple',
                    'subheading' => 'Deliver mobile apps, USSD, and web banking experiences that share workflows, limits, and risk rules across every touchpoint.',
                    'alt' => 'Omnichannel Banking Solutions'
                ],
                [
                    'image' => 'https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=1920',
                    'heading' => 'Extend Your Reach with Agent Banking',
                    'subheading' => 'Equip staff and agents with offline-ready apps for onboarding, KYC, collections, and monitoring—safely synced into your core.',
                    'alt' => 'Agent Banking Solutions'
                ]
            ],
            'tagline' => 'ApexCore Platform',
            'cta_primary' => [
                'text' => 'Explore the Platform',
                'url' => home_url('/request-demo')
            ],
            'cta_secondary' => [
                'text' => 'View Solutions',
                'url' => home_url('/solutions')
            ],
            'banner_text' => 'Apex Softwares\' technology solutions impact <strong>100+ financial institutions</strong> across Africa.',
            'banner_link' => [
                'text' => 'Learn More',
                'url' => home_url('/about-us')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        ?>
        <section class="apex-hero" data-hero-carousel>
            <!-- Background Slides -->
            <div class="apex-hero__backgrounds">
                <?php foreach ($args['slides'] as $index => $slide) : ?>
                <div class="apex-hero__bg-slide <?php echo $index === 0 ? 'is-active' : ''; ?>" data-slide="<?php echo $index; ?>">
                    <img src="<?php echo esc_url($slide['image']); ?>" alt="<?php echo esc_attr($slide['alt']); ?>" class="apex-hero__bg-image" loading="<?php echo $index === 0 ? 'eager' : 'lazy'; ?>">
                </div>
                <?php endforeach; ?>
                <div class="apex-hero__overlay"></div>
            </div>
            
            <!-- Hero Content -->
            <div class="apex-hero__content">
                <div class="apex-hero__inner">
                    <!-- Tagline -->
                    <p class="apex-hero__tagline">
                        <span class="apex-hero__tagline-dot"></span>
                        <?php echo esc_html($args['tagline']); ?>
                    </p>
                    
                    <!-- Headings -->
                    <h1 class="apex-hero__heading">
                        <?php foreach ($args['slides'] as $index => $slide) : ?>
                        <span class="apex-hero__heading-text <?php echo $index === 0 ? 'is-active' : ''; ?>" data-heading="<?php echo $index; ?>">
                            <?php echo esc_html($slide['heading']); ?>
                        </span>
                        <?php endforeach; ?>
                    </h1>
                    
                    <!-- Subheadings -->
                    <div class="apex-hero__subheading">
                        <?php foreach ($args['slides'] as $index => $slide) : ?>
                        <p class="apex-hero__subheading-text <?php echo $index === 0 ? 'is-active' : ''; ?>" data-subheading="<?php echo $index; ?>">
                            <?php echo esc_html($slide['subheading']); ?>
                        </p>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- CTA Buttons -->
                    <div class="apex-hero__cta-group">
                        <a href="<?php echo esc_url($args['cta_primary']['url']); ?>" class="apex-hero__cta apex-hero__cta--primary">
                            <?php echo esc_html($args['cta_primary']['text']); ?>
                            <svg class="apex-hero__cta-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                        <a href="<?php echo esc_url($args['cta_secondary']['url']); ?>" class="apex-hero__cta apex-hero__cta--secondary">
                            <?php echo esc_html($args['cta_secondary']['text']); ?>
                        </a>
                    </div>
                    
                    <!-- Navigation -->
                    <div class="apex-hero__nav">
                        <button type="button" class="apex-hero__nav-btn" data-hero-prev aria-label="Previous slide">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="15 18 9 12 15 6"></polyline>
                            </svg>
                        </button>
                        <div class="apex-hero__indicators">
                            <?php foreach ($args['slides'] as $index => $slide) : ?>
                            <button type="button" class="apex-hero__indicator <?php echo $index === 0 ? 'is-active' : ''; ?>" data-indicator="<?php echo $index; ?>" aria-label="Slide <?php echo $index + 1; ?>"></button>
                            <?php endforeach; ?>
                        </div>
                        <button type="button" class="apex-hero__nav-btn" data-hero-next aria-label="Next slide">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Bottom Banner -->
            <div class="apex-hero__banner">
                <p><?php echo wp_kses_post($args['banner_text']); ?> <a href="<?php echo esc_url($args['banner_link']['url']); ?>"><?php echo esc_html($args['banner_link']['text']); ?> →</a></p>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_Hero_Component::get_instance();

// Helper function for easy rendering
function apex_render_hero($args = []) {
    Apex_Hero_Component::get_instance()->render($args);
}
