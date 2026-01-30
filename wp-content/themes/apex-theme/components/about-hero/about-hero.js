/**
 * About Hero Component JavaScript
 * Animations and interactions
 * 
 * @package ApexTheme
 * @subpackage Components/AboutHero
 */

(function() {
    'use strict';
    
    class ApexAboutHero {
        constructor(element) {
            this.section = element;
            this.content = element.querySelector('.apex-about-hero__content');
            this.imageWrapper = element.querySelector('.apex-about-hero__image-wrapper');
            
            this.init();
        }
        
        init() {
            this.setupIntersectionObserver();
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
                        entry.target.classList.add('is-visible');
                        observer.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.content) observer.observe(this.content);
            if (this.imageWrapper) observer.observe(this.imageWrapper);
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-about-hero-section]');
        sections.forEach(section => {
            new ApexAboutHero(section);
        });
    });
    
    window.ApexAboutHero = ApexAboutHero;
})();
