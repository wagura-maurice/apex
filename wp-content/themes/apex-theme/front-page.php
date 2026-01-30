<?php get_header(); ?>

<!-- Full-Screen Hero Section with Blurred Background Carousel -->
<section class="apex-hero-fullscreen" data-hero-carousel-container>
    <!-- Background Images Container -->
    <div class="apex-hero-bg-container">
        <!-- Slide 1 Background -->
        <div class="apex-hero-bg-slide active" data-bg-slide="0">
            <img 
                src="https://www.rediansoftware.com/wp-content/uploads/2025/12/digital-core-banking-sacco-platform-dashboard-east-west-africa-2048x1152.jpg" 
                alt="Digital Core Banking Platform" 
                class="apex-hero-bg-image"
            />
        </div>
        <!-- Slide 2 Background -->
        <div class="apex-hero-bg-slide" data-bg-slide="1">
            <img 
                src="https://i0.wp.com/fintech.rediansoftware.com/wp-content/uploads/2023/06/standard-quality-control-concept-m.jpg" 
                alt="Quality Digital Banking Experience" 
                class="apex-hero-bg-image"
            />
        </div>
        <!-- Slide 3 Background -->
        <div class="apex-hero-bg-slide" data-bg-slide="2">
            <img 
                src="https://i0.wp.com/fintech.rediansoftware.com/wp-content/uploads/2023/05/businessman-touch-cloud-computin-1.webp" 
                alt="Cloud Banking Solutions" 
                class="apex-hero-bg-image"
            />
        </div>
        <!-- Dark Overlay -->
        <div class="apex-hero-overlay"></div>
    </div>

    <!-- Hero Content -->
    <div class="apex-hero-content">
        <div class="apex-hero-content-inner">
            <!-- Tagline -->
            <p class="apex-hero-tagline" data-hero-content="tagline">
                <span class="apex-hero-tagline-dot"></span>
                ApexCore Platform
            </p>
            
            <!-- Main Heading - Changes with slides -->
            <h1 class="apex-hero-heading" data-hero-content="heading">
                <span class="apex-hero-heading-text active" data-heading-slide="0">
                    Launch Your Digital Bank of the Future
                </span>
                <span class="apex-hero-heading-text" data-heading-slide="1">
                    Omnichannel Banking Made Simple
                </span>
                <span class="apex-hero-heading-text" data-heading-slide="2">
                    Extend Your Reach with Agent Banking
                </span>
            </h1>
            
            <!-- Subheading - Changes with slides -->
            <p class="apex-hero-subheading">
                <span class="apex-hero-subheading-text active" data-subheading-slide="0">
                    Power your winning neobank strategy with ApexCore – the web-based, multi-tenant core banking platform built for MFIs, SACCOs, and banks.
                </span>
                <span class="apex-hero-subheading-text" data-subheading-slide="1">
                    Deliver mobile apps, USSD, and web banking experiences that share workflows, limits, and risk rules across every touchpoint.
                </span>
                <span class="apex-hero-subheading-text" data-subheading-slide="2">
                    Equip staff and agents with offline-ready apps for onboarding, KYC, collections, and monitoring—safely synced into your core.
                </span>
            </p>
            
            <!-- CTA Buttons -->
            <div class="apex-hero-cta-group">
                <a href="<?php echo esc_url(home_url('/request-demo')); ?>" class="apex-hero-cta-primary">
                    Explore the Platform
                </a>
                <a href="<?php echo esc_url(home_url('/solutions/overview')); ?>" class="apex-hero-cta-secondary">
                    View Solutions
                </a>
            </div>
            
            <!-- Carousel Navigation -->
            <div class="apex-hero-nav">
                <button type="button" class="apex-hero-nav-btn apex-hero-nav-prev" data-hero-prev aria-label="Previous slide">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="15 18 9 12 15 6"></polyline>
                    </svg>
                </button>
                <button type="button" class="apex-hero-nav-btn apex-hero-nav-next" data-hero-next aria-label="Next slide">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="9 18 15 12 9 6"></polyline>
                    </svg>
                </button>
            </div>
            
            <!-- Slide Indicators -->
            <div class="apex-hero-indicators">
                <button type="button" class="apex-hero-indicator active" data-hero-indicator="0" aria-label="Slide 1"></button>
                <button type="button" class="apex-hero-indicator" data-hero-indicator="1" aria-label="Slide 2"></button>
                <button type="button" class="apex-hero-indicator" data-hero-indicator="2" aria-label="Slide 3"></button>
            </div>
        </div>
    </div>
    
    <!-- Bottom Banner -->
    <div class="apex-hero-banner">
        <p>Apex Softwares' technology solutions impact <strong>100+ financial institutions</strong> across Africa. <a href="<?php echo esc_url(home_url('/about-us')); ?>">Learn More</a></p>
    </div>
</section>

<!-- Main Content after hero -->
<main id="site-main" class="flex-1">
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
        <div class="site-content clearfix">
            <?php if (have_posts()) :
                while (have_posts()) : the_post();
                    the_content();
                endwhile;
            else :
                echo '<p>No content found</p>';
            endif;
            ?>
        </div>
    </div>
