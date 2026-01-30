<?php 
/**
 * Template Name: Careers
 * Careers Page Template
 * 
 * @package ApexTheme
 */

get_header(); 
?>

<?php 
// Page Hero
apex_render_about_hero([
    'badge' => 'Join Our Team',
    'heading' => 'Build the Future of African Fintech',
    'description' => 'Join a team of passionate innovators transforming financial services across Africa. We\'re looking for talented individuals who want to make an impact.',
    'stats' => [
        ['value' => '50+', 'label' => 'Team Members'],
        ['value' => '15+', 'label' => 'Countries'],
        ['value' => '4.5/5', 'label' => 'Glassdoor Rating'],
        ['value' => '100%', 'label' => 'Remote Options']
    ],
    'image' => 'https://images.unsplash.com/photo-1522071820081-009f0129c71c?w=1200'
]);
?>

<section class="apex-careers-why">
    <div class="apex-careers-why__container">
        <div class="apex-careers-why__header">
            <h2 class="apex-careers-why__heading">Why Work at Apex?</h2>
            <p class="apex-careers-why__description">We're not just building software—we're building the future of financial services in Africa.</p>
        </div>
        
        <div class="apex-careers-why__grid">
            <div class="apex-careers-why__item">
                <div class="apex-careers-why__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <h3>Impactful Work</h3>
                <p>Build solutions that help millions access financial services and improve lives across Africa.</p>
            </div>
            
            <div class="apex-careers-why__item">
                <div class="apex-careers-why__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M2 12h20M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                </div>
                <h3>Global Impact</h3>
                <p>Work with clients across 15+ African countries and see your work make a real difference.</p>
            </div>
            
            <div class="apex-careers-why__item">
                <div class="apex-careers-why__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3>Growth & Learning</h3>
                <p>Continuous learning opportunities, mentorship, and career growth paths.</p>
            </div>
            
            <div class="apex-careers-why__item">
                <div class="apex-careers-why__icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><path d="M9 12l2 2 4-4"/></svg>
                </div>
                <h3>Competitive Benefits</h3>
                <p>Competitive salary, equity, health insurance, and flexible work arrangements.</p>
            </div>
        </div>
    </div>
</section>

<section class="apex-careers-openings">
    <div class="apex-careers-openings__container">
        <div class="apex-careers-openings__header">
            <h2 class="apex-careers-openings__heading">Open Positions</h2>
            <p class="apex-careers-openings__description">Find your next opportunity</p>
        </div>
        
        <div class="apex-careers-openings__list">
            <div class="apex-careers-openings__item">
                <div class="apex-careers-openings__item-content">
                    <h3>Senior Full-Stack Developer</h3>
                    <div class="apex-careers-openings__meta">
                        <span class="apex-careers-openings__location">Nairobi, Kenya (Remote)</span>
                        <span class="apex-careers-openings__type">Full-time</span>
                    </div>
                    <p>We're looking for an experienced developer to help build our next-generation core banking platform.</p>
                    <div class="apex-careers-openings__tags">
                        <span>PHP</span>
                        <span>React</span>
                        <span>PostgreSQL</span>
                    </div>
                </div>
                <a href="#" class="apex-careers-openings__apply">Apply Now →</a>
            </div>
            
            <div class="apex-careers-openings__item">
                <div class="apex-careers-openings__item-content">
                    <h3>Mobile Developer (iOS/Android)</h3>
                    <div class="apex-careers-openings__meta">
                        <span class="apex-careers-openings__location">Lagos, Nigeria (Remote)</span>
                        <span class="apex-careers-openings__type">Full-time</span>
                    </div>
                    <p>Build beautiful mobile banking experiences that work even in low-connectivity areas.</p>
                    <div class="apex-careers-openings__tags">
                        <span>React Native</span>
                        <span>TypeScript</span>
                        <span>Mobile</span>
                    </div>
                </div>
                <a href="#" class="apex-careers-openings__apply">Apply Now →</a>
            </div>
            
            <div class="apex-careers-openings__item">
                <div class="apex-careers-openings__item-content">
                    <h3>Product Manager</h3>
                    <div class="apex-careers-openings__meta">
                        <span class="apex-careers-openings__location">Nairobi, Kenya</span>
                        <span class="apex-careers-openings__type">Full-time</span>
                    </div>
                    <p>Drive product strategy and work with cross-functional teams to deliver exceptional fintech products.</p>
                    <div class="apex-careers-openings__tags">
                        <span>Product</span>
                        <span>Strategy</span>
                        <span>Agile</span>
                    </div>
                </div>
                <a href="#" class="apex-careers-openings__apply">Apply Now →</a>
            </div>
            
            <div class="apex-careers-openings__item">
                <div class="apex-careers-openings__item-content">
                    <h3>DevOps Engineer</h3>
                    <div class="apex-careers-openings__meta">
                        <span class="apex-careers-openings__location">Remote</span>
                        <span class="apex-careers-openings__type">Full-time</span>
                    </div>
                    <p>Build and maintain our cloud infrastructure ensuring 99.99% uptime for critical banking systems.</p>
                    <div class="apex-careers-openings__tags">
                        <span>AWS</span>
                        <span>Kubernetes</span>
                        <span>CI/CD</span>
                    </div>
                </div>
                <a href="#" class="apex-careers-openings__apply">Apply Now →</a>
            </div>
        </div>
    </div>
</section>

<section class="apex-careers-culture">
    <div class="apex-careers-culture__container">
        <div class="apex-careers-culture__header">
            <h2 class="apex-careers-culture__heading">Our Culture</h2>
            <p class="apex-careers-culture__description">We believe in creating an environment where everyone can thrive</p>
        </div>
        
        <div class="apex-careers-culture__grid">
            <div class="apex-careers-culture__item">
                <h3>Diversity & Inclusion</h3>
                <p>We celebrate diverse backgrounds and perspectives. Our team represents 10+ African countries.</p>
            </div>
            <div class="apex-careers-culture__item">
                <h3>Work-Life Balance</h3>
                <p>Flexible hours, remote work options, and generous time off policies.</p>
            </div>
            <div class="apex-careers-culture__item">
                <h3>Continuous Learning</h3>
                <p>Learning budget, conference attendance, and internal knowledge sharing sessions.</p>
            </div>
            <div class="apex-careers-culture__item">
                <h3>Transparency</h3>
                <p>Open communication, regular town halls, and access to leadership.</p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>
