<?php
/**
 * Success Stories Component
 * Detailed client success stories with metrics
 * Dynamically pulls content from the success_story CPT
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_CaseStudies_Component {
    
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
                'apex-success-stories-component',
                get_template_directory_uri() . '/components/success-stories/success-stories.css',
                [],
                '1.0.1'
            );
            wp_enqueue_script(
                'apex-success-stories-component',
                get_template_directory_uri() . '/components/success-stories/success-stories.js',
                [],
                '1.0.1',
                true
            );
        }
    }

    /**
     * Parse the _success_story_stats meta field into an array of metric/label pairs.
     */
    private function parse_stats($stats_raw) {
        $stats = [];
        if ($stats_raw) {
            foreach (explode("\n", $stats_raw) as $stat_line) {
                $parts = explode('|', $stat_line);
                if (count($parts) >= 2) {
                    $stats[] = ['metric' => trim($parts[0]), 'label' => trim($parts[1])];
                }
            }
        }
        return $stats;
    }

    /**
     * Build a story data array from a WP_Post object.
     */
    private function build_story_data($post) {
        $post_id = $post->ID;
        $thumb = get_the_post_thumbnail_url($post_id, 'large');
        $cats = get_the_terms($post_id, 'success_story_category');
        $industries = get_the_terms($post_id, 'success_story_industry');
        $regions = get_the_terms($post_id, 'success_story_region');
        $client = get_post_meta($post_id, '_success_story_client_partner', true);
        $stats_raw = get_post_meta($post_id, '_success_story_stats', true);

        $category = ($cats && !is_wp_error($cats)) ? $cats[0]->name : 'Success Story';
        $industry = ($industries && !is_wp_error($industries)) ? $industries[0]->name : $category;
        $region = ($regions && !is_wp_error($regions)) ? $regions[0]->name : '';
        $excerpt = wp_trim_words($post->post_excerpt ?: wp_strip_all_tags($post->post_content), 30);

        return [
            'id'       => $post_id,
            'client'   => $client ?: $post->post_title,
            'title'    => $post->post_title,
            'industry' => $industry,
            'location' => $region,
            'image'    => $thumb ?: '',
            'excerpt'  => $excerpt,
            'results'  => $this->parse_stats($stats_raw),
            'link'     => get_permalink($post_id),
            'author_name' => get_the_author_meta('display_name', $post->post_author),
        ];
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => 'Success Stories',
            'heading' => 'Real Results from Real Clients',
            'description' => 'Discover how financial institutions across Africa have transformed their operations with ApexCore.',
            'cta' => [
                'text' => 'View All Success Stories',
                'url' => home_url('/insights/success-stories')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);

        // Determine the featured story: use the same option as the insights page
        $featured_story_id = intval(get_option('apex_stories_featured_story_id_insights-success-stories', 0));
        $featured_post = $featured_story_id ? get_post($featured_story_id) : null;

        // Fallback: use the latest published success story if no featured story is selected
        if (!$featured_post || $featured_post->post_status !== 'publish') {
            $latest = get_posts([
                'post_type'      => 'success_story',
                'post_status'    => 'publish',
                'posts_per_page' => 1,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);
            $featured_post = $latest ? $latest[0] : null;
        }

        $featured = $featured_post ? $this->build_story_data($featured_post) : null;

        // Get additional stories (excluding the featured one)
        $exclude_ids = $featured ? [$featured['id']] : [];
        $other_stories_query = get_posts([
            'post_type'      => 'success_story',
            'post_status'    => 'publish',
            'posts_per_page' => 2,
            'post__not_in'   => $exclude_ids,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);
        $other_stories = [];
        foreach ($other_stories_query as $sp) {
            $other_stories[] = $this->build_story_data($sp);
        }

        ?>
        <section class="apex-case-studies" data-case-studies-section>
            <div class="apex-case-studies__container">
                <!-- Header -->
                <div class="apex-case-studies__header" data-animate="fade-up">
                    <span class="apex-case-studies__badge"><?php echo esc_html($args['badge']); ?></span>
                    <h2 class="apex-case-studies__heading"><?php echo esc_html($args['heading']); ?></h2>
                    <p class="apex-case-studies__description"><?php echo esc_html($args['description']); ?></p>
                </div>
                
                <!-- Featured Success Story -->
                <?php if ($featured) : ?>
                <div class="apex-case-studies__featured" data-animate="fade-up">
                    <div class="apex-case-studies__featured-image">
                        <?php if ($featured['image']) : ?>
                            <img src="<?php echo esc_url($featured['image']); ?>" alt="<?php echo esc_attr($featured['client']); ?>" loading="lazy">
                        <?php else :
                            $ph_hue = abs(crc32($featured['title'] . $featured['id'])) % 360;
                        ?>
                            <div style="width:100%;height:100%;min-height:300px;background:linear-gradient(135deg,hsl(<?php echo $ph_hue; ?>,45%,45%),hsl(<?php echo ($ph_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                                <span style="font-size:64px;font-weight:700;opacity:0.9;"><?php echo esc_html(strtoupper(mb_substr($featured['client'], 0, 1))); ?></span>
                                <span style="font-size:15px;opacity:0.7;margin-top:6px;"><?php echo esc_html($featured['industry']); ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="apex-case-studies__featured-overlay"></div>
                    </div>
                    <div class="apex-case-studies__featured-content">
                        <div class="apex-case-studies__featured-meta">
                            <span class="apex-case-studies__industry"><?php echo esc_html($featured['industry']); ?></span>
                            <?php if ($featured['location']) : ?>
                                <span class="apex-case-studies__location"><?php echo esc_html($featured['location']); ?></span>
                            <?php endif; ?>
                        </div>
                        <h3 class="apex-case-studies__featured-title"><?php echo esc_html($featured['client']); ?></h3>
                        
                        <div class="apex-case-studies__featured-details">
                            <div class="apex-case-studies__detail-block">
                                <h4>Overview</h4>
                                <p><?php echo esc_html($featured['excerpt']); ?></p>
                            </div>
                        </div>
                        
                        <?php if (!empty($featured['results'])) : ?>
                        <div class="apex-case-studies__featured-results">
                            <?php foreach ($featured['results'] as $result) : ?>
                            <div class="apex-case-studies__result">
                                <span class="apex-case-studies__result-metric"><?php echo esc_html($result['metric']); ?></span>
                                <span class="apex-case-studies__result-label"><?php echo esc_html($result['label']); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        <?php endif; ?>
                        
                        <a href="<?php echo esc_url($featured['link']); ?>" class="apex-case-studies__read-more">
                            Read Full Success Story
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M5 12h14M12 5l7 7-7 7"/>
                            </svg>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Other Success Stories Grid -->
                <?php if (!empty($other_stories)) : ?>
                <div class="apex-case-studies__grid">
                    <?php foreach ($other_stories as $index => $story) : ?>
                    <div class="apex-case-studies__card" data-animate="fade-up" data-delay="<?php echo $index * 100; ?>">
                        <div class="apex-case-studies__card-image">
                            <?php if ($story['image']) : ?>
                                <img src="<?php echo esc_url($story['image']); ?>" alt="<?php echo esc_attr($story['client']); ?>" loading="lazy">
                            <?php else :
                                $card_hue = abs(crc32($story['title'] . $story['id'])) % 360;
                            ?>
                                <div style="width:100%;height:100%;min-height:200px;background:linear-gradient(135deg,hsl(<?php echo $card_hue; ?>,45%,45%),hsl(<?php echo ($card_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                                    <span style="font-size:48px;font-weight:700;opacity:0.9;"><?php echo esc_html(strtoupper(mb_substr($story['client'], 0, 1))); ?></span>
                                    <span style="font-size:13px;opacity:0.7;margin-top:4px;"><?php echo esc_html($story['industry']); ?></span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="apex-case-studies__card-content">
                            <div class="apex-case-studies__card-meta">
                                <span class="apex-case-studies__industry"><?php echo esc_html($story['industry']); ?></span>
                            </div>
                            <h3 class="apex-case-studies__card-title"><?php echo esc_html($story['client']); ?></h3>
                            <p class="apex-case-studies__card-challenge"><?php echo esc_html(wp_trim_words($story['excerpt'], 20)); ?></p>
                            
                            <?php if (!empty($story['results'])) : ?>
                            <div class="apex-case-studies__card-results">
                                <?php foreach (array_slice($story['results'], 0, 2) as $result) : ?>
                                <div class="apex-case-studies__card-result">
                                    <span class="apex-case-studies__result-metric"><?php echo esc_html($result['metric']); ?></span>
                                    <span class="apex-case-studies__result-label"><?php echo esc_html($result['label']); ?></span>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <?php endif; ?>
                            
                            <a href="<?php echo esc_url($story['link']); ?>" class="apex-case-studies__card-link">
                                View Success Story
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M5 12h14M12 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <!-- CTA -->
                <div class="apex-case-studies__cta" data-animate="fade-up">
                    <a href="<?php echo esc_url($args['cta']['url']); ?>" class="apex-case-studies__cta-btn">
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
Apex_CaseStudies_Component::get_instance();

// Helper function
function apex_render_case_studies($args = []) {
    Apex_CaseStudies_Component::get_instance()->render($args);
}
