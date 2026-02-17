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
                <div class="apex-blog-grid__grid">
                    <?php if ($posts_query->have_posts()) : ?>
                        <?php $index = 0; while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
                        <article class="apex-blog-grid__item" data-animate="fade-up" data-delay="<?php echo $index * 100; ?>">
                        <div class="apex-blog-grid__item-image">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('medium_large', ['class' => '', 'loading' => 'lazy']); ?>
                            <?php else : ?>
                                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400" alt="<?php the_title_attribute(); ?>" loading="lazy">
                            <?php endif; ?>
                        </div>
                        <div class="apex-blog-grid__item-content">
                            <?php
                            $categories = get_the_category();
                            if ($categories) : ?>
                                <span class="apex-blog-grid__item-category"><?php echo esc_html($categories[0]->name); ?></span>
                            <?php endif; ?>
                            <h3><?php the_title(); ?></h3>
                            <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                            <div class="apex-blog-grid__item-meta">
                                <span><?php echo get_the_date(); ?></span>
                                <span>5 min read</span>
                            </div>
                            <a href="<?php the_permalink(); ?>">Read Article →</a>
                        </div>
                    </article>
                        <?php $index++; endwhile; wp_reset_postdata(); ?>
                    <?php else : ?>
                        <?php foreach ($fallback_posts as $index => $post) : ?>
                                            <article class="apex-blog-grid__item" data-animate="fade-up" data-delay="<?php echo $index * 100; ?>">
                                                <div class="apex-blog-grid__item-image">
                                                    <img src="<?php echo esc_url($post['image']); ?>" alt="<?php echo esc_attr($post['title']); ?>" loading="lazy">
                                                </div>
                                                <div class="apex-blog-grid__item-content">
                                                    <span class="apex-blog-grid__item-category"><?php echo esc_html($post['category']); ?></span>
                                                    <h3><?php echo esc_html($post['title']); ?></h3>
                                                    <p><?php echo esc_html($post['excerpt']); ?></p>
                                                    <div class="apex-blog-grid__item-meta">
                                                        <span><?php echo esc_html($post['date']); ?></span>
                                                        <span>5 min read</span>
                                                    </div>
                                                    <a href="<?php echo esc_url($post['url']); ?>">Read Article →</a>
                                                </div>
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
