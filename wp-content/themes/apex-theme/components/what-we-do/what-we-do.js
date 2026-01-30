/**
 * What We Do Component JavaScript
 * Card animations and interactions
 * 
 * @package ApexTheme
 * @subpackage Components/WhatWeDo
 */

(function() {
    'use strict';
    
    class ApexWhatWeDo {
        constructor(element) {
            this.section = element;
            this.header = element.querySelector('.apex-what-we-do__header');
            this.cards = element.querySelectorAll('.apex-what-we-do__card');
            this.ctaWrapper = element.querySelector('.apex-what-we-do__cta-wrapper');
            
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
    }
    
    // Initialize on DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        const sections = document.querySelectorAll('.apex-what-we-do');
        sections.forEach(section => {
            new ApexWhatWeDo(section);
        });
    });
    
    window.ApexWhatWeDo = ApexWhatWeDo;
})();
