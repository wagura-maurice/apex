/**
 * Hero Component JavaScript
 * Carousel functionality with autoplay and touch support
 * 
 * @package ApexTheme
 * @subpackage Components/Hero
 */

(function() {
    'use strict';
    
    class ApexHeroCarousel {
        constructor(element) {
            this.container = element;
            this.slides = element.querySelectorAll('[data-slide]');
            this.headings = element.querySelectorAll('[data-heading]');
            this.subheadings = element.querySelectorAll('[data-subheading]');
            this.indicators = element.querySelectorAll('[data-indicator]');
            this.prevBtn = element.querySelector('[data-hero-prev]');
            this.nextBtn = element.querySelector('[data-hero-next]');
            
            this.currentSlide = 0;
            this.totalSlides = this.slides.length;
            this.autoplayInterval = null;
            this.autoplayDelay = 6000;
            this.isAnimating = false;
            
            this.init();
        }
        
        init() {
            this.bindEvents();
            this.startAutoplay();
            this.setupKeyboardNav();
            this.setupTouchEvents();
        }
        
        bindEvents() {
            if (this.prevBtn) {
                this.prevBtn.addEventListener('click', () => this.prev());
            }
            
            if (this.nextBtn) {
                this.nextBtn.addEventListener('click', () => this.next());
            }
            
            this.indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => this.goTo(index));
            });
            
            this.container.addEventListener('mouseenter', () => this.pauseAutoplay());
            this.container.addEventListener('mouseleave', () => this.startAutoplay());
            this.container.addEventListener('focusin', () => this.pauseAutoplay());
            this.container.addEventListener('focusout', () => this.startAutoplay());
        }
        
        setupKeyboardNav() {
            this.container.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    this.prev();
                } else if (e.key === 'ArrowRight') {
                    this.next();
                }
            });
        }
        
        setupTouchEvents() {
            let touchStartX = 0;
            let touchEndX = 0;
            
            this.container.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });
            
            this.container.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                this.handleSwipe(touchStartX, touchEndX);
            }, { passive: true });
        }
        
        handleSwipe(startX, endX) {
            const threshold = 50;
            const diff = startX - endX;
            
            if (Math.abs(diff) > threshold) {
                if (diff > 0) {
                    this.next();
                } else {
                    this.prev();
                }
            }
        }
        
        goTo(index) {
            if (this.isAnimating || index === this.currentSlide) return;
            
            this.isAnimating = true;
            
            // Update slides
            this.slides.forEach((slide, i) => {
                slide.classList.toggle('is-active', i === index);
            });
            
            // Update headings
            this.headings.forEach((heading, i) => {
                heading.classList.toggle('is-active', i === index);
            });
            
            // Update subheadings
            this.subheadings.forEach((subheading, i) => {
                subheading.classList.toggle('is-active', i === index);
            });
            
            // Update indicators
            this.indicators.forEach((indicator, i) => {
                indicator.classList.toggle('is-active', i === index);
            });
            
            this.currentSlide = index;
            
            // Reset autoplay
            this.resetAutoplay();
            
            // Allow next animation after transition
            setTimeout(() => {
                this.isAnimating = false;
            }, 700);
        }
        
        next() {
            const nextIndex = (this.currentSlide + 1) % this.totalSlides;
            this.goTo(nextIndex);
        }
        
        prev() {
            const prevIndex = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
            this.goTo(prevIndex);
        }
        
        startAutoplay() {
            if (this.autoplayInterval) return;
            
            this.autoplayInterval = setInterval(() => {
                this.next();
            }, this.autoplayDelay);
        }
        
        pauseAutoplay() {
            if (this.autoplayInterval) {
                clearInterval(this.autoplayInterval);
                this.autoplayInterval = null;
            }
        }
        
        resetAutoplay() {
            this.pauseAutoplay();
            this.startAutoplay();
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const heroElements = document.querySelectorAll('[data-hero-carousel]');
        heroElements.forEach(element => {
            new ApexHeroCarousel(element);
        });
    });
    
    // Export for external use
    window.ApexHeroCarousel = ApexHeroCarousel;
})();
