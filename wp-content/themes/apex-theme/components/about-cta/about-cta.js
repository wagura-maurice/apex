/**
 * About CTA Component JavaScript
 * Animations and interactions
 * 
 * @package ApexTheme
 * @subpackage Components/AboutCTA
 */

(function() {
    'use strict';
    
    class ApexAboutCTA {
        constructor(element) {
            this.section = element;
            this.container = element.querySelector('.apex-about-cta__container');
            
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
            
            if (this.container) observer.observe(this.container);
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-about-cta-section]');
        sections.forEach(section => {
            new ApexAboutCTA(section);
        });
    });
    
    window.ApexAboutCTA = ApexAboutCTA;
})();
