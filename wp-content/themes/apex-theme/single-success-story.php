<?php
/**
 * Template Name: Single Success Story
 * Single Success Story Template for success_story CPT
 *
 * @package ApexTheme
 */

get_header();
?>

<?php while (have_posts()) : the_post();
    $post_id   = get_the_ID();
    $terms     = get_the_terms($post_id, 'success_story_category');
    $category  = ($terms && !is_wp_error($terms)) ? $terms[0]->name : 'Success Story';
    $cat_slug  = ($terms && !is_wp_error($terms)) ? $terms[0]->slug : 'success-story';
    $ph_hue    = abs(crc32(get_the_title() . $post_id)) % 360;
    $wc        = str_word_count(wp_strip_all_tags(get_the_content()));
    $read_time = max(1, ceil($wc / 200));
    $thumb_url = get_the_post_thumbnail_url($post_id, 'full');
?>

<!-- ── Hero: full-width image with overlaid title card ── -->
<section class="sn-hero<?php echo $thumb_url ? '' : ' sn-hero--no-img'; ?>"
         <?php if ($thumb_url) : ?>style="background-image:url('<?php echo esc_url($thumb_url); ?>')"<?php endif; ?>>
    <?php if (!$thumb_url) : ?>
        <div class="sn-hero__gradient" style="background:linear-gradient(135deg,hsl(<?php echo $ph_hue; ?>,40%,30%),hsl(<?php echo ($ph_hue+40)%360; ?>,50%,22%));"></div>
    <?php endif; ?>

    <div class="sn-hero__overlay"></div>

    <div class="sn-hero__inner">
        <nav class="sn-hero__breadcrumb">
            <a href="<?php echo esc_url(home_url('/')); ?>">Home</a>
            <span class="sn-hero__sep">/</span>
            <a href="<?php echo esc_url(home_url('/insights/success-stories')); ?>">Success Stories</a>
        </nav>

        <div class="sn-hero__card">
            <span class="sn-hero__badge"><?php echo esc_html($category); ?></span>
            <h1 class="sn-hero__title"><?php the_title(); ?></h1>
            <div class="sn-hero__meta">
                <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('F j, Y'); ?></time>
                <span class="sn-hero__dot"></span>
                <span><?php echo esc_html($read_time); ?> min read</span>
            </div>
        </div>
    </div>
</section>

