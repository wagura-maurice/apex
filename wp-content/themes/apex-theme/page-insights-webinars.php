<?php 
/**
 * Template Name: Insights Webinars
 * Webinars & Events Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_webinars_hero_stats_insights-webinars', "50+ | Webinars Hosted\n10K+ | Attendees\n25+ | Expert Speakers\n12 | Annual Events");
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
    'badge' => get_option('apex_webinars_hero_badge_insights-webinars', 'Webinars & Events'),
    'heading' => get_option('apex_webinars_hero_heading_insights-webinars', 'Learn from Industry Experts'),
    'description' => get_option('apex_webinars_hero_description_insights-webinars', 'Join our webinars, workshops, and events to stay ahead of the curve in financial technology. Connect with peers and learn from industry leaders.'),
    'stats' => $stats_array,
    'image' => get_option('apex_webinars_hero_image_insights-webinars', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=1200')
]);
?>

<section class="apex-webinars-upcoming">
    <div class="apex-webinars-upcoming__container">
        <div class="apex-webinars-upcoming__header">
            <span class="apex-webinars-upcoming__badge"><?php echo esc_html(get_option('apex_webinars_upcoming_badge_insights-webinars', 'Upcoming Events')); ?></span>
            <h2 class="apex-webinars-upcoming__heading"><?php echo esc_html(get_option('apex_webinars_upcoming_heading_insights-webinars', "Don't Miss Out")); ?></h2>
            <p class="apex-webinars-upcoming__description"><?php echo esc_html(get_option('apex_webinars_upcoming_description_insights-webinars', 'Register for our upcoming webinars and events to learn from industry experts and connect with peers.')); ?></p>
        </div>
        
        <div class="apex-webinars-upcoming__grid">
            <?php
            // Get the featured event first
            $featured_event = get_posts([
                'post_type' => 'webinar_event',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'meta_key' => '_webinar_event_featured',
                'meta_value' => '1',
                'orderby' => 'date',
                'order' => 'DESC'
            ]);
            
            // Display featured event if exists
            if ($featured_event) :
                $event = $featured_event[0];
                $event_date = get_post_meta($event->ID, '_webinar_event_date', true);
                $event_start_time = get_post_meta($event->ID, '_webinar_event_start_time', true);
                $event_end_time = get_post_meta($event->ID, '_webinar_event_end_time', true);
                $event_timezone = get_post_meta($event->ID, '_webinar_event_timezone', true);
                $event_duration = get_post_meta($event->ID, '_webinar_event_duration', true);
                $event_registration_url = get_post_meta($event->ID, '_webinar_event_registration_url', true);
                $event_speakers = get_post_meta($event->ID, '_webinar_event_speakers', true);
                
                $date_obj = $event_date ? DateTime::createFromFormat('Y-m-d', $event_date) : null;
                $day = $date_obj ? $date_obj->format('d') : '';
                $month = $date_obj ? strtoupper($date_obj->format('M')) : '';
                
                $event_types = get_the_terms($event->ID, 'webinar_event_type');
                $event_type_name = ($event_types && !is_wp_error($event_types)) ? $event_types[0]->name : 'Live Webinar';
                
                $is_featured = true;
                $tz_suffix = $event_timezone ? ' ' . $event_timezone : '';
                $time_display = $event_start_time ? $event_start_time . ($event_end_time ? '–' . $event_end_time : '') . $tz_suffix : '';
                $duration_display = apex_calc_event_duration($event_start_time, $event_end_time, $event_duration);
            ?>
            <div class="apex-webinars-upcoming__item apex-webinars-upcoming__item--featured">
                <div class="apex-webinars-upcoming__item-badge"><?php echo esc_html(get_option('apex_webinars_featured_badge_insights-webinars', 'Featured Webinar')); ?></div>
                <div class="apex-webinars-upcoming__item-date">
                    <?php if (has_post_thumbnail($event->ID)) : ?>
                        <?php echo get_the_post_thumbnail($event->ID, 'medium', ['class' => 'apex-webinars-upcoming__item-image', 'loading' => 'lazy']); ?>
                    <?php else : ?>
                        <?php
                        $ph_hash = crc32($event->post_title . $event->ID);
                        $ph_hue = abs($ph_hash) % 360;
                        $ph_initial = strtoupper(mb_substr($event_type_name, 0, 1));
                        ?>
                        <div class="apex-webinars-upcoming__item-placeholder" style="background:linear-gradient(135deg,hsl(<?php echo $ph_hue; ?>,45%,45%),hsl(<?php echo ($ph_hue+40)%360; ?>,55%,35%));">
                            <span class="apex-webinars-upcoming__item-initial"><?php echo esc_html($ph_initial); ?></span>
                            <span class="apex-webinars-upcoming__item-type-name"><?php echo esc_html($event_type_name); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($event_date && $date_obj) : ?>
                    <div class="apex-webinars-upcoming__item-date-overlay">
                        <span class="apex-webinars-upcoming__item-day"><?php echo esc_html($day); ?></span>
                        <span class="apex-webinars-upcoming__item-month"><?php echo esc_html($month); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="apex-webinars-upcoming__item-content">
                    <span class="apex-webinars-upcoming__item-type"><?php echo esc_html($event_type_name); ?></span>
                    <h3><?php echo esc_html($event->post_title); ?></h3>
                    <p><?php echo esc_html(wp_trim_words($event->post_excerpt ?: wp_strip_all_tags($event->post_content), 25)); ?></p>
                    <div class="apex-webinars-upcoming__item-meta">
                        <?php if ($time_display) : ?>
                        <div class="apex-webinars-upcoming__item-time">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <span><?php echo esc_html($time_display); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if ($duration_display) : ?>
                        <div class="apex-webinars-upcoming__item-duration">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3v4M3 5h4M6 17v4M4 19h4M13 3l2 2-2 2M19 13l2 2-2 2"/><circle cx="12" cy="12" r="3"/></svg>
                            <span><?php echo esc_html($duration_display); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <?php if ($is_featured && $event_speakers) : ?>
                    <div class="apex-webinars-upcoming__item-speakers">
                        <span>Speakers:</span>
                        <div class="apex-webinars-upcoming__item-speaker-avatars">
                            <?php 
                            $speaker_names = array_map('trim', explode(',', $event_speakers));
                            $all_speakers = apex_parse_webinar_speakers();
                            foreach (array_slice($speaker_names, 0, 2) as $sname) :
                                $matched = false;
                                foreach ($all_speakers as $sp) {
                                    if (strcasecmp($sp['name'], $sname) === 0) {
                                        echo '<img src="' . esc_url($sp['image']) . '" alt="' . esc_attr($sname) . '">';
                                        $matched = true;
                                        break;
                                    }
                                }
                                if (!$matched) :
                            ?>
                                <div style="width: 50px; height: 50px; border-radius: 50%; background: #f97316; display: flex; align-items: center; justify-content: center; color: white; font-weight: bold;">
                                    <?php echo esc_html(strtoupper(mb_substr($sname, 0, 1))); ?>
                                </div>
                            <?php endif; endforeach; ?>
                        </div>
                        <span><?php echo esc_html($event_speakers); ?></span>
                    </div>
                    <?php endif; ?>
                    <a href="<?php echo esc_url($event_registration_url ?: '#'); ?>" class="apex-webinars-upcoming__item-cta">Register Now - Free</a>
                </div>
            </div>
            <?php endif; ?>
            
            <?php
            // Now query non-featured events with pagination
            $events_paged = max(1, intval($_GET['events_page'] ?? 1));
            $posts_per_page = 4; // Show 4 non-featured events per page
            
            $upcoming_events_query = new WP_Query([
                'post_type' => 'webinar_event',
                'post_status' => 'publish',
                'posts_per_page' => $posts_per_page,
                'paged' => $events_paged,
                'meta_query' => [
                    'relation' => 'OR',
                    [
                        'key' => '_webinar_event_featured',
                        'compare' => 'NOT EXISTS',
                    ],
                    [
                        'key' => '_webinar_event_featured',
                        'value' => '1',
                        'compare' => '!=',
                    ],
                ],
                'meta_key' => '_webinar_event_date',
                'orderby' => 'meta_value',
                'order' => 'ASC',
            ]);
            
            if ($upcoming_events_query->have_posts()) :
                foreach ($upcoming_events_query->posts as $event) :
                    $event_date = get_post_meta($event->ID, '_webinar_event_date', true);
                    $event_start_time = get_post_meta($event->ID, '_webinar_event_start_time', true);
                    $event_end_time = get_post_meta($event->ID, '_webinar_event_end_time', true);
                    $event_timezone = get_post_meta($event->ID, '_webinar_event_timezone', true);
                    $event_duration = get_post_meta($event->ID, '_webinar_event_duration', true);
                    $event_registration_url = get_post_meta($event->ID, '_webinar_event_registration_url', true);
                    $event_speakers = get_post_meta($event->ID, '_webinar_event_speakers', true);
                    
                    $date_obj = $event_date ? DateTime::createFromFormat('Y-m-d', $event_date) : null;
                    $day = $date_obj ? $date_obj->format('d') : '';
                    $month = $date_obj ? strtoupper($date_obj->format('M')) : '';
                    
                    $event_types = get_the_terms($event->ID, 'webinar_event_type');
                    $event_type_name = ($event_types && !is_wp_error($event_types)) ? $event_types[0]->name : 'Live Webinar';
                    
                    $is_featured = false;
                    $tz_suffix = $event_timezone ? ' ' . $event_timezone : '';
                    $time_display = $event_start_time ? $event_start_time . ($event_end_time ? '–' . $event_end_time : '') . $tz_suffix : '';
                    $duration_display = apex_calc_event_duration($event_start_time, $event_end_time, $event_duration);
            ?>
            <div class="apex-webinars-upcoming__item">
                <div class="apex-webinars-upcoming__item-date">
                    <?php if (has_post_thumbnail($event->ID)) : ?>
                        <?php echo get_the_post_thumbnail($event->ID, 'medium', ['class' => 'apex-webinars-upcoming__item-image', 'loading' => 'lazy']); ?>
                    <?php else : ?>
                        <?php
                        $ph_hash = crc32($event->post_title . $event->ID);
                        $ph_hue = abs($ph_hash) % 360;
                        $ph_initial = strtoupper(mb_substr($event_type_name, 0, 1));
                        ?>
                        <div class="apex-webinars-upcoming__item-placeholder" style="background:linear-gradient(135deg,hsl(<?php echo $ph_hue; ?>,45%,45%),hsl(<?php echo ($ph_hue+40)%360; ?>,55%,35%));">
                            <span class="apex-webinars-upcoming__item-initial"><?php echo esc_html($ph_initial); ?></span>
                            <span class="apex-webinars-upcoming__item-type-name"><?php echo esc_html($event_type_name); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($event_date && $date_obj) : ?>
                    <div class="apex-webinars-upcoming__item-date-overlay">
                        <span class="apex-webinars-upcoming__item-day"><?php echo esc_html($day); ?></span>
                        <span class="apex-webinars-upcoming__item-month"><?php echo esc_html($month); ?></span>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="apex-webinars-upcoming__item-content">
                    <span class="apex-webinars-upcoming__item-type"><?php echo esc_html($event_type_name); ?></span>
                    <h3><?php echo esc_html($event->post_title); ?></h3>
                    <p><?php echo esc_html(wp_trim_words($event->post_excerpt ?: wp_strip_all_tags($event->post_content), 25)); ?></p>
                    <div class="apex-webinars-upcoming__item-meta">
                        <?php if ($time_display) : ?>
                        <div class="apex-webinars-upcoming__item-time">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <span><?php echo esc_html($time_display); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if ($duration_display) : ?>
                        <div class="apex-webinars-upcoming__item-duration">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3v4M3 5h4M6 17v4M4 19h4M13 3l2 2-2 2M19 13l2 2-2 2"/><circle cx="12" cy="12" r="3"/></svg>
                            <span><?php echo esc_html($duration_display); ?></span>
                        </div>
                        <?php endif; ?>
                    </div>
                    <a href="<?php echo esc_url($event_registration_url ?: '#'); ?>" class="apex-webinars-upcoming__item-cta apex-webinars-upcoming__item-cta--secondary">Register</a>
                </div>
            </div>
            <?php
                endforeach;
                
                // Add pagination for non-featured events only
                $total_pages = $upcoming_events_query->max_num_pages;
                
                if ($total_pages > 1) :
            ?>
            <div class="apex-webinars-upcoming__pagination">
                <?php
                // Previous page link
                if ($events_paged > 1) :
            ?>
                    <a href="<?php echo esc_url(add_query_arg('events_page', $events_paged - 1)); ?>" class="apex-webinars-upcoming__page-btn">←</a>
            <?php endif; ?>
            
            <?php
            // Page numbers
            $show_pages = 4;
            $start_page = max(1, $events_paged - floor($show_pages / 2));
            $end_page = min($total_pages, $start_page + $show_pages - 1);
            
            if ($start_page > 1) :
            ?>
                    <a href="<?php echo esc_url(add_query_arg('events_page', 1)); ?>" class="apex-webinars-upcoming__page-btn">1</a>
                    <?php if ($start_page > 2) : ?>
                        <span class="apex-webinars-upcoming__page-ellipsis">...</span>
                    <?php endif; ?>
            <?php endif; ?>
            
            <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                <?php if ($i == $events_paged) : ?>
                    <button class="apex-webinars-upcoming__page-btn active"><?php echo $i; ?></button>
                <?php else : ?>
                    <a href="<?php echo esc_url(add_query_arg('events_page', $i)); ?>" class="apex-webinars-upcoming__page-btn"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php
            if ($end_page < $total_pages) :
                if ($end_page < $total_pages - 1) :
            ?>
                    <span class="apex-webinars-upcoming__page-ellipsis">...</span>
                <?php endif; ?>
                <a href="<?php echo esc_url(add_query_arg('events_page', $total_pages)); ?>" class="apex-webinars-upcoming__page-btn"><?php echo $total_pages; ?></a>
            <?php endif; ?>
            
            <?php
            // Next page link
            if ($events_paged < $total_pages) :
            ?>
                    <a href="<?php echo esc_url(add_query_arg('events_page', $events_paged + 1)); ?>" class="apex-webinars-upcoming__page-btn">→</a>
            <?php endif; ?>
            </div>
            <?php endif; ?>
            <?php else : ?>
                // Fallback: show static defaults when no events exist yet
            ?>
            <div class="apex-webinars-upcoming__item apex-webinars-upcoming__item--featured">
                <div class="apex-webinars-upcoming__item-badge"><?php echo esc_html(get_option('apex_webinars_featured_badge_insights-webinars', 'Featured Webinar')); ?></div>
                <div class="apex-webinars-upcoming__item-date">
                    <?php 
                    $fallback_image = get_option('apex_webinars_featured_image_insights-webinars', 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=400');
                    if ($fallback_image) : 
                    ?>
                        <img src="<?php echo esc_url($fallback_image); ?>" alt="<?php echo esc_attr(get_option('apex_webinars_featured_title_insights-webinars', 'Featured Webinar')); ?>" class="apex-webinars-upcoming__item-image" loading="lazy">
                    <?php else : ?>
                        <div class="apex-webinars-upcoming__item-placeholder" style="background:linear-gradient(135deg,hsl(25,45%,45%),hsl(65,55%,35%));">
                            <span class="apex-webinars-upcoming__item-initial">W</span>
                            <span class="apex-webinars-upcoming__item-type-name">Webinar</span>
                        </div>
                    <?php endif; ?>
                    <div class="apex-webinars-upcoming__item-date-overlay">
                        <span class="apex-webinars-upcoming__item-day"><?php echo esc_html(get_option('apex_webinars_featured_day_insights-webinars', '15')); ?></span>
                        <span class="apex-webinars-upcoming__item-month"><?php echo esc_html(get_option('apex_webinars_featured_month_insights-webinars', 'FEB')); ?></span>
                    </div>
                </div>
                <div class="apex-webinars-upcoming__item-content">
                    <span class="apex-webinars-upcoming__item-type"><?php echo esc_html(get_option('apex_webinars_featured_type_insights-webinars', 'Live Webinar')); ?></span>
                    <h3><?php echo esc_html(get_option('apex_webinars_featured_title_insights-webinars', 'The Future of Core Banking: Cloud-Native Architecture in 2026')); ?></h3>
                    <p><?php echo esc_html(get_option('apex_webinars_featured_description_insights-webinars', 'Explore how cloud-native core banking systems are revolutionizing the financial services industry. Learn about scalability, security, and cost benefits.')); ?></p>
                    <div class="apex-webinars-upcoming__item-meta">
                        <div class="apex-webinars-upcoming__item-time">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                            <span><?php echo esc_html(get_option('apex_webinars_featured_time_insights-webinars', '2:00 PM EAT')); ?></span>
                        </div>
                        <div class="apex-webinars-upcoming__item-duration">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 3v4M3 5h4M6 17v4M4 19h4M13 3l2 2-2 2M19 13l2 2-2 2"/><circle cx="12" cy="12" r="3"/></svg>
                            <span><?php echo esc_html(get_option('apex_webinars_featured_duration_insights-webinars', '60 minutes')); ?></span>
                        </div>
                    </div>
                    <div class="apex-webinars-upcoming__item-speakers">
                        <span>Speakers:</span>
                        <div class="apex-webinars-upcoming__item-speaker-avatars">
                            <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Speaker 1">
                            <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" alt="Speaker 2">
                        </div>
                        <span><?php echo esc_html(get_option('apex_webinars_featured_speakers_insights-webinars', 'Sarah Ochieng, John Kamau')); ?></span>
                    </div>
                    <a href="<?php echo esc_url(get_option('apex_webinars_featured_link_insights-webinars', '#')); ?>" class="apex-webinars-upcoming__item-cta">Register Now - Free</a>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="apex-webinars-conference">
    <div class="apex-webinars-conference__container">
        <?php
        // Get conference from admin textarea (similar to speakers)
        $conference = apex_parse_webinar_conference();
        
        if ($conference) :
        ?>
        <div class="apex-webinars-conference__content">
            <span class="apex-webinars-conference__badge">Annual Conference</span>
            <h2 class="apex-webinars-conference__heading"><?php echo esc_html($conference['name']); ?></h2>
            <p class="apex-webinars-conference__description"><?php echo esc_html($conference['description']); ?></p>
            
            <div class="apex-webinars-conference__details">
                <?php if ($conference['date']) : ?>
                <div class="apex-webinars-conference__detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    <div>
                        <strong>Date</strong>
                        <span><?php echo esc_html($conference['date']); ?></span>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($conference['location']) : ?>
                <div class="apex-webinars-conference__detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <div>
                        <strong>Location</strong>
                        <span><?php echo esc_html($conference['location']); ?></span>
                    </div>
                </div>
                <?php endif; ?>
                
                <?php if ($conference['attendees']) : ?>
                <div class="apex-webinars-conference__detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <div>
                        <strong>Attendees</strong>
                        <span><?php echo esc_html($conference['attendees']); ?></span>
                    </div>
                </div>
                <?php endif; ?>
            </div>
            
            <?php if (!empty($conference['highlights'])) : ?>
            <div class="apex-webinars-conference__highlights">
                <h4>Conference Highlights:</h4>
                <ul>
                    <?php foreach ($conference['highlights'] as $highlight) : ?>
                        <li><?php echo esc_html($highlight); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            
            <div class="apex-webinars-conference__ctas">
                <?php if ($conference['register_link']) : ?>
                <a href="<?php echo esc_url($conference['register_link']); ?>" class="apex-webinars-conference__cta-primary" target="_blank">Register Early - Save 30%</a>
                <?php endif; ?>
                <?php if ($conference['agenda_link']) : ?>
                <a href="<?php echo esc_url($conference['agenda_link']); ?>" class="apex-webinars-conference__cta-secondary" target="_blank">View Agenda</a>
                <?php endif; ?>
            </div>
        </div>
        <div class="apex-webinars-conference__image">
            <img src="<?php echo esc_url($conference['image']); ?>" alt="<?php echo esc_attr($conference['name']); ?>" loading="lazy">
        </div>
        <?php else : ?>
        <!-- Fallback to admin options when no conference data exists -->
        <div class="apex-webinars-conference__content">
            <span class="apex-webinars-conference__badge"><?php echo esc_html(get_option('apex_webinars_conf_badge_insights-webinars', 'Annual Conference')); ?></span>
            <h2 class="apex-webinars-conference__heading"><?php echo esc_html(get_option('apex_webinars_conf_heading_insights-webinars', 'Apex Summit 2026')); ?></h2>
            <p class="apex-webinars-conference__description"><?php echo esc_html(get_option('apex_webinars_conf_description_insights-webinars', 'Join us for our flagship annual conference bringing together 500+ financial technology leaders, innovators, and practitioners from across Africa.')); ?></p>
            
            <div class="apex-webinars-conference__details">
                <div class="apex-webinars-conference__detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                    <div>
                        <strong>Date</strong>
                        <span><?php echo esc_html(get_option('apex_webinars_conf_date_insights-webinars', 'June 15-17, 2026')); ?></span>
                    </div>
                </div>
                <div class="apex-webinars-conference__detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <div>
                        <strong>Location</strong>
                        <span><?php echo esc_html(get_option('apex_webinars_conf_location_insights-webinars', 'Kenyatta International Convention Centre, Nairobi')); ?></span>
                    </div>
                </div>
                <div class="apex-webinars-conference__detail">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    <div>
                        <strong>Attendees</strong>
                        <span><?php echo esc_html(get_option('apex_webinars_conf_attendees_insights-webinars', '500+ Industry Leaders')); ?></span>
                    </div>
                </div>
            </div>
            
            <div class="apex-webinars-conference__highlights">
                <h4>Conference Highlights:</h4>
                <ul>
                    <?php
                    $highlights = get_option('apex_webinars_conf_highlights_insights-webinars', 
                        "50+ Sessions across 5 tracks\nKeynotes from industry visionaries\nHands-on product workshops\nNetworking events and awards dinner\nExhibition hall with 30+ vendors"
                    );
                    foreach (explode("\n", $highlights) as $highlight) {
                        if (trim($highlight)) {
                            echo '<li>' . esc_html(trim($highlight)) . '</li>';
                        }
                    }
                    ?>
                </ul>
            </div>
            
            <div class="apex-webinars-conference__ctas">
                <a href="<?php echo esc_url(get_option('apex_webinars_conf_register_link_insights-webinars', '#')); ?>" class="apex-webinars-conference__cta-primary">Register Early - Save 30%</a>
                <a href="<?php echo esc_url(get_option('apex_webinars_conf_agenda_link_insights-webinars', '#')); ?>" class="apex-webinars-conference__cta-secondary">View Agenda</a>
            </div>
        </div>
        <div class="apex-webinars-conference__image">
            <img src="<?php echo esc_url(get_option('apex_webinars_conf_image_insights-webinars', 'https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=600')); ?>" alt="<?php echo esc_attr(get_option('apex_webinars_conf_heading_insights-webinars', 'Conference')); ?>" loading="lazy">
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="apex-webinars-ondemand">
    <div class="apex-webinars-ondemand__container">
        <div class="apex-webinars-ondemand__header">
            <span class="apex-webinars-ondemand__badge"><?php echo esc_html(get_option('apex_webinars_ondemand_badge_insights-webinars', 'On-Demand Library')); ?></span>
            <h2 class="apex-webinars-ondemand__heading"><?php echo esc_html(get_option('apex_webinars_ondemand_heading_insights-webinars', 'Watch Anytime')); ?></h2>
            <p class="apex-webinars-ondemand__description"><?php echo esc_html(get_option('apex_webinars_ondemand_description_insights-webinars', 'Missed a webinar? Catch up with our library of recorded sessions covering a wide range of topics.')); ?></p>
        </div>
        
        <div class="apex-webinars-ondemand__filters">
            <button class="apex-webinars-ondemand__filter active" data-filter="all">All Topics</button>
            <?php
            $library_categories = get_terms([
                'taxonomy' => 'webinar_library_category',
                'hide_empty' => false,
                'orderby' => 'name',
                'order' => 'ASC'
            ]);
            if ($library_categories && !is_wp_error($library_categories)) :
                foreach ($library_categories as $lib_cat) :
            ?>
                <button class="apex-webinars-ondemand__filter" data-filter="<?php echo esc_attr($lib_cat->slug); ?>"><?php echo esc_html($lib_cat->name); ?></button>
            <?php endforeach; endif; ?>
        </div>
        
        <div class="apex-webinars-ondemand__grid">
            <?php
            // Pagination setup for webinar library
            $library_paged = max(1, intval($_GET['library_page'] ?? 1));
            $posts_per_page = 6;
            
            // WordPress query with proper pagination
            $library_query = new WP_Query([
                'post_type' => 'webinar_library',
                'post_status' => 'publish',
                'posts_per_page' => $posts_per_page,
                'paged' => $library_paged,
                'orderby' => 'date',
                'order' => 'DESC',
            ]);
            
            if ($library_query->have_posts()) :
                while ($library_query->have_posts()) : $library_query->the_post();
                    $lib_duration = get_post_meta(get_the_ID(), '_webinar_library_duration', true);
                    $lib_views = get_post_meta(get_the_ID(), '_webinar_library_views', true);
                    $lib_recording_date = get_post_meta(get_the_ID(), '_webinar_library_recording_date', true);
                    
                    $lib_cats = get_the_terms(get_the_ID(), 'webinar_library_category');
                    $lib_cat_slug = ($lib_cats && !is_wp_error($lib_cats)) ? $lib_cats[0]->slug : 'other';
                    $lib_cat_name = ($lib_cats && !is_wp_error($lib_cats)) ? $lib_cats[0]->name : 'Webinar';
                    
                    $views_display = $lib_views ? number_format(intval($lib_views)) : '0';
                    $date_display = $lib_recording_date ? date('M Y', strtotime($lib_recording_date)) : get_the_date('M Y', get_the_ID());
            ?>
            <article class="apex-webinars-ondemand__item" data-category="<?php echo esc_attr($lib_cat_slug); ?>">
                <div class="apex-webinars-ondemand__item-thumbnail">
                    <?php if (has_post_thumbnail(get_the_ID())) : ?>
                        <img src="<?php echo esc_url(get_the_post_thumbnail_url(get_the_ID(), 'medium')); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                    <?php else : ?>
                        <?php
                        $ph_hash = crc32(get_the_title() . get_the_ID());
                        $ph_hue = abs($ph_hash) % 360;
                        $ph_initial = strtoupper(mb_substr($lib_cat_name, 0, 1));
                        ?>
                        <div style="width:100%;height:100%;min-height:200px;background:linear-gradient(135deg,hsl(<?php echo $ph_hue; ?>,45%,45%),hsl(<?php echo ($ph_hue+40)%360; ?>,55%,35%));display:flex;align-items:center;justify-content:center;flex-direction:column;color:#fff;font-family:sans-serif;">
                            <span style="font-size:48px;font-weight:700;opacity:0.9;"><?php echo esc_html($ph_initial); ?></span>
                            <span style="font-size:13px;opacity:0.7;margin-top:4px;"><?php echo esc_html($lib_cat_name); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if ($lib_duration) : ?>
                    <span class="apex-webinars-ondemand__item-duration"><?php echo esc_html($lib_duration); ?></span>
                    <?php endif; ?>
                    <div class="apex-webinars-ondemand__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="apex-webinars-ondemand__item-content">
                    <span class="apex-webinars-ondemand__item-category"><?php echo esc_html($lib_cat_name); ?></span>
                    <h3><?php echo esc_html(get_the_title()); ?></h3>
                    <p><?php echo esc_html(wp_trim_words(get_the_excerpt() ?: wp_strip_all_tags(get_the_content()), 20)); ?></p>
                    <div class="apex-webinars-ondemand__item-meta">
                        <span><?php echo esc_html($views_display); ?> views</span>
                        <span><?php echo esc_html($date_display); ?></span>
                    </div>
                </div>
            </article>
            <?php
                endwhile;
                wp_reset_postdata();
            else :
                // Fallback: show static defaults when no library items exist yet
                $default_library = [
                    ['title' => 'Core Banking Modernization: A Practical Roadmap', 'desc' => 'Step-by-step guide to planning and executing a successful core banking transformation.', 'duration' => '58:32', 'views' => '1,245', 'date' => 'Dec 2025', 'category' => 'core-banking', 'cat_name' => 'Core Banking', 'img' => 'https://images.unsplash.com/photo-1551434678-e076c223a692?w=400'],
                    ['title' => 'Designing Mobile Banking Apps That Users Love', 'desc' => 'UX best practices and design principles for creating engaging mobile banking experiences.', 'duration' => '45:18', 'views' => '982', 'date' => 'Nov 2025', 'category' => 'mobile-banking', 'cat_name' => 'Mobile Banking', 'img' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400'],
                    ['title' => 'AI-Powered Fraud Detection: Real-World Implementation', 'desc' => 'How to implement machine learning models for real-time fraud detection and prevention.', 'duration' => '52:45', 'views' => '1,567', 'date' => 'Oct 2025', 'category' => 'security', 'cat_name' => 'Security', 'img' => 'https://images.unsplash.com/photo-1563986768609-322da13575f3?w=400'],
                    ['title' => 'Navigating Regulatory Compliance Across African Markets', 'desc' => 'Understanding and meeting regulatory requirements when operating in multiple African countries.', 'duration' => '61:20', 'views' => '876', 'date' => 'Sep 2025', 'category' => 'compliance', 'cat_name' => 'Compliance', 'img' => 'https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=400'],
                    ['title' => 'Zero-Downtime Data Migration Strategies', 'desc' => 'Best practices for migrating customer data without service interruption.', 'duration' => '48:55', 'views' => '1,102', 'date' => 'Aug 2025', 'category' => 'core-banking', 'cat_name' => 'Core Banking', 'img' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400'],
                    ['title' => 'Building Successful Agent Banking Networks', 'desc' => 'Strategies for recruiting, training, and managing agent networks for last-mile delivery.', 'duration' => '55:10', 'views' => '789', 'date' => 'Jul 2025', 'category' => 'mobile-banking', 'cat_name' => 'Mobile Banking', 'img' => 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400'],
                ];
                foreach ($default_library as $dl) :
            ?>
            <article class="apex-webinars-ondemand__item" data-category="<?php echo esc_attr($dl['category']); ?>">
                <div class="apex-webinars-ondemand__item-thumbnail">
                    <img src="<?php echo esc_url($dl['img']); ?>" alt="<?php echo esc_attr($dl['title']); ?>" loading="lazy">
                    <span class="apex-webinars-ondemand__item-duration"><?php echo esc_html($dl['duration']); ?></span>
                    <div class="apex-webinars-ondemand__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <div class="apex-webinars-ondemand__item-content">
                    <span class="apex-webinars-ondemand__item-category"><?php echo esc_html($dl['cat_name']); ?></span>
                    <h3><?php echo esc_html($dl['title']); ?></h3>
                    <p><?php echo esc_html($dl['desc']); ?></p>
                    <div class="apex-webinars-ondemand__item-meta">
                        <span><?php echo esc_html($dl['views']); ?> views</span>
                        <span><?php echo esc_html($dl['date']); ?></span>
                    </div>
                </div>
            </article>
            <?php endforeach; endif; ?>
        </div>
        
        <?php
        $total_pages = isset($library_query) ? $library_query->max_num_pages : 1;
        if ($total_pages > 1) :
        ?>
        <div class="apex-webinars-ondemand__pagination">
            <?php
            // Previous page link
            if ($library_paged > 1) :
            ?>
                <a href="<?php echo esc_url(add_query_arg('library_page', $library_paged - 1)); ?>" class="apex-webinars-ondemand__page-btn">←</a>
            <?php endif; ?>
            
            <?php
            // Page numbers
            $show_pages = 4;
            $start_page = max(1, $library_paged - floor($show_pages / 2));
            $end_page = min($total_pages, $start_page + $show_pages - 1);
            
            if ($start_page > 1) :
            ?>
                <a href="<?php echo esc_url(add_query_arg('library_page', 1)); ?>" class="apex-webinars-ondemand__page-btn">1</a>
                <?php if ($start_page > 2) : ?>
                    <span class="apex-webinars-ondemand__page-ellipsis">...</span>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php for ($i = $start_page; $i <= $end_page; $i++) : ?>
                <?php if ($i == $library_paged) : ?>
                    <button class="apex-webinars-ondemand__page-btn active"><?php echo $i; ?></button>
                <?php else : ?>
                    <a href="<?php echo esc_url(add_query_arg('library_page', $i)); ?>" class="apex-webinars-ondemand__page-btn"><?php echo $i; ?></a>
                <?php endif; ?>
            <?php endfor; ?>
            
            <?php
            if ($end_page < $total_pages) :
                if ($end_page < $total_pages - 1) :
            ?>
                    <span class="apex-webinars-ondemand__page-ellipsis">...</span>
                <?php endif; ?>
                <a href="<?php echo esc_url(add_query_arg('library_page', $total_pages)); ?>" class="apex-webinars-ondemand__page-btn"><?php echo $total_pages; ?></a>
            <?php endif; ?>
            
            <?php
            // Next page link
            if ($library_paged < $total_pages) :
            ?>
                <a href="<?php echo esc_url(add_query_arg('library_page', $library_paged + 1)); ?>" class="apex-webinars-ondemand__page-btn">→</a>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<section class="apex-webinars-speakers">
    <div class="apex-webinars-speakers__container">
        <div class="apex-webinars-speakers__header">
            <span class="apex-webinars-speakers__badge"><?php echo esc_html(get_option('apex_webinars_speakers_badge_insights-webinars', 'Expert Speakers')); ?></span>
            <h2 class="apex-webinars-speakers__heading"><?php echo esc_html(get_option('apex_webinars_speakers_heading_insights-webinars', 'Learn from the Best')); ?></h2>
            <p class="apex-webinars-speakers__description"><?php echo esc_html(get_option('apex_webinars_speakers_description_insights-webinars', 'Our webinars feature industry experts, thought leaders, and practitioners with deep experience in financial technology.')); ?></p>
        </div>
        
        <div class="apex-webinars-speakers__grid">
            <?php
            $speakers = apex_parse_webinar_speakers();
            foreach ($speakers as $speaker) :
            ?>
            <div class="apex-webinars-speakers__item">
                <img src="<?php echo esc_url($speaker['image']); ?>" alt="<?php echo esc_attr($speaker['name']); ?>">
                <h4><?php echo esc_html($speaker['name']); ?></h4>
                <span><?php echo esc_html($speaker['title']); ?>, <?php echo esc_html($speaker['company']); ?></span>
                <p><?php echo esc_html($speaker['bio']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="apex-webinars-newsletter">
    <div class="apex-webinars-newsletter__container">
        <div class="apex-webinars-newsletter__content">
            <h2 class="apex-webinars-newsletter__heading"><?php echo esc_html(get_option('apex_webinars_newsletter_heading_insights-webinars', 'Never Miss an Event')); ?></h2>
            <p class="apex-webinars-newsletter__description"><?php echo esc_html(get_option('apex_webinars_newsletter_description_insights-webinars', 'Subscribe to get notified about upcoming webinars, workshops, and events.')); ?></p>
            
            <form class="apex-webinars-newsletter__form">
                <input type="email" placeholder="<?php echo esc_attr(get_option('apex_webinars_newsletter_placeholder_insights-webinars', 'Enter your email address')); ?>" required>
                <button type="submit"><?php echo esc_html(get_option('apex_webinars_newsletter_button_insights-webinars', 'Subscribe')); ?></button>
            </form>
            
            <p class="apex-webinars-newsletter__note"><?php echo esc_html(get_option('apex_webinars_newsletter_note_insights-webinars', 'We respect your privacy. Unsubscribe at any time.')); ?></p>
        </div>
    </div>
</section>

<?php get_footer(); ?>

<script>
jQuery(document).ready(function($) {
    // On-Demand Library category filtering
    $('.apex-webinars-ondemand__filter').on('click', function() {
        var filter = $(this).data('filter');
        
        $('.apex-webinars-ondemand__filter').removeClass('active');
        $(this).addClass('active');
        
        if (filter === 'all') {
            $('.apex-webinars-ondemand__item').show();
        } else {
            $('.apex-webinars-ondemand__item').hide();
            $('.apex-webinars-ondemand__item[data-category="' + filter + '"]').show();
        }
        
        // Reset pagination to page 1 when filter changes
        var url = new URL(window.location.href);
        if (url.searchParams.has('library_page') && url.searchParams.get('library_page') !== '1') {
            url.searchParams.delete('library_page');
            history.replaceState(null, '', url.toString());
        }
        // Update active button visually to page 1
        var $pagination = $('.apex-webinars-ondemand__pagination');
        $pagination.find('.apex-webinars-ondemand__page-btn').removeClass('active');
        $pagination.find('a.apex-webinars-ondemand__page-btn').first().addClass('active');

        // Show/hide pagination based on whether any items are visible
        var visible = $('.apex-webinars-ondemand__item:visible').length;
        if (visible === 0) {
            $pagination.hide();
        } else {
            $pagination.show();
        }
    });
});
</script>
