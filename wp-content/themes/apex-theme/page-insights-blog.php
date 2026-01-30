<?php 
/**
 * Template Name: Insights Blog
 * Blog Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Insights & Thought Leadership',
    'heading' => 'The Apex Blog',
    'description' => 'Expert insights, industry trends, and practical guides on digital banking, financial technology, and driving innovation in African financial services.',
    'stats' => [
        ['value' => '200+', 'label' => 'Articles Published'],
        ['value' => '50K+', 'label' => 'Monthly Readers'],
        ['value' => '15+', 'label' => 'Expert Contributors'],
        ['value' => '8', 'label' => 'Topic Categories']
    ],
    'image' => 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1200'
]);
?>

<section class="apex-blog-featured">
    <div class="apex-blog-featured__container">
        <div class="apex-blog-featured__header">
            <span class="apex-blog-featured__badge">Editor's Pick</span>
        </div>
        
        <div class="apex-blog-featured__card">
            <div class="apex-blog-featured__image">
                <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=800" alt="Future of Digital Banking" loading="lazy">
                <span class="apex-blog-featured__category">Digital Banking</span>
            </div>
            <div class="apex-blog-featured__content">
                <div class="apex-blog-featured__meta">
                    <span class="apex-blog-featured__date">January 25, 2026</span>
                    <span class="apex-blog-featured__read-time">8 min read</span>
                </div>
                <h2 class="apex-blog-featured__title">The Future of Digital Banking in Africa: 5 Trends Shaping 2026 and Beyond</h2>
                <p class="apex-blog-featured__excerpt">As we enter 2026, the African banking landscape continues to evolve at an unprecedented pace. From embedded finance to AI-driven personalization, discover the key trends that will define the next era of financial services across the continent.</p>
                <div class="apex-blog-featured__author">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Sarah Ochieng">
                    <div>
                        <strong>Sarah Ochieng</strong>
                        <span>Chief Technology Officer</span>
                    </div>
                </div>
                <a href="#" class="apex-blog-featured__link">
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
            <a href="#" class="apex-blog-categories__item" data-category="digital-banking">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                <span>Digital Banking</span>
                <small>42 articles</small>
            </a>
            <a href="#" class="apex-blog-categories__item" data-category="mobile-banking">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
                <span>Mobile Banking</span>
                <small>38 articles</small>
            </a>
            <a href="#" class="apex-blog-categories__item" data-category="financial-inclusion">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <span>Financial Inclusion</span>
                <small>31 articles</small>
            </a>
            <a href="#" class="apex-blog-categories__item" data-category="security">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                <span>Security & Compliance</span>
                <small>28 articles</small>
            </a>
            <a href="#" class="apex-blog-categories__item" data-category="ai-analytics">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>
                <span>AI & Analytics</span>
                <small>24 articles</small>
            </a>
            <a href="#" class="apex-blog-categories__item" data-category="api-integration">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                <span>API & Integration</span>
                <small>19 articles</small>
            </a>
            <a href="#" class="apex-blog-categories__item" data-category="sacco-mfi">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 21h18M3 10h18M5 6l7-3 7 3M4 10v11M20 10v11M8 14v3M12 14v3M16 14v3"/></svg>
                <span>SACCO & MFI</span>
                <small>35 articles</small>
            </a>
            <a href="#" class="apex-blog-categories__item" data-category="product-updates">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4M4.93 19.07l2.83-2.83M16.24 7.76l2.83-2.83"/></svg>
                <span>Product Updates</span>
                <small>22 articles</small>
            </a>
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
            <h2 class="apex-blog-newsletter__heading">Get Insights Delivered</h2>
            <p class="apex-blog-newsletter__description">Subscribe to our weekly newsletter for the latest articles, industry news, and exclusive insights from our team of experts.</p>
            
            <form class="apex-blog-newsletter__form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
            </form>
            
            <p class="apex-blog-newsletter__note">Join 10,000+ subscribers. Unsubscribe at any time.</p>
        </div>
    </div>
</section>

<?php get_footer(); ?>
