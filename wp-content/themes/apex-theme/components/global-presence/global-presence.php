<?php
/**
 * Global Presence Component
 * Geographic reach and office locations
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_GlobalPresence_Component {
    
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
        if (is_page_template('page-about-us-overview.php') || strpos($_SERVER['REQUEST_URI'], 'about-us') !== false) {
            wp_enqueue_style(
                'apex-global-presence-component',
                get_template_directory_uri() . '/components/global-presence/global-presence.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-global-presence-component',
                get_template_directory_uri() . '/components/global-presence/global-presence.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Our Reach',
            'heading' => 'Pan-African Presence',
            'description' => 'From our headquarters in Nairobi, we serve financial institutions across the African continent.',
            'regions' => [],
            'headquarters' => [
                'city' => 'Nairobi',
                'country' => 'Kenya',
                'address' => 'Westlands Business Park'
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        ?>
        <section class="apex-global-presence" data-global-presence-section>
            <div class="apex-global-presence__container">
                <div class="apex-global-presence__header" data-animate="fade-up">
                    <span class="apex-global-presence__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-global-presence__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-global-presence__description"><?php echo esc_html($args['description']); ?></p>
                </div>
                
                <div class="apex-global-presence__grid">
                    <!-- Regions -->
                    <div class="apex-global-presence__regions" data-animate="fade-right">
                        <?php foreach ($args['regions'] as $region) : ?>
                        <div class="apex-global-presence__region">
                            <div class="apex-global-presence__region-header">
                                <h3 class="apex-global-presence__region-name"><?php echo esc_html($region['name']); ?></h3>
                                <span class="apex-global-presence__region-clients"><?php echo esc_html($region['clients']); ?> Clients</span>
                            </div>
                            <div class="apex-global-presence__region-countries">
                                <?php foreach ($region['countries'] as $country) : ?>
                                <span class="apex-global-presence__country"><?php echo esc_html($country); ?></span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <!-- Headquarters Card -->
                    <div class="apex-global-presence__hq" data-animate="fade-left">
                        <div class="apex-global-presence__hq-card">
                            <div class="apex-global-presence__hq-icon">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/>
                                    <circle cx="12" cy="10" r="3"/>
                                </svg>
                            </div>
                            <span class="apex-global-presence__hq-label">Headquarters</span>
                            <h3 class="apex-global-presence__hq-city"><?php echo esc_html($args['headquarters']['city']); ?>, <?php echo esc_html($args['headquarters']['country']); ?></h3>
                            <p class="apex-global-presence__hq-address"><?php echo esc_html($args['headquarters']['address']); ?></p>
                            
                            <div class="apex-global-presence__hq-stats">
                                <div class="apex-global-presence__hq-stat">
                                    <span class="apex-global-presence__hq-stat-value">100+</span>
                                    <span class="apex-global-presence__hq-stat-label">Clients</span>
                                </div>
                                <div class="apex-global-presence__hq-stat">
                                    <span class="apex-global-presence__hq-stat-value">15+</span>
                                    <span class="apex-global-presence__hq-stat-label">Countries</span>
                                </div>
                                <div class="apex-global-presence__hq-stat">
                                    <span class="apex-global-presence__hq-stat-value">200+</span>
                                    <span class="apex-global-presence__hq-stat-label">Team Members</span>
                                </div>
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
Apex_GlobalPresence_Component::get_instance();

// Helper function
function apex_render_global_presence($args = []) {
    Apex_GlobalPresence_Component::get_instance()->render($args);
}
