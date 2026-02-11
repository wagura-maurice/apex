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

<section class="apex-news-featured">
    <div class="apex-news-featured__container">
        <div class="apex-news-featured__header">
            <span class="apex-news-featured__badge">Featured Story</span>
        </div>
        
        <div class="apex-news-featured__card">
            <div class="apex-news-featured__image">
                <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=800" alt="ApexCore 3.0 Launch" loading="lazy">
                <span class="apex-news-featured__category">Product Launch</span>
            </div>
            <div class="apex-news-featured__content">
                <span class="apex-news-featured__date">January 15, 2026</span>
                <h2 class="apex-news-featured__title">Apex Softwares Launches ApexCore 3.0: The Next Generation of Core Banking</h2>
                <p class="apex-news-featured__excerpt">We're excited to announce the launch of ApexCore 3.0, our most advanced core banking platform yet. This major release introduces cloud-native architecture, AI-powered analytics, and enhanced API capabilities that will transform how financial institutions operate.</p>
                <p class="apex-news-featured__excerpt">Key highlights include 10x faster transaction processing, real-time fraud detection, and a completely redesigned user interface that reduces training time by 60%.</p>
                <a href="#" class="apex-news-featured__link">
                    Read Full Announcement
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="apex-news-grid">
    <div class="apex-news-grid__container">
        <div class="apex-news-grid__header">
            <h2 class="apex-news-grid__heading">Recent News</h2>
            <div class="apex-news-grid__filters">
                <button class="apex-news-grid__filter active" data-filter="all">All</button>
                <button class="apex-news-grid__filter" data-filter="product">Product</button>
                <button class="apex-news-grid__filter" data-filter="company">Company</button>
                <button class="apex-news-grid__filter" data-filter="industry">Industry</button>
            </div>
        </div>
        
        <div class="apex-news-grid__items">
            <article class="apex-news-grid__item" data-category="company">
                <div class="apex-news-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400" alt="Series B Funding" loading="lazy">
                </div>
                <div class="apex-news-grid__item-content">
                    <span class="apex-news-grid__item-category">Company News</span>
                    <span class="apex-news-grid__item-date">January 8, 2026</span>
                    <h3>Apex Softwares Raises $25M Series B to Accelerate Pan-African Expansion</h3>
                    <p>Investment led by TLcom Capital will fuel expansion into West and Southern Africa, with plans to double the team by end of 2026.</p>
                    <a href="#">Read More →</a>
                </div>
            </article>
            
            <article class="apex-news-grid__item" data-category="product">
                <div class="apex-news-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=400" alt="Mobile Banking Update" loading="lazy">
                </div>
                <div class="apex-news-grid__item-content">
                    <span class="apex-news-grid__item-category">Product Update</span>
                    <span class="apex-news-grid__item-date">December 20, 2025</span>
                    <h3>New Mobile Banking Features: Biometric Authentication and Instant Loans</h3>
                    <p>Our latest mobile banking update introduces fingerprint and face ID authentication, plus instant loan disbursement in under 60 seconds.</p>
                    <a href="#">Read More →</a>
                </div>
            </article>
            
            <article class="apex-news-grid__item" data-category="industry">
                <div class="apex-news-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=400" alt="Financial Inclusion Report" loading="lazy">
                </div>
                <div class="apex-news-grid__item-content">
                    <span class="apex-news-grid__item-category">Industry Insight</span>
                    <span class="apex-news-grid__item-date">December 15, 2025</span>
                    <h3>2025 African Financial Inclusion Report: Key Trends and Opportunities</h3>
                    <p>Our annual report analyzes the state of financial inclusion across Africa, highlighting the role of technology in reaching the unbanked.</p>
                    <a href="#">Read More →</a>
                </div>
            </article>
            
            <article class="apex-news-grid__item" data-category="company">
                <div class="apex-news-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1540575467063-178a50c2df87?w=400" alt="Fintech Awards" loading="lazy">
                </div>
                <div class="apex-news-grid__item-content">
                    <span class="apex-news-grid__item-category">Awards</span>
                    <span class="apex-news-grid__item-date">November 28, 2025</span>
                    <h3>Apex Softwares Wins "Best Core Banking Provider" at Africa Fintech Awards</h3>
                    <p>Recognition for innovation and impact in transforming financial services across the continent.</p>
                    <a href="#">Read More →</a>
                </div>
            </article>
            
            <article class="apex-news-grid__item" data-category="product">
                <div class="apex-news-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400" alt="API Marketplace" loading="lazy">
                </div>
                <div class="apex-news-grid__item-content">
                    <span class="apex-news-grid__item-category">Product Launch</span>
                    <span class="apex-news-grid__item-date">November 15, 2025</span>
                    <h3>Introducing ApexConnect: Our New API Marketplace for Third-Party Integrations</h3>
                    <p>Connect with 50+ pre-built integrations including payment gateways, credit bureaus, and KYC providers.</p>
                    <a href="#">Read More →</a>
                </div>
            </article>
            
            <article class="apex-news-grid__item" data-category="company">
                <div class="apex-news-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400" alt="Nigeria Office" loading="lazy">
                </div>
                <div class="apex-news-grid__item-content">
                    <span class="apex-news-grid__item-category">Expansion</span>
                    <span class="apex-news-grid__item-date">November 1, 2025</span>
                    <h3>Apex Softwares Opens New Office in Lagos to Serve West African Market</h3>
                    <p>Strategic expansion to better serve our growing client base in Nigeria, Ghana, and across West Africa.</p>
                    <a href="#">Read More →</a>
                </div>
            </article>
        </div>
        
        <div class="apex-news-grid__load-more">
            <a href="<?php echo home_url('/insights/blog'); ?>" class="apex-news-grid__load-btn">Load More Articles</a>
        </div>
    </div>
