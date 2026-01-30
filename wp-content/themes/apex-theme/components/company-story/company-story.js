/**
 * Company Story Component JavaScript
 * Animations and interactions
 * 
 * @package ApexTheme
 * @subpackage Components/CompanyStory
 */

(function() {
    'use strict';
    
    class ApexCompanyStory {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-company-story__header');
            this.content = element.querySelector('.apex-company-story__content');
            this.timeline = element.querySelector('.apex-company-story__timeline');
            
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
            if (this.content) observer.observe(this.content);
            if (this.timeline) observer.observe(this.timeline);
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-company-story-section]');
        sections.forEach(section => {
            new ApexCompanyStory(section);
        });
    });
    
    window.ApexCompanyStory = ApexCompanyStory;
})();
