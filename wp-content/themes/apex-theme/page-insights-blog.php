<?php 
/**
 * Template Name: Insights Blog
 * Blog Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_blog_hero_stats_insights-blog', "200+ | Articles Published\n50K+ | Monthly Readers\n15+ | Expert Contributors\n8 | Topic Categories");
$stats_array = [];
foreach (explode("\n", $hero_stats) as $stat_line) {
    $parts = explode(' | ', $stat_line);
    if (count($parts) >= 2) {
        $stats_array[] = [
            'value' => trim($parts[0]),
            'label' => trim($parts[1])
        ];
    }
}

apex_render_about_hero([
    'badge' => get_option('apex_blog_hero_badge_insights-blog', 'Insights & Thought Leadership'),
    'heading' => get_option('apex_blog_hero_heading_insights-blog', 'The Apex Blog'),
    'description' => get_option('apex_blog_hero_description_insights-blog', 'Expert insights, industry trends, and practical guides on digital banking, financial technology, and driving innovation in African financial services.'),
    'stats' => $stats_array,
    'image' => get_option('apex_blog_hero_image_insights-blog', 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1200')
]);
?>

<section class="apex-blog-featured">
    <div class="apex-blog-featured__container">
        <div class="apex-blog-featured__header">
            <span class="apex-blog-featured__badge"><?php echo esc_html(get_option('apex_blog_featured_badge_insights-blog', "Editor's Pick")); ?></span>
        </div>
        
        <div class="apex-blog-featured__card">
            <div class="apex-blog-featured__image">
                <img src="<?php echo esc_url(get_option('apex_blog_featured_image_insights-blog', 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=800')); ?>" alt="<?php echo esc_attr(get_option('apex_blog_featured_title_insights-blog', 'Featured Article')); ?>" loading="lazy">
                <span class="apex-blog-featured__category"><?php echo esc_html(get_option('apex_blog_featured_category_insights-blog', 'Digital Banking')); ?></span>
            </div>
            <div class="apex-blog-featured__content">
                <div class="apex-blog-featured__meta">
                    <span class="apex-blog-featured__date"><?php echo esc_html(get_option('apex_blog_featured_date_insights-blog', 'January 25, 2026')); ?></span>
                    <span class="apex-blog-featured__read-time"><?php echo esc_html(get_option('apex_blog_featured_readtime_insights-blog', '8 min read')); ?></span>
                </div>
                <h2 class="apex-blog-featured__title"><?php echo esc_html(get_option('apex_blog_featured_title_insights-blog', 'The Future of Digital Banking in Africa: 5 Trends Shaping 2026 and Beyond')); ?></h2>
                <p class="apex-blog-featured__excerpt"><?php echo esc_html(get_option('apex_blog_featured_excerpt_insights-blog', 'As we enter 2026, the African banking landscape continues to evolve at an unprecedented pace. From embedded finance to AI-driven personalization, discover the key trends that will define the next era of financial services across the continent.')); ?></p>
                <div class="apex-blog-featured__author">
                    <img src="<?php echo esc_url(get_option('apex_blog_featured_author_image_insights-blog', 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100')); ?>" alt="<?php echo esc_attr(get_option('apex_blog_featured_author_name_insights-blog', 'Author')); ?>">
                    <div>
                        <strong><?php echo esc_html(get_option('apex_blog_featured_author_name_insights-blog', 'Sarah Ochieng')); ?></strong>
                        <span><?php echo esc_html(get_option('apex_blog_featured_author_title_insights-blog', 'Chief Technology Officer')); ?></span>
                    </div>
                </div>
                <a href="<?php echo esc_url(get_option('apex_blog_featured_link_insights-blog', '#')); ?>" class="apex-blog-featured__link">
                    Read Full Article
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="apex-blog-categories">
    <div class="apex-blog-categories__container">
        <h2 class="apex-blog-categories__heading">Browse by Topic</h2>
        <div class="apex-blog-categories__grid">
            <?php
            // Dynamic categories from WordPress taxonomy
            $wp_categories = get_categories([
                'orderby' => 'count',
                'order' => 'DESC',
                'hide_empty' => false,
            ]);

            // Default SVG icon for categories
            $default_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>';

            // Map category slugs to custom icons (optional visual enhancement)
            $category_icons = [
                'uncategorized' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
                'digital-banking' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>',
                'mobile-banking' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>',
                'financial-inclusion' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                'security' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                'ai-analytics' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>',
                'api-integration' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>',
                'sacco-mfi' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>',
                'product-updates' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>',
            ];

            foreach ($wp_categories as $cat) :
                $icon = isset($category_icons[$cat->slug]) ? $category_icons[$cat->slug] : $default_icon;
                $article_count = $cat->count . ' ' . _n('article', 'articles', $cat->count);
                $cat_link = get_category_link($cat->term_id);
            ?>
                <a href="<?php echo esc_url($cat_link); ?>" class="apex-blog-categories__item" data-category="<?php echo esc_attr($cat->slug); ?>">
                    <?php echo $icon; ?>
                    <span><?php echo esc_html($cat->name); ?></span>
                    <small><?php echo esc_html($article_count); ?></small>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="apex-blog-grid">
    <div class="apex-blog-grid__container">
        <div class="apex-blog-grid__header">
            <h2 class="apex-blog-grid__heading">Latest Articles</h2>
            <div class="apex-blog-grid__search">
                <input type="text" placeholder="Search articles...">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
            </div>
        </div>
        
        <div class="apex-blog-grid__items">
            <?php
            // Pagination setup - paged is set by apex_insights_template_redirect in functions.php
            $paged = max(1, intval(get_query_var('paged', 1)));
            
            $posts_per_page = 6;
            
            // WordPress query with proper pagination
            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
                'ignore_sticky_posts' => true
            );
            
            $blog_query = new WP_Query($args);
            
            if ($blog_query->have_posts()) :
                $index = 0;
                while ($blog_query->have_posts()) : $blog_query->the_post();
            ?>
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
                            <span><?php echo reading_time(); ?> min read</span>
                        </div>
                        <a href="<?php the_permalink(); ?>">Read Article →</a>
                    </div>
                </article>
            <?php
                $index++;
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="apex-blog-grid__no-posts">
                    <p>No articles found. Check back soon for new content!</p>
                </div>
            <?php endif; ?>
        </div></div>
        
        <div class="apex-blog-grid__pagination">
            <?php
            // Dynamic pagination
            $total_pages = $blog_query->max_num_pages;
            
            if ($total_pages > 1) :
                // Previous page link
                if ($paged > 1) :
            ?>
                <a href="<?php echo get_pagenum_link($paged - 1); ?>" class="apex-blog-grid__page-btn">←</a>
            <?php endif; ?>
            
            <?php
            // Page numbers
            $show_pages = 4;
            $start_page = max(1, $paged - floor($show_pages / 2));
            $end_page = min($total_pages, $start_page + $show_pages - 1);
            
            if ($start_page > 1) :
            ?>
                <a href="<?php echo get_pagenum_link(1); ?>" class="apex-blog-grid__page-btn">1</a>
                <?php if ($start_page > 2) : ?>
                    <span class="apex-blog-grid__page-ellipsis">...</span>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                <?php if ($i == $paged) : ?>
                    <button class="apex-blog-grid__page-btn active"><?php echo $i; ?></button>
                <?php else : ?>
                    <a href="<?php echo get_pagenum_link($i); ?>" class="apex-blog-grid__page-btn"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php
            if ($end_page < $total_pages) :
                if ($end_page < $total_pages - 1) :
            ?>
                    <span class="apex-blog-grid__page-ellipsis">...</span>
                <?php endif; ?>
                <a href="<?php echo get_pagenum_link($total_pages); ?>" class="apex-blog-grid__page-btn"><?php echo $total_pages; ?></a>
            <?php endif; ?>
            
            <?php
            // Next page link
            if ($paged < $total_pages) :
            ?>
                <a href="<?php echo get_pagenum_link($paged + 1); ?>" class="apex-blog-grid__page-btn">→</a>
            <?php endif; ?>
            
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="apex-blog-newsletter">
    <div class="apex-blog-newsletter__container">
        <div class="apex-blog-newsletter__content">
            <h2 class="apex-blog-newsletter__heading"><?php echo esc_html(get_option('apex_blog_newsletter_heading_insights-blog', 'Get Insights Delivered')); ?></h2>
            <p class="apex-blog-newsletter__description"><?php echo esc_html(get_option('apex_blog_newsletter_description_insights-blog', 'Subscribe to our weekly newsletter for the latest articles, industry news, and exclusive insights from our team of experts.')); ?></p>
            
            <form class="apex-blog-newsletter__form">
                <input type="email" placeholder="<?php echo esc_attr(get_option('apex_blog_newsletter_placeholder_insights-blog', 'Enter your email address')); ?>" required>
                <button type="submit"><?php echo esc_html(get_option('apex_blog_newsletter_button_insights-blog', 'Subscribe')); ?></button>
            </form>
            
            <p class="apex-blog-newsletter__note"><?php echo esc_html(get_option('apex_blog_newsletter_note_insights-blog', 'Join 10,000+ subscribers. Unsubscribe at any time.')); ?></p>
        </div>
    </div>
</section>

<?php get_footer(); ?>
