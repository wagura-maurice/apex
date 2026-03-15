/**
 * Case Studies Component JavaScript
 * Animations and interactions
 * 
 * @package ApexTheme
 * @subpackage Components/CaseStudies
 */

(function() {
    'use strict';
    
    class ApexCaseStudies {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-case-studies__header');
            this.featured = element.querySelector('.apex-case-studies__featured');
            this.cards = element.querySelectorAll('.apex-case-studies__card');
            this.cta = element.querySelector('.apex-case-studies__cta');
            
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
            if (this.featured) observer.observe(this.featured);
            if (this.cta) observer.observe(this.cta);
            
            // Cards with stagger
            const cardObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const delay = parseInt(entry.target.dataset.delay) || 0;
                        setTimeout(() => {
                            entry.target.classList.add('is-visible');
                        }, delay);
                        cardObserver.unobserve(entry.target);
                    }
                });
            }, { ...options, threshold: 0.2 });
            
            this.cards.forEach(card => {
                cardObserver.observe(card);
            });
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-case-studies-section]');
        sections.forEach(section => {
            new ApexCaseStudies(section);
        });
    });
    
    window.ApexCaseStudies = ApexCaseStudies;
})();