</main>

<!-- Hero Carousel Styles -->
<style>
/* Full-Screen Hero Section */
.apex-hero-fullscreen {
    position: relative;
    width: 100%;
    height: 100vh;
    min-height: 600px;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    margin-top: 0 !important;
    padding-top: 0 !important;
}

/* Remove any spacing from closed containers */
body > .min-h-screen > main > div:empty,
body > div:empty {
    display: none;
}

/* Background Container */
.apex-hero-bg-container {
    position: absolute;
    inset: 0;
    z-index: 0;
}

/* Background Slides */
.apex-hero-bg-slide {
    position: absolute;
    inset: 0;
    opacity: 0;
    transition: opacity 1s ease-in-out;
}

.apex-hero-bg-slide.active {
    opacity: 1;
}

/* Background Images - Blurred */
.apex-hero-bg-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    object-position: center;
    filter: blur(4px);
    transform: scale(1.05);
}

/* Dark Overlay with Blue Tint (like softwaregroup.com) */
.apex-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        135deg,
        rgba(30, 58, 138, 0.85) 0%,
        rgba(30, 64, 175, 0.75) 50%,
        rgba(37, 99, 235, 0.7) 100%
    );
    z-index: 1;
}

/* Hero Content */
.apex-hero-content {
    position: relative;
    z-index: 10;
    flex: 1;
    display: flex;
    align-items: center;
    padding: 0 1.5rem;
    padding-top: 100px;
    padding-bottom: 2rem;
}

.apex-hero-content-inner {
    width: 100%;
    max-width: 700px;
    margin: 0;
    padding: 0;
}

/* Tagline */
.apex-hero-tagline {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.15em;
    color: #fed7aa;
    margin-bottom: 1rem;
}

.apex-hero-tagline-dot {
    width: 8px;
    height: 8px;
    background-color: #fa8b24;
    border-radius: 50%;
    animation: pulse-dot 2s infinite;
}

@keyframes pulse-dot {
    0%, 100% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.7; transform: scale(1.2); }
}

/* Main Heading */
.apex-hero-heading {
    position: relative;
    min-height: 220px;
    margin-bottom: 1.5rem;
}

.apex-hero-heading-text {
    position: absolute;
    top: 0;
    left: 0;
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
    color: #ffffff;
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.6s ease-out;
    max-width: 100%;
    width: 100%;
}

.apex-hero-heading-text.active {
    opacity: 1;
    transform: translateY(0);
}

/* Subheading */
.apex-hero-subheading {
    position: relative;
    min-height: 100px;
    margin-bottom: 2rem;
}

.apex-hero-subheading-text {
    position: absolute;
    top: 0;
    left: 0;
    font-size: 1.125rem;
    line-height: 1.6;
    color: rgba(255, 255, 255, 0.85);
    max-width: 100%;
    opacity: 0;
    transform: translateY(15px);
    transition: all 0.6s ease-out 0.1s;
}

.apex-hero-subheading-text.active {
    opacity: 1;
    transform: translateY(0);
}

/* CTA Buttons */
.apex-hero-cta-group {
    display: flex;
    flex-wrap: wrap;
    gap: 1rem;
    margin-bottom: 2.5rem;
}

.apex-hero-cta-primary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 1rem 2rem;
    font-size: 0.9375rem;
    font-weight: 600;
    color: #1e3a8a;
    background-color: #fa8b24;
    border-radius: 9999px;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 14px rgba(250, 139, 36, 0.4);
}

.apex-hero-cta-primary:hover {
    background-color: #f97316;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(250, 139, 36, 0.5);
    text-decoration: none;
    color: #ffffff;
}

.apex-hero-cta-secondary {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 1rem 2rem;
    font-size: 0.9375rem;
    font-weight: 600;
    color: #ffffff;
    background-color: transparent;
    border: 2px solid rgba(255, 255, 255, 0.4);
    border-radius: 9999px;
    text-decoration: none;
    transition: all 0.3s ease;
}

.apex-hero-cta-secondary:hover {
    background-color: rgba(255, 255, 255, 0.1);
    border-color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    color: #ffffff;
}

/* Navigation Arrows */
.apex-hero-nav {
    display: flex;
    gap: 0.75rem;
    margin-bottom: 2rem;
}

