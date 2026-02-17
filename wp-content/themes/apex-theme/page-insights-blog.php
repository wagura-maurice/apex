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
        <h2 class="apex-blog-categories__heading"><?php echo esc_html(get_option('apex_blog_categories_heading_insights-blog', 'Browse by Topic')); ?></h2>
        <div class="apex-blog-categories__grid">
            <?php
            // Category icons
            $category_icons = [
                'digital-banking' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>',
                'mobile-banking' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>',
                'financial-inclusion' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>',
                'security' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>',
                'ai-analytics' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>',
                'api-integration' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>',
                'sacco-mfi' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>',
                'product-updates' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>'
            ];
            
            $categories = get_option('apex_blog_categories_items_insights-blog', 
                "digital-banking | Digital Banking | 42 articles\n" .
                "mobile-banking | Mobile Banking | 38 articles\n" .
                "financial-inclusion | Financial Inclusion | 31 articles\n" .
                "security | Security & Compliance | 28 articles\n" .
                "ai-analytics | AI & Analytics | 24 articles\n" .
                "api-integration | API & Integration | 19 articles\n" .
                "sacco-mfi | SACCO & MFI | 35 articles\n" .
                "product-updates | Product Updates | 22 articles"
            );
            
            $category_lines = explode("\n", $categories);
            foreach ($category_lines as $category_line) {
                $parts = explode(' | ', $category_line);
                if (count($parts) >= 3) {
                    $id = trim($parts[0]);
                    $title = trim($parts[1]);
                    $count = trim($parts[2]);
                    $icon = isset($category_icons[$id]) ? $category_icons[$id] : '';
                    ?>
                    <a href="#" class="apex-blog-categories__item" data-category="<?php echo esc_attr($id); ?>">
                        <?php echo $icon; ?>
                        <span><?php echo esc_html($title); ?></span>
                        <small><?php echo esc_html($count); ?></small>
                    </a>
                    <?php
                }
            }
            ?>
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
            <article class="apex-blog-grid__item">
                <div class="apex-blog-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=400" alt="Open Banking APIs" loading="lazy">
                </div>
                <div class="apex-blog-grid__item-content">
                    <span class="apex-blog-grid__item-category">API & Integration</span>
                    <h3>How Open Banking APIs Are Transforming Financial Services in East Africa</h3>
                    <p>Explore how open banking initiatives are creating new opportunities for innovation and collaboration in the East African financial ecosystem.</p>
                    <div class="apex-blog-grid__item-meta">
                        <span>January 20, 2026</span>
                        <span>6 min read</span>
                    </div>
                    <a href="#">Read Article →</a>
                </div>
            </article>
            
            <article class="apex-blog-grid__item">
                <div class="apex-blog-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400" alt="AI in Banking" loading="lazy">
                </div>
                <div class="apex-blog-grid__item-content">
                    <span class="apex-blog-grid__item-category">AI & Analytics</span>
                    <h3>5 Ways AI Is Revolutionizing Credit Scoring for Underserved Markets</h3>
                    <p>Traditional credit scoring leaves millions unbanked. Learn how AI-powered alternative data analysis is changing the game.</p>
                    <div class="apex-blog-grid__item-meta">
                        <span>January 18, 2026</span>
                        <span>7 min read</span>
                    </div>
                    <a href="#">Read Article →</a>
                </div>
            </article>
            
            <article class="apex-blog-grid__item">
                <div class="apex-blog-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400" alt="Mobile Money" loading="lazy">
                </div>
                <div class="apex-blog-grid__item-content">
                    <span class="apex-blog-grid__item-category">Mobile Banking</span>
                    <h3>The Rise of Super Apps: What African Banks Can Learn from Asia</h3>
                    <p>Super apps are reshaping consumer expectations. Here's how African financial institutions can adapt and thrive.</p>
                    <div class="apex-blog-grid__item-meta">
                        <span>January 15, 2026</span>
                        <span>5 min read</span>
                    </div>
                    <a href="#">Read Article →</a>
                </div>
            </article>
            
            <article class="apex-blog-grid__item">
                <div class="apex-blog-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400" alt="SACCO Digital" loading="lazy">
                </div>
                <div class="apex-blog-grid__item-content">
                    <span class="apex-blog-grid__item-category">SACCO & MFI</span>
                    <h3>Digital Transformation Roadmap for SACCOs: A Step-by-Step Guide</h3>
                    <p>A practical guide for SACCO leaders looking to modernize operations and better serve their members in the digital age.</p>
                    <div class="apex-blog-grid__item-meta">
                        <span>January 12, 2026</span>
                        <span>10 min read</span>
                    </div>
                    <a href="#">Read Article →</a>
                </div>
            </article>
            
            <article class="apex-blog-grid__item">
                <div class="apex-blog-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=400" alt="Cybersecurity" loading="lazy">
                </div>
                <div class="apex-blog-grid__item-content">
                    <span class="apex-blog-grid__item-category">Security & Compliance</span>
                    <h3>Cybersecurity Best Practices for African Financial Institutions in 2026</h3>
                    <p>With cyber threats evolving rapidly, here are the essential security measures every financial institution should implement.</p>
                    <div class="apex-blog-grid__item-meta">
                        <span>January 10, 2026</span>
                        <span>8 min read</span>
                    </div>
                    <a href="#">Read Article →</a>
                </div>
            </article>
            
            <article class="apex-blog-grid__item">
                <div class="apex-blog-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400" alt="Financial Inclusion" loading="lazy">
                </div>
                <div class="apex-blog-grid__item-content">
                    <span class="apex-blog-grid__item-category">Financial Inclusion</span>
                    <h3>Agent Banking: Reaching the Last Mile in Rural Africa</h3>
                    <p>How agent banking networks are bringing financial services to underserved communities across the continent.</p>
                    <div class="apex-blog-grid__item-meta">
                        <span>January 8, 2026</span>
                        <span>6 min read</span>
                    </div>
                    <a href="#">Read Article →</a>
                </div>
            </article>
        </div>
        
        <div class="apex-blog-grid__pagination">
            <button class="apex-blog-grid__page-btn active">1</button>
            <button class="apex-blog-grid__page-btn">2</button>
            <button class="apex-blog-grid__page-btn">3</button>
            <button class="apex-blog-grid__page-btn">4</button>
            <button class="apex-blog-grid__page-btn">→</button>
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
