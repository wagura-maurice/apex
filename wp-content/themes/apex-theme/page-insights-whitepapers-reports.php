<?php 
/**
 * Template Name: Insights Whitepapers Reports
 * Whitepapers & Reports Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Research & Resources',
    'heading' => 'Whitepapers & Reports',
    'description' => 'In-depth research, industry analysis, and practical guides to help you make informed decisions about your digital transformation journey.',
    'stats' => [
        ['value' => '30+', 'label' => 'Publications'],
        ['value' => '15K+', 'label' => 'Downloads'],
        ['value' => '10+', 'label' => 'Research Partners'],
        ['value' => '5', 'label' => 'Annual Reports']
    ],
    'image' => 'https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=1200'
]);
?>

<section class="apex-reports-featured">
    <div class="apex-reports-featured__container">
        <div class="apex-reports-featured__header">
            <span class="apex-reports-featured__badge">Featured Report</span>
        </div>
        
        <div class="apex-reports-featured__card">
            <div class="apex-reports-featured__image">
                <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600" alt="State of Digital Banking Report" loading="lazy">
                <span class="apex-reports-featured__type">Annual Report</span>
            </div>
            <div class="apex-reports-featured__content">
                <span class="apex-reports-featured__date">January 2026</span>
                <h2 class="apex-reports-featured__title">The State of Digital Banking in Africa 2026</h2>
                <p class="apex-reports-featured__excerpt">Our comprehensive annual report analyzing digital banking trends, adoption rates, and opportunities across 15 African markets. Based on surveys of 500+ financial institutions and analysis of 10 million+ transactions.</p>
                
                <div class="apex-reports-featured__highlights">
                    <h4>Key Findings:</h4>
                    <ul>
                        <li>Mobile banking adoption grew 45% year-over-year</li>
                        <li>AI-powered services now used by 60% of institutions</li>
                        <li>Agent banking networks expanded to reach 50M+ users</li>
                        <li>Cloud adoption accelerating with 70% planning migration</li>
                    </ul>
                </div>
                
                <div class="apex-reports-featured__meta">
                    <span><strong>Pages:</strong> 86</span>
                    <span><strong>Format:</strong> PDF</span>
                </div>
                
                <a href="#" class="apex-reports-featured__cta">
                    Download Free Report
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="apex-reports-categories">
    <div class="apex-reports-categories__container">
        <h2 class="apex-reports-categories__heading">Browse by Category</h2>
        <div class="apex-reports-categories__grid">
            <a href="#" class="apex-reports-categories__item" data-category="industry-reports">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10H12V2z"/><path d="M12 2a10 10 0 0 1 10 10"/></svg>
                <span>Industry Reports</span>
                <small>8 publications</small>
            </a>
            <a href="#" class="apex-reports-categories__item" data-category="whitepapers">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                <span>Whitepapers</span>
                <small>12 publications</small>
            </a>
            <a href="#" class="apex-reports-categories__item" data-category="guides">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                <span>Implementation Guides</span>
                <small>6 publications</small>
            </a>
            <a href="#" class="apex-reports-categories__item" data-category="benchmarks">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                <span>Benchmark Studies</span>
                <small>4 publications</small>
            </a>
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
            <span class="apex-reports-custom__badge">Custom Research</span>
            <h2 class="apex-reports-custom__heading">Need Custom Research?</h2>
            <p class="apex-reports-custom__description">Our research team can conduct custom studies tailored to your specific needs, including market analysis, competitive benchmarking, and feasibility studies.</p>
            
            <div class="apex-reports-custom__services">
                <div class="apex-reports-custom__service">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                    <div>
                        <strong>Market Analysis</strong>
                        <span>Deep-dive into specific markets or segments</span>
                    </div>
                </div>
                <div class="apex-reports-custom__service">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 20V10M12 20V4M6 20v-6"/></svg>
                    <div>
                        <strong>Competitive Benchmarking</strong>
                        <span>Compare your performance against peers</span>
                    </div>
                </div>
                <div class="apex-reports-custom__service">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                    <div>
                        <strong>Feasibility Studies</strong>
                        <span>Assess viability of new initiatives</span>
                    </div>
                </div>
            </div>
            
            <a href="<?php echo home_url('/contact'); ?>" class="apex-reports-custom__cta">Request Custom Research</a>
        </div>
        <div class="apex-reports-custom__image">
            <img src="https://images.unsplash.com/photo-1552664730-d307ca884978?w=500" alt="Research Team" loading="lazy">
        </div>
    </div>
</section>

<section class="apex-reports-newsletter">
    <div class="apex-reports-newsletter__container">
        <div class="apex-reports-newsletter__content">
            <h2 class="apex-reports-newsletter__heading">Get New Reports First</h2>
            <p class="apex-reports-newsletter__description">Subscribe to be notified when we publish new research, whitepapers, and industry reports.</p>
            
            <form class="apex-reports-newsletter__form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
            </form>
            
            <p class="apex-reports-newsletter__note">Join 5,000+ subscribers. We respect your privacy.</p>
        </div>
    </div>
</section>

<?php get_footer(); ?>
