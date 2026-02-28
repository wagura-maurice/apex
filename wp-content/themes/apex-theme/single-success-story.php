<?php 
/**
 * Template Name: Single Success Story
 * Single Success Story Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php while (have_posts()) : the_post(); ?>

<section class="apex-single-story-hero">
    <div class="apex-single-story-hero__container">
        <div class="apex-single-story-hero__content">
            <div class="apex-single-story-hero__meta">
                <span class="apex-single-story-hero__category">
                    <?php
                    $categories = get_the_terms(get_the_ID(), 'success_story_category');
                    $category = $categories ? $categories[0]->name : 'Success Story';
                    echo esc_html($category);
                    ?>
                </span>
                <span class="apex-single-story-hero__date"><?php echo get_the_date('F j, Y'); ?></span>
                <span class="apex-single-story-hero__read-time"><?php echo reading_time(); ?> min read</span>
            </div>
            
            <h1 class="apex-single-story-hero__title"><?php the_title(); ?></h1>
            
            <div class="apex-single-story-hero__excerpt">
                <?php echo wp_trim_words(get_the_excerpt(), 40); ?>
            </div>
            
            <div class="apex-single-story-hero__author">
                <img src="<?php echo get_avatar_url(get_the_author_meta('ID'), ['size' => 100]); ?>" alt="<?php echo esc_attr(get_the_author_meta('display_name')); ?>">
                <div>
                    <strong><?php echo get_the_author_meta('display_name'); ?></strong>
                    <span><?php echo get_the_author_meta('description') ?: 'Contributor'; ?></span>
                </div>
            </div>
        </div>
        
        <div class="apex-single-story-hero__image">
            <?php if (has_post_thumbnail()) : ?>
                <?php the_post_thumbnail('large', ['class' => '', 'loading' => 'lazy']); ?>
            <?php else :
                $hash = crc32(get_the_title() . get_the_ID());
                $hue = abs($hash) % 360;
                $initial = strtoupper(mb_substr($category, 0, 1));
            ?>
                <div style="width:100%;height:100%;min-height:400px;background:linear-gradient(135deg,hsl(<?php echo $hue; ?>,45%,45%),hsl(<?php echo ($hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                    <span style="font-size:96px;font-weight:700;opacity:0.9;"><?php echo esc_html($initial); ?></span>
                    <span style="font-size:18px;opacity:0.7;margin-top:8px;"><?php echo esc_html($category); ?></span>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="apex-single-story-content">
    <div class="apex-single-story-content__container">
        <div class="apex-single-story-content__main">
            <div class="apex-single-story-content__body">
                <?php the_content(); ?>
            </div>
            
            <?php if (get_the_tags()) : ?>
            <div class="apex-single-story-content__tags">
                <h3>Tags</h3>
                <div class="apex-single-story-content__tag-list">
                    <?php foreach (get_the_tags() as $tag) : ?>
                        <a href="<?php echo get_tag_link($tag->term_id); ?>" class="apex-single-story-content__tag">
                            <?php echo esc_html($tag->name); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
            
            <div class="apex-single-story-content__share">
                <h3>Share this story</h3>
                <div class="apex-single-story-content__share-buttons">
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="apex-single-story-content__share-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
                        LinkedIn
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="apex-single-story-content__share-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M22.46 6c-.85.38-1.75.64-2.7.76 1-.6 1.76-1.55 2.12-2.68-.93.55-1.96.95-3.06 1.17-.88-.94-2.13-1.53-3.51-1.53-2.66 0-4.81 2.16-4.81 4.81 0 .38.04.75.13 1.1-4-.2-7.58-2.11-9.96-5.02-.41.71-.65 1.53-.65 2.4 0 1.67.85 3.14 2.14 4.01-.79-.03-1.54-.24-2.19-.61v.06c0 2.33 1.66 4.28 3.86 4.72-.4.11-.83.17-1.27.17-.31 0-.62-.03-.92-.08.63 1.91 2.39 3.3 4.49 3.34-1.65 1.29-3.72 2.06-5.97 2.06-.39 0-.77-.02-1.15-.07 2.13 1.36 4.65 2.16 7.37 2.16 8.84 0 13.68-7.32 13.68-13.68 0-.21 0-.42-.01-.62.94-.68 1.76-1.53 2.4-2.5z"/></svg>
                        Twitter
                    </a>
                    <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>" class="apex-single-story-content__share-btn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                        Email
                    </a>
                </div>
            </div>
        </div>
        
        <aside class="apex-single-story-content__sidebar">
            <div class="apex-single-story-content__related">
                <h3>Related Success Stories</h3>
                <?php
                $related_args = [
                    'post_type' => 'success_story',
                    'posts_per_page' => 3,
                    'post__not_in' => [get_the_ID()],
                    'orderby' => 'rand',
                    'post_status' => 'publish'
                ];
                $related_query = new WP_Query($related_args);
                
                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                ?>
                    <article class="apex-single-story-content__related-item">
                        <a href="<?php the_permalink(); ?>" class="apex-single-story-content__related-link">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('thumbnail', ['class' => '', 'loading' => 'lazy']); ?>
                            <?php endif; ?>
                            <div class="apex-single-story-content__related-content">
                                <h4><?php the_title(); ?></h4>
                                <span><?php echo get_the_date(); ?></span>
                            </div>
                        </a>
                    </article>
                <?php
                    endwhile;
                    wp_reset_postdata();
                else :
                ?>
                    <p>No related stories found.</p>
                <?php endif; ?>
            </div>
            
            <div class="apex-single-story-content__cta">
                <h3>Ready to Transform Your Business?</h3>
                <p>See how our solutions can help you achieve similar results.</p>
                <a href="<?php echo home_url('/request-demo'); ?>" class="apex-single-story-content__cta-btn">
                    Request a Demo
                </a>
            </div>
        </aside>
    </div>
</section>

<section class="apex-single-story-navigation">
    <div class="apex-single-story-navigation__container">
        <?php
        $prev_post = get_previous_post();
        $next_post = get_next_post();
        ?>
        
        <?php if ($prev_post) : ?>
            <a href="<?php echo get_permalink($prev_post->ID); ?>" class="apex-single-story-navigation__prev">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M19 12H5M12 19l-7-7 7-7"/></svg>
                <div>
                    <span>Previous Story</span>
                    <strong><?php echo esc_html($prev_post->post_title); ?></strong>
                </div>
            </a>
        <?php endif; ?>
        
        <a href="<?php echo home_url('/insights/success-stories'); ?>" class="apex-single-story-navigation__all">
            All Success Stories
        </a>
        
        <?php if ($next_post) : ?>
            <a href="<?php echo get_permalink($next_post->ID); ?>" class="apex-single-story-navigation__next">
                <div>
                    <span>Next Story</span>
                    <strong><?php echo esc_html($next_post->post_title); ?></strong>
                </div>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        <?php endif; ?>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>
