/**
 * What's New Component JavaScript
 * Post card animations
 * 
 * @package ApexTheme
 * @subpackage Components/WhatsNew
 */

(function() {
    'use strict';
    
    class ApexWhatsNew {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-whats-new__header');
            this.cards = element.querySelectorAll('.apex-whats-new__card');
            this.mobileCta = element.querySelector('.apex-whats-new__mobile-cta');
            
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
            
            // Observer for cards with stagger
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
            
            // Observer for mobile CTA
            const ctaObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('is-visible');
                        ctaObserver.unobserve(entry.target);
                    }
                });
            }, options);
            
            if (this.mobileCta) {
                ctaObserver.observe(this.mobileCta);
            }
        }
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('[data-whats-new-section]');
        sections.forEach(section => {
            new ApexWhatsNew(section);
        });
    });
    
    window.ApexWhatsNew = ApexWhatsNew;
})();
