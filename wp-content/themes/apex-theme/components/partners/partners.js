/**
 * Partners Component JavaScript
 * Logo grid animations
 * 
 * @package ApexTheme
 * @subpackage Components/Partners
 */

(function() {
    'use strict';
    
    class ApexPartners {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-partners__header');
            this.grid = element.querySelector('.apex-partners__grid');
            this.items = element.querySelectorAll('.apex-partners__item');
            this.ctaWrapper = element.querySelector('.apex-partners__cta-wrapper');
            
            this.init();
        }
        
        init() {
            this.setupIntersectionObserver();
            this.setupItemAnimations();
        }
        
        setupIntersectionObserver() {
            const options = {
                root: null,
                rootMargin: '-50px',
                threshold: 0.2
            };
            
            // Observer for header
            const headerObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        headerObserver.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.header) {
                headerObserver.observe(this.header);
            }
            
            // Observer for grid
            const gridObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        this.animateItems();
                        gridObserver.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.grid) {
                gridObserver.observe(this.grid);
            }
            
            // Observer for CTA
            const ctaObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        ctaObserver.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.ctaWrapper) {
                ctaObserver.observe(this.ctaWrapper);
            }
        }
        
        setupItemAnimations() {
            this.items.forEach(item => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                item.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
            });
        }
        
        animateItems() {
            this.items.forEach((item, index) => {
                const delay = parseInt(item.dataset.delay) || index * 50;
                setTimeout(() => {
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, delay);
            });
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-partners-section]');
        sections.forEach(section => {
            new ApexPartners(section);
        });
    });
    
    window.ApexPartners = ApexPartners;
})();
