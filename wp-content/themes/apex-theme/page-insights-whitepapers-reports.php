<?php
/**
 * Template Name: Insights Whitepapers Reports
 * Whitepapers & Reports Page Template - Dynamic (whitepaper_report CPT)
 *
 * @package ApexTheme
 */

get_header();

// ── Hero ──────────────────────────────────────────────────────────────────────
$hero_stats  = get_option('apex_reports_hero_stats_insights-whitepapers-reports', "30+ | Publications\n15K+ | Downloads\n10+ | Research Partners\n5 | Annual Reports");
$stats_array = [];
foreach (explode("\n", $hero_stats) as $stat_line) {
    $parts = explode(' | ', $stat_line);
    if (count($parts) >= 2) {
        $stats_array[] = ['value' => trim($parts[0]), 'label' => trim($parts[1])];
    }
}

apex_render_about_hero([
    'badge'       => get_option('apex_reports_hero_badge_insights-whitepapers-reports', 'Research & Resources'),
    'heading'     => get_option('apex_reports_hero_heading_insights-whitepapers-reports', 'Whitepapers & Reports'),
    'description' => get_option('apex_reports_hero_description_insights-whitepapers-reports', 'In-depth research, industry analysis, and practical guides to help you make informed decisions about your digital transformation journey.'),
    'stats'       => $stats_array,
    'image'       => get_option('apex_reports_hero_image_insights-whitepapers-reports', 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200'),
]);

// ── Helper: pagination URL ────────────────────────────────────────────────────
if (!function_exists('apex_reports_page_link')) {
    function apex_reports_page_link($page, $base, $params) {
        $p = $params;
        if ($page > 1) {
            $p['paged'] = $page;
        } else {
            unset($p['paged']);
        }
        return $p ? $base . '?' . http_build_query($p) : $base;
    }
}
?>

<!-- ═══════════════════════════════════════════════════════════════════════════
     FEATURED REPORT
════════════════════════════════════════════════════════════════════════════ -->
<section class="apex-reports-featured">
    <div class="apex-reports-featured__container">
        <div class="apex-reports-featured__header">
            <span class="apex-reports-featured__badge"><?php echo esc_html(get_option('apex_reports_featured_badge_insights-whitepapers-reports', 'Featured Report')); ?></span>
        </div>

        <?php
        // 1. Look for explicitly featured publication
        $featured_posts = get_posts([
            'post_type'      => 'whitepaper_report',
            'post_status'    => 'publish',
            'posts_per_page' => 1,
            'meta_key'       => '_report_is_featured',
            'meta_value'     => '1',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ]);

        // 2. Fallback: most recent publication
        if (empty($featured_posts)) {
            $featured_posts = get_posts([
                'post_type'      => 'whitepaper_report',
                'post_status'    => 'publish',
                'posts_per_page' => 1,
                'orderby'        => 'date',
                'order'          => 'DESC',
            ]);
        }

        if (!empty($featured_posts)) :
            $fr            = $featured_posts[0];
            $fr_thumb      = get_the_post_thumbnail_url($fr->ID, 'large');
            $fr_terms      = get_the_terms($fr->ID, 'report_category');
            $fr_category   = ($fr_terms && !is_wp_error($fr_terms)) ? $fr_terms[0]->name : 'Report';
            $fr_pub_date   = get_post_meta($fr->ID, '_report_publish_date', true);
            $fr_date_label = $fr_pub_date ? date('F Y', strtotime($fr_pub_date)) : get_the_date('F Y', $fr->ID);
            $fr_pages      = get_post_meta($fr->ID, '_report_pages', true);
            $fr_format     = get_post_meta($fr->ID, '_report_format', true) ?: 'PDF';
            $fr_dl_url     = get_post_meta($fr->ID, '_report_download_url', true) ?: '#';
            $fr_findings   = get_post_meta($fr->ID, '_report_key_findings', true);
            $fr_excerpt    = wp_trim_words($fr->post_excerpt ?: wp_strip_all_tags($fr->post_content), 40);
        ?>
        <div class="apex-reports-featured__card">
            <div class="apex-reports-featured__image">
                <?php if ($fr_thumb) : ?>
                    <img src="<?php echo esc_url($fr_thumb); ?>" alt="<?php echo esc_attr($fr->post_title); ?>" loading="lazy">
                <?php else :
                    $fr_hue = abs(crc32($fr->post_title . $fr->ID)) % 360;
                ?>
                    <div style="width:100%;height:100%;min-height:300px;background:linear-gradient(135deg,hsl(<?php echo $fr_hue; ?>,45%,45%),hsl(<?php echo ($fr_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                        <span style="font-size:64px;font-weight:700;opacity:0.9;"><?php echo esc_html(strtoupper(mb_substr($fr_category, 0, 1))); ?></span>
                        <span style="font-size:15px;opacity:0.7;margin-top:6px;"><?php echo esc_html($fr_category); ?></span>
                    </div>
                <?php endif; ?>
                <span class="apex-reports-featured__type"><?php echo esc_html($fr_category); ?></span>
            </div>

            <div class="apex-reports-featured__content">
                <span class="apex-reports-featured__date"><?php echo esc_html($fr_date_label); ?></span>
                <h2 class="apex-reports-featured__title"><?php echo esc_html($fr->post_title); ?></h2>
                <p class="apex-reports-featured__excerpt"><?php echo esc_html($fr_excerpt); ?></p>

                <?php if ($fr_findings) : ?>
                <div class="apex-reports-featured__highlights">
                    <h4>Key Findings:</h4>
                    <ul>
                        <?php foreach (explode("\n", $fr_findings) as $finding) :
                            if (trim($finding)) : ?>
                            <li><?php echo esc_html(trim($finding)); ?></li>
                        <?php endif; endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="apex-reports-featured__meta">
                    <?php if ($fr_pages) : ?>
                    <span><strong>Pages:</strong> <?php echo esc_html($fr_pages); ?></span>
                    <?php endif; ?>
                    <span><strong>Format:</strong> <?php echo esc_html($fr_format); ?></span>
                </div>

                <a href="<?php echo esc_url($fr_dl_url); ?>" class="apex-reports-featured__cta" target="_blank" rel="noopener noreferrer">
                    Download Free Report
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                </a>
            </div>
        </div>

        <?php else : ?>
        <div class="apex-reports-featured__card" style="padding:2rem;text-align:center;color:#888;">
            <p>No publications yet.
            <?php if (current_user_can('edit_posts')) : ?>
                <a href="<?php echo esc_url(admin_url('post-new.php?post_type=whitepaper_report')); ?>">Add your first publication</a> and check "Feature this publication".
            <?php endif; ?>
            </p>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     BROWSE BY CATEGORY
════════════════════════════════════════════════════════════════════════════ -->
<section class="apex-reports-categories">
    <div class="apex-reports-categories__container">
        <h2 class="apex-reports-categories__heading"><?php echo esc_html(get_option('apex_reports_categories_heading_insights-whitepapers-reports', 'Browse by Category')); ?></h2>
        <div class="apex-reports-categories__grid">
            <?php
            $cat_icons = [
                'industry-reports'      => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>',
                'whitepapers'           => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>',
                'implementation-guides' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
                'benchmark-studies'     => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>',
            ];
            $default_cat_icon = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>';

            $report_terms = get_terms([
                'taxonomy'   => 'report_category',
                'hide_empty' => false,
                'orderby'    => 'name',
                'order'      => 'ASC',
            ]);

            if ($report_terms && !is_wp_error($report_terms)) :
                foreach ($report_terms as $term) :
                    $icon        = isset($cat_icons[$term->slug]) ? $cat_icons[$term->slug] : $default_cat_icon;
                    $count_label = $term->count . ' ' . ($term->count === 1 ? 'publication' : 'publications');
                    $cat_url     = home_url('/insights/whitepapers-reports') . '?report_cat=' . urlencode($term->slug);
                    ?>
                    <a href="<?php echo esc_url($cat_url); ?>" class="apex-reports-categories__item" data-category="<?php echo esc_attr($term->slug); ?>">
                        <?php echo $icon; ?>
                        <span><?php echo esc_html($term->name); ?></span>
                        <small><?php echo esc_html($count_label); ?></small>
                    </a>
                <?php endforeach;
            endif; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     ALL PUBLICATIONS
════════════════════════════════════════════════════════════════════════════ -->
<section class="apex-reports-grid">
    <div class="apex-reports-grid__container">
        <?php
        // ── Query params ──────────────────────────────────────────────────────
        $current_sort = isset($_GET['sort'])       ? sanitize_key($_GET['sort'])       : 'newest';
        $current_cat  = isset($_GET['report_cat']) ? sanitize_key($_GET['report_cat']) : '';

        // Pagination: respect WordPress /page/N/ rewrites AND ?paged= GET param
        $paged = max(1, intval(get_query_var('paged', 1)));
        if ($paged === 1 && !empty($_GET['paged'])) {
            $paged = max(1, intval($_GET['paged']));
        }

        $posts_per_page = 8;
        $base_url       = home_url('/insights/whitepapers-reports');

        // Build URL params that persist across page links (excludes paged itself)
        $url_params = [];
        if ($current_sort && $current_sort !== 'newest') {
            $url_params['sort'] = $current_sort;
        }
        if ($current_cat) {
            $url_params['report_cat'] = $current_cat;
        }

        // ── Orderby args ──────────────────────────────────────────────────────
        switch ($current_sort) {
            case 'popular':
                $orderby_args = ['meta_key' => '_report_download_count', 'orderby' => 'meta_value_num', 'order' => 'DESC'];
                break;
            case 'title':
                $orderby_args = ['orderby' => 'title', 'order' => 'ASC'];
                break;
            default:
                $orderby_args = ['orderby' => 'date', 'order' => 'DESC'];
        }

        // ── Tax query ─────────────────────────────────────────────────────────
        $tax_query_args = [];
        if ($current_cat) {
            $tax_query_args[] = [
                'taxonomy' => 'report_category',
                'field'    => 'slug',
                'terms'    => $current_cat,
            ];
        }

        $query_args = array_merge([
            'post_type'           => 'whitepaper_report',
            'post_status'         => 'publish',
            'posts_per_page'      => $posts_per_page,
            'paged'               => $paged,
            'ignore_sticky_posts' => true,
        ], $orderby_args);

        if (!empty($tax_query_args)) {
            $query_args['tax_query'] = $tax_query_args;
        }

        $reports_query = new WP_Query($query_args);
        ?>

        <div class="apex-reports-grid__header">
            <h2 class="apex-reports-grid__heading">
                All Publications
                <?php if ($current_cat) :
                    $active_term = get_term_by('slug', $current_cat, 'report_category');
                    if ($active_term) : ?>
                        <span style="font-size:0.75em;font-weight:400;color:#f97316;"> &mdash; <?php echo esc_html($active_term->name); ?></span>
                    <?php endif;
                endif; ?>
            </h2>

            <div class="apex-reports-grid__sort" style="display:flex;align-items:center;gap:0.75rem;flex-wrap:wrap;">
                <label for="reports-sort-select" style="font-weight:500;white-space:nowrap;">Sort by:</label>
                <select id="reports-sort-select" onchange="window.location.href=this.value" style="padding:0.4rem 0.75rem;border:1px solid #e2e8f0;border-radius:6px;cursor:pointer;">
                    <?php
                    $sort_options = [
                        'newest'  => 'Newest First',
                        'popular' => 'Most Popular',
                        'title'   => 'Title A–Z',
                    ];
                    foreach ($sort_options as $val => $label) :
                        // Build URL for this sort option, reset paged
                        $s_params = $url_params;
                        if ($val === 'newest') {
                            unset($s_params['sort']);
                        } else {
                            $s_params['sort'] = $val;
                        }
                        unset($s_params['paged']);
                        $s_url = $s_params ? $base_url . '?' . http_build_query($s_params) : $base_url;
                        ?>
                        <option value="<?php echo esc_url($s_url); ?>" <?php selected($current_sort, $val); ?>>
                            <?php echo esc_html($label); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <?php if ($current_cat) :
                    $clear_params = $url_params;
                    unset($clear_params['report_cat'], $clear_params['paged']);
                    $clear_url = $clear_params ? $base_url . '?' . http_build_query($clear_params) : $base_url;
                ?>
                    <a href="<?php echo esc_url($clear_url); ?>" style="font-size:0.875rem;color:#f97316;text-decoration:none;white-space:nowrap;">&times; Clear filter</a>
                <?php endif; ?>
            </div>
        </div>

        <div class="apex-reports-grid__items">
            <?php if ($reports_query->have_posts()) :
                while ($reports_query->have_posts()) : $reports_query->the_post();
                    $r_id       = get_the_ID();
                    $r_thumb    = get_the_post_thumbnail_url($r_id, 'medium');
                    $r_terms    = get_the_terms($r_id, 'report_category');
                    $r_cat_name = ($r_terms && !is_wp_error($r_terms)) ? $r_terms[0]->name : 'Publication';
                    $r_cat_slug = ($r_terms && !is_wp_error($r_terms)) ? $r_terms[0]->slug : '';
                    $r_pub_date = get_post_meta($r_id, '_report_publish_date', true);
                    $r_date_lbl = $r_pub_date ? date('F Y', strtotime($r_pub_date)) : get_the_date('F Y');
                    $r_pages    = get_post_meta($r_id, '_report_pages', true);
                    $r_dl_count = get_post_meta($r_id, '_report_download_count', true);
                    $r_dl_url   = get_post_meta($r_id, '_report_download_url', true) ?: '#';
                    $r_excerpt  = wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 20);
                    $r_hue      = abs(crc32(get_the_title() . $r_id)) % 360;
            ?>
                <article class="apex-reports-grid__item" data-category="<?php echo esc_attr($r_cat_slug); ?>">
                    <div class="apex-reports-grid__item-cover">
                        <?php if ($r_thumb) : ?>
                            <img src="<?php echo esc_url($r_thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                        <?php else : ?>
                            <div style="width:100%;height:100%;min-height:180px;background:linear-gradient(135deg,hsl(<?php echo $r_hue; ?>,45%,45%),hsl(<?php echo ($r_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                                <span style="font-size:40px;font-weight:700;opacity:0.9;"><?php echo esc_html(strtoupper(mb_substr($r_cat_name, 0, 1))); ?></span>
                                <span style="font-size:12px;opacity:0.7;margin-top:4px;"><?php echo esc_html($r_cat_name); ?></span>
                            </div>
                        <?php endif; ?>
                        <span class="apex-reports-grid__item-type"><?php echo esc_html($r_cat_name); ?></span>
                    </div>
                    <div class="apex-reports-grid__item-content">
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo esc_html($r_excerpt); ?></p>
                        <div class="apex-reports-grid__item-meta">
                            <span><?php echo esc_html($r_date_lbl); ?></span>
                            <?php if ($r_pages) : ?>
                                <span><?php echo esc_html($r_pages); ?> pages</span>
                            <?php endif; ?>
                            <?php if ($r_dl_count) : ?>
                                <span><?php echo number_format(intval($r_dl_count)); ?> downloads</span>
                            <?php endif; ?>
                        </div>
                        <a href="<?php echo esc_url($r_dl_url); ?>" class="apex-reports-grid__item-download" target="_blank" rel="noopener noreferrer">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                            Download PDF
                        </a>
                    </div>
                </article>
            <?php endwhile;
                wp_reset_postdata();
            else : ?>
                <div class="apex-reports-grid__no-posts" style="grid-column:1/-1;padding:3rem 1rem;text-align:center;color:#888;">
                    <p>No publications found<?php echo $current_cat ? ' in this category' : ''; ?>.
                    <?php if (current_user_can('edit_posts')) : ?>
                        <a href="<?php echo esc_url(admin_url('post-new.php?post_type=whitepaper_report')); ?>">Add a publication →</a>
                    <?php endif; ?>
                    </p>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="apex-reports-grid__pagination">
            <?php
            $total_pages = $reports_query->max_num_pages;

            if ($total_pages > 1) :
                if ($paged > 1) : ?>
                    <a href="<?php echo esc_url(apex_reports_page_link($paged - 1, $base_url, $url_params)); ?>" class="apex-reports-grid__page-btn">←</a>
                <?php endif;

                $show_pages = 4;
                $start_page = max(1, $paged - (int)floor($show_pages / 2));
                $end_page   = min($total_pages, $start_page + $show_pages - 1);

                if ($start_page > 1) : ?>
                    <a href="<?php echo esc_url(apex_reports_page_link(1, $base_url, $url_params)); ?>" class="apex-reports-grid__page-btn">1</a>
                    <?php if ($start_page > 2) : ?><span class="apex-reports-grid__page-ellipsis">…</span><?php endif; ?>
                <?php endif;

                for ($i = $start_page; $i <= $end_page; $i++) :
                    if ($i === $paged) : ?>
                        <button class="apex-reports-grid__page-btn active"><?php echo $i; ?></button>
                    <?php else : ?>
                        <a href="<?php echo esc_url(apex_reports_page_link($i, $base_url, $url_params)); ?>" class="apex-reports-grid__page-btn"><?php echo $i; ?></a>
                    <?php endif;
                endfor;

                if ($end_page < $total_pages) :
                    if ($end_page < $total_pages - 1) : ?><span class="apex-reports-grid__page-ellipsis">…</span><?php endif; ?>
                    <a href="<?php echo esc_url(apex_reports_page_link($total_pages, $base_url, $url_params)); ?>" class="apex-reports-grid__page-btn"><?php echo $total_pages; ?></a>
                <?php endif;

                if ($paged < $total_pages) : ?>
                    <a href="<?php echo esc_url(apex_reports_page_link($paged + 1, $base_url, $url_params)); ?>" class="apex-reports-grid__page-btn">→</a>
                <?php endif;
            endif; ?>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════════════════
     CUSTOM RESEARCH