<!-- ── Article body + sidebar ── -->
<section class="sn-body">
    <div class="sn-body__wrap">

        <article class="sn-body__article">
            <div class="sn-body__content">
                <?php the_content(); ?>
            </div>

            <footer class="sn-body__foot">
                <p class="sn-body__share-label">Share this article</p>
                <div class="sn-body__share">
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>"
                       target="_blank" rel="noopener noreferrer" class="sn-body__share-btn sn-body__share-btn--li" title="Share on LinkedIn">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M19 3a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h14m-.5 15.5v-5.3a3.26 3.26 0 0 0-3.26-3.26c-.85 0-1.84.52-2.32 1.3v-1.11h-2.79v8.37h2.79v-4.93c0-.77.62-1.4 1.39-1.4a1.4 1.4 0 0 1 1.4 1.4v4.93h2.79M6.88 8.56a1.68 1.68 0 0 0 1.68-1.68c0-.93-.75-1.69-1.68-1.69a1.69 1.69 0 0 0-1.69 1.69c0 .93.76 1.68 1.69 1.68m1.39 9.94v-8.37H5.5v8.37h2.77z"/></svg>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>"
                       target="_blank" rel="noopener noreferrer" class="sn-body__share-btn sn-body__share-btn--tw" title="Share on X">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>"
                       target="_blank" rel="noopener noreferrer" class="sn-body__share-btn sn-body__share-btn--fb" title="Share on Facebook">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </a>
                    <a href="https://www.instagram.com/"
                       target="_blank" rel="noopener noreferrer" class="sn-body__share-btn sn-body__share-btn--ig" title="Share on Instagram (copy link)">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zM5.838 12a6.162 6.162 0 1112.324 0 6.162 6.162 0 01-12.324 0zM12 16a4 4 0 110-8 4 4 0 010 8zm4.965-10.405a1.44 1.44 0 112.881.001 1.44 1.44 0 01-2.881-.001z"/></svg>
                    </a>
                    <a href="https://wa.me/?text=<?php echo urlencode(get_the_title() . ' ' . get_permalink()); ?>"
                       target="_blank" rel="noopener noreferrer" class="sn-body__share-btn sn-body__share-btn--wa" title="Share on WhatsApp">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.149-.67.149-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414-.074-.123-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/></svg>
                    </a>
                    <a href="mailto:?subject=<?php echo urlencode(get_the_title()); ?>&body=<?php echo urlencode(get_permalink()); ?>"
                       class="sn-body__share-btn sn-body__share-btn--em" title="Share via Email">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
                    </a>
                </div>
            </footer>
        </article>

        <aside class="sn-body__side">
            <div class="sn-side-card">
                <h3 class="sn-side-card__heading">Related Stories</h3>
                <?php
                $related_args = [
                    'post_type'      => 'success_story',
                    'post_status'    => 'publish',
                    'posts_per_page' => 5,
                    'post__not_in'   => [$post_id],
                    'orderby'        => 'rand',
                ];
                if ($terms && !is_wp_error($terms)) {
                    $related_args['tax_query'] = [[
                        'taxonomy' => 'success_story_category',
                        'field'    => 'term_id',
                        'terms'    => wp_list_pluck($terms, 'term_id'),
                    ]];
                }
                $related_query = new WP_Query($related_args);
                if (!$related_query->have_posts()) {
                    $related_query = new WP_Query([
                        'post_type'      => 'success_story',
                        'post_status'    => 'publish',
                        'posts_per_page' => 5,
                        'post__not_in'   => [$post_id],
                        'orderby'        => 'date',
                        'order'          => 'DESC',
                    ]);
                }
                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                        $r_hue   = abs(crc32(get_the_title() . get_the_ID())) % 360;
                        $r_terms = get_the_terms(get_the_ID(), 'success_story_category');
                        $r_cat   = ($r_terms && !is_wp_error($r_terms)) ? $r_terms[0]->name : '';
                ?>
                <a href="<?php the_permalink(); ?>" class="sn-related">
                    <div class="sn-related__img">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('thumbnail', ['loading' => 'lazy']); ?>
                        <?php else : ?>
                            <div style="width:100%;height:100%;background:linear-gradient(135deg,hsl(<?php echo $r_hue; ?>,40%,40%),hsl(<?php echo ($r_hue+40)%360; ?>,50%,30%));display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.25rem;font-weight:700;">
                                <?php echo esc_html(strtoupper(mb_substr(get_the_title(), 0, 1))); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="sn-related__text">
                        <?php if ($r_cat) : ?><span class="sn-related__cat"><?php echo esc_html($r_cat); ?></span><?php endif; ?>
                        <h4><?php the_title(); ?></h4>
                        <time><?php echo get_the_date('M j, Y'); ?></time>
                    </div>
                </a>
                <?php endwhile; wp_reset_postdata();
                else : ?>
                    <p class="sn-side-card__empty">No related stories yet.</p>
                <?php endif; ?>
            </div>

            <div class="sn-side-cta">
                <div class="sn-side-cta__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"/></svg>
                </div>
                <h3>Explore More</h3>
                <p>Discover how Apex Softwares has transformed institutions worldwide.</p>
                <a href="<?php echo esc_url(home_url('/insights/success-stories')); ?>" class="sn-side-cta__btn">All Success Stories</a>
            </div>
        </aside>

    </div>
</section>

<!-- ── Prev / Next navigation ── -->
<nav class="sn-nav">
    <div class="sn-nav__wrap">
        <?php
        $prev_post = get_previous_post(false, '', 'success_story_category');
        $next_post = get_next_post(false, '', 'success_story_category');
        if (!$prev_post) $prev_post = get_previous_post();
        if (!$next_post) $next_post = get_next_post();
        ?>

        <?php if ($prev_post) : ?>
        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="sn-nav__link sn-nav__link--prev">
            <span class="sn-nav__arrow">←</span>
            <div>
                <span class="sn-nav__label">Previous</span>
                <strong><?php echo esc_html(wp_trim_words($prev_post->post_title, 8)); ?></strong>
            </div>
        </a>
        <?php else : ?><span></span><?php endif; ?>

        <?php if ($next_post) : ?>
        <a href="<?php echo get_permalink($next_post->ID); ?>" class="sn-nav__link sn-nav__link--next">
            <div>
                <span class="sn-nav__label">Next</span>
                <strong><?php echo esc_html(wp_trim_words($next_post->post_title, 8)); ?></strong>
            </div>
            <span class="sn-nav__arrow">→</span>
        </a>
        <?php else : ?><span></span><?php endif; ?>
    </div>
</nav>

<?php endwhile; ?>

<?php get_footer(); ?>
