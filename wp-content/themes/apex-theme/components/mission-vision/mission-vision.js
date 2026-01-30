/**
 * Mission & Vision Component JavaScript
 * Animations and interactions
 * 
 * @package ApexTheme
 * @subpackage Components/MissionVision
 */

(function() {
    'use strict';
    
    class ApexMissionVision {
        constructor(element) {
            this.section = element;
            this.cards = element.querySelector('.apex-mission-vision__cards');
            this.valuesHeading = element.querySelector('.apex-mission-vision__values-heading');
            this.values = element.querySelectorAll('.apex-mission-vision__value');
            
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
                        const delay = entry.target.dataset.delay || 0;
                        setTimeout(() => {
                            entry.target.classList.add('is-visible');
                        }, delay);
                        observer.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.cards) observer.observe(this.cards);
            if (this.valuesHeading) observer.observe(this.valuesHeading);
            this.values.forEach(value => observer.observe(value));
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-mission-vision-section]');
        sections.forEach(section => {
            new ApexMissionVision(section);
        });
    });
    
    window.ApexMissionVision = ApexMissionVision;
})();
