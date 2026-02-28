<?php 
/**
 * Template Name: Insights Success Stories
 * Success Stories / Case Studies Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Initialize filter variables
$industry_filter = isset($_GET['industry']) ? sanitize_text_field($_GET['industry']) : 'all';
$region_filter = isset($_GET['region']) ? sanitize_text_field($_GET['region']) : 'all';
$solution_filter = isset($_GET['solution']) ? sanitize_text_field($_GET['solution']) : 'all';

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_stories_hero_stats_insights-success-stories', "100+ | Success Stories\n15+ | Countries\n40% | Avg. Cost Reduction\n3x | Customer Growth");
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
    'badge' => get_option('apex_stories_hero_badge_insights-success-stories', 'Success Stories'),
    'heading' => get_option('apex_stories_hero_heading_insights-success-stories', 'Real Results, Real Impact'),
    'description' => get_option('apex_stories_hero_description_insights-success-stories', 'Discover how financial institutions across Africa are transforming their operations, reaching more customers, and driving growth with Apex Softwares solutions.'),
    'stats' => $stats_array,
    'image' => get_option('apex_stories_hero_image_insights-success-stories', 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200')
]);
?>

<section class="apex-stories-featured">
    <div class="apex-stories-featured__container">
        <div class="apex-stories-featured__header">
            <span class="apex-stories-featured__badge"><?php echo esc_html(get_option('apex_stories_featured_badge_insights-success-stories', 'Featured Story')); ?></span>
        </div>
        
        <?php
        // Dynamic Featured Success Story from selected post ID
        $featured_story_id = intval(get_option('apex_stories_featured_story_id_insights-success-stories', 0));
        $featured_story = $featured_story_id ? get_post($featured_story_id) : null;

        if ($featured_story && $featured_story->post_status === 'publish') :
            $fs_thumb = get_the_post_thumbnail_url($featured_story_id, 'large');
            $fs_cats = get_the_terms($featured_story_id, 'success_story_category');
            $fs_category = $fs_cats ? $fs_cats[0]->name : 'Success Story';
            $fs_date = get_the_date('F j, Y', $featured_story_id);
            $fs_wc = str_word_count(wp_strip_all_tags($featured_story->post_content));
            $fs_readtime = max(1, ceil($fs_wc / 200)) . ' min read';
            $fs_excerpt = wp_trim_words($featured_story->post_excerpt ?: wp_strip_all_tags($featured_story->post_content), 30);
            $fs_author_name = get_the_author_meta('display_name', $featured_story->post_author);
            $fs_author_avatar = get_avatar_url($featured_story->post_author, ['size' => 100]);
            $fs_link = get_permalink($featured_story_id);
        ?>
        <?php
            $fs_client = get_post_meta($featured_story_id, '_success_story_client_partner', true);
            $fs_stats_raw = get_post_meta($featured_story_id, '_success_story_stats', true);
            $fs_stats = [];
            if ($fs_stats_raw) {
                foreach (explode("\n", $fs_stats_raw) as $stat_line) {
                    $parts = explode('|', $stat_line);
                    if (count($parts) >= 2) {
                        $fs_stats[] = ['value' => trim($parts[0]), 'label' => trim($parts[1])];
                    }
                }
            }
        ?>
        <div class="apex-stories-featured__card">
            <div class="apex-stories-featured__image" style="position: relative;">
                <?php if ($fs_thumb) : ?>
                    <img src="<?php echo esc_url($fs_thumb); ?>" alt="<?php echo esc_attr($featured_story->post_title); ?>" loading="lazy">
                <?php else :
                    $fs_ph_hue = abs(crc32($featured_story->post_title . $featured_story_id)) % 360;
                ?>
                    <div style="width:100%;height:100%;min-height:300px;background:linear-gradient(135deg,hsl(<?php echo $fs_ph_hue; ?>,45%,45%),hsl(<?php echo ($fs_ph_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                        <span style="font-size:64px;font-weight:700;opacity:0.9;"><?php echo esc_html(strtoupper(mb_substr($fs_category, 0, 1))); ?></span>
                        <span style="font-size:15px;opacity:0.7;margin-top:6px;"><?php echo esc_html($fs_category); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($fs_client) : ?>
                    <span style="position:absolute;bottom:1rem;left:1rem;background:rgba(255,255,255,0.95);color:#1e293b;padding:0.4rem 1rem;border-radius:6px;font-size:0.85rem;font-weight:600;backdrop-filter:blur(4px);"><?php echo esc_html($fs_client); ?></span>
                <?php endif; ?>
            </div>
            <div class="apex-stories-featured__content">
                <span class="apex-stories-featured__category" style="display:inline-block;margin-bottom:1rem;"><?php echo esc_html($fs_category); ?></span>
                <h2 class="apex-stories-featured__title"><?php echo esc_html($featured_story->post_title); ?></h2>
                <p class="apex-stories-featured__excerpt"><?php echo esc_html($fs_excerpt); ?></p>
                <?php if (!empty($fs_stats)) : ?>
                <div class="apex-stories-featured__stats" style="display:flex;gap:1rem;margin:1.5rem 0;">
                    <?php foreach ($fs_stats as $stat) : ?>
                    <div style="flex:1;text-align:center;padding:0.75rem;border:1px solid #e2e8f0;border-radius:8px;">
                        <strong style="display:block;font-size:1.25rem;color:#f97316;"><?php echo esc_html($stat['value']); ?></strong>
                        <span style="font-size:0.75rem;color:#64748b;"><?php echo esc_html($stat['label']); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <a href="<?php echo esc_url($fs_link); ?>" class="apex-stories-featured__link">
                    Read Full Case Study
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        <?php else :
            // Fallback: show the latest published success story if no featured story is selected
            $latest = get_posts(['post_type' => 'success_story', 'post_status' => 'publish', 'posts_per_page' => 1, 'orderby' => 'date', 'order' => 'DESC']);
            if ($latest) :
                $ls = $latest[0];
                $ls_thumb = get_the_post_thumbnail_url($ls->ID, 'large');
                $ls_cats = get_the_terms($ls->ID, 'success_story_category');
                $ls_category = $ls_cats ? $ls_cats[0]->name : 'Success Story';
                $ls_excerpt = wp_trim_words($ls->post_excerpt ?: wp_strip_all_tags($ls->post_content), 30);
                $ls_link = get_permalink($ls->ID);
                $ls_client = get_post_meta($ls->ID, '_success_story_client_partner', true);
                $ls_stats_raw = get_post_meta($ls->ID, '_success_story_stats', true);
                $ls_stats = [];
                if ($ls_stats_raw) {
                    foreach (explode("\n", $ls_stats_raw) as $stat_line) {
                        $parts = explode('|', $stat_line);
                        if (count($parts) >= 2) {
                            $ls_stats[] = ['value' => trim($parts[0]), 'label' => trim($parts[1])];
                        }
                    }
                }
        ?>
        <div class="apex-stories-featured__card">
            <div class="apex-stories-featured__image" style="position: relative;">
                <?php if ($ls_thumb) : ?>
                    <img src="<?php echo esc_url($ls_thumb); ?>" alt="<?php echo esc_attr($ls->post_title); ?>" loading="lazy">
                <?php else :
                    $ls_ph_hue = abs(crc32($ls->post_title . $ls->ID)) % 360;
                ?>
                    <div style="width:100%;height:100%;min-height:300px;background:linear-gradient(135deg,hsl(<?php echo $ls_ph_hue; ?>,45%,45%),hsl(<?php echo ($ls_ph_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                        <span style="font-size:64px;font-weight:700;opacity:0.9;"><?php echo esc_html(strtoupper(mb_substr($ls_category, 0, 1))); ?></span>
                        <span style="font-size:15px;opacity:0.7;margin-top:6px;"><?php echo esc_html($ls_category); ?></span>
                    </div>
                <?php endif; ?>
                <?php if ($ls_client) : ?>
                    <span style="position:absolute;bottom:1rem;left:1rem;background:rgba(255,255,255,0.95);color:#1e293b;padding:0.4rem 1rem;border-radius:6px;font-size:0.85rem;font-weight:600;backdrop-filter:blur(4px);"><?php echo esc_html($ls_client); ?></span>
                <?php endif; ?>
            </div>
            <div class="apex-stories-featured__content">
                <span class="apex-stories-featured__category" style="display:inline-block;margin-bottom:1rem;"><?php echo esc_html($ls_category); ?></span>
                <h2 class="apex-stories-featured__title"><?php echo esc_html($ls->post_title); ?></h2>
                <p class="apex-stories-featured__excerpt"><?php echo esc_html($ls_excerpt); ?></p>
                <?php if (!empty($ls_stats)) : ?>
                <div class="apex-stories-featured__stats" style="display:flex;gap:1rem;margin:1.5rem 0;">
                    <?php foreach ($ls_stats as $stat) : ?>
                    <div style="flex:1;text-align:center;padding:0.75rem;border:1px solid #e2e8f0;border-radius:8px;">
                        <strong style="display:block;font-size:1.25rem;color:#f97316;"><?php echo esc_html($stat['value']); ?></strong>
                        <span style="font-size:0.75rem;color:#64748b;"><?php echo esc_html($stat['label']); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                <a href="<?php echo esc_url($ls_link); ?>" class="apex-stories-featured__link">
                    Read Full Case Study
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
</section>

<section class="apex-stories-filters">
    <div class="apex-stories-filters__container">
        <div class="apex-stories-filters__group">
            <label>Industry</label>
            <select id="industry-filter">
                <option value="all" <?php selected($industry_filter, 'all'); ?>>All Industries</option>
                <?php
                $industries = get_terms(['taxonomy' => 'success_story_industry', 'hide_empty' => true]);
                if ($industries && !is_wp_error($industries)) {
                    foreach ($industries as $industry) {
                        echo '<option value="' . esc_attr($industry->slug) . '" ' . selected($industry_filter, $industry->slug, false) . '>' . esc_html($industry->name) . '</option>';
                    }
                } else {
                    // Hardcoded fallback options
                    $hardcoded_industries = ['Commercial Banks', 'Microfinance', 'SACCOs', 'Credit Unions', 'Fintechs', 'Insurance'];
                    foreach ($hardcoded_industries as $industry) {
                        $slug = sanitize_title($industry);
                        echo '<option value="' . esc_attr($slug) . '" ' . selected($industry_filter, $slug, false) . '>' . esc_html($industry) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="apex-stories-filters__group">
            <label>Region</label>
            <select id="region-filter">
                <option value="all" <?php selected($region_filter, 'all'); ?>>All Regions</option>
                <?php
                $regions = get_terms(['taxonomy' => 'success_story_region', 'hide_empty' => true]);
                if ($regions && !is_wp_error($regions)) {
                    foreach ($regions as $region) {
                        echo '<option value="' . esc_attr($region->slug) . '" ' . selected($region_filter, $region->slug, false) . '>' . esc_html($region->name) . '</option>';
                    }
                } else {
                    // Hardcoded fallback options
                    $hardcoded_regions = ['East Africa', 'West Africa', 'Southern Africa', 'North Africa', 'Central Africa'];
                    foreach ($hardcoded_regions as $region) {
                        $slug = sanitize_title($region);
                        echo '<option value="' . esc_attr($slug) . '" ' . selected($region_filter, $slug, false) . '>' . esc_html($region) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
        <div class="apex-stories-filters__group">
            <label>Solution</label>
            <select id="solution-filter">
                <option value="all" <?php selected($solution_filter, 'all'); ?>>All Solutions</option>
                <?php
                $solutions = get_terms(['taxonomy' => 'success_story_solution', 'hide_empty' => true]);
                if ($solutions && !is_wp_error($solutions)) {
                    foreach ($solutions as $solution) {
                        echo '<option value="' . esc_attr($solution->slug) . '" ' . selected($solution_filter, $solution->slug, false) . '>' . esc_html($solution->name) . '</option>';
                    }
                } else {
                    // Hardcoded fallback options
                    $hardcoded_solutions = ['Core Banking', 'Mobile Banking', 'Agent Banking', 'Digital Lending', 'Digital Payments', 'Microfinance Software'];
                    foreach ($hardcoded_solutions as $solution) {
                        $slug = sanitize_title($solution);
                        echo '<option value="' . esc_attr($slug) . '" ' . selected($solution_filter, $slug, false) . '>' . esc_html($solution) . '</option>';
                    }
                }
                ?>
            </select>
        </div>
    </div>
</section>

<section class="apex-stories-grid">
    <div class="apex-stories-grid__container">
        <div class="apex-stories-grid__items">
            <?php
            // Pagination setup - paged is set by apex_insights_template_redirect in functions.php
            $paged = max(1, intval(get_query_var('paged', 1)));
            
            $posts_per_page = 6;
            
            // Get filter values from URL parameters
            $industry_filter = isset($_GET['industry']) ? sanitize_text_field($_GET['industry']) : 'all';
            $region_filter = isset($_GET['region']) ? sanitize_text_field($_GET['region']) : 'all';
            $solution_filter = isset($_GET['solution']) ? sanitize_text_field($_GET['solution']) : 'all';
            
            // Build taxonomy query
            $tax_query = [];
            
            if ($industry_filter !== 'all') {
                $tax_query[] = [
                    'taxonomy' => 'success_story_industry',
                    'field' => 'slug',
                    'terms' => $industry_filter,
                ];
            }
            
            if ($region_filter !== 'all') {
                $tax_query[] = [
                    'taxonomy' => 'success_story_region',
                    'field' => 'slug',
                    'terms' => $region_filter,
                ];
            }
            
            if ($solution_filter !== 'all') {
                $tax_query[] = [
                    'taxonomy' => 'success_story_solution',
                    'field' => 'slug',
                    'terms' => $solution_filter,
                ];
            }
            
            // WordPress query with proper pagination and taxonomy filtering
            $args = array(
                'post_type' => 'success_story',
                'post_status' => 'publish',
                'posts_per_page' => $posts_per_page,
                'paged' => $paged,
                'orderby' => 'date',
                'order' => 'DESC',
                'ignore_sticky_posts' => true
            );
            
            // Add taxonomy query if filters are applied
            if (!empty($tax_query)) {
                $args['tax_query'] = array_merge(['relation' => 'AND'], $tax_query);
            }
            
            $stories_query = new WP_Query($args);
            
            if ($stories_query->have_posts()) :
                $index = 0;
                while ($stories_query->have_posts()) : $stories_query->the_post();
            ?>
                <article class="apex-stories-grid__item">
                    <div class="apex-stories-grid__item-image" style="position: relative;">
                        <?php
                        $st_cats = get_the_terms(get_the_ID(), 'success_story_category');
                        $st_cat_name = $st_cats ? $st_cats[0]->name : 'Success Story';
                        ?>
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium_large', ['class' => '', 'loading' => 'lazy']); ?>
                            <span class="apex-stories-grid__item-tag" style="position: absolute; top: 1rem; left: 1rem; padding: 0.5rem 1rem; background: #f97316; color: #ffffff; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; border-radius: 50px;"><?php echo esc_html($st_cat_name); ?></span>
                        <?php else : ?>
                            <?php
                            $st_hash = crc32(get_the_title() . get_the_ID());
                            $st_hue = abs($st_hash) % 360;
                            $st_initial = strtoupper(mb_substr($st_cat_name, 0, 1));
                            ?>
                            <div style="width:100%;height:100%;min-height:200px;background:linear-gradient(135deg,hsl(<?php echo $st_hue; ?>,45%,45%),hsl(<?php echo ($st_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                                <span style="font-size:48px;font-weight:700;opacity:0.9;"><?php echo esc_html($st_initial); ?></span>
                                <span style="font-size:13px;opacity:0.7;margin-top:4px;"><?php echo esc_html($st_cat_name); ?></span>
                            </div>
                            <span class="apex-stories-grid__item-tag" style="position: absolute; top: 1rem; left: 1rem; padding: 0.5rem 1rem; background: #f97316; color: #ffffff; font-size: 0.75rem; font-weight: 600; text-transform: uppercase; border-radius: 50px;"><?php echo esc_html($st_cat_name); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="apex-stories-grid__item-content">
                        <div class="apex-stories-grid__item-header">
                            <?php
                            $client_partner = get_post_meta(get_the_ID(), '_success_story_client_partner', true);
                            $region_terms = get_the_terms(get_the_ID(), 'success_story_region');
                            $region_name = ($region_terms && !is_wp_error($region_terms)) ? $region_terms[0]->name : '';
                            ?>
                            <span class="apex-stories-grid__item-company"><?php echo $client_partner ? esc_html($client_partner) : 'N/A'; ?></span>
                            <span class="apex-stories-grid__item-location"><?php echo $region_name ? esc_html($region_name) : 'N/A'; ?></span>
                        </div>
                        <h3><?php the_title(); ?></h3>
                        <p><?php echo wp_trim_words(get_the_excerpt(), 20); ?></p>
                        <div class="apex-stories-grid__item-stats">
                            <div>
                                <strong><?php echo reading_time(); ?></strong>
                                <span>min read</span>
                            </div>
                            <div>
                                <strong><?php echo get_the_date('M j'); ?></strong>
                                <span><?php echo get_the_date('Y'); ?></span>
                            </div>
                        </div>
                        <a href="<?php the_permalink(); ?>">Read Story →</a>
                    </div>
                </article>
            <?php
                $index++;
                endwhile;
                wp_reset_postdata();
            else :
            ?>
                <div class="apex-stories-grid__no-posts">
                    <p>No success stories found. Check back soon for new content!</p>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="apex-blog-grid__pagination">
            <?php
            // Dynamic pagination
            $total_pages = $stories_query->max_num_pages;
            
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

<section class="apex-stories-testimonials">
    <div class="apex-stories-testimonials__container">
        <div class="apex-stories-testimonials__header">
            <span class="apex-stories-testimonials__badge"><?php echo esc_html(get_option('apex_stories_testimonials_badge_insights-success-stories', 'Client Voices')); ?></span>
            <h2 class="apex-stories-testimonials__heading"><?php echo esc_html(get_option('apex_stories_testimonials_heading_insights-success-stories', 'What Our Clients Say')); ?></h2>
            <p class="apex-stories-testimonials__description"><?php echo esc_html(get_option('apex_stories_testimonials_description_insights-success-stories', 'Real stories from real clients about their transformative journey with our solutions.')); ?></p>
        </div>
        
        <?php
        $testimonials_raw = get_option('apex_stories_testimonials_items_insights-success-stories', '');
        $testimonials = [];
        if ($testimonials_raw) {
            foreach (explode("\n", $testimonials_raw) as $line) {
                $parts = explode('|', $line);
                if (count($parts) >= 5) {
                    $testimonials[] = [
                        'name' => trim($parts[0]),
                        'role' => trim($parts[1]),
                        'company' => trim($parts[2]),
                        'quote' => trim($parts[3]),
                        'image' => trim($parts[4])
                    ];
                }
            }
        }
        
        // Use default testimonials if none are set
        if (empty($testimonials)) {
            $testimonials = [
                [
                    'name' => 'David Okello',
                    'role' => 'Managing Director',
                    'company' => 'Farmers SACCO',
                    'quote' => "Apex's digital banking platform transformed how we serve our rural communities. We've seen a 300% increase in mobile transactions and our customers love the intuitive interface.",
                    'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100'
                ],
                [
                    'name' => 'Sarah Chen',
                    'role' => 'CEO',
                    'company' => 'QuickLoan Finance',
                    'quote' => "The implementation was seamless and the support team was exceptional. Within 6 months, we processed over \$50M in loans through their digital lending system.",
                    'image' => 'https://images.unsplash.com/photo-1494790108755-2616b612b786?w=100'
                ],
                [
                    'name' => 'Michael Kamau',
                    'role' => 'Operations Director',
                    'company' => 'Community Bank',
                    'quote' => "Our agent banking network grew from 50 to 500+ agents in just one year. The platform's scalability and reliability have been game-changers for our expansion.",
                    'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100'
                ]
            ];
        }
        ?>
        
        <div class="apex-stories-testimonials__grid">
            <?php foreach ($testimonials as $testimonial): ?>
            <div class="apex-stories-testimonials__item">
                <div class="apex-stories-testimonials__quote">
                    <p>"<?php echo esc_html($testimonial['quote']); ?>"</p>
                </div>
                <div class="apex-stories-testimonials__author">
                    <img src="<?php echo esc_url($testimonial['image']); ?>" alt="<?php echo esc_attr($testimonial['name']); ?>">
                    <div>
                        <strong><?php echo esc_html($testimonial['name']); ?></strong>
                        <span><?php echo esc_html($testimonial['role']); ?>, <?php echo esc_html($testimonial['company']); ?></span>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="apex-stories-impact">
    <div class="apex-stories-impact__container">
        <div class="apex-stories-impact__header">
            <span class="apex-stories-impact__badge"><?php echo esc_html(get_option('apex_stories_impact_badge_insights-success-stories', 'Our Impact')); ?></span>
            <h2 class="apex-stories-impact__heading"><?php echo esc_html(get_option('apex_stories_impact_heading_insights-success-stories', 'Driving Financial Inclusion Across Africa')); ?></h2>
            <p class="apex-stories-impact__description"><?php echo esc_html(get_option('apex_stories_impact_description_insights-success-stories', "Together with our clients, we're making a measurable difference in communities across the continent.")); ?></p>
        </div>
        
        <div class="apex-stories-impact__grid">
            <?php
            $impact_items = get_option('apex_stories_impact_items_insights-success-stories', 
                "10M+ | End Users Served\n\$5B+ | Transactions Processed\n2M+ | Previously Unbanked Reached\n500K+ | Small Businesses Empowered"
            );
            foreach (explode("\n", $impact_items) as $impact_line) {
                $parts = explode(' | ', $impact_line);
                if (count($parts) >= 2) {
                    $value = trim($parts[0]);
                    $label = trim($parts[1]);
                    ?>
                    <div class="apex-stories-impact__item">
                        <span class="apex-stories-impact__value"><?php echo esc_html($value); ?></span>
                        <span class="apex-stories-impact__label"><?php echo esc_html($label); ?></span>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-blog-newsletter">
    <div class="apex-blog-newsletter__container">
        <div class="apex-blog-newsletter__content">
            <h2 class="apex-blog-newsletter__heading"><?php echo esc_html(get_option('apex_stories_newsletter_heading_insights-success-stories', 'Get Success Stories Delivered')); ?></h2>
            <p class="apex-blog-newsletter__description"><?php echo esc_html(get_option('apex_stories_newsletter_description_insights-success-stories', 'Subscribe to our newsletter for the latest case studies, client success stories, and insights from our team of experts.')); ?></p>
            
            <form class="apex-blog-newsletter__form">
                <input type="email" placeholder="<?php echo esc_attr(get_option('apex_stories_newsletter_placeholder_insights-success-stories', 'Enter your email address')); ?>" required>
                <button type="submit"><?php echo esc_html(get_option('apex_stories_newsletter_button_insights-success-stories', 'Subscribe')); ?></button>
            </form>
            
            <p class="apex-blog-newsletter__note"><?php echo esc_html(get_option('apex_stories_newsletter_note_insights-success-stories', 'Join 10,000+ subscribers. Unsubscribe at any time.')); ?></p>
        </div>
    </div>
</section>

<?php get_footer(); ?>

<?php wp_footer(); ?>

<script>
jQuery(document).ready(function($) {
    // Handle filter changes
    $('#industry-filter, #region-filter, #solution-filter').on('change', function() {
        var industry = $('#industry-filter').val();
        var region = $('#region-filter').val();
        var solution = $('#solution-filter').val();
        
        // Build URL with filter parameters
        var url = new URL(window.location);
        if (industry !== 'all') {
            url.searchParams.set('industry', industry);
        } else {
            url.searchParams.delete('industry');
        }
        if (region !== 'all') {
            url.searchParams.set('region', region);
        } else {
            url.searchParams.delete('region');
        }
        if (solution !== 'all') {
            url.searchParams.set('solution', solution);
        } else {
            url.searchParams.delete('solution');
        }
        
        // Reset to page 1 when filters change
        url.searchParams.delete('paged');
        
        // Navigate to new URL
        window.location.href = url.toString();
    });
});
</script>
