<?php 
/**
 * Template Name: News & Updates
 * News & Updates Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'News & Updates',
    'heading' => 'Latest from Apex Softwares',
    'description' => 'Stay informed about our latest product releases, company announcements, industry insights, and the impact we\'re making across African financial services.',
    'stats' => [
        ['value' => '50+', 'label' => 'Articles Published'],
        ['value' => '12', 'label' => 'Industry Awards'],
        ['value' => '25+', 'label' => 'Media Features'],
        ['value' => '10K+', 'label' => 'Newsletter Subscribers']
    ],
    'image' => 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1200'
]);
?>

<?php
// ── Featured Story ────────────────────────────────────────────
$featured_badge = get_option('apex_featured_badge_about-us-news', 'Featured Story');

// Try: first find a CPT post marked as featured
$fp_query = new WP_Query([
    'post_type'      => 'apex_news',
    'post_status'    => 'publish',
    'posts_per_page' => 1,
    'orderby'        => 'date',
    'order'          => 'DESC',
    'meta_query'     => [['key' => '_apex_news_featured', 'value' => '1']],
]);
// Fallback: latest apex_news post
if (!$fp_query->have_posts()) {
    $fp_query = new WP_Query([
        'post_type'      => 'apex_news',
        'post_status'    => 'publish',
        'posts_per_page' => 1,
        'orderby'        => 'date',
        'order'          => 'DESC',
    ]);
}
?>
<section class="apex-news-featured">
    <div class="apex-news-featured__container">
        <div class="apex-news-featured__header">
            <span class="apex-news-featured__badge"><?php echo esc_html($featured_badge); ?></span>
        </div>

        <?php if ($fp_query->have_posts()) : $fp_query->the_post();
            $fp_id        = get_the_ID();
            $fp_thumb     = get_the_post_thumbnail_url($fp_id, 'large');
            $fp_terms     = get_the_terms($fp_id, 'news_category');
            $fp_category  = ($fp_terms && !is_wp_error($fp_terms)) ? $fp_terms[0]->name : 'News';
            $fp_date      = get_the_date('F j, Y', $fp_id);
            $fp_excerpt   = wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 60);
            $fp_link      = get_permalink($fp_id);
            $fp_ph_hue    = abs(crc32(get_the_title() . $fp_id)) % 360;
        ?>
        <div class="apex-news-featured__card">
            <div class="apex-news-featured__image">
                <?php if ($fp_thumb) : ?>
                    <img src="<?php echo esc_url($fp_thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                <?php else : ?>
                    <div style="width:100%;height:100%;min-height:300px;background:linear-gradient(135deg,hsl(<?php echo $fp_ph_hue; ?>,45%,45%),hsl(<?php echo ($fp_ph_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                        <span style="font-size:64px;font-weight:700;opacity:0.9;"><?php echo esc_html(strtoupper(mb_substr($fp_category, 0, 1))); ?></span>
                        <span style="font-size:15px;opacity:0.7;margin-top:6px;"><?php echo esc_html($fp_category); ?></span>
                    </div>
                <?php endif; ?>
                <span class="apex-news-featured__category"><?php echo esc_html($fp_category); ?></span>
            </div>
            <div class="apex-news-featured__content">
                <span class="apex-news-featured__date"><?php echo esc_html($fp_date); ?></span>
                <h2 class="apex-news-featured__title"><?php echo esc_html(get_the_title()); ?></h2>
                <p class="apex-news-featured__excerpt"><?php echo esc_html($fp_excerpt); ?></p>
                <a href="<?php echo esc_url($fp_link); ?>" class="apex-news-featured__link">
                    Read Full Announcement
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        <?php wp_reset_postdata(); endif; ?>
    </div>
</section>

<?php
// ── Recent News ───────────────────────────────────────────────
$news_heading   = get_option('apex_news_heading_about-us-news', 'Recent News');
$paged          = max(1, intval(get_query_var('paged', 1)));
$posts_per_page = 6;
$selected_cat   = sanitize_key(get_query_var('news_cat', ''));

$query_args = [
    'post_type'      => 'apex_news',
    'post_status'    => 'publish',
    'posts_per_page' => $posts_per_page,
    'paged'          => $paged,
    'orderby'        => 'date',
    'order'          => 'DESC',
];
$news_query = new WP_Query($query_args);

$cat_tabs = [
    'all'      => 'All',
    'product'  => 'Product',
    'company'  => 'Company',
    'industry' => 'Industry',
];
?>
<section class="apex-news-grid">
    <div class="apex-news-grid__container">
        <div class="apex-news-grid__header">
            <h2 class="apex-news-grid__heading"><?php echo esc_html($news_heading); ?></h2>
            <div class="apex-news-grid__filters">
                <?php foreach ($cat_tabs as $slug => $label) : ?>
                <button class="apex-news-grid__filter<?php echo $slug === 'all' ? ' active' : ''; ?>"
                        data-filter="<?php echo esc_attr($slug); ?>">
                    <?php echo esc_html($label); ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>

        <div class="apex-news-grid__items">
            <?php if ($news_query->have_posts()) :
                while ($news_query->have_posts()) : $news_query->the_post();
                    $n_id       = get_the_ID();
                    $n_thumb    = get_the_post_thumbnail_url($n_id, 'medium_large');
                    $n_terms    = get_the_terms($n_id, 'news_category');
                    $n_cat_name = ($n_terms && !is_wp_error($n_terms)) ? $n_terms[0]->name : 'News';
                    $n_ph_hue   = abs(crc32(get_the_title() . $n_id)) % 360;
            ?>
            <article class="apex-news-grid__item" data-category="<?php echo esc_attr($n_terms && !is_wp_error($n_terms) ? $n_terms[0]->slug : 'uncategorized'); ?>">
                <div class="apex-news-grid__item-image" style="position:relative;">
                    <?php if ($n_thumb) : ?>
                        <img src="<?php echo esc_url($n_thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                    <?php else : ?>
                        <div style="width:100%;height:100%;min-height:200px;background:linear-gradient(135deg,hsl(<?php echo $n_ph_hue; ?>,45%,45%),hsl(<?php echo ($n_ph_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                            <span style="font-size:48px;font-weight:700;opacity:0.9;"><?php echo esc_html(strtoupper(mb_substr($n_cat_name, 0, 1))); ?></span>
                            <span style="font-size:13px;opacity:0.7;margin-top:4px;"><?php echo esc_html($n_cat_name); ?></span>
                        </div>
                    <?php endif; ?>
                    <span class="apex-news-grid__item-category" style="position:absolute;top:1rem;left:1rem;padding:0.5rem 1rem;background:#f97316;color:#fff;font-size:0.75rem;font-weight:600;text-transform:uppercase;border-radius:50px;"><?php echo esc_html($n_cat_name); ?></span>
                </div>
                <div class="apex-news-grid__item-content">
                    <span class="apex-news-grid__item-date"><?php echo get_the_date(); ?></span>
                    <h3><?php the_title(); ?></h3>
                    <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                    <a href="<?php the_permalink(); ?>">Read More →</a>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata();
            else : ?>
            <div class="apex-news-grid__no-posts">
                <p>No news items found<?php echo $selected_cat ? ' in this category' : ''; ?>. Check back soon!</p>
            </div>
            <?php endif; ?>
        </div>

        <div class="apex-news-grid__pagination">
            <?php
            $total_pages = $news_query->max_num_pages;
            if ($total_pages > 1) :
                if ($paged > 1) :
                    echo '<a href="' . esc_url(get_pagenum_link($paged - 1)) . '" class="apex-news-grid__page-btn">←</a>';
                endif;

                $show_pages = 4;
                $start_page = max(1, $paged - floor($show_pages / 2));
                $end_page   = min($total_pages, $start_page + $show_pages - 1);

                if ($start_page > 1) {
                    echo '<a href="' . esc_url(get_pagenum_link(1)) . '" class="apex-news-grid__page-btn">1</a>';
                    if ($start_page > 2) echo '<span class="apex-news-grid__page-ellipsis">...</span>';
                }
                for ($i = $start_page; $i <= $end_page; $i++) {
                    if ($i == $paged) {
                        echo '<span class="apex-news-grid__page-btn active">' . $i . '</span>';
                    } else {
                        echo '<a href="' . esc_url(get_pagenum_link($i)) . '" class="apex-news-grid__page-btn">' . $i . '</a>';
                    }
                }
                if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) echo '<span class="apex-news-grid__page-ellipsis">...</span>';
                    echo '<a href="' . esc_url(get_pagenum_link($total_pages)) . '" class="apex-news-grid__page-btn">' . $total_pages . '</a>';
                }
                if ($paged < $total_pages) :
                    echo '<a href="' . esc_url(get_pagenum_link($paged + 1)) . '" class="apex-news-grid__page-btn">→</a>';
                endif;
            endif;
            ?>
        </div>
    </div>
</section>

<?php
$press_heading     = get_option('apex_press_heading_about-us-news', 'In the Press');
$press_description = get_option('apex_press_description_about-us-news', 'What leading publications are saying about Apex Softwares');
$press_items_raw   = get_option('apex_press_items_about-us-news', "TechCrunch | \"Apex Softwares is quietly becoming the Stripe of African banking infrastructure.\" | #\nBloomberg | \"The Kenyan fintech is powering a digital banking revolution across the continent.\" | #\nForbes Africa | \"One of Africa's most promising B2B fintech companies, enabling financial inclusion at scale.\" | #\nQuartz Africa | \"Apex's technology is helping SACCOs and MFIs compete with traditional banks.\" | #");
$press_lines = array_filter(array_map('trim', explode("\n", $press_items_raw)));
?>
<section class="apex-news-press">
    <div class="apex-news-press__container">
        <div class="apex-news-press__header">
            <h2 class="apex-news-press__heading"><?php echo esc_html($press_heading); ?></h2>
            <p class="apex-news-press__description"><?php echo esc_html($press_description); ?></p>
        </div>
        
        <div class="apex-news-press__grid">
            <?php foreach ($press_lines as $line) :
                $parts       = array_map('trim', explode('|', $line));
                $pub_name    = isset($parts[0]) ? $parts[0] : '';
                $quote       = isset($parts[1]) ? $parts[1] : '';
                $article_url = isset($parts[2]) ? $parts[2] : '#';
                if (empty($pub_name)) continue;
            ?>
            <div class="apex-news-press__item">
                <div class="apex-news-press__logo">
                    <span><?php echo esc_html($pub_name); ?></span>
                </div>
                <blockquote><?php echo esc_html(stripslashes($quote)); ?></blockquote>
                <?php if (!empty($article_url) && $article_url !== '#') : ?>
                <a href="<?php echo esc_url($article_url); ?>" target="_blank" rel="noopener noreferrer">Read Article →</a>
                <?php else : ?>
                <a href="#" target="_blank" rel="noopener noreferrer">Read Article →</a>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php
apex_render_newsletter_section([
    'form_id'     => 'news-newsletter-form',
    'heading'     => 'Stay Updated',
    'description' => 'Subscribe to our newsletter for the latest news, product updates, and industry insights delivered to your inbox.',
    'placeholder' => 'Enter your email address',
    'button_text' => 'Subscribe',
    'note'        => 'By subscribing, you agree to our Privacy Policy. Unsubscribe at any time.',
    'source'      => 'Apex Website News Newsletter Form',
    'css_prefix'  => 'apex-news-newsletter',
]);
?>

<section class="apex-news-contact">
    <div class="apex-news-contact__container">
        <div class="apex-news-contact__content">
            <h2 class="apex-news-contact__heading">Media Inquiries</h2>
            <p class="apex-news-contact__description">For press inquiries, interview requests, or media resources, please contact our communications team.</p>
            
            <div class="apex-news-contact__info">
                <div class="apex-news-contact__item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
                    <div>
                        <strong>Email</strong>
                        <a href="mailto:press@apexsoftwares.com">press@apexsoftwares.com</a>
                    </div>
                </div>
                
                <div class="apex-news-contact__item">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                    <div>
                        <strong>Press Kit</strong>
                        <a href="#">Download Media Assets</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>

<script>
jQuery(document).ready(function($) {
    $('.apex-news-grid__filter').on('click', function() {
        var filter = $(this).data('filter');

        $('.apex-news-grid__filter').removeClass('active');
        $(this).addClass('active');

        if (filter === 'all') {
            $('.apex-news-grid__item').show();
        } else {
            $('.apex-news-grid__item').hide();
            $('.apex-news-grid__item[data-category="' + filter + '"]').show();
        }

        var visible = $('.apex-news-grid__item:visible').length;
        var $pagination = $('.apex-news-grid__pagination');
        $pagination.toggle(visible > 0 && filter === 'all');
    });
});
</script>

