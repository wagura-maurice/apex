<?php
/**
 * About Hero Component
 * Hero section for About Us pages
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_AboutHero_Component {
    
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
        $request_uri = $_SERVER['REQUEST_URI'];
        $is_about_page = strpos($request_uri, 'about-us') !== false;
        $is_insights_page = strpos($request_uri, 'insights') !== false;
        $is_contact_page = strpos($request_uri, 'contact') !== false;
        $is_industry_page = strpos($request_uri, 'industry') !== false;
        $is_support_page = strpos($request_uri, 'careers') !== false || 
                           strpos($request_uri, 'help-support') !== false ||
                           strpos($request_uri, 'faq') !== false ||
                           strpos($request_uri, 'knowledge-base') !== false ||
                           strpos($request_uri, 'developers') !== false ||
                           strpos($request_uri, 'partners') !== false ||
                           strpos($request_uri, 'request-demo') !== false ||
                           strpos($request_uri, 'privacy-policy') !== false ||
                           strpos($request_uri, 'terms-and-conditions') !== false;
        $is_solutions_page = strpos($request_uri, 'solutions') !== false;
        
        if (is_page_template('page-about-us-overview.php') || $is_about_page || $is_insights_page || $is_contact_page || $is_industry_page || $is_support_page || $is_solutions_page) {
            wp_enqueue_style(
                'apex-about-hero-component',
                get_template_directory_uri() . '/components/about-hero/about-hero.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-about-hero-component',
                get_template_directory_uri() . '/components/about-hero/about-hero.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'About Apex Softwares',
            'heading' => 'Transforming Financial Services Across Africa',
            'description' => 'For over a decade, we\'ve been at the forefront of financial technology innovation.',
            'stats' => [
                ['value' => '100+', 'label' => 'Financial Institutions'],
                ['value' => '15+', 'label' => 'Countries'],
                ['value' => '10M+', 'label' => 'End Users'],
                ['value' => '14+', 'label' => 'Years Experience']
            ],
            'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200'
        ];
        
        $args = wp_parse_args($args, $defaults);
        ?>
        <section class="apex-about-hero" data-about-hero-section>
            <div class="apex-about-hero__background">
                <div class="apex-about-hero__gradient"></div>
            </div>
            <div class="apex-about-hero__container">
                <div class="apex-about-hero__content" data-animate="fade-up">
                    <span class="apex-about-hero__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h1 class="apex-about-hero__heading"><?php echo esc_html($args['heading']); ?></h1>
                    <p class="apex-about-hero__description"><?php echo esc_html($args['description']); ?></p>
                    
                    <div class="apex-about-hero__stats">
                        <?php foreach ($args['stats'] as $stat) : ?>
                        <div class="apex-about-hero__stat">
                            <span class="apex-about-hero__stat-value"><?php echo esc_html($stat['value']); ?></span>
                            <span class="apex-about-hero__stat-label"><?php echo esc_html($stat['label']); ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                
                <div class="apex-about-hero__image-wrapper" data-animate="fade-left">
                    <div class="apex-about-hero__image-container">
                        <img src="<?php echo esc_url($args['image']); ?>" alt="Apex Softwares Team" class="apex-about-hero__image" loading="eager">
                        <div class="apex-about-hero__image-overlay"></div>
                    </div>
                    <div class="apex-about-hero__decoration apex-about-hero__decoration--1"></div>
                    <div class="apex-about-hero__decoration apex-about-hero__decoration--2"></div>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_AboutHero_Component::get_instance();

// Helper function
function apex_render_about_hero($args = []) {
    Apex_AboutHero_Component::get_instance()->render($args);
}
