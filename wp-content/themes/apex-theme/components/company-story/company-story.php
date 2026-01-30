<?php
/**
 * Company Story Component
 * Company history and milestones
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_CompanyStory_Component {
    
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
                'apex-company-story-component',
                get_template_directory_uri() . '/components/company-story/company-story.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-company-story-component',
                get_template_directory_uri() . '/components/company-story/company-story.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Our Story',
            'heading' => 'From Vision to Reality',
            'content' => [],
            'milestones' => []
        ];
        
        $args = wp_parse_args($args, $defaults);
        ?>
        <section class="apex-company-story" data-company-story-section>
            <div class="apex-company-story__container">
                <div class="apex-company-story__header" data-animate="fade-up">
                    <span class="apex-company-story__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-company-story__heading"><?php echo esc_html($args['heading']); ?></h2>
                </div>
                
                <div class="apex-company-story__grid">
                    <div class="apex-company-story__content" data-animate="fade-right">
                        <?php foreach ($args['content'] as $paragraph) : ?>
                        <p><?php echo esc_html($paragraph); ?></p>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="apex-company-story__timeline" data-animate="fade-left">
                        <?php foreach ($args['milestones'] as $index => $milestone) : ?>
                        <div class="apex-company-story__milestone" data-milestone="<?php echo $index; ?>">
                            <div class="apex-company-story__milestone-marker">
                                <span class="apex-company-story__milestone-dot"></span>
                                <?php if ($index < count($args['milestones']) - 1) : ?>
                                <span class="apex-company-story__milestone-line"></span>
                                <?php endif; ?>
                            </div>
                            <div class="apex-company-story__milestone-content">
                                <span class="apex-company-story__milestone-year"><?php echo esc_html($milestone['year']); ?></span>
                                <h4 class="apex-company-story__milestone-title"><?php echo esc_html($milestone['title']); ?></h4>
                                <p class="apex-company-story__milestone-desc"><?php echo esc_html($milestone['description']); ?></p>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </section>
        <?php
    }
}

// Initialize component
Apex_CompanyStory_Component::get_instance();

// Helper function
function apex_render_company_story($args = []) {
    Apex_CompanyStory_Component::get_instance()->render($args);
}
