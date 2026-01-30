<?php
/**
 * Mission & Vision Component
 * Company mission, vision, and core values
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_MissionVision_Component {
    
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
                'apex-mission-vision-component',
                get_template_directory_uri() . '/components/mission-vision/mission-vision.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-mission-vision-component',
                get_template_directory_uri() . '/components/mission-vision/mission-vision.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'mission' => [
                'title' => 'Our Mission',
                'description' => 'To empower financial institutions with innovative technology solutions.',
                'icon' => 'target'
            ],
            'vision' => [
                'title' => 'Our Vision',
                'description' => 'To be the leading financial technology partner in Africa.',
                'icon' => 'eye'
            ],
            'values' => []
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        $icons = [
            'target' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>',
            'eye' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>',
            'lightbulb' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 18h6"/><path d="M10 22h4"/><path d="M15.09 14c.18-.98.65-1.74 1.41-2.5A4.65 4.65 0 0 0 18 8 6 6 0 0 0 6 8c0 1 .23 2.23 1.5 3.5A4.61 4.61 0 0 1 8.91 14"/></svg>',
            'handshake' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.42 4.58a5.4 5.4 0 0 0-7.65 0l-.77.78-.77-.78a5.4 5.4 0 0 0-7.65 0C1.46 6.7 1.33 10.28 4 13l8 8 8-8c2.67-2.72 2.54-6.3.42-8.42z"/></svg>',
            'shield' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
            'users' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
            'rocket' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="m12 15-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>',
            'heart' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>'
        ];
        ?>
        <section class="apex-mission-vision" data-mission-vision-section>
            <div class="apex-mission-vision__container">
                <!-- Mission & Vision Cards -->
                <div class="apex-mission-vision__cards" data-animate="fade-up">
                    <div class="apex-mission-vision__card apex-mission-vision__card--mission">
                        <div class="apex-mission-vision__card-icon">
                            <?php echo $icons[$args['mission']['icon']] ?? $icons['target']; ?>
                        </div>
                        <h3 class="apex-mission-vision__card-title"><?php echo esc_html($args['mission']['title']); ?></h3>
                        <p class="apex-mission-vision__card-desc"><?php echo esc_html($args['mission']['description']); ?></p>
                    </div>
                    
                    <div class="apex-mission-vision__card apex-mission-vision__card--vision">
                        <div class="apex-mission-vision__card-icon">
                            <?php echo $icons[$args['vision']['icon']] ?? $icons['eye']; ?>
                        </div>
                        <h3 class="apex-mission-vision__card-title"><?php echo esc_html($args['vision']['title']); ?></h3>
                        <p class="apex-mission-vision__card-desc"><?php echo esc_html($args['vision']['description']); ?></p>
                    </div>
                </div>
                
                <!-- Core Values -->
                <?php if (!empty($args['values'])) : ?>
                <div class="apex-mission-vision__values">
                    <h3 class="apex-mission-vision__values-heading" data-animate="fade-up">Our Core Values</h3>
                    <div class="apex-mission-vision__values-grid">
                        <?php foreach ($args['values'] as $index => $value) : ?>
                        <div class="apex-mission-vision__value" data-animate="fade-up" data-delay="<?php echo $index * 100; ?>">
                            <div class="apex-mission-vision__value-icon">
                                <?php echo $icons[$value['icon']] ?? $icons['lightbulb']; ?>
                            </div>
                            <h4 class="apex-mission-vision__value-title"><?php echo esc_html($value['title']); ?></h4>
                            <p class="apex-mission-vision__value-desc"><?php echo esc_html($value['description']); ?></p>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_MissionVision_Component::get_instance();

// Helper function
function apex_render_mission_vision($args = []) {
    Apex_MissionVision_Component::get_instance()->render($args);
}