.apex-hero-nav-btn {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 48px;
    height: 48px;
    background-color: rgba(255, 255, 255, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    color: #ffffff;
    cursor: pointer;
    transition: all 0.3s ease;
}

.apex-hero-nav-btn:hover {
    background-color: rgba(255, 255, 255, 0.2);
    border-color: rgba(255, 255, 255, 0.5);
}

/* Slide Indicators */
.apex-hero-indicators {
    display: flex;
    gap: 0.5rem;
}

.apex-hero-indicator {
    width: 12px;
    height: 12px;
    background-color: rgba(255, 255, 255, 0.3);
    border: none;
    border-radius: 50%;
    cursor: pointer;
    transition: all 0.3s ease;
}

.apex-hero-indicator.active {
    background-color: #fa8b24;
    width: 32px;
    border-radius: 6px;
}

.apex-hero-indicator:hover:not(.active) {
    background-color: rgba(255, 255, 255, 0.5);
}

/* Bottom Banner */
.apex-hero-banner {
    position: relative;
    z-index: 10;
    background-color: #fa8b24;
    padding: 1rem 1.5rem;
    text-align: center;
}

.apex-hero-banner p {
    margin: 0;
    font-size: 0.9375rem;
    color: #1e3a8a;
}

.apex-hero-banner a {
    color: #1e3a8a;
    font-weight: 600;
    text-decoration: underline;
}

.apex-hero-banner a:hover {
    color: #1e40af;
}

/* Responsive Styles */
@media (min-width: 640px) {
    .apex-hero-content {
        padding: 0 3rem;
        padding-top: 100px;
    }
    
    .apex-hero-content-inner {
        max-width: 650px;
    }
    
    .apex-hero-heading {
        min-height: 160px;
    }
    
    .apex-hero-heading-text {
        font-size: 2.75rem;
    }
    
    .apex-hero-subheading {
        min-height: 90px;
    }
    
    .apex-hero-subheading-text {
        font-size: 1.125rem;
    }
}

@media (min-width: 768px) {
    .apex-hero-content {
        padding: 0 4rem;
        padding-top: 100px;
    }
    
    .apex-hero-content-inner {
        max-width: 700px;
    }
    
    .apex-hero-heading {
        min-height: 140px;
    }
    
    .apex-hero-heading-text {
        font-size: 3.25rem;
    }
    
    .apex-hero-subheading {
        min-height: 80px;
    }
    
    .apex-hero-subheading-text {
        font-size: 1.25rem;
    }
}

@media (min-width: 1024px) {
    .apex-hero-content {
        padding: 0 6rem;
        padding-top: 80px;
    }
    
    .apex-hero-content-inner {
        max-width: 750px;
    }
    
    .apex-hero-heading {
        min-height: 130px;
    }
    
    .apex-hero-heading-text {
        font-size: 3.75rem;
    }
    
    .apex-hero-subheading {
        min-height: 70px;
    }
    
    .apex-hero-subheading-text {
        font-size: 1.25rem;
    }
}

@media (min-width: 1280px) {
    .apex-hero-content {
        padding: 0 8rem;
    }
    
    .apex-hero-content-inner {
        max-width: 800px;
    }
    
    .apex-hero-heading {
        min-height: 120px;
    }
    
    .apex-hero-heading-text {
        font-size: 4rem;
    }
}

@media (min-width: 1536px) {
    .apex-hero-content {
        padding: 0 calc((100vw - 1280px) / 2 + 2rem);
    }
}
</style>

<!-- Hero Carousel JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.querySelector('[data-hero-carousel-container]');
    if (!container) return;
    
    const bgSlides = container.querySelectorAll('[data-bg-slide]');
    const headingSlides = container.querySelectorAll('[data-heading-slide]');
    const subheadingSlides = container.querySelectorAll('[data-subheading-slide]');
    const indicators = container.querySelectorAll('[data-hero-indicator]');
    const prevBtn = container.querySelector('[data-hero-prev]');
    const nextBtn = container.querySelector('[data-hero-next]');
    
    let currentSlide = 0;
    const totalSlides = bgSlides.length;
    let autoplayInterval;
    
    function goToSlide(index) {
        // Wrap around
        if (index < 0) index = totalSlides - 1;
        if (index >= totalSlides) index = 0;
        
        // Update background slides
        bgSlides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        
        // Update heading slides
        headingSlides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        
        // Update subheading slides
        subheadingSlides.forEach((slide, i) => {
            slide.classList.toggle('active', i === index);
        });
        
        // Update indicators
        indicators.forEach((indicator, i) => {
            indicator.classList.toggle('active', i === index);
        });
        
        currentSlide = index;
    }
    
    function nextSlide() {
        goToSlide(currentSlide + 1);
    }
    
    function prevSlide() {
        goToSlide(currentSlide - 1);
    }
    
    function startAutoplay() {
        autoplayInterval = setInterval(nextSlide, 5000);
    }
    
    function stopAutoplay() {
        clearInterval(autoplayInterval);
    }
    
    // Event listeners
    if (prevBtn) {
        prevBtn.addEventListener('click', () => {
            prevSlide();
            stopAutoplay();
            startAutoplay();
        });
    }
    
    if (nextBtn) {
        nextBtn.addEventListener('click', () => {
            nextSlide();
            stopAutoplay();
            startAutoplay();
        });
    }
    
    indicators.forEach((indicator, index) => {
        indicator.addEventListener('click', () => {
            goToSlide(index);
            stopAutoplay();
            startAutoplay();
        });
    });
    
    // Pause on hover
    container.addEventListener('mouseenter', stopAutoplay);
    container.addEventListener('mouseleave', startAutoplay);
    
    // Start autoplay
    startAutoplay();
});
</script>

<?php get_footer(); ?>