<?php
/**
 * What's New Component
 * Latest posts/news section
 * 
 * @package ApexTheme
 * @subpackage Components
 */

if (!defined('ABSPATH')) exit;

class Apex_WhatsNew_Component {
    
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
                'apex-whats-new-component',
                get_template_directory_uri() . '/components/whats-new/whats-new.css',
                [],
                '1.0.0'
            );
            wp_enqueue_script(
                'apex-whats-new-component',
                get_template_directory_uri() . '/components/whats-new/whats-new.js',
                [],
                '1.0.0',
                true
            );
        }
    }
    
    public function render($args = []) {
        $defaults = [
            'badge' => "What's New",
            'heading' => 'Latest News & Insights',
            'description' => 'Stay updated with the latest developments in financial technology and Apex Softwares.',
            'posts_per_page' => 3,
            'category' => '',
            'cta' => [
                'text' => 'View All Articles',
                'url' => home_url('/blog')
            ]
        ];
        
        $args = wp_parse_args($args, $defaults);
        
        // Query posts
        $query_args = [
            'post_type' => 'post',
            'posts_per_page' => $args['posts_per_page'],
            'post_status' => 'publish',
            'orderby' => 'date',
            'order' => 'DESC'
        ];
        
        if (!empty($args['category'])) {
            $query_args['category_name'] = $args['category'];
        }
        
        $posts_query = new WP_Query($query_args);
        
        // Fallback posts if no real posts exist
        $fallback_posts = [
            [
                'title' => 'Apex Softwares Launches Next-Gen Mobile Banking Platform',
                'excerpt' => 'Our latest mobile banking solution brings cutting-edge features including biometric authentication, instant transfers, and AI-powered financial insights.',
                'date' => date('F j, Y', strtotime('-3 days')),
                'category' => 'Product Update',
                'image' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=600',
                'url' => '#'
            ],
            [
                'title' => 'Digital Transformation: The Future of African Banking',
                'excerpt' => 'Explore how digital transformation is reshaping the financial landscape across Africa and what it means for traditional banking institutions.',
                'date' => date('F j, Y', strtotime('-1 week')),
                'category' => 'Industry Insights',
                'image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600',
                'url' => '#'
            ],
            [
                'title' => 'Apex Partners with Central Bank for Financial Inclusion Initiative',
                'excerpt' => 'A groundbreaking partnership aimed at bringing banking services to underserved communities through innovative agent banking solutions.',
                'date' => date('F j, Y', strtotime('-2 weeks')),
                'category' => 'Company News',
                'image' => 'https://images.unsplash.com/photo-1559526324-4b87b5e36e44?w=600',
                'url' => '#'
            ]
        ];
        ?>
        <section class="apex-whats-new" data-whats-new-section>
            <div class="apex-whats-new__container">
                <!-- Header -->
                <div class="apex-whats-new__header" data-animate="fade-up">
                    <div class="apex-whats-new__header-content">
                        <span class="apex-whats-new__badge"><?php echo esc_html($args['badge']); ?></span>
                        <h2 class="apex-whats-new__heading"><?php echo esc_html($args['heading']); ?></h2>
                        <p class="apex-whats-new__description"><?php echo esc_html($args['description']); ?></p>
                    </div>
                    <a href="<?php echo esc_url($args['cta']['url']); ?>" class="apex-whats-new__header-cta">
                        <?php echo esc_html($args['cta']['text']); ?>
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                
                <!-- Posts Grid -->
                <div class="apex-whats-new__grid">
                    <?php if ($posts_query->have_posts()) : ?>
                        <?php $index = 0; while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
                        <article class="apex-whats-new__card" data-animate="fade-up" data-delay="<?php echo $index * 100; ?>">
                            <a href="<?php the_permalink(); ?>" class="apex-whats-new__card-link">
                                <div class="apex-whats-new__card-image" style="position: relative;">
                        <?php
                        $wn_cats = get_the_category();
                        $wn_cat_name = $wn_cats ? $wn_cats[0]->name : 'Article';
                        ?>
                                    <?php if (has_post_thumbnail()) : ?>
                                        <?php the_post_thumbnail('medium_large', ['class' => 'apex-whats-new__image', 'loading' => 'lazy']); ?>
                            <?php else :
                                $wn_cats = get_the_category();
                                $wn_cat_name = $wn_cats ? $wn_cats[0]->name : 'Article';
                                $wn_hash = crc32(get_the_title() . get_the_ID());
                                $wn_hue = abs($wn_hash) % 360;
                                $wn_initial = strtoupper(mb_substr($wn_cat_name, 0, 1));
                            ?>
                                <div style="width:100%;height:100%;min-height:200px;background:linear-gradient(135deg,hsl(<?php echo $wn_hue; ?>,45%,45%),hsl(<?php echo ($wn_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                                    <span style="font-size:48px;font-weight:700;opacity:0.9;"><?php echo esc_html($wn_initial); ?></span>
                                    <span style="font-size:13px;opacity:0.7;margin-top:4px;"><?php echo esc_html(isset($post['category']) ? $post['category'] : $wn_cat_name); ?></span>
                                </div>
                            <?php endif; ?>
<span class="apex-whats-new__card-category" style="position: absolute; top: 1rem; left: 1rem; padding: 0.5rem 1rem; background: #f97316; color: #ffffff; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; border-radius: 50px;"><?php echo esc_html(isset($post['category']) ? $post['category'] : $wn_cat_name); ?></span>
                                    <div class="apex-whats-new__card-overlay"></div>
                                </div>
                                <div class="apex-whats-new__card-content">
                                    <div class="apex-whats-new__card-meta">
                                        <span class="apex-whats-new__card-date">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="apex-whats-new__card-title"><?php the_title(); ?></h3>
                                    <p class="apex-whats-new__card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                                    <span class="apex-whats-new__card-read-more">
                                        Read Article
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        </article>
                        <?php $index++; endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                        <?php foreach ($fallback_posts as $index => $post) : ?>
                        <article class="apex-whats-new__card" data-animate="fade-up" data-delay="<?php echo $index * 100; ?>">
                            <a href="<?php echo esc_url($post['url']); ?>" class="apex-whats-new__card-link">
                                <div class="apex-whats-new__card-image" style="position: relative;">
                        <?php
                        $wn_cats = get_the_category();
                        $wn_cat_name = $wn_cats ? $wn_cats[0]->name : 'Article';
                        ?>
                            <?php
                            $fb_hue = abs(crc32($post['title'])) % 360;
                            $fb_initial = strtoupper(mb_substr($post['category'], 0, 1));
                            ?>
                            <div style="width:100%;height:100%;min-height:200px;background:linear-gradient(135deg,hsl(<?php echo $fb_hue; ?>,45%,45%),hsl(<?php echo ($fb_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                                <span style="font-size:48px;font-weight:700;opacity:0.9;"><?php echo esc_html($fb_initial); ?></span>
                                <span style="font-size:13px;opacity:0.7;margin-top:4px;"><?php echo esc_html($post['category']); ?></span>
                            </div>
<span class="apex-whats-new__card-category" style="position: absolute; top: 1rem; left: 1rem; padding: 0.5rem 1rem; background: #f97316; color: #ffffff; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; border-radius: 50px;"><?php echo esc_html(isset($post['category']) ? $post['category'] : $wn_cat_name); ?></span>
                                    <div class="apex-whats-new__card-overlay"></div>
                                </div>
                                <div class="apex-whats-new__card-content">
                                    <div class="apex-whats-new__card-meta">
                                        <span class="apex-whats-new__card-date">
                                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <h3 class="apex-whats-new__card-title"><?php echo esc_html($post['title']); ?></h3>
                                    <p class="apex-whats-new__card-excerpt"><?php echo esc_html($post['excerpt']); ?></p>
                                    <span class="apex-whats-new__card-read-more">
                                        Read Article
                                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                            <path d="M5 12h14M12 5l7 7-7 7"/>
                                        </svg>
                                    </span>
                                </div>
                            </a>
                        </article>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                
                <!-- Mobile CTA -->
                <div class="apex-whats-new__mobile-cta" data-animate="fade-up">
                    <a href="<?php echo esc_url($args['cta']['url']); ?>" class="apex-whats-new__cta-btn">
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
Apex_WhatsNew_Component::get_instance();

// Helper function
function apex_render_whats_new($args = []) {
    Apex_WhatsNew_Component::get_instance()->render($args);
}
