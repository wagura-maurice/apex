<?php
/**
 * How We Do It Component
 * Process and methodology showcase section
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_HowWeDoIt_Component {
    
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
                'apex-how-we-do-it-component',
                get_template_directory_uri() . '/components/how-we-do-it/how-we-do-it.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-how-we-do-it-component',
                get_template_directory_uri() . '/components/how-we-do-it/how-we-do-it.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'How We Do It',
            'heading' => 'Our Proven Implementation Approach',
            'description' => 'We follow a structured methodology that ensures successful deployments, minimal disruption, and maximum value for your institution.',
            'steps' => [
                [
                    'number' => '01',
                    'title' => 'Discovery & Assessment',
                    'description' => 'We analyze your current systems, processes, and requirements to create a tailored implementation roadmap.',
                    'icon' => 'search',
                    'duration' => '2-4 Weeks'
                ],
                [
                    'number' => '02',
                    'title' => 'Solution Design',
                    'description' => 'Our architects design a customized solution that integrates seamlessly with your existing infrastructure.',
                    'icon' => 'layout',
                    'duration' => '3-6 Weeks'
                ],
                [
                    'number' => '03',
                    'title' => 'Development & Configuration',
                    'description' => 'We configure the platform to your specifications and develop any custom modules required.',
                    'icon' => 'code',
                    'duration' => '6-12 Weeks'
                ],
                [
                    'number' => '04',
                    'title' => 'Testing & Training',
                    'description' => 'Rigorous testing ensures quality while comprehensive training prepares your team for success.',
                    'icon' => 'check-circle',
                    'duration' => '4-6 Weeks'
                ],
                [
                    'number' => '05',
                    'title' => 'Go-Live & Support',
                    'description' => 'We ensure a smooth launch with dedicated support and continuous optimization post-deployment.',
                    'icon' => 'rocket',
                    'duration' => 'Ongoing'
                ]
            ],
            'cta' => [
                'text' => 'Start Your Journey',
                'url' => home_url('/contact')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        $icons = [
            'search' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>',
            'layout' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><line x1="3" y1="9" x2="21" y2="9"/><line x1="9" y1="21" x2="9" y2="9"/></svg>',
            'code' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
            'check-circle' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>',
            'rocket' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4.5 16.5c-1.5 1.26-2 5-2 5s3.74-.5 5-2c.71-.84.7-2.13-.09-2.91a2.18 2.18 0 0 0-2.91-.09z"/><path d="M12 15l-3-3a22 22 0 0 1 2-3.95A12.88 12.88 0 0 1 22 2c0 2.72-.78 7.5-6 11a22.35 22.35 0 0 1-4 2z"/><path d="M9 12H4s.55-3.03 2-4c1.62-1.08 5 0 5 0"/><path d="M12 15v5s3.03-.55 4-2c1.08-1.62 0-5 0-5"/></svg>'
        ];
        ?>
        <section class="apex-how-we-do-it" data-animate-section>
            <div class="apex-how-we-do-it__container">
                <!-- Section Header -->
                <div class="apex-how-we-do-it__header" data-animate="fade-up">
                    <span class="apex-how-we-do-it__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-how-we-do-it__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-how-we-do-it__description"><?php echo esc_html($args['description']); ?></p>
                </div>
                
                <!-- Timeline -->
                <div class="apex-how-we-do-it__timeline">
                    <div class="apex-how-we-do-it__timeline-line"></div>
                    
                    <?php foreach ($args['steps'] as $index => $step) : ?>
                    <div class="apex-how-we-do-it__step <?php echo $index % 2 === 0 ? 'apex-how-we-do-it__step--left' : 'apex-how-we-do-it__step--right'; ?>" data-animate="fade-up" data-delay="<?php echo $index * 150; ?>">
                        <div class="apex-how-we-do-it__step-content">
                            <div class="apex-how-we-do-it__step-icon">
                                <?php echo $icons[$step['icon']] ?? $icons['search']; ?>
                            </div>
                            <span class="apex-how-we-do-it__step-number"><?php echo esc_html($step['number']); ?></span>
                            <h3 class="apex-how-we-do-it__step-title"><?php echo esc_html($step['title']); ?></h3>
                            <p class="apex-how-we-do-it__step-description"><?php echo esc_html($step['description']); ?></p>
                            <span class="apex-how-we-do-it__step-duration">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                                </svg>
                                <?php echo esc_html($step['duration']); ?>
                            </span>
                        </div>
                        <div class="apex-how-we-do-it__step-dot"></div>
                    </div>
                    <?php endforeach; ?>
                </div>
                
                <!-- CTA -->
                <div class="apex-how-we-do-it__cta-wrapper" data-animate="fade-up">
                    <a href="<?php echo esc_url($args['cta']['url']); ?>" class="apex-how-we-do-it__cta">
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
Apex_HowWeDoIt_Component::get_instance();

// Helper function
function apex_render_how_we_do_it($args = []) {
    Apex_HowWeDoIt_Component::get_instance()->render($args);
}