</section>

<section class="apex-news-press">
    <div class="apex-news-press__container">
        <div class="apex-news-press__header">
            <h2 class="apex-news-press__heading">In the Press</h2>
            <p class="apex-news-press__description">What leading publications are saying about Apex Softwares</p>
        </div>
        
        <div class="apex-news-press__grid">
            <div class="apex-news-press__item">
                <div class="apex-news-press__logo">
                    <span>TechCrunch</span>
                </div>
                <blockquote>"Apex Softwares is quietly becoming the Stripe of African banking infrastructure."</blockquote>
                <a href="#">Read Article →</a>
            </div>
            
            <div class="apex-news-press__item">
                <div class="apex-news-press__logo">
                    <span>Bloomberg</span>
                </div>
                <blockquote>"The Kenyan fintech is powering a digital banking revolution across the continent."</blockquote>
                <a href="#">Read Article →</a>
            </div>
            
            <div class="apex-news-press__item">
                <div class="apex-news-press__logo">
                    <span>Forbes Africa</span>
                </div>
                <blockquote>"One of Africa's most promising B2B fintech companies, enabling financial inclusion at scale."</blockquote>
                <a href="#">Read Article →</a>
            </div>
            
            <div class="apex-news-press__item">
                <div class="apex-news-press__logo">
                    <span>Quartz Africa</span>
                </div>
                <blockquote>"Apex's technology is helping SACCOs and MFIs compete with traditional banks."</blockquote>
                <a href="#">Read Article →</a>
            </div>
        </div>
    </div>
</section>

<section class="apex-news-newsletter">
    <div class="apex-news-newsletter__container">
        <div class="apex-news-newsletter__content">
            <h2 class="apex-news-newsletter__heading">Stay Updated</h2>
            <p class="apex-news-newsletter__description">Subscribe to our newsletter for the latest news, product updates, and industry insights delivered to your inbox.</p>
            
            <form class="apex-news-newsletter__form">
                <input type="email" placeholder="Enter your email address" required>
                <button type="submit">Subscribe</button>
            </form>
            
            <p class="apex-news-newsletter__note">By subscribing, you agree to our Privacy Policy. Unsubscribe at any time.</p>
        </div>
    </div>
</section>

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
