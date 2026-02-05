<?php
/**
 * About CTA Component
 * Call-to-action section for About pages
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_AboutCTA_Component {
    
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
                'apex-about-cta-component',
                get_template_directory_uri() . '/components/about-cta/about-cta.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-about-cta-component',
                get_template_directory_uri() . '/components/about-cta/about-cta.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'heading' => 'Ready to Transform Your Institution?',
            'description' => 'Join over 100 financial institutions that trust Apex Softwares.',
            'cta_primary' => [
                'text' => 'Request a Demo',
                'url' => home_url('/request-demo')
            ],
            'cta_secondary' => [
                'text' => 'Contact Us',
                'url' => home_url('/contact')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        ?>
        <section class="apex-about-cta" data-about-cta-section>
            <div class="apex-about-cta__background">
                <div class="apex-about-cta__gradient"></div>
                <div class="apex-about-cta__pattern"></div>
            </div>
            <div class="apex-about-cta__container" data-animate="fade-up">
                <h2 class="apex-about-cta__heading"><?php echo esc_html($args['heading']); ?></h2>
                <p class="apex-about-cta__description"><?php echo esc_html($args['description']); ?></p>
                
                <div class="apex-about-cta__buttons">
                    <a href="<?php echo esc_url($args['cta_primary']['url']); ?>" class="apex-about-cta__btn apex-about-cta__btn--primary">
                        <?php echo esc_html($args['cta_primary']['text']); ?>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                    <a href="<?php echo esc_url($args['cta_secondary']['url']); ?>" class="apex-about-cta__btn apex-about-cta__btn--secondary">
                        <?php echo esc_html($args['cta_secondary']['text']); ?>
                    </a>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_AboutCTA_Component::get_instance();

// Helper function
function apex_render_about_cta($args = []) {
    Apex_AboutCTA_Component::get_instance()->render($args);
}
