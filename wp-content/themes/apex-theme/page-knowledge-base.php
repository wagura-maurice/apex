<?php 
/**
 * Template Name: Knowledge Base
 * Knowledge Base Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Knowledge Base',
    'heading' => 'Comprehensive Documentation & Guides',
    'description' => 'Find detailed guides, tutorials, and documentation to help you get the most out of our products.',
    'stats' => [
        ['value' => '200+', 'label' => 'Articles'],
        ['value' => '50+', 'label' => 'Video Tutorials'],
        ['value' => '100%', 'label' => 'Searchable'],
        ['value' => '24/7', 'label' => 'Access']
    ],
    'image' => 'https://images.unsplash.com/photo-1531403009284-440f080d1e12?w=1200'
]);
?>

<section class="apex-kb-search">
    <div class="apex-kb-search__container">
        <div class="apex-kb-search__header">
            <h2 class="apex-kb-search__heading">Search Our Knowledge Base</h2>
            <p class="apex-kb-search__description">Find answers to your questions quickly</p>
        </div>
        
        <div class="apex-kb-search__form">
            <input type="text" placeholder="Search for articles, guides, tutorials..." class="apex-kb-search__input">
            <button type="submit" class="apex-kb-search__button">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                Search
            </button>
        </div>
        
        <div class="apex-kb-search__suggestions">
            <span>Popular searches:</span>
            <a href="#">Getting started</a>
            <a href="#">Mobile banking setup</a>
            <a href="#">API integration</a>
            <a href="#">Security settings</a>
        </div>
    </div>
</section>

<section class="apex-kb-categories">
    <div class="apex-kb-categories__container">
        <div class="apex-kb-categories__header">
            <h2 class="apex-kb-categories__heading">Browse by Category</h2>
        </div>
        
        <div class="apex-kb-categories__grid">
            <a href="#" class="apex-kb-categories__card">
                <div class="apex-kb-categories__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <h3>Getting Started</h3>
                <p>Quick start guides and onboarding documentation</p>
                <span class="apex-kb-categories__card-count">25 articles</span>
            </a>
            
            <a href="#" class="apex-kb-categories__card">
                <div class="apex-kb-categories__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8M12 17v4"/></svg>
                </div>
                <h3>Core Banking</h3>
                <p>Comprehensive guides for ApexCore platform</p>
                <span class="apex-kb-categories__card-count">45 articles</span>
            </a>
            
            <a href="#" class="apex-kb-categories__card">
                <div class="apex-kb-categories__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
                </div>
                <h3>Mobile Banking</h3>
                <p>Mobile app setup and configuration guides</p>
                <span class="apex-kb-categories__card-count">38 articles</span>
            </a>
            
            <a href="#" class="apex-kb-categories__card">
                <div class="apex-kb-categories__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Agent Banking</h3>
                <p>Agent network setup and management</p>
                <span class="apex-kb-categories__card-count">22 articles</span>
            </a>
            
            <a href="#" class="apex-kb-categories__card">
                <div class="apex-kb-categories__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                </div>
                <h3>Security</h3>
                <p>Security configuration and best practices</p>
                <span class="apex-kb-categories__card-count">18 articles</span>
            </a>
            
            <a href="#" class="apex-kb-categories__card">
                <div class="apex-kb-categories__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <h3>Integrations</h3>
                <p>API documentation and integration guides</p>
                <span class="apex-kb-categories__card-count">32 articles</span>
            </a>
            
            <a href="#" class="apex-kb-categories__card">
                <div class="apex-kb-categories__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                </div>
                <h3>Reports</h3>
                <p>Reporting and analytics configuration</p>
                <span class="apex-kb-categories__card-count">15 articles</span>
            </a>
            
            <a href="#" class="apex-kb-categories__card">
                <div class="apex-kb-categories__card-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3>Billing</h3>
                <p>Account management and billing guides</p>
                <span class="apex-kb-categories__card-count">8 articles</span>
            </a>
        </div>
    </div>
</section>

<section class="apex-kb-articles">
    <div class="apex-kb-articles__container">
        <div class="apex-kb-articles__header">
            <h2 class="apex-kb-articles__heading">Popular Articles</h2>
            <p class="apex-kb-articles__description">Most viewed articles this week</p>
        </div>
        
        <div class="apex-kb-articles__list">
            <a href="#" class="apex-kb-articles__item">
                <div class="apex-kb-articles__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                </div>
                <div class="apex-kb-articles__item-content">
                    <h3>Getting Started with ApexCore</h3>
                    <p>A comprehensive guide to setting up your core banking platform</p>
                    <span class="apex-kb-articles__item-meta">Getting Started • 15 min read</span>
                </div>
                <span class="apex-kb-articles__item-arrow">→</span>
            </a>
            
            <a href="#" class="apex-kb-articles__item">
                <div class="apex-kb-articles__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="5" y="2" width="14" height="20" rx="2"/><path d="M12 18h.01"/></svg>
                </div>
                <div class="apex-kb-articles__item-content">
                    <h3>Configuring Mobile Banking App</h3>
                    <p>Step-by-step guide to customize your mobile banking experience</p>
                    <span class="apex-kb-articles__item-meta">Mobile Banking • 12 min read</span>
                </div>
                <span class="apex-kb-articles__item-arrow">→</span>
            </a>
            
            <a href="#" class="apex-kb-articles__item">
                <div class="apex-kb-articles__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                </div>
                <div class="apex-kb-articles__item-content">
                    <h3>Security Best Practices</h3>
                    <p>Essential security configurations for your platform</p>
                    <span class="apex-kb-articles__item-meta">Security • 10 min read</span>
                </div>
                <span class="apex-kb-articles__item-arrow">→</span>
            </a>
            
            <a href="#" class="apex-kb-articles__item">
                <div class="apex-kb-articles__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
                </div>
                <div class="apex-kb-articles__item-content">
                    <h3>API Integration Guide</h3>
                    <p>How to integrate your systems with our APIs</p>
                    <span class="apex-kb-articles__item-meta">Integrations • 20 min read</span>
                </div>
                <span class="apex-kb-articles__item-arrow">→</span>
            </a>
            
            <a href="#" class="apex-kb-articles__item">
                <div class="apex-kb-articles__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <div class="apex-kb-articles__item-content">
                    <h3>Setting Up Agent Banking</h3>
                    <p>Complete guide to deploying your agent network</p>
                    <span class="apex-kb-articles__item-meta">Agent Banking • 18 min read</span>
                </div>
                <span class="apex-kb-articles__item-arrow">→</span>
            </a>
            
            <a href="#" class="apex-kb-articles__item">
                <div class="apex-kb-articles__item-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6M16 13H8M16 17H8M10 9H8"/></svg>
                </div>
                <div class="apex-kb-articles__item-content">
                    <h3>Creating Custom Reports</h3>
                    <p>Build custom reports to meet your regulatory requirements</p>
                    <span class="apex-kb-articles__item-meta">Reports • 14 min read</span>
                </div>
                <span class="apex-kb-articles__item-arrow">→</span>
            </a>
        </div>
    </div>
</section>

<section class="apex-kb-videos">
    <div class="apex-kb-videos__container">
        <div class="apex-kb-videos__header">
            <h2 class="apex-kb-videos__heading">Video Tutorials</h2>
            <p class="apex-kb-videos__description">Learn visually with our video guides</p>
        </div>
        
        <div class="apex-kb-videos__grid">
            <a href="#" class="apex-kb-videos__item">
                <div class="apex-kb-videos__item-thumbnail">
                    <img src="https://images.unsplash.com/photo-1556761175-5973dc0f32e7?w=400" alt="Video thumbnail">
                    <div class="apex-kb-videos__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <h3>Platform Overview</h3>
                <span>5:32</span>
            </a>
            
            <a href="#" class="apex-kb-videos__item">
                <div class="apex-kb-videos__item-thumbnail">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400" alt="Video thumbnail">
                    <div class="apex-kb-videos__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <h3>User Management</h3>
                <span>8:15</span>
            </a>
            
            <a href="#" class="apex-kb-videos__item">
                <div class="apex-kb-videos__item-thumbnail">
                    <img src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=400" alt="Video thumbnail">
                    <div class="apex-kb-videos__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <h3>Product Configuration</h3>
                <span>12:45</span>
            </a>
            
            <a href="#" class="apex-kb-videos__item">
                <div class="apex-kb-videos__item-thumbnail">
                    <img src="https://images.unsplash.com/photo-1551434678-e076c223a692?w=400" alt="Video thumbnail">
                    <div class="apex-kb-videos__item-play">
                        <svg viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
                    </div>
                </div>
                <h3>Reporting Dashboard</h3>
                <span>6:20</span>
            </a>
        </div>
    </div>
</section>


<?php get_footer(); ?>
