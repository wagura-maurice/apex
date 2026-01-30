/**
 * Compliance Component JavaScript
 * Animations
 * 
 * @package ApexTheme
 * @subpackage Components/Compliance
 */

(function() {
    'use strict';
    
    class ApexCompliance {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-compliance__header');
            this.certifications = element.querySelector('.apex-compliance__certifications');
            this.features = element.querySelector('.apex-compliance__features');
            this.cta = element.querySelector('.apex-compliance__cta');
            
            this.init();
        }
        
        init() {
            this.setupIntersectionObserver();
        }
        
        setupIntersectionObserver() {
            const options = {
                root: null,
                rootMargin: '-50px',
                threshold: 0.1
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
            if (this.certifications) observer.observe(this.certifications);
            if (this.features) observer.observe(this.features);
            if (this.cta) observer.observe(this.cta);
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-compliance-section]');
        sections.forEach(section => {
            new ApexCompliance(section);
        });
    });
    
    window.ApexCompliance = ApexCompliance;
})();