════════════════════════════════════════════════════════════════════════════ -->
<section class="apex-reports-custom">
    <div class="apex-reports-custom__container">
        <div class="apex-reports-custom__content">
            <span class="apex-reports-custom__badge"><?php echo esc_html(get_option('apex_reports_custom_badge_insights-whitepapers-reports', 'Custom Research')); ?></span>
            <h2 class="apex-reports-custom__heading"><?php echo esc_html(get_option('apex_reports_custom_heading_insights-whitepapers-reports', 'Need Custom Research?')); ?></h2>
            <p class="apex-reports-custom__description"><?php echo esc_html(get_option('apex_reports_custom_description_insights-whitepapers-reports', 'Our research team can conduct custom studies tailored to your specific needs, including market analysis, competitive benchmarking, and feasibility studies.')); ?></p>

            <div class="apex-reports-custom__services">
                <?php
                $cr_services = get_option(
                    'apex_reports_custom_services_insights-whitepapers-reports',
                    "Market Analysis | Deep-dive into specific markets or segments\n" .
                    "Competitive Benchmarking | Compare your performance against peers\n" .
                    "Feasibility Studies | Assess viability of new initiatives"
                );
                $cr_icons = [
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>',
                ];
                $cr_idx = 0;
                foreach (explode("\n", $cr_services) as $cr_line) {
                    $cr_parts = explode(' | ', $cr_line, 2);
                    if (count($cr_parts) === 2) :
                        $cr_icon = isset($cr_icons[$cr_idx]) ? $cr_icons[$cr_idx] : $cr_icons[0];
                        ?>
                        <div class="apex-reports-custom__service">
                            <?php echo $cr_icon; ?>
                            <div>
                                <strong><?php echo esc_html(trim($cr_parts[0])); ?></strong>
                                <span><?php echo esc_html(trim($cr_parts[1])); ?></span>
                            </div>
                        </div>
                        <?php
                        $cr_idx++;
                    endif;
                }
                ?>
            </div>

            <a href="<?php echo esc_url(get_option('apex_reports_custom_link_insights-whitepapers-reports', home_url('/contact'))); ?>" class="apex-reports-custom__cta">Request Custom Research</a>
        </div>
        <div class="apex-reports-custom__image">
            <img src="<?php echo esc_url(get_option('apex_reports_custom_image_insights-whitepapers-reports', 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=500')); ?>" alt="Research Team" loading="lazy">
        </div>
    </div>
</section>

<?php
apex_render_newsletter_section([
    'form_id'     => 'reports-newsletter-form',
    'heading'     => get_option('apex_reports_newsletter_heading_insights-whitepapers-reports', 'Get New Reports First'),
    'description' => get_option('apex_reports_newsletter_description_insights-whitepapers-reports', 'Subscribe to be notified when we publish new research, whitepapers, and industry reports.'),
    'placeholder' => get_option('apex_reports_newsletter_placeholder_insights-whitepapers-reports', 'Enter your email address'),
    'button_text' => get_option('apex_reports_newsletter_button_insights-whitepapers-reports', 'Subscribe'),
    'note'        => get_option('apex_reports_newsletter_note_insights-whitepapers-reports', 'Join 5,000+ subscribers. We respect your privacy.'),
    'source'      => 'Apex Website Whitepapers & Reports Newsletter Form',
    'css_prefix'  => 'apex-blog-newsletter',
]);
?>

<?php get_footer(); ?>
