<?php 
/**
 * Template Name: Insights Success Stories
 * Success Stories / Case Studies Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Success Stories',
    'heading' => 'Real Results, Real Impact',
    'description' => 'Discover how financial institutions across Africa are transforming their operations, reaching more customers, and driving growth with Apex Softwares solutions.',
    'stats' => [
        ['value' => '100+', 'label' => 'Success Stories'],
        ['value' => '15+', 'label' => 'Countries'],
        ['value' => '40%', 'label' => 'Avg. Cost Reduction'],
        ['value' => '3x', 'label' => 'Customer Growth']
    ],
    'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=1200'
]);
?>

<section class="apex-stories-featured">
    <div class="apex-stories-featured__container">
        <div class="apex-stories-featured__header">
            <span class="apex-stories-featured__badge">Featured Story</span>
        </div>
        
        <div class="apex-stories-featured__card">
            <div class="apex-stories-featured__image">
                <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=800" alt="Kenya National SACCO" loading="lazy">
                <div class="apex-stories-featured__logo">
                    <span>Kenya National SACCO</span>
                </div>
            </div>
            <div class="apex-stories-featured__content">
                <span class="apex-stories-featured__category">SACCO</span>
                <h2 class="apex-stories-featured__title">How Kenya National SACCO Grew Membership by 300% with Digital Transformation</h2>
                <p class="apex-stories-featured__excerpt">Kenya National SACCO faced declining membership and high operational costs. By implementing ApexCore and our mobile banking solution, they transformed their member experience and achieved remarkable growth.</p>
                
                <div class="apex-stories-featured__results">
                    <div class="apex-stories-featured__result">
                        <span class="apex-stories-featured__result-value">300%</span>
                        <span class="apex-stories-featured__result-label">Membership Growth</span>
                    </div>
                    <div class="apex-stories-featured__result">
                        <span class="apex-stories-featured__result-value">65%</span>
                        <span class="apex-stories-featured__result-label">Cost Reduction</span>
                    </div>
                    <div class="apex-stories-featured__result">
                        <span class="apex-stories-featured__result-value">4.8/5</span>
                        <span class="apex-stories-featured__result-label">Member Satisfaction</span>
                    </div>
                </div>
                
                <a href="#" class="apex-stories-featured__link">
                    Read Full Case Study
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

<section class="apex-stories-filters">
    <div class="apex-stories-filters__container">
        <div class="apex-stories-filters__group">
            <label>Industry</label>
            <select>
                <option value="all">All Industries</option>
                <option value="sacco">SACCOs</option>
                <option value="mfi">Microfinance</option>
                <option value="bank">Commercial Banks</option>
                <option value="fintech">Fintechs</option>
            </select>
        </div>
        <div class="apex-stories-filters__group">
            <label>Region</label>
            <select>
                <option value="all">All Regions</option>
                <option value="east-africa">East Africa</option>
                <option value="west-africa">West Africa</option>
                <option value="southern-africa">Southern Africa</option>
                <option value="central-africa">Central Africa</option>
            </select>
        </div>
        <div class="apex-stories-filters__group">
            <label>Solution</label>
            <select>
                <option value="all">All Solutions</option>
                <option value="core-banking">Core Banking</option>
                <option value="mobile-banking">Mobile Banking</option>
                <option value="agent-banking">Agent Banking</option>
                <option value="digital-lending">Digital Lending</option>
            </select>
        </div>
    </div>
</section>

<section class="apex-stories-grid">
    <div class="apex-stories-grid__container">
        <div class="apex-stories-grid__items">
            <article class="apex-stories-grid__item">
                <div class="apex-stories-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?w=400" alt="Umoja MFI" loading="lazy">
                    <span class="apex-stories-grid__item-tag">Microfinance</span>
                </div>
                <div class="apex-stories-grid__item-content">
                    <div class="apex-stories-grid__item-header">
                        <span class="apex-stories-grid__item-company">Umoja Microfinance</span>
                        <span class="apex-stories-grid__item-location">Tanzania</span>
                    </div>
                    <h3>Scaling Microloans to 500,000 Customers with Automated Lending</h3>
                    <p>Umoja MFI leveraged our digital lending platform to automate loan processing and reach half a million customers across Tanzania.</p>
                    <div class="apex-stories-grid__item-stats">
                        <div>
                            <strong>500K</strong>
                            <span>Customers Served</span>
                        </div>
                        <div>
                            <strong>90%</strong>
                            <span>Faster Processing</span>
                        </div>
                    </div>
                    <a href="#">Read Story →</a>
                </div>
            </article>
            
            <article class="apex-stories-grid__item">
                <div class="apex-stories-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1563986768609-322da13575f3?w=400" alt="Unity Bank" loading="lazy">
                    <span class="apex-stories-grid__item-tag">Commercial Bank</span>
                </div>
                <div class="apex-stories-grid__item-content">
                    <div class="apex-stories-grid__item-header">
                        <span class="apex-stories-grid__item-company">Unity Bank Nigeria</span>
                        <span class="apex-stories-grid__item-location">Nigeria</span>
                    </div>
                    <h3>Modernizing Legacy Systems: A Core Banking Transformation Journey</h3>
                    <p>Unity Bank replaced their 15-year-old core system with ApexCore, achieving seamless migration and improved performance.</p>
                    <div class="apex-stories-grid__item-stats">
                        <div>
                            <strong>Zero</strong>
                            <span>Downtime Migration</span>
                        </div>
                        <div>
                            <strong>10x</strong>
                            <span>Faster Transactions</span>
                        </div>
                    </div>
                    <a href="#">Read Story →</a>
                </div>
            </article>
            
            <article class="apex-stories-grid__item">
                <div class="apex-stories-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?w=400" alt="Farmers SACCO" loading="lazy">
                    <span class="apex-stories-grid__item-tag">SACCO</span>
                </div>
                <div class="apex-stories-grid__item-content">
                    <div class="apex-stories-grid__item-header">
                        <span class="apex-stories-grid__item-company">Farmers Cooperative SACCO</span>
                        <span class="apex-stories-grid__item-location">Uganda</span>
                    </div>
                    <h3>Bringing Banking to Rural Farmers Through Agent Networks</h3>
                    <p>Farmers SACCO deployed 200+ agents across rural Uganda, bringing financial services to previously unbanked agricultural communities.</p>
                    <div class="apex-stories-grid__item-stats">
                        <div>
                            <strong>200+</strong>
                            <span>Active Agents</span>
                        </div>
                        <div>
                            <strong>50K</strong>
                            <span>New Members</span>
                        </div>
                    </div>
                    <a href="#">Read Story →</a>
                </div>
            </article>
            
            <article class="apex-stories-grid__item">
                <div class="apex-stories-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=400" alt="PayFast" loading="lazy">
                    <span class="apex-stories-grid__item-tag">Fintech</span>
                </div>
                <div class="apex-stories-grid__item-content">
                    <div class="apex-stories-grid__item-header">
                        <span class="apex-stories-grid__item-company">PayFast Ghana</span>
                        <span class="apex-stories-grid__item-location">Ghana</span>
                    </div>
                    <h3>Building a Mobile-First Payment Platform from the Ground Up</h3>
                    <p>PayFast used our API platform to launch a mobile payment service that now processes over 1 million transactions monthly.</p>
                    <div class="apex-stories-grid__item-stats">
                        <div>
                            <strong>1M+</strong>
                            <span>Monthly Transactions</span>
                        </div>
                        <div>
                            <strong>99.99%</strong>
                            <span>Uptime</span>
                        </div>
                    </div>
                    <a href="#">Read Story →</a>
                </div>
            </article>
            
            <article class="apex-stories-grid__item">
                <div class="apex-stories-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1551836022-d5d88e9218df?w=400" alt="Teachers SACCO" loading="lazy">
                    <span class="apex-stories-grid__item-tag">SACCO</span>
                </div>
                <div class="apex-stories-grid__item-content">
                    <div class="apex-stories-grid__item-header">
                        <span class="apex-stories-grid__item-company">Teachers Savings SACCO</span>
                        <span class="apex-stories-grid__item-location">Rwanda</span>
                    </div>
                    <h3>Digitizing Member Services for 100,000 Educators</h3>
                    <p>Teachers SACCO transformed their member experience with a mobile app that enables savings, loans, and payments on the go.</p>
                    <div class="apex-stories-grid__item-stats">
                        <div>
                            <strong>100K</strong>
                            <span>Active Members</span>
                        </div>
                        <div>
                            <strong>85%</strong>
                            <span>Mobile Adoption</span>
                        </div>
                    </div>
                    <a href="#">Read Story →</a>
                </div>
            </article>
            
            <article class="apex-stories-grid__item">
                <div class="apex-stories-grid__item-image">
                    <img src="https://images.unsplash.com/photo-1560472354-b33ff0c44a43?w=400" alt="Metro Finance" loading="lazy">
                    <span class="apex-stories-grid__item-tag">Microfinance</span>
                </div>
                <div class="apex-stories-grid__item-content">
                    <div class="apex-stories-grid__item-header">
                        <span class="apex-stories-grid__item-company">Metro Finance</span>
                        <span class="apex-stories-grid__item-location">South Africa</span>
                    </div>
                    <h3>Reducing Loan Default Rates with AI-Powered Credit Scoring</h3>
                    <p>Metro Finance implemented our AI credit scoring module, dramatically reducing defaults while expanding lending to underserved segments.</p>
                    <div class="apex-stories-grid__item-stats">
                        <div>
                            <strong>45%</strong>
                            <span>Lower Defaults</span>
                        </div>
                        <div>
                            <strong>2x</strong>
                            <span>Loan Portfolio</span>
                        </div>
                    </div>
                    <a href="#">Read Story →</a>
                </div>
            </article>
        </div>
        
        <div class="apex-stories-grid__load-more">
            <button class="apex-stories-grid__load-btn">Load More Stories</button>
        </div>
    </div>
</section>

<section class="apex-stories-testimonials">
    <div class="apex-stories-testimonials__container">
        <div class="apex-stories-testimonials__header">
            <span class="apex-stories-testimonials__badge">Client Testimonials</span>
            <h2 class="apex-stories-testimonials__heading">What Our Clients Say</h2>
        </div>
        
        <div class="apex-stories-testimonials__grid">
            <div class="apex-stories-testimonials__item">
                <div class="apex-stories-testimonials__quote">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                </div>
                <p>"Apex Softwares didn't just give us software—they gave us a partner in our digital transformation journey. Their team understood our unique challenges as a SACCO and delivered solutions that truly work for our members."</p>
                <div class="apex-stories-testimonials__author">
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=100" alt="James Mwangi">
                    <div>
                        <strong>James Mwangi</strong>
                        <span>CEO, Kenya National SACCO</span>
                    </div>
                </div>
            </div>
            
            <div class="apex-stories-testimonials__item">
                <div class="apex-stories-testimonials__quote">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                </div>
                <p>"The migration from our legacy system was seamless. We expected months of disruption, but Apex delivered a smooth transition with zero downtime. Our customers didn't even notice the change—except that everything got faster."</p>
                <div class="apex-stories-testimonials__author">
                    <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=100" alt="Amina Okafor">
                    <div>
                        <strong>Amina Okafor</strong>
                        <span>CTO, Unity Bank Nigeria</span>
                    </div>
                </div>
            </div>
            
            <div class="apex-stories-testimonials__item">
                <div class="apex-stories-testimonials__quote">
                    <svg viewBox="0 0 24 24" fill="currentColor"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                </div>
                <p>"With Apex's agent banking solution, we've been able to reach farmers in the most remote areas of Uganda. Financial inclusion isn't just a buzzword for us anymore—it's our reality."</p>
                <div class="apex-stories-testimonials__author">
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=100" alt="David Okello">
                    <div>
                        <strong>David Okello</strong>
                        <span>Managing Director, Farmers SACCO</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="apex-stories-impact">
    <div class="apex-stories-impact__container">
        <div class="apex-stories-impact__header">
            <span class="apex-stories-impact__badge">Our Impact</span>
            <h2 class="apex-stories-impact__heading">Driving Financial Inclusion Across Africa</h2>
            <p class="apex-stories-impact__description">Together with our clients, we're making a measurable difference in communities across the continent.</p>
        </div>
        
        <div class="apex-stories-impact__grid">
            <div class="apex-stories-impact__item">
                <span class="apex-stories-impact__value">10M+</span>
                <span class="apex-stories-impact__label">End Users Served</span>
            </div>
            <div class="apex-stories-impact__item">
                <span class="apex-stories-impact__value">$5B+</span>
                <span class="apex-stories-impact__label">Transactions Processed</span>
            </div>
            <div class="apex-stories-impact__item">
                <span class="apex-stories-impact__value">2M+</span>
                <span class="apex-stories-impact__label">Previously Unbanked Reached</span>
            </div>
            <div class="apex-stories-impact__item">
                <span class="apex-stories-impact__value">500K+</span>
                <span class="apex-stories-impact__label">Small Businesses Empowered</span>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
