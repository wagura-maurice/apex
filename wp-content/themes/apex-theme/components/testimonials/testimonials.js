/**
 * Testimonials Component JavaScript
 * Carousel functionality
 * 
 * @package ApexTheme
 * @subpackage Components/Testimonials
 */

(function() {
    'use strict';
    
    class ApexTestimonials {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-testimonials__header');
            this.carousel = element.querySelector('[data-testimonials-carousel]');
            this.slides = element.querySelectorAll('.apex-testimonials__slide');
            this.indicators = element.querySelectorAll('.apex-testimonials__indicator');
            this.prevBtn = element.querySelector('[data-testimonials-prev]');
            this.nextBtn = element.querySelector('[data-testimonials-next]');
            
            this.currentSlide = 0;
            this.totalSlides = this.slides.length;
            this.autoplayInterval = null;
            this.autoplayDelay = 7000;
            this.isAnimating = false;
            
            this.init();
        }
        
        init() {
            this.setupIntersectionObserver();
            this.bindEvents();
            this.startAutoplay();
        }
        
        setupIntersectionObserver() {
            const options = {
                root: null,
                rootMargin: '-50px',
                threshold: 0.2
            };
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        if (this.header) {
                            this.header.classList.add('is-visible');
                        }
                        observer.unobserve(entry.target);
                    }
                });
            }, options);
            
            observer.observe(this.section);
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
            
            // Pause on hover
            if (this.carousel) {
                this.carousel.addEventListener('mouseenter', () => this.pauseAutoplay());
                this.carousel.addEventListener('mouseleave', () => this.startAutoplay());
            }
            
            // Touch events
            this.setupTouchEvents();
        }
        
        setupTouchEvents() {
            if (!this.carousel) return;
            
            let touchStartX = 0;
            let touchEndX = 0;
            
            this.carousel.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, { passive: true });
            
            this.carousel.addEventListener('touchend', (e) => {
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
            const direction = index > this.currentSlide ? 1 : -1;
            
            // Update slides
            this.slides.forEach((slide, i) => {
                slide.classList.remove('is-active', 'is-prev');
                if (i === index) {
                    slide.classList.add('is-active');
                } else if (i === this.currentSlide && direction > 0) {
                    slide.classList.add('is-prev');
                }
            });
            
            // Update indicators
            this.indicators.forEach((indicator, i) => {
                indicator.classList.toggle('is-active', i === index);
            });
            
            this.currentSlide = index;
            this.resetAutoplay();
            
            setTimeout(() => {
                this.isAnimating = false;
            }, 600);
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
        const sections = document.querySelectorAll('[data-testimonials-section]');
        sections.forEach(section => {
            new ApexTestimonials(section);
        });
    });
    
    window.ApexTestimonials = ApexTestimonials;
})();
