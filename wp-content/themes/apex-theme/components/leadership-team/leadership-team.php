<?php
/**
 * Leadership Team Component
 * Team members showcase
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_LeadershipTeam_Component {
    
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
                'apex-leadership-team-component',
                get_template_directory_uri() . '/components/leadership-team/leadership-team.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-leadership-team-component',
                get_template_directory_uri() . '/components/leadership-team/leadership-team.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Leadership',
            'heading' => 'Meet Our Team',
            'description' => 'Our leadership team brings together decades of experience.',
            'team' => []
        ];
        
        $args = wp_parse_args($args, $defaults);
        ?>
        <section class="apex-leadership-team" data-leadership-team-section>
            <div class="apex-leadership-team__container">
                <div class="apex-leadership-team__header" data-animate="fade-up">
                    <span class="apex-leadership-team__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-leadership-team__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-leadership-team__description"><?php echo esc_html($args['description']); ?></p>
                </div>
                
                <div class="apex-leadership-team__grid">
                    <?php foreach ($args['team'] as $index => $member) : ?>
                    <div class="apex-leadership-team__member" data-animate="fade-up" data-delay="<?php echo $index * 100; ?>">
                        <div class="apex-leadership-team__member-image-wrapper">
                            <img src="<?php echo esc_url($member['image']); ?>" alt="<?php echo esc_attr($member['name']); ?>" class="apex-leadership-team__member-image" loading="lazy">
                            <div class="apex-leadership-team__member-overlay">
                                <div class="apex-leadership-team__member-social">
                                    <?php if (!empty($member['linkedin'])) : ?>
                                    <a href="<?php echo esc_url($member['linkedin']); ?>" class="apex-leadership-team__social-link" aria-label="LinkedIn" target="_blank" rel="noopener">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                    </a>
                                    <?php endif; ?>
                                    <?php if (!empty($member['twitter'])) : ?>
                                    <a href="<?php echo esc_url($member['twitter']); ?>" class="apex-leadership-team__social-link" aria-label="Twitter" target="_blank" rel="noopener">
                                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                    </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="apex-leadership-team__member-info">
                            <h3 class="apex-leadership-team__member-name"><?php echo esc_html($member['name']); ?></h3>
                            <span class="apex-leadership-team__member-role"><?php echo esc_html($member['role']); ?></span>
                            <p class="apex-leadership-team__member-bio"><?php echo esc_html($member['bio']); ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_LeadershipTeam_Component::get_instance();

// Helper function
function apex_render_leadership_team($args = []) {
    Apex_LeadershipTeam_Component::get_instance()->render($args);
}
