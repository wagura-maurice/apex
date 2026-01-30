<?php
/**
 * Partners Component
 * Logo showcase section for business relationships
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_Partners_Component {
    
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
                'apex-partners-component',
                get_template_directory_uri() . '/components/partners/partners.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-partners-component',
                get_template_directory_uri() . '/components/partners/partners.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Our Partners',
            'heading' => 'Trusted Technology & Integration Partners',
            'description' => 'We collaborate with leading technology providers to deliver comprehensive solutions.',
            'partners' => [
                [
                    'name' => 'Microsoft Azure',
                    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/Microsoft_Azure.svg/150px-Microsoft_Azure.svg.png',
                    'url' => '#'
                ],
                [
                    'name' => 'Amazon Web Services',
                    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/9/93/Amazon_Web_Services_Logo.svg/150px-Amazon_Web_Services_Logo.svg.png',
                    'url' => '#'
                ],
                [
                    'name' => 'Visa',
                    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/150px-Visa_Inc._logo.svg.png',
                    'url' => '#'
                ],
                [
                    'name' => 'Mastercard',
                    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/150px-Mastercard-logo.svg.png',
                    'url' => '#'
                ],
                [
                    'name' => 'Safaricom',
                    'logo' => 'https://upload.wikimedia.org/wikipedia/en/thumb/9/95/Safaricom_logo.svg/150px-Safaricom_logo.svg.png',
                    'url' => '#'
                ],
                [
                    'name' => 'Oracle',
                    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/50/Oracle_logo.svg/150px-Oracle_logo.svg.png',
                    'url' => '#'
                ],
                [
                    'name' => 'IBM',
                    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/IBM_logo.svg/150px-IBM_logo.svg.png',
                    'url' => '#'
                ],
                [
                    'name' => 'Google Cloud',
                    'logo' => 'https://upload.wikimedia.org/wikipedia/commons/thumb/5/51/Google_Cloud_logo.svg/150px-Google_Cloud_logo.svg.png',
                    'url' => '#'
                ]
            ],
            'cta' => [
                'text' => 'Become a Partner',
                'url' => home_url('/partners')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        ?>
        <section class="apex-partners" data-partners-section>
            <div class="apex-partners__container">
                <!-- Header -->
                <div class="apex-partners__header" data-animate="fade-up">
                    <span class="apex-partners__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-partners__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-partners__description"><?php echo esc_html($args['description']); ?></p>
                </div>
                
                <!-- Logo Grid -->
                <div class="apex-partners__grid" data-animate="fade-up">
                    <?php foreach ($args['partners'] as $index => $partner) : ?>
                    <a href="<?php echo esc_url($partner['url']); ?>" class="apex-partners__item" data-delay="<?php echo $index * 50; ?>" title="<?php echo esc_attr($partner['name']); ?>">
                        <img src="<?php echo esc_url($partner['logo']); ?>" alt="<?php echo esc_attr($partner['name']); ?>" class="apex-partners__logo" loading="lazy">
                    </a>
                    <?php endforeach; ?>
                </div>
                
                <!-- Scrolling Marquee (for mobile) -->
                <div class="apex-partners__marquee" aria-hidden="true">
                    <div class="apex-partners__marquee-track">
                        <?php for ($i = 0; $i < 2; $i++) : ?>
                        <?php foreach ($args['partners'] as $partner) : ?>
                        <div class="apex-partners__marquee-item">
                            <img src="<?php echo esc_url($partner['logo']); ?>" alt="<?php echo esc_attr($partner['name']); ?>" class="apex-partners__logo" loading="lazy">
                        </div>
                        <?php endforeach; ?>
                        <?php endfor; ?>
                    </div>
                </div>
                
                <!-- CTA -->
                <div class="apex-partners__cta-wrapper" data-animate="fade-up">
                    <a href="<?php echo esc_url($args['cta']['url']); ?>" class="apex-partners__cta">
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
Apex_Partners_Component::get_instance();

// Helper function
function apex_render_partners($args = []) {
    Apex_Partners_Component::get_instance()->render($args);
}
