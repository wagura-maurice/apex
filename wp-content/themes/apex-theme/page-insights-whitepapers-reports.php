<?php 
/**
 * Template Name: Insights Whitepapers Reports
 * Whitepapers & Reports Page Template - Dynamic Admin Controlled
 * 
 * @package ApexTheme
 */

get_header(); 

// Dynamic Hero Section - Admin Controlled
$hero_stats = get_option('apex_reports_hero_stats_insights-whitepapers-reports', "30+ | Publications\n15K+ | Downloads\n10+ | Research Partners\n5 | Annual Reports");
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
    'badge' => get_option('apex_reports_hero_badge_insights-whitepapers-reports', 'Research & Resources'),
    'heading' => get_option('apex_reports_hero_heading_insights-whitepapers-reports', 'Whitepapers & Reports'),
    'description' => get_option('apex_reports_hero_description_insights-whitepapers-reports', 'In-depth research, industry analysis, and practical guides to help you make informed decisions about your digital transformation journey.'),
    'stats' => $stats_array,
    'image' => get_option('apex_reports_hero_image_insights-whitepapers-reports', 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200')
]);
?>

<section class="apex-reports-featured">
    <div class="apex-reports-featured__container">
        <div class="apex-reports-featured__header">
            <span class="apex-reports-featured__badge"><?php echo esc_html(get_option('apex_reports_featured_badge_insights-whitepapers-reports', 'Featured Report')); ?></span>
        </div>
        
        <div class="apex-reports-featured__card">
            <div class="apex-reports-featured__image">
                <img src="<?php echo esc_url(get_option('apex_reports_featured_image_insights-whitepapers-reports', 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600')); ?>" alt="<?php echo esc_attr(get_option('apex_reports_featured_title_insights-whitepapers-reports', 'Featured Report')); ?>" loading="lazy">
                <span class="apex-reports-featured__type"><?php echo esc_html(get_option('apex_reports_featured_type_insights-whitepapers-reports', 'Annual Report')); ?></span>
            </div>
            <div class="apex-reports-featured__content">
                <span class="apex-reports-featured__date"><?php echo esc_html(get_option('apex_reports_featured_date_insights-whitepapers-reports', 'January 2026')); ?></span>
                <h2 class="apex-reports-featured__title"><?php echo esc_html(get_option('apex_reports_featured_title_insights-whitepapers-reports', 'The State of Digital Banking in Africa 2026')); ?></h2>
                <p class="apex-reports-featured__excerpt"><?php echo esc_html(get_option('apex_reports_featured_excerpt_insights-whitepapers-reports', 'Our comprehensive annual report analyzing digital banking trends, adoption rates, and opportunities across 15 African markets. Based on surveys of 500+ financial institutions and analysis of 10 million+ transactions.')); ?></p>
                
                <div class="apex-reports-featured__highlights">
                    <h4>Key Findings:</h4>
                    <ul>
                        <?php
                        $highlights = get_option('apex_reports_featured_highlights_insights-whitepapers-reports', 
                            "Mobile banking adoption grew 45% year-over-year\nAI-powered services now used by 60% of institutions\nAgent banking networks expanded to reach 50M+ users\nCloud adoption accelerating with 70% planning migration"
                        );
                        foreach (explode("\n", $highlights) as $highlight) {
                            if (trim($highlight)) {
                                echo '<li>' . esc_html(trim($highlight)) . '</li>';
                            }
                        }
                        ?>
                    </ul>
                </div>
                
                <div class="apex-reports-featured__meta">
                    <span><strong>Pages:</strong> <?php echo esc_html(get_option('apex_reports_featured_pages_insights-whitepapers-reports', '86')); ?></span>
                    <span><strong>Format:</strong> <?php echo esc_html(get_option('apex_reports_featured_format_insights-whitepapers-reports', 'PDF')); ?></span>
                </div>
                
                <a href="<?php echo esc_url(get_option('apex_reports_featured_link_insights-whitepapers-reports', '#')); ?>" class="apex-reports-featured__cta">
                    Download Free Report
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="apex-reports-categories">
    <div class="apex-reports-categories__container">
        <h2 class="apex-reports-categories__heading"><?php echo esc_html(get_option('apex_reports_categories_heading_insights-whitepapers-reports', 'Browse by Category')); ?></h2>
        <div class="apex-reports-categories__grid">
            <?php
            // Category icons
            $category_icons = [
                'industry-reports' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>',
                'whitepapers' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>',
                'guides' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>',
                'benchmarks' => '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>'
            ];
            
            $categories = get_option('apex_reports_categories_items_insights-whitepapers-reports', 
                "industry-reports | Industry Reports | 8 publications\n" .
                "whitepapers | Whitepapers | 12 publications\n" .
                "guides | Implementation Guides | 6 publications\n" .
                "benchmarks | Benchmark Studies | 4 publications"
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
                    <a href="#" class="apex-reports-categories__item" data-category="<?php echo esc_attr($id); ?>">
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

<section class="apex-reports-grid">
    <div class="apex-reports-grid__container">
        <div class="apex-reports-grid__header">
            <h2 class="apex-reports-grid__heading">All Publications</h2>
            <div class="apex-reports-grid__sort">
                <label>Sort by:</label>
                <select>
                    <option value="newest">Newest First</option>
                    <option value="popular">Most Popular</option>
                    <option value="title">Title A-Z</option>
                </select>
            </div>
        </div>
        
        <div class="apex-reports-grid__items">
            <article class="apex-reports-grid__item" data-category="whitepapers">
                <div class="apex-reports-grid__item-cover">
                    <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=300" alt="Open Banking Whitepaper" loading="lazy">
                    <span class="apex-reports-grid__item-type">Whitepaper</span>
                </div>
                <div class="apex-reports-grid__item-content">
                    <h3>Open Banking in Africa: Opportunities and Challenges</h3>
                    <p>An analysis of open banking initiatives across African markets and their implications for financial institutions.</p>
                    <div class="apex-reports-grid__item-meta">
                        <span>December 2025</span>
                        <span>24 pages</span>
                        <span>2,340 downloads</span>
                    </div>
                    <a href="#" class="apex-reports-grid__item-download">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Download PDF
                    </a>
                </div>
            </article>
            
            <article class="apex-reports-grid__item" data-category="guides">
                <div class="apex-reports-grid__item-cover">
                    <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=300" alt="Core Banking Migration Guide" loading="lazy">
                    <span class="apex-reports-grid__item-type">Guide</span>
                </div>
                <div class="apex-reports-grid__item-content">
                    <h3>The Complete Guide to Core Banking Migration</h3>
                    <p>A step-by-step guide covering planning, execution, and post-migration optimization for core banking transformations.</p>
                    <div class="apex-reports-grid__item-meta">
                        <span>November 2025</span>
                        <span>42 pages</span>
                        <span>1,890 downloads</span>
                    </div>
                    <a href="#" class="apex-reports-grid__item-download">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Download PDF
                    </a>
                </div>
            </article>
            
            <article class="apex-reports-grid__item" data-category="benchmarks">
                <div class="apex-reports-grid__item-cover">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=300" alt="SACCO Performance Benchmark" loading="lazy">
                    <span class="apex-reports-grid__item-type">Benchmark</span>
                </div>
                <div class="apex-reports-grid__item-content">
                    <h3>East African SACCO Performance Benchmark 2025</h3>
                    <p>Comparative analysis of operational efficiency, digital adoption, and member satisfaction across 200+ SACCOs.</p>
                    <div class="apex-reports-grid__item-meta">
                        <span>October 2025</span>
                        <span>56 pages</span>
                        <span>1,567 downloads</span>
                    </div>
                    <a href="#" class="apex-reports-grid__item-download">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Download PDF
                    </a>
                </div>
            </article>
            
            <article class="apex-reports-grid__item" data-category="whitepapers">
                <div class="apex-reports-grid__item-cover">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=300" alt="AI in Banking Whitepaper" loading="lazy">
                    <span class="apex-reports-grid__item-type">Whitepaper</span>
                </div>
                <div class="apex-reports-grid__item-content">
                    <h3>AI and Machine Learning in African Banking</h3>
                    <p>Exploring practical applications of AI in credit scoring, fraud detection, and customer service for African financial institutions.</p>
                    <div class="apex-reports-grid__item-meta">
                        <span>September 2025</span>
                        <span>32 pages</span>
                        <span>2,123 downloads</span>
                    </div>
                    <a href="#" class="apex-reports-grid__item-download">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Download PDF
                    </a>
                </div>
            </article>
            
            <article class="apex-reports-grid__item" data-category="industry-reports">
                <div class="apex-reports-grid__item-cover">
                    <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=300" alt="Financial Inclusion Report" loading="lazy">
                    <span class="apex-reports-grid__item-type">Report</span>
                </div>
                <div class="apex-reports-grid__item-content">
                    <h3>Financial Inclusion Progress Report: Sub-Saharan Africa</h3>
                    <p>Tracking progress toward financial inclusion goals and identifying remaining gaps across 20 Sub-Saharan African countries.</p>
                    <div class="apex-reports-grid__item-meta">
                        <span>August 2025</span>
                        <span>68 pages</span>
                        <span>3,456 downloads</span>
                    </div>
                    <a href="#" class="apex-reports-grid__item-download">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Download PDF
                    </a>
                </div>
            </article>
            
            <article class="apex-reports-grid__item" data-category="guides">
                <div class="apex-reports-grid__item-cover">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=300" alt="Agent Banking Guide" loading="lazy">
                    <span class="apex-reports-grid__item-type">Guide</span>
                </div>
                <div class="apex-reports-grid__item-content">
                    <h3>Building an Agent Banking Network: A Practical Guide</h3>
                    <p>Everything you need to know about launching and scaling an agent banking network for last-mile financial service delivery.</p>
                    <div class="apex-reports-grid__item-meta">
                        <span>July 2025</span>
                        <span>38 pages</span>
                        <span>1,234 downloads</span>
                    </div>
                    <a href="#" class="apex-reports-grid__item-download">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Download PDF
                    </a>
                </div>
            </article>
            
            <article class="apex-reports-grid__item" data-category="whitepapers">
                <div class="apex-reports-grid__item-cover">
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=300" alt="Cybersecurity Whitepaper" loading="lazy">
                    <span class="apex-reports-grid__item-type">Whitepaper</span>
                </div>
                <div class="apex-reports-grid__item-content">
                    <h3>Cybersecurity Best Practices for African Financial Institutions</h3>
                    <p>A comprehensive guide to protecting your institution and customers from evolving cyber threats.</p>
                    <div class="apex-reports-grid__item-meta">
                        <span>June 2025</span>
                        <span>28 pages</span>
                        <span>1,876 downloads</span>
                    </div>
                    <a href="#" class="apex-reports-grid__item-download">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Download PDF
                    </a>
                </div>
            </article>
            
            <article class="apex-reports-grid__item" data-category="benchmarks">
                <div class="apex-reports-grid__item-cover">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=300" alt="Mobile Banking Benchmark" loading="lazy">
                    <span class="apex-reports-grid__item-type">Benchmark</span>
                </div>
                <div class="apex-reports-grid__item-content">
                    <h3>Mobile Banking App Performance Benchmark 2025</h3>
                    <p>Comparative analysis of mobile banking app performance, features, and user experience across 50 African banks.</p>
                    <div class="apex-reports-grid__item-meta">
                        <span>May 2025</span>
                        <span>44 pages</span>
                        <span>987 downloads</span>
                    </div>
                    <a href="#" class="apex-reports-grid__item-download">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                        Download PDF
                    </a>
                </div>
            </article>
        </div>
        
        <div class="apex-reports-grid__pagination">
            <button class="apex-reports-grid__page-btn active">1</button>
            <button class="apex-reports-grid__page-btn">2</button>
            <button class="apex-reports-grid__page-btn">3</button>
            <button class="apex-reports-grid__page-btn">→</button>
        </div>
    </div>
</section>

<section class="apex-reports-custom">
    <div class="apex-reports-custom__container">
        <div class="apex-reports-custom__content">
            <span class="apex-reports-custom__badge"><?php echo esc_html(get_option('apex_reports_custom_badge_insights-whitepapers-reports', 'Custom Research')); ?></span>
            <h2 class="apex-reports-custom__heading"><?php echo esc_html(get_option('apex_reports_custom_heading_insights-whitepapers-reports', 'Need Custom Research?')); ?></h2>
            <p class="apex-reports-custom__description"><?php echo esc_html(get_option('apex_reports_custom_description_insights-whitepapers-reports', 'Our research team can conduct custom studies tailored to your specific needs, including market analysis, competitive benchmarking, and feasibility studies.')); ?></p>
            
            <div class="apex-reports-custom__services">
                <?php
                $services = get_option('apex_reports_custom_services_insights-whitepapers-reports', 
                    "Market Analysis | Deep-dive into specific markets or segments\n" .
                    "Competitive Benchmarking | Compare your performance against peers\n" .
                    "Feasibility Studies | Assess viability of new initiatives"
                );
                $service_icons = [
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>',
                    '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>'
                ];
                $service_lines = explode("\n", $services);
                $icon_index = 0;
                foreach ($service_lines as $service_line) {
                    $parts = explode(' | ', $service_line);
                    if (count($parts) >= 2) {
                        $title = trim($parts[0]);
                        $description = trim($parts[1]);
                        $icon = isset($service_icons[$icon_index]) ? $service_icons[$icon_index] : '';
                        ?>
                        <div class="apex-reports-custom__service">
                            <?php echo $icon; ?>
                            <div>
                                <strong><?php echo esc_html($title); ?></strong>
                                <span><?php echo esc_html($description); ?></span>
                            </div>
                        </div>
                        <?php
                        $icon_index++;
                    }
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

<section class="apex-reports-newsletter">
    <div class="apex-reports-newsletter__container">
        <div class="apex-reports-newsletter__content">
            <h2 class="apex-reports-newsletter__heading"><?php echo esc_html(get_option('apex_reports_newsletter_heading_insights-whitepapers-reports', 'Get New Reports First')); ?></h2>
            <p class="apex-reports-newsletter__description"><?php echo esc_html(get_option('apex_reports_newsletter_description_insights-whitepapers-reports', 'Subscribe to be notified when we publish new research, whitepapers, and industry reports.')); ?></p>
            
            <form class="apex-reports-newsletter__form">
                <input type="email" placeholder="<?php echo esc_attr(get_option('apex_reports_newsletter_placeholder_insights-whitepapers-reports', 'Enter your email address')); ?>" required>
                <button type="submit"><?php echo esc_html(get_option('apex_reports_newsletter_button_insights-whitepapers-reports', 'Subscribe')); ?></button>
            </form>
            
            <p class="apex-reports-newsletter__note"><?php echo esc_html(get_option('apex_reports_newsletter_note_insights-whitepapers-reports', 'Join 5,000+ subscribers. We respect your privacy.')); ?></p>
        </div>
    </div>
</section>

<?php get_footer(); ?>
