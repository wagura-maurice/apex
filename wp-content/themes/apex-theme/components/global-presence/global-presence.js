/**
 * Global Presence Component JavaScript
 * Animations and interactions
 * 
 * @package ApexTheme
 * @subpackage Components/GlobalPresence
 */

(function() {
    'use strict';
    
    class ApexGlobalPresence {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-global-presence__header');
            this.regions = element.querySelector('.apex-global-presence__regions');
            this.hq = element.querySelector('.apex-global-presence__hq');
            
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
            
            if (this.header) observer.observe(this.header);
            if (this.regions) observer.observe(this.regions);
            if (this.hq) observer.observe(this.hq);
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-global-presence-section]');
        sections.forEach(section => {
            new ApexGlobalPresence(section);
        });
    });
    
    window.ApexGlobalPresence = ApexGlobalPresence;
})();
