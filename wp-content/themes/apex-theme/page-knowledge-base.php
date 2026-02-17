<?php 
/**
 * Template Name: Knowledge Base
 * Knowledge Base Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_kb_hero_stats_knowledge-base', "200+ | Articles\n50+ | Video Tutorials\n100% | Searchable\n24/7 | Access");
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
    'badge' => get_option('apex_kb_hero_badge_knowledge-base', 'Knowledge Base'),
    'heading' => get_option('apex_kb_hero_heading_knowledge-base', 'Comprehensive Documentation & Guides'),
    'description' => get_option('apex_kb_hero_description_knowledge-base', 'Find detailed guides, tutorials, and documentation to help you get the most out of our products.'),
    'stats' => $stats_array,
    'image' => get_option('apex_kb_hero_image_knowledge-base', 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=1200')
]);
?>

<section class="apex-kb-search">
    <div class="apex-kb-search__container">
        <div class="apex-kb-search__header">
            <h2 class="apex-kb-search__heading"><?php echo esc_html(get_option('apex_kb_search_heading_knowledge-base', 'Search Our Knowledge Base')); ?></h2>
            <p class="apex-kb-search__description"><?php echo esc_html(get_option('apex_kb_search_description_knowledge-base', 'Find answers to your questions quickly')); ?></p>
        </div>
        
        <div class="apex-kb-search__form">
            <input type="text" placeholder="<?php echo esc_attr(get_option('apex_kb_search_placeholder_knowledge-base', 'Search for articles, guides, tutorials...')); ?>" class="apex-kb-search__input">
            <button type="submit" class="apex-kb-search__button">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                <?php echo esc_html(get_option('apex_kb_search_button_knowledge-base', 'Search')); ?>
            </button>
        </div>
        
        <div class="apex-kb-search__suggestions">
            <span>Popular searches:</span>
            <?php
            $suggestions = get_option('apex_kb_search_suggestions_knowledge-base', "Getting started\nMobile banking setup\nAPI integration\nSecurity settings");
            $suggestion_lines = explode("\n", $suggestions);
            foreach ($suggestion_lines as $suggestion) {
                $suggestion = trim($suggestion);
                if (!empty($suggestion)) {
                    echo '<a href="#">' . esc_html($suggestion) . '</a>';
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-kb-categories">
    <div class="apex-kb-categories__container">
        <div class="apex-kb-categories__header">
            <h2 class="apex-kb-categories__heading"><?php echo esc_html(get_option('apex_kb_categories_heading_knowledge-base', 'Browse by Category')); ?></h2>
        </div>
        
        <div class="apex-kb-categories__grid">
            <?php
            $category_icons = [
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>'
            ];
            
            $categories = get_option('apex_kb_categories_items_knowledge-base', 
                "Getting Started | Quick start guides and onboarding documentation | 25 articles\n" .
                "Core Banking | Comprehensive guides for ApexCore platform | 45 articles\n" .
                "Mobile Banking | Mobile app setup and configuration guides | 38 articles\n" .
                "Agent Banking | Agent network setup and management | 22 articles\n" .
                "Security | Security configuration and best practices | 18 articles\n" .
                "Integrations | API documentation and integration guides | 32 articles\n" .
                "Reports | Reporting and analytics configuration | 15 articles\n" .
                "Billing | Account management and billing guides | 8 articles"
            );
            
            $category_lines = explode("\n", $categories);
            $icon_index = 0;
            foreach ($category_lines as $category_line) {
                $parts = explode(' | ', $category_line);
                if (count($parts) >= 3) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $count = trim($parts[2]);
                    $icon = isset($category_icons[$icon_index]) ? $category_icons[$icon_index] : '';
                    ?>
                    <a href="#" class="apex-kb-categories__card">
                        <div class="apex-kb-categories__card-icon">
                            <?php echo $icon; ?>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <p><?php echo esc_html($description); ?></p>
                        <span class="apex-kb-categories__card-count"><?php echo esc_html($count); ?></span>
                    </a>
                    <?php
                    $icon_index++;
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-kb-articles">
    <div class="apex-kb-articles__container">
        <div class="apex-kb-articles__header">
            <h2 class="apex-kb-articles__heading"><?php echo esc_html(get_option('apex_kb_articles_heading_knowledge-base', 'Popular Articles')); ?></h2>
            <p class="apex-kb-articles__description"><?php echo esc_html(get_option('apex_kb_articles_description_knowledge-base', 'Most viewed articles this week')); ?></p>
        </div>
        
        <div class="apex-kb-articles__list">
            <?php
            $article_icons = [
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>'
            ];
            
            $articles = get_option('apex_kb_articles_items_knowledge-base', 
                "Getting Started with ApexCore | A comprehensive guide to setting up your core banking platform | Getting Started • 15 min read\n" .
                "Configuring Mobile Banking App | Step-by-step guide to customize your mobile banking experience | Mobile Banking • 12 min read\n" .
                "Security Best Practices | Essential security configurations for your platform | Security • 10 min read\n" .
                "API Integration Guide | How to integrate your systems with our APIs | Integrations • 20 min read\n" .
                "Setting Up Agent Banking | Complete guide to deploying your agent network | Agent Banking • 18 min read\n" .
                "Creating Custom Reports | Build custom reports to meet your regulatory requirements | Reports • 14 min read"
            );
            
            $article_lines = explode("\n", $articles);
            $icon_index = 0;
            foreach ($article_lines as $article_line) {
                $parts = explode(' | ', $article_line);
                if (count($parts) >= 3) {
                    $title = trim($parts[0]);
                    $description = trim($parts[1]);
                    $meta = trim($parts[2]);
                    $icon = isset($article_icons[$icon_index]) ? $article_icons[$icon_index] : '';
                    ?>
                    <a href="#" class="apex-kb-articles__item">
                        <div class="apex-kb-articles__item-icon">
                            <?php echo $icon; ?>
                        </div>
                        <div class="apex-kb-articles__item-content">
                            <h3><?php echo esc_html($title); ?></h3>
                            <p><?php echo esc_html($description); ?></p>
                            <span class="apex-kb-articles__item-meta"><?php echo esc_html($meta); ?></span>
                        </div>
                        <span class="apex-kb-articles__item-arrow">→</span>
                    </a>
                    <?php
                    $icon_index++;
                }
            }
            ?>
        </div>
    </div>
</section>

<section class="apex-kb-videos">
    <div class="apex-kb-videos__container">
        <div class="apex-kb-videos__header">
            <h2 class="apex-kb-videos__heading"><?php echo esc_html(get_option('apex_kb_videos_heading_knowledge-base', 'Video Tutorials')); ?></h2>
            <p class="apex-kb-videos__description"><?php echo esc_html(get_option('apex_kb_videos_description_knowledge-base', 'Learn visually with our video guides')); ?></p>
        </div>
        
        <div class="apex-kb-videos__grid">
            <?php
            $videos = get_option('apex_kb_videos_items_knowledge-base', 
                "Platform Overview | 5:32 | https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=400\n" .
                "User Management | 8:15 | https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400\n" .
                "Product Configuration | 12:45 | https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400\n" .
                "Reporting Dashboard | 6:20 | https://images.unsplash.com/photo-1551434678-e076c223a692?w=400"
            );
            
            $video_lines = explode("\n", $videos);
            foreach ($video_lines as $video_line) {
                $parts = explode(' | ', $video_line);
                if (count($parts) >= 3) {
                    $title = trim($parts[0]);
                    $duration = trim($parts[1]);
                    $thumbnail = trim($parts[2]);
                    ?>
                    <a href="#" class="apex-kb-videos__item">
                        <div class="apex-kb-videos__item-thumbnail">
                            <img src="<?php echo esc_url($thumbnail); ?>" alt="<?php echo esc_attr($title); ?>">
                            <div class="apex-kb-videos__item-play">
                                <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                            </div>
                        </div>
                        <h3><?php echo esc_html($title); ?></h3>
                        <span><?php echo esc_html($duration); ?></span>
                    </a>
                    <?php
                }
            }
            ?>
        </div>
    </div>
</section>


<?php get_footer(); ?>
